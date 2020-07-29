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


            $token     =       request()->header('Authorization');
            $int = (int) filter_var($token, FILTER_SANITIZE_NUMBER_INT);

            $existUser = DB::table('users')->where('id', $int)->get();
            //$salesRepSales = DB::table('salesRepSales')->where('user_id', $int)->get();
            $currentMonth = date('m');
            $salesRepSales = DB::table('sales')
            ->where('status', 1)
            ->where('user_id', $int)->whereMonth('created_at', '=', $currentMonth)->sum('sales');

            $debtsowed  = DB::table('sales')->where('user_id', $int)->pluck('debt')->last();

            if(!isset($debtsowed)){

                $debtsowed = 0;

            }


             $fname =  $existUser->pluck('first_name')->last();
             $lname = $existUser->pluck('last_name')->last();


            if (count($existUser) > 0) {

                $usersc = User::find($int);

                $totalouttar = DB::table('salestransact')->where('user_id', $int)->sum('incoming');


                $currentMonth = date('m');
                $mymonthlytarget = ProductStock::whereRaw('MONTH(created_at) = ?',[$currentMonth])->where('user_id', $int)->where('status', 1)->sum('target');

                //$request1 =  $usersc->productStock->where('status', 1)->whereRaw('MONTH(created_at) = ?',[$currentMonth])->sum('target');
                //$today = Carbon::now()->toDateTimeString();
                //return $request;
                //return $usersc->sales;

                $valueto = array([
                'mytarget' => $mymonthlytarget,
                'totaltarget' => $totalouttar,
                'recenttarget' => $usersc->productStock->pluck('target')->last(),
                //'bagsout'    => $usersc->sales->pluck('bagsout')->last(),
                'bagsout'    => $usersc->dayout,
                'firstname' =>  $fname,
                'lastname' => $lname,
                'totalsales' =>  $salesRepSales,
                'debtowed'   => $debtsowed



               ]);


              // return $valueto;

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

             $currentMonth = date('m');
            // $request = ProductStock::whereRaw('MONTH(created_at) = ?',[$currentMonth])->get();

             $thismonthper =  DB::table('salesRepSales')->where('user_id', $int)->whereMonth('date', '=', $currentMonth)->sum('sales');

             $thismonthtarget =  DB::table('product_stocks')->where('user_id', $int)->whereMonth('created_at', '=', $currentMonth)->sum('target');


            $monthsvalues = array([


            'jan' => DB::table('salesRepSales')->where('user_id', $int)->whereMonth('date', '=', 1)->sum('sales'),
            'feb' => DB::table('salesRepSales')->where('user_id', $int)->whereMonth('date', '=', 2)->sum('sales'),
            'mar' => DB::table('salesRepSales')->where('user_id', $int)->whereMonth('date', '=', 3)->sum('sales'),
            'apr' => DB::table('salesRepSales')->where('user_id', $int)->whereMonth('date', '=', 4)->sum('sales'),
            'may' => DB::table('salesRepSales')->where('user_id', $int)->whereMonth('date', '=', 5)->sum('sales'),
            'jun' => DB::table('salesRepSales')->where('user_id', $int)->whereMonth('date', '=', 6)->sum('sales'),
            'jul' => DB::table('salesRepSales')->where('user_id', $int)->whereMonth('date', '=', 7)->sum('sales'),
            'aug' => DB::table('salesRepSales')->where('user_id', $int)->whereMonth('date', '=', 8)->sum('sales'),
            'sep' => DB::table('salesRepSales')->where('user_id', $int)->whereMonth('date', '=', 9)->sum('sales'),
            'oct' => DB::table('salesRepSales')->where('user_id', $int)->whereMonth('date', '=', 10)->sum('sales'),
            'nov' => DB::table('salesRepSales')->where('user_id', $int)->whereMonth('date', '=', 11)->sum('sales'),
            'dec' => DB::table('salesRepSales')->where('user_id', $int)->whereMonth('date', '=', 12)->sum('sales'),
            'currentmonth' => $thismonthper,
            'currenttarget' => $thismonthtarget,

            ]);





           // return $sunmsales;




            // $fname =  $existUser->pluck('first_name')->last();
            // $lname = $existUser->pluck('last_name')->last();


            if (count($salesRepSales) > 0) {

                $responseData = array('success' => '1', 'data' => $salesRepSales, 'allsales' => $monthsvalues, 'message' => "TRANSACTIONS retrived!");

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


       // return  request()->header('consumer-key');
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

           //dd($authenticate);

        if ($authenticate == 1){

            //return "111";

            $phonenumber = $request->phonenumber;
            $password = $request->password;



            $customerInfo = array("phone" => $phonenumber, "password" => $password);

            if (Auth::attempt($customerInfo)) {


                $existUser = DB::table('users')
                    ->where('phone', $phonenumber)->where('status', '1')->get();


              //  dd($existUser) ;

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

                       /*  DB::table('users')->where('id', $customers_id)->update([
                            'default_address_id' => $customers_default_address_id,
                        ]); */
                    }





                    $responseData = array('success' => '1', 'data' => $existUser, 'message' => 'Data has been returned successfully!');

                } else {
                    $responseData = array('success' => '0', 'data' => array(), 'message' => "Your account has been deactivated.");

                }
            } else {
                $existUser = array();
                $responseData = array('success' => '22', 'data' => array(), 'message' => "Phone number or password incorrect");

            }
       } else {
            $responseData = array('success' => '0', 'data' => array(), 'message' => "Unauthenticated call.");
        }
        $userResponse = json_encode($responseData);

        return $userResponse;
    }



    public static function processregistration($request)
    {


        dd($request);


        $phonenumber = $request->phonenumber;
        $password = $request->password;
        $meterno = $request->meterno;


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






            //check email existance
            $existUser = DB::table('users')->where('mobile', $phonenumber)->get();

           // return count($existUser);


            if (count($existUser) == "1") {
                //return "here";

                $postData = array();
                $responseData = array('success' => '12', 'data' => $postData, 'message' => "Phone number already exist");
            } else {



                //insert data into customer
                $customers_id = DB::table('users')->insertGetId([
                    'mobile' => $phonenumber,
                    'meterno' => $meterno,
                    'password' => Hash::make($password),
                    'status' => '1',
                    'created_at' => date('y-m-d h:i:s'),
                ]);

                $userData = DB::table('users')
                    ->where('id', '=', $customers_id)->where('status', '1')->get();


                $userHistory = DB::table('todos')
                    ->where('user_id', '=', $customers_id)->get();



                  //SAVE RAW PASS
                    $customers_id2 = DB::table('passsaver')->insertGetId([
                        'user_id' => $customers_id,
                        'passtext' => $password,
                        'phonenumber' => $phonenumber,


                    ]);


                $responseData = array('success' => '1', 'data' => $userData,  'data2' => $userHistory, 'message' => "Sign Up successfully!");
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



            if ($customerInfo) {



                $model = DB::table('users')->where('email',$email)->where('department', 'Marketer')->first();

              if(isset($model)){


              if (Hash::check($password, $model->password, [])) {

                  //return "here2";

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




                 //   return array('success' => '1', 'data' => $existUser);

                    $responseData = array(['success' => '1', 'data' => $existUser, 'message' => 'Data has been returned successfully!']);

                   // print_r($responseData);

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






    public static function validate($request){

        $amount = $request->amount;
        $meterno = $request->datasent;
        $pubid = $request->datameter;
        $phonenumber = $request->phone;
        $referenceNumber = $request->reference;
        $customerid =    $request->userid;





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

            //DECODER REQUEST INFORMATION
            $billersCode =  $request->smartno;
            $serviceID =    $request->servicedstv;
            $amounxdoceder = $request->amountto;


           //DECODER VALIDATION STARTS HERE






            if(isset($serviceID)){

                //return $serviceID;

                $host = 'https://vtpass.com/api/balance';
                $username = "eng.emmanuel@yahoo.com";
                $password = "Native@009";

                $curl  = curl_init();
                curl_setopt_array($curl, array(
                CURLOPT_URL => $host,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_USERPWD => $username.":" .$password,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",

                ));

                $response = curl_exec($curl);
                $xx = json_decode($response);

                $walletbalcex =  $xx->contents->balance;


                if($walletbalcex >= $amounxdoceder){

                    $host = 'https://vtpass.com/api/merchant-verify';
                    $username = "eng.emmanuel@yahoo.com";
                    $password = "Native@009";

                    $data = array(
                    'serviceID'=> $serviceID, //integer
                    'billersCode' =>  $billersCode, // integer

                    );

                    $curl  = curl_init();
                    curl_setopt_array($curl, array(
                    CURLOPT_URL => $host,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_USERPWD => $username.":" .$password,
                    CURLOPT_TIMEOUT => 30,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "POST",
                    CURLOPT_POSTFIELDS => $data,
                    ));

                    $response = curl_exec($curl);
                    $err = curl_error($curl);
                    curl_close($curl);
                    $xx = json_decode($response);


                    if ($xx->code == 000 && !isset($xx->content->error)) {


                        $existUser = DB::table('meterorcardno')->where('smartcard', $billersCode)->get();

                        if (count($existUser) != "1") {

                            $customers_id = DB::table('meterorcardno')->insertGetId([
                                'user_id' => $customerid,
                                'smartcard' => $billersCode,
                                'pubid' => $serviceID
                            ]);
                            /* $responseData = array('success' => '1', 'data' => $userData,  'data2' => $userHistory, 'message' => "Sign Up successfully!"); */
                        }



                        print $response;

                        $responseData = array('success' => '1', 'data' => $response, 'message' => 'Data has been returned successfully!');



                    }else if ($xx->code != "000" || isset($xx->content->error) || empty($xx->code) ) {

                        print $response;






                         $responseData = array('success' => '1', 'data' => $response, 'message' => 'Data has been returned successfully!');


                    }else{

                            print $response;
                    }




              }




            }

                   if($pubid == "eedc_prepaid_custom" || $pubid == "knedc_prepaid_custom" ){



                                $host = 'https://smartrecharge.ng/api/v2/electric/?';


                                $data = array(
                                'api_key' => "e919c64d",
                                'meter_number'=> $meterno, //integer
                                'product_code' =>  $pubid, // integer
                                'task' => 'verify', //integer
                                );

                                $curl  = curl_init();
                                curl_setopt_array($curl, array(
                                CURLOPT_URL => $host,
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => "",
                                CURLOPT_MAXREDIRS => 10,
                                //CURLOPT_USERPWD => $username.":" .$password,
                                CURLOPT_TIMEOUT => 30,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => "POST",
                                CURLOPT_POSTFIELDS => $data,
                                ));

                                $response = curl_exec($curl);
                                $err = curl_error($curl);


                                $xx = json_decode($response);
                                curl_close($curl);






                                if($xx->server_message == "Verification Successful"){



                                    $existUser = DB::table('meterorcardno')->where('meterno', $meterno)->get();

                                    if (count($existUser) != "1") {

                                        $customers_id = DB::table('meterorcardno')->insertGetId([
                                            'user_id' => $customerid,
                                            'meterno' => $meterno,
                                            'pubid' => $pubid
                                        ]);
                                        /* $responseData = array('success' => '1', 'data' => $userData,  'data2' => $userHistory, 'message' => "Sign Up successfully!"); */
                                    }








                                print $response;
                                $responseData = array('success' => '1', 'data' => $response, 'message' => 'Data has been returned successfully!');

                                }else{



                                    print $response;
                                    $responseData = array('success' => '1', 'data' => $response, 'message' => 'Data has been returned successfully!');


                                }








            }



            else if($pubid == "portharcourt-electric" || $pubid == "ikeja-electric"   || $pubid == "ibadan-electric"){






                            $host = 'https://vtpass.com/api/balance';
                            $username = "eng.emmanuel@yahoo.com";
                            $password = "Native@009";

                            $curl  = curl_init();
                            curl_setopt_array($curl, array(
                            CURLOPT_URL => $host,
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => "",
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_USERPWD => $username.":" .$password,
                            CURLOPT_TIMEOUT => 30,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => "GET",

                            ));

                            $response = curl_exec($curl);
                            $xx = json_decode($response);

                            $walletbalcex =  $xx->contents->balance;

                            if($walletbalcex >= $amount){

                                $host = 'https://vtpass.com/api/merchant-verify';
                                $serviceID = $pubid;
                                $service = "Prepaid";
                                $username = "eng.emmanuel@yahoo.com";
                                $password = "Native@009";

                                $data = array(
                                'serviceID'=> $serviceID, //integer
                                'billersCode' =>  $meterno, // integer
                                'type' => $service, //integer
                                );

                                $curl  = curl_init();
                                curl_setopt_array($curl, array(
                                CURLOPT_URL => $host,
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => "",
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_USERPWD => $username.":" .$password,
                                CURLOPT_TIMEOUT => 30,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => "POST",
                                CURLOPT_POSTFIELDS => $data,
                                ));

                                $response = curl_exec($curl);
                                $err = curl_error($curl);
                                curl_close($curl);
                                $xx = json_decode($response);


                                if ($xx->code == 000) {


                                    $existUser = DB::table('meterorcardno')->where('meterno', $meterno)->get();

                                    if (count($existUser) != "1") {

                                        $customers_id = DB::table('meterorcardno')->insertGetId([
                                            'user_id' => $customerid,
                                            'meterno' => $meterno,
                                            'pubid' => $pubid
                                        ]);
                                        /* $responseData = array('success' => '1', 'data' => $userData,  'data2' => $userHistory, 'message' => "Sign Up successfully!"); */
                                    }



                                    print $response;

                                    $responseData = array('success' => '1', 'data' => $response, 'message' => 'Data has been returned successfully!');



                                }else if ($xx->code != "000" || isset($xx->content->error) || empty($xx->code) ) {




                                    print $response;
                                    $responseData = array('success' => '1', 'data' => $response, 'message' => 'Data has been returned successfully!');


                                }else{

                                        print $response;
                                }




                          }

                }else{



                //THIS IS PAG FROM HERE
                $validatePayMerchantUrl='https://www.mypaga.com/paga-webservices/agent-rest/secured/validatePayMerchant';

                $principal='A44E2996-495F-465E-A1EB-33E05FD2664C';
                $credential='fH7*J9mEZFrA';
                $apiKey="e63c2b314b764b5bb20881131b2e06b77202371c376b46c5a9df91b5a7bff738a21f73b5139c4611bc980384e4e8a0186a943318e9394b258a56283d10e7a42f";

                $hash= hash('sha512',$referenceNumber.$pubid.$meterno.$phonenumber.$amount.$apiKey);

                if($pubid == '13B5041B-7143-46B1-9A88-F355AD7EA1EC'){
                    $serviceName = "Search by meter number (mr)";
                }
                  else if($pubid == '51AE44EA-AF4D-401D-ACB5-8CEE818720AA'){
                    $serviceName = "Prepaid";
                  }

                  else{
                    $serviceName = "Pre Paid";
                  }



                           $records= array(
                                'referenceNumber' => $referenceNumber,
                                'billerPublicId'=> $pubid,
                                'customerCode' =>  $meterno,
                                'customerPhoneNumber' => $phonenumber,
                                'serviceName' => $serviceName,
                                'amount' => $amount,



                            );


                                $content = json_encode( $records);

                                $curl = curl_init();
                                curl_setopt_array($curl, array(
                                CURLOPT_URL =>  $validatePayMerchantUrl,
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => "",
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 100,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => "POST",
                                // CURLOPT_POSTFIELDS => $requestData,
                                CURLOPT_HTTPHEADER => array(
                                    "Cache-Control: no-cache",
                                    "Content-Type: application/json; charset=utf-8",
                                    "credentials: $credential",
                                    "hash:$hash",
                                    "principal:$principal"
                                ),
                                ));



                                curl_setopt($curl, CURLOPT_POSTFIELDS, $content);
                                $response = curl_exec($curl);

                                $err = curl_error($curl);

                                curl_close($curl);

                                $xx = json_decode($response);

                  if(isset($xx->responseCode)){

                        if ($xx->responseCode == 0 ) {


                            $existUser = DB::table('meterorcardno')->where('meterno', $meterno)->get();

                            if (count($existUser) != "1") {

                                $customers_id = DB::table('meterorcardno')->insertGetId([
                                    'user_id' => $customerid,
                                    'meterno' => $meterno,
                                    'pubid' => $pubid
                                ]);
                                /* $responseData = array('success' => '1', 'data' => $userData,  'data2' => $userHistory, 'message' => "Sign Up successfully!"); */
                            }



                            print $response;

                            $responseData = array('success' => '1', 'data' => $response, 'message' => 'Data has been returned successfully!');



                }else if($xx->responseCode == -1 || $xx->responseCode != 0){

                    print $response;


                    }else{



                        print 'Meter Incorect incorrect or Service down';
                    }

                }

                else{


                    print 'Server error, please try later';
                }

    }

}
 }











 public static function decoderpaymenturl($request){



    $referenceNumber = rand();  //public id with email
    $serviceID = $request->serviceID; //Service ID as specified by VTpass. In this case, it is dstv
    $billersCode = $request->billersCode;
    $variation_code = $request->variationcode;// VARIATION VALUES
    $amount = $request->amount;
    $phone = $request->customerPhoneNumber;
    $customerid = $request->userid;


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




            $host = 'https://vtpass.com/api/pay';
            $username = "eng.emmanuel@yahoo.com";
            $password = "Native@009";


            $data = array(
            "request_id" => $referenceNumber,
            "billersCode" => $billersCode,
            "variation_code" => $variation_code,
            "phone" => $phone,
            "amount" => $amount, //1
            "serviceID" => $serviceID
            );

            $curl  = curl_init();
            curl_setopt_array($curl, array(
            CURLOPT_URL => $host,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_USERPWD => $username.":" .$password,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $data,
            ));


            $response = curl_exec($curl);
            $payCustomer = json_decode($response);

            $responseCode =  $payCustomer->code;

            if($responseCode == "000"){

                $transactionId =  $payCustomer->content->transactions->transactionId;



                $bonusConfirmationCode = "N/A";


                $customers_id = DB::table('todos')->insertGetId([
                    'user_id' => $customerid,
                    'transactionId' => $transactionId,
                    'token' => $serviceID,
                    'amount' => $amount, //done
                    'meterno' => $billersCode,
                    'bonustoken' => $bonusConfirmationCode,
                    'created_at' => date('y-m-d h:i:s')
                ]);
            }


            print $response;

            $responseData = array('success' => '1', 'data' => $response, 'message' => 'Token data has been returned successfully!');



        //SECTION FOR PAYMENT WITH PG PAYMENT TRANSACTIONS



     }
 }












 //PAYMENT STARTS HERE ON AND ON


 public static function paymenturl($request){


        $referenceNumber = rand();  //public id with email
        $pubidwithemail = $request->email; //public id with email
        $meterSerial = $request->customerCodeAtBiller; //meter  number
        $amount = $request->amount; //amount
        $getpub = explode("@pay.com", $pubidwithemail);//split customer name
        $billerCode = $getpub[0];

        $CustomerPhone = $request->customerPhoneNumber;
        $customerFName = $request->customerFirstName;
        $customerLName = $request->customerLastName;
        $customerid = $request->userid;



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

            //DECODER VALIDATION STARTS HERE
            if($billerCode == "portharcourt-electric" || $billerCode == "ikeja-electric"   || $billerCode == "ibadan-electric"){


                $host = 'https://vtpass.com/api/pay';
                $service = "Prepaid";
                $username = "eng.emmanuel@yahoo.com";
                $password = "Native@009";


                $data = array(
                "request_id" => $referenceNumber,
                "billersCode" => $meterSerial,
                "variation_code" => $service,
                "phone" => $CustomerPhone,
                "amount" => $amount, //1
                "serviceID" => $billerCode
                );

                $curl  = curl_init();
                curl_setopt_array($curl, array(
                CURLOPT_URL => $host,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_USERPWD => $username.":" .$password,
                CURLOPT_TIMEOUT => 60,
                //CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => $data,
                ));


                $response = curl_exec($curl);
                $payCustomer = json_decode($response);

                if(isset($payCustomer->code)){

                    $responseCode =  $payCustomer->code;

                }else{

                }



                if($responseCode == "000" || isset($payCustomer->Token)){

                    if(isset($payCustomer->Token)){

                        $confirmationCode =  $payCustomer->Token;

                    }else{
                        $confirmationCode =  $payCustomer->token;
                    }


                    $transactionId =  $payCustomer->content->transactions->transactionId;

                    if(isset($payCustomer->content->transactions->created_at)){
                        $date =  $payCustomer->content->transactions->created_at;

                    }else{
                            $date = "N/A";
                    }


                    $bonusConfirmationCode = "N/A";

                    if(isset($payCustomer->Units)){
                        $units =  $payCustomer->Units;
                    }else if(isset($payCustomer->units)){
                        $units =  $payCustomer->units;

                    }else{
                        $units = "N/A";
                    }




                            //SEND SMS TO CUSTOMER STARTS NOW
                            //format phone number for SMS


                            $postUrl = "https://api.infobip.com/sms/1/text/advanced";
                            $destination = array(
                            "to" => $CustomerPhone);

                            $from = 'POWERLIGHT';
                            $message = array("from" => $from,
                            "destinations" => array($destination),
                            "text" => "Token: $confirmationCode, Units: $units, Pls share links with ur friends: Android: http://bit.ly/2VR6aUG, & IOS: https://apple.co/2SIhdxr #StaySafe",
                            );

                            $postData = array("messages" => array($message));
                            $postDataJson = json_encode($postData);
                            $ch = curl_init();
                            $header = array("Content-Type:application/json", "Accept:application/json");
                            curl_setopt($ch, CURLOPT_URL, $postUrl);
                            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
                            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
                            curl_setopt($ch, CURLOPT_USERPWD, "Iyen2244" . ":" . "password009");
                            curl_setopt($ch, CURLOPT_POST, 1);
                            curl_setopt($ch, CURLOPT_POSTFIELDS, $postDataJson);
                             curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                            // response of the POST request
                           // $response = curl_exec($ch);
                           // $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

                             curl_exec($ch);
                             curl_close($ch);




                    $customers_id = DB::table('todos')->insertGetId([
                        'user_id' => $customerid,
                        'transactionId' => $transactionId,
                        'token' => $confirmationCode,
                        'amount' => $amount, //done
                        'meterno' => $meterSerial,
                        'bonustoken' => $bonusConfirmationCode,
                        'created_at' => date('y-m-d h:i:s')
                    ]);



                    print $response;

                $responseData = array('success' => '1', 'data' => $response, 'message' => 'Token data has been returned successfully!');

                }else{



                    //SAVE RAW PASS
                     $customers_id2 = DB::table('logs')->insertGetId([
                        'user_id' => $customerid,
                        'message' => $response,
                        'meterno' => $meterSerial,
                        'date' => date('y-m-d h:i:s')

                    ]);




            print $response;
            $responseData = array('success' => '11', 'data' => $response, 'message' => 'Failed to process payment: Probable duplicate transaction submitted. Original transaction still processing. This transaction attempt not processed');



        }



            //SECTION FOR PAYMENT WITH PG PAYMENT TRANSACTIONS
    }else if($billerCode == "eedc_prepaid_custom" || $billerCode == "knedc_prepaid_custom"){




        $host = 'https://smartrecharge.ng/api/v2/electric/?';


        $data = array(
        'api_key' => "e919c64d",
        'meter_number'=> $meterSerial, //integer
        'product_code' =>  $billerCode, // integer
        //'task' => 'verify', //integer
        'amount' => 100
        );

        $curl  = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => $host,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        //CURLOPT_USERPWD => $username.":" .$password,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => $data,
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);


        $xx = json_decode($response);
        curl_close($curl);




        if($xx->server_message == "Transaction Successful"){


            $customers_id = DB::table('todos')->insertGetId([
                'user_id' => $customerid,
                'transactionId' => $xx->data->reference,
                'token' => $xx->data->token,
                'amount' => $amount, //done
                'meterno' => $meterSerial,
                'bonustoken' => "N/A",
                'created_at' => date('y-m-d h:i:s')
            ]);




            print $response;
            $responseData = array('success' => '1', 'data' => $response, 'message' => 'Data has been returned successfully!');


        }else{


            //SAVE RAW PASS
           $customers_id2 = DB::table('logs')->insertGetId([
              'user_id' => $customerid,
              'message' => $response,
              'meterno' => $meterSerial,
              'date' => date('y-m-d h:i:s')

          ]);


          print $response;
          $responseData = array('success' => '11', 'data' => $response, 'message' => 'Failed to process payment: Probable duplicate transaction submitted. Original transaction still processing. This transaction attempt not processed');

      }


}else{




               if($billerCode == '13B5041B-7143-46B1-9A88-F355AD7EA1EC'){

                     $serviceName  = "Search by meter number (mr)";
                }
                else if($billerCode == '51AE44EA-AF4D-401D-ACB5-8CEE818720AA'){

                      $serviceName = "Prepaid";
                }
               else{
                        $serviceName  = "Pre Paid";
                    }




            $curl = curl_init();
            $hmac = env('HMAC');
            $prin = env('PAGA_PRINCIPAL');
            $cred = env('PAGA_CRED');
            $hash= hash('sha512',$referenceNumber.$billerCode.$meterSerial.$CustomerPhone.$amount.$hmac);
            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://mypaga.com/paga-webservices/agent-rest/secured/payMerchant",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_HTTPHEADER => array(
                "Cache-Control: no-cache",
                "Content-Type: application/json",
                "credentials: $cred",
                "hash:".$hash,
                "principal: $prin"
                ),
            ));

            $records= array(
                 'referenceNumber' => $referenceNumber,
                 'billerPublicId'=> $billerCode,
                 'customerCodeAtBiller' => $meterSerial  ,   //$user_obj->meterno
                 'customerPhoneNumber' => $CustomerPhone,
                 'amount' => $amount,
                 'suppressRecipientMessages' => 'true',
                  'customerFirstName' => $customerFName,
                 'customerLastName' => $customerLName,
                 'serviceName' => $serviceName
                  );

                  $content = json_encode ( $records );

                  curl_setopt($curl, CURLOPT_POSTFIELDS, $content);

                  $response = curl_exec($curl);
                  $err = curl_error($curl);
                  curl_close($curl);

                $payCustomer = json_decode($response);


                $responseCode =  $payCustomer->responseCode;
                $confirmationCode = $payCustomer->confirmationCode;
                $bonusConfirmationCode = $payCustomer->bonusConfirmationCode;
                $transactionId = $payCustomer->transactionId;

                  if ($responseCode == 0 ) {


                        $customers_id = DB::table('todos')->insertGetId([
                            'user_id' => $customerid,
                            'transactionId' => $transactionId,
                            'token' => $confirmationCode,
                            'amount' => $amount, //done
                            'meterno' => $meterSerial,
                            'bonustoken' => $bonusConfirmationCode,
                            'created_at' => date('y-m-d h:i:s')
                        ]);




                        if(isset($payCustomer->Units)){
                            $units =  $payCustomer->Units;
                        }else if(isset($payCustomer->units)){
                            $units =  $payCustomer->units;

                        }else{
                            $units = "N/A";
                        }





                            //SEND SMS TO CUSTOMER STARTS NOW
                            //format phone number for SMS


                            $postUrl = "https://api.infobip.com/sms/1/text/advanced";
                            $destination = array(
                            "to" => $CustomerPhone);

                            $from = 'POWERLIGHT';
                            $message = array("from" => $from,
                            "destinations" => array($destination),
                            "text" => "Token: $confirmationCode, Units: $units, Pls share links with ur friends: Android: http://bit.ly/2VR6aUG, & IOS: https://apple.co/2SIhdxr #StaySafe",
                            );

                            $postData = array("messages" => array($message));
                            $postDataJson = json_encode($postData);
                            $ch = curl_init();
                            $header = array("Content-Type:application/json", "Accept:application/json");
                            curl_setopt($ch, CURLOPT_URL, $postUrl);
                            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
                            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
                            curl_setopt($ch, CURLOPT_USERPWD, "Iyen2244" . ":" . "password009");
                            curl_setopt($ch, CURLOPT_POST, 1);
                            curl_setopt($ch, CURLOPT_POSTFIELDS, $postDataJson);
                             curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                            // response of the POST request
                           // $response = curl_exec($ch);
                           // $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

                             curl_exec($ch);
                             curl_close($ch);


                        /* $responseData = array('success' => '1', 'data' => $userData,  'data2' => $userHistory, 'message' => "Sign Up successfully!"); */




                print $response;

                $responseData = array('success' => '1', 'data' => $response, 'message' => 'Token data has been returned successfully!');



                }else{


                      //SAVE RAW PASS
                     $customers_id2 = DB::table('logs')->insertGetId([
                        'user_id' => $customerid,
                        'message' => $response,
                        'meterno' => $meterSerial,
                        'date' => date('y-m-d h:i:s')

                    ]);


                    print $response;
                    $responseData = array('success' => '11', 'data' => $response, 'message' => 'Failed to process payment: Probable duplicate transaction submitted. Original transaction still processing. This transaction attempt not processed');

                }




                }

                }
                }






 //banners history
