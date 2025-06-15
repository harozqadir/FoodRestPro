<?php

namespace App\Http\Controllers\Server;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Table;
use Illuminate\Http\Request;

class TableController extends Controller
{
public function index(){
    $tables = Table::all();
    // You can pass the tables to the view if needed
    return view('server.home',compact('tables'));
}

public function deleteInvoice($id){
    Invoice::findOrFail($id)->delete();
    return redirect () ->route('server.home');
}


}
