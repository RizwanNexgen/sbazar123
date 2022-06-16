<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Kyslik\ColumnSortable\Sortable;
use App\manufacturers_info;
use App\Models\Core\Manufacturers;
use App\Models\Core\Setting;
use App\Models\Core\Languages;
use App\Http\Controllers\AdminControllers\SiteSettingController;
use Illuminate\Support\Facades\Validator;


class Manufacturers extends Model
{
  public function __construct()
  {
      $varsetting = new SiteSettingController();
      $this->varsetting = $varsetting;
  }
    //
    use Sortable;
    public function manufacturers_info(){
        return $this->hasOne('App\manufacturers_info');
    }

    public function images(){
        return $this->belongsTo('App\Images');
    }

    public $sortableAs = ['manufacturers_url'];
    public $sortable = ['manufacturers_id', 'manufacturer_name', 'manufacturer_image','manufacturers_slug','created_at','updated_at'];

    public function paginator(){
         $manufacturers =  Manufacturers::sortable(['manufacturers_id'=>'desc'])
                //->leftJoin('products','products.manufacturers_id', '=', 'manufacturers.manufacturers_id')
                                   
                ->LeftJoin('image_categories', function ($join) {
                $join->on('image_categories.image_id', '=', 'manufacturers.manufacturer_image')
                    ->where(function ($query) {
                        $query->where('image_categories.image_type', '=', 'THUMBNAIL')
                            ->where('image_categories.image_type', '!=', 'THUMBNAIL')
                            ->orWhere('image_categories.image_type', '=', 'ACTUAL');
                    });
                })

                //->select(DB::raw('manufacturers.manufacturers_id as id, manufacturers.is_top as is_top, manufacturers.manufacturer_status as status, manufacturers.manufacturer_image as image, manufacturers.manufacturer_name as name, image_categories.path as path, COUNT(products.products_id) as total_products'))
                ->select('manufacturers.manufacturers_id as id', 'manufacturers.is_top as is_top', 'manufacturers.manufacturer_status as status', 'manufacturers.manufacturer_image as image', 'manufacturers.manufacturer_name as name', 'image_categories.path as path')
                //->groupBy('manufacturers.manufacturers_id')
                ->paginate(50);


                //dd($manufacturers->all());

        return $manufacturers;
    }

    public function getter($language_id){
         if($language_id == null){
           $language_id = '1';
         }
         $manufacturers =  Manufacturers::sortable(['manufacturers_id'=>'desc'])
            ->leftJoin('manufacturers_info','manufacturers_info.manufacturers_id', '=', 'manufacturers.manufacturers_id')
            ->LeftJoin('image_categories', function ($join) {
                $join->on('image_categories.image_id', '=', 'manufacturers.manufacturer_image')
                    ->where(function ($query) {
                        $query->where('image_categories.image_type', '=', 'THUMBNAIL')
                            ->where('image_categories.image_type', '!=', 'THUMBNAIL')
                            ->orWhere('image_categories.image_type', '=', 'ACTUAL');
                    });
                })
            ->select('manufacturers.manufacturers_id as id', 'manufacturers.manufacturer_image as image',  'manufacturers.manufacturer_name as name', 'manufacturers_info.manufacturers_url as url', 'manufacturers_info.url_clicked', 'manufacturers_info.date_last_click as clik_date','image_categories.path as path')
            ->where('manufacturers_info.languages_id', $language_id)
            ->get();
        return $manufacturers;
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

          $manufacturers_id = DB::table('manufacturers')->insertGetId([
              'manufacturer_image'   =>   $request->image_icone,
              'manufacturer_image_header'   =>   $request->image_id,
              'created_at'			=>   $date_added,
              'manufacturer_name' 	=>   $request->name,
              'is_top' 	=>   $request->is_top,
              'manufacturer_status' 	=>   $request->manufecturer_status,
              'manufacturers_slug'	=>	 $slug
          ]);

          foreach($languages as $languages_data)
          {
            $desc_field = 'brand_description_'.$languages_data->languages_id;
            $req_products_description = $request->$desc_field;

            DB::table('manufacturers_info')->insert([
                'manufacturers_id'  	=>     $manufacturers_id,
                'manufacturers_desc'     =>     addslashes($req_products_description),
                'languages_id'			=>	   $languages_data->languages_id,
                //'url_clickeded'			=>	   $request->url_clickeded
            ]);
          }
          

    }

