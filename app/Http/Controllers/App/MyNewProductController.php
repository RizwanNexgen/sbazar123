<?php

namespace App\Http\Controllers\App;

//validator is builtin class in laravel
use Validator;
use DB;
use DateTime;
use Hash;
use Auth;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\AppModels\Product;
use App\Models\AppModels\Cart;
use Carbon\Carbon;
use App\Models\Core\Manufacturers;
use App\Models\Core\Setting;
use App\Models\Core\Package;
use App\Http\Controllers\AdminControllers\SiteSettingController;
use App\Http\Controllers\AdminControllers\AlertController;
use App\Models\Core\Images;

class MyNewProductController extends Controller
{

    public function __construct(Setting $setting)
    {
        $this->Setting = $setting;
    }
    
    public function shipping_methods(Request $request){
        $shipping_methods = DB::table('shipping_methods')->where('status',1)->get();
        $method_details = [];
        foreach($shipping_methods as $key => $method ){
            $method_details[$key]['method'] = $method;
            $method_details[$key]['method_details'] = DB::table($method->table_name)->get();
        }

        
        return response()->json(['message' => 'Shipping Methods', 'shipping_methods' => $method_details]);
    }
    
    public function get_single_product(Request $request)
    {
        
       $produtc = DB::table('products')->where('products_id', $request['product_id'])->first();
       
        $hotCat = DB::table('products_to_hotcats')->where('products_id', $request['product_id'])->get();
            
        $h_infos = "";
     
        if($hotCat->count() > 0){
            $h_infos = DB::table('hotcats')->select('hotcats_id', 'hotcat_name', 'hotcats_color_code')->where('hotcats_id', $hotCat[0]->hotcats_id)->first();
            $produtc->hotcat_id = $h_infos->hotcats_id;
            $produtc->hotcat_name = $h_infos->hotcat_name;
            $produtc->hotcat_color_code = $h_infos->hotcats_color_code;
            
        }


        $special = DB::table('specials')->where('products_id', $request['product_id'])->where('status', 1)->where('expires_date', '>=', strtotime("now"))->first();
        
        if(!empty($special)){
            
            $special_price = $special->specials_new_products_price;

            $discount = round((($produtc->products_price - $special_price) / $produtc->products_price) * 100);

            $produtc->discount = $discount;
            $produtc->discounted_price = $special->specials_new_products_price;
            $produtc->discount_expires_date = date('Y-m-d',$special->expires_date);
        }

        $flash_sale = DB::table('flash_sale')->where('products_id', $request['product_id'])->where('flash_status', 1)->where('flash_expires_date', '>=', strtotime("now"))->first();

        if(!empty($flash_sale)){
            
            $flash_sale_price = $flash_sale->flash_sale_products_price;

            $discount = round((($produtc->products_price - $flash_sale_price) / $produtc->products_price) * 100);

            $produtc->flash_discounted_price = $flash_sale->flash_sale_products_price;
            $produtc->flash_discount = $discount;
            $produtc->flash_expires_date = date('Y-m-d H:m:i',$flash_sale->flash_expires_date);
        }

        $p_msd = DB::table('products_msd')->where('products_id', $request['product_id'])->where('discount', '<>', 0)->where('discount', '<>', NULL)->get();
        $msd = [];
        if(!empty($p_msd)){
            $cnt = 0;
            foreach($p_msd as $key => $m){
                $msd[$key] = DB::table('memberships')->select('membership_id', 'membership_name')->where('membership_id', $m->level_id)->first();
                $msd[$key]->discount =  $m->discount;
            }
            $produtc->msd_info = $msd;
        }

        //$p_img = DB::table('products_images')->where('products_id', $request['product_id'])->where('image', '<>', NULL)->get();
        $p_img = DB::table('product_images_cloud')->where('product_id', $request['product_id'])->get();

        //return response()->json($p_img);

        if(!empty($p_img)){

            $images = [];
            $cnt = 0;
            // $p_main_img = DB::table('image_categories')->where('image_id', $p->main_image_id)->first()->path;
            $p_main_img = $p_img->where('image_no', 0)->first() != null ? $p_img->where('image_no', 0)->first()->url : '';
            $images[0] = $p_main_img;
            $images[1] = $p_img->where('image_no', 1)->first() != null ? $p_img->where('image_no', 1)->first()->url : '';
            $images[2] = $p_img->where('image_no', 2)->first() != null ? $p_img->where('image_no', 2)->first()->url : '';
            $images[3] = $p_img->where('image_no', 3)->first() != null ? $p_img->where('image_no', 3)->first()->url : '';
            

            /* foreach($p_img as $mg){
                $img = DB::table('image_categories')->where('image_id', $mg->image)->first()->path;
                $cnt++;
                $images[$cnt] = $img;
            } */

            $produtc->product_images_path = $images;
        }

        return response()->json($produtc);
    }
    
    
    public function all_pages(){


       $pages = DB::table('pages')
         ->leftJoin('pages_description', 'pages_description.page_id', '=', 'pages.page_id')
         ->where([
               ['pages_description.language_id','=',1],
               ['pages.type','=','1']
             ])
         ->orderBy('pages.page_id', 'ASC')
         ->get();
    
       return $pages;
    }
    
