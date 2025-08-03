<?php
namespace App\Http\Controllers\Server;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Table;
use Illuminate\Http\Request;

class ServerTableController extends Controller
{
    public function index()
    {
        $tables = Table::all(); // Fetch all tables
        return view('server.home', compact('tables'));
    }

    // Method to delete an invoice
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
    public function home()
{
    $serverId = auth()->id();

    // Get distinct table IDs from invoices where created_by_server = current server, and invoice status is 'open' or 'ordered' (e.g. status = 1)
    $tableIds = Invoice::where('created_by_server', $serverId)
                ->where('status', 1)  // status 1 means order is open/unpaid
                ->distinct()
                ->pluck('table_id')
                ->toArray();

    // Fetch tables matching these IDs
    $tables = Table::whereIn('id', $tableIds)->get();

    return view('server.home', compact('tables'));
}

}
