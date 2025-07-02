<?php

namespace App\Http\Controllers\Server;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Table;
use Illuminate\Http\Request;

class TableController extends Controller
{
    public function index()
    {
        // Retrieve all tables with their related invoices
        $tables = Table::with('invoices')->get();

        // Pass the tables data to the server.home view
        return view('server.home', compact('tables'));
    }

    public function deleteInvoice($id)
    {
        Invoice::findOrFail($id)->forceDelete();
        return redirect()->route('server.home');
    }


}
