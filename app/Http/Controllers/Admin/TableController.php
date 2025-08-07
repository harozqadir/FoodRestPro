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
        // Advanced search: one input, two columns
        if ($request->filled('custom_search')) {
            $search = $request->custom_search;
            $data->where(function($q) use ($search) {
                $q->where('table_number', 'like', "%{$search}%");
            });
        }
        return DataTables::of($data)
        ->addIndexColumn()
        ->editColumn('created_at', function ($row) {
                return $row->created_at->format('H:i:s - Y-m-d');
            })
             ->addColumn('creator_by', function ($row) {
                return $row->creator ? $row->creator->username : '—';
            })
            ->rawColumns(['creator_by'])
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
        return redirect()->back()->with(['message' => __('words.Table Created Successfully')]);
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
    $table = Table::findOrFail($id);
    $table->update([
        'table_number' => $request->input('table_number'),
    ]);
    return redirect()->back()->with(['message' => __('words.Table updated successfully')]);
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Table::findOrFail($id)->delete();

        return redirect()->back()->with(['message' => __('words.Table deleted successfully')]);
    }
}
