<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Kyslik\ColumnSortable\Sortable;
use App\hotcats_info;
use App\Models\Core\Hotcats;
use App\Models\Core\Setting;
use App\Models\Core\Languages;
use App\Http\Controllers\AdminControllers\SiteSettingController;
use Illuminate\Support\Facades\Validator;


class Hotcats extends Model
{
  public function __construct()
  {
      $varsetting = new SiteSettingController();
      $this->varsetting = $varsetting;
  }
    //
    use Sortable;
    public function hotcats_info(){
        return $this->hasOne('App\hotcats_info');
    }

    public function images(){
        return $this->belongsTo('App\Images');
    }

    public $sortableAs = ['hotcats_url'];
    public $sortable = ['hotcats_id', 'hotcat_name', 'hotcat_image','hotcats_slug','created_at','updated_at'];

    public function paginator(){
         $hotcats =  Hotcats::sortable(['hotcats_id'=>'desc'])
                ->leftJoin('products_to_hotcats','products_to_hotcats.hotcats_id', '=', 'hotcats.hotcats_id')
                                   
                ->LeftJoin('image_categories', function ($join) {
                $join->on('image_categories.image_id', '=', 'hotcats.hotcat_image')
                    ->where(function ($query) {
                        $query->where('image_categories.image_type', '=', 'THUMBNAIL')
                            ->where('image_categories.image_type', '!=', 'THUMBNAIL')
                            ->orWhere('image_categories.image_type', '=', 'ACTUAL');
                    });
                })
                ->select(DB::raw('hotcats.hotcats_id as id, hotcats.hotcats_status as status, hotcats.hotcats_color_code as color_code, hotcats.hotcat_image as image, hotcats.hotcat_name as name, image_categories.path as path, COUNT(products_to_hotcats.products_id) as total_products'))
                ->groupBy('hotcats.hotcats_id')
                ->paginate(50);


        return $hotcats;
    }

    public function getter($language_id){
         if($language_id == null){
           $language_id = '1';
         }
         $hotcats =  Hotcats::sortable(['hotcats_id'=>'desc'])
            ->leftJoin('hotcats_info','hotcats_info.hotcats_id', '=', 'hotcats.hotcats_id')
            ->LeftJoin('image_categories', function ($join) {
                $join->on('image_categories.image_id', '=', 'hotcats.hotcat_image')
                    ->where(function ($query) {
                        $query->where('image_categories.image_type', '=', 'THUMBNAIL')
                            ->where('image_categories.image_type', '!=', 'THUMBNAIL')
                            ->orWhere('image_categories.image_type', '=', 'ACTUAL');
                    });
                })
            ->select('hotcats.hotcats_id as id', 'hotcats.hotcat_image as image',  'hotcats.hotcat_name as name', 'hotcats_info.hotcats_url as url', 'hotcats_info.url_clicked', 'hotcats_info.date_last_click as clik_date','image_categories.path as path')
            ->where('hotcats_info.languages_id', $language_id)
            ->where('hotcats.hotcats_status', 1)
            ->get();
        return $hotcats;
    }

    public function insert($request){

          $slug = $request->name;
          $date_added	= date('y-m-d h:i:s');
          $languages_id 	=  '1';
          $slug_count = 0;

          $setting = new Setting();
          $myVarsetting = new SiteSettingController($setting);
          $languages = $myVarsetting->getLanguages();

         
          do{
              if($slug_count==0){
                  $currentSlug = $this->varsetting->slugify($request->name);
              }else{
                  $currentSlug = $this->varsetting->slugify($request->name.'-'.$slug_count);
              }
              $slug = $currentSlug;

              $checkSlug = $this->slug($currentSlug);

              $slug_count++;
          }

          while(count($checkSlug)>0);

          $hotcats_id = DB::table('hotcats')->insertGetId([
              'hotcat_image'   =>   $request->image_icone,
              'hotcat_image_header'   =>   $request->image_id,
              'created_at'			=>   $date_added,
              'hotcat_name' 	=>   $request->name,
              'hotcats_color_code' 	=>   $request->color_code,
              'hotcats_status' 	=>   $request->hotcats_status,
              'hotcats_slug'	=>	 $slug
          ]);

          foreach($languages as $languages_data)
          {
            $desc_field = 'brand_description_'.$languages_data->languages_id;
            $req_products_description = $request->$desc_field;

            DB::table('hotcats_info')->insert([
                'hotcats_id'  	=>     $hotcats_id,
                'hotcats_desc'     =>     addslashes($req_products_description),
                'languages_id'			=>	   $languages_data->languages_id,
                //'url_clickeded'			=>	   $request->url_clickeded
            ]);
          }
          

    }