    public function edit($manufacturers_id){

        $editManufacturer = DB::table('manufacturers')
            ->leftJoin('manufacturers_info','manufacturers_info.manufacturers_id', '=', 'manufacturers.manufacturers_id')
            ->LeftJoin('image_categories as logo', function ($join) {
                $join->on('logo.image_id', '=', 'manufacturers.manufacturer_image')
                    ->where(function ($query) {
                        $query->where('logo.image_type', '=', 'THUMBNAIL')
                            ->where('logo.image_type', '!=', 'THUMBNAIL')
                            ->orWhere('logo.image_type', '=', 'ACTUAL');
                    });
                })
            ->LeftJoin('image_categories as header', function ($join) {
                $join->on('header.image_id', '=', 'manufacturers.manufacturer_image_header')
                    ->where(function ($query) {
                        $query->where('header.image_type', '=', 'THUMBNAIL')
                            ->where('header.image_type', '!=', 'THUMBNAIL')
                            ->orWhere('header.image_type', '=', 'ACTUAL');
                    });
                })
            ->select(
                'manufacturers.manufacturers_id as id', 
                'manufacturer_image as logo_image', 
                'manufacturer_image_header as header_image',  
                'manufacturers.manufacturer_name as name',
                'manufacturers.manufacturer_status as status',
                'manufacturers.is_top as is_top',
                'manufacturers_info.manufacturers_url as url', 
                'manufacturers_info.url_clicked', 
                'manufacturers_info.date_last_click as clik_date', 
                'manufacturers.manufacturers_slug as slug',
                'logo.path as logo_path',
                'header.path as header_path'
                )
            ->where( 'manufacturers.manufacturers_id', $manufacturers_id )
            ->first();
            
            $list_desc = DB::table('manufacturers_info')->where('manufacturers_id', $manufacturers_id)->get();

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
              $manufacturers = Manufacturers::sortable(['manufacturers_id'=>'desc'])
                ->leftJoin('products','products.manufacturers_id', '=', 'manufacturers.manufacturers_id')
                                   
                ->LeftJoin('image_categories', function ($join) {
                $join->on('image_categories.image_id', '=', 'manufacturers.manufacturer_image')
                    ->where(function ($query) {
                        $query->where('image_categories.image_type', '=', 'THUMBNAIL')
                            ->where('image_categories.image_type', '!=', 'THUMBNAIL')
                            ->orWhere('image_categories.image_type', '=', 'ACTUAL');
                    });
                })

                ->select(DB::raw('manufacturers.manufacturers_id as id, manufacturers.manufacturer_status as status, manufacturers.manufacturer_image as image, manufacturers.manufacturer_name as name, image_categories.path as path, COUNT(products.products_id) as total_products'))
                ->groupBy('manufacturers.manufacturers_id')
                ->where('manufacturers.manufacturer_name', 'LIKE', '%' . $param . '%')->paginate('10');
              //$manufacturers = Manufacturers::sortable(['manufacturers_id'=>'desc'])
                  //->leftJoin('manufacturers_info','manufacturers_info.manufacturers_id', '=', 'manufacturers.manufacturers_id')
                  //->leftJoin('images','images.id', '=', 'manufacturers.manufacturer_image')
                  //->leftJoin('image_categories','image_categories.image_id', '=', 'manufacturers.manufacturer_image')
                  //->select('manufacturers.manufacturers_id as id', 'manufacturers.manufacturer_image as image',  'manufacturers.manufacturer_name as name', 'manufacturers_info.manufacturers_url as url', 'manufacturers_info.url_clicked', 'manufacturers_info.date_last_click as clik_date','image_categories.path as path')
                  //->where('manufacturers.manufacturer_name', 'LIKE', '%' . $param . '%')->where('image_categories.image_type','=','THUMBNAIL' or 'image_categories.image_type','=','ACTUAL')->paginate('10');
              break;

          case 'URL':
              $manufacturers = Manufacturers::sortable(['manufacturers_id'=>'desc'])
                ->leftJoin('products','products.manufacturers_id', '=', 'manufacturers.manufacturers_id')
                                   
                ->LeftJoin('image_categories', function ($join) {
                $join->on('image_categories.image_id', '=', 'manufacturers.manufacturer_image')
                    ->where(function ($query) {
                        $query->where('image_categories.image_type', '=', 'THUMBNAIL')
                            ->where('image_categories.image_type', '!=', 'THUMBNAIL')
                            ->orWhere('image_categories.image_type', '=', 'ACTUAL');
                    });
                })

                ->select(DB::raw('manufacturers.manufacturers_id as id, manufacturers.manufacturer_status as status, manufacturers.manufacturer_image as image, manufacturers.manufacturer_name as name, image_categories.path as path, COUNT(products.products_id) as total_products'))
                ->groupBy('manufacturers.manufacturers_id')
                ->where('manufacturers_info.manufacturers_url', 'LIKE', '%' . $param . '%')->paginate('10');
              //$manufacturers = Manufacturers::sortable(['manufacturers_id'=>'desc'])
                  //->leftJoin('manufacturers_info','manufacturers_info.manufacturers_id', '=', 'manufacturers.manufacturers_id')
                  //->leftJoin('images','images.id', '=', 'manufacturers.manufacturer_image')
                  //->leftJoin('image_categories','image_categories.image_id', '=', 'manufacturers.manufacturer_image')
                  //->select('manufacturers.manufacturers_id as id', 'manufacturers.manufacturer_image as image',  'manufacturers.manufacturer_name as name', 'manufacturers_info.manufacturers_url as url', 'manufacturers_info.url_clicked', 'manufacturers_info.date_last_click as clik_date','image_categories.path as path')
                  //->where('manufacturers_info.manufacturers_url', 'LIKE', '%' . $param . '%')->where('image_categories.image_type','=','THUMBNAIL' or 'image_categories.image_type','=','ACTUAL')->paginate('10');
              break;


          default:
              $manufacturers = Manufacturers::sortable(['manufacturers_id'=>'desc'])
                ->leftJoin('products','products.manufacturers_id', '=', 'manufacturers.manufacturers_id')
                                   
                ->LeftJoin('image_categories', function ($join) {
                $join->on('image_categories.image_id', '=', 'manufacturers.manufacturer_image')
                    ->where(function ($query) {
                        $query->where('image_categories.image_type', '=', 'THUMBNAIL')
                            ->where('image_categories.image_type', '!=', 'THUMBNAIL')
                            ->orWhere('image_categories.image_type', '=', 'ACTUAL');
                    });
                })

                ->select(DB::raw('manufacturers.manufacturers_id as id, manufacturers.manufacturer_status as status, manufacturers.manufacturer_image as image, manufacturers.manufacturer_name as name, image_categories.path as path, COUNT(products.products_id) as total_products'))
                ->groupBy('manufacturers.manufacturers_id')->paginate('10');
              //$manufacturers = Manufacturers::sortable(['manufacturers_id'=>'desc'])
                  //->leftJoin('manufacturers_info','manufacturers_info.manufacturers_id', '=', 'manufacturers.manufacturers_id')
                  //->leftJoin('images','images.id', '=', 'manufacturers.manufacturer_image')
                  //->leftJoin('image_categories','image_categories.image_id', '=', 'manufacturers.manufacturer_image')
                  //->select('manufacturers.manufacturers_id as id', 'manufacturers.manufacturer_image as image',  'manufacturers.manufacturer_name as name', 'manufacturers_info.manufacturers_url as url', 'manufacturers_info.url_clicked', 'manufacturers_info.date_last_click as clik_date','image_categories.path as path')
                  //->where('manufacturers_info.languages_id', '1')->paginate('10');
      }
        return $manufacturers;
    }

    public function fetchAllmanufacturers($language_id){

        $getManufacturers = DB::table('manufacturers')
            ->leftJoin('manufacturers_info','manufacturers_info.manufacturers_id', '=', 'manufacturers.manufacturers_id')
            ->select('manufacturers.manufacturers_id as id', 'manufacturers.manufacturer_image as image',  'manufacturers.manufacturer_name as name', 'manufacturers_info.manufacturers_url as url', 'manufacturers_info.url_clicked', 'manufacturers_info.date_last_click as clik_date')
            ->where('manufacturers_info.languages_id', $language_id)->get();
        return $getManufacturers;
    }

    public function fetchmanufacturers(){

        $manufacturers = DB::table('manufacturers')
            ->leftJoin('manufacturers_info','manufacturers_info.manufacturers_id', '=', 'manufacturers.manufacturers_id')
            ->leftJoin('images','images.id', '=', 'manufacturers.manufacturer_image')
            ->leftJoin('image_categories','image_categories.image_id', '=', 'manufacturers.manufacturer_image')
            ->select('manufacturers.manufacturers_id as id', 'manufacturers.manufacturer_image as image',  'manufacturers.manufacturer_name as name', 'manufacturers_info.manufacturers_url as url', 'manufacturers_info.url_clicked', 'manufacturers_info.date_last_click as clik_date','image_categories.path as path')
            ->where('manufacturers_info.languages_id', '1')->where('image_categories.image_type','=','THUMBNAIL' or 'image_categories.image_type','=','ACTUAL');


        return $manufacturers;


    }

    public function slug($currentSlug){

        $checkSlug = DB::table('manufacturers')->where('manufacturers_slug',$currentSlug)->get();

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

                DB::table('manufacturers')->where('manufacturers_id', $request->id)->update([
                   'manufacturer_image'   =>   $uploadIcon,
                    'manufacturer_image_header'   =>   $uploadImage,
                    'updated_at'			=>   $last_modified,
                    'manufacturer_name' 	=>   $request->name,
                    'is_top' 	=>   $request->is_top,
                    'manufacturer_status' 	=>   $request->manufecturer_status,
                    'manufacturers_slug'	=>	 $slug
                ]);
                
                foreach($languages as $languages_data)
                {
                    $desc_field = 'brand_description_'.$languages_data->languages_id;
                    $req_products_description = $request->$desc_field;

                    $checkExist = DB::table('manufacturers_info')->where('languages_id', $languages_data->languages_id)->where('manufacturers_id', $request->id)->count();

                    if($checkExist==0)
                    {
                        DB::table('manufacturers_info')->insert([
                            'manufacturers_id'  	=>     $request->id,
                            'manufacturers_desc'     =>     addslashes($req_products_description),
                            'languages_id'			=>	   $languages_data->languages_id,                           
                        ]);
                    }
                    else
                    {
                        DB::table('manufacturers_info')
                        ->where('manufacturers_id', $request->id)
                        ->where('languages_id', $languages_data->languages_id)
                        ->update([                            
                            'manufacturers_desc'     =>     addslashes($req_products_description),                                                    
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


    //delete Manufacturers

    public function destroyrecord($request){

        DB::beginTransaction();

        try{
            DB::table('manufacturers')->where('manufacturers_id', $request->manufacturers_id)->delete();
            DB::table('manufacturers_info')->where('manufacturers_id', $request->manufacturers_id)->delete();

            $product_ids = DB::table('products')->where('manufacturers_id', $request->manufacturers_id)->pluck('products_id');

            DB::table('products_to_categories')->whereIn('products_id', $product_ids)->delete();
            DB::table('products')->whereIn('products_id', $product_ids)->delete();
            DB::table('specials')->whereIn('products_id', $product_ids)->delete();
            DB::table('products_description')->whereIn('products_id', $product_ids)->delete();
            DB::table('products_attributes')->whereIn('products_id', $product_ids)->delete();

            DB::commit();
        }
        catch(\Exception $e){
            DB::rollBack();
        }

        
    }
    public function fetchsortmanufacturers($name, $param){

        switch ( $name )
        {
            case 'Name':
                $manufacturers = DB::table('manufacturers')
                ->leftJoin('manufacturers_info','manufacturers_info.manufacturers_id', '=', 'manufacturers.manufacturers_id')
                ->leftJoin('images','images.id', '=', 'manufacturers.manufacturer_image')
                ->leftJoin('image_categories','image_categories.image_id', '=', 'manufacturers.manufacturer_image')
                ->select('manufacturers.manufacturers_id as id', 'manufacturers.manufacturer_image as image',  'manufacturers.manufacturer_name as name', 'manufacturers_info.manufacturers_url as url', 'manufacturers_info.url_clicked', 'manufacturers_info.date_last_click as clik_date','image_categories.path as path')
                ->where('manufacturers.manufacturer_name', 'LIKE', '%' . $param . '%')->where('image_categories.image_type','=','THUMBNAIL' or 'image_categories.image_type','=','ACTUAL')->paginate('10');
                  break;

            case 'URL':
                $manufacturers = DB::table('manufacturers')
                    ->leftJoin('manufacturers_info','manufacturers_info.manufacturers_id', '=', 'manufacturers.manufacturers_id')
                    ->leftJoin('images','images.id', '=', 'manufacturers.manufacturer_image')
                    ->leftJoin('image_categories','image_categories.image_id', '=', 'manufacturers.manufacturer_image')
                    ->select('manufacturers.manufacturers_id as id', 'manufacturers.manufacturer_image as image',  'manufacturers.manufacturer_name as name', 'manufacturers_info.manufacturers_url as url', 'manufacturers_info.url_clicked', 'manufacturers_info.date_last_click as clik_date','image_categories.path as path')
                    ->where('manufacturers_info.manufacturers_url', 'LIKE', '%' . $param . '%')->where('image_categories.image_type','=','THUMBNAIL' or 'image_categories.image_type','=','ACTUAL')->paginate('10');
                break;


            default:
            $manufacturers = DB::table('manufacturers')
                ->leftJoin('manufacturers_info','manufacturers_info.manufacturers_id', '=', 'manufacturers.manufacturers_id')
                ->leftJoin('images','images.id', '=', 'manufacturers.manufacturer_image')
                ->leftJoin('image_categories','image_categories.image_id', '=', 'manufacturers.manufacturer_image')
                ->select('manufacturers.manufacturers_id as id', 'manufacturers.manufacturer_image as image',  'manufacturers.manufacturer_name as name', 'manufacturers_info.manufacturers_url as url', 'manufacturers_info.url_clicked', 'manufacturers_info.date_last_click as clik_date','image_categories.path as path')
                ->where('manufacturers_info.languages_id', '1')->paginate('10');
        }


        return $manufacturers;


    }

}
