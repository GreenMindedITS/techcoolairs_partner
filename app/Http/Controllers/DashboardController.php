<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;

class DashboardController extends Controller
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
        $technician_count = DB::select(DB::raw("SELECT COUNT(*) as number_of_technicians FROM `tbl_partner` a, `tbl_technician_partner` b WHERE a.partner_id = b.partner_id"));
        $partner_image = DB::select(DB::raw("SELECT * FROM `tbl_user_profile_image` WHERE user_id =  '$user->user_id'"));
        
        $current_jo_lists = DB::select(DB::raw("SELECT a.id AS jo_id, a.job_order_id, a.booking_id, a.jo_status, DATE_FORMAT(a.jo_schedule_date, '%b %e, %Y') AS jo_schedule_date, DATE_FORMAT(a.jo_issued_date, '%b %e, %Y') AS jo_issued_date, d.technician_id, (SELECT CONCAT(c.technician_last_name, ', ', c.technician_first_name, ' ', IF(c.technician_middle_name is NULL, '', c.technician_middle_name)) FROM `tbl_technician` c WHERE c.technician_id = d.technician_id) AS technician_name FROM `tbl_job_order` a, `tbl_booking` b, `tbl_job_order_partner` d WHERE a.booking_id = b.booking_id AND a.job_order_id = d.job_order_id AND d.partner_id = '$user->user_id'"));

        return view('dashboard', [
            "technician_count" => $technician_count,
            "partner_image" => $partner_image,
            "user_action_history" => $user_action_history,
            "current_jo_lists" => $current_jo_lists,
        ]);
    }
}
