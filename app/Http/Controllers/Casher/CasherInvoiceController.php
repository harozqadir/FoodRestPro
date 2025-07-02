<?php

namespace App\Http\Controllers\Casher;

use App\Http\Controllers\Controller;
use App\Jobs\ClearTableInvoiceAfterPayment;
use App\Models\Invoice;
use App\Models\Table;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;


class CasherInvoiceController extends Controller
{
    public function show($id)
{
    {
        $table = Table::with(['invoices.invoice_food'])->findOrFail($id);
    
        // Use the total_price from the invoice directly
        $finalTotalPrice = $table->invoice ? $table->invoice->total_price : 0;
    
        return view('casher.invoice', compact('table', 'finalTotalPrice'));
    }}

public function processPayment($id)
{
    $table = Table::with(['invoices'])->findOrFail($id);

    if (!$table->invoice) {
        return redirect()->back()->with('error', 'No invoice found for this table.');
    }

    $finalTotalPrice = $table->invoice->total_price;

    $table->invoice->update([
        'status' => 1, // Paid
        'paid_at' => now(),
        'user_id' => auth()->user()->id, // casher's user_id
]);
    

    
        $table->update([
            'status' => 'available'
        ]);    

    

    return redirect()->route('casher.tables.invoice', ['id' => $table->id])
        ->with('success', "Payment of {$finalTotalPrice} IQD processed for Table #{$table->table_number}");
}
public function report(Request $request)
{
    $query = Invoice::with(['table', 'creator', 'casher']); // if you have casher too    // Optional: Filtering
    if ($request->filled('from')) {
        $query->whereDate('created_at', '>=', $request->from);
    }
    if ($request->filled('to')) {
        $query->whereDate('created_at', '<=', $request->to);
    }
    if ($request->filled('casher_id')) {
        $query->where('casher_id', $request->casher_id);
    }

    $cashers = User::where('role', 'casher')->get();

    // FIX: assign $invoices
    $invoices = $query->orderByDesc('created_at')->paginate(20);

    return view('casher.invoices_report', compact('invoices', 'cashers'));
}
}


