<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\api101\userController;
use App\Http\Controllers\Api\api101\siteController;
use App\Http\Controllers\Api\api101\SecurityController;

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::middleware('tokenAuth')->group(function(){

    // Get Api's  

    Route::post('/get_buildingslist',[siteController::class,'listbuildings']);
    Route::post('/get_leavereasonslist',[siteController::class,'listleavereasons']);
    Route::post('/get_leaverequestlist',[siteController::class,'listleaverequest']); 
    Route::post('/get_myleaverequestlist',[siteController::class,'listmyleaverequest']);
    Route::post('/get_notificationslist',[siteController::class, 'listnotifications']);
    Route::post('/get_securityworkdtlslist',[siteController::class, 'listsecurityworkdtls']);
    Route::post('/get_securityworkdtlsbydate',[siteController::class, 'listsecurityworkdtlsbydate']);
	Route::post('/get_secutiylocationsbymap',[siteController::class, 'listsecutiylocationsbymap']);
	
	Route::post('/sp_visit_notify',[siteController::class, 'sp_visit_notify']);
	
    Route::post('/get_lastworklocation',[siteController::class, 'lastworklocation']);
    Route::post('/get_securiteslist',[userController::class, 'listsecurites']);

    // Submit Api's

    Route::post('/submit_leaverequest',[siteController::class, 'save_leaverequest']);
    Route::post('/approve_leaverequest',[siteController::class, 'approve_leaverequest']);
    Route::post('/submit_securitylocation',[siteController::class, 'save_worklocations']);
	Route::post('/submit_supervisorlocation',[siteController::class, 'save_spvr_worklocations']);
    Route::post('/assign_building',[userController::class, 'assignBuilding']);

    // App Details
    
    Route::post('/get_companydetails',[siteController::class, 'company_dtls']);
    Route::post('/get_appupdate',[siteController::class, 'setting_app_update']);

    // Work Api's

    Route::post('/security_worklogin',[userController::class, 'worklogin']);
    Route::post('/security_worklogout',[userController::class, 'worklogout']);
	
	Route::post('/submit_field_tracking',[siteController::class, 'save_field_tracking']);

    // Logout

    Route::post('/logout',[userController::class, 'userlogout']);


    Route::post('/Security_assign_buildings',[SecurityController::class, 'assign_buildings']);
    
});


Route::middleware('jwtAuth')->group(function(){
    Route::post('/login',[userController::class, 'userlogin']);
});

// Route::post('/Security_assign_buildings',[SecurityController::class, 'assign_buildings']);