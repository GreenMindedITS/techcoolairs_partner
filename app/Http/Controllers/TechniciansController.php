<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Auth;

class TechniciansController extends Controller
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
        $technician_list = DB::select(DB::raw("SELECT a.id, a.technician_id, a.technician_first_name, a.technician_middle_name, a.technician_last_name, a.technician_birthdate, CONCAT(a.technician_first_name, ' ', a.technician_last_name) as technician_name, a.technician_contact_number, a.technician_email_address, b.technician_address, CONCAT(b.technician_address, ', ', d.brgyDesc, ', ', e.citymunDesc, ', ', f.provDesc, ' ', b.technician_address_zip_code) as complete_technician_address, b.id_barangay, d.citymunCode, e.citymunDesc, e.provCode, f.provDesc, (SELECT aa.user_profile_image FROM `tbl_user_profile_image` aa WHERE aa.user_id = a.technician_id) as technician_profile_image, c.technician_partner_status FROM `tbl_technician` a, `tbl_technician_address` b, `tbl_technician_partner` c, `tbl_brgy` d, `tbl_city` e, `tbl_province` f WHERE a.technician_id = b.technician_id AND a.technician_id = c.technician_id AND b.id_barangay = d.id_barangay AND d.citymunCode = e.citymunCode AND e.provCode = f.provCode AND c.partner_id = '$user->user_id' ORDER BY a.id DESC"));
        $technician_count = DB::select(DB::raw("SELECT COUNT(*) as number_of_technicians FROM `tbl_partner` a, `tbl_technician_partner` b WHERE a.partner_id = b.partner_id AND a.partner_id = '$user->user_id'"));

        $province_listing = DB::select(DB::raw("SELECT a.provCode, a.provDesc, b.citymunCode FROM `tbl_province` a, `tbl_city` b WHERE a.provCode = b.provCode GROUP BY a.provCode"));

        return view('technicians', [            
            "technician_list" => $technician_list,
            "technician_count" => $technician_count,
            "partner_image" => $partner_image,
            "province_listing" => $province_listing
        ]);
    }

    public function get_technician_details($technician_id){
        $technician_details = DB::select(DB::raw("SELECT a.technician_id, a.technician_first_name, a.technician_middle_name, a.technician_last_name, a.technician_birthdate, CONCAT(a.technician_first_name, ' ', a.technician_last_name) as technician_name, a.technician_contact_number, a.technician_email_address, b.technician_address, CONCAT(b.technician_address, ', ', d.brgyDesc, ', ', e.citymunDesc, ', ', f.provDesc) as complete_technician_address, b.id_barangay, d.brgyDesc, d.citymunCode, e.citymunDesc, e.provCode, f.provDesc, b.technician_address_zip_code, (SELECT aa.user_profile_image FROM `tbl_user_profile_image` aa WHERE aa.user_id = a.technician_id) as technician_profile_image, c.technician_partner_status FROM `tbl_technician` a, `tbl_technician_address` b, `tbl_technician_partner` c, `tbl_brgy` d, `tbl_city` e, `tbl_province` f WHERE a.technician_id = b.technician_id AND a.technician_id = c.technician_id AND b.id_barangay = d.id_barangay AND d.citymunCode = e.citymunCode AND e.provCode = f.provCode AND a.technician_id = '$technician_id'"));

        $province_code = $technician_details[0]->provCode;
        $city_code = $technician_details[0]->citymunCode;
        $barangay_id = $technician_details[0]->id_barangay;

        $province_list = DB::select(DB::raw("SELECT a.provCode, a.provDesc, b.citymunCode FROM `tbl_province` a, `tbl_city` b WHERE a.provCode = b.provCode AND a.provCode NOT IN ($province_code) GROUP BY a.provCode"));
        $city_list = DB::select(DB::raw("SELECT a.citymunCode, a.citymunDesc FROM `tbl_city` a, `tbl_province` b WHERE a.provCode = b.provCode AND a.provCode = $province_code AND citymunCode NOT IN ($city_code) GROUP BY a.citymunCode"));
        $barangay_list = DB::select(DB::raw("SELECT a.id_barangay, a.brgyDesc FROM `tbl_brgy` a, `tbl_city` b WHERE a.citymunCode = b.citymunCode AND a.citymunCode = $city_code AND id_barangay NOT IN ($barangay_id) GROUP BY a.id_barangay"));


        return [
            "technician_details" => $technician_details,
            "province_list" => $province_list,
            "city_list" => $city_list,
            "barangay_list" => $barangay_list
        ];
    }

    /**
     * Technician Profile Picture
     *
     */

    public function upload_technician_profile_user_image(Request $request)
    {
         $user = auth()->user();
         $technician_id = $request->technician_id;
         $filename = time()."_tech_".$request->input_file[0]->getClientOriginalName();
 
        //  dd($request->all());
 
         $user_profile = DB::select(DB::raw("SELECT * FROM `tbl_user_profile_image` WHERE user_id = '$technician_id'"));
        //  dd($user_profile);
         $technician_profile = DB::select(DB::raw("SELECT CONCAT(technician_first_name, ' ', technician_last_name) as technician_name FROM `tbl_technician` WHERE technician_id = '$technician_id'"));
         
         if($user_profile){
            $path = Storage::disk('do_spaces')->putFileAs('cleaningapp-profile-images', $request->input_file[0], $filename, 'public');
             $profile_image_change = DB::table('tbl_user_profile_image')
                 ->where('user_id', $technician_id)
                 ->update([
                     'user_profile_image' => $filename,
                     'user_profile_image_updated_at' => date("Y-m-d H:i:s", strtotime(date("Y/m/d H:i:s")))
                 ]);

                 if($user_profile[0]->user_profile_image != 'img_avatar.png'){
                    Storage::disk('do_spaces')->delete('cleaningapp-profile-images/'.$user_profile[0]->user_profile_image);
                    // unlink(public_path('img/'.$user_profile[0]->user_profile_image));
                 }
 
         }else{
             $profile_image_change = DB::table('tbl_user_profile_image')->insert(
                 [
                     'id' => NULL,
                     'user_id' => $technician_id,
                     'user_profile_image' => $filename,
                     'user_profile_image_created_at' => date("Y-m-d H:i:s", strtotime(date("Y/m/d H:i:s")))
                 ]
             );
         }
 
        //  $request->input_file[0]->move(public_path('img/'), $filename);
 
         if($profile_image_change){
             DB::table('tbl_action_history')->insert(
                 [
                     'act_history_id' => NULL,
                     'user_id' => $user->user_id,
                     'action_history_activity' => "Uploaded profile image for technician - ".$technician_profile[0]->technician_name." (".$request->technician_id.").",
                     'action_history_log_created_at' => date("Y-m-d H:i:s", strtotime(date("Y/m/d H:i:s")))
                 ]
             );
                 
             return response()->json(['message'=>'Updated technician profile image successfully!', 'success_flag'=>'1']);
         }else{
             return response()->json(['error'=>'Something went wrong...', 'success_flag'=>'0']);
         }
    }

    /**
     * Update Technician Information
     *
     */
    public function technicianinformation_update(Request $request)
    {
        $user = auth()->user();
        // dd($request->all());
        
        $technician_update = DB::table('tbl_technician')
            ->where('technician_id', $request->modify_technician_id)
            ->update([
                'technician_first_name' => $request->modify_technician_first_name,
                'technician_middle_name' => $request->modify_technician_middle_name,
                'technician_last_name' => $request->modify_technician_last_name,
                'technician_birthdate' => $request->modify_technician_birthdate,
                'technician_contact_number' => $request->modify_technician_contact_number,
                'technician_email_address' => $request->modify_technician_email_address,
                'technician_updated_at' => date("Y-m-d H:i:s", strtotime(date("Y/m/d H:i:s")))
            ]);

        $technician_address_update = DB::table('tbl_technician_address')
            ->where('technician_id', $request->modify_technician_id)
            ->update([
                'technician_address' => $request->modify_technician_address,
                'id_barangay' => $request->modify_technician_select_barangay,
                'technician_address_zip_code' => $request->modify_technician_zip_code,
                'technician_address_map_latitude' => '',
                'technician_address_map_longitude' => '',
                'technician_address_status' => 'active',
                'technician_address_updated_at' => date("Y-m-d H:i:s", strtotime(date("Y/m/d H:i:s")))
            ]);

        $technician_update_users = DB::table('users')
            ->where('user_id', $request->modify_technician_id)
            ->update([
                'name' => $request->modify_technician_first_name.' '.$request->modify_technician_last_name,
                'updated_at' => date("Y-m-d H:i:s", strtotime(date("Y/m/d H:i:s")))
            ]);

        if($technician_update_users){
            DB::table('tbl_action_history')->insert(
                [
                    'act_history_id' => NULL,
                    'user_id' => $user->user_id,
                    'action_history_activity' => "Updated information of technician - " .$request->modify_technician_first_name." ".$request->modify_technician_last_name." (".$request->modify_technician_id.").",
                    'action_history_log_created_at' => date("Y-m-d H:i:s", strtotime(date("Y/m/d H:i:s")))
                ]
            );
                        
            return response()->json(['message'=>'Technician information updated successfully!', 'success_flag'=>'1']);
        }else{
            return response()->json(['error'=>'Something went wrong...', 'success_flag'=>'0']);
        }
    }

    /**
     * Add Technician
     *
     */
    public function technicianinformation_add(Request $request)
    {
        $user = auth()->user();
        // dd($request->all());
        
        $technician_count = DB::select(DB::raw("SELECT LPAD((COUNT(*)+1), 3, 0) as tcount FROM `tbl_technician_partner` WHERE partner_id = '$user->user_id'"));
        $technician_id = 'technician_'.$technician_count[0]->tcount;

        // Add technician
        $technician_add = DB::table('tbl_technician')->insert(
            [
                'id' => NULL,
                'technician_id' => $technician_id,
                'technician_first_name' => $request->add_technician_first_name,
                'technician_middle_name' => $request->add_technician_middle_name,
                'technician_last_name' => $request->add_technician_last_name,
                'technician_birthdate' => $request->add_technician_birthdate,
                'technician_contact_number' => $request->add_technician_contact_number,
                'technician_email_address' => $request->add_technician_email_address,
                'technician_created_at' => date("Y-m-d H:i:s", strtotime(date("Y/m/d H:i:s")))
            ]
        );

        // Add technician address
        $technician_add_address = DB::table('tbl_technician_address')->insert(
            [
                'technician_address_id' => NULL,
                'technician_id' => $technician_id,
                'technician_address' => $request->add_technician_address,
                'id_barangay' => $request->add_technician_select_barangay,
                'technician_address_zip_code' => $request->add_technician_zip_code,
                'technician_address_map_latitude' => '',
                'technician_address_map_longitude' => '',
                'technician_address_status' => 'active',
                'technician_address_created_at' => date("Y-m-d H:i:s", strtotime(date("Y/m/d H:i:s")))
            ]
        );

        // Add technician partner
        $technician_add_partner = DB::table('tbl_technician_partner')->insert(
            [
                'id' => NULL,
                'technician_id' => $technician_id,
                'partner_id' => $user->user_id,
                'technician_partner_status' => 'Active',
                'technician_partner_created_at' => date("Y-m-d H:i:s", strtotime(date("Y/m/d H:i:s")))
            ]
        );

        // Add technician user
        $technician_add_user = DB::table('users')->insert(
            [
                'id' => NULL,
                'user_id' => $technician_id,
                'user_category_id' => 'uc_004',
                'name' => $request->add_technician_first_name.' '.$request->add_technician_last_name,
                'email' => $request->add_technician_email_address,
                'password' => Hash::make($request->add_technician_email_address),
                'active' => 1,
                'created_at' => date("Y-m-d H:i:s", strtotime(date("Y/m/d H:i:s")))
            ]
        );

        // Add technician user default profile image
        $technician_add_user_img = DB::table('tbl_user_profile_image')->insert(
            [
                'id' => NULL,
                'user_id' => $technician_id,
                'user_profile_image' => 'img_avatar.png',
                'user_profile_image_created_at' => date("Y-m-d H:i:s", strtotime(date("Y/m/d H:i:s")))
            ]
        );

        if($technician_add_user_img){
            DB::table('tbl_action_history')->insert(
                [
                    'act_history_id' => NULL,
                    'user_id' => $user->user_id,
                    'action_history_activity' => "Added a new technician - " .$request->add_technician_first_name." ".$request->add_technician_last_name." (".$request->add_technician_id.").",
                    'action_history_log_created_at' => date("Y-m-d H:i:s", strtotime(date("Y/m/d H:i:s")))
                ]
            );
                        
            return response()->json(['message'=>'Technician added successfully!', 'success_flag'=>'1']);
        }else{
            return response()->json(['error'=>'Something went wrong...', 'success_flag'=>'0']);
        }
    }
}
