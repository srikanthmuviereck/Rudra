<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
Use DB;
class Contactus extends Component
{
          public $terms, $privacy, $abt, $mobile,$whatsapp,$mail;

    public $admin_email_new, $admin_pass_new ,$admin_mail,$admin_super, $admin_pass, $admin_id;
        
protected $rules = [
        'mobile' => 'required|numeric|digits:10',
        'whatsapp' => 'required|numeric|digits:10',
        'mail' => 'required|email',        
    ];

    protected $messages = [
        'mobile.required' => 'This Field is Mandatory',
        'whatsapp.required' => 'This Field is Mandatory',
        'mail.required' => 'This Field is Mandatory',   
    ];

    public function render()
    {
      
      
      
        $get_admin_dtl = DB::table('rudhra_adminlogin')->select('*')->get();  
        return view('livewire.dashboard.contactus')->extends('layouts.main');
    }
 public function updContactUS()
    {

        // dd(1);

        $this->validate();

        $mble = [
            'value' => $this->mobile
        ];
        $email = [
            'value' => $this->mail
        ];

        $whatsapp = [
            'value' => $this->whatsapp
        ];

        $upd_phone = DB::table('settings')->where('field','phone')->update($mble);
        $upd_mail = DB::table('settings')->where('field','mail')->update($email);
        $upd_wapp = DB::table('settings')->where('field','whatsapp')->update($whatsapp);

        session()->flash('settingMessage', 'Contact US  Updated Successfully!');
        return redirect()->to('others');
        
    }


public function mount()
  {
  $get_phone = DB::table('settings')->select('value')->where('field','phone')->get();
        $get_mail = DB::table('settings')->select('value')->where('field','mail')->get();
        $get_wapp = DB::table('settings')->select('value')->where('field','whatsapp')->get();


        foreach($get_phone as $phone){
            $mble = $phone->value;
        }

        foreach($get_mail as $mail){
            $email = $mail->value;
        }

        foreach($get_wapp as $wapp){
            $whatsapp = $wapp->value;
        }
        // dd(1);

        $this->mobile = $mble;
        $this->mail = $email;
        $this->whatsapp = $whatsapp;
   
  }


    public function editAdminUser($aid)
    {
        $this->admin_id = $aid;

        $get_admin_dtl = DB::table('rudhra_adminlogin')->where('id', $aid)->get();

        if($get_admin_dtl->count() > 0){

            foreach($get_admin_dtl as $admin){

                $email = $admin->email;
                $super = $admin->superuser;

            }

            $this->admin_mail = $email;
            $this->admin_super = !empty($super)?$super:"";

        }else{
            session()->flash('settingMessage', 'No Users Found!');
            return redirect()->to('others');
        }
    }

     public function getDtl()
    {

      
    }
    
}