    public function faq_page(){
     
        $faq = DB::table('faq')
                    ->select('faq.id', 'faq.question', 'faq.answer', 'faq_cat.name as faq_cat_name')
                    ->join('faq_cat', 'faq.cat_id', '=', 'faq_cat.id')
                    ->get();
        return response()->json(['faqs' => $faq]);
       
    }
    public function discounted_products(){
        $product_ids = DB::table('specials')->where('status',1)->where('expires_date','>',time())->select('*', \DB::raw('FROM_UNIXTIME(expires_date) AS timeu'))->get()->pluck('products_id');
        $products = $this->get_product_info_incl_variable($product_ids);
        
        return response()->json(['discounted_products' => $products]);
    } 
    public function trending_products(){
        $products = DB::table('products as p')
                   ->where('p.products_status', 1)
                    ->leftJoin('products_description as pd', 'pd.products_id', '=', 'p.products_id')
                    ->leftJoin('products_to_hotcats as pth', 'pth.products_id', '=', 'p.products_id')
                    ->leftJoin('hotcats as h', 'h.hotcats_id', '=', 'pth.hotcats_id')
                    ->leftJoin('manufacturers as mn', 'mn.manufacturers_id', '=', 'p.manufacturers_id')
                    ->leftJoin('specials as s', function($join)
                         {
                             $join->on('s.products_id', '=', 'p.products_id')
                             ->where(function ($query) {
                                $query->where('s.status', '=', 1);
                                $query->where('expires_date', '>=', strtotime("now"));
                            });
                         })
                     ->where('pd.language_id', 1)
                    ->where('p.products_in_stock', '>', 0)
                    ->where('mn.manufacturer_status', 1)
                    ->where('pd.products_viewed','!=', 0)
                    ->groupBy('p.products_id')
                    ->orderBy('pd.products_viewed', 'DESC')
                    ->select('p.products_id as product_id',
                             'p.products_type as products_type',
                             'p.products_in_stock as product_stock',
                             'pd.products_name  as product_name',
                             'pd.products_description as product_description',
                             'pd.products_viewed as product_viewed',
                             'p.products_quantity as product_quantity',
                             'p.products_video_link as product_video_link',
                             'p.products_price as product_price',
                             'p.products_weight as product_weight',
                             'p.products_weight_unit as product_weight_unit',
                             'p.products_status as product_status',
                             'p.is_current as is_current_product',
                             'p.products_tax_class_id as product_tax_class_id',
                             'p.manufacturers_id as product_manufacturer_id',
                             'p.products_ordered as product_ordered',
                             'p.products_liked as product_liked',
                             'p.low_limit as low_limit',
                             'p.products_type as product_type',
                             'p.products_min_order as product_min_order',
                             'p.products_max_order as product_max_order',
                             'p.products_max_stock as product_max_stock',
                             'p.products_price_market as product_price_market',
                             'p.products_points as product_points',
                             'p.products_points_redeem as product_points_redeem',
                             'p.products_points_bonus as product_points_bonus',
                             'p.products_note as product_note',
                             'p.products_sku as product_sku',
                             'p.products_msd as has_msd',
                             'p.sb_unique_id as product_sb_unique_id',
                             'p.expire_date as product_expire_date',
                             'p.products_image as main_image_id',
                             'h.hotcats_id as hotcat_id',
                             'h.hotcat_name as hotcat_name',
                             'h.hotcats_color_code as hotcat_color_code',
                             's.specials_new_products_price as discounted_price',
                             's.expires_date as discounted_expires_date'
                             )->limit(50)
                    ->get();

        foreach($products as $p){
            
            if($p->hotcat_id == null){
                unset($p->hotcat_id);
            }
            if($p->hotcat_name == null){
                unset($p->hotcat_name);
            }
            if($p->hotcat_color_code == null){
                unset($p->hotcat_color_code);
            }
            if($p->discounted_expires_date == null){
                unset($p->discounted_expires_date);
            }
            else{
                $p->discounted_expires_date = date('Y-m-d', $p->discounted_expires_date);
            }
            if($p->discounted_price == null){
                unset($p->discounted_price);
            }
            else{
                $special_price = $p->discounted_price;

                $discount = round((($p->product_price - $special_price) / $p->product_price) * 100);

                $p->discount = $discount;
            }

            if($p->has_msd == 'Y'){
                $msd = [];
                $p_msd = DB::table('products_msd')->where('products_id', $p->product_id)->where('discount', '<>', 0)->where('discount', '<>', NULL)->get();
                
                if(!empty($p_msd)){
                    $cnt = 0;
                    foreach($p_msd as $key => $m){
                        $msd[$key] = DB::table('memberships')->select('membership_id', 'membership_name')->where('membership_id', $m->level_id)->first();
                        $msd[$key]->discount =  $m->discount;
                    }
                    $p->msd_info = $msd;
                }
            }
            

            //$p_img = DB::table('products_images')->where('products_id', $p->product_id)->where('image', '<>', NULL)->get();
            $p_img = DB::table('product_images_cloud')->where('product_id', $p->product_id)->get();


            if(!empty($p_img)){

                $images = [];
                $cnt = 0;
                // $p_main_img = DB::table('image_categories')->where('image_id', $p->main_image_id)->first()->path;
                $p_main_img = $p_img->where('image_no', 0)->first() != null ? $p_img->where('image_no', 0)->first()->url : '';
                $images[0] = $p_main_img;
                $images[1] = $p_img->where('image_no', 1)->first() != null ? $p_img->where('image_no', 1)->first()->url : '';
                $images[2] = $p_img->where('image_no', 2)->first() != null ? $p_img->where('image_no', 2)->first()->url : '';
                $images[3] = $p_img->where('image_no', 3)->first() != null ? $p_img->where('image_no', 3)->first()->url : '';
                

                /* foreach($p_img as $mg){
                    $img = DB::table('image_categories')->where('image_id', $mg->image)->first()->path;
                    $cnt++;
                    $images[$cnt] = $img;
                } */

                $p->product_images_path = $images;
            }
        }
        
        
        
        return response()->json(['trending_products' => $products]);
    }
    public function bonus_point_products(){
        $product_ids = DB::table('products')->where('products_points_bonus','!=', NULL)->limit(50)->get()->pluck('products_id');
        $products = $this->get_product_info_incl_variable($product_ids);
        
        return response()->json(['bonus_point_products' => $products]);
    }
    public function msd_products(){
        $product_ids = DB::table('products')->where('products_msd','Y')->limit(50)->get()->pluck('products_id');
        $products = $this->get_product_info_incl_variable($product_ids);
        
        return response()->json(['msd_products' => $products]);
    }
    public function exclusive_products(){
        $product_ids = DB::table('products')->where('products_price_market', NULL)->limit(50)->get()->pluck('products_id');
        $products = $this->get_product_info_incl_variable($product_ids);
        
        return response()->json(['exclusive_products' => $products]);
    }
 
