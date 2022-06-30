<?php

namespace App\Http\Controllers\AdminControllers;

use App\Models\Core\Languages;
use App\Models\Core\HomeBanners;
use App\Models\Core\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Exception;
use App\Models\Core\Images;

class HomeBannersController extends Controller
{
  public function __construct(HomeBanners $HomeBanners, Setting $setting, Images $images)
  {
      $this->HomeBanners = $HomeBanners;
      $this->varseting = new SiteSettingController($setting);
      $this->Setting = $setting;
      $this->images = $images;
  }

  public function display(){
    $title = array('pageTitle' => Lang::get("labels.Home Banners"));
    $result['banners'] = $this->HomeBanners->index();
    $result['languages'] = $this->varseting->getLanguages();
    $allimage = $this->images->getimages();
    //dd($result);
    $result['commonContent'] = $this->Setting->commonContent();
    return view("admin.settings.web.homebanners.index",$title)->with('result', $result)->with('allimage', $allimage);
  }

    public function splash_screen(){
        $title = array('pageTitle' => Lang::get("labels.Home Banners"));
        $result['banners'] = $this->HomeBanners->index();
        $result['languages'] = $this->varseting->getLanguages();
        $allimage = $this->images->getimages();
        //dd($result);
        $result['commonContent'] = $this->Setting->commonContent();
        $result['first'] = DB::table('splash_screen_files')->where("splash_screen_id", 1)->first();
        $result['second'] = DB::table('splash_screen_files')->where("splash_screen_id", 2)->first();
        $result['third'] = DB::table('splash_screen_files')->where("splash_screen_id", 3)->first();
        $result['fourth'] = DB::table('splash_screen_files')->where("splash_screen_id", 4)->first();
        $result['fifth'] = DB::table('splash_screen_files')->where("splash_screen_id", 5)->first();

        return view("admin.app_menus.splash_screen",$title)->with('result', $result)->with('allimage', $allimage);
    }

    public function store_splash_screen(Request $request){
        \Tinify\setKey(env("TINIFY_API_KEY"));
        $s3_credential = array(
            "service" => "s3",
            "aws_access_key_id" => env('S3_ACCESS_KEY_ID'),
            "aws_secret_access_key" => env("S3_SECRET_ACCESS_KEY"),
            "region" => env("S3_REGION"),
            /* "headers" => array("Cache-Control" => "max-age=31536000, public"), */
            "path" => "",
        );



        if($request->hasFile('first')){

            $check_type = $request->file('first')->getClientMimeType();
            $type = '';

            if(strpos($check_type, 'image') == true){
                $type = 'IMAGE';
//               $source = \Tinify\fromFile($request->file('first'));
//               dd($source);
                $source = $request->file('first');
            }else{
               $source = $request->file('first');
                $type = 'VIDEO';
//                dd($source);
            }


            DB::table('splash_screen_files')->where('splash_screen_id', 1)->delete();

            $file_name = date('m-d-Y_H:i:s') . '_'. $request->file('first')->getClientOriginalName();
            $s3_credential['path'] = env('S3_BUCKET_NAME'). 'product-images/' . $file_name;
            $path =  'splash_screen_files/' . $file_name;

//            $disk = \Storage::disk('s3');
//            $disk->put($path, fopen($source, 'r+'));
            \Storage::disk('s3')->put($path, $source, ['x-amz-acl' => 'public', 'ACL' => 'public-read']);
//            \Storage::disk('s3')->setVisibility($path, 'public');

        return    $url =  \Storage::disk('s3')->url($path);

//            $request->file('first')->store($s3_credential);

            DB::table('splash_screen_files')->insert([
                'splash_screen_id'=> 1,
                'url' => $url,
                'type'=>$type
            ]);
        }
        if($request->hasFile('second')){

            $check_type = $request->file('second')->getClientMimeType();
            DB::table('splash_screen_files')->where('splash_screen_id', 2)->delete();

            $file_name = date('m-d-Y_H:i:s') . '_'. $request->file('second')->getClientOriginalName();
            $source = \Tinify\fromFile($request->file('second'));

            $s3_credential['path'] = env('S3_BUCKET_NAME'). '/splash_screen_files'. '/' . $file_name;

            $source->store($s3_credential);

            DB::table('splash_screen_files')->insert([
                'splash_screen_id'=> 2,
                'url' => 'http://'.env('S3_BUCKET_NAME') . '.s3.' . env('S3_REGION') . '.amazonaws.com/splash_screen_files/' . $file_name,
                'type'=>'IMAGE'
            ]);
        }
        if($request->hasFile('third')){

            $check_type = $request->file('third')->getClientMimeType();
            DB::table('splash_screen_files')->where('splash_screen_id', 3)->delete();

            $file_name = date('m-d-Y_H:i:s') . '_'. $request->file('third')->getClientOriginalName();
            $source = \Tinify\fromFile($request->file('third'));

            $s3_credential['path'] = env('S3_BUCKET_NAME'). '/splash_screen_files'. '/' . $file_name;

            $source->store($s3_credential);

            DB::table('splash_screen_files')->insert([
                'splash_screen_id'=> 3,
                'url' => 'http://'.env('S3_BUCKET_NAME') . '.s3.' . env('S3_REGION') . '.amazonaws.com/splash_screen_files/' . $file_name,
                'type'=>'IMAGE'
            ]);
        }
        if($request->hasFile('fourth')){

            $check_type = $request->file('fourth')->getClientMimeType();
            DB::table('splash_screen_files')->where('splash_screen_id', 4)->delete();

            $file_name = date('m-d-Y_H:i:s') . '_'. $request->file('fourth')->getClientOriginalName();
            $source = \Tinify\fromFile($request->file('fourth'));

            $s3_credential['path'] = env('S3_BUCKET_NAME'). '/splash_screen_files'. '/' . $file_name;

            $source->store($s3_credential);

            DB::table('splash_screen_files')->insert([
                'splash_screen_id'=> 4,
                'url' => 'http://'.env('S3_BUCKET_NAME') . '.s3.' . env('S3_REGION') . '.amazonaws.com/splash_screen_files/' . $file_name,
                'type'=>'IMAGE'
            ]);
        }
        if($request->hasFile('fifth')){

            $check_type = $request->file('fifth')->getClientMimeType();
            DB::table('splash_screen_files')->where('splash_screen_id', 5)->delete();

            $file_name = date('m-d-Y_H:i:s') . '_'. $request->file('fifth')->getClientOriginalName();
            $source = \Tinify\fromFile($request->file('fifth'));

            $s3_credential['path'] = env('S3_BUCKET_NAME'). '/splash_screen_files'. '/' . $file_name;

            $source->store($s3_credential);

            DB::table('splash_screen_files')->insert([
                'splash_screen_id'=> 5,
                'url' => 'http://'.env('S3_BUCKET_NAME') . '.s3.' . env('S3_REGION') . '.amazonaws.com/splash_screen_files/' . $file_name,
                'type'=>'IMAGE'
            ]);
        }

        return redirect()->back();
    }
 
