<?php 
namespace App\Http\Controllers\Chef;

use App\Http\Controllers\Controller;
use App\Models\Foodinvoice;
use App\Models\Invoice;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // Display all orders for the chef
    public function index()
    {
        // Only show food orders that are not yet delivered (exclude status = 3)
        $foodOrders = Foodinvoice::with('food.sub_category')
            ->where('status', '<>', 3) // Don't show delivered items
            ->orderBy('status', 'asc') // Show pending first
            ->get();

        // Get the latest invoice (optional, based on your business logic)
        $invoice = Invoice::latest()->first();

        return view('chef.home', compact('foodOrders', 'invoice'));
    }

    // Update food status (from Pending -> Done)
    public function updateStatus($id)
    {
        $foodInvoice = Foodinvoice::findOrFail($id);

        // Only allow status change from Pending (1) to Done (2)
        if ($foodInvoice->status == 1) {
            $foodInvoice->status = 2;
            $foodInvoice->save();

            return redirect()->back()->with('success', 'Order marked as done!');
        }

        return redirect()->back()->with('error', 'Status update not allowed!');
    }

    
}
