<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReservationRequest;
use App\Models\Reservation;
use App\Models\Table;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ReservationController extends Controller
{

   public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Reservation::query()->latest()->with('user'); // Include 'user' relation

            // Return the data to DataTables
            return DataTables::of($data)
                ->addColumn('created_at_readable', function($row) {
                    return $row->created_at->format('Y-m-d H:i:s');
                })
                ->addColumn('user_name', function($row) {
                    return $row->user ? $row->user->name : 'N/A'; // Return 'N/A' if no user found
                })
                 ->addColumn('table_number', function ($row) {
                return $row->table ? 'Table No. ' . $row->table->table_number : 'N/A'; // Render table number
            })
                ->addIndexColumn() // Add index column for DataTables
                ->make(true);
        }

        return view('admin.reservations.index');
    }
  
  public function create()
    {
     $tables =Table::where('status', 'available')->get();
    return view('admin.reservations.form', compact('tables'));
    }
  
   
    // Show Individual Reservation
    public function show(Request $request, $id)
    {
        $data = Reservation::findOrFail($id);
        return view('admin.reservation.show', compact('data'));
    }
     // Store the reservation data
    public function store(ReservationRequest $request)
{
       // Your logic to store reservation here
        $new_data = $request->all();
        auth()->user()->reservations()->create($new_data);


    // Update the table status to reserved
    $table = Table::find($request->table_id);
    if ($table) {
        $table->status = 'reserved'; // Set the table status to 'reserved'
        $table->save();
    }

    return redirect()->back()->with(['message' => 'Reservation created successfully!']);
}
    
    public function edit(string $id)
    {
      $data = Reservation::findOrFail($id);
    $tables = \App\Models\Table::get(); // allow pick any for edit
    return view('admin.reservations.form', compact('data', 'tables'));
    }

    public function update(ReservationRequest $request, string $id)
{
    $reservation = Reservation::findOrFail($id);
    $reservation->update($request->validated()); // This will update the reservation

    return redirect()->back()->with('message', 'Reservation updated successfully!');
}

    public function destroy(string $id)
{
    // Find the reservation by ID
    $reservation = Reservation::findOrFail($id);
    
    // If reservation exists, delete it
    $reservation->delete();
    
    // Optional: Update the table status to 'available' when the reservation is deleted
    $table = Table::find($reservation->table_id);
    if ($table) {
        $table->status = 'available'; // Or whatever the default status is
        $table->save();
    }

    // Return success message
    return redirect()->back()->with('message', 'Reservation deleted successfully!');
}
}
