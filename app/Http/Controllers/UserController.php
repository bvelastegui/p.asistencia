<?php

namespace App\Http\Controllers;


use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(User $user = null)
    {
        $selected_user = $user;
        $users = User::where('id', '!=', auth()->id())->get();

        return view('users.index', compact('users', 'selected_user'));
    }

    public function update(Request $request, User $user)
    {
        if ($request->has('active')) {
            $user->update(['active' => $request->get('active')]);
        } else {
            $this->validate($request, [
                'identity' => [
                    'required',
                    Rule::unique('users')->ignore($user->identity, 'identity')
                ],
                'email' => [
                    'required',
                    Rule::unique('users')->ignore($user->email, 'email')
                ],
                'name' => 'required',
                'password' => 'nullable|min:6|confirmed'
            ]);

            $updates = $request->only('identity', 'email', 'name');

            if ($password = $request->get('password')) $updates['password'] = Hash::make($password);

            if ($request->has('is_admin')) $updates['is_admin'] = true;

            $updates['change_password_on_next_login'] = $request->has('change_password_on_next_login') ? true : false;

            $user->update($updates);
        }

        return redirect()->route('users.index', ['user' => $user->id]);
    }

    public function changePassword()
    {
        return view('users.password');
    }

    public function storePassword(Request $request)
    {
        $this->validate($request, [
            'password' => 'required|min:6|confirmed'
        ]);

        $user = User::find(auth()->id());
        $user->password = Hash::make($request->get('password'));
        $user->change_password_on_next_login = false;
        $user->save();

        return redirect()->route('schedules.index');
    }

    public function store(Request $request)
    {
        $this->validate($request,
            [
                'name' => 'required',
                'identity' => 'required|unique:users,identity',
                'email' => 'required|unique:users,email',
                'password' => 'required|min:4|confirmed'
            ]
        );

        $newUser = User::create([
            'name' => $request->get('name'),
            'identity' => $request->get('identity'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
            'change_password_on_next_login' => $request->has('change_password_on_next_login')
        ]);

        return redirect()->route('users.index', ['user' => $newUser->id]);
    }
}