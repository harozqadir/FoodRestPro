<?php

namespace App\Http\Controllers\Server;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Foodinvoice;
use App\Models\Invoice;
use App\Models\SubCategory;
use App\Models\Table;
use Illuminate\Http\Request;


class FoodController extends Controller
{
/**
 * Display a listing of the resource.
 *
 * @param  int  $id
 * @return \Illuminate\Http\Response
 */

 
public function index($id){
    $table=Table::findOrFail($id);
    $categories = Category::all();
    // Eager load subcategories and their foods
    $sub_categories = SubCategory::with('foods')->get();
    // Get the latest invoice for the table with status 0 (open)
    $invoice= Invoice::where('table_id', $id)
    ->where('status', 0)
    ->latest()->with('invoice_food.food.sub_category')-> first();
   
    return view('server.foods',compact('table','categories','sub_categories','invoice'));
}

public function store(Request $request){
   

  if($request->total > 0){
    // Check if there is an existing open invoice for the table
    $check_for_invoice = Invoice::where('table_id', $request->table_id)
    ->where('status', 0)
    ->latest()
    ->first();
    $invoice_id = -1;
    if($check_for_invoice){
        // If an open invoice exists, update it
        $invoice_id = $check_for_invoice->id;
    }else{
        // If no open invoice exists, create a new one
      $new_invoice= auth()->user()->invoices()->create([
        'table_id' => $request->table_id,
        'total_price' => $request->total, 
        ]); 
        // Get the ID of the newly created invoice
        // This will be used to associate food items with this invoice
        $invoice_id = $new_invoice->id;
    }
    

    for($i=0; $i < count($request->food_id); $i++){
    // Check if the quantity is greater than 0 before creating the invoice_food record
    // This prevents creating records with zero quantity
    // This is important to avoid creating empty records in the invoice_food table
        if($request->quantity[$i] > 0){
        
        auth()->user()->invoice_food()->create([
            'invoice_id' => $invoice_id,
            'food_id' => $request->food_id[$i],
            'quantity' => $request->quantity[$i],
            'price' => $request->price[$i],
            
        ]);
        }
}
  }
  
          return redirect()->back();

}
public function plus_or_minus($id,$value){
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