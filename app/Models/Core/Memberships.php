<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Kyslik\ColumnSortable\Sortable;
use App\Models\Core\Memberships;
use App\Models\Core\Setting;
use App\Models\Core\Languages;
use App\Http\Controllers\AdminControllers\SiteSettingController;
use Illuminate\Support\Facades\Validator;


class Memberships extends Model
{
  public function __construct()
  {
      $varsetting = new SiteSettingController();
      $this->varsetting = $varsetting;
  }
    //
    use Sortable;

    public function images(){
        return $this->belongsTo('App\Images');
    }

    public $sortableAs = ['membership_id'];
    public $sortable = ['membership_id', 'membership_name'];

    public function paginator(){
         $memberships =  Memberships::sortable(['membership_id'=>'desc'])
                                   
                ->LeftJoin('image_categories', function ($join) {
                $join->on('image_categories.image_id', '=', 'memberships.membership_image')
                    ->where(function ($query) {
                        $query->where('image_categories.image_type', '=', 'THUMBNAIL')
                            ->where('image_categories.image_type', '!=', 'THUMBNAIL')
                            ->orWhere('image_categories.image_type', '=', 'ACTUAL');
                    });
                })

                ->select(DB::raw('memberships.membership_id as id, memberships.membership_has_validity as has_validity, memberships.membership_points_from as point_from, memberships.membership_points_to as point_to, memberships.membership_valid_till as valid_till, memberships.membership_discount_percentage as discount_percent, memberships.membership_cap_value as cap_value, memberships.membership_status as status, memberships.membership_image as image, memberships.membership_name as name, image_categories.path as path'))
                //->groupBy('memberships.memberships_id')
                ->paginate();

        return $memberships;
    }

    /*public function getter($language_id){
         if($language_id == null){
           $language_id = '1';
         }
         $memberships =  memberships::sortable(['memberships_id'=>'desc'])
            ->leftJoin('memberships_info','memberships_info.memberships_id', '=', 'memberships.memberships_id')
            ->LeftJoin('image_categories', function ($join) {
                $join->on('image_categories.image_id', '=', 'memberships.membership_image')
                    ->where(function ($query) {
                        $query->where('image_categories.image_type', '=', 'THUMBNAIL')
                            ->where('image_categories.image_type', '!=', 'THUMBNAIL')
                            ->orWhere('image_categories.image_type', '=', 'ACTUAL');
                    });
                })
            ->select('memberships.memberships_id as id', 'memberships.membership_image as image',  'memberships.membership_name as name', 'memberships_info.memberships_url as url', 'memberships_info.url_clicked', 'memberships_info.date_last_click as clik_date','image_categories.path as path')
            ->where('memberships_info.languages_id', $language_id)
            ->get();
        return $memberships;
    }*/

    public function insert($request){
          $date_added	= date('y-m-d h:i:s');
          $languages_id 	=  '1';

          $setting = new Setting();
          $myVarsetting = new SiteSettingController($setting);
          $languages = $myVarsetting->getLanguages();
          
          //dd($request->all());

          $memberships_id = DB::table('memberships')->insertGetId([
              'membership_name'   =>   $request->name,
              'membership_image'   =>   $request->image_id,
              'membership_points_from'   =>   $request->membership_points_from,
              'membership_points_to'   =>   $request->membership_points_to,
              'membership_has_validity'   =>   $request->membership_has_validity,
              'membership_valid_till'   =>   ($request->membership_has_validity == 1) ? $request->membership_valid_till : "",
              'membership_discount_percentage'   =>   $request->membership_discount_percentage,
              'membership_cap_value'   =>   $request->membership_cap_value,
              'membership_status'   =>   1,
              'created_at'   =>   $date_added,
          ]);

          foreach($languages as $languages_data)
          {
            $desc_field = 'benifit_description_'.$languages_data->languages_id;
            $req_benifit_description = $request->$desc_field;

            DB::table('membership_descriptions')->insert([
                'membership_id'  	=>     $memberships_id,
                'membership_description'     =>     addslashes($req_benifit_description),
                'language_id'			=>	   $languages_data->languages_id,
            ]);
          }
          

    }

