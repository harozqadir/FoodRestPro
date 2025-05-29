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
        $data = Reservation::latest()->where('table_id',$request->table_id)->with('user'); 
        return DataTables::of($data)->addIndexColumn()
            ->make(true);
        }
        $table = Table::findOrFail($request->table_id);
    return view('admin.reservations.index', compact('table'));
    
}

    
    public function create()
    {

        return view('admin.reservations.form');

    }

    
    public function store(ReservationRequest $request)
    {
        auth()->user()->reservations()->create($request->validated());
        return redirect()->back()->with(['message' => 'User Created Successfully'],);
        

   
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id)
    { 
        if ($request->ajax()) {

            $data = Reservation::latest()->where('table_id',$id)->with('user'); 
            return DataTables::of($data)->addIndexColumn()
                ->make(true);
            }
            
            $table = Table::findOrFail($id);
        return view('admin.reservations.index', compact('table'));
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = Reservation::findOrfail($id);

        return view('admin.reservations.form',compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ReservationRequest $request, string $id)
    {
        Reservation::findOrFail($id)->update($request->validated());
        return redirect()->back()->with(['message' => 'User updated successfully'],);

       }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Reservation::findOrFail($id)->delete();
        
        return redirect()->back()->with(['message' => 'User deleted successfully'],);
    }
}
