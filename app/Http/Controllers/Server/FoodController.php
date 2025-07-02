<?php

namespace App\Http\Controllers\Server;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Foodinvoice;
use App\Models\Foods;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\SubCategory;
use App\Models\Table;
use Illuminate\Http\Request;


class FoodController extends Controller
{

 
 public function index($id){
    

    // Validate the table ID
    $table=Table::findOrFail($id);

    $categories = Category::all();
    
    $sub_categories = SubCategory::with('foods')->get();

    // Get the latest invoice for the table with status 0 (open)
    $invoice= Invoice::where('table_id', $id)
    ->where('status', Invoice::STATUS_ORDERED)
    ->latest()    
    ->with('invoice_food.food.sub_category')// Eager load related data
    -> first();
   
    return view('server.foods',compact('table','categories','sub_categories','invoice',));
   }

public function store(Request $request)
{    
   auth()->user()->invoices()->create([
       
      'table-id' => $request->table_id,
    'created_by' => auth()->user()->name,
      'total' => $request->total,
      ''

   ]);     


}


     





public function plus_or_minus($id,$value)
   {
         // Find the food item in the invoice

    $invoice_food = Foodinvoice::findOrFail($id);
    $invoice_food->update([
        'quantity' => $invoice_food->quantity + $value,
        
    ]);
    if($invoice_food->quantity == 0){
        $invoice_food->delete();
    }
    return redirect()->back();
   }


}

