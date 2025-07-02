<?php

namespace App\Http\Controllers\Casher;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\SubCategory;
use App\Models\Table;
use Illuminate\Http\Request;

class CasherTableController extends Controller
{
   
    public function index()
{
    $tables = Table::with(['invoice' => function($query) {
        $query->where('status', 0); // Only unpaid invoices
    }, 'invoices.invoice_food'])->get();

    $tables->each(function ($table) {
        if ($table->invoice) {
            $table->total_price = $table->invoice->invoice_food->sum(function ($item) {
                return $item->quantity * $item->price;
            });
        } else {
            $table->total_price = 0;
        }
    });

    return view('casher.home', compact('tables'));
}

}
