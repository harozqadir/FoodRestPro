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

class UserController extends Controller
{
    
    public function index(Request $request)
    {
        
       //$data = User::with('user')->orderBy('id','desc')->paginate(10); //represent pages
     // First way to search
    //    $data = User::query()->with('user')->when($request->search,function($search)
    //   use($request){
    //       $search->where('email','like', $request->search.'%');
    //   })->latest()->paginate(10)->appends($request->query());


      // Second way to search
    //    $data = User::query()->with('user')->orderBy('id','desc');
    //    if($request->search){
    //        //whereany
    //        //where all 
    //        //whereHas 
    //        $data->whereAny('email','like', $request->search.'%');
    //    }

    // //another way to search
    // $data = User::query()->with('user')->get();
    //   return view('admin.users.index',compact('data'));
    
    if ($request->ajax()) {
        $data = User::query()->latest()->with('user'); // Remove with('user') if not needed
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('role_readable', function($row) {
                $roles = [
                    1 => 'Admin',
                    2 => 'Server',
                    3 => 'Chief'
                ];
                return $roles[$row->role] ?? 'Unknown';
            })
            ->addColumn('actions', function ($row) {
                return '<a href="'.route('admin.users.edit', ['user' => $row->id]).'" class="btn btn-primary">Edit</a>

                <form id='.$row->id.' action="'.route('admin.users.destroy', ['user' => $row->id]).'" method="POST" style="display: inline-block;">
                        '.csrf_field().'
                        '.method_field('DELETE').'
                <button  type="button" onclick= "deleteFunction('.$row->id.')" class="btn btn-danger">Delete</button>
                        </form>
                        ';
            })
            ->editColumn('created_at', function ($row) {
                return $row->created_at->format('Y-m-d');
            })
            ->rawColumns(['actions'])
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
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
