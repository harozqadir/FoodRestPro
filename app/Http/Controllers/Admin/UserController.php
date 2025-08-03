<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Contracts\DataTable;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
class UserController extends Controller
{
    
   public function index(Request $request)
{
    if ($request->ajax()) {
        $data = User::query()->latest()->with('user');
        return DataTables::of($data)->addIndexColumn()
       
            ->editColumn('created_at', function ($row) {
                return $row->created_at->format('Y-m-d');
            })
            ->addColumn('creator_by', function ($row) {
                return $row->creator ? $row->creator->username : '—';
            })
            ->rawColumns(['creator_by'])
            ->make(true);
    }

    return view('admin.users.index');
}


    
    public function create()
    {
        return view('admin.users.form');

    }
      
    
    public function store(UserRequest $request)
    {
        auth()->user()->users()->create($request->validated());
        return redirect()->back()->with(['message' => 'User created successfully'],);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = User::findOrfail($id);
        return view('admin.users.form',compact('data'));}

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, string $id)
    {
        if($request->password)
        User::findOrFail($id)->update($request->validated());
        else
        User::findOrFail($id)->update(Arr::except($request->validated(),['password']));

        return redirect()->back()->with(['message' => 'User updated successfully'],);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        User::findOrFail($id)->delete();
      
        return redirect()->back()->with(['message' => 'User deleted successfully'],);
    }

    public function logout(Request $request)
    {
        // Log out the user
        Auth::guard('web')->logout();

        // Invalidate the session
        $request->session()->invalidate();

        // Regenerate the CSRF token
        $request->session()->regenerateToken();

        // Redirect to the login page
        return redirect()->route('login');
    }
}
