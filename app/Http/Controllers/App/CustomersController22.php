<?php
namespace App\Http\Controllers\App;

use Illuminate\Foundation\Auth\ThrottlesLogins;
//use Validator;
//use Mail;
//use DateTime;
//use Auth;
//use DB;
//use Hash;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Carbon;
use App\Models\AppModels\Customer;

class CustomersController extends Controller
{


	//imageupdate
	public function imageupdate(Request $request){
		$userResponse = Customer::imageupdate($request);
			print $userResponse;
		}

	//login
	public function processlogin(Request $request){
    $userResponse = Customer::processlogin($request);
		print $userResponse;
	}



	//Driver login
	public function logindriver(Request $request){
		$userResponse = Customer::logindriver($request);
			print $userResponse;
		}



	

	//registration
	public function processregistration(Request $request){
    $userResponse = Customer::processregistration($request);
		print $userResponse;
	}




	//registration driver
	public function processregistrationdriver(Request $request){
		$userResponse = Customer::processregistrationdriver($request);
		print $userResponse;
		}


	/* public function verifydrivermobile(Request $request){

			$phone = $request->mobile_number;
	
			
	
			 //check phone existance
			 DB::table('drivers')->where('phone', $phone)->update([
	
				'mobile_verified' => 2,
				'token' => $this->generateBarcodeNumber2()
	
			 ]);
			 $userData = DB::table('drivers')->where('phone', $phone)->get();
	
			// $responseData = array('success' => '1', 'data' => $userData, 'message' => "Sign Up successfully!");
	
			 print $userData;
	
		} */

	




	/* public function generateBarcodeNumber2() {
		$number = mt_rand(1000000000, 9999999999); // better than rand()
	
		// call the same function if the barcode exists already
		if ($this->barcodeNumberExists2($number)) {
			return $this->generateBarcodeNumber2();
		}
	
		// otherwise, it's valid and can be used
		return $number;
	}
	
	public function barcodeNumberExists2($number) {
		// query the database and return a boolean
		// for instance, it might look like this in Laravel
		//return User::whereBarcodeNumber($number)->exists();

		return DB::table( 'drivers' )->where( 'token', $number )->exists();
	} */






	//THIS SECTION FOR PASSENGERS


	/* public function verifymobile(Request $request){

		$phone = $request->mobile_number;

		

		 //check phone existance
		 DB::table('users')->where('phone', $phone)->update([

			'mobile_verified' => 2,
			'token' => $this->generateBarcodeNumber()

		 ]);
		 $userData = DB::table('users')->where('phone', $phone)->get();

		// $responseData = array('success' => '1', 'data' => $userData, 'message' => "Sign Up successfully!");

		 print $userData;

	} */

















	/* public function generateBarcodeNumber() {
		$number = mt_rand(1000000000, 9999999999); // better than rand()
	
		// call the same function if the barcode exists already
		if ($this->barcodeNumberExists($number)) {
			return generateBarcodeNumber();
		}
	
		// otherwise, it's valid and can be used
		return $number;
	} */
	
	/* public function barcodeNumberExists($number) {
		// query the database and return a boolean
		// for instance, it might look like this in Laravel
		//return User::whereBarcodeNumber($number)->exists();

		return DB::table( 'users' )->where( 'token', $number )->exists();
	} */


	


	//notify_me
	public function notify_me(Request $request){
		$categoryResponse = Customer::notify_me($request);
			print $categoryResponse;
		}


	//get user information
    public function getuserinfo(Request $request){
		
        $userinfo = Customer::getuserinfo($request);
			return $userinfo;
	}



	//get user information
    public function getdriverallinfo(Request $request){
		
        $userinfo = Customer::getdriverallinfo($request);
			return $userinfo;
	}


	//get user transactions
    public function getSales(Request $request){
		
        $userinfo = Customer::getSales($request);
			return $userinfo;
	}
		


    


	//get ride information
    public function getrideinfo(Request $request){
		
        $userinfo = Customer::getrideinfo($request);
			return $userinfo;
		}


	//get rider status 
    public function getridestatus(Request $request){
		
        $userinfo = Customer::getridestatus($request);
			return $userinfo;
		}



	




	

	//update profile
	public function updatesalesrecord(Request $request){
    $userResponse = Customer::updatesalesrecord($request);
		print $userResponse;

	}

	//processforgotPassword
	public function processforgotpassword(Request $request){
    $userResponse = Customer::processforgotpassword($request);
		print $userResponse;
	}

	//facebookregistration
	public function facebookregistration(Request $request){
	  $userResponse = Customer::facebookregistration($request);
		print $userResponse;


	}


	//googleregistration
	public function googleregistration(Request $request){
    $userResponse = Customer::googleregistration($request);
		print $userResponse;


		}

	//generate random password
	function createRandomPassword() {
		$pass = substr(md5(uniqid(mt_rand(), true)) , 0, 8);
		return $pass;
	}

	//generate random password
	function registerdevices(Request $request) {
    	$userResponse = Customer::registerdevices($request);
		print $userResponse;
	}

	function updatepassword(Request $request) {
		$userResponse = Customer::updatepassword($request);
		print $userResponse;
	}


}
