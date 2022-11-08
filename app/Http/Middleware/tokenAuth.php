<?php

namespace App\Http\Middleware;

use Closure;

use Illuminate\Http\Request;

use DB;
use App\Models\Tables\securityModel;
use App\Models\Tables\supervisorModel;
use App\Models\Tables\clientModel;

class tokenAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(!empty($request->user_id) && !empty($request->token) && !empty($request->user_type)){

            $user_id = $request->user_id;
            $token = $request->token;
            $u_type = $request->user_type;

            if($u_type == 'SCRT'){
                $get_dtl = securityModel::select('*')->where('scrt_id', '=', $user_id)->where('api_token',$token)->get();
            }elseif ($u_type == 'SPVR') {
                $get_dtl = supervisorModel::select('*')->where('spvr_id', '=', $user_id)->where('api_token',$token)->get();                
            }elseif ($u_type == 'CLNT') {
                $get_dtl = clientModel::select('*')->where('clnt_id', '=', $user_id)->where('api_token',$token)->get();                
            }else{
                return response()->json([
                    'error'=>true,
                    'code'=>201,
                    'message'=>'Unknown User Type!'                      
                ]);
            }

            if($get_dtl->count() == 0){

                return response()->json([
                    'error'=>true,'code'=>401,'message'=>'Not a Valid User!'
                ]);
                exit;
            }else{

                return $next($request);
            }
        }else{

            return response()->json([
                'error'=>true,'code'=>401,'message'=>'Please Fill Mandatory Fields!'
            ]);
            exit;

        }
        // 
    }
}