    public function edit($memberships_id){

        $editmembership = DB::table('memberships')
            ->leftJoin('membership_descriptions','membership_descriptions.membership_id', '=', 'memberships.membership_id')
            
            ->LeftJoin('image_categories as logo', function ($join) {
                $join->on('logo.image_id', '=', 'memberships.membership_image')
                    ->where(function ($query) {
                        $query->where('logo.image_type', '=', 'THUMBNAIL')
                            ->where('logo.image_type', '!=', 'THUMBNAIL')
                            ->orWhere('logo.image_type', '=', 'ACTUAL');
                    });
                })
                
            ->select(
                'memberships.membership_id as id',
                'memberships.membership_image as membership_image_id',
                'memberships.membership_name as name',
                'memberships.membership_points_from as point_from',
                'memberships.membership_points_to as point_to',
                'memberships.membership_valid_till as valid_till',
                'memberships.membership_has_validity as has_validity',
                'memberships.membership_discount_percentage as discount',
                'memberships.membership_cap_value as cap_val',
                'memberships.membership_status as status',
                'logo.path as logo_path'
                )
            ->where( 'memberships.membership_id', $memberships_id )
            ->first();
            
            $list_desc = DB::table('membership_descriptions')->where('membership_id', $memberships_id)->get();
            //dd($memberships_id);
            $editmembership->infos = [];

            foreach($list_desc as $desc)
            {
                $editmembership->infos[$desc->language_id] = $desc;    
            }
        
         return $editmembership;
    }

    public function filter($name,$param){
      switch ( $name )
      {
          case 'Name':
              $memberships = memberships::sortable(['membership_id'=>'desc'])
                 ->LeftJoin('image_categories', function ($join) {
                    $join->on('image_categories.image_id', '=', 'memberships.membership_image')
                        ->where(function ($query) {
                            $query->where('image_categories.image_type', '=', 'THUMBNAIL')
                                ->where('image_categories.image_type', '!=', 'THUMBNAIL')
                                ->orWhere('image_categories.image_type', '=', 'ACTUAL');
                    });
                })

                ->select(DB::raw('memberships.membership_id as id, memberships.membership_points_from as point_from, memberships.membership_points_to as point_to, memberships.membership_valid_till as valid_till, memberships.membership_discount_percentage as discount_percent, memberships.membership_cap_value as cap_value, memberships.membership_status as status, memberships.membership_image as image, memberships.membership_name as name, image_categories.path as path'))
                  ->where('memberships.membership_name', 'LIKE', '%' . $param . '%')->paginate('10');
              break;
              
          default:
              $memberships = memberships::sortable(['membership_id'=>'desc'])
                  ->LeftJoin('image_categories', function ($join) {
                    $join->on('image_categories.image_id', '=', 'memberships.membership_image')
                        ->where(function ($query) {
                            $query->where('image_categories.image_type', '=', 'THUMBNAIL')
                                ->where('image_categories.image_type', '!=', 'THUMBNAIL')
                                ->orWhere('image_categories.image_type', '=', 'ACTUAL');
                    });
                })

                ->select(DB::raw('memberships.membership_id as id, memberships.membership_has_validity as has_validity, memberships.membership_points_from as point_from, memberships.membership_points_to as point_to, memberships.membership_valid_till as valid_till, memberships.membership_discount_percentage as discount_percent, memberships.membership_cap_value as cap_value, memberships.membership_status as status, memberships.membership_image as image, memberships.membership_name as name, image_categories.path as path'))
                //->groupBy('memberships.memberships_id')
                ->paginate('10');
      }
        return $memberships;
    }

    /*public function fetchAllmemberships($language_id){

        $getmemberships = DB::table('memberships')
            ->leftJoin('memberships_info','memberships_info.memberships_id', '=', 'memberships.memberships_id')
            ->select('memberships.memberships_id as id', 'memberships.membership_image as image',  'memberships.membership_name as name', 'memberships_info.memberships_url as url', 'memberships_info.url_clicked', 'memberships_info.date_last_click as clik_date')
            ->where('memberships_info.languages_id', $language_id)->get();
        return $getmemberships;
    }*/

    /*public function fetchmemberships(){

        $memberships = DB::table('memberships')
            ->leftJoin('memberships_info','memberships_info.memberships_id', '=', 'memberships.memberships_id')
            ->leftJoin('images','images.id', '=', 'memberships.membership_image')
            ->leftJoin('image_categories','image_categories.image_id', '=', 'memberships.membership_image')
            ->select('memberships.memberships_id as id', 'memberships.membership_image as image',  'memberships.membership_name as name', 'memberships_info.memberships_url as url', 'memberships_info.url_clicked', 'memberships_info.date_last_click as clik_date','image_categories.path as path')
            ->where('memberships_info.languages_id', '1')->where('image_categories.image_type','=','THUMBNAIL' or 'image_categories.image_type','=','ACTUAL');


        return $memberships;


    }*/

    /*public function slug($currentSlug){

        $checkSlug = DB::table('memberships')->where('memberships_slug',$currentSlug)->get();

        return $checkSlug;
    }*/

