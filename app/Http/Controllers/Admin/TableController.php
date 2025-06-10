<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TableRequest;
use App\Models\Table;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TableController extends Controller
{
   
    public function index(Request $request)
    {

      if ($request->ajax()) {
        $data = Table::latest()->with('user');         
        return DataTables::of($data)
        // WhereHas vs WhereRelation
        //WhereRelation
        // ->filter(function($q) use ($request){
        //     if($request->search['value'] != ''){
        //        $q->whereRelation('reservations','name','like','%'.$request->search['value'].'%');
         //WhereHas
        ->filter(function($q) use ($request){
            if($request->search['value'] != ''){
             $q->whereHas('reservations',function($query) use ($request){
                $query->where('name','like', '%'.$request->search['value'].'%')
                    ->orWhere('phone-number','like', '%'.$request->search['value'].'%')
                    
                ;
             });

            }
        
    
    })
        
        
        ->addIndexColumn()
            ->make(true);
        }
       return view('admin.tables.index');
    }

    
    public function create()
    {

        return view('admin.tables.form');

    }

    
    public function store(TableRequest $request)
    {
        auth()->user()->tables()->create($request->validated());
        return redirect()->back()->with(['message' => 'User Created Successfully'],);
        

   
    }

    
    public function edit(string $id)
    {
        $data = Table::findOrfail($id);

        return view('admin.tables.form',compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TableRequest $request, string $id)
    {
         Table::findOrFail($id)->update($request->validated());
        return redirect()->back()->with(['message' => 'User updated successfully'],);

       }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Table::findOrFail($id)->delete();
        
        return redirect()->back()->with(['message' => 'User deleted successfully'],);
    }
}
