<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\AdminControllers\MediaController;
use App\Models\Core\Images;
use App\Models\Core\Setting;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Lang;
use Mail;

class AppSettingController extends Controller
{

    public function apiAuthenticate($consumer_data)
    {



        
        $settings = $this->getSetting();

        //return $settings;

        $callExist = DB::table('api_calls_list')
           
            ->get();

                
            

        $ip = '198.0.0.1';
        $device_id = 1220;

      

        $http_call_record = DB::table('http_call_record')->where('ip', $ip)->orderBy('ping_time', 'desc')->first();
        if ($http_call_record == null) {
            $last_ping_time = Carbon::now();
            $difference_from_previous = 0;
        } else {
            $last_ping_time = $http_call_record->ping_time;
            $difference_from_previous = $http_call_record->difference_from_previous;

        }
       /*  $date = new Carbon(Carbon::now()->toDateTimeString());

        $difference = $date->floatDiffInSeconds($last_ping_time);

        DB::table('http_call_record')
            ->insert([
                'ip' => $ip,
                'device_id' => $device_id,
                'url' => $consumer_data['consumer_url'],
                'ping_time' => Carbon::now(),
                'difference_from_previous' => $difference,
            ]); */

        $time_taken = DB::table('http_call_record')->where('url', $consumer_data['consumer_url'])->where('ip', $ip)->take(10)->sum('difference_from_previous');
        $record_count = DB::table('http_call_record')->where('ip', $ip)->count();


        if(md5($settings['consumer_key']) == $consumer_data['consumer_key'] &&
            md5($settings['consumer_secret']) == $consumer_data['consumer_secret']


             ){
                 
       
            
            return '1';
        }else{


              if($record_count >= 1000 && $time_taken <=60 ){
                     DB::table('http_call_record')->where('url',$consumer_data['consumer_url'])->where('ip',$ip)->delete();
        
                DB::table('block_ips')
                      ->insert([
                            'ip' => $ip,
                            'device_id' => $device_id,
                     'created_at' => Carbon::now()
                        ]);
                    return '0';
                 }else{
                     return '0';
                 }
        }
    }

    public function getlanguages()
    {
        $consumer_data = array();
        $consumer_data['consumer_key'] = request()->header('consumer-key');
        $consumer_data['consumer_secret'] = request()->header('consumer-secret');
        $consumer_data['consumer_nonce'] = request()->header('consumer-nonce');
        $consumer_data['consumer_device_id'] = 1220;
        $consumer_data['consumer_ip'] = '198.0.0.1';
        $consumer_data['consumer_url'] = __FUNCTION__;

        $authenticate = $this->apiAuthenticate($consumer_data);

        if ($authenticate == 1) {
            $languages = DB::table('languages')
            ->LeftJoin('image_categories', function ($join) {
                $join->on('image_categories.image_id', '=', 'languages.image')
                    ->where(function ($query) {
                        $query->where('image_categories.image_type', '=', 'THUMBNAIL')
                            ->where('image_categories.image_type', '!=', 'THUMBNAIL')
                            ->orWhere('image_categories.image_type', '=', 'ACTUAL');
                    });
              })->select('languages.*', 'image_categories.path as image')->get();
            $responseData = array('success' => '1', 'languages' => $languages, 'message' => "Returned all languages.");
        } else {
            $responseData = array('success' => '0', 'languages' => array(), 'message' => "Unauthenticated call.");
        }

        $categoryResponse = json_encode($responseData);
        print $categoryResponse;
	}
	
  
	
    public function getSetting()
    {
        $setting = DB::table('settings')->get();

        $result = array();

        foreach ($setting as $settings) {

            $name = $settings->name;
            $value = $settings->value;
            $result[$name] = $value;
        }
        return $result;
    }

    public function sitesetting()
    {

        $consumer_data = array();
        $consumer_data['consumer_key'] = request()->header('consumer-key');
        $consumer_data['consumer_secret'] = request()->header('consumer-secret');
        //$consumer_data['consumer_nonce'] = request()->header('consumer-nonce');
        $consumer_data['consumer_device_id'] = 1220;
        $consumer_data['consumer_ip'] = '198.0.0.1';
        $consumer_data['consumer_url'] = __FUNCTION__;

        $authenticate = $this->apiAuthenticate($consumer_data);

        /* if ($authenticate == 1) { */
            $settings = $this->getSetting();
            $responseData = array('success' => '1', 'data' => $settings, 'message' => "Returned all site data.");
        /* } else {
            $responseData = array('success' => '0', 'languages' => array(), 'message' => "Unauthenticated call.");
        } */
        $categoryResponse = json_encode($responseData);
        print $categoryResponse;
    }

    

    

    


}
