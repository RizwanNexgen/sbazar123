<?php
namespace App\Http\Controllers\App;

use Illuminate\Foundation\Auth\ThrottlesLogins;
use Validator;
use Mail;
use DateTime;
use Auth;
use DB;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Carbon;
use App\Models\AppModels\Customer;
use App\Models\AppModels\Address;

use App\Models\Core\User;
use App\Mail\EmailForgetPassword;
use Illuminate\Support\Str;


class CustomersController extends Controller
{


   public function customerregistration(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'avatar' => 'required|image',
            'email' => 'required | email |unique:users',
            'password' => 'required',
            'country_code' => 'required',
            'phone' => 'required',
        ]);
        $errors = array();
        if ($validator->fails()){
            $e_index = 0;
            foreach($validator->errors()->messages() as $key=>$errorsmsges){
                $errors[$e_index++] = $errorsmsges[0];                    
            }
            return response()->json(['success'=>false, 'message'=>'Missing Parameters', 'errors'=>$validator->errors()->messages()]); 
        }
        $ref_id_for_db = '';
        if($request->ref_id){
            $ref_user = DB::table('users')->where('referral_id', $request->ref_id)->first(); 
         if(!$ref_user){
             return response()->json(['success'=>false, 'message'=>'invalid referral code']);
           }
           $ref_id_for_db = $ref_user->id;
        }

        $firstCharacterUsername = strtoupper(substr($request->username, 0, 1));
        $permitted_chars = 'abcdefghijklmnopqrstuvwxyz';
        $randomCharachter = strtoupper(substr(str_shuffle($permitted_chars), 0, 1));
        $twoRandomDigits = mt_rand(10, 99);
        $year =  substr(date("Y"), 2, 4);
    
        $referalID = $firstCharacterUsername.$randomCharachter.$year .$twoRandomDigits;


        
		$imageName = time().'.'.$request->avatar->extension();  
		
		$request->avatar->move(public_path('profile_images'), $imageName);

    //insert data into customer
        $customers_id = DB::table('users')->insertGetId([
            'role_id' => 2,
            'user_name' => $request->username,
            'phone' => $request->phone,
            'country_code' => $request->country_code,
            'avatar' => 'profile_images/'.$imageName,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'status' => '1',
            'created_at' => date('y-m-d h:i:s'),
            'referral_id'=>  $referalID,
            'refered_by'=>$ref_id_for_db,
        ]);
    
           $customers_address = DB::table('address_book')->insertGetId([
            'user_id' => $customers_id,
    
        ]);
    
        $userData = DB::table('users')
            ->where('users.id', '=', $customers_id)->where('status', '1')->get();
        Mail::to($email)->send(new EmailVerification($request->email));    
        $responseData = array('success' => true, 'data' => $userData, 'message' => "Sign Up successfully!");
    }

	public function forgetpass(Request $request){
      
            $req_email = $request->email;
      
      
            
            
          
          $emailVerification = DB::table('users')->where('email', $req_email)->first();
          if($emailVerification){

             $email = Str::random(8);

              $cation = DB::table('users')->where('email', $req_email)->update(['password'=>bcrypt($email)]);
            
           Mail::to($req_email)->send(new EmailForgetPassword($email));
	       return response()->json(['message'=>'Please check your email']);
          }else{
           return response()->json(['message'=>'Your email does not exists']);
          }
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



	public function getAuthUserData(Request $request){

		// DB::table('customers_info');

		$email = $request->email;

        $existUser = DB::table('users')
                    ->where('email', $email)->where('status', '1')
                    ->LeftJoin('address_book','address_book.user_id','=', 'users.id')->select('users.*','address_book.*')->get();
        if($existUser){
        return response()->json(['success'=>1, 'data'=>$existUser, 'message'=>'Login user data'],200);            

        }   else{
        return response()->json(['success'=>0,  'message'=>'User not found'],404);            

        }         
	}

	public function updateAuthUser(Request $request){

		$email = $request->email;

		$users = User::where('email',$email)->first();
		
		if($request->first_name){

			$users->first_name = $request->first_name;
		}

		if($request->last_name){
			$users->last_name = $request->last_name;
		}


		if($request->user_name){
			$users->user_name = $request->user_name;
		}


		if($request->gender){
			$users->gender = $request->gender;
		}


		if($request->country_code){
			$users->country_code = $request->country_code;
		}


		if($request->city){
			$users->city = $request->city;
		}


		if($request->phone){
			$users->phone = $request->phone;
		}


		if($request->email){
			$users->email = $request->email;
		}


		if($request->avatar){
			$users->avatar = $request->avatar;
		}

		if($request->dob){
			$users->dob = $request->dob;
		}
      	if($request->password){
			$users->password = bcrypt($request->password);
		}
      $users->save();
      
      $address = Address::where('user_id', '=', $users->id)->first();
     
      if($address){
      
      
      		if($request->entry_street_address){
			$address->entry_street_address = $request->entry_street_address;
		}
      
      		if($request->entry_postcode){
			$address->entry_postcode = $request->entry_postcode;
		}
      
      		if($request->entry_suburb){
			$address->entry_suburb = $request->entry_suburb;
		}
      
   
      
      		if($request->entry_postcode){
			$address->entry_postcode = $request->entry_postcode;
		}
      
      
      
      		if($request->entry_city){
			$address->entry_city = $request->entry_city;
		}

         		if($request->entry_state){
			$address->entry_state = $request->entry_state;
		}
         		if($request->entry_latitude){
			$address->entry_latitude = $request->entry_latitude;
		}
      
       		if($request->entry_longitude){
			$address->entry_longitude = $request->entry_longitude;
		}  
         		
      
         		if($request->country){
			$address->country = $request->country;
		}
  
     
               $address->save();        
      }
           $existUser = DB::table('users')
                    ->where('email', $email)->where('status', '1')
                    ->LeftJoin('address_book','address_book.user_id','=', 'users.id')->select('users.*','address_book.*')->get();   
      
      // return $existUser;
        return response()->json(['success'=>1, 'data'=>$existUser, 'message'=>'User data updated'],200);            

        



	}


  
	//login
	public function processlogin(Request $request){
      
            $email = $request->email;
            
          
            $emailVerification = DB::table('users')
                    ->where('email', $email)->where('status', '1')  ->where('email_verified', '=',1)->first();
          if($emailVerification){
      
         $userResponse = Customer::processlogin($request);
		return response()->json(json_decode($userResponse));
          }else{
            return response()->json(['message'=>'Please verifiy your email first']);
          }
	}
  
  
  	//forget passsword

  
  
  

	//registration
	public function processregistration(Request $request){

		//return response()->json(['a' => 'b']);

    $userResponse = Customer::processregistration($request);
		return $userResponse;
	}

	//notify_me
	public function notify_me(Request $request){
    $categoryResponse = Customer::notify_me($request);
		print $categoryResponse;
	}

	//update profile
	public function updatecustomerinfo(Request $request){
    $userResponse = Customer::updatecustomerinfo($request);
		print $userResponse;

	}

	//processforgotPassword
	public function processforgotpassword(Request $request){
    $userResponse = Customer::processforgotpassword($request);
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