    public function edit($hotcats_id){

        $editManufacturer = DB::table('hotcats')
            ->leftJoin('hotcats_info','hotcats_info.hotcats_id', '=', 'hotcats.hotcats_id')
            ->LeftJoin('image_categories as logo', function ($join) {
                $join->on('logo.image_id', '=', 'hotcats.hotcat_image')
                    ->where(function ($query) {
                        $query->where('logo.image_type', '=', 'THUMBNAIL')
                            ->where('logo.image_type', '!=', 'THUMBNAIL')
                            ->orWhere('logo.image_type', '=', 'ACTUAL');
                    });
                })
            ->LeftJoin('image_categories as header', function ($join) {
                $join->on('header.image_id', '=', 'hotcats.hotcat_image_header')
                    ->where(function ($query) {
                        $query->where('header.image_type', '=', 'THUMBNAIL')
                            ->where('header.image_type', '!=', 'THUMBNAIL')
                            ->orWhere('header.image_type', '=', 'ACTUAL');
                    });
                })
            ->select(
                'hotcats.hotcats_id as id', 
                'hotcat_image as logo_image', 
                'hotcat_image_header as header_image',  
                'hotcats.hotcat_name as name',
                'hotcats.hotcats_color_code as color_code',
                'hotcats.hotcats_status as status',
                'hotcats_info.hotcats_url as url', 
                'hotcats_info.url_clicked', 
                'hotcats_info.date_last_click as clik_date', 
                'hotcats.hotcats_slug as slug',
                'logo.path as logo_path',
                'header.path as header_path'
                )
            ->where( 'hotcats.hotcats_id', $hotcats_id )
            ->first();
            
            $list_desc = DB::table('hotcats_info')->where('hotcats_id', $hotcats_id)->get();

            $editManufacturer->infos = [];

            foreach($list_desc as $desc)
            {
                $editManufacturer->infos[$desc->languages_id] = $desc;    
            }

         return $editManufacturer;
    }

    public function filter($name,$param){
      switch ( $name )
      {
          case 'Name':
              $hotcats = Hotcats::sortable(['hotcats_id'=>'desc'])
                  ->leftJoin('hotcats_info','hotcats_info.hotcats_id', '=', 'hotcats.hotcats_id')
                  ->leftJoin('images','images.id', '=', 'hotcats.hotcat_image')
                  ->leftJoin('image_categories','image_categories.image_id', '=', 'hotcats.hotcat_image')
                  ->select('hotcats.hotcats_id as id', 'hotcats.hotcat_image as image', 'hotcats.hotcats_color_code as color_code', 'hotcats.hotcat_name as name', 'hotcats_info.hotcats_url as url', 'hotcats_info.url_clicked', 'hotcats_info.date_last_click as clik_date','image_categories.path as path')
                  ->where('hotcats.hotcat_name', 'LIKE', '%' . $param . '%')->where('image_categories.image_type','=','THUMBNAIL' or 'image_categories.image_type','=','ACTUAL')->paginate('10');
              break;

          case 'URL':
              $hotcats = Hotcats::sortable(['hotcats_id'=>'desc'])
                  ->leftJoin('hotcats_info','hotcats_info.hotcats_id', '=', 'hotcats.hotcats_id')
                  ->leftJoin('images','images.id', '=', 'hotcats.hotcat_image')
                  ->leftJoin('image_categories','image_categories.image_id', '=', 'hotcats.hotcat_image')
                  ->select('hotcats.hotcats_id as id', 'hotcats.hotcat_image as image', 'hotcats.hotcats_color_code as color_code', 'hotcats.hotcat_name as name', 'hotcats_info.hotcats_url as url', 'hotcats_info.url_clicked', 'hotcats_info.date_last_click as clik_date','image_categories.path as path')
                  ->where('hotcats_info.hotcats_url', 'LIKE', '%' . $param . '%')->where('image_categories.image_type','=','THUMBNAIL' or 'image_categories.image_type','=','ACTUAL')->paginate('10');
              break;


          default:
              $hotcats = Hotcats::sortable(['hotcats_id'=>'desc'])
                  ->leftJoin('hotcats_info','hotcats_info.hotcats_id', '=', 'hotcats.hotcats_id')
                  ->leftJoin('images','images.id', '=', 'hotcats.hotcat_image')
                  ->leftJoin('image_categories','image_categories.image_id', '=', 'hotcats.hotcat_image')
                  ->select('hotcats.hotcats_id as id', 'hotcats.hotcat_image as image', 'hotcats.hotcats_color_code as color_code', 'hotcats.hotcat_name as name', 'hotcats_info.hotcats_url as url', 'hotcats_info.url_clicked', 'hotcats_info.date_last_click as clik_date','image_categories.path as path')
                  ->where('hotcats_info.languages_id', '1')->paginate('10');
      }
        return $hotcats;
    }

