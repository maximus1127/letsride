<?php

namespace App\Models\AppModels;

use App\Http\Controllers\App\AlertController;
use App\Http\Controllers\App\AppSettingController;
use Auth;
use DB;
use File;
use Hash;
use App\User;
use App\ProductStock;
use Carbon\Carbon;
use App\Models\AppModels\Driver;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{


    protected $table = 'drivers';

    //adding one to many relationship between the Users table and the wallet
    public function wallet(){
        return $this->hasMany('App\Models\AppModels\Newwallet');

    }





    public static function getuserinfo($request){


        $consumer_data = array();
        $consumer_data['consumer_key'] = request()->header('consumer-key');
        $consumer_data['consumer_secret'] = request()->header('consumer-secret');
        $consumer_data['consumer_nonce'] = request()->header('consumer-nonce');
        //$consumer_data['consumer_device_id'] = request()->header('consumer-device-id');
        //$consumer_data['consumer_ip'] = request()->header('consumer-ip');
        // $consumer_data['consumer_ip'];
        $consumer_data['consumer_url'] = __FUNCTION__; // 'processlogin' is returns here
        $authController = new AppSettingController();
        
        $authenticate = $authController->apiAuthenticate($consumer_data);

        if ($authenticate == 1){ 

            $id = $request->id;

            $userData = DB::table('users')->where('id', $id)->where('role_id', '2')->get();

            return $userData;

            $responseData = array('success' => '1', 'data' => $userData, 'message' => "Sign Up successfully!");  

        }

        $userResponse = json_encode($responseData);
        print $userResponse;

    }



    public static function getdriverallinfo(){
        $consumer_data = array();
        $consumer_data['consumer_key'] = request()->header('consumer-key');
        $consumer_data['consumer_secret'] = request()->header('consumer-secret');
        $consumer_data['consumer_nonce'] = request()->header('consumer-nonce');
        //$consumer_data['consumer_device_id'] = request()->header('consumer-device-id');
        //$consumer_data['consumer_ip'] = request()->header('consumer-ip');
        // $consumer_data['consumer_ip'];
        $consumer_data['consumer_url'] = __FUNCTION__; // 'processlogin' is returns here
        $authController = new AppSettingController();
        
        $authenticate = $authController->apiAuthenticate($consumer_data);

        if ($authenticate == 1){ 

          

            $token                          =       request()->header('Authorization');
            $int = (int) filter_var($token, FILTER_SANITIZE_NUMBER_INT);

            //return $int;


            $existUser = DB::table('users')->where('id', $int)->get();
            $salesRepSales = DB::table('salesRepSales')->where('user_id', $int)->get();

             $fname =  $existUser->pluck('first_name')->last();
             $lname = $existUser->pluck('last_name')->last();


            if (count($existUser) > 0) {  

                $usersc = User::find($int);


                $currentMonth = date('m');
                $mymonthlytarget = ProductStock::whereRaw('MONTH(created_at) = ?',[$currentMonth])->where('user_id', $int)->where('status', 1)->sum('target');

                //$request1 =  $usersc->productStock->where('status', 1)->whereRaw('MONTH(created_at) = ?',[$currentMonth])->sum('target');
                //$today = Carbon::now()->toDateTimeString();
                //return $request;
    

                //return $usersc->sales;

                $valueto = array([
                'mytarget' => $mymonthlytarget,
                'totaltarget' => $usersc->sales->sum('bagsout'),
                'recenttarget' => $usersc->productStock->pluck('target')->last(),
                'bagsout'    => $usersc->sales->pluck('bagsout')->last(),
                'firstname' =>  $fname,
                'lastname' => $lname,
                'totalsales' =>  $salesRepSales->sum('sales')



               ]);

                $responseData = array('success' => '1', 'data' => $valueto, 'message' => "Wallet retrived!");  

            }

          

        }

        $userResponse = json_encode($responseData);
        print $userResponse;
    }

























    public static function getSales(){
        $consumer_data = array();
        $consumer_data['consumer_key'] = request()->header('consumer-key');
        $consumer_data['consumer_secret'] = request()->header('consumer-secret');
        $consumer_data['consumer_nonce'] = request()->header('consumer-nonce');
        //$consumer_data['consumer_device_id'] = request()->header('consumer-device-id');
        //$consumer_data['consumer_ip'] = request()->header('consumer-ip');
        // $consumer_data['consumer_ip'];
        $consumer_data['consumer_url'] = __FUNCTION__; // 'processlogin' is returns here
        $authController = new AppSettingController();
        
        $authenticate = $authController->apiAuthenticate($consumer_data);

        if ($authenticate == 1){ 

          

            $token                          =       request()->header('Authorization');
            $int = (int) filter_var($token, FILTER_SANITIZE_NUMBER_INT);

            //return $int;


            //$existUser = DB::table('salesRepSales')->where('id', $int)->get();

            $salesRepSales = DB::table('salesRepSales')->where('user_id', $int)->get();

            // $fname =  $existUser->pluck('first_name')->last();
            // $lname = $existUser->pluck('last_name')->last();


            if (count($salesRepSales) > 0) {  

                $responseData = array('success' => '1', 'data' => $salesRepSales, 'message' => "TRANSACTIONS retrived!");  

            }

          

        }

        $userResponse = json_encode($responseData);
        print $userResponse;
    }






















 //GET RIDE INFO SECTION

    public static function getrideinfo($request){


        $consumer_data = array();
        $consumer_data['consumer_key'] = request()->header('consumer-key');
        $consumer_data['consumer_secret'] = request()->header('consumer-secret');
        $consumer_data['consumer_nonce'] = request()->header('consumer-nonce');
        //$consumer_data['consumer_device_id'] = request()->header('consumer-device-id');
        //$consumer_data['consumer_ip'] = request()->header('consumer-ip');
        // $consumer_data['consumer_ip'];
        $consumer_data['consumer_url'] = __FUNCTION__; // 'processlogin' is returns here
        $authController = new AppSettingController();


       // return $request->page;
        
        $authenticate = $authController->apiAuthenticate($consumer_data);

        if ($authenticate == 1){ 

          // return $request->status;

            $token                          =       request()->header('Authorization');
            //remove bearer character from token
            $int = (int) filter_var($token, FILTER_SANITIZE_NUMBER_INT);

            //return "getting";

            $id = $request->id;

            $userData = DB::table('drivers')->where('token', $int)->get();

           //  return $userData;

            $responseData = array('success' => '1', 'data' => $userData, 'message' => "Sign Up successfully!");  

        }

        $userResponse = json_encode($responseData);
        print $userResponse;

    }















    //GET RIDE INFO SECTION

    public static function getridestatus($request){


        $consumer_data = array();
        $consumer_data['consumer_key'] = request()->header('consumer-key');
        $consumer_data['consumer_secret'] = request()->header('consumer-secret');
        $consumer_data['consumer_nonce'] = request()->header('consumer-nonce');
        //$consumer_data['consumer_device_id'] = request()->header('consumer-device-id');
        //$consumer_data['consumer_ip'] = request()->header('consumer-ip');
        // $consumer_data['consumer_ip'];
        $consumer_data['consumer_url'] = __FUNCTION__; // 'processlogin' is returns here
        $authController = new AppSettingController();
        
        $authenticate = $authController->apiAuthenticate($consumer_data);

        if ($authenticate != 1){ 

           // return $request->status;



            $token             =       request()->header('Authorization');
            //remove bearer character from token
            $int = (int) filter_var($token, FILTER_SANITIZE_NUMBER_INT);

            //return "getting";

            $id = $request->id;

            $userData = DB::table('drivers')->where('token', $int)->where('status',$request->status)->get();

           //  return $userData;

            $responseData = array('success' => '1', 'data' => $userData, 'message' => "Sign Up successfully!");  

        }

        $userResponse = json_encode($responseData);
        print $userResponse;

    }
















    public static function processlogin($request)
    {
        $consumer_data = array();
        $consumer_data['consumer_key'] = request()->header('consumer-key');
        $consumer_data['consumer_secret'] = request()->header('consumer-secret');
        $consumer_data['consumer_nonce'] = request()->header('consumer-nonce');
        //$consumer_data['consumer_device_id'] = request()->header('consumer-device-id');
        //$consumer_data['consumer_ip'] = request()->header('consumer-ip');
        // $consumer_data['consumer_ip'];
        $consumer_data['consumer_url'] = __FUNCTION__; // 'processlogin' is returns here
        $authController = new AppSettingController();
        
        $authenticate = $authController->apiAuthenticate($consumer_data);

        if ($authenticate == 1){ 

            $email = $request->email;
            $password = $request->password;

            $customerInfo = array("email" => $email, "password" => $password, 'role_id' => 2);
            
            if (Auth::attempt($customerInfo)) {


                

                $existUser = DB::table('users')
                    ->where('email', $email)->where('status', '1')->get();
               // return $existUser;

                if (count($existUser) > 0) {

                    $customers_id = $existUser[0]->id;

                    //update record of customers_info
                    $existUserInfo = DB::table('customers_info')->where('customers_info_id', $customers_id)->get();
                    $customers_info_id = $customers_id;
                    $customers_info_date_of_last_logon = date('Y-m-d H:i:s');
                    $customers_info_number_of_logons = '1';
                    $customers_info_date_account_created = date('Y-m-d H:i:s');
                    $global_product_notifications = '1';

                    if (count($existUserInfo) > 0) {
                        //update customers_info table
                        DB::table('customers_info')->where('customers_info_id', $customers_info_id)->update([
                            'customers_info_date_of_last_logon' => $customers_info_date_of_last_logon,
                            'global_product_notifications' => $global_product_notifications,
                            'customers_info_number_of_logons' => DB::raw('customers_info_number_of_logons + 1'),
                        ]);

                    } else {
                        //insert customers_info table
                        $customers_default_address_id = DB::table('customers_info')->insertGetId(
                            ['customers_info_id' => $customers_info_id,
                                'customers_info_date_of_last_logon' => $customers_info_date_of_last_logon,
                                'customers_info_number_of_logons' => $customers_info_number_of_logons,
                                'customers_info_date_account_created' => $customers_info_date_account_created,
                                'global_product_notifications' => $global_product_notifications,
                            ]
                        );

                        DB::table('users')->where('id', $customers_id)->update([
                            'default_address_id' => $customers_default_address_id,
                        ]);
                    }

                    //check if already login or not
   /*                  $already_login = DB::table('whos_online')->where('customer_id', '=', $customers_id)->get();

                    if (count($already_login) > 0) {
                        DB::table('whos_online')
                            ->where('customer_id', $customers_id)
                            ->update([
                                'full_name' => $existUser[0]->first_name . ' ' . $existUser[0]->last_name,
                                'time_entry' => date('Y-m-d H:i:s'),
                            ]);
                    } else {
                        DB::table('whos_online')
                            ->insert([
                                'full_name' => $existUser[0]->first_name . ' ' . $existUser[0]->last_name,
                                'time_entry' => date('Y-m-d H:i:s'),
                                'customer_id' => $customers_id,
                            ]);
                    } */

                    

                    $responseData = array('success' => '1', 'data' => $existUser, 'message' => 'Data has been returned successfully!');

                } else {
                    $responseData = array('success' => '0', 'data' => array(), 'message' => "Your account has been deactivated.");

                }
            } else {
                $existUser = array();
                $responseData = array('success' => '22', 'data' => array(), 'message' => "Invalid email or password.");

            }
       } else {
            $responseData = array('success' => '0', 'data' => array(), 'message' => "Unauthenticated call.");
        } 
        $userResponse = json_encode($responseData);

        return $userResponse;
    }



    public static function processregistration($request)
    {
        $customers_firstname = $request->name;
        $customers_lastname = $request->name;
        $email = $request->email;
        $password = $request->password;
        $customers_telephone = $request->mobile_number;
        $customers_info_date_account_created = date('y-m-d h:i:s');

        $consumer_data = array();
        $consumer_data['consumer_key'] = request()->header('consumer-key');
        $consumer_data['consumer_secret'] = request()->header('consumer-secret');
        $consumer_data['consumer_nonce'] = request()->header('consumer-nonce');
        //$consumer_data['consumer_device_id'] = request()->header('consumer-device-id');
        //$consumer_data['consumer_ip'] = request()->header('consumer-ip');
        $consumer_data['consumer_url'] = __FUNCTION__;
        $authController = new AppSettingController();

        $authenticate = $authController->apiAuthenticate($consumer_data);

        $extensions = array('gif', 'jpg', 'jpeg', 'png');

       

            //check email existance
            $existUser = DB::table('users')->where('email', $email)->get();

            if (count($existUser) == "1") {
                $responseData = array('success' => '0', 'data' => array(), 'message' => "e dey");
                //response if email already exit
                $postData = array();
                $responseData = array('success' => '12', 'data' => $postData, 'message' => "Email address already exist");
            } else {

               

                //insert data into customer
                $customers_id = DB::table('users')->insertGetId([
                    'role_id' => '2',
                    'full_name' => $customers_firstname,
                    'phone' => $customers_telephone,
                    'email' => $email,
                    'password' => Hash::make($password),
                    'status' => '1',
                    'created_at' => date('y-m-d h:i:s'),
                ]);

                $userData = DB::table('users')
                    ->where('users.id', '=', $customers_id)->where('status', '1')->get();
                $responseData = array('success' => '1', 'data' => $userData, 'message' => "Sign Up successfully!");
            }

      
        $userResponse = json_encode($responseData);
        print $userResponse;
    }









//DRIVER REGISTRATION and LOGIN STARTS FROM HERE DOWN

    public static function processregistrationdriver($request)
    {
        $customers_firstname = $request->name;
        $customers_lastname = $request->name;
        $email = $request->email;
        $password = $request->password;
        $customers_telephone = $request->mobile_number;
        $customers_info_date_account_created = date('y-m-d h:i:s');

        $consumer_data = array();
        $consumer_data['consumer_key'] = request()->header('consumer-key');
        $consumer_data['consumer_secret'] = request()->header('consumer-secret');
        $consumer_data['consumer_nonce'] = request()->header('consumer-nonce');
        //$consumer_data['consumer_device_id'] = request()->header('consumer-device-id');
        //$consumer_data['consumer_ip'] = request()->header('consumer-ip');
        $consumer_data['consumer_url'] = __FUNCTION__;
        $authController = new AppSettingController();

        $authenticate = $authController->apiAuthenticate($consumer_data);

        $extensions = array('gif', 'jpg', 'jpeg', 'png');

       

            //check email existance
            $existUser = DB::table('drivers')->where('email', $email)->get();


           

            if (count($existUser) == "1") {
                $responseData = array('success' => '0', 'data' => array(), 'message' => "e dey");
                //response if email already exit
                $postData = array();
                $responseData = array('success' => '12', 'data' => $postData, 'message' => "Email address already exist");
            } 

             //check phone existance
             $existmobilephone = DB::table('drivers')->where('phone', $customers_telephone)->get();

            if(count($existmobilephone) == "1") {
                $responseData = array('success' => '0', 'data' => array(), 'message' => "e dey");
                //response if email already exit
                $postData = array();
                $responseData = array('success' => '13', 'data' => $postData, 'message' => "Phone number already exist");
            } 
            
            else {

               

                //insert data into customer
                $customers_id = DB::table('drivers')->insertGetId([
                    'role_id' => '2',
                    'full_name' => $customers_firstname,
                    'phone' => $customers_telephone,
                    'email' => $email,
                    'password' => Hash::make($password),
                    'status' => '1',
                    'created_at' => date('y-m-d h:i:s'),
                ]);

                $userData = DB::table('drivers')
                    ->where('drivers.id', '=', $customers_id)->where('status', '1')->get();
                $responseData = array('success' => '1', 'data' => $userData, 'message' => "Sign Up successfully!");
            }

      
        $userResponse = json_encode($responseData);
        print $userResponse;
    }





    public static function logindriver($request)
    {

        //return "4444";
        $consumer_data = array();
        $consumer_data['consumer_key'] = request()->header('consumer-key');
        $consumer_data['consumer_secret'] = request()->header('consumer-secret');
        $consumer_data['consumer_nonce'] = request()->header('consumer-nonce');
        //$consumer_data['consumer_device_id'] = request()->header('consumer-device-id');
        //$consumer_data['consumer_ip'] = request()->header('consumer-ip');
        // $consumer_data['consumer_ip'];
        $consumer_data['consumer_url'] = __FUNCTION__; // 'processlogin' is returns here
        $authController = new AppSettingController();

        //return $consumer_data['consumer_secret'];
        
        $authenticate = $authController->apiAuthenticate($consumer_data);

       // return $authenticate;

        if ($authenticate == 1){ 

            $email = $request->email;
            $password = $request->password;

          

        

            $customerInfo = array("email" => $email, "password" => $password, 'department' => 'Marketer');

            //dd($customerInfo);
            
            if ($customerInfo) {


                $model = DB::table('users')->where('email',$email)->where('department', 'Marketer')->first();

           if(isset($model)){


            if (Hash::check($password, $model->password, [])) {

                $existUser = DB::table('users')
                ->where('email', $email)->where('department', 'Marketer')->get();


                if (count($existUser) > 0) {

                    $customers_id = $existUser[0]->id;

                    //update record of customers_info
                    $existUserInfo = DB::table('customers_info')->where('customers_info_id', $customers_id)->get();
                    $customers_info_id = $customers_id;
                    $customers_info_date_of_last_logon = date('Y-m-d H:i:s');
                    $customers_info_number_of_logons = '1';
                    $customers_info_date_account_created = date('Y-m-d H:i:s');
                    $global_product_notifications = '1';

                    if (count($existUserInfo) > 0) {
                        //update customers_info table
                        DB::table('customers_info')->where('customers_info_id', $customers_info_id)->update([
                            'customers_info_date_of_last_logon' => $customers_info_date_of_last_logon,
                            'global_product_notifications' => $global_product_notifications,
                            'customers_info_number_of_logons' => DB::raw('customers_info_number_of_logons + 1'),
                        ]);

                    } else {
                        //insert customers_info table
                        $customers_default_address_id = DB::table('customers_info')->insertGetId(
                            ['customers_info_id' => $customers_info_id,
                                'customers_info_date_of_last_logon' => $customers_info_date_of_last_logon,
                                'customers_info_number_of_logons' => $customers_info_number_of_logons,
                                'customers_info_date_account_created' => $customers_info_date_account_created,
                                'global_product_notifications' => $global_product_notifications,
                            ]
                        );

                        DB::table('users')->where('id', $customers_id)->update([
                            'default_address_id' => $customers_default_address_id,
                        ]);
                    }

                    //check if already login or not
   /*                  $already_login = DB::table('whos_online')->where('customer_id', '=', $customers_id)->get();

                    if (count($already_login) > 0) {
                        DB::table('whos_online')
                            ->where('customer_id', $customers_id)
                            ->update([
                                'full_name' => $existUser[0]->first_name . ' ' . $existUser[0]->last_name,
                                'time_entry' => date('Y-m-d H:i:s'),
                            ]);
                    } else {
                        DB::table('whos_online')
                            ->insert([
                                'full_name' => $existUser[0]->first_name . ' ' . $existUser[0]->last_name,
                                'time_entry' => date('Y-m-d H:i:s'),
                                'customer_id' => $customers_id,
                            ]);
                    } */

                    

                    $responseData = array('success' => '1', 'data' => $existUser, 'message' => 'Data has been returned successfully!');

                } else {
                    $responseData = array('success' => '0', 'data' => array(), 'message' => "Your account has been deactivated.");

                }



              
            }

               
           }else{
            $existUser = array();

            $responseData = array('success' => '22',  'message' => "You are not a sales Rep.");
             
           }

               



               
            } else {
                $existUser = array();
                $responseData = array('success' => '22', 'data' => array(), 'message' => "Invalid email or password.");

            }
       } else {
            $responseData = array('success' => '0', 'data' => array(), 'message' => "Unauthenticated call.");
        } 

     

        $userResponse = json_encode($responseData);
        return $userResponse;
    }






    public static function notify_me($request)
    {
        $device_id = $request->device_id;
        $is_notify = $request->is_notify;
        $consumer_data = array();
        $consumer_data['consumer_key'] = request()->header('consumer-key');
        $consumer_data['consumer_secret'] = request()->header('consumer-secret');
        $consumer_data['consumer_nonce'] = request()->header('consumer-nonce');
        //$consumer_data['consumer_device_id'] = request()->header('consumer-device-id');
        //$consumer_data['consumer_ip'] = request()->header('consumer-ip');
        $consumer_data['consumer_url'] = __FUNCTION__;
        $authController = new AppSettingController();
        $authenticate = $authController->apiAuthenticate($consumer_data);

        if ($authenticate == 1) {

            $devices = DB::table('devices')->where('device_id', $device_id)->get();
            if (!empty($devices[0]->customers_id)) {
                $customers = DB::table('users')->where('id', $devices[0]->customers_id)->get();

                if (count($customers) > 0) {

                    foreach ($customers as $customers_data) {

                        DB::table('devices')->where('user_id', $customers_data->customers_id)->update([
                            'is_notify' => $is_notify,
                        ]);
                    }

                }
            } else {

                DB::table('devices')->where('device_id', $device_id)->update([
                    'is_notify' => $is_notify,
                ]);
            }

            $responseData = array('success' => '1', 'data' => '', 'message' => "Notification setting has been changed successfully!");
        } else {
            $responseData = array('success' => '0', 'data' => array(), 'message' => "Unauthenticated call.");
        }
        $categoryResponse = json_encode($responseData);

        return $categoryResponse;
    }



    public static function imageupdate($request){

        $token                          =       request()->header('Authorization');
        $consumer_data 		 				  =  array();
        $consumer_data['consumer_key'] 	 	  =  request()->header('consumer-key');
        $consumer_data['consumer_secret']	  =  request()->header('consumer-secret');
        $consumer_data['consumer_nonce']	  =  request()->header('consumer-nonce');
       // $consumer_data['consumer_device_id']  =  request()->header('consumer-device-id');
       // $consumer_data['consumer_ip']  	  = request()->header('consumer-ip');
        $consumer_data['consumer_url']  	  =  __FUNCTION__;
        $authController = new AppSettingController();
        $authenticate = $authController->apiAuthenticate($consumer_data);

        //remove bearer character from token
        $int = (int) filter_var($token, FILTER_SANITIZE_NUMBER_INT);




        if($authenticate==1){


            $cehckexist = DB::table('drivers')->where('token', $int)->where('role_id', 2)->get();

            if(isset($request->image_url) && $cehckexist){

                DB::table('drivers')->where('token', $int)->update([
                    'image_url' => $request->image_url
                ]);


                $userData = DB::table('drivers')->where('token', $int)->get();
                $responseData = array('success'=>'1', 'data'=>$userData, 'message'=>"Drivers Photo has been Updated successfully");

                
               
            }

    }
 }

    public static function updatesalesrecord($request)
    {

         
        $salesamt            			=       $request->salesamt;
        $leakage           	            =       $request->leakage;
     
        $token                          =       request()->header('Authorization');
        

    
        $customers_info_date_account_last_modified 	=   date('y-m-d h:i:s');
        $consumer_data 		 				  =  array();
        $consumer_data['consumer_key'] 	 	  =  request()->header('consumer-key');
        $consumer_data['consumer_secret']	  =  request()->header('consumer-secret');
        $consumer_data['consumer_nonce']	  =  request()->header('consumer-nonce');
       // $consumer_data['consumer_device_id']  =  request()->header('consumer-device-id');
       // $consumer_data['consumer_ip']  	  = request()->header('consumer-ip');
        $consumer_data['consumer_url']  	  =  __FUNCTION__;
        $authController = new AppSettingController();
        $authenticate = $authController->apiAuthenticate($consumer_data);


         $int = (int) filter_var($token, FILTER_SANITIZE_NUMBER_INT);

       //  return  $int;


        if($authenticate==1){


       /*  $cehckexist = DB::table('sales')->where('user_id', $int)->update([
            'sales' => $salesamt
            
            ]); */

       // $getprice = DB::table('salesRepSales')->insertGetId($arraydata);
        $customers_id = DB::table('salesRepSales')->insertGetId([
            'user_id' => $int,
            'bagsout' => '0',
            'sales' => $request->salesamt 

        ]);

        $responseData = array('success'=>'1',  'message'=>"Sucessfully sent to Sales Manager for Approval");
      

        }else{
            $responseData = array('success'=>'0', 'data'=>array(),  'message'=>"Unauthenticated call.");
        }
        $userResponse = json_encode($responseData);

        return $userResponse;
    }


    public static function updatepassword($request)
    {
    $customers_id            					=   $request->customers_id;
    $customers_info_date_account_last_modified 	=   date('y-m-d h:i:s');
    $consumer_data 		 				  =  array();
    $consumer_data['consumer_key'] 	 	  =  request()->header('consumer-key');
    $consumer_data['consumer_secret']	  =  request()->header('consumer-secret');
    $consumer_data['consumer_nonce']	  =  request()->header('consumer-nonce');
   // $consumer_data['consumer_device_id']  =  request()->header('consumer-device-id');
    $consumer_data['consumer_ip']  	  = request()->header('consumer-ip');
    $consumer_data['consumer_url']  	  =  __FUNCTION__;
    $authController = new AppSettingController();
    $authenticate = $authController->apiAuthenticate($consumer_data);


    if($authenticate==1){
        $cehckexist = DB::table('users')->where('id', $customers_id)->where('role_id', 2)->first();
            if($cehckexist){
                $oldpassword    = $request->oldpassword;
                $newPassword    = $request->newpassword;

                $content = DB::table('users')->where('id', $customers_id)->first();

                $customerInfo = array("email" => $cehckexist->email, "password" => $oldpassword);

                if (Auth::attempt($customerInfo)) {

                    DB::table('users')->where('id', $customers_id)->update([
                    'password'			 =>  Hash::make($newPassword)
                    ]);

                    //get user data
                    $userData = DB::table('users')
                        ->select('users.*')
                        ->where('users.id', '=', $customers_id)->where('status', '1')->get();
                    $responseData = array('success'=>'1', 'data'=>$userData, 'message'=>"Information has been Updated successfully");
                }else{
                    $responseData = array('success'=>'2', 'data'=>array(),  'message'=>"current password does not match.");
                }
        }else{
            $responseData = array('success'=>'3', 'data'=>array(),  'message'=>"Record not found.");
        }

        }else{
            $responseData = array('success'=>'0', 'data'=>array(),  'message'=>"Unauthenticated call.");
        }

        $userResponse = json_encode($responseData);
        return $userResponse;
    }

    public static function processforgotpassword($request)
    {

        $email = $request->email;
        $postData = array();

        $consumer_data = array();
        $consumer_data['consumer_key'] = request()->header('consumer-key');
        $consumer_data['consumer_secret'] = request()->header('consumer-secret');
        $consumer_data['consumer_nonce'] = request()->header('consumer-nonce');
        //$consumer_data['consumer_device_id'] = request()->header('consumer-device-id');
        //$consumer_data['consumer_ip'] = request()->header('consumer-ip');
        $consumer_data['consumer_url'] = __FUNCTION__;
        $authController = new AppSettingController();
        $authenticate = $authController->apiAuthenticate($consumer_data);

        if ($authenticate == 1) {

            //check email exist
            $existUser = DB::table('users')->where('email', $email)->get();

            if (count($existUser) > 0) {
                $password = substr(md5(uniqid(mt_rand(), true)), 0, 8);

                DB::table('users')->where('email', $email)->update([
                    'password' => Hash::make($password),
                ]);

                $existUser[0]->password = $password;

                $myVar = new AlertController();
                $alertSetting = $myVar->forgotPasswordAlert($existUser);
                $responseData = array('success' => '1', 'data' => $postData, 'message' => "Your password has been sent to your email address.");
            } else {
                $responseData = array('success' => '0', 'data' => $postData, 'message' => "Email address doesn't exist!");
            }
        } else {
            $responseData = array('success' => '0', 'data' => array(), 'message' => "Unauthenticated call.");
        }
        $userResponse = json_encode($responseData);

        return $userResponse;
    }

    public static function facebookregistration($request)
    {
        require_once app_path('vendor/autoload.php');
        $consumer_data = array();
        $consumer_data['consumer_key'] = request()->header('consumer-key');
        $consumer_data['consumer_secret'] = request()->header('consumer-secret');
        $consumer_data['consumer_nonce'] = request()->header('consumer-nonce');
       // $consumer_data['consumer_device_id'] = request()->header('consumer-device-id');
        //$consumer_data['consumer_ip'] = request()->header('consumer-ip');
        $consumer_data['consumer_url'] = __FUNCTION__;
        $authController = new AppSettingController();
        $authenticate = $authController->apiAuthenticate($consumer_data);

        if ($authenticate == 1) {
            //get function from other controller
            $myVar = new AppSettingController();
            $setting = $myVar->getSetting();

            $password = substr(md5(uniqid(mt_rand(), true)), 0, 8);
            $access_token = $request->access_token;

            $fb = new \Facebook\Facebook([
                'app_id' => $setting['facebook_app_id'],
                'app_secret' => $setting['facebook_secret_id'],
                'default_graph_version' => 'v2.2',
            ]);

            try {
                $response = $fb->get('/me?fields=id,name,email,first_name,last_name,gender,public_key', $access_token);
            } catch (Facebook\Exceptions\FacebookResponseException $e) {
                echo 'Graph returned an error: ' . $e->getMessage();
            } catch (Facebook\Exceptions\FacebookSDKException $e) {
                echo 'Facebook SDK returned an error: ' . $e->getMessage();
            }

            $user = $response->getGraphUser();

            $fb_id = $user['id'];
            $customers_firstname = $user['first_name'];
            $customers_lastname = $user['last_name'];
            $name = $user['name'];
            if (empty($user['gender']) or $user['gender'] == 'male') {
                $customers_gender = '0';
            } else {
                $customers_gender = '1';
            }
            if (!empty($user['email'])) {
                $email = $user['email'];
            } else {
                $email = '';
            }

            //user information
            $fb_data = array(
                'fb_id' => $fb_id,
            );
            $customer_data = array(
                'role_id' => 2,
                'first_name' => $customers_firstname,
                'last_name' => $customers_lastname,
                'email' => $email,
                'password' => Hash::make($password),
                'status' => '1',
                'created_at' => time(),
            );

            $existUser = DB::table('customers')->where('fb_id', '=', $fb_id)->get();
            if (count($existUser) > 0) {

                $customers_id = $existUser[0]->customers_id;
                $success = "2";
                $message = "Customer record has been updated.";
                //update data of customer
                DB::table('customers')->where('user_id', '=', $customers_id)->update($fb_data);
            } else {
                $success = "1";
                $message = "Customer account has been created.";
                //insert data of customer
                $customers_id = DB::table('users')->insertGetId($customer_data);
                DB::table('customers')->insertGetId([
                    'fb_id' => $fb_id,
                    'user_id' => $customers_id,

                ]);

            }

            $userData = DB::table('users')->where('id', '=', $customers_id)->get();

            //update record of customers_info
            $existUserInfo = DB::table('customers_info')->where('customers_info_id', $customers_id)->get();
            $customers_info_id = $customers_id;
            $customers_info_date_of_last_logon = date('Y-m-d H:i:s');
            $customers_info_number_of_logons = '1';
            $customers_info_date_account_created = date('Y-m-d H:i:s');
            $global_product_notifications = '1';

            if (count($existUserInfo) > 0) {
                //update customers_info table
                DB::table('customers_info')->where('customers_info_id', $customers_info_id)->update([
                    'customers_info_date_of_last_logon' => $customers_info_date_of_last_logon,
                    'global_product_notifications' => $global_product_notifications,
                    'customers_info_number_of_logons' => DB::raw('customers_info_number_of_logons + 1'),
                ]);

            } else {
                //insert customers_info table
                $customers_default_address_id = DB::table('customers_info')->insertGetId([
                    'customers_info_id' => $customers_info_id,
                    'customers_info_date_of_last_logon' => $customers_info_date_of_last_logon,
                    'customers_info_number_of_logons' => $customers_info_number_of_logons,
                    'customers_info_date_account_created' => $customers_info_date_account_created,
                    'global_product_notifications' => $global_product_notifications,
                ]);

            }

            //check if already login or not
            $already_login = DB::table('whos_online')->where('customer_id', '=', $customers_id)->get();
            if (count($already_login) > 0) {
                DB::table('whos_online')
                    ->where('customer_id', $customers_id)
                    ->update([
                        'full_name' => $userData[0]->first_name . ' ' . $userData[0]->last_name,
                        'time_entry' => date('Y-m-d H:i:s'),
                    ]);
            } else {
                DB::table('whos_online')
                    ->insert([
                        'full_name' => $userData[0]->first_name . ' ' . $userData[0]->last_name,
                        'time_entry' => date('Y-m-d H:i:s'),
                        'customer_id' => $customers_id,
                    ]);
            }

            $responseData = array('success' => $success, 'data' => $userData, 'message' => $message);
        } else {
            $responseData = array('success' => '0', 'data' => array(), 'message' => "Unauthenticated call.");
        }
        $userResponse = json_encode($responseData);

        return $userResponse;
    }

    public static function googleregistration($request)
    {
        $consumer_data = array();
        $consumer_data['consumer_key'] = request()->header('consumer-key');
        $consumer_data['consumer_secret'] = request()->header('consumer-secret');
        $consumer_data['consumer_nonce'] = request()->header('consumer-nonce');
       // $consumer_data['consumer_device_id'] = request()->header('consumer-device-id');
        //$consumer_data['consumer_ip'] = request()->header('consumer-ip');
        $consumer_data['consumer_url'] = __FUNCTION__;
        $authController = new AppSettingController();
        $authenticate = $authController->apiAuthenticate($consumer_data);

        if ($authenticate == 1) {

            $password = substr(md5(uniqid(mt_rand(), true)), 0, 8);
            //gmail user information
            $access_token = $request->idToken;
            $google_id = $request->userId;
            $customers_firstname = $request->givenName;
            $customers_lastname = $request->familyName;
            $email = $request->email;

            //user information
            $google_data = array(
                'google_id' => $google_id,
            );

            $customer_data = array(
                'role_id' => 2,
                'first_name' => $customers_firstname,
                'last_name' => $customers_lastname,
                'email' => $email,
                'password' => Hash::make($password),
                'status' => '1',
                'created_at' => time(),
            );

            $existUser = DB::table('customers')->where('google_id', '=', $google_id)->get();
            if (count($existUser) > 0) {
                $customers_id = $existUser[0]->customers_id;
                DB::table('users')->where('id', $customers_id)->update($customer_data);
            } else {
                //insert data into customer
                $customers_id = DB::table('users')->insertGetId($customer_data);
                DB::table('customers')->insertGetId([
                    'google_id' => $google_id,
                    'user_id' => $customers_id,
                ]);

            }

            $userData = DB::table('users')->where('id', '=', $customers_id)->get();

            //update record of customers_info
            $existUserInfo = DB::table('customers_info')->where('customers_info_id', $customers_id)->get();
            $customers_info_id = $customers_id;
            $customers_info_date_of_last_logon = date('Y-m-d H:i:s');
            $customers_info_number_of_logons = '1';
            $customers_info_date_account_created = date('Y-m-d H:i:s');
            $customers_info_date_account_last_modified = date('Y-m-d H:i:s');
            $global_product_notifications = '1';

            if (count($existUserInfo) > 0) {
                $success = '2';
            } else {
                //break;
                //insert customers_info table
                $customers_default_address_id = DB::table('customers_info')->insertGetId(
                    [
                        'customers_info_id' => $customers_info_id,
                        'customers_info_date_of_last_logon' => $customers_info_date_of_last_logon,
                        'customers_info_number_of_logons' => $customers_info_number_of_logons,
                        'customers_info_date_account_created' => $customers_info_date_account_created,
                        'global_product_notifications' => $global_product_notifications,
                    ]
                );
                $success = '1';
            }

            //check if already login or not
            $already_login = DB::table('whos_online')->where('customer_id', '=', $customers_id)->get();

            if (count($already_login) > 0) {
                DB::table('whos_online')
                    ->where('customer_id', $customers_id)
                    ->update([
                        'full_name' => $userData[0]->first_name . ' ' . $userData[0]->last_name,
                        'time_entry' => date('Y-m-d H:i:s'),
                    ]);
            } else {

                DB::table('whos_online')
                    ->insert([
                        'full_name' => $userData[0]->first_name . ' ' . $userData[0]->last_name,
                        'time_entry' => date('Y-m-d H:i:s'),
                        'customer_id' => $customers_id,
                    ]);
            }

            //$userData = $request->all();
            $responseData = array('success' => $success, 'data' => $userData, 'message' => "Login successfully");
        } else {
            $responseData = array('success' => '0', 'data' => array(), 'message' => "Unauthenticated call.");
        }
        $userResponse = json_encode($responseData);

        return $userResponse;
    }

    public static function registerdevices($request)
    {
        $consumer_data = array();
        $consumer_data['consumer_key'] = request()->header('consumer-key');
        $consumer_data['consumer_secret'] = request()->header('consumer-secret');
        $consumer_data['consumer_nonce'] = request()->header('consumer-nonce');
       // $consumer_data['consumer_device_id'] = request()->header('consumer-device-id');
        //$consumer_data['consumer_ip'] = request()->header('consumer-ip');
        $consumer_data['consumer_url'] = __FUNCTION__;
        $authController = new AppSettingController();
        $authenticate = $authController->apiAuthenticate($consumer_data);

        if ($authenticate == 1) {

            $myVar = new AppSettingController();
            $setting = $myVar->getSetting();

            $device_type = $request->device_type;

            if ($device_type == 'iOS') { /* iphone */
                $type = 1;
            } elseif ($device_type == 'Android') { /* android */
                $type = 2;
            } elseif ($device_type == 'Desktop') { /* other */
                $type = 3;
            }

            if (!empty($request->customers_id)) {

                $device_data = array(
                    'device_id' => $request->device_id,
                    'device_type' => $type,
                    'register_date' => time(),
                    'update_date' => time(),
                    'ram' => $request->ram,
                    'status' => '1',
                    'processor' => $request->processor,
                    'device_os' => $request->device_os,
                    'location' => $request->location,
                    'device_model' => $request->device_model,
                    'customers_id' => $request->customers_id,
                    'manufacturer' => $request->manufacturer,
                    $setting['default_notification'] => '1',
                );

            } else {

                $device_data = array(
                    'device_id' => $request->device_id,
                    'device_type' => $type,
                    'register_date' => time(),
                    'update_date' => time(),
                    'status' => '1',
                    'ram' => $request->ram,
                    'processor' => $request->processor,
                    'device_os' => $request->device_os,
                    'location' => $request->location,
                    'device_model' => $request->device_model,
                    'manufacturer' => $request->manufacturer,
                    $setting['default_notification'] => '1',
                );

            }

            //check device exist
            $device_id = DB::table('devices')->where('device_id', '=', $request->device_id)->get();

            if (count($device_id) > 0) {

                $dataexist = DB::table('devices')->where('device_id', '=', $request->device_id)->where('user_id', '==', '0')->get();

                DB::table('devices')
                    ->where('device_id', $request->device_id)
                    ->update($device_data);

                if (count($dataexist) >= 0) {
                    $userData = DB::table('users')->where('id', '=', $request->customers_id)->get();
                    //notification
                    $myVar = new AlertController();
                    $alertSetting = $myVar->createUserAlert($userData);
                }
            } else {
                $device_id = DB::table('devices')->insertGetId($device_data);
            }

            $responseData = array('success' => '1', 'data' => array(), 'message' => "Device is registered.");
        } else {
            $responseData = array('success' => '0', 'data' => array(), 'message' => "Unauthenticated call.");
        }
        $userResponse = json_encode($responseData);

        return $userResponse;
    }

}
