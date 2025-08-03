<?php

namespace App\Http\Controllers\Casher;
use Barryvdh\DomPDF\Facade\Pdf;

use App\Http\Controllers\Controller;
use App\Jobs\ClearTableInvoiceAfterPayment;
use App\Models\Category;
use App\Models\Foodinvoice;
use App\Models\Foods;
use App\Models\Invoice;
use App\Models\Table;
use App\Models\User;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session as FacadesSession;
use Symfony\Component\HttpFoundation\Session\Session as SessionSession;
use Yajra\DataTables\Facades\DataTables;

class CasherInvoiceController extends Controller
{

     public function index(Request $request)
      {
        // Only return JSON if DataTables requests it
        if ($request->ajax()) {
            $data = Invoice::with(['table', 'user', 'creator']) // user = customer, creator = server
                ->when($request->filled('date_from') && $request->filled('date_to'), function ($query) use ($request) {
                    $query->whereBetween('created_at', [$request->date_from, $request->date_to]);
                })
                ->when($request->filled('cashier_id'), function ($query) use ($request) {
                    $query->where('created_by_server', $request->cashier_id);
                })
                ->when($request->filled('table_id'), function ($query) use ($request) {
                    $query->where('table_id', $request->table_id);
                })
                ->when($request->filled('status'), function ($query) use ($request) {
                    $query->where('status', $request->status);
                })
                ->latest();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('table_number', fn($row) => $row->table?->number ?? 'N/A')
                ->addColumn('customer', fn($row) => $row->user?->name ?? 'N/A')
                ->addColumn('server', fn($row) => $row->creator?->name ?? 'N/A')
                ->addColumn('total_price', fn($row) => number_format($row->total_price, 2))
                ->addColumn('status_text', function ($row) {
                    return match ($row->status) {
                        1 => 'Ordered',
                        2 => 'Paid',
                        3 => 'Cancelled',
                        default => 'Unknown',
                    };
                })
                ->addColumn('created_at', fn($row) => $row->created_at->format('Y-m-d H:i'))
                ->rawColumns(['status_text'])
                ->make(true);
        }

        // Fetch tables and cashiers for the filters
        $tables = Table::all();

        $cashiers = User::whereHas('invoices', function ($q) {
            $q->where('status', 2);
        })->get();

    return redirect()->route('casher.home')->with('success', 'Invoice paid successfully.');
    }


    public function show($id)
    {
        $invoice = Invoice::with([
            'creator',
            'table',
            'invoice_food.food.sub_category'
        ])->findOrFail($id);

        return view('casher.invoice', compact('invoice'));
    }

 // Process payment for the invoice
   public function payInvoice($id)
{
    $invoice = Invoice::with('table')->findOrFail($id);

    if ($invoice->status != 1) {
        return back()->with('error', 'Invoice already paid or invalid.');
    }

    $invoice->status = 2; // mark as paid
    $invoice->paid_by = auth()->id(); // store who paid
    $invoice->save();

    if ($invoice->table) {
        $invoice->table->status = 'available';
        $invoice->table->save();
    }

    return redirect()->route('casher.home')->with('success', 'Invoice paid successfully.');
}



public function markAsPaid($invoice_id)
{
    $invoice = Invoice::findOrFail($invoice_id);

    // Only update if the current status is Arrived (1)
    if ($invoice->status == 1) {
        $invoice->status = 2; // Change status to 'Paid'
        $invoice->save();
    }

    return redirect()->back()->with('status', 'Invoice marked as Paid!');
}




}

