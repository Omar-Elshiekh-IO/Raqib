<?php

use App\Http\Controllers\Api\V1\ApiAuthController;
use App\Http\Controllers\Api\V1\AttendanceEmployeeController;
use App\Http\Controllers\Api\V1\BusinessMissionController;
use App\Http\Controllers\Api\V1\DashboardController;
use App\Http\Controllers\Api\V1\ExcuseController;
use App\Http\Controllers\Api\V1\LeaveController;
use App\Http\Controllers\Api\V1\LoanController;
use Doctrine\DBAL\Schema\Index;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
// Route::post('login', [ApiController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function () {

    // Route::post('logout', [ApiController::class, 'logout']);
    Route::get('get-projects', [ApiController::class, 'getProjects']);
    Route::post('add-tracker', [ApiController::class, 'addTracker']);
    Route::post('stop-tracker', [ApiController::class, 'stopTracker']);
    Route::post('upload-photos', [ApiController::class, 'uploadImage']);
});

Route::prefix("v1")->group(function(){
  Route::post('login',[ApiAuthController::class,'login']);

  Route::middleware(['auth:sanctum'])->group(function(){

    Route::get('employee',[DashboardController::class,'index'])->middleware('permission:show hrm dashboard');

    Route::post('attendance/check-in',[AttendanceEmployeeController::class,'checkIn']);
    Route::put('attendance/check-out',[AttendanceEmployeeController::class,'checkOut']);

    Route::prefix('excuse')->group(function(){
      Route::get('/',[ExcuseController::class,'index'])->middleware('permission:view excuse|manage excuse');
      Route::post('/store',[ExcuseController::class,'store'])->middleware('permission:create excuse|manage excuse');
      Route::put('/{id}',[ExcuseController::class,'update'])->middleware('permission:edit excuse|manage excuse');
      Route::delete('/{id}',[ExcuseController::class,'destroy'])->middleware('permission:delete excuse|manage excuse');
      Route::put('/{id}/approve',[ExcuseController::class,'action'])->middleware('permission:approve excuse|manage excuse');
      Route::put('/{id}/reject',[ExcuseController::class,'action'])->middleware('permission:approve excuse|manage excuse');
      Route::get('/pending-approvals',[ExcuseController::class,'pendingApprovals'])->middleware('permission:manage excuse');
    });

    Route::prefix('leave')->group(function(){
      Route::get('/',[LeaveController::class,'index'])->middleware('permission:view leave|manage leave');
      Route::post('/store',[LeaveController::class,'store'])->middleware('permission:create leave|manage leave');
      Route::put('/{id}',[LeaveController::class,'update'])->middleware('permission:edit leave|manage leave');
      Route::delete('/{id}',[LeaveController::class,'destroy'])->middleware('permission:delete leave|manage leave');
      Route::put('/{id}/approve',[LeaveController::class,'action'])->middleware('permission:approve leave|manage leave');
      Route::put('/{id}/reject',[LeaveController::class,'action'])->middleware('permission:approve leave|manage leave');
      Route::get('/pending-approvals',[LeaveController::class,'pendingApprovals'])->middleware('permission:manage leave');
    });

    Route::prefix('loan')->group(function(){
      Route::get('/',[LoanController::class,'index'])->middleware('permission:view loan|manage loan');
      Route::post('/store',[LoanController::class,'store'])->middleware('permission:create loan|manage loan');
      Route::put('/{id}',[LoanController::class,'update'])->middleware('permission:edit loan|manage loan');
      Route::delete('/{id}',[LoanController::class,'destroy'])->middleware('permission:delete loan|manage loan');
      Route::put('/{id}/approve',[LoanController::class,'action'])->middleware('permission:approve loan|manage loan');
      Route::put('/{id}/reject',[LoanController::class,'action'])->middleware('permission:approve loan|manage loan');
      Route::get('/pending-approvals',[LoanController::class,'pendingApprovals'])->middleware('permission:manage loan');
    });

    Route::prefix('business-mission')->group(function(){
      Route::get('/',[BusinessMissionController::class,'index'])->middleware('permission:view business mission|manage business mission');
      Route::post('/store',[BusinessMissionController::class,'store'])->middleware('permission:create business mission|manage business mission');
      Route::put('/{id}',[BusinessMissionController::class,'update'])->middleware('permission:edit business mission|manage business mission');
      Route::delete('/{id}',[BusinessMissionController::class,'destroy'])->middleware('permission:delete business mission|manage business mission');
      Route::put('/{id}/approve',[BusinessMissionController::class,'action'])->middleware('permission:approve business mission|manage business mission');
      Route::put('/{id}/reject',[BusinessMissionController::class,'action'])->middleware('permission:approve business mission|manage business mission');
      Route::get('/pending-approvals',[BusinessMissionController::class,'pendingApprovals'])->middleware('permission:manage business mission');
    });

  });
});