<?php

namespace App\Http\Controllers\Casher;

use App\Http\Controllers\Controller;
use App\Models\Foodinvoice;
use App\Models\Foods;
use App\Models\Invoice;
use App\Models\Table;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Barryvdh\Snappy\Facades\SnappyPdf;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Spatie\Browsershot\Browsershot;

class CasherReportController extends Controller
{

    public function index(Request $request)
{
   // Invoices Report
$invoices = Invoice::with(['table', 'creator'])
    ->when($request->filled('start_date'), fn($q) => $q->whereDate('created_at', '>=', $request->start_date))
    ->when($request->filled('end_date'), fn($q) => $q->whereDate('created_at', '<=', $request->end_date))
    ->when($request->filled('cashier_id'), fn($q) => $q->where('created_by_server', $request->cashier_id))
    ->when($request->filled('table_id'), fn($q) => $q->where('table_id', $request->table_id))
    ->orderBy('created_at', 'desc')
    ->paginate(20);

// Ordered Foods Report
$orderedFoods = Foodinvoice::with(['food', 'invoice'])
    ->when($request->filled('start_date'), fn($q) => $q->whereDate('created_at', '>=', $request->start_date))
    ->when($request->filled('end_date'), fn($q) => $q->whereDate('created_at', '<=', $request->end_date))
    ->when($request->filled('cashier_id'), fn($q) => $q->whereHas('invoice', fn($q2) => $q2->where('created_by_server', $request->cashier_id)))
    ->when($request->filled('table_id'), fn($q) => $q->whereHas('invoice', fn($q2) => $q2->where('table_id', $request->table_id)))
    ->orderBy('created_at', 'desc')
    ->paginate(20);

// Grouped Foods
$groupedFoods = \App\Models\Foodinvoice::selectRaw('
        DATE(created_at) as date,
        food_id,
        SUM(quantity) as total_quantity,
        SUM(quantity * price) as total_revenue
    ')
    ->when($request->filled('start_date'), fn($q) => $q->whereDate('created_at', '>=', $request->start_date))
    ->when($request->filled('end_date'), fn($q) => $q->whereDate('created_at', '<=', $request->end_date))
    ->when($request->filled('cashier_id'), fn($q) => $q->whereHas('invoice', fn($q2) => $q2->where('created_by_server', $request->cashier_id)))
    ->when($request->filled('table_id'), fn($q) => $q->whereHas('invoice', fn($q2) => $q2->where('table_id', $request->table_id)))
    ->groupBy(DB::raw('DATE(created_at)'), 'food_id')
    ->orderByDesc('total_quantity')
    ->get()
    ->map(function ($row) {
        $row->food = \App\Models\Foods::find($row->food_id);
        return $row;
    });
    
    // Paginate manually (since it's a collection)
    $page = request('foods_page', 1);
    $perPage = 15;
    $groupedFoodsPaginated = new \Illuminate\Pagination\LengthAwarePaginator(
        $groupedFoods->forPage($page, $perPage),
        $groupedFoods->count(),
        $perPage,
        $page,
        ['pageName' => 'foods_page']
    );   

    $tables = Table::all();

    $totalSales = $invoices->sum('total_price');
    $totalInvoices = $invoices->count();
    $unpaidInvoices = $invoices->where('status', 1)->count();
    $cashiers = User::whereHas('invoices')->get(); // Only cashiers with invoices
    return view('casher.reports', compact(
        'invoices',
        'orderedFoods',
        'tables',
        'totalSales',
        'totalInvoices',
        'unpaidInvoices',
        'groupedFoodsPaginated',
            'cashiers'

    ));
}
//Report Sections
   public function report(Request $request)
{
    $query = Invoice::with(['server', 'table']);

    // Use start_date and end_date for consistency with your filter form
    if ($request->filled('start_date') && $request->filled('end_date')) {
        $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
    }

    if ($request->filled('cashier_id')) {
        $query->where('created_by_server', $request->cashier_id);
    }

    if ($request->filled('table_number')) {
        $query->whereHas('table', function ($q) use ($request) {
            $q->where('table_number', $request->table_number);
        });
    }

    $invoices = $query->latest()->paginate(10);
    $invoices->appends($request->query());

    $totalSales = $invoices->where('status', 2)->sum('total_price');
    $totalInvoices = $invoices->count();
    $unpaidInvoices = $invoices->where('status', 1)->count();

    $cashiers = User::whereHas('invoices', function($q){
        $q->where('status', 2);
    })->get();

    $tables = Table::all();

    // Foods grouping (use start_date/end_date for consistency)
    $groupedFoods = DB::table('foodinvoices')
        ->selectRaw('
            DATE(foodinvoices.created_at) as date,
            food_id,
            SUM(quantity) as total_quantity,
            SUM(foodinvoices.quantity * foodinvoices.price) as total_revenue
        ')
        ->join('foods', 'foodinvoices.food_id', '=', 'foods.id')
        ->join('invoices', 'foodinvoices.invoice_id', '=', 'invoices.id')
        ->when($request->filled('start_date') && $request->filled('end_date'), function ($query) use ($request) {
            $query->whereBetween('foodinvoices.created_at', [$request->start_date, $request->end_date]);
        })
        ->when($request->filled('cashier_id'), function ($query) use ($request) {
            $query->where('invoices.created_by_server', $request->cashier_id);
        })
        ->when($request->filled('table_number'), function ($query) use ($request) {
            $query->whereHas('invoices.table', function ($q) use ($request) {
                $q->where('table_number', $request->table_number);
            });
        })
        ->groupBy(DB::raw('DATE(foodinvoices.created_at)'), 'food_id')
        ->orderByDesc('total_quantity')
        ->get()
        ->map(function ($row) {
            $row->food = Foods::find($row->food_id);
            return $row;
        });

    $page = $request->get('foods_page', 1);
    $perPage = 10;

    $groupedFoodsPaginated = new LengthAwarePaginator(
        $groupedFoods->forPage($page, $perPage),
        $groupedFoods->count(),
        $perPage,
        $page,
        ['pageName' => 'foods_page']
    );

    $groupedFoodsPaginated->appends($request->except('foods_page'))->withPath($request->url());

    return view('casher.reports', compact(
        'invoices',
        'totalSales',
        'totalInvoices',
        'unpaidInvoices',
        'cashiers',
        'tables',
        'groupedFoodsPaginated'
    ));
}


public function exportInvoicesReport(Request $request)
{
   $query = Invoice::query()->with(['table', 'creator']);

    if ($request->filled('start_date')) {
        $query->whereDate('created_at', '>=', $request->start_date);
    }
    if ($request->filled('end_date')) {
        $query->whereDate('created_at', '<=', $request->end_date);
    }
    if ($request->filled('cashier_id')) {
    $query->where('created_by_server', $request->cashier_id);
    $cashier = User::find($request->cashier_id);
    $cashierName = $cashier ? $cashier->username : 'N/A';
} else {
    $cashierName = 'All';
}
    // if ($request->filled('table_id')) {
    //     $query->where('table_id', $request->table_id);
    //     $table = Table::find($request->table_id);
    //     $tableNumber = $table ? $table->table_number : 'N/A';
    // } else {
    //     $tableNumber = 'All';
    // }

    $invoices = $query->get();

    $totalSales = $invoices->sum('total_price');
    $unpaidCount = $invoices->where('status', 1)->count();
    
    
  $cashierName = $request->filled('cashier_id')
        ? optional(User::find($request->cashier_id))->username
        : 'All';

    $html = view('casher.exports.invoices_report', [
        'invoices' => $invoices,
        'from' => $request->start_date,
        'to' => $request->end_date,
        'cashierName' => $cashierName,
        'totalSales' => $totalSales,
        'unpaidCount' => $unpaidCount,
    ])->render();

    return response()->streamDownload(function () use ($html) {
        echo Browsershot::html($html)
            ->format('A4')
            ->margins(10, 10, 10, 10)
            ->showBackground()
            ->pdf();
    }, 'invoices_report.pdf');


}
public function exportOrderedFoodsPdf(Request $request)
{
    // Validate request parameters
    $from = $request->input('start_date');
    $to = $request->input('end_date');
    $cashierId = $request->input('cashier_id');
    $tableId = $request->input('table_id');

    // Get cashier and table names
    $cashierName = $cashierId ? optional(User::find($cashierId))->username : 'All';
    $tableNumber = $tableId ? optional(Table::find($tableId))->table_number : 'All';

    // Build the query for invoices
    $query = Invoice::with(['creator', 'table', 'foodItems.food'])
        ->when($from && $to, fn($q) => $q->whereBetween('created_at', [$from, $to]))
        ->when($cashierId, fn($q) => $q->where('created_by_server', $cashierId))
        ->when($tableId, fn($q) => $q->where('table_id', $tableId));

    $invoices = $query->orderByDesc('created_at')->get();

    // Group and summarize ordered foods
    $foods = Foodinvoice::selectRaw('
        DATE(created_at) as date,
        food_id,
        SUM(quantity) as total_quantity,
        SUM(quantity * price) as total_revenue
    ')
        ->when($from, fn($q) => $q->whereDate('created_at', '>=', $from))
        ->when($to, fn($q) => $q->whereDate('created_at', '<=', $to))
        ->when($cashierId, fn($q) => $q->whereHas('invoice', fn($q2) => $q2->where('created_by_server', $cashierId)))
        ->when($tableId, fn($q) => $q->whereHas('invoice', fn($q2) => $q2->where('table_id', $tableId)))
        ->groupBy(DB::raw('DATE(created_at)'), 'food_id')
        ->orderByDesc('total_quantity')
        ->get()
        ->map(function ($row) {
            $row->food = Foods::find($row->food_id);
            return $row;
        });

    $totalQuantity = $foods->sum('total_quantity');
    $totalRevenue = $foods->sum('total_revenue');

    // Render Blade view to HTML
    $html = view('casher.exports.ordered_foods_report', [
        'foods' => $foods,
        'from' => $from,
        'to' => $to,
        'totalQuantity' => $totalQuantity,
        'cashierName' => $cashierName,
        'tableNumber' => $tableNumber,
        'totalRevenue' => $totalRevenue,
    ])->render();

    // Generate PDF using Browsershot (A4, RTL, Kurdish font support)
    return response()->streamDownload(function () use ($html) {
        echo Browsershot::html($html)
            ->format('A4')
            ->margins(10, 10, 10, 10)
            ->showBackground()
            ->pdf();
    }, 'ordered_foods_report.pdf');
}

}
/* public function exportOrderedFoodsPdf(Request $request)
    {
        // Validate request parameters
        $from = $request->input('start_date');
        $to = $request->input('end_date');
        $cashierId = $request->input('cashier_id');
        $tableId = $request->input('table_id');
        // Get cashier and table names
        $cashierName = $cashierId ? optional(\App\Models\User::find($cashierId))->username : 'All';
        $tableNumber = $tableId ? optional(\App\Models\Table::find($tableId))->table_number : 'All';
        // Build the query for invoices
        $query = Invoice::with(['creator', 'table', 'foodItems.food'])
            ->when($from && $to, fn($q) => $q->whereBetween('created_at', [$from, $to]))
            ->when($cashierId, fn($q) => $q->where('created_by_server', $cashierId))
            ->when($tableId, fn($q) => $q->where('table_id', $tableId));

        $invoices = $query->orderByDesc('created_at')->get();

        // Group and summarize ordered foods
        $foods = \App\Models\Foodinvoice::selectRaw('
        DATE(created_at) as date,
        food_id,
        SUM(quantity) as total_quantity,
        SUM(quantity * price) as total_revenue
    ')
            ->when($from, fn($q) => $q->whereDate('created_at', '>=', $from))
            ->when($to, fn($q) => $q->whereDate('created_at', '<=', $to))
            ->when($cashierId, fn($q) => $q->whereHas('invoice', fn($q2) => $q2->where('created_by_server', $cashierId)))
            ->when($tableId, fn($q) => $q->whereHas('invoice', fn($q2) => $q2->where('table_id', $tableId)))
            ->groupBy(DB::raw('DATE(created_at)'), 'food_id')
            ->orderByDesc('total_quantity')
            ->get()
            ->map(function ($row) {
                $row->food = \App\Models\Foods::find($row->food_id);
                return $row;
            });
        $totalSales = $invoices->sum('total_price');
        $unpaidCount = $invoices->where('status', 1)->count();
        $totalQuantity = $foods->sum('total_quantity');
        $totalRevenue = $foods->sum('total_revenue');

        $html = view('casher.reports.exports.ordered_foods', [
            'invoices' => $invoices,
            'from' => $request->start_date,
            'to' => $request->end_date,
            'cashierName' => $cashierName,
            'totalSales' => $totalSales,
            'totalQuantity' => $totalQuantity,
            'tableNumber' => $tableNumber,

            'unpaidCount' => $unpaidCount,
            'totalRevenue' => $totalRevenue,


        ])->render();

        return response()->streamDownload(function () use ($html) {
            echo Browsershot::html($html)
                ->format('A4')
                ->margins(10, 10, 10, 10)
                ->showBackground()
                ->pdf();
        }, 'orders_foods_report.pdf');
    } */