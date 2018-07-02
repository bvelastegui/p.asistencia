<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

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
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function credentials(Request $request)
    {
        return array_merge($request->only($this->username(), 'password'), ['active' => 1]);
    }

    public function authenticated(Request $request, $user)
    {
        if ($user->change_password_in_next_login) {
            return redirect()->route('users.changePassword', ['user' => $user]);
        }

        return redirect()->intended($this->redirectPath());
    }

    public function username()
    {
        return 'identity';
    }
}
