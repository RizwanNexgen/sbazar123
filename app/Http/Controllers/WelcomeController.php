<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WelcomeController extends Controller
{
    public function index(Request $request)
    {
        return 123;
        $data = [];    		
        
        $query = DB::table('products');
        $query->select('products.*', 'products_description.products_name', 'image_categories.path');        
        $query->leftJoin('products_description', 'products_description.products_id', '=', 'products.products_id');
        $query->LeftJoin('image_categories', function ($join) {
            $join->on('image_categories.image_id', '=', 'products.products_image')
                ->where(function ($query) {
                    $query->where('image_categories.image_type', '=', 'THUMBNAIL')
                        ->where('image_categories.image_type', '!=', 'THUMBNAIL')
                        ->orWhere('image_categories.image_type', '=', 'ACTUAL');
                });
        });        
        $query->where('products_description.language_id', 1);
        $query->limit(12);
        $query->inRandomOrder();
        $data['recommendations'] = $query->get();
        
        return view('welcome', $data);
    }



    public function verify($email)
    {

    	 $user = DB::table('users')->where('email', '=', $email)->first();
    	 if($user){

    	 	 $userCheck = DB::table('users')
    	 	              ->where('email', '=', $email)
    	 	              ->where('email_verified', '=', 1)
    	 	              ->first();
    	 	  if ($userCheck) {
    	 	              	
    	 	              	return 'Please Login. This Email is already verified: ' .$email;
    	 	              }else{
    	 	             DB::table('users')->where('email', $email)
    	 	             ->update(['email_verified'=>1]);
    	 	             return 'Your email has been verified: ' .$email; 
    	 	              }            

    	 }else{
    	 	   return 'This Email is not registered: ' .$email;
    	 }

    }  




}
