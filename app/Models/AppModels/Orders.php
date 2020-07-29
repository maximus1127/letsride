<?php

namespace App\Models\AppModels;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Admin\AdminSiteSettingController;
use App\Http\Controllers\Admin\AdminCategoriesController;
use App\Http\Controllers\Admin\AdminProductsController;
use App\Http\Controllers\App\AppSettingController;
use App\Http\Controllers\App\AlertController;
use DB;
use Lang;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Validator;
use Mail;
use DateTime;
use Auth;
use Carbon\Carbon;


class Orders extends Model
{

  public static function convertprice($current_price, $requested_currency)
  {
    $required_currency = DB::table('currencies')->where('is_current',1)->where('code', $requested_currency)->first();
    $products_price = $current_price * $required_currency->value;

    return $products_price;
  }

  public static function converttodefaultprice($current_price, $requested_currency)
  {
    $required_currency = DB::table('currencies')->where('is_current',1)->where('code', $requested_currency)->first();
    $products_price = $current_price * $required_currency->value;
    return $products_price;
  }

  public static function currencies($currency_code){
   $currencies = DB::table('currencies')->where('is_current',1)->where('code', $currency_code)->first();
   return $currency_code;
  }

 public static function hyperpaytoken($request)
{
  $consumer_data 		 				  =  array();
  $consumer_data['consumer_key'] 	 	  =  request()->header('consumer-key');
  $consumer_data['consumer_secret']	  =  request()->header('consumer-secret');
  $consumer_data['consumer_nonce']	  =  request()->header('consumer-nonce');
  $consumer_data['consumer_device_id']  =  request()->header('consumer-device-id');
  $consumer_data['consumer_ip']  =  request()->header('consumer-ip');
  $consumer_data['consumer_url']  	  =  __FUNCTION__;
  $authController = new AppSettingController();
  $authenticate = $authController->apiAuthenticate($consumer_data);

  if($authenticate==1){
    $payments_setting = Orders::payments_setting_for_hyperpay($request);

    //check envinment
    if($payments_setting[0]->hyperpay_enviroment == '0'){
      $env_url = "https://test.oppwa.com/v1/checkouts";
    }else{
      $env_url = "https://oppwa.com/v1/checkouts";
    }

    //use currency account currency only e:g. 'SAR'
    $url = $env_url;
    $data = "authentication.userId=" .$payments_setting['userid']->value.
			"&authentication.password=" .$payments_setting['password']->value.
			"&authentication.entityId=" .$payments_setting['entityid']->value.
      "&amount=" . $request->amount.
      "&currency=SAR" .
      "&paymentType=DB".
      "&customer.email=".$request->email.
      "&testMode=INTERNAL".
      "&merchantTransactionId=". uniqid();

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $responseData = curl_exec($ch);
    if(curl_errno($ch)) {
      return curl_error($ch);
    }
    curl_close($ch);

    $data = json_decode($responseData);

    if($data->result->code=='000.200.100'){
      $responseData = array('success'=>'1', 'token'=>$data->id, 'message'=>"Token generated.");
    }else{
      $responseData = array('success'=>'2', 'token'=>array(), 'message'=>$data->result->description);
    }

  }else{
    $responseData = array('success'=>'0', 'data'=>array(),  'message'=>"Unauthenticated call.");
  }
  $orderResponse = json_encode($responseData);

  return $orderResponse;
}

public static function generatebraintreetoken()
{
  $consumer_data 		 				  =  array();
  $consumer_data['consumer_key'] 	 	  =  request()->header('consumer-key');
  $consumer_data['consumer_secret']	  =  request()->header('consumer-secret');
  $consumer_data['consumer_nonce']	  =  request()->header('consumer-nonce');
  $consumer_data['consumer_device_id']  =  request()->header('consumer-device-id');
  $consumer_data['consumer_ip']  =  request()->header('consumer-ip');
  $consumer_data['consumer_url']  	  =  __FUNCTION__;
  $authController = new AppSettingController();
  $authenticate = $authController->apiAuthenticate($consumer_data);

  if($authenticate==1){
    $payments_setting = Orders::payments_setting_for_brain_tree($request);

    //braintree transaction get nonce
    $is_transaction  = '0'; 			# For payment through braintree

    if($payments_setting['merchant_id']->environment == '0'){
			$braintree_environment = 'sandbox';
		}else{
			$environment = 'production';
    }

    $braintree_merchant_id = $payments_setting['merchant_id']->value;
    $braintree_public_key  = $payments_setting['public_key']->value;
    $braintree_private_key = $payments_setting['private_key']->value;

    //for token please check braintree.php file
    require_once app_path('braintree/Braintree.php');

    $responseData = array('success'=>'1', 'token'=>$clientToken, 'message'=>"Token generated.");
  }else{
    $responseData = array('success'=>'0', 'data'=>array(),  'message'=>"Unauthenticated call.");
  }
  $orderResponse = json_encode($responseData);

  return $orderResponse;
}

public static function getpaymentmethods($request)
{
  $consumer_data 		 				  =  array();
  $consumer_data['consumer_key'] 	 	  =  request()->header('consumer-key');
  $consumer_data['consumer_secret']	  =  request()->header('consumer-secret');
  $consumer_data['consumer_nonce']	  =  request()->header('consumer-nonce');
  $consumer_data['consumer_device_id']  =  request()->header('consumer-device-id');
  $consumer_data['consumer_ip']  =  request()->header('consumer-ip');
  $consumer_data['consumer_url']  	  =  __FUNCTION__;

  $authController = new AppSettingController();
  $authenticate = $authController->apiAuthenticate($consumer_data);

  if($authenticate==1){

    $result = array();
    $payments_setting = Orders::payments_setting_for_brain_tree($request);

		if($payments_setting['merchant_id']->environment=='0'){
			$braintree_enviroment = 'Test';
		}else{
			$braintree_enviroment = 'Live';
		}

    $braintree_card = array(
      'auth_token' => '',
      'client_id' => '',
      'client_secret' => '',
      'environment' => $braintree_enviroment,
			'name' => $payments_setting['merchant_id']->name,
			'public_key' => $payments_setting['public_key']->value,
			'active' => $payments_setting['merchant_id']->status,
			'payment_method'=>$payments_setting['merchant_id']->payment_method,
			'method'=>'braintree_card',
    );

    $braintree_paypal = array(
      'auth_token' => '',
      'client_id' => '',
      'client_secret' => '',
      'environment' => $braintree_enviroment,
			'name' => $payments_setting['merchant_id']->sub_name_2,
			'public_key' => $payments_setting['public_key']->value,
			'active' => $payments_setting['merchant_id']->status,
			'payment_method'=>$payments_setting['merchant_id']->payment_method,
			'method' => 'braintree_paypal',
    );

    $payments_setting = Orders::payments_setting_for_stripe($request);

    if($payments_setting['publishable_key']->environment=='0'){
      $stripe_enviroment = 'Test';
    }else{
      $stripe_enviroment = 'Live';
    }

    $stripe = array(
      'auth_token' => '',
      'client_id' => '',
      'client_secret' => '',
      'environment' => $stripe_enviroment,
      'name' => $payments_setting['publishable_key']->name,
      'public_key' => $payments_setting['publishable_key']->value,
      'active' => $payments_setting['publishable_key']->status,
			'payment_method'=>$payments_setting['publishable_key']->payment_method,
			'method' => 'stripe',
    );

    $payments_setting = Orders::payments_setting_for_cod($request);

    $cod = array(
      'environment' => '',
      'method' => 'cod',
      'public_key' => '',
      'auth_token' => '',
      'client_id' => '',
      'client_secret' => '',
      'name' => $payments_setting->name,
      'active' => $payments_setting->status,
			'payment_method'=>'cod'
    );

    $payments_setting = Orders::payments_setting_for_paypal($request);

    if($payments_setting['id']->environment=='0'){
			$paypal_enviroment = 'Test';
		}else{
			$paypal_enviroment = 'Live';
		}

    $paypal = array(
      'method' => 'paypal',
      'auth_token' => '',
      'client_id' => '',
      'client_secret' => '',
      'environment' => $paypal_enviroment,
			'name' => $payments_setting['id']->name,
			'public_key' => $payments_setting['id']->value,
			'active' => $payments_setting['id']->status,
			'payment_method'=>$payments_setting['id']->payment_method,
    );


    $payments_setting = Orders::payments_setting_for_instamojo($request);

    if($payments_setting['auth_token']->environment=='0'){
			$instamojo_enviroment = 'Test';
		}else{
			$instamojo_enviroment = 'Live';
		}

    $instamojo = array(
      'environment' => $instamojo_enviroment,
      'name' => $payments_setting['auth_token']->name,
      'method' => 'instamojo',
      'public_key' => $payments_setting['api_key']->value,
      'auth_token' => $payments_setting['auth_token']->value,
      'client_id' => $payments_setting['client_id']->value,
      'client_secret' => $payments_setting['client_secret']->value,
      'active' => $payments_setting['api_key']->status,
			'payment_method'=>'instamojo',
    );

    $payments_setting = Orders::payments_setting_for_hyperpay($request);

    if($payments_setting['userid']->environment=='0'){
			$hyperpay_enviroment = 'Test';
		}else{
			$hyperpay_enviroment = 'Live';
		}


    $hyperpay = array(
      'method' => 'hyperpay',
      'public_key' => '',
      'auth_token' => '',
      'client_id' => '',
      'client_secret' => '',
      'environment' => $hyperpay_enviroment,
      'name' => $payments_setting['userid']->name,
      'active' => $payments_setting['userid']->status,
			'payment_method'=>'hyperpay',
    );


    $result[0] = $braintree_card;
    $result[1] = $braintree_paypal;
    $result[2] = $stripe;
    $result[3] = $cod;
    $result[4] = $paypal;
    $result[5] = $instamojo;
    $result[6] = $hyperpay;

    $responseData = array('success'=>'1', 'data'=>$result, 'message'=>"Payment methods are returned.");
  }else{
    $responseData = array('success'=>'0', 'data'=>array(),  'message'=>"Unauthenticated call.");
  }
  $orderResponse = json_encode($responseData);

  return $orderResponse;
}

public static function payments_setting_for_brain_tree($request){
  $payments_setting = DB::table('payment_methods_detail')
  ->leftjoin('payment_description', 'payment_description.payment_methods_id', '=', 'payment_methods_detail.payment_methods_id')
  ->leftjoin('payment_methods', 'payment_methods.payment_methods_id', '=', 'payment_methods_detail.payment_methods_id')
  ->select('payment_methods_detail.*','payment_description.sub_name_1','payment_description.sub_name_2','payment_description.name', 'payment_methods.environment', 'payment_methods.status', 'payment_methods.payment_method')
  ->where('language_id', $request->language_id)
  ->where('payment_description.payment_methods_id',1)->get()->keyBy('key');
  return $payments_setting;
}

public static function payments_setting_for_stripe($request){
  $payments_setting = DB::table('payment_methods_detail')
  ->leftjoin('payment_description', 'payment_description.payment_methods_id', '=', 'payment_methods_detail.payment_methods_id')
  ->leftjoin('payment_methods', 'payment_methods.payment_methods_id', '=', 'payment_methods_detail.payment_methods_id')
  ->select('payment_methods_detail.*', 'payment_description.name', 'payment_methods.environment', 'payment_methods.status', 'payment_methods.payment_method')
  ->where('language_id', $request->language_id)
  ->where('payment_description.payment_methods_id',2)->get()->keyBy('key');
  return $payments_setting;
}

public static function payments_setting_for_cod($request){
  $payments_setting = DB::table('payment_description')
  ->leftjoin('payment_methods', 'payment_methods.payment_methods_id', '=', 'payment_description.payment_methods_id')
  ->select('payment_description.name', 'payment_methods.environment', 'payment_methods.status', 'payment_methods.payment_method')
  ->where('language_id', $request->language_id)
  ->where('payment_description.payment_methods_id',4)->first();
  return $payments_setting;
}

public static function payments_setting_for_paypal($request){
  $payments_setting = DB::table('payment_methods_detail')
  ->leftjoin('payment_description', 'payment_description.payment_methods_id', '=', 'payment_methods_detail.payment_methods_id')
  ->leftjoin('payment_methods', 'payment_methods.payment_methods_id', '=', 'payment_methods_detail.payment_methods_id')
  ->select('payment_methods_detail.*', 'payment_description.name', 'payment_methods.environment', 'payment_methods.status', 'payment_methods.payment_method')
  ->where('language_id', $request->language_id)
  ->where('payment_description.payment_methods_id',3)->get()->keyBy('key');
  return $payments_setting;
}

public static function payments_setting_for_instamojo($request){
  $payments_setting = DB::table('payment_methods_detail')
  ->leftjoin('payment_description', 'payment_description.payment_methods_id', '=', 'payment_methods_detail.payment_methods_id')
  ->leftjoin('payment_methods', 'payment_methods.payment_methods_id', '=', 'payment_methods_detail.payment_methods_id')
  ->select('payment_methods_detail.*', 'payment_description.name', 'payment_methods.environment', 'payment_methods.status', 'payment_methods.payment_method')
  ->where('language_id', $request->language_id)
  ->where('payment_description.payment_methods_id',5)->get()->keyBy('key');
  return $payments_setting;
}

public static function payments_setting_for_hyperpay($request){
  $payments_setting = DB::table('payment_methods_detail')
  ->leftjoin('payment_description', 'payment_description.payment_methods_id', '=', 'payment_methods_detail.payment_methods_id')
  ->leftjoin('payment_methods', 'payment_methods.payment_methods_id', '=', 'payment_methods_detail.payment_methods_id')
  ->select('payment_methods_detail.*', 'payment_description.name', 'payment_methods.environment', 'payment_methods.status', 'payment_methods.payment_method')
  ->where('language_id', $request->language_id)
  ->where('payment_description.payment_methods_id',6)->get()->keyBy('key');
  return $payments_setting;
}

public static function getrate($request)
{
  $consumer_data 		 				  =  array();
  $consumer_data['consumer_key'] 	 	  =  request()->header('consumer-key');
  $consumer_data['consumer_secret']	  =  request()->header('consumer-secret');
  $consumer_data['consumer_nonce']	  =  request()->header('consumer-nonce');
  $consumer_data['consumer_device_id']  =  request()->header('consumer-device-id');
  $consumer_data['consumer_ip']  =  request()->header('consumer-ip');
  $consumer_data['consumer_url']  	  =  __FUNCTION__;
  $authController = new AppSettingController();
  $authenticate = $authController->apiAuthenticate($consumer_data);

  if($authenticate==1){

    //tax rate
    $tax_zone_id   			=   $request->tax_zone_id;
    $requested_currency =   $request->currency_code;

    $index = '0';
    $total_tax = '0';
    $is_number = true;
    foreach($request->products as $products_data){
      $final_price = $request->products[$index]['final_price'];
      $products = DB::table('products')
        ->LeftJoin('tax_rates', 'tax_rates.tax_class_id','=','products.products_tax_class_id')
        ->where('tax_rates.tax_zone_id', $tax_zone_id)
        ->where('products_id', $products_data['products_id'])->get();
      if(count($products)>0){
        $tax_value = $products[0]->tax_rate/100*$final_price;
        $total_tax = $total_tax+$tax_value;
        $index++;
      }
    }

    if($total_tax>0){
      $total_tax = Orders::convertprice($total_tax, $requested_currency);
      $data['tax'] = $total_tax;
    }else{
      $data['tax'] = '0';
    }


    $countries = DB::table('countries')->where('countries_id','=',$request->country_id)->get();

    //website path
    $websiteURL =  "http://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
    $replaceURL = str_replace('getRate','', $websiteURL);
    $requiredURL = $replaceURL.'app/ups/ups.php';


    //default shipping method
    $shippings = DB::table('shipping_methods')->get();

    $result = array();

    foreach($shippings as $shipping_methods){
      //ups shipping rate
      if($shipping_methods->methods_type_link == 'upsShipping' and $shipping_methods->status == '1'){
        $result2= array();
        $is_transaction = '0';

        $ups_shipping = DB::table('ups_shipping')->where('ups_id', '=', '1')->get();

        //shipp from and all credentials
        $accessKey  = $ups_shipping[0]->access_key;
        $userId 	= $ups_shipping[0]->user_name;
        $password 	= $ups_shipping[0]->password;

        //ship from address
        $fromAddress  = $ups_shipping[0]->address_line_1;
        $fromPostalCode  = $ups_shipping[0]->post_code;
        $fromCity  = $ups_shipping[0]->city;
        $fromState  = $ups_shipping[0]->state;
        $fromCountry  = $ups_shipping[0]->country;

        //ship to address
        $toPostalCode = $request->postcode;
        $toCity = $request->city;
        $toState = $request->state;
        $toCountry = $countries[0]->countries_iso_code_2;
        $toAddress = $request->street_address;

        //product detail
        $products_weight = $request->products_weight;
        $products_weight_unit = $request->products_weight_unit;

        //change G or KG to LBS
        if($products_weight_unit=='g'){
          $productsWeight = $products_weight/453.59237;
        }else if($products_weight_unit=='kg'){
          $productsWeight = $products_weight/0.45359237;
        }

        //production or test mode
        if($ups_shipping[0]->shippingEnvironment == 1){ 			#production mode
          $useIntegration = true;
        }else{
          $useIntegration = false;								#test mode
        }

        $serviceData = explode(',',$ups_shipping[0]->serviceType);


        $index = 0;
        $description = DB::table('shipping_description')->where([
                  ['language_id', '=', $request->language_id],
                  ['table_name', '=',  'ups_shipping'],
                ])->get();

        $sub_labels = json_decode($description[0]->sub_labels);

        foreach($serviceData as $value){
          if($value == "US_01")
          {
            $name = $sub_labels->nextDayAir;
            $serviceTtype = "1DA";
          }
          else if ($value == "US_02")
          {
            $name = $sub_labels->secondDayAir;
            $serviceTtype = "2DA";
          }
            else if ($value == "US_03")
          {
            $name = $sub_labels->ground;
            $serviceTtype = "GND";
          }
          else if ($value == "US_12")
          {
            $name = $sub_labels->threeDaySelect;
            $serviceTtype = "3DS";
          }
          else if ($value == "US_13")
          {
            $name = $sub_labels->nextDayAirSaver;
            $serviceTtype = "1DP";
          }
          else if ($value == "US_14")
          {
            $name = $sub_labels->nextDayAirEarlyAM;
            $serviceTtype = "1DM";
          }
          else if ($value == "US_59")
          {
            $name = $sub_labels->secondndDayAirAM;
            $serviceTtype = "2DM";
          }
          else if($value == "IN_07")
          {
            $name = Lang::get("labels.Worldwide Express");
            $serviceTtype = "UPSWWE";
          }
          else if ($value == "IN_08")
          {
            $name = Lang::get("labels.Worldwide Expedited");
            $serviceTtype = "UPSWWX";
          }
          else if ($value == "IN_11")
          {
            $name = Lang::get("labels.Standard");
            $serviceTtype = "UPSSTD";
          }
          else if ($value == "IN_54")
          {
            $name = Lang::get("labels.Worldwide Express Plus");
            $serviceTtype = "UPSWWEXPP";
          }

        $some_data = array(
          'access_key' => $accessKey,  						# UPS License Number
          'user_name' => $userId,								# UPS Username
          'password' => $password, 							# UPS Password
          'pickUpType' => '03',								# Drop Off Location
          'shipToPostalCode' => $toPostalCode, 				# Destination  Postal Code
          'shipToCountryCode' => $toCountry,					# Destination  Country
          'shipFromPostalCode' => $fromPostalCode, 			# Origin Postal Code
          'shipFromCountryCode' => $fromCountry,				# Origin Country
          'residentialIndicator' => 'IN', 					# Residence Shipping and for commercial shipping "COM"
          'cServiceCodes' => $serviceTtype, 					# Sipping rate for UPS Ground
          'packagingType' => '02',
          'packageWeight' => $productsWeight
          );

          $curl = curl_init();
          // You can also set the URL you want to communicate with by doing this:
          // $curl = curl_init('http://localhost/echoservice');

          // We POST the data
          curl_setopt($curl, CURLOPT_POST, 1);
          // Set the url path we want to call
          curl_setopt($curl, CURLOPT_URL, $requiredURL);
          // Make it so the data coming back is put into a string
          curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
          // Insert the data
          curl_setopt($curl, CURLOPT_POSTFIELDS, $some_data);

          // You can also bunch the above commands into an array if you choose using: curl_setopt_array

          // Send the request
          $rate = curl_exec($curl);
          // Free up the resources $curl is using
          curl_close($curl);
         $ups_description = DB::table('shipping_description')->where('table_name','ups_shipping')->where('language_id',$request->language_id)->get();
         if(!empty($ups_description[0]->name)){
          $methodName = $ups_description[0]->name;
         }else{
          $methodName = 'UPS Shipping';
         }
         if (is_numeric($rate)){
          $rate = Orders::convertprice($rate, $requested_currency);
          $success = array('success'=>'1', 'message'=>"Rate is returned.", 'name'=>$methodName);
          $result2[$index] = array('name'=>$name,'rate'=>$rate,'currencyCode'=>$requested_currency,'shipping_method'=>'upsShipping');
          $index++;
         }
         else{
          $success = array('success'=>'0','message'=>"Selected regions are not supported for UPS shipping", 'name'=>$ups_description[0]->name);
         }

          $success['services'] = $result2;
          $result['upsShipping'] = $success;

        }


      }else if($shipping_methods->methods_type_link == 'flateRate' and $shipping_methods->status == '1'){
        $description = DB::table('shipping_description')->where('table_name','flate_rate')->where('language_id',$request->language_id)->get();

        if(!empty($description[0]->name)){
          $methodName = $description[0]->name;
        }else{
          $methodName = 'Flate Rate';
        }

        $ups_shipping = DB::table('flate_rate')->where('id', '=', '1')->get();
        $rate = Orders::convertprice($ups_shipping[0]->flate_rate, $requested_currency);
        $data2 =  array('name'=>$methodName,'rate'=>$rate,'currencyCode'=>$requested_currency,'shipping_method'=>'flateRate');
        if(count($ups_shipping)>0){
          $success = array('success'=>'1', 'message'=>"Rate is returned.", 'name'=>$methodName);
          $success['services'][0] = $data2;
          $result['flateRate'] = $success;
        }


      }else if($shipping_methods->methods_type_link == 'localPickup' and $shipping_methods->status == '1') {
        $description = DB::table('shipping_description')->where('table_name','local_pickup')->where('language_id',$request->language_id)->get();

        if(!empty($description[0]->name)){
          $methodName = $description[0]->name;
        }else{
          $methodName = 'Local Pickup';
        }

        $data2 =  array('name'=>$methodName, 'rate'=>'0', 'currencyCode'=>$requested_currency, 'shipping_method'=>'localPickup');
        $success = array('success'=>'1', 'message'=>"Rate is returned.", 'name'=>$methodName);
        $success['services'][0] = $data2;
        $result['localPickup'] = $success;

      }else if($shipping_methods->methods_type_link == 'freeShipping'  and $shipping_methods->status == '1'){
        $description = DB::table('shipping_description')->where('table_name','free_shipping')->where('language_id',$request->language_id)->get();

        if(!empty($description[0]->name)){
          $methodName = $description[0]->name;
        }else{
          $methodName = 'Free Shipping';
        }

        $data2 =  array('name'=>$methodName,'rate'=>'0','currencyCode'=>$requested_currency,'shipping_method'=>'freeShipping');
        $success = array('success'=>'1', 'message'=>"Rate is returned.", 'name'=>$methodName);
        $success['services'][0] = $data2;
        $result['freeShipping'] = $success;

      }else if($shipping_methods->methods_type_link == 'shippingByWeight'  and $shipping_methods->status == '1'){
        $description = DB::table('shipping_description')->where('table_name','shipping_by_weight')->where('language_id',$request->language_id)->get();
        if(!empty($description[0]->name)){
          $methodName = $description[0]->name;
        }else{
          $methodName = 'Shipping Price';
        }

        $weight = $request->products_weight;

        //check price by weight
        $priceByWeight = DB::table('products_shipping_rates')->where('weight_from','<=',$weight)->where('weight_to','>=',$weight)->get();

        if(!empty($priceByWeight) and count($priceByWeight)>0 ){
          $price = $priceByWeight[0]->weight_price;
          $rate = Orders::convertprice($price, $requested_currency);
        }else{
          $rate = 0;
        }

        $data2 =  array('name'=>$methodName,'rate'=>$rate,'currencyCode'=>$requested_currency,'shipping_method'=>'Shipping Price');
        $success = array('success'=>'1', 'message'=>"Rate is returned.", 'name'=>$methodName);
        $success['services'][0] = $data2;
        $result['freeShipping'] = $success;
      }
    }
    $data['shippingMethods'] = $result;

    $responseData = array('success'=>'1', 'data'=>$data, 'message'=>"Data is returned.");
  }else{
    $responseData = array('success'=>'0', 'data'=>array(),  'message'=>"Unauthenticated call.");
  }
  $orderResponse = json_encode($responseData);

  return $orderResponse;
}

public static function getcoupon($request)
{

  		$result = array();
  		$consumer_data 		 				  =  array();
  		$consumer_data['consumer_key'] 	 	  =  request()->header('consumer-key');
  		$consumer_data['consumer_secret']	  =  request()->header('consumer-secret');
  		$consumer_data['consumer_nonce']	  =  request()->header('consumer-nonce');
  		$consumer_data['consumer_device_id']  =  request()->header('consumer-device-id');
      $consumer_data['consumer_ip']  =  request()->header('consumer-ip');
  		$consumer_data['consumer_url']  	  =  __FUNCTION__;
  		$authController = new AppSettingController();
  		$authenticate = $authController->apiAuthenticate($consumer_data);

  		if($authenticate==1){

  			$coupons = DB::table('coupons')->where('code', '=', $request->code)->get();

  			if(count($coupons)>0){

  				if(!empty($coupons[0]->product_ids)){
  					$product_ids = explode(',', $coupons[0]->product_ids);
  					$coupons[0]->product_ids =  $product_ids;
  				}
  				else{
  					$coupons[0]->product_ids = array();
  				}

  				if(!empty($coupons[0]->exclude_product_ids)){
  					$exclude_product_ids = explode(',', $coupons[0]->exclude_product_ids);
  					$coupons[0]->exclude_product_ids =  $exclude_product_ids;
  				}else{
  					$coupons[0]->exclude_product_ids =  array();
  				}

  				if(!empty($coupons[0]->product_categories)){
  					$product_categories = explode(',', $coupons[0]->product_categories);
  					$coupons[0]->product_categories =  $product_categories;
  				}else{
  					$coupons[0]->product_categories =  array();
  				}

  				if(!empty($coupons[0]->excluded_product_categories)){
  					$excluded_product_categories = explode(',', $coupons[0]->excluded_product_categories);
  					$coupons[0]->excluded_product_categories =  $excluded_product_categories;
  				}else{
  					$coupons[0]->excluded_product_categories = array();
  				}

  				if(!empty($coupons[0]->email_restrictions)){
  					$email_restrictions = explode(',', $coupons[0]->email_restrictions);
  					$coupons[0]->email_restrictions =  $email_restrictions;
  				}else{
  					$coupons[0]->email_restrictions =  array();
  				}

  				if(!empty($coupons[0]->used_by)){
  					$used_by = explode(',', $coupons[0]->used_by);
  					$coupons[0]->used_by =  $used_by;
  				}else{
  					$coupons[0]->used_by =  array();
  				}

  				$responseData = array('success'=>'1', 'data'=>$coupons, 'message'=>"Coupon info is returned.");
  			}else{
  				$responseData = array('success'=>'0', 'data'=>$coupons, 'message'=>"Coupon doesn't exist.");
  			}
  		}else{
  			$responseData = array('success'=>'0', 'data'=>array(),  'message'=>"Unauthenticated call.");
  		}

  		$orderResponse = json_encode($responseData);

      return $orderResponse;
}

public static function setbudget($request)
{
  $consumer_data 		 				  =  array();
  $consumer_data['consumer_key'] 	 	  =  request()->header('consumer-key');
  $consumer_data['consumer_secret']	  =  request()->header('consumer-secret');
  $consumer_data['consumer_nonce']	  =  request()->header('consumer-nonce');
  $consumer_data['consumer_device_id']  =  request()->header('consumer-device-id');
  $consumer_data['consumer_ip']  =  request()->header('consumer-ip');
  $consumer_data['consumer_url']  	  =  __FUNCTION__;

  $authController = new AppSettingController();
  $authenticate = $authController->apiAuthenticate($consumer_data);
  $ipAddress = Orders::get_client_ip_env();

  if($authenticate==1){

			$date_added								=	date('Y-m-d h:i:s');

			$customers_id         =   $request->userid;
			$budget            		=   $request->budget;
	

      $delivery = DB::table('users')->where('id', '=', $customers_id)
      ->update([
        'budget' => $budget

      ]);

			

     $godown = 	DB::table('users')->where('id', '=', $customers_id)->get();
     
     print $godown;

		

		
      
      $responseData = array('success'=>'1', 'data'=>array(), 'message'=> 'Budget data updated');

      
  }else{
    $responseData = array('success'=>'0', 'data'=>array(),  'message'=>"Unauthenticated call.");
  }

}

public static function getorders($request)
{


  
  $consumer_data 		 				  =  array();
  $customers_id						  =  $request->customers_id;
  $consumer_data['consumer_key'] 	 	  =  request()->header('consumer-key');
  $consumer_data['consumer_secret']	  =  request()->header('consumer-secret');
  $consumer_data['consumer_nonce']	  =  request()->header('consumer-nonce');
  //$consumer_data['consumer_device_id']  =  request()->header('consumer-device-id');
  //$consumer_data['consumer_ip']  =  request()->header('consumer-ip');
  $consumer_data['consumer_url']  	  =  __FUNCTION__;
  $authController = new AppSettingController();
  $authenticate = $authController->apiAuthenticate($consumer_data);

  if($authenticate==1){




    $order = DB::table('todos')->orderBy('user_id', 'desc')
        ->where('created_at', '>=', Carbon::today())
        ->where([
          ['user_id', '=', $customers_id],
     ])->get();


     


     Carbon::setWeekStartsAt(Carbon::SUNDAY);

     $orderweek = DB::table('todos')->orderBy('user_id', 'desc')
     ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
     ->where([
       ['user_id', '=', $customers_id],
     ])->get();






     $ordermonth = DB::table('todos')->orderBy('user_id', 'desc')
     ->whereYear('created_at', Carbon::now()->year)
     ->whereMonth('created_at', Carbon::now()->month)
     ->where([
       ['user_id', '=', $customers_id],
     ])->get();




     $orderyear = DB::table('todos')->orderBy('user_id', 'desc')
     ->whereYear('created_at', Carbon::now()->year)
     ->where([
       ['user_id', '=', $customers_id],
     ])->get();


        //return $order;

        $theuser = DB::table('users')
        ->where([
          ['id', '=', $customers_id],
        ])->get();


    $total =  $ordermonth->sum('amount');


    if(count($order) > 0 || count($ordermonth) > 0 || count($orderyear) > 0){
      //foreach
   
        $responseData = array('success'=>'1', 'data'=> $order, 'week'=> $orderweek, 'themonth' => $ordermonth, 'theyear' => $orderyear, 'ttl' => $total, 'theowner' => $theuser, 'message'=>"Returned all orders.");

    }else{
        $orders_data = array();
        $responseData = array('success'=>'0', 'data'=>$orders_data, 'message'=>"Order is not placed yet.");
    }
  }else{
    $responseData = array('success'=>'0', 'data'=>array(),  'message'=>"Unauthenticated call.");
  }
  $orderResponse = json_encode($responseData);

  return $orderResponse;
}

public static function getmonnify($request)
{

  		$consumer_data 		 				  =  array();
  		$orders_id							  =  $request->orders_id;
  		$consumer_data['consumer_key'] 	 	  =  request()->header('consumer-key');
  		$consumer_data['consumer_secret']	  =  request()->header('consumer-secret');
  		$consumer_data['consumer_nonce']	  =  request()->header('consumer-nonce');
  		$consumer_data['consumer_device_id']  =  request()->header('consumer-device-id');
      $consumer_data['consumer_ip']  =  request()->header('consumer-ip');
  		$consumer_data['consumer_url']  	  =  __FUNCTION__;
  		$authController = new AppSettingController();
  		$authenticate = $authController->apiAuthenticate($consumer_data);

  		if($authenticate==1){




        $getMerchantUrl='https://api.monnify.com/api/v1/auth/login'; 
        $curl = curl_init();
          curl_setopt_array($curl, array(
          CURLOPT_URL =>  $getMerchantUrl,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 100,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
          // CURLOPT_POSTFIELDS => $requestData,
          CURLOPT_HTTPHEADER => array(
              "Cache-Control: no-cache",
              "Content-Type: application/json",
              'Authorization: Basic TUtfUFJPRF85Mkw4QjZaODRUOkdQREM3UlNHNkZLOVBQVE5DVlM4Tk5SV1ZHUUNTRkxF'
            
            ),
          ));
            
            
        
          //curl_setopt($curl, CURLOPT_POSTFIELDS, $content);  
          $response = curl_exec($curl);
          
      
          
          $err = curl_error($curl);

          curl_close($curl);

          print  $response ;

  		}else{
  			$responseData = array('success'=>'0', 'data'=>array(),  'message'=>"Unauthenticated call.");
  		}
  	

}








public static function reservemonnify($request)
{

  		$consumer_data 		 				  =  array();
  		$orders_id							  =  $request->orders_id;
  		$consumer_data['consumer_key'] 	 	  =  request()->header('consumer-key');
  		$consumer_data['consumer_secret']	  =  request()->header('consumer-secret');
  		$consumer_data['consumer_nonce']	  =  request()->header('consumer-nonce');
  		$consumer_data['consumer_device_id']  =  request()->header('consumer-device-id');
      $consumer_data['consumer_ip']  =  request()->header('consumer-ip');
  		$consumer_data['consumer_url']  	  =  __FUNCTION__;
  		$authController = new AppSettingController();
  		$authenticate = $authController->apiAuthenticate($consumer_data);

  		if($authenticate==1){

        //return $request->referenceNumber;  02160240970|2348068295276|1




                                    
                            $validatePayMerchantUrl='https://api.monnify.com/api/v1/bank-transfer/reserved-accounts'; 
                            $principal = $request->accesskey; 
                            $str_explode=explode("|",$request->referenceNumber);
                            $meterno = $str_explode[0]; 
                            
       
       
     
     
                             $records= array(
                                'accountReference' => $request->referenceNumber,
                                'accountName'=> $meterno,
                                'currencyCode' =>  "NGN",
                                'contractCode' => "431977568323",
                                'customerEmail' => $request->email
                            
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
                "Authorization: Bearer $principal"
              ),
            ));
              
              
          
