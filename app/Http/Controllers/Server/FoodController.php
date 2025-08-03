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
use Illuminate\Support\Facades\Log;

class FoodController extends Controller
{

 
 public function index($id)
{
    // User ID of logged-in server
    $userId = auth()->id();

    // Validate the table ID
    $table = Table::findOrFail($id);

    // Fetch the categories and sub-categories
    $categories = Category::all();
    $sub_categories = SubCategory::with('foods')->get();

    // Get the latest invoice for the table with status 1 (open) assigned to this server
    $invoice = Invoice::where('table_id', $id)
        ->where('created_by_server', $userId)   // <-- filter by server here
        ->latest()
        ->with(['invoice_food' => function ($query) {
            $query->where('status', 1);  // Filter by foodinvoices status
        }, 'invoice_food.food.sub_category']) // Eager load related data
        ->first();

    // Pass the data to the view
    return view('server.foods', compact('table', 'categories', 'sub_categories', 'invoice'));

    }
    
public function store(Request $request)
{
    if ($request->total > 0) {
        $invoice = null;

        if ($request->invoice_id) {
            // Load existing invoice by ID
            $invoice = Invoice::with('invoice_food')->find($request->invoice_id);
        } else {
            // Check for an open invoice
            $invoice = Invoice::with('invoice_food')->where('table_id', $request->table_id)
                ->where('status', 1)
                ->latest()
                ->first();

            if (!$invoice) {
                $invoice = Invoice::create([
                    'table_id' => $request->table_id,
                    'created_by_server' => auth()->id(),
                    'total_price' => 0,
                    'status' => 1, // unpaid
                ]);

                $invoice->load('invoice_food');
            }
        }

        // Force status to 1 (unpaid) in case it's something else
        if ($invoice->status != 1) {
            $invoice->status = 1;
            $invoice->save();
        }

        $invoice_id = $invoice->id;

        // Add food items
        for ($i = 0; $i < count($request->food_id); $i++) {
            if ($request->quantity[$i] > 0) {
                auth()->user()->invoice_food()->create([
                    'invoice_id' => $invoice_id,
                    'food_id'    => $request->food_id[$i],
                    'quantity'   => $request->quantity[$i],
                    'price'      => $request->price[$i],
                ]);
            }
        }

        // Recalculate total_price using Eloquent
        $invoice->load('invoice_food');
        $total = $invoice->invoice_food->sum(function ($item) {
            return $item->quantity * $item->price;
        });

        $invoice->total_price = $total;
        $invoice->save();

        // Update table status
        $table = Table::find($request->table_id);
        $table->status = 'ordered';
        $table->save();

        return redirect()->route('server.foods', [
            'id' => $request->table_id,
            'invoice_id' => $invoice_id
        ]);
    }

    return redirect()->back();
}

public function plus_or_minus($id,$value)
   {

        // Find the food item in the invoice

    $invoice_food = Foodinvoice::findOrFail($id);
    $old_quantity = $invoice_food->quantity;
    $invoice_food->update([
        'quantity' => $old_quantity + $value,
    ]);

    // Calculate the price change
    $price_change = $invoice_food->price * $value;

    // Update the total price in the invoice
    $invoice = Invoice::find($invoice_food->invoice_id);
    $invoice->total_price += $price_change;
    $invoice->save();
    if($invoice_food->quantity == 0){
        $invoice_food->delete();
    }
    return redirect()->back();
   }




}