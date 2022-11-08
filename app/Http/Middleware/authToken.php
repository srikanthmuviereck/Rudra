<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

use DB;

class authToken
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

        if($request->session()->has('authToken') != '' && $request->session()->has('authMail')){

            $token = $request->session()->get('authToken');
            $mail = $request->session()->get('authMail');

            $get_sess = DB::table('rudhra_adminlogin')->where('token',$token)->where('email',$mail)->get();

            if($get_sess->count() > 0){
                if($request->path() == 'admin-login'){
                    return redirect()->route('welcome');
                }else{
                    return $next($request);
                }
            }else{
                return redirect()->route('login');
            }
        }else{
            return redirect()->route('login');
        }        
    }
}
