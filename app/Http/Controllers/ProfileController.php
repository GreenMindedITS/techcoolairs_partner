<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Auth;

class ProfileController extends Controller
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

        $partner_info = DB::select(DB::raw("SELECT * FROM `tbl_partner` WHERE partner_id = '$user->user_id'"));
        $partner_address_info = DB::select(DB::raw("SELECT a.partner_id, b.*, c.citymunCode, d.citymunDesc, d.provCode, e.provDesc FROM `tbl_partner` a, `tbl_partner_address` b, `tbl_brgy` c, `tbl_city` d, `tbl_province` e WHERE a.partner_id = b.partner_id AND b.id_barangay = c.id_barangay AND c.citymunCode = d.citymunCode AND d.provCode = e.provCode AND a.partner_id = '$user->user_id'"));
        $partner_image = DB::select(DB::raw("SELECT * FROM `tbl_user_profile_image` WHERE user_id = '$user->user_id'"));

        $province_code = $partner_address_info[0]->provCode;
        $province_list = DB::select(DB::raw("SELECT a.provCode, a.provDesc, b.citymunCode FROM `tbl_province` a, `tbl_city` b WHERE a.provCode = b.provCode AND a.provCode NOT IN ($province_code) GROUP BY a.provCode"));
        $technician_count = DB::select(DB::raw("SELECT COUNT(*) as number_of_technicians FROM `tbl_partner` a, `tbl_technician_partner` b WHERE a.partner_id = b.partner_id AND a.partner_id = '$user->user_id'"));

        return view('profile', [
            "partner_info" => $partner_info,
            "partner_image" => $partner_image,
            "partner_address_info" => $partner_address_info,
            "province_list" => $province_list,
            "technician_count" => $technician_count
        ]);
    }

    /**
     * Profile Picture
     *
     */

    public function upload_partner_profile_user_image(Request $request)
    {
        $user = auth()->user();
        $partner_id = $request->partner_id;
        $filename = time()."_part_".$request->input_file[0]->getClientOriginalName();

        // dd($request->all());

        $user_profile = DB::select(DB::raw("SELECT * FROM `tbl_user_profile_image` WHERE user_id = '$partner_id'"));
        
        if($user_profile){
            $path = Storage::disk('do_spaces')->putFileAs('cleaningapp-profile-images', $request->input_file[0], $filename, 'public');
            $profile_image_change = DB::table('tbl_user_profile_image')
                ->where('user_id', $partner_id)
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
                    'user_id' => $partner_id,
                    'user_profile_image' => $filename,
                    'user_profile_image_created_at' => date("Y-m-d H:i:s", strtotime(date("Y/m/d H:i:s")))
                ]
            );
        }

        // $request->input_file[0]->move(public_path('img/'), $filename);

        if($profile_image_change){
            DB::table('tbl_action_history')->insert(
                [
                    'act_history_id' => NULL,
                    'user_id' => $partner_id,
                    'action_history_activitiy' => "Uploaded profile image.",
                    'action_history_log_created_at' => date("Y-m-d H:i:s", strtotime(date("Y/m/d H:i:s")))
                ]
            );
                
            return response()->json(['message'=>'Partner profile image updated successfully!', 'success_flag'=>'1']);
        }else{
            return response()->json(['error'=>'Something went wrong...', 'success_flag'=>'0']);
        }
    }

    /**
     * Change Password
     *
     */

    public function change_password(Request $request)
    {
        $user = auth()->user();

        $current_password = $request->current_password;
        $new_password = $request->new_password;
        
        $user_info = DB::select(DB::raw("SELECT * FROM `users` WHERE id = $user->id"));

        if(!(Hash::check($current_password, $user_info[0]->password))){            
            return response()->json(['message'=>'Invalid current password inputted.', 'password_mismatch'=>'1']);
        }

        $update_password = DB::table('users')
            ->where('id', $user->id)
            ->update([
                'password' => Hash::make($new_password),
                'updated_at' => date("Y-m-d H:i:s", strtotime(date("Y/m/d H:i:s")))
            ]);

        if($update_password){
            DB::table('tbl_action_history')->insert(
                [
                    'act_history_id' => NULL,
                    'user_id' => $user_info[0]->user_id,
                    'action_history_activitiy' => "Changed Password.",
                    'action_history_log_created_at' => date("Y-m-d H:i:s", strtotime(date("Y/m/d H:i:s")))
                ]
            );
            
            return response()->json(['message'=>'Password changed successfully!', 'password_mismatch'=>'0']);
        }else{
            return response()->json(['error'=>'Something went wrong...', 'password_mismatch'=>'0']);
        }
    }

    public function partnerinformation_update(Request $request)
    {
        $user = auth()->user();
        
        $partner_update = DB::table('tbl_partner')
            ->where('partner_id', $request->partner_id)
            ->update([
                'partner_company_name' => $request->partner_company_name,
                'partner_person_in_charge' => $request->partner_person_in_charge,
                'partner_email_address' => $request->partner_email_address,
                'partner_contact_number' => $request->partner_contact_number,
                'partner_updated_at' => date("Y-m-d H:i:s", strtotime(date("Y/m/d H:i:s")))
            ]);

        $partner_update_users = DB::table('users')
            ->where('user_id', $request->partner_id)
            ->update([
                'name' => $request->partner_company_name,
                'updated_at' => date("Y-m-d H:i:s", strtotime(date("Y/m/d H:i:s")))
            ]);

        if($partner_update_users){
            DB::table('tbl_action_history')->insert(
                [
                    'act_history_id' => NULL,
                    'user_id' => $request->partner_id,
                    'action_history_activitiy' => "Updated partner information.",
                    'action_history_log_created_at' => date("Y-m-d H:i:s", strtotime(date("Y/m/d H:i:s")))
                ]
            );
                        
            return response()->json(['message'=>'Partner information updated successfully!', 'success_flag'=>'1']);
        }else{
            return response()->json(['error'=>'Something went wrong...', 'success_flag'=>'0']);
        }
    }

    public function get_city($province_code){
        $city_list = DB::select(DB::raw("SELECT * FROM `tbl_city` WHERE provCode = '$province_code'"));

        return $city_list;
    }

    public function get_barangay($city_code){
        $barangay_list = DB::select(DB::raw("SELECT * FROM `tbl_brgy` WHERE citymunCode = '$city_code'"));

        return $barangay_list;
    }

    public function partneraddress_update(Request $request){
        $user = auth()->user();

        // print_r($request->all());

        $partner_address_update = DB::table('tbl_partner_address')
            ->where('partner_id', $request->partner_id)
            ->update([
                'partner_address' => $request->partner_address,
                'id_barangay' => $request->select_barangay,
                'partner_address_zip_code' => $request->zip_code,
                'partner_address_map_latitude' => $request->latitude,
                'partner_address_map_longitude' => $request->longitude,
                'partner_address_status' => "active",
                'partner_address_updated_at' => date("Y-m-d H:i:s", strtotime(date("Y/m/d H:i:s")))
            ]);

        if($partner_address_update){
            DB::table('tbl_action_history')->insert(
                [
                    'act_history_id' => NULL,
                    'user_id' => $request->partner_id,
                    'action_history_activitiy' => "Updated partner address.",
                    'action_history_log_created_at' => date("Y-m-d H:i:s", strtotime(date("Y/m/d H:i:s")))
                ]
            );
                        
            return response()->json(['message'=>'Partner address updated successfully!', 'success_flag'=>'1']);
        }else{
            return response()->json(['error'=>'Something went wrong...', 'success_flag'=>'0']);
        }
    }
}
