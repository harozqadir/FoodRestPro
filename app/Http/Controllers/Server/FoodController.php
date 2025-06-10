<?php

namespace App\Http\Controllers\Server;

use App\Http\Controllers\Controller;
use App\Models\Category;
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
    return view('server.foods',compact('table','categories','sub_categories'));
}

public function store(Request $request){

    
    
  if($request->total > 0){
    $new_invoice= auth()->user()->invoices()->create([
        'table_id' => $request->table_id,
        'total_price' => $request->total,
    ]);
    for($i=0; $i < count($request->food_id); $i++){
        if($request->quantity[$i] > 0){
        
        auth()->user()->invoice_foods()->create([
            'invoice_id' => $new_invoice->id,
            'food_id' => $request->food_id[$i],
            'quantity' => $request->quantity[$i],
            'price' => $request->price[$i],
            
        ]);
        }
}
      return redirect()->back();
  }
    
}
}