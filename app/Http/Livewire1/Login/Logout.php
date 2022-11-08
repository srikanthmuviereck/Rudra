<?php

namespace App\Http\Livewire\Login;

use Livewire\Component;

use DB;

use Session;

class Logout extends Component
{
    public function render()
    {
        // return view('livewire.login-form')->extends('layouts.login');
    }

    public function getLogin(){

        $token = session()->get('authToken');
        $mail = session()->get('authMail');

        $upd = [
            'token' => ''
        ];

        $chk_super = DB::table('rudhra_adminlogin')->where('email',$mail)->update($upd);
        Session::flush();
        return redirect()->route('login');
    }
}
