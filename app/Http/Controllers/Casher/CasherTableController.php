<?php

namespace App\Http\Controllers\Casher;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Table;
use Illuminate\Http\Request;

class CasherTableController extends Controller
{
    /**
     * Display the Casher's dashboard with tables and their invoice statuses.
     */
    public function index()
    {
        // Fetch all tables with their invoices
        $tables = Table::with('invoice')->get();

        // Return the view for the Casher's home page
        return view('casher.home', compact('tables'));
    }

    /**
     * Display the invoice for a specific table.
     */
    public function invoice($id)
    {
        // Fetch the table and its invoice
        $table = Table::with('invoice.orders.food')->findOrFail($id);
        $invoice = $table->invoice;

        // Ensure the table has an invoice
        if (!$invoice) {
            return redirect()->route('casher.home')->with('error', 'No invoice found for this table.');
        }

        // Return the view for the table's invoice
        return view('casher.invoice', compact('table', 'invoice'));
    }

    public function removeOrder($id)
      {
    // Find the order and delete it
       $order = Order::findOrFail($id);
       $order->delete();

       // Recalculate the total price of the invoice
       $invoice = $order->invoice;
        $invoice->total_price = $invoice->orders->sum(function ($order) {
          return $order->price * $order->quantity;
          });
            $invoice->save();

          return redirect()->back()->with('success', 'Order removed successfully.');
    }
}
