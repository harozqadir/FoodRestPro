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
        $query->where('status', 1); // Only unpaid invoices
    }, 'invoices.invoice_food'])->get();

  

    return view('casher.home', compact('tables'));
}
public function deleteInvoice($id)
    {
        // Find the invoice or fail if it doesn't exist
        $invoice = Invoice::findOrFail($id);

        // Get the table related to this invoice
        $table = $invoice->table; 

        // Delete the invoice
        $invoice->delete();

        // Update the table status to 'available'
        if ($table) {
            $table->status = 'available';
            $table->save();
        }

        // Redirect back to the server home route
        return redirect()->route('server.home');
    }

}