    public function fetchAllhotcats($language_id){
       $getHotcats = DB::table('hotcats')
            ->leftJoin('hotcats_info','hotcats_info.hotcats_id', '=', 'hotcats.hotcats_id')
            ->select('hotcats.hotcats_id as id', 'hotcats.hotcat_image as image',  'hotcats.hotcat_name as name', 'hotcats.hotcats_color_code as color_code', 'hotcats_info.hotcats_url as url', 'hotcats_info.url_clicked', 'hotcats_info.date_last_click as clik_date')
            ->where('hotcats_info.languages_id', $language_id)->get();
        return $getHotcats;
    }

    public function fetchhotcats(){

        $hotcats = DB::table('hotcats')
            ->leftJoin('hotcats_info','hotcats_info.hotcats_id', '=', 'hotcats.hotcats_id')
            ->leftJoin('images','images.id', '=', 'hotcats.hotcat_image')
            ->leftJoin('image_categories','image_categories.image_id', '=', 'hotcats.hotcat_image')
            ->select('hotcats.hotcats_id as id', 'hotcats.hotcat_image as image',  'hotcats.hotcat_name as name', 'hotcats.hotcats_color_code as color_code', 'hotcats_info.hotcats_url as url', 'hotcats_info.url_clicked', 'hotcats_info.date_last_click as clik_date','image_categories.path as path')
            ->where('hotcats_info.languages_id', '1')->where('image_categories.image_type','=','THUMBNAIL' or 'image_categories.image_type','=','ACTUAL');


        return $hotcats;


    }



    public function slug($currentSlug){

        $checkSlug = DB::table('hotcats')->where('hotcats_slug',$currentSlug)->get();

        return $checkSlug;
    }



    public function updaterecord($request){

                  $last_modified 	=   date('y-m-d h:i:s');
                  $languages_id = '1';
                    
                  $setting = new Setting();
                  $myVarsetting = new SiteSettingController($setting);
                  $languages = $myVarsetting->getLanguages();
                  
                  //check slug
                  if($request->old_slug!=$request->slug ){
                      $slug = $request->slug;
                      $slug_count = 0;
                      do{
                          if($slug_count==0){
                              $currentSlug = $this->varsetting->slugify($request->slug);
                          }else{
                              $currentSlug = $this->varsetting->slugify($request->slug.'-'.$slug_count);
                          }
                          $slug = $currentSlug;

                          $checkSlug = $this->slug($currentSlug);
                          $slug_count++;
                      }

                      while(count($checkSlug)>0);

                  }else{
                      $slug = $request->slug;
                  }

                  if($request->image_id==null){

                      $uploadImage = $request->oldImage;

                  }else{

                      $uploadImage = $request->image_id;
                  }

                  if($request->image_icone==null){

                        $uploadIcon = $request->oldIcon;

                    }else{

                        $uploadIcon = $request->image_icone;
                    }

                DB::table('hotcats')->where('hotcats_id', $request->id)->update([
                   'hotcat_image'   =>   $uploadIcon,
                    'hotcat_image_header'   =>   $uploadImage,
                    'updated_at'			=>   $last_modified,
                    'hotcat_name' 	=>   $request->name,
                    'hotcats_color_code' 	=>   $request->color_code,
                    'hotcats_status' 	=>   $request->hotcats_status,
                    'hotcats_slug'	=>	 $slug
                ]);
                
                foreach($languages as $languages_data)
                {
                    $desc_field = 'brand_description_'.$languages_data->languages_id;
                    $req_products_description = $request->$desc_field;

                    $checkExist = DB::table('hotcats_info')->where('languages_id', $languages_data->languages_id)->where('hotcats_id', $request->id)->count();

                    if($checkExist==0)
                    {
                        DB::table('hotcats_info')->insert([
                            'hotcats_id'  	=>     $request->id,
                            'hotcats_desc'     =>     addslashes($req_products_description),
                            'languages_id'			=>	   $languages_data->languages_id,                           
                        ]);
                    }
                    else
                    {
                        DB::table('hotcats_info')
                        ->where('hotcats_id', $request->id)
                        ->where('languages_id', $languages_data->languages_id)
                        ->update([                            
                            'hotcats_desc'     =>     addslashes($req_products_description),                                                    
                        ]);
                    }                    
                }

        $editCategory = DB::table('categories')
            ->leftJoin('categories_description','categories_description.categories_id', '=', 'categories.categories_id')
            ->select('categories.categories_id as id', 'categories.categories_image as image',  'categories.created_at as date_added', 'categories.updated_at as last_modified', 'categories_description.categories_name as name')
            ->where('categories.categories_id', $request->id)
            ->get();
        return $editCategory;
    }