  public function insert(Request $request){
       // dd($request->all());

        
        $result = array();

        //get function from other controller
        $languages = $this->varseting->getLanguages();
        $banners_types = array('banners_1','banners_2','banners_3');

        //multiple lanugauge with record
        foreach($languages as $languages_data){
          //text_1_banner_1
            $bannerText = 'text_'.$languages_data->languages_id;
            $bannerImageId = 'image_id_'.$languages_data->languages_id;
             
              foreach($banners_types as $key => $banners_type){

                if($key==0){
                  $banner_name =  'banners_1';
                }elseif($key==1){
                    $banner_name =  'banners_2';
                }else{
                    $banner_name =  'banners_3';
                }

                $banner_text = $bannerText.'_'.$banner_name;
                $banner_image_id = $bannerImageId.'_'.$banner_name;
                // print $banner_text.' ';
                // print $request->$banner_text.' ';

                $banners_text = $request->$banner_text;
                $banners_image_id = $request->$banner_image_id;

                $checkExist = $this->HomeBanners->checkExit($banner_name, $languages_data->languages_id);
                
                if($checkExist){
                  $this->HomeBanners->updaterecord($banner_name,$languages_data->languages_id,$banners_text, $banners_image_id);
                }else{
                  $this->HomeBanners->insertrecord($banner_name,$languages_data->languages_id,$banners_text, $banners_image_id);
                }

              }
     }

        $message = Lang::get("labels.Home banner added successfully");
        return redirect()->back()->withErrors([$message]);
  }  

   public function update(Request $request){

     $title = array('pageTitle' => Lang::get("labels.EditSubCategories"));
     $result = array();
     $result['message'] = Lang::get("labels.Category has been updated successfully");
     $last_modified 	=   date('y-m-d h:i:s');
     $parent_id = $request->parent_id;
     $categories_id = $request->id;
     $categories_status  = $request->categories_status;

     //get function from other controller
     $languages = $this->varseting->getLanguages();
     $extensions = $this->varseting->imageType();

     //check slug
     if($request->old_slug!=$request->slug){
         $slug = $request->slug;
         $slug_count = 0;
         do{
             if($slug_count==0){
                 $currentSlug = $this->varseting->slugify($request->slug);
             }else{
                 $currentSlug = $this->varseting->slugify($request->slug.'-'.$slug_count);
             }
             $slug = $currentSlug;
             $checkSlug = DB::table('categories')->where('categories_slug',$currentSlug)->where('categories_id','!=',$request->id)->get();
             $slug_count++;
         }
         while(count($checkSlug)>0);
     }else{
         $slug = $request->slug;
     }
     if($request->image_id!==null){
         $uploadImage = $request->image_id;
     }else{
         $uploadImage = $request->oldImage;
     }

     if($request->image_icone !==null){
         $uploadIcon = $request->image_icone;
     }	else{
         $uploadIcon = $request->oldIcon;
     }

     $updateCategory = $this->Categories->updaterecord($categories_id,$uploadImage,$uploadIcon,$last_modified,$parent_id,$slug,$categories_status);

     foreach($languages as $languages_data){
       $categories_name = 'category_name_'.$languages_data->languages_id;
       $checkExist = $this->Categories->checkExit($categories_id,$languages_data);
         $categories_name = $request->$categories_name;
         if(count($checkExist)>0){
           $category_des_update = $this->Categories->updatedescription($categories_name,$languages_data,$categories_id);
       }else{
           $updat_des = $this->Categories->insertcategorydescription($categories_name,$categories_id, $languages_data->languages_id);
       }
     }

     $message = Lang::get("labels.CategorieUpdateMessage");
     return redirect()->back()->withErrors([$message]);
    }

    public function delete(Request $request){
      $deletecategory = $this->Categories->deleterecord($request);
      $message = Lang::get("labels.CategoriesDeleteMessage");
      return redirect()->back()->withErrors([$message]);
    }
}
