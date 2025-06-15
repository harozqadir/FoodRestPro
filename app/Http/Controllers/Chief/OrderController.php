<?php

namespace App\Http\Controllers\Chief;

use App\Http\Controllers\Controller;
use App\Models\Foodinvoice;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function  index()
    {
        $invoice_foods = Foodinvoice::where('status','<>',3)->with('food.sub_category')
        ->orderBy('status','asc')->get();
        return view('chief.home',compact('invoice_foods'));
    }

    public function update_state($id,$state){
        
        Foodinvoice::findOrfail($id)->update( [
            'status' => $state
        ]);
        return redirect()->back();
    }
}
