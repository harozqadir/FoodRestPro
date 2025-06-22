<?php

namespace App\Http\Controllers\Casher;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Table;
use Illuminate\Http\Request;

class CasherController extends Controller
{
    public function index(){
        $tables = Table::all();
        // You can pass the tables to the view if needed
        return view('casher.home',compact('tables'));
    }
    
    public function deleteInvoice($id){
        Invoice::findOrFail($id)->delete();
        return redirect () ->route('casher.home');
    }
}
