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

 
public function index($tableId){

    $table=Table::findOrFail($tableId);
    
    // Get all categories and subcategories
    $categories = Category::all();
    $sub_categories = SubCategory::with('foods')->get();


    // Get the latest invoice for the table with status 0 (open)
    $invoice= Invoice::where('table_id', $tableId)
    ->where('status', 0)// Open invoice
    ->with('invoice_food.food.sub_category')// Eager load related data
    ->latest()
    -> first();
   
    return view('server.foods',compact('table','categories','sub_categories','invoice'));
}
public function store(Request $request, $tableId)
{

    // Validate the request
    $request->validate([
        'food_id' => 'required|array',
        'food_id.*' => 'exists:foods,id',
        'quantity' => 'required|array',
        'quantity.*' => 'integer|min:0',
        'price' => 'required|array',
        'price.*' => 'numeric|min:0',
    ]);

    // Check if at least one food item has a quantity greater than 0
    $hasOrder = false;
    foreach ($request->quantity as $quantity) {
        if ($quantity > 0) {
            $hasOrder = true;
            break;
        }
    }
    // If no food is selected, redirect back with an error message
    if (!$hasOrder) {
        return redirect()->back()->with('error', 'No food items were selected. Please select at least one food item.');
    }
    
     if($request->total> 0){
       $check_for_invoice = Invoice::where('table_id', $tableId)
        ->where('status', 0) // Open invoice
        ->latest()
        ->first();
        $invoice_id = -1;

        if($check_for_invoice){
            // If an open invoice exists, use its ID
            $invoice_id = $check_for_invoice->id;
        } else {
            // If no open invoice exists, create a new one
            $new_invoice = Invoice::create([
                'table_id' => $tableId,
                'total_price' => $request->total,
                'status' => 0, // Open invoice
            ]);
            $invoice_id = $new_invoice->id;
        }
        
     }
    // Initialize $check_for_invoice to null
    $check_for_invoice = null;
    
   

     for($i=0;$i<count($request->food_id);$i++){
        // Check if the quantity is greater than 0 before creating the invoice_food record
        // This prevents creating records with zero quantity
        if($request->quantity[$i] > 0){
            auth()->user()->invoice_food()->create([
                'invoice_id' => $invoice_id,
                'food_id' => $request->food_id[$i],
                'quantity' => $request->quantity[$i],
                'price' => $request->price[$i],
            ]);
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