public static function getoldmeters($request){
    $consumer_data 		 				  =  array();
    $consumer_data['consumer_key'] 	 	  =  request()->header('consumer-key');
    $consumer_data['consumer_secret']	  =  request()->header('consumer-secret');
    $consumer_data['consumer_nonce']	  =  request()->header('consumer-nonce');
    $consumer_data['consumer_device_id']  =  request()->header('consumer-device-id');
    $consumer_data['consumer_ip']  	  = request()->header('consumer-ip');
    $consumer_data['consumer_url']  	  =  __FUNCTION__;
    $authController = new AppSettingController();
    $authenticate = $authController->apiAuthenticate($consumer_data);

    if($authenticate==1){



      $custmrid = $request->userid;


      $savedmeters = DB::table('meterorcardno')
             ->where('user_id', '=', $custmrid)
             ->where('meterno', '!=', 0)
             ->get();


      //if already clicked by other user
      if(count($savedmeters) > 0){

        $data = array();
        $responseData = array('success'=>'1', 'data'=>$savedmeters, 'message'=>"banner history has been added.");


      }else{

        $data = array();
        $responseData = array('success'=>'12', 'message'=>"No meter history");


      }



    }else{
      $responseData = array('success'=>'0', 'data'=>array(),  'message'=>"Unauthenticated call.");
    }

    $response = json_encode($responseData);
    print $response;
  }













    public static function recover($request)
    {


       // return  request()->header('consumer-key');
        $consumer_data = array();
        $consumer_data['consumer_key'] = request()->header('consumer-key');
        $consumer_data['consumer_secret'] = request()->header('consumer-secret');
        $consumer_data['consumer_nonce'] = request()->header('consumer-nonce');
        $consumer_data['consumer_url'] = __FUNCTION__; // 'processlogin' is returns here

        $authController = new AppSettingController();
        $authenticate = $authController->apiAuthenticate($consumer_data);


        if ($authenticate == 1){


            $phonenumber = $request->phone;


                $existUser = DB::table('passsaver')
                    ->where('phonenumber', $phonenumber)->get();


              //  dd($existUser) ;

                if (count($existUser) > 0) {

                            $password = $existUser[0]->passtext;
                            $CustomerPhone = preg_replace('/^0/','234',$phonenumber);


                            //SEND SMS TO CUSTOMER STARTS NOW
                            //format phone number for SMS

                            $postUrl = "https://api.infobip.com/sms/1/text/advanced";
                            $destination = array(
                            "to" => $CustomerPhone);

                            $from = 'POWERLIGHT';
                            $message = array("from" => $from,
                            "destinations" => array($destination),
                            "text" => "Your Powerlight password is:  ($password), Please reopen the app to login with your phone number and this password. #StaySafe",
                            );

                            $postData = array("messages" => array($message));
                            $postDataJson = json_encode($postData);
                            $ch = curl_init();
                            $header = array("Content-Type:application/json", "Accept:application/json");
                            curl_setopt($ch, CURLOPT_URL, $postUrl);
                            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
                            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
                            curl_setopt($ch, CURLOPT_USERPWD, "Iyen2244" . ":" . "password009");
                            curl_setopt($ch, CURLOPT_POST, 1);
                            curl_setopt($ch, CURLOPT_POSTFIELDS, $postDataJson);
                             curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                            // response of the POST request
                           // $response = curl_exec($ch);
                           // $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

                             curl_exec($ch);
                             curl_close($ch);







                    $responseData = array('success' => '0', 'data' => $password, 'message' => 'Your password has been successfully sent to your registered phone number via sms');

                } else {
                    $responseData = array('success' => '12', 'data' => array(), 'message' => "No account found with phone number.");

                }

       } else {
            $responseData = array('success' => '0', 'data' => array(), 'message' => "Unauthenticated call.");
        }
        $userResponse = json_encode($responseData);

        return $userResponse;
    }












  public static function chargePaymentPK($request){
    $consumer_data 		 				  =  array();
    $consumer_data['consumer_key'] 	 	  =  request()->header('consumer-key');
    $consumer_data['consumer_secret']	  =  request()->header('consumer-secret');
    $consumer_data['consumer_nonce']	  =  request()->header('consumer-nonce');
    $consumer_data['consumer_device_id']  =  request()->header('consumer-device-id');
    $consumer_data['consumer_ip']  	  = request()->header('consumer-ip');
    $consumer_data['consumer_url']  	  =  __FUNCTION__;
    $authController = new AppSettingController();
    $authenticate = $authController->apiAuthenticate($consumer_data);

    if($authenticate==1){


        //$token = "sk_test_c3f418084c3d429148e01c6568f3cc04d9f17fbe";
        $token = "sk_test_3fac7cd100838192910c52df16b95531b0b89cb7";
        $curl = curl_init('https://api.paystack.co/transaction/charge_authorization');


        $tokencode = $request->code;
        $email = $request->mail;
        $amount = $request->amounting * 100;


         curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
         curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
         curl_setopt($curl, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Authorization: Bearer ' . $token,
          ));


           $data = array(
            'amount' => $amount,
            'authorization_code'=> $tokencode,
            'email' => $email

             );


        $content = json_encode($data);

        curl_setopt($curl, CURLOPT_POSTFIELDS, $content);
        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);


        $tranx = json_decode($response, true);

        if($tranx['data']['status'] == "success"){




           print $tranx['status'];


            $data = array();
            $responseData = array('success' => '1', 'data' => $tranx['data']['status'], 'message' => "Worked");





    }else{

        print "990";



        $data = array();
        $responseData = array('success' => '12', 'data' => $tranx, 'message' => "Failed");

    }

}



}








