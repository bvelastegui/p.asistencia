<?php

namespace App\Http\Controllers;

use App\Course;
use App\Schedule;
use App\Student;
use App\Subject;
use App\User;
use App\WorkDay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    public function index(Request $request)
    {
        $user = $request->user();
        session()->put('multiple', false);

        if ($user->change_password_on_next_login) {
            return redirect()->route('users.changePassword');
        }

        if ($user->is_admin) {
            if ($user->subjects()->count() > 0) {
                session()->put('multiple', true);
                return view('home');
            } else {
                return redirect()->route('admin.index');
            }
        } else {
            return redirect()->route('schedules.index');
        }
    }
}
