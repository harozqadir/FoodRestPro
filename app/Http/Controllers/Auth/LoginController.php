<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    //protected $redirectTo = '/admin/home';
    

    public function redirectTo()
{
    $user = auth()->user();
    if ($user->isAdmin()) {
        return '/admin/home';
    } elseif ($user->isServer()) {
        return '/server/home';
    } elseif ($user->isChef()) {
        return '/chef/home';
    } elseif ($user->isCasher()) {
        return '/casher/home';
    }
    return '/home';
}

public function username()
{
    return 'username';
}

public function showLoginForm()
{
    return view('auth.login');
}

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');

        //$this->middleware('auth')->only('logout');
    }
   
    public function logout(Request $request)
    {
        Auth::logout();

        // Invalidate the session and regenerate the CSRF token
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect to the login page
        return redirect()->route('login');
    }

}
