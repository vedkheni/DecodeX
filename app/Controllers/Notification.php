<?php 
namespace App\Controllers;
use App\Controllers\BaseController;
 
 
class Notification extends BaseController {
    public function index()
    {    
         return view('index');
    }
 
    public function sendPushNotification()
    {  
         
        $val = $this->validate([
            'nId' => 'required',
        ]);
 
        $notification_id = $this->request->getVar('nId');
        $title = 'Demo Notification'; 
        $message = 'First codeigniter notification for mobile';
        $d_type    = $this->request->getVar('device_type');  // for android or IOS
 
        $accesstoken = $this->request->getVar('csrf_test_name');
        $id = 112;
        $URL = 'https://fcm.googleapis.com/fcm/send';
 
 
            $post_data = '{
                "to" : "' . $notification_id . '",
                "data" : {
                  "body" : "",
                  "title" : "' . $title . '",
                  "type" : "' . $d_type . '",
                  "id" : "' . $id . '",
                  "message" : "' . $message . '",
                },
                "notification" : {
                     "body" : "' . $message . '",
                     "title" : "' . $title . '",
                      "type" : "' . $d_type . '",
                     "id" : "' . $id . '",
                     "message" : "' . $message . '",
                    "icon" : "new",
                    "sound" : "default"
                    },
 
              }';
            // print_r($post_data);die;
 
        $crl = curl_init();
 
        $headr = array();
        $headr[] = 'Content-type: application/json';
        $headr[] = 'Authorization: ' . $accesstoken;
        curl_setopt($crl, CURLOPT_SSL_VERIFYPEER, false);
 
        curl_setopt($crl, CURLOPT_URL, $URL);
        curl_setopt($crl, CURLOPT_HTTPHEADER, $headr);
 
        curl_setopt($crl, CURLOPT_POST, true);
        curl_setopt($crl, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
 
        $rest = curl_exec($crl);
 
        if ($rest === false) {
            // throw new Exception('Curl error: ' . curl_error($crl));
            //print_r('Curl error: ' . curl_error($crl));
            $result_noti = 0;
        } else {
 
            $result_noti = 1;
        }
 
        echo view('success');
    }
}