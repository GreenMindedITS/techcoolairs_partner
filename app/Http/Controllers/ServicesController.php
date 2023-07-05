<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Auth;

class ServicesController extends Controller
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

        $services_list = DB::select(DB::raw("SELECT * FROM `tbl_services` WHERE service_id NOT IN (SELECT service_id FROM `tbl_partner_services`)"));
        $partner_services_list = DB::select(DB::raw("SELECT a.service_id, a.service_name, a.service_description, b.partner_service_price, b.partner_service_status, b.partner_service_id, b.partner_serv_id FROM `tbl_services` a, `tbl_partner_services` b WHERE a.service_id = b.service_id AND b.partner_id = '$user->user_id'")); 
        $partner_image = DB::select(DB::raw("SELECT * FROM `tbl_user_profile_image` WHERE user_id = '$user->user_id'")); 

        return view('services', [
            "partner_image" => $partner_image,
            "services_list" => $services_list,
            "partner_services_list" => $partner_services_list
        ]);
    }

    public function get_services_info($service_id)
    {      
        $user = auth()->user(); 

        $services_info = DB::select(DB::raw("SELECT * FROM `tbl_services` WHERE service_id = '$service_id'"));

        return response()->json($services_info, 200);
        
    }

    /**
     * Update Services Information
     *
     */
    public function services_update(Request $request)
    {
        $user = auth()->user(); 

        // dd($request->all());

        $services_update = DB::table('tbl_partner_services')
            ->where([
                ['partner_service_id', $request->edit_partner_service_id],
                ['partner_id', $user->user_id]
            ])
            ->update([
                'partner_service_price' => $request->edit_partner_service_price,
                'partner_service_status' => $request->edit_partner_service_status,
                'partner_service_updated_at' => date("Y-m-d H:i:s", strtotime(date("Y/m/d H:i:s")))
            ]);

        if($services_update){
            DB::table('tbl_action_history')->insert(
                [
                    'act_history_id' => NULL,
                    'user_id' => $user->user_id,
                    'action_history_activity' => "Updated partner service information - ".$request->edit_partner_service_name .".",
                    'action_history_log_created_at' => date("Y-m-d H:i:s", strtotime(date("Y/m/d H:i:s")))
                ]
            );
                        
            return response()->json(['message'=>'Partner service information updated successfully!', 'success_flag'=>'1']);
        }else{
            return response()->json(['error'=>'Something went wrong...', 'success_flag'=>'0']);
        }
    }

    /**
     * Add Services
     *
     */
    public function services_add(Request $request)
    {
        $user = auth()->user(); 

        // dd($request->all());
        
        $services_count = DB::select(DB::raw("SELECT LPAD((COUNT(*)+1), 3, 0) as scount FROM `tbl_partner_services` WHERE partner_id = '$user->user_id'"));
        $partner_services_id = 'part_serv_'.$services_count[0]->scount;

        $services_add = DB::table('tbl_partner_services')->insert(
            [
                'partner_serv_id' => NULL,
                'partner_service_id' => $partner_services_id,
                'partner_id' => $user->user_id,
                'service_id' => $request->add_service_id,
                'partner_service_price' => $request->add_partner_service_price,
                'partner_service_status' => $request->add_partner_service_status,
                'partner_service_created_at' => date("Y-m-d H:i:s", strtotime(date("Y/m/d H:i:s")))
            ]
        );

        if($services_add){
            DB::table('tbl_action_history')->insert(
                [
                    'act_history_id' => NULL,
                    'user_id' => $user->user_id,
                    'action_history_activity' => "Added new partner service - ". $request->add_partner_service_name. '.',
                    'action_history_log_created_at' => date("Y-m-d H:i:s", strtotime(date("Y/m/d H:i:s")))
                ]
            );
                        
            return response()->json(['message'=>'Added new partner service successfully!', 'success_flag'=>'1']);
        }else{
            return response()->json(['error'=>'Something went wrong...', 'success_flag'=>'0']);
        }
    }

    /**
     * Services Schedule
     *
     */
    public function index_schedule_services()
    {
        $user = auth()->user();   

        $partner_services_list = DB::select(DB::raw("SELECT a.service_id, a.service_name, a.service_description, b.partner_service_price, b.partner_service_status, b.partner_service_id, b.partner_serv_id FROM `tbl_services` a, `tbl_partner_services` b WHERE a.service_id = b.service_id AND b.partner_id = '$user->user_id'"));
        $partner_image = DB::select(DB::raw("SELECT * FROM `tbl_user_profile_image` WHERE user_id = '$user->user_id'")); 
        
        $partner_schedule_count = DB::select(DB::raw("SELECT a.partner_schedule_date, (SELECT SUM(aa.partner_schedule_no_of_slots) FROM `tbl_partner_schedule` aa WHERE aa.partner_schedule_date = a.partner_schedule_date) as total_schedule_slots FROM `tbl_partner_schedule` a, `tbl_partner_services` b WHERE a.partner_service_id = b.partner_service_id GROUP BY a.partner_schedule_date")); 

        $partner_schedule_list = DB::select(DB::raw("SELECT a.partner_sched, a.partner_service_id, c.service_name, a.partner_schedule_date, DATE_FORMAT(a.partner_schedule_date, '%b %e, %Y') AS schedule_date, a.partner_schedule_start_time, DATE_FORMAT(a.partner_schedule_start_time, '%h:%i %p') AS start_time, a.partner_schedule_end_time, DATE_FORMAT(a.partner_schedule_end_time, '%h:%i %p') AS end_time, a.partner_schedule_no_of_slots FROM `tbl_partner_schedule` a, `tbl_partner_services` b, `tbl_services` c WHERE a.partner_service_id = b.partner_service_id AND b.service_id = c.service_id ORDER BY a.partner_schedule_date DESC")); 
        

        return view('schedule_services', [
            "partner_image" => $partner_image,
            "partner_services_list" => $partner_services_list,
            "partner_schedule_list" => $partner_schedule_list,
            "partner_schedule_count" => $partner_schedule_count
        ]);
    }

    /**
     * Update Services Schedule Information
     *
     */
    public function services_schedule_update(Request $request)
    {
        $user = auth()->user(); 

        // dd($request->all());

        $services_schedule_update = DB::table('tbl_partner_schedule')
            ->where([
                ['partner_sched', $request->edit_partner_sched],
                ['partner_service_id', $request->edit_partner_service_id]
            ])
            ->update([
                'partner_schedule_date' => $request->edit_partner_schedule_date,
                'partner_schedule_start_time' => $request->edit_partner_schedule_start_time,
                'partner_schedule_end_time' => $request->edit_partner_schedule_end_time,
                'partner_schedule_no_of_slots' => $request->edit_partner_schedule_slots,
                'partner_schedule_updated_at' => date("Y-m-d H:i:s", strtotime(date("Y/m/d H:i:s")))
            ]);

        if($services_schedule_update){
            DB::table('tbl_action_history')->insert(
                [
                    'act_history_id' => NULL,
                    'user_id' => $user->user_id,
                    'action_history_activity' => "Updated service schedule information for ".$request->edit_partner_service_id .".",
                    'action_history_log_created_at' => date("Y-m-d H:i:s", strtotime(date("Y/m/d H:i:s")))
                ]
            );
                        
            return response()->json(['message'=>'Partner service schedule information updated successfully!', 'success_flag'=>'1']);
        }else{
            return response()->json(['error'=>'Something went wrong...', 'success_flag'=>'0']);
        }
    }

    /**
     * Add Services Schedule
     *
     */
    public function services_schedule_add(Request $request)
    {
        $user = auth()->user(); 

        // dd($request->all());
        
        $partner_services_count = DB::select(DB::raw("SELECT LPAD((COUNT(*)+1), 3, 0) as scount FROM `tbl_partner_schedule`"));
        $partner_schedule_id = 'part_sched_'.$partner_services_count[0]->scount;

        $services_schedule_add = DB::table('tbl_partner_schedule')->insert(
            [
                'partner_sched' => NULL,
                'partner_schedule_id' => $partner_schedule_id,
                'partner_service_id' => $request->add_partner_service_id,
                'partner_schedule_date' => $request->add_partner_schedule_date,
                'partner_schedule_start_time' => $request->add_partner_schedule_start_time,
                'partner_schedule_end_time' => $request->add_partner_schedule_end_time,
                'partner_schedule_no_of_slots' => $request->add_partner_schedule_slots,
                'partner_schedule_updated_at' => date("Y-m-d H:i:s", strtotime(date("Y/m/d H:i:s")))
            ]
        );

        if($services_schedule_add){
            DB::table('tbl_action_history')->insert(
                [
                    'act_history_id' => NULL,
                    'user_id' => $user->user_id,
                    'action_history_activity' => "Added new schedule for - ". $request->add_partner_service_id. '.',
                    'action_history_log_created_at' => date("Y-m-d H:i:s", strtotime(date("Y/m/d H:i:s")))
                ]
            );
                        
            return response()->json(['message'=>'Added new service schedule successfully!', 'success_flag'=>'1']);
        }else{
            return response()->json(['error'=>'Something went wrong...', 'success_flag'=>'0']);
        }
    }

    public function get_events($date)
    {      
        $user = auth()->user(); 

        $all_schedule_for_the_day = DB::select(DB::raw("SELECT a.partner_sched, a.partner_service_id, c.service_name, a.partner_schedule_date, DATE_FORMAT(a.partner_schedule_date, '%b %e, %Y') AS schedule_date, a.partner_schedule_start_time, DATE_FORMAT(a.partner_schedule_start_time, '%h:%i %p') AS start_time, a.partner_schedule_end_time, DATE_FORMAT(a.partner_schedule_end_time, '%h:%i %p') AS end_time, a.partner_schedule_no_of_slots FROM `tbl_partner_schedule` a, `tbl_partner_services` b, `tbl_services` c WHERE a.partner_service_id = b.partner_service_id AND b.service_id = c.service_id AND a.partner_schedule_date = '$date' ORDER BY a.partner_schedule_date DESC"));

        return response()->json($all_schedule_for_the_day, 200);
        
    }
}
