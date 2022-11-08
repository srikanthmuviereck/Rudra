<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;

use DB;
use App\Models\Tables\securityModel;

class Notification extends Component
{
    public $not_id, $not_type,$not_title,$not_msg;

    protected $rules = [
        'not_type' => 'required',
        'not_title' => 'required',
        'not_msg' => 'required',
    ];

    protected $messages = [
        'not_type.required' => 'This Field is Mandatory',
        'not_title.required' => 'This Field is Mandatory',
        'not_msg.required' => 'This Field is Mandatory',
    ];

    protected $listeners = ['deleteNotify'];

    public function render()
    {
        return view('livewire.dashboard.notification')->extends('layouts.main');
    }

    public function addnewNotification()
    {
        $this->validate();

        $insNotify = [
            'title' => $this->not_title,
            'message' => $this->not_msg,
            'type' => 'normal',
            'user_type' => $this->not_type,
        ];

        $insertNot = DB::table('notification')->insertGetId($insNotify);

        //

        if($insertNot > 0){
            

            $get_where = DB::table('notification')->where('id', $insertNot)->get();
            
            foreach($get_where as $where){

                $name = $where->title;
                $message = $where->message;
                $type = $where->type;
                // $image = $where->image;
                $user_type = $where->user_type;
                
            }

            if($user_type == 'security'){

                $get_fcm_id = securityModel::select('fcm_id')->get();

            }elseif($user_type == 'Operation Team'){

                $get_fcm_id = DB::table('supervisor')->select('fcm_id')->get();

            }else{
                $get_fcm_id = DB::table('client')->select('fcm_id')->get();
            }

            $title   = $name;
            $body    = $message;
            $tmp_img = '';

            $click = !empty($this->not_gym)?$this->not_gym:'';

            if($get_fcm_id->count() > 0){

                $fcm_ids = json_decode($get_fcm_id);
                
                //dd($fcm_ids);

                $this->sendPush($fcm_ids, $title, $body);

                session()->flash('notifyMessage', 'Notification Send successfully!');
                return redirect()->to('notification');   
                
            }else{
                session()->flash('notifyMessage', 'Notification Send Failed, No Active Customers!');
                return redirect()->to('notification');
            }
        }else{
            session()->flash('notifyMessage', 'Notification Send Failed!');
            return redirect()->to('notification');
        }
        
    }

    public function sendPush(array $fcm, $title, $body)
    {

        $get_server_key = 'AAAAJFP-zhI:APA91bHNXwX71Q_-QJ4Qtm041Toq8ubxeJK8_HTT4zOu-LX-4LEoReKPRnJGyGOJKpBBYr_LPb32vadPYd2N6RTCkQq-uduszUlQFXD2bFJnC6_fG4g6Tb0_159WxrX4951TGM-baMZj';

        $get_fcm_id = $fcm;

        $tmpid=  rand(1000,9909);

        foreach($get_fcm_id as $fcm){


            $json_data =[
                "to" => $fcm->fcm_id,
                    "data"=>[
                        "android_channel_id"=>"default",
                        "title"=>$title,
                        "body"=>$body,
                        "image"=>'',
                           "tag"=>$tmpid,
                        "click_action"=>'normal',
                        ],
                    "notification"=>[
                        "android_channel_id"=>"default",
                        "title"=>$title,
                        "body"=>$body,
                        "image"=>'',
                        "tag"=>$tmpid,
                        "click_action"=>'normal',
                    ]
                ];

           $data = json_encode($json_data);
           //FCM API end-point
           $url = 'https://fcm.googleapis.com/fcm/send';
           //api_key in Firebase Console -> Project Settings -> CLOUD MESSAGING -> Server key
          
           //header with content_type api key
           $headers = array(
               'Content-Type:application/json',
               'Authorization:key='.$get_server_key
           );
           //CURL request to route notification to FCM connection server (provided by Google)
           $ch = curl_init();
           curl_setopt($ch, CURLOPT_URL, $url);
           curl_setopt($ch, CURLOPT_POST, true);
           curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
           curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
           curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
           curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
           curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
           $result = curl_exec($ch);
           $err = curl_error($ch);

           if ($err) {
               return $err;
           }

        }
        curl_close($ch);
    }

    public function deleteNotify($obj)
    {
        $nId = $obj['id'];
        $this->not_id = $nId;
        $this->dispatchBrowserEvent('notifyDelete');
    }

    public function removeNot()
    {
        DB::table('notification')->where('id', $this->not_id)->delete();
        session()->flash('notifyMessage', 'Notification Deleted successfully!');
        return redirect()->to('/notification');
    }

    public function closeModal()
    {
        $this->resetErrorBag();
        
        $this->not_id = '';
        $this->not_type = '';
        $this->not_title = '';
        $this->not_msg = '';
    }

}
