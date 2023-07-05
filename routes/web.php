<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\JobOrderController;
use App\Http\Controllers\TechniciansController;
use App\Http\Controllers\ActivitiesController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth/login');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware(['auth']);
Route::get('/profile', [ProfileController::class, 'index'])->name('profile')->middleware(['auth']);
Route::get('/services', [ServicesController::class, 'index'])->name('services')->middleware(['auth']);
Route::get('/technicians', [TechniciansController::class, 'index'])->name('technicians')->middleware(['auth']);
Route::get('/activities', [ActivitiesController::class, 'index'])->name('activities')->middleware(['auth']);
Route::get('/schedule_services', [ServicesController::class, 'index_schedule_services'])->name('schedule_services')->middleware(['auth']);
Route::get('/job_order', [JobOrderController::class, 'index'])->name('job_order')->middleware(['auth']);

Route::get('/get_city/{province_code}', [ProfileController::class, 'get_city'])->middleware(['auth']);
Route::get('/get_barangay/{city_code}', [ProfileController::class, 'get_barangay'])->middleware(['auth']);

Route::post('/upload_partner_profile_user_image', [ProfileController::class, 'upload_partner_profile_user_image'])->middleware(['auth']);
Route::post('/change_password', [ProfileController::class, 'change_password'])->middleware(['auth']);
Route::post('/partnerinformation_update', [ProfileController::class, 'partnerinformation_update'])->middleware(['auth']);
Route::post('/partneraddress_update', [ProfileController::class, 'partneraddress_update'])->middleware(['auth']);

Route::get('/get_technician_details/{id}', [TechniciansController::class, 'get_technician_details'])->middleware(['auth']);(['auth']);
Route::post('/upload_technician_profile_user_image', [TechniciansController::class, 'upload_technician_profile_user_image'])->middleware(['auth']);
Route::post('/technicianinformation_update', [TechniciansController::class, 'technicianinformation_update'])->middleware(['auth']);
Route::post('/technicianinformation_add', [TechniciansController::class, 'technicianinformation_add'])->middleware(['auth']);

Route::post('/services_add', [ServicesController::class, 'services_add'])->middleware(['auth']);
Route::post('/services_update', [ServicesController::class, 'services_update'])->middleware(['auth']);
Route::post('/services_schedule_add', [ServicesController::class, 'services_schedule_add'])->middleware(['auth']);
Route::post('/services_schedule_update', [ServicesController::class, 'services_schedule_update'])->middleware(['auth']);

Route::get('get_services_info/{service_id}', [ServicesController::class, 'get_services_info']);
Route::get('get_events/{date}', [ServicesController::class, 'get_events']);
Route::get('get_booking_info/{booking_id}', [JobOrderController::class, 'get_booking_info']);
Route::get('get_booking_info_for_job_order/{book_sched_id}/{booking_id}', [JobOrderController::class, 'get_booking_info_for_job_order']);
Route::get('get_joborder_info/{jo_id}/{joborder_id}', [JobOrderController::class, 'get_joborder_info']);
Route::get('get_joborder_info_for_edit_assign/{jo_id}/{joborder_id}', [JobOrderController::class, 'get_joborder_info_for_edit_assign']);

Route::post('/add_joborder', [JobOrderController::class, 'add_joborder'])->middleware(['auth']);
Route::post('/edit_joborder', [JobOrderController::class, 'edit_joborder'])->middleware(['auth']);

Auth::routes();