            curl_setopt($curl, CURLOPT_POSTFIELDS, $content);  
            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);
            $xx = json_decode($response);

            if($xx->requestSuccessful != false){



              $accountnumber = $xx->responseBody->accountNumber;
              $bankName = $xx->responseBody->bankName;
              $accountName = $xx->responseBody->accountName;


              /* $existUser = DB::table('monnifyaccounts')->where('meterno', $meterno)->get();

              if (count($existUser) != "1") { */


                $str_explode=explode("|",$request->referenceNumber);
                $customerid = $str_explode[2]; 
                $phone = $str_explode[1]; 



                  $customers_id = DB::table('monnifyaccounts')->insertGetId([
                      'user_id' => $customerid,
                      'meter' => $meterno,
                      'accountnum' => $accountnumber,
                      'accountbank' => $bankName,
                      'accountname' => $accountName, 
                      'phone' => $phone
                  ]);


                  /* $responseData = array('success' => '1', 'data' => $userData,  'data2' => $userHistory, 'message' => "Sign Up successfully!"); */
              /* } */



              print $response;

            }else{
              print $response;
            }

  		}else{
  			$responseData = array('success'=>'0', 'data'=>array(),  'message'=>"Unauthenticated call.");
  		}
  	

}

















public static function get_client_ip_env(){
		$ipaddress = '';
		if (getenv('HTTP_CLIENT_IP'))
			$ipaddress = getenv('HTTP_CLIENT_IP');
		else if(getenv('HTTP_X_FORWARDED_FOR'))
			$ipaddress = getenv('HTTP_X_FORWARDED_FOR');
		else if(getenv('HTTP_X_FORWARDED'))
			$ipaddress = getenv('HTTP_X_FORWARDED');
		else if(getenv('HTTP_FORWARDED_FOR'))
			$ipaddress = getenv('HTTP_FORWARDED_FOR');
		else if(getenv('HTTP_FORWARDED'))
			$ipaddress = getenv('HTTP_FORWARDED');
		else if(getenv('REMOTE_ADDR'))
			$ipaddress = getenv('REMOTE_ADDR');
		else
			$ipaddress = 'UNKNOWN';

		return $ipaddress;
	}

}