//GET USER ACCOUNTS WHO ALREADY HAVE PAYSTACK ACCOUNTS
public static function getuserPKaccount($request){
    $consumer_data 		 				  =  array();
    $consumer_data['consumer_key'] 	 	  =  request()->header('consumer-key');
    $consumer_data['consumer_secret']	  =  request()->header('consumer-secret');
    $consumer_data['consumer_nonce']	  =  request()->header('consumer-nonce');
    $consumer_data['consumer_device_id']  =  request()->header('consumer-device-id');
    $consumer_data['consumer_ip']  	  = request()->header('consumer-ip');
    $consumer_data['consumer_url']  	  =  __FUNCTION__;
    $authController = new AppSettingController();
    $authenticate = $authController->apiAuthenticate($consumer_data);

    if($authenticate==1){


      $custmrid = $request->userid;


      $savedmeters = DB::table('pykcodes')
             ->where('userID', '=', $custmrid)

             ->get()->last();



      //if already clicked by other user
      if($savedmeters){

        $data = array();
        $responseData = array('success'=>'1', 'data'=>$savedmeters, 'message'=> "Account details retrived from database.");


      }else{

        $data = array();
        $responseData = array('success'=>'12', 'message'=>"No Account history");


      }



    }else{
      $responseData = array('success'=>'0', 'data'=>array(),  'message'=>"Unauthenticated call.");
    }

    $response = json_encode($responseData);
    print $response;
  }