    //delete Hotcats

    public function destroyrecord($request){

        DB::table('hotcats')->where('hotcats_id', $request->hotcats_id)->delete();
        DB::table('hotcats_info')->where('hotcats_id', $request->hotcats_id)->delete();
        DB::table('products_to_hotcats')->where('hotcats_id', $request->hotcats_id)->delete();

    }
    public function fetchsorthotcats($name, $param){

        switch ( $name )
        {
            case 'Name':
                $hotcats = DB::table('hotcats')
                ->leftJoin('hotcats_info','hotcats_info.hotcats_id', '=', 'hotcats.hotcats_id')
                ->leftJoin('images','images.id', '=', 'hotcats.hotcat_image')
                ->leftJoin('image_categories','image_categories.image_id', '=', 'hotcats.hotcat_image')
                ->select('hotcats.hotcats_id as id', 'hotcats.hotcat_image as image',  'hotcats.hotcat_name as name', 'hotcats_info.hotcats_url as url', 'hotcats_info.url_clicked', 'hotcats_info.date_last_click as clik_date','image_categories.path as path')
                ->where('hotcats.hotcat_name', 'LIKE', '%' . $param . '%')->where('image_categories.image_type','=','THUMBNAIL' or 'image_categories.image_type','=','ACTUAL')->paginate('10');
                  break;

            case 'URL':
                $hotcats = DB::table('hotcats')
                    ->leftJoin('hotcats_info','hotcats_info.hotcats_id', '=', 'hotcats.hotcats_id')
                    ->leftJoin('images','images.id', '=', 'hotcats.hotcat_image')
                    ->leftJoin('image_categories','image_categories.image_id', '=', 'hotcats.hotcat_image')
                    ->select('hotcats.hotcats_id as id', 'hotcats.hotcat_image as image',  'hotcats.hotcat_name as name', 'hotcats_info.hotcats_url as url', 'hotcats_info.url_clicked', 'hotcats_info.date_last_click as clik_date','image_categories.path as path')
                    ->where('hotcats_info.hotcats_url', 'LIKE', '%' . $param . '%')->where('image_categories.image_type','=','THUMBNAIL' or 'image_categories.image_type','=','ACTUAL')->paginate('10');
                break;


            default:
            $hotcats = DB::table('hotcats')
                ->leftJoin('hotcats_info','hotcats_info.hotcats_id', '=', 'hotcats.hotcats_id')
                ->leftJoin('images','images.id', '=', 'hotcats.hotcat_image')
                ->leftJoin('image_categories','image_categories.image_id', '=', 'hotcats.hotcat_image')
                ->select('hotcats.hotcats_id as id', 'hotcats.hotcat_image as image',  'hotcats.hotcat_name as name', 'hotcats_info.hotcats_url as url', 'hotcats_info.url_clicked', 'hotcats_info.date_last_click as clik_date','image_categories.path as path')
                ->where('hotcats_info.languages_id', '1')->paginate('10');
        }


        return $hotcats;


    }

}