    // 10 random brands
    
    public function get_random_brands(Request $request){
        $brands = DB::table('manufacturers')
            ->join('manufacturers_info', 'manufacturers_info.manufacturers_id', '=', 'manufacturers.manufacturers_id')
            //           ->join('images', 'images.id', '=', 'manufacturers.manufacturer_image')
            ->LeftJoin('image_categories', function ($join) {
                $join->on('image_categories.image_id', '=', 'manufacturers.manufacturer_image')->where(function ($query) {
                    $query->where('image_categories.image_type', '=', 'THUMBNAIL')
                        ->where('image_categories.image_type', '!=', 'THUMBNAIL')
                        ->orWhere('image_categories.image_type', '=', 'ACTUAL');
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
            ->where('manufacturers_info.languages_id', '=', 1)
            ->where('manufacturers.manufacturer_status', '=', 1)
            ->inRandomOrder()
            ->limit(10)
            ->select('manufacturers.manufacturers_id as id', 'manufacturers_info.*', 'manufacturers.manufacturer_image as image', 'manufacturer_image_header as header_image', 'manufacturers.manufacturer_name as name', 'manufacturers_info.manufacturers_url as url', 'manufacturers_info.url_clicked', 'manufacturers_info.date_last_click as clik_date', 'header.path as header_image_path', 'image_categories.path as path')
            ->get();

        return response()->json(['random_brands' => $brands]);
    }
    /* Single product api */

    public function get_super_deals(Request $request)
    {
        $super_deals = DB::table('super_deals')
                        ->LeftJoin('image_categories', 'image_categories.image_id', '=', 'super_deals.bg_image_id')
                        ->where('super_deals.status', 1)
                        ->select('super_deals.id as id', 'super_deals.cap_amount as cap_amount', 'super_deals.type as type','super_deals.superdeal_max_order as superdeal_max_order', 'image_categories.path as bg_image_path')
                        ->first();

        if(isset($super_deals)){
            $sd_products = DB::table('super_deals_products')->get();
            $pid_to_price = $sd_products->pluck('new_product_price', 'product_id');
            $pid_to_point = $sd_products->pluck('new_point', 'product_id');
            $product_ids = $sd_products->pluck('product_id');

            $products = $this->get_product_info_incl_variable($product_ids);

            foreach($products as $p){
                if($super_deals->type == 'price'){
                    $p->super_deals_price = $pid_to_price[$p->product_id];
                }
                elseif($super_deals->type == 'point'){
                    $p->super_deals_point = $pid_to_point[$p->product_id];
                }
            }

            $super_deals->products = $products;
        }
        return response()->json(['super_deals' => $super_deals]);
    }

    public function get_product_info_incl_variable($product_ids = null){

        $products = DB::table('products as p')
                   ->where('p.products_status', 1)
                    ->whereIn('p.products_id', $product_ids)
                    ->leftJoin('products_description as pd', 'pd.products_id', '=', 'p.products_id')
                    ->leftJoin('products_to_hotcats as pth', 'pth.products_id', '=', 'p.products_id')
                    ->leftJoin('hotcats as h', 'h.hotcats_id', '=', 'pth.hotcats_id')
                    ->leftJoin('manufacturers as mn', 'mn.manufacturers_id', '=', 'p.manufacturers_id')
                    ->leftJoin('specials as s', function($join)
                         {
                             $join->on('s.products_id', '=', 'p.products_id')
                             ->where(function ($query) {
                                $query->where('s.status', '=', 1);
                                $query->where('expires_date', '>=', strtotime("now"));
                            });
                         })
                     ->where('pd.language_id', 1)
                    ->where('p.products_in_stock', '>', 0)
                    ->where('mn.manufacturer_status', 1)
                    ->groupBy('p.products_id')
                    ->orderBy('p.products_in_stock', 'DESC')
                    ->select('p.products_id as product_id',
                             'p.products_type as products_type',
                             'p.products_in_stock as product_stock',
                             'pd.products_name  as product_name',
                             'pd.products_description as product_description',
                             'pd.products_viewed as product_viewed',
                             'p.products_quantity as product_quantity',
                             'p.products_video_link as product_video_link',
                             'p.products_price as product_price',
                             'p.products_weight as product_weight',
                             'p.products_weight_unit as product_weight_unit',
                             'p.products_status as product_status',
                             'p.is_current as is_current_product',
                             'p.products_tax_class_id as product_tax_class_id',
                             'p.manufacturers_id as product_manufacturer_id',
                             'p.products_ordered as product_ordered',
                             'p.products_liked as product_liked',
                             'p.low_limit as low_limit',
                             'p.products_type as product_type',
                             'p.products_min_order as product_min_order',
                             'p.products_max_order as product_max_order',
                             'p.products_max_stock as product_max_stock',
                             'p.products_price_market as product_price_market',
                             'p.products_points as product_points',
                             'p.products_points_redeem as product_points_redeem',
                             'p.products_points_bonus as product_points_bonus',
                             'p.products_note as product_note',
                             'p.products_sku as product_sku',
                             'p.products_msd as has_msd',
                             'p.sb_unique_id as product_sb_unique_id',
                             'p.expire_date as product_expire_date',
                             'p.products_image as main_image_id',
                             'h.hotcats_id as hotcat_id',
                             'h.hotcat_name as hotcat_name',
                             'h.hotcats_color_code as hotcat_color_code',
                             's.specials_new_products_price as discounted_price',
                             's.expires_date as discounted_expires_date'
                             )
                    ->get();

        foreach($products as $p){
            
            if($p->hotcat_id == null){
                unset($p->hotcat_id);
            }
            if($p->hotcat_name == null){
                unset($p->hotcat_name);
            }
            if($p->hotcat_color_code == null){
                unset($p->hotcat_color_code);
            }
            if($p->discounted_expires_date == null){
                unset($p->discounted_expires_date);
            }
            else{
                $p->discounted_expires_date = date('Y-m-d', $p->discounted_expires_date);
            }
            if($p->discounted_price == null){
                unset($p->discounted_price);
            }
            else{
                $special_price = $p->discounted_price;

                $discount = round((($p->product_price - $special_price) / $p->product_price) * 100);

                $p->discount = $discount;
            }

            if($p->has_msd == 'Y'){
                $msd = [];
                $p_msd = DB::table('products_msd')->where('products_id', $p->product_id)->where('discount', '<>', 0)->where('discount', '<>', NULL)->get();
                
                if(!empty($p_msd)){
                    $cnt = 0;
                    foreach($p_msd as $key => $m){
                        $msd[$key] = DB::table('memberships')->select('membership_id', 'membership_name')->where('membership_id', $m->level_id)->first();
                        $msd[$key]->discount =  $m->discount;
                    }
                    $p->msd_info = $msd;
                }
            }
            

            //$p_img = DB::table('products_images')->where('products_id', $p->product_id)->where('image', '<>', NULL)->get();
            $p_img = DB::table('product_images_cloud')->where('product_id', $p->product_id)->get();


            if(!empty($p_img)){

                $images = [];
                $cnt = 0;
                // $p_main_img = DB::table('image_categories')->where('image_id', $p->main_image_id)->first()->path;
                $p_main_img = $p_img->where('image_no', 0)->first() != null ? $p_img->where('image_no', 0)->first()->url : '';
                $images[0] = $p_main_img;
                $images[1] = $p_img->where('image_no', 1)->first() != null ? $p_img->where('image_no', 1)->first()->url : '';
                $images[2] = $p_img->where('image_no', 2)->first() != null ? $p_img->where('image_no', 2)->first()->url : '';
                $images[3] = $p_img->where('image_no', 3)->first() != null ? $p_img->where('image_no', 3)->first()->url : '';
                

                /* foreach($p_img as $mg){
                    $img = DB::table('image_categories')->where('image_id', $mg->image)->first()->path;
                    $cnt++;
                    $images[$cnt] = $img;
                } */

                $p->product_images_path = $images;
            }
        }
        
        return $products;
    }


}
