<?php
/**
 * Created by PhpStorm.
 * User: bvelastegui
 * Date: 6/28/18
 * Time: 1:01 p.m.
 */

namespace App\Http\Controllers;


use App\Schedule;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $userId = auth()->id();
        $schedules = (new Schedule)->whereHas("subject", function ($query) use ($userId) {
            $query->select('id')->where('user_id', $userId);
        })->where('day', date('l'))->get();

        return view('schedules.index', compact('schedules'));
    }

    public function edit($scheduleId)
    {

    }

    public function store()
    {

    }
}