    public function updaterecord($request){

      $last_modified 	=   date('y-m-d h:i:s');
      $languages_id = '1';
        
      $setting = new Setting();
      $myVarsetting = new SiteSettingController($setting);
      $languages = $myVarsetting->getLanguages();

      if($request->image_id==null){

          $uploadImage = $request->oldImage;

      }else{

          $uploadImage = $request->image_id;
      }

        DB::table('memberships')->where('membership_id', $request->id)->update([
           'membership_name'   =>   $request->name,
           'membership_image'   =>   $uploadImage,
           'membership_points_from'   =>   $request->membership_points_from,
           'membership_points_to'   =>   $request->membership_points_to,
           'membership_has_validity'   =>   $request->membership_has_validity,
           'membership_valid_till'   =>   ($request->membership_has_validity == 1) ? $request->membership_valid_till : "",
           'membership_discount_percentage'   =>   $request->membership_discount_percentage,
           'membership_cap_value'   =>   $request->membership_cap_value,
           'membership_status'   =>   1,
           'updated_at'   =>   $last_modified,
        ]);
        
        foreach($languages as $languages_data)
        {
            $desc_field = 'benifit_description_'.$languages_data->languages_id;
            $req_benifit_description = $request->$desc_field;

            $checkExist = DB::table('membership_descriptions')->where('language_id', $languages_data->languages_id)->where('membership_id', $request->id)->count();

            if($checkExist==0)
            {
                DB::table('membership_descriptions')->insert([
                    'membership_id'  	=>     $request->id,
                    'membership_description'     =>     addslashes($req_benifit_description),
                    'language_id'			=>	   $languages_data->languages_id,                           
                ]);
            }
            else
            {
                DB::table('membership_descriptions')
                ->where('membership_id', $request->id)
                ->where('language_id', $languages_data->languages_id)
                ->update([
                    'membership_description'     =>     addslashes($req_benifit_description),
                ]);
            }
        }
    }


    //delete memberships

    public function destroyrecord($request){
        
        //dd($request->all());

        DB::table('memberships')->where('membership_id', $request->membership_id)->delete();
        DB::table('membership_descriptions')->where('membership_id', $request->membership_id)->delete();
    }
    /*public function fetchsortmemberships($name, $param){

        switch ( $name )
        {
            case 'Name':
                $memberships = DB::table('memberships')
                ->leftJoin('memberships_info','memberships_info.memberships_id', '=', 'memberships.memberships_id')
                ->leftJoin('images','images.id', '=', 'memberships.membership_image')
                ->leftJoin('image_categories','image_categories.image_id', '=', 'memberships.membership_image')
                ->select('memberships.memberships_id as id', 'memberships.membership_image as image',  'memberships.membership_name as name', 'memberships_info.memberships_url as url', 'memberships_info.url_clicked', 'memberships_info.date_last_click as clik_date','image_categories.path as path')
                ->where('memberships.membership_name', 'LIKE', '%' . $param . '%')->where('image_categories.image_type','=','THUMBNAIL' or 'image_categories.image_type','=','ACTUAL')->paginate('10');
                  break;

            case 'URL':
                $memberships = DB::table('memberships')
                    ->leftJoin('memberships_info','memberships_info.memberships_id', '=', 'memberships.memberships_id')
                    ->leftJoin('images','images.id', '=', 'memberships.membership_image')
                    ->leftJoin('image_categories','image_categories.image_id', '=', 'memberships.membership_image')
                    ->select('memberships.memberships_id as id', 'memberships.membership_image as image',  'memberships.membership_name as name', 'memberships_info.memberships_url as url', 'memberships_info.url_clicked', 'memberships_info.date_last_click as clik_date','image_categories.path as path')
                    ->where('memberships_info.memberships_url', 'LIKE', '%' . $param . '%')->where('image_categories.image_type','=','THUMBNAIL' or 'image_categories.image_type','=','ACTUAL')->paginate('10');
                break;


            default:
            $memberships = DB::table('memberships')
                ->leftJoin('memberships_info','memberships_info.memberships_id', '=', 'memberships.memberships_id')
                ->leftJoin('images','images.id', '=', 'memberships.membership_image')
                ->leftJoin('image_categories','image_categories.image_id', '=', 'memberships.membership_image')
                ->select('memberships.memberships_id as id', 'memberships.membership_image as image',  'memberships.membership_name as name', 'memberships_info.memberships_url as url', 'memberships_info.url_clicked', 'memberships_info.date_last_click as clik_date','image_categories.path as path')
                ->where('memberships_info.languages_id', '1')->paginate('10');
        }


        return $memberships;


    }*/

}
