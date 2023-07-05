<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Auth;

class ActivitiesController extends Controller
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = auth()->user();    
        $user_action_history = DB::select(DB::raw("SELECT act_history_id, user_id, action_history_activity, DATE_FORMAT(action_history_log_created_at, '%M %d, %Y') AS created_at_date, DATE_FORMAT(action_history_log_created_at, '%h:%i %p') AS created_at_time FROM `tbl_action_history` WHERE user_id = '$user->user_id' ORDER BY act_history_id DESC"));
        $partner_image = DB::select(DB::raw("SELECT * FROM `tbl_user_profile_image` WHERE user_id =  '$user->user_id'"));

        return view('activities', [
            "user_action_history" => $user_action_history,
            "partner_image" => $partner_image
        ]);
    }
}
