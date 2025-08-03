<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Foods;
use App\Models\SubCategory;
use App\Models\Table;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
{

$activeCount = Foods::where('is_active', true)->count();
$inactiveCount = Foods::where('is_active', false)->count();
$mostExpensive = Foods::orderByDesc('price')->first();
$cheapest = Foods::orderBy('price')->first();
$userCount = User::count();
$categoryCount=  Category::count();
$subcategoryCount = SubCategory::count();
$foodCount =Foods::count();
$availableTableCount = Table::where('status', 'Available')->count();
$sub_categories = SubCategory::all();

return view('admin.home', compact(
    
    'activeCount',
    'inactiveCount',
    'mostExpensive',
    'cheapest',
    'userCount' ,
    'categoryCount' ,
    'subcategoryCount',
    'foodCount',
    'availableTableCount',
    'sub_categories',
))->with([
    'mostExpensiveName' => optional($mostExpensive)->name_en,
    'mostExpensivePrice' => optional($mostExpensive)->price,
    'cheapestName' => optional($cheapest)->name_en,
    'cheapestPrice' => optional($cheapest)->price,
]);

     return view('admin.home', [
       
    ]);
}

public function showDashboard()
{
    $categories = Category::all(); // Get all categories (or your specific query)
    
    // Pass the categories variable to the view
    return view('admin.dashboard', compact('categories'));
}

   
}
