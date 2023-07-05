<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Auth;

class JobOrderController extends Controller
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
        $partner_image = DB::select(DB::raw("SELECT * FROM `tbl_user_profile_image` WHERE user_id =  '$user->user_id'"));

        // $bookings_list = DB::select(DB::raw("SELECT a.id, a.booking_id, a.booking_created_at, c.customer_id, CONCAT(c.customer_last_name, ', ', c.customer_first_name, ' ', c.customer_middle_name) AS customer_name, CONCAT(d.customer_address_landmark, ', ', f.brgyDesc, ', ', g.citymunDesc, ', ', h.provDesc) as complete_customer_address, CONCAT(b.customer_device_area_name, ' (', b.customer_device_brand_name, ')') AS device_name, b.customer_device_brand_name, e.ac_type_name, b.customer_device_serial_number FROM `tbl_booking` a, `tbl_customer_device` b, `tbl_customer` c, `tbl_customer_address` d, `tbl_ac_type` e, `tbl_brgy` f, `tbl_city` g, `tbl_province` h WHERE a.customer_device_id = b.customer_device_id AND b.customer_id = c.customer_id AND b.ac_type_id = e.ac_type_id AND c.customer_id = d.customer_id AND a.customer_address_id = d.customer_address_id AND f.id_barangay = d.id_barangay AND f.citymunCode = g.citymunCode AND g.provCode = h.provCode AND a.booking_id NOT IN (SELECT booking_id FROM `tbl_job_order`)"));

        $available_bookings_list = DB::select(DB::raw("SELECT a.id AS jo_id, a.job_order_id, b.id AS book_id, a.booking_id, a.customer_id, DATE_FORMAT(b.booking_created_at, '%b %e, %Y %h:%i %p') AS booking_created_at, CONCAT(c.customer_last_name, ', ', c.customer_first_name, ' ', c.customer_middle_name) AS customer_name, d.customer_device_area_name, d.customer_device_brand_name, e.ac_type_name, i.service_name FROM `tbl_job_order` a, `tbl_booking` b, `tbl_customer` c, `tbl_customer_device` d, `tbl_ac_type` e, `tbl_booking_schedule` f, `tbl_partner_schedule` g, `tbl_partner_services` h, `tbl_services` i WHERE a.booking_id = b.booking_id AND a.customer_id = c.customer_id AND b.customer_device_id = d.customer_device_id AND d.ac_type_id = e.ac_type_id AND b.booking_schedule_id = f.booking_schedule_id AND f.partner_schedule_id = g.partner_schedule_id AND g.partner_service_id = h.partner_service_id AND h.service_id = i.service_id AND a.job_order_id NOT IN (SELECT job_order_id FROM `tbl_job_order_partner`) LIMIT 1"));

        $current_jo_lists = DB::select(DB::raw("SELECT a.id AS jo_id, a.job_order_id, a.booking_id, a.jo_status, DATE_FORMAT(a.jo_schedule_date, '%b %e, %Y') AS jo_schedule_date, DATE_FORMAT(a.jo_issued_date, '%b %e, %Y') AS jo_issued_date, d.technician_id, (SELECT CONCAT(c.technician_last_name, ', ', c.technician_first_name, ' ', IF(c.technician_middle_name is NULL, '', c.technician_middle_name)) FROM `tbl_technician` c WHERE c.technician_id = d.technician_id) AS technician_name FROM `tbl_job_order` a, `tbl_booking` b, `tbl_job_order_partner` d WHERE a.booking_id = b.booking_id AND a.job_order_id = d.job_order_id AND d.partner_id = '$user->user_id' ORDER BY a.jo_updated_at DESC;"));

        return view('job_order', [
            "available_bookings_list" => $available_bookings_list,
            "current_jo_lists" => $current_jo_lists,
            "partner_image" => $partner_image
        ]);
    }

    /**
     * Get Detailed Booking Information.
     *
     **/ 
    public function get_booking_info($booking_id)
    {      
        $user = auth()->user(); 

        $detailed_booking_information = DB::select(DB::raw("SELECT a.id, a.booking_id, DATE_FORMAT(a.booking_created_at, '%b %e, %Y %h:%i %p') AS booking_created_at, f.customer_id, CONCAT(f.customer_last_name, ', ', f.customer_first_name, ' ', f.customer_middle_name) AS customer_name, f.customer_contact_number, f.customer_email_address, CONCAT(h.customer_device_area_name, ' (', h.customer_device_brand_name, ')') AS device_name, h.customer_device_brand_name, h.customer_device_area_name, h.customer_device_serial_number, i.ac_type_name, e.service_name, CONCAT(g.customer_address_landmark, ', ', j.brgyDesc, ', ', k.citymunDesc, ', ', l.provDesc) as complete_customer_address FROM `tbl_booking` a, `tbl_booking_schedule` b, `tbl_partner_schedule` c, `tbl_partner_services` d, `tbl_services` e, `tbl_customer` f, `tbl_customer_address` g, `tbl_customer_device` h, `tbl_ac_type` i, `tbl_brgy` j, `tbl_city` k, `tbl_province` l WHERE a.booking_schedule_id = b.booking_schedule_id AND b.partner_schedule_id = c.partner_schedule_id AND c.partner_service_id = d.partner_service_id AND d.service_id = e.service_id AND a.customer_address_id = g.customer_address_id AND g.id_barangay = j.id_barangay AND j.citymunCode = k.citymunCode AND k.provCode = l.provCode AND g.customer_id = f.customer_id AND a.customer_device_id = h.customer_device_id AND h.ac_type_id = i.ac_type_id AND a.booking_id = '$booking_id'"));
        
        $detailed_booking_schedule = DB::select(DB::raw("SELECT ee.service_name, DATE_FORMAT(bb.partner_schedule_date, '%b %e, %Y') AS schedule_date, DATE_FORMAT(bb.partner_schedule_start_time, '%h:%i %p') AS start_time, DATE_FORMAT(bb.partner_schedule_end_time, '%h:%i %p') AS end_time, aa.active FROM `tbl_booking` a, `tbl_booking_schedule` aa, `tbl_partner_schedule` bb, `tbl_partner_services` cc, `tbl_partner` dd, `tbl_services` ee WHERE aa.booking_schedule_id = a.booking_schedule_id AND aa.partner_schedule_id = bb.partner_schedule_id AND bb.partner_service_id = cc.partner_service_id AND cc.service_id = ee.service_id AND cc.partner_id = dd.partner_id AND a.booking_id = '$booking_id'"));

        return response()->json([
            'detailed_booking_information' => $detailed_booking_information, 
            'detailed_booking_schedule' => $detailed_booking_schedule
        ], 200);
    }

    /**
     * Get Job Order Information.
     *
     **/ 
    public function get_joborder_info($jo_id, $joborder_id)
    {      
        $user = auth()->user(); 

        $detailed_joborder_information = DB::select(DB::raw("SELECT a.id, a.job_order_id, a.customer_id, CONCAT(h.customer_last_name, ', ', h.customer_first_name, ' ', h.customer_middle_name) AS customer_name, h.customer_contact_number, h.customer_email_address, CONCAT(k.customer_address_landmark, ', ', l.brgyDesc, ', ', m.citymunDesc, ', ', n.provDesc) as complete_customer_address, o.technician_id, CONCAT(g.technician_last_name, ', ', g.technician_first_name, ' ', IF(g.technician_middle_name is NULL ,'', g.technician_middle_name)) as technician_name, g.technician_contact_number, g.technician_email_address, a.booking_id, a.jo_status, DATE_FORMAT(a.jo_schedule_date, '%b %e, %Y') AS jo_schedule_date, DATE_FORMAT(a.jo_issued_date, '%b %e, %Y') AS jo_issued_date, i.customer_device_area_name, i.customer_device_brand_name, i.customer_device_serial_number, j.ac_type_name FROM `tbl_job_order` a, `tbl_booking` b, `tbl_booking_schedule` c, `tbl_partner_schedule` d, `tbl_partner_services` e, `tbl_services` f, `tbl_technician` g, `tbl_customer` h, `tbl_customer_device` i, `tbl_ac_type` j, `tbl_customer_address` k, `tbl_brgy` l, `tbl_city` m, `tbl_province` n, `tbl_job_order_partner` o WHERE a.booking_id = b.booking_id AND a.job_order_id = o.job_order_id AND g.technician_id = o.technician_id AND a.customer_id = h.customer_id AND b.customer_device_id = i.customer_device_id AND b.customer_address_id = k.customer_address_id AND b.booking_schedule_id = c.booking_schedule_id AND c.partner_schedule_id = d.partner_schedule_id AND d.partner_service_id = e.partner_service_id AND e.service_id = f.service_id AND i.ac_type_id = j.ac_type_id AND k.id_barangay = l.id_barangay AND l.citymunCode = m.citymunCode AND m.provCode = n.provCode AND a.id = '$jo_id' AND a.job_order_id = '$joborder_id'"));
        
        $detailed_joborder_schedule = DB::select(DB::raw("SELECT CONCAT(f.service_name, ' (', dd.partner_company_name, ')') AS service_name, DATE_FORMAT(bb.partner_schedule_date, '%b %e, %Y') AS schedule_date, DATE_FORMAT(bb.partner_schedule_start_time, '%h:%i %p') AS start_time, DATE_FORMAT(bb.partner_schedule_end_time, '%h:%i %p') AS end_time, aa.active FROM `tbl_booking` a, `tbl_booking_schedule` aa, `tbl_partner_schedule` bb, `tbl_partner_services` cc, `tbl_partner` dd, `tbl_job_order` e, `tbl_services` f WHERE a.booking_id = e.booking_id AND aa.booking_schedule_id = a.booking_schedule_id AND aa.partner_schedule_id = bb.partner_schedule_id AND bb.partner_service_id = cc.partner_service_id AND cc.service_id = f.service_id AND cc.partner_id = dd.partner_id AND aa.active = 1 AND e.id = '$jo_id' AND e.job_order_id = '$joborder_id'"));

        return response()->json([
            'detailed_joborder_information' => $detailed_joborder_information, 
            'detailed_booking_schedule' => $detailed_joborder_schedule
        ], 200);
    }

    /**
     * Get Specific Booking Information for Creation of Job Order
     *
     **/ 
    public function get_booking_info_for_job_order($edit_book_sched_id, $edit_booking_id)
    {      
        $user = auth()->user();

        $booking_information = DB::select(DB::raw("SELECT a.id, i.job_order_id, a.booking_id, a.booking_created_at, DATE_FORMAT(a.booking_created_at, '%b %e, %Y %h:%i %p') AS booking_date, c.customer_id, CONCAT(c.customer_last_name, ', ', c.customer_first_name, ' ', c.customer_middle_name) AS customer_name, CONCAT(d.customer_address_landmark, ', ', f.brgyDesc, ', ', g.citymunDesc, ', ', h.provDesc) as complete_customer_address, c.customer_contact_number, c.customer_email_address, CONCAT(b.customer_device_area_name, ' (', b.customer_device_brand_name, ')') AS device_name, b.customer_device_brand_name, e.ac_type_name, b.customer_device_serial_number FROM `tbl_booking` a, `tbl_customer_device` b, `tbl_customer` c, `tbl_customer_address` d, `tbl_ac_type` e, `tbl_brgy` f, `tbl_city` g, `tbl_province` h, `tbl_job_order` i WHERE a.booking_id = i.booking_id AND a.customer_device_id = b.customer_device_id AND b.customer_id = c.customer_id AND b.ac_type_id = e.ac_type_id AND c.customer_id = d.customer_id AND a.customer_address_id = d.customer_address_id AND f.id_barangay = d.id_barangay AND f.citymunCode = g.citymunCode AND g.provCode = h.provCode AND a.booking_id = '$edit_booking_id'"));
        
        $booking_schedule = DB::select(DB::raw("SELECT aa.book_sched_id, aa.booking_schedule_id, ee.service_name, CONCAT(DATE_FORMAT(bb.partner_schedule_date, '%b %e, %Y'), ' ', DATE_FORMAT(bb.partner_schedule_start_time, '%h:%i %p'), '-', DATE_FORMAT(bb.partner_schedule_end_time, '%h:%i %p')) AS schedule_with_time, DATE_FORMAT(bb.partner_schedule_date, '%b %e, %Y') AS schedule_date, DATE_FORMAT(bb.partner_schedule_start_time, '%h:%i %p') AS start_time, DATE_FORMAT(bb.partner_schedule_end_time, '%h:%i %p') AS end_time, aa.active FROM `tbl_booking` a, `tbl_booking_schedule` aa, `tbl_partner_schedule` bb, `tbl_partner_services` cc, `tbl_partner` dd, `tbl_services` ee WHERE aa.booking_schedule_id = a.booking_schedule_id AND aa.partner_schedule_id = bb.partner_schedule_id AND bb.partner_service_id = cc.partner_service_id AND cc.partner_id = dd.partner_id AND cc.service_id = ee.service_id AND a.booking_id = '$edit_booking_id'"));
        
        $technician_list = DB::select(DB::raw("SELECT a.id, a.technician_id, CONCAT(a.technician_first_name, ' ', a.technician_last_name) as technician_name FROM `tbl_technician` a, `tbl_technician_partner` c WHERE a.technician_id = c.technician_id AND c.partner_id = '$user->user_id' AND c.technician_partner_status = 'Active' ORDER BY a.id DESC"));

        return response()->json([
            'booking_information' => $booking_information,
            'booking_schedule' => $booking_schedule,
            'technician_list' => $technician_list
        ], 200);
    }

    /**
     * ADD/GRAB JOB ORDER
     *
     */
    public function add_joborder(Request $request)
    {
        $user = auth()->user(); 

        dd($request->all());
        
        // SAVE JOB ORDER TO PARTNER
        $add_joborder = DB::table('tbl_job_order_partner')->insert(
            [
                'jo_partner_id' => NULL,
                'job_order_id' => $request->edit_job_order_id,
                'partner_id' => $user->user_id,
                'technician_id' => $request->edit_select_assign_technician,
                'created_at' => date("Y-m-d H:i:s", strtotime(date("Y/m/d H:i:s")))
            ]
        );

        // ADD JO BILLING HERE
        $jo_billing_count = DB::select(DB::raw("SELECT LPAD((COUNT(*)+1), 3, 0) as tcount FROM `tbl_job_order_billing`"));
        $jo_billing_id = 'jo_billing_'.$jo_billing_count[0]->tcount;

        $add_joborder_billing = DB::table('tbl_job_order_billing')->insert(
            [
                'id' => NULL,
                'jo_billing_id' => $jo_billing_id,
                'job_order_id' => $request->edit_job_order_id,
                'job_order_billing_status' => "PENDING",
                'job_order_created_at' => date("Y-m-d H:i:s", strtotime(date("Y/m/d H:i:s")))
            ]
        );

        // INSTEAD OF BOOKING_SCHEDULE_ID, BOOK_SCHED_ID WAS FETCH FROM INPUT

        // CHANGE ACTIVE TO 1 WITH THE CHOSEN SCHEDULE
        $get_booking_schedule_id = DB::select(DB::raw("SELECT booking_schedule_id FROM `tbl_booking_schedule` WHERE book_sched_id = '$request->edit_select_customer_booking_schedules'"));

        $booking_schedule_id = $get_booking_schedule_id[0]->booking_schedule_id;
        $booking_schedule_update = DB::table('tbl_booking_schedule')
            ->where([
                'book_sched_id' => $request->edit_select_customer_booking_schedules,
                'booking_schedule_id' => $booking_schedule_id
                ])
            ->update([
                'active' => 1
            ]);
            
        // GET SCHEDULE DATE FROM BOOKING
        $booking_schedule = DB::select(DB::raw("SELECT b.partner_schedule_date FROM `tbl_booking_schedule` a, `tbl_partner_schedule` b WHERE a.partner_schedule_id = b.partner_schedule_id AND a.book_sched_id = '$request->edit_select_customer_booking_schedules'"));

        // APPLY SCHEDULE DATE BOOKING TO JO SCHEDULE DATE
        $booking_schedule_update = DB::table('tbl_job_order')
            ->where('job_order_id', $request->edit_job_order_id)
            ->update([
                'jo_status' => "In Queue",
                'jo_schedule_date' => $booking_schedule[0]->partner_schedule_date
            ]);
        
        if($booking_schedule_update){
            DB::table('tbl_action_history')->insert(
                [
                    'act_history_id' => NULL,
                    'user_id' => $user->user_id,
                    'action_history_activity' => "Grabbed new job order - ". $request->edit_job_order_id. '.',
                    'action_history_log_created_at' => date("Y-m-d H:i:s", strtotime(date("Y/m/d H:i:s")))
                ]
            );
                        
            return response()->json(['message'=>'Grabbed new job order!', 'success_flag'=>'1']);
        }else{
            return response()->json(['error'=>'Something went wrong...', 'success_flag'=>'0']);
        }
    }    

    /**
     * Get Job Order Information FOR EDITING/ASSIGNING.
     *
     **/ 
    public function get_joborder_info_for_edit_assign($jo_id, $joborder_id)
    {      
        $user = auth()->user();

        $edit_jo_joborder_information = DB::select(DB::raw("SELECT a.id, a.job_order_id, a.customer_id, CONCAT(h.customer_last_name, ', ', h.customer_first_name, ' ', h.customer_middle_name) AS customer_name, h.customer_contact_number, h.customer_email_address, CONCAT(k.customer_address_landmark, ', ', l.brgyDesc, ', ', m.citymunDesc, ', ', n.provDesc) as complete_customer_address, a.booking_id, a.jo_status, DATE_FORMAT(a.jo_schedule_date, '%b %e, %Y') AS jo_schedule_date, DATE_FORMAT(a.jo_issued_date, '%b %e, %Y') AS jo_issued_date, i.customer_device_area_name, i.customer_device_brand_name, i.customer_device_serial_number, j.ac_type_name FROM `tbl_job_order` a, `tbl_booking` b, `tbl_booking_schedule` c, `tbl_partner_schedule` d, `tbl_partner_services` e, `tbl_services` f, `tbl_customer` h, `tbl_customer_device` i, `tbl_ac_type` j, `tbl_customer_address` k, `tbl_brgy` l, `tbl_city` m, `tbl_province` n WHERE a.booking_id = b.booking_id AND a.customer_id = h.customer_id AND b.customer_device_id = i.customer_device_id AND b.customer_address_id = k.customer_address_id AND b.booking_schedule_id = c.booking_schedule_id AND c.partner_schedule_id = d.partner_schedule_id AND d.partner_service_id = e.partner_service_id AND e.service_id = f.service_id AND i.ac_type_id = j.ac_type_id AND k.id_barangay = l.id_barangay AND l.citymunCode = m.citymunCode AND m.provCode = n.provCode AND a.id = '$jo_id' AND a.job_order_id = '$joborder_id' LIMIT 1")); // check this, should not use limit 1

        $edit_jo_booking_schedule_list = DB::select(DB::raw("SELECT aa.book_sched_id, aa.booking_schedule_id, ee.service_name, CONCAT(DATE_FORMAT(bb.partner_schedule_date, '%b %e, %Y'), ' ', DATE_FORMAT(bb.partner_schedule_start_time, '%h:%i %p'), '-', DATE_FORMAT(bb.partner_schedule_end_time, '%h:%i %p')) AS schedule_with_time, DATE_FORMAT(bb.partner_schedule_date, '%b %e, %Y') AS schedule_date, DATE_FORMAT(bb.partner_schedule_start_time, '%h:%i %p') AS start_time, DATE_FORMAT(bb.partner_schedule_end_time, '%h:%i %p') AS end_time, aa.active FROM `tbl_booking` a, `tbl_booking_schedule` aa, `tbl_partner_schedule` bb, `tbl_partner_services` cc, `tbl_partner` dd, `tbl_services` ee WHERE aa.booking_schedule_id = a.booking_schedule_id AND aa.partner_schedule_id = bb.partner_schedule_id AND bb.partner_service_id = cc.partner_service_id AND cc.partner_id = dd.partner_id AND cc.service_id = ee.service_id AND a.booking_id = (SELECT a.booking_id FROM `tbl_booking` a, `tbl_job_order` b WHERE a.booking_id = b.booking_id AND b.id = '$jo_id' AND b.job_order_id = '$joborder_id')"));
        
        $edit_jo_technician_list = DB::select(DB::raw("SELECT a.id, a.technician_id, CONCAT(a.technician_first_name, ' ', a.technician_last_name) as technician_name FROM `tbl_technician` a, `tbl_technician_partner` c WHERE a.technician_id = c.technician_id AND c.partner_id = '$user->user_id' AND c.technician_partner_status = 'Active' ORDER BY a.id DESC"));

        return response()->json([
            'edit_jo_joborder_information' => $edit_jo_joborder_information, 
            'edit_jo_booking_schedule_list' => $edit_jo_booking_schedule_list, 
            'edit_jo_technician_list' => $edit_jo_technician_list
        ], 200);
    }

    /**
     * EDIT JOB ORDER
     *
     */
    public function edit_joborder(Request $request)
    {
        $user = auth()->user(); 

        // dd($request->all());
        
        // EDIT JOB ORDER TO PARTNER
        $edit_joborder = DB::table('tbl_job_order_partner')
            ->where('job_order_id', $request->edit_assign_job_order_id)
            ->update([
                'technician_id' => $request->edit_assign_select_assign_technician,                
                'updated_at' => date("Y-m-d H:i:s", strtotime(date("Y/m/d H:i:s")))              
            ]);

        // ADD JO BILLING HERE
        // $jo_billing_count = DB::select(DB::raw("SELECT LPAD((COUNT(*)+1), 3, 0) as tcount FROM `tbl_job_order_billing`"));
        // $jo_billing_id = 'jo_billing_'.$jo_billing_count[0]->tcount;

        // $add_joborder_billing = DB::table('tbl_job_order_billing')->insert(
        //     [
        //         'id' => NULL,
        //         'jo_billing_id' => $jo_billing_id,
        //         'job_order_id' => $request->edit_job_order_id,
        //         'job_order_billing_status' => "PENDING",
        //         'job_order_created_at' => date("Y-m-d H:i:s", strtotime(date("Y/m/d H:i:s")))
        //     ]
        // );

        
        // INSTEAD OF BOOKING_SCHEDULE_ID, BOOK_SCHED_ID WAS FETCH FROM INPUT

        $get_booking_schedule_id = DB::select(DB::raw("SELECT booking_schedule_id FROM `tbl_booking_schedule` WHERE book_sched_id = '$request->edit_assign_select_customer_booking_schedules'"));
        $booking_schedule_id = $get_booking_schedule_id[0]->booking_schedule_id;

        $get_active_booking_schedule_id = DB::select(DB::raw("SELECT book_sched_id FROM `tbl_booking_schedule` WHERE active = 1 AND booking_schedule_id = '$booking_schedule_id'"));
        $modify_book_sched_id = $get_active_booking_schedule_id[0]->book_sched_id;

        // CHANGE ACTIVE TO 0 TO PREVIOUS CHOSEN SCHEDULE
        $booking_schedule_update_to_active = DB::table('tbl_booking_schedule')
            ->where([
                'book_sched_id' => $modify_book_sched_id,
                'booking_schedule_id' => $booking_schedule_id
                ])
            ->update([
                'active' => 0
            ]);

        // CHANGE ACTIVE TO 1 WITH THE CHOSEN SCHEDULE
        $booking_schedule_update_to_active = DB::table('tbl_booking_schedule')
            ->where('book_sched_id', $request->edit_assign_select_customer_booking_schedules)
            ->update([
                'active' => 1
            ]);
            
        // GET SCHEDULE DATE FROM BOOKING
        $booking_schedule = DB::select(DB::raw("SELECT b.partner_schedule_date FROM `tbl_booking_schedule` a, `tbl_partner_schedule` b WHERE a.partner_schedule_id = b.partner_schedule_id AND a.book_sched_id = '$request->edit_assign_select_customer_booking_schedules'"));

        // APPLY SCHEDULE DATE BOOKING TO JO SCHEDULE DATE
        $booking_schedule_update = DB::table('tbl_job_order')
            ->where('job_order_id', $request->edit_assign_job_order_id)
            ->update([
                'jo_status' => "In Queue",
                'jo_schedule_date' => $booking_schedule[0]->partner_schedule_date
            ]);
        
        if($booking_schedule_update){
            DB::table('tbl_action_history')->insert(
                [
                    'act_history_id' => NULL,
                    'user_id' => $user->user_id,
                    'action_history_activity' => "Edited job order - ". $request->edit_assign_job_order_id. '.',
                    'action_history_log_created_at' => date("Y-m-d H:i:s", strtotime(date("Y/m/d H:i:s")))
                ]
            );
                        
            return response()->json(['message'=>'Edited Job Order.', 'success_flag'=>'1']);
        }else{
            return response()->json(['error'=>'Something went wrong...', 'success_flag'=>'0']);
        }
    }    
}