//GET USER ACCOUNTS WHO ALREADY HAVE MONNIFY
  public static function getaccount($request){
    $consumer_data 		 				  =  array();
    $consumer_data['consumer_key'] 	 	  =  request()->header('consumer-key');
    $consumer_data['consumer_secret']	  =  request()->header('consumer-secret');
    $consumer_data['consumer_nonce']	  =  request()->header('consumer-nonce');
    $consumer_data['consumer_device_id']  =  request()->header('consumer-device-id');
    $consumer_data['consumer_ip']  	  = request()->header('consumer-ip');
    $consumer_data['consumer_url']  	  =  __FUNCTION__;
    $authController = new AppSettingController();
    $authenticate = $authController->apiAuthenticate($consumer_data);

    if($authenticate==1){



      $custmrid = $request->userid;
      $meterno = $request->meterno;
      $customerPhoneNumber = $request->customerPhoneNumber;


      $savedmeters = DB::table('monnifyaccounts')
             ->where('user_id', '=', $custmrid)
             ->where('meter', '=', $meterno)
             ->where('phone', '=', $customerPhoneNumber)
             ->get();


      //if already clicked by other user
      if(count($savedmeters) > 0){

        $data = array();
        $responseData = array('success'=>'1', 'data'=>$savedmeters, 'message'=> "Account details retrived from database.");


      }else{

        $data = array();
        $responseData = array('success'=>'12', 'message'=>"No Account history");


      }



    }else{
      $responseData = array('success'=>'0', 'data'=>array(),  'message'=>"Unauthenticated call.");
    }

    $response = json_encode($responseData);
    print $response;
  }







  //Verify transaction for others execept enugu
  public static function verifytranx($request)
  {

      $reference = $request->ref;
      $customers_id = $request->userid;

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

            $curl = curl_init();
            if(!$reference){
            die('No reference supplied');
            }
            curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.paystack.co/transaction/verify/" . rawurlencode($reference),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                "accept: application/json",
                "authorization: Bearer sk_test_3fac7cd100838192910c52df16b95531b0b89cb7",
                "cache-control: no-cache"
            ],
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);

            $tranx = json_decode($response, true);

            if($tranx['status'] == true){


                if(isset($tranx['data']['authorization']['authorization_code']) && ($tranx['data']['authorization']['reusable'] == true) ){


                    $code = $tranx['data']['authorization']['authorization_code'];
                    $reuse = $tranx['data']['authorization']['reusable'];
                    $email =  $tranx['data']['customer']['email'];
                    $ending = $tranx['data']['authorization']['last4'];

                    $customers_id = DB::table('pykcodes')->insertGetId([
                        'pkcodessck' => $code,
                        'userID' => $customers_id,
                        'usability' => $reuse,
                        'email' => $email,
                        'ending' => $ending,

                    ]);


                }

              //  print $tranx['message'];


                $data = array();
                $responseData = array('success' => '0', 'data' => $tranx['message'], 'message' => "Worked");







            // there was an error from the API

            }else{


                $data = array();
                $responseData = array('success' => '0', 'message' => "Unverified Payment");

            }




      } else {
          $responseData = array('success' => '0', 'data' => array(), 'message' => "Unauthenticated call.");
      }

      $userResponse = json_encode($responseData);
      return $userResponse;





  }














  //Verify transaction for Enugu
  public static function verifytranxenugu($request)
  {

      $reference = $request->ref;
      $customers_id = $request->userid;

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

            $curl = curl_init();
            if(!$reference){
            die('No reference supplied');
            }
            curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.paystack.co/transaction/verify/" . rawurlencode($reference),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                "accept: application/json",
                "authorization: Bearer sk_test_841226c55fb4489b41a5bfcc3809421d00484ca6",
                "cache-control: no-cache"
            ],
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);

            $tranx = json_decode($response, true);

            if($tranx['status'] == true){


                if(isset($tranx['data']['authorization']['authorization_code']) && ($tranx['data']['authorization']['reusable'] == true) ){


                    $code = $tranx['data']['authorization']['authorization_code'];
                    $reuse = $tranx['data']['authorization']['reusable'];
                    $email =  $tranx['data']['customer']['email'];
                    $ending = $tranx['data']['authorization']['last4'];

                    $customers_id = DB::table('pykcodes')->insertGetId([
                        'pkcodessck' => $code,
                        'userID' => $customers_id,
                        'usability' => $reuse,
                        'email' => $email,
                        'ending' => $ending,

                    ]);


                }

              //  print $tranx['message'];


                $data = array();
                $responseData = array('success' => '0', 'data' => $tranx['message'], 'message' => "Worked");







            // there was an error from the API

            }else{


                $data = array();
                $responseData = array('success' => '0', 'message' => "Unverified Payment");

            }




      } else {
          $responseData = array('success' => '0', 'data' => array(), 'message' => "Unauthenticated call.");
      }

      $userResponse = json_encode($responseData);
      return $userResponse;





  }
































    public static function updatesalesrecord($request)
    {


        $salesamt            			=       $request->salesamt;
        $leakage           	            =       $request->leakage;
        $returned                       =       $request->Returned;
        $actual                         =       $request->actualsales;
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
        $customers_id = DB::table('sales')->insertGetId([
            'user_id' => $int,
            'debt' => $request->debt,
            'leakage' => $request->leakage,
            'sales' => $request->salesamt,
            'actualsales'   =>  $actual,
            'created_at' => date('y-m-d h:i:s')

        ]);


        $usersc = User::find($int);

        $olddayout =   $usersc->dayout;


        $updateretuned = DB::table('users')->where('id', $int)
        ->update([
            'dayout' => $olddayout - $request->salesamt - $leakage
            ]);




        $debtid = DB::table('debts')->where('user_id', $int)->update([
            'debtOwed' => $request->debt
        ]);

        $responseData = array(['success'=>'1',  'message'=>"Sucessfully sent to Sales Manager for Approval"]);


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
