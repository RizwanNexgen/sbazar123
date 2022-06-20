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

class MyProductController extends Controller
{

    public function __construct(Setting $setting)
    {
        $this->Setting = $setting;
    }



    /*public function brand_product(Request $request)
    {

        $brand = DB::table('manufacturers')->where('manufacturers_id', '=', $request->brand_id)->first();

        if ($brand->manufacturer_status == 0) {
            //Inactive brand
            return response()->json(['brand_products' => []]);
        }

        $products = DB::table('products')->where('products.manufacturers_id', '=', $request->brand_id)

            ->LeftJoin('products_to_categories', 'products_to_categories.products_id', '=', 'products.products_id')
            ->LeftJoin('bundles_products', 'bundles_products.product_id', '=', 'products.products_id')
            ->LeftJoin('products_description', 'products_description.products_id', '=', 'products.products_id')
            ->LeftJoin('products as sub_products', 'sub_products.parent_products_id', '=', 'products.products_id')
            ->LeftJoin('images', 'images.id', '=', 'products.products_image')
            ->LeftJoin('flash_sale', 'flash_sale.products_id', '=', 'products.products_id')
            ->LeftJoin('specials', 'specials.products_id', '=', 'products.products_id')
            ->LeftJoin('image_categories', function ($join) {
                $join->on('image_categories.image_id', '=', 'products.products_image')->where(function ($query) {
                    $query->where('image_categories.image_type', '=', 'THUMBNAIL')
                        ->where('image_categories.image_type', '=', 'THUMBNAIL')
                        ->orWhere('image_categories.image_type', '=', 'THUMBNAIL');
                });
            })

            ->where('products_description.language_id', '=', 1)
            ->where('products.products_status', '=', 1)
            ->where('products.parent_products_id', '=', null)


            ->select(
                'products.products_id as products_products_id',
                'bundles_products.product_id as product_in_bundles',
                'products.*',
                'products_description.*',
                'products_description.products_id as products_description_products_id',
                'images.name as image_of_product',
                'image_categories.path as path',
                'flash_sale.*',
                'flash_sale.products_id as flash_sale_products_id',
                DB::raw('0 as flash_sale_timer_duration'),
                DB::raw('0 as flash_sale_timer_status'),
                'specials.*',
                DB::raw('0 as special_discount_price_status'),
                'specials.products_id as specials_products_id',
                'specials.status as specials_status',
                'sub_products.products_id  as product_variation_id',
                'sub_products.products_weight  as product_variation_weight',
                'sub_products.products_weight_unit  as product_variation_unit',
                DB::raw('group_concat(products_to_categories.categories_id) as categorie_ids')
            )
            // ->orderBy('products_products_id', 'DESC')
            // ->take(20)  
            ->groupBy('products_products_id')
            ->get();


        $nowTime = date("Y-m-d H:i:s", time());

        for ($i = 0; $i < count($products); $i++) {

            $expiry  = date("Y-m-d H:i:s", $products[$i]->expires_date);
            $flash_expires_date  = date("Y-m-d H:i:s",  $products[$i]->flash_expires_date);

            $flash_start_date  = date("Y-m-d H:i:s",  $products[$i]->flash_start_date);



            if ($products[$i]->specials_id != null && $expiry > $nowTime && $products[$i]->specials_status == 1) {

                $products[$i]->special_discount_price_status = 1;
            }

            if ($products[$i]->flash_sale_id != null && $flash_expires_date > $nowTime &&  $products[$i]->flash_status == 1) {


                $dtDiff = $products[$i]->flash_expires_date - time();
                $totalDays = intval($dtDiff / (24 * 60 * 60));
                $totalHours = $totalDays * 24;

                $products[$i]->flash_sale_timer_status = 1;
                $products[$i]->flash_sale_timer_duration = $totalHours;
            }
        }

        return response()->json(['brand_products' => $products]);
    }*/
    
    public function brand_product(Request $request)
    {

        $brand = DB::table('manufacturers')->where('manufacturers_id', '=', $request->brand_id)->first();

        if ($brand->manufacturer_status == 0) {
            //Inactive brand
            return response()->json(['brand_products' => []]);
        }

        $product_ids = DB::table('products')
                ->where('products.manufacturers_id', $request->brand_id)
                ->select('products_id')
                ->get()->pluck('products_id');
        
        $products = $this->get_product_info($product_ids);

        return response()->json(['brand_products' => $products]);
    }




    public function app_banners()
    {



        $data = [];
        $data['pageTitle'] = 'Menubar';

        $data['list'] = DB::table('app_menus')
            ->select('app_menus.*', 'app_menus_langs.title')
            ->leftJoin('app_menus_langs', 'app_menus_langs.app_menu_id', '=', 'app_menus.id')
            ->where('app_menus_langs.language_id', 1)
            ->orderBy('app_menus.id', 'ASC')
            ->get();

        //$result['commonContent'] = $this->Setting->commonContent();

        //return view("admin.app_menus.index", $data)->with('result', $result);
        return response()->json($data);
    }

    public function recomendedproducts(Request $request)
    {


        $categories = DB::table('categories')
            ->where('categories.parent_id', '=', $request->parent_id)
            ->where('categories.categories_status', '=', 1)
            ->select('categories.*')
            ->get();

        if ($categories->count() > 0) {
            $cat_ids = [];
            foreach ($categories as $categorie) {
                $cat_ids[] = $categorie->categories_id;
            }
        }


        $products = DB::table('products_to_categories')->whereIn('categories_id', $cat_ids)
            ->join('products', 'products.products_id', '=', 'products_to_categories.products_id')
            ->LeftJoin('bundles_products', 'bundles_products.product_id', '=', 'products.products_id')
            ->LeftJoin('products_description', 'products_description.products_id', '=', 'products.products_id')
            ->LeftJoin('products as sub_products', 'sub_products.parent_products_id', '=', 'products.products_id')
            ->LeftJoin('images', 'images.id', '=', 'products.products_image')
            ->LeftJoin('flash_sale', 'flash_sale.products_id', '=', 'products.products_id')
            ->LeftJoin('specials', 'specials.products_id', '=', 'products.products_id')

            ->LeftJoin('products_to_hotcats', 'products_to_hotcats.products_id', '=', 'products.products_id')
            ->LeftJoin('hotcats', 'products_to_hotcats.hotcats_id', '=', 'hotcats.hotcats_id')

            ->LeftJoin('products_msd', 'products_msd.products_id', '=', 'products.products_id')
            ->LeftJoin('memberships', 'products_msd.level_id', '=', 'memberships.membership_id')

            /* ->LeftJoin('image_categories', function ($join) {
                $join->on('image_categories.image_id', '=', 'products.products_image')->where(function ($query) {
                    $query->where('image_categories.image_type', '=', 'THUMBNAIL')
                        ->where('image_categories.image_type', '!=', 'THUMBNAIL')
                        ->orWhere('image_categories.image_type', '=', 'ACTUAL');
                });
            }) */

            ->LeftJoin('product_images_cloud', function ($join) {
                $join->on('product_images_cloud.product_id', '=', 'products.products_id')->where(function ($query) {
                    $query->where('product_images_cloud.image_no', '=', 0);
                });
            })

            ->where('products_description.language_id', '=', 1)
            ->where('products.products_status', '=', 1)
            ->where('products.parent_products_id', '=', null)
            ->where('products.is_feature', '=', 1)



            ->select(
                'products.products_id as products_products_id',
                'bundles_products.product_id as product_in_bundles',
                'products.*',
                'products_description.*',
                'products_description.products_id as products_description_products_id',
                'images.name as image_of_product',
                /* 'image_categories.path as path', */
                'product_images_cloud.url as path',
                'flash_sale.*',
                'flash_sale.products_id as flash_sale_products_id',
                DB::raw('0 as flash_sale_timer_duration'),
                DB::raw('0 as flash_sale_timer_status'),
                'specials.*',
                DB::raw('0 as special_discount_price_status'),
                'specials.products_id as specials_products_id',
                'specials.status as specials_status',
                'sub_products.products_id  as product_variation_id',
                'sub_products.products_weight  as product_variation_weight',
                'sub_products.products_weight_unit  as product_variation_unit',


                'hotcats.hotcats_id as hotcat_id',
                'hotcats.hotcat_name as hotcat_name',
                'hotcats.hotcats_color_code as hotcats_color_code',
                'memberships.membership_id as msd_id',
                'memberships.membership_name as msd_name',
                'memberships.membership_discount_percentage as msd_discount',
                'memberships.membership_points_from as msd_points_from',
                'memberships.membership_points_to as msd_points_to',
                'memberships.membership_cap_value as msd_cap_value',
                'memberships.membership_has_validity as msd_has_validity',
                'memberships.membership_valid_till as msd_valid_till',
                'memberships.membership_status as msd_status'
            )
            // ->orderBy('products_products_id', 'DESC')
            // ->take(20)  
            ->groupBy('products_products_id')
            ->get();


        $nowTime = date("Y-m-d H:i:s", time());

        for ($i = 0; $i < count($products); $i++) {
            $expiry  = date("Y-m-d H:i:s", $products[$i]->expires_date);
            $flash_expires_date  = date("Y-m-d H:i:s",  $products[$i]->flash_expires_date);

            $flash_start_date  = date("Y-m-d H:i:s",  $products[$i]->flash_start_date);



            if ($products[$i]->specials_id != null && $expiry > $nowTime && $products[$i]->specials_status == 1) {

                $products[$i]->special_discount_price_status = 1;
            }

            if ($products[$i]->flash_sale_id != null && $flash_expires_date > $nowTime &&  $products[$i]->flash_status == 1) {


                $dtDiff = $products[$i]->flash_expires_date - time();
                $totalDays = intval($dtDiff / (24 * 60 * 60));
                $totalHours = $totalDays * 24;

                $products[$i]->flash_sale_timer_status = 1;
                $products[$i]->flash_sale_timer_duration = $totalHours;
            }
        }

        return response()->json(['category_products' => $products]);
    }
    
    /*Api for bundle*/
    public function bundles(Request $request)
    {

        $bundles = DB::table('bundles')

            ->LeftJoin('bundles_info', 'bundles_info.bundle_id', '=', 'bundles.id')

            ->LeftJoin('image_categories', function ($join) {
                $join->on('image_categories.image_id', '=', 'bundles.bg_image_id')->where(function ($query) {
                    $query->where('image_categories.image_type', '=', 'THUMBNAIL')
                        ->where('image_categories.image_type', '!=', 'THUMBNAIL')
                        ->orWhere('image_categories.image_type', '=', 'ACTUAL');
                });
            })

            ->where('bundles_info.language_id', '=', 1)
            ->where('bundles.status', '=', 1)
            ->select(
                'bundles.id as id',
                'bundles_info.bundle_title as bundle_title',
                'bundles.bundle_type as bundle_type',
                'bundles.discount as discount',
                'bundles.has_msd as has_msd',
                'bundles.max_order as max_order',
                'image_categories.path as bundle_image_path'
            )

            ->get();


        foreach ($bundles as $b) {

            $combo_details = DB::table('bundles_products')
                ->where('bundles_products.bundle_id', $b->id)
                ->select('product_id', 'quantity')
                ->get();
            
            $pid_to_quantity = $combo_details->pluck('quantity', 'product_id');
            $product_ids = $combo_details->pluck('product_id');

            $products = $this->get_product_info($product_ids);

            if ($b->has_msd == 'Y') {

                $msd = DB::table('bundles_msd')

                    ->where('bundles_msd.bundle_id', $b->id)

                    ->join('memberships', 'memberships.membership_id', '=', 'bundles_msd.level_id')

                    ->LeftJoin('image_categories', function ($join) {
                        $join->on('image_categories.image_id', '=', 'memberships.membership_image')->where(function ($query) {
                            $query->where('image_categories.image_type', '=', 'THUMBNAIL')
                                ->where('image_categories.image_type', '!=', 'THUMBNAIL')
                                ->orWhere('image_categories.image_type', '=', 'ACTUAL');
                        });
                    })

                    ->select(
                        'memberships.membership_id as msd_id',
                        'memberships.membership_name as membership_name',
                        'image_categories.path as membership_image_path',
                        'bundles_msd.discount as membership_discount'
                    )
                    ->get();

                $b->msd_info = $msd;
            }

            $b->number_of_products = count($products);
            
            $b->total_price = round($products->sum(function ($t) use ($pid_to_quantity) {
                return $t->product_price * $pid_to_quantity[$t->product_id];
            }));
            
            $b->total_point = round($products->sum(function ($t) use ($pid_to_quantity) {
                return $t->product_points * $pid_to_quantity[$t->product_id];
            }));

            if ($b->bundle_type == 1) {

                $b->bundle_type = 'price';
                

                $b->discount_amount = round(($b->total_price * $b->discount) / 100);
                $b->bundle_total = $b->total_price - $b->discount_amount;

            } elseif ($b->bundle_type == 2) {

                $b->bundle_type = 'point';
                

                $b->incremented_point = round(($b->total_point * $b->discount) / 100);
                $b->bundle_total = round($b->total_point + $b->incremented_point);
            }
            foreach($products as $p){
                $p->products_quantity = $pid_to_quantity[$p->product_id];
            }
            $b->products = $products;
        }



        return response()
            ->json(['bundles' => $bundles]);
    }
    
    public function bundle_products(Request $request)
    {
        $product_ids = DB::table('bundles_products')->where('bundle_id', $request->bundle_id)->get()->pluck('product_id');
        return response()->json(['bundle_products' => $this->get_product_info($product_ids)]);
    }
    
    public function addCartBundle(Request $request)
    {

        $email = $request->email;
        $bundle_id = $request->bundle_id;

        $user = DB::table('users')->where('email', $email)->first();

        $check = DB::table('cart_bundle')->where('user_id', '=', $user->id)
            ->where('bundle_id', '=', $bundle_id)->first();

        if (!$check) {

            DB::table('cart_bundle')->insert([

                'user_id' => $user->id,
                'bundle_id' => $bundle_id,
                'qty' => 1

            ]);


            return response()
                ->json(['message' => 'Bundle added to cart'], 200);
        } else {
            return response()
                ->json(['message' => 'Bundle is already added into cart'], 200);
        }
    }

    public function remove_bundle_from_cart(Request $request)
    {

        $email = $request->email;
        $bundle_id = $request->bundle_id;

        $user = DB::table('users')->where('email', $email)->first();

        $check = DB::table('cart_bundle')->where('user_id', '=', $user->id)
            ->where('bundle_id', '=', $bundle_id);

        $check->delete();
        
        return response()
            ->json(['message' => 'Bundle removed from cart'], 200);
    }

    public function add_bundle_qty(Request $request)
    {

        $email = $request->email;
        $bundle_id = $request->bundle_id;

        $user = DB::table('users')->where('email', $email)->first();



        $cart = DB::table('cart_bundle')->where('user_id', '=', $user->id)
            ->where('bundle_id', '=', $bundle_id)->increment('qty', 1);


        return response()
            ->json(['message' => 'Bundle quantity increased by 1'], 200);
    }

    public function decrease_bundle_qty(Request $request)
    {

        $email = $request->email;
        $bundle_id = $request->bundle_id;

        $user = DB::table('users')->where('email', $email)->first();

        if(empty($user)){
            return response()
                ->json(['message' => 'Invalid user'], 400);
        }

        DB::table('cart_bundle')->where('user_id', '=', $user->id)
            ->where('bundle_id', '=', $bundle_id)->decrement('qty', 1);

        $cart = DB::table('cart_bundle')->where('user_id', '=', $user->id)
            ->where('bundle_id', '=', $bundle_id)->first();

        if(empty($cart)){
            return response()
                ->json(['message' => 'Invalid Bundle ID'], 400);
        }

        if($cart->qty == 0){

            DB::table('cart_bundle')->where('user_id', '=', $user->id)
            ->where('bundle_id', '=', $bundle_id)->delete();

            return response()
            ->json(['message' => 'Quantity zero. Bundle removed.'], 200);
        }

        return response()
            ->json(['message' => 'Bundle quantity decreased by 1'], 200);
    }
    /*Api for bundle*/
    
    
    /*Api for Combo*/

    public function combos(Request $request)
    {

        $combos = DB::table('combos')

            ->LeftJoin('combos_info', 'combos_info.combo_id', '=', 'combos.id')

            ->LeftJoin('image_categories', function ($join) {
                $join->on('image_categories.image_id', '=', 'combos.bg_image_id')->where(function ($query) {
                    $query->where('image_categories.image_type', '=', 'THUMBNAIL')
                        ->where('image_categories.image_type', '!=', 'THUMBNAIL')
                        ->orWhere('image_categories.image_type', '=', 'ACTUAL');
                });
            })

            ->where('combos_info.language_id', '=', 1)
            ->where('combos.status', '=', 1)
            ->select('combos.id as id', 'combos_info.combo_title as title','combos.max_order as max_order', 'combos.discount as discount', 'image_categories.path as combo_image_path', 'combos.has_msd as has_msd')
            ->get();

        foreach ($combos as $c) {

            $combo_details = DB::table('combos_products')
                ->where('combos_products.combo_id', $c->id)
                ->select('product_id', 'quantity')
                ->get();
            
            $pid_to_quantity = $combo_details->pluck('quantity', 'product_id');
            $product_ids = $combo_details->pluck('product_id');

            // $products = $this->get_product_info($product_ids);
            $products = $this->get_product_info_incl_variable($product_ids);
            
            
            if ($c->has_msd == 1) {

                $c->has_msd = 'Y';

                $msd = DB::table('combos_msd')

                    ->where('combos_msd.combo_id', $c->id)

                    ->join('memberships', 'memberships.membership_id', '=', 'combos_msd.membership_id')

                    ->LeftJoin('image_categories', function ($join) {
                        $join->on('image_categories.image_id', '=', 'memberships.membership_image')->where(function ($query) {
                            $query->where('image_categories.image_type', '=', 'THUMBNAIL')
                                ->where('image_categories.image_type', '!=', 'THUMBNAIL')
                                ->orWhere('image_categories.image_type', '=', 'ACTUAL');
                        });
                    })

                    ->select(
                        'memberships.membership_id as msd_id',
                        'memberships.membership_name as membership_name',
                        'image_categories.path as membership_image_path',
                        'combos_msd.discount as membership_discount'
                    )
                    ->get();

                $c->msd_info = $msd;
            } else {
                $c->has_msd = 'N';
            }

            $c->number_of_products = count($products);

            $c->total_price = round($products->sum(function ($t) use ($pid_to_quantity) {
                return $t->product_price * $pid_to_quantity[$t->product_id];
            }));
            
            $c->total_point = round($products->sum(function ($t) use ($pid_to_quantity) {
                return $t->product_points * $pid_to_quantity[$t->product_id];
            }));

            $c->discount_amount = round(($c->total_price * $c->discount) / 100);
            $c->combo_total = $c->total_price - $c->discount_amount;
            foreach($products as $p){
                $p->products_quantity = $pid_to_quantity[$p->product_id];
            }
            $c->products = $products;
        }

        return response()
            ->json(['combos' => $combos]);
    }

    public function combo_products(Request $request)
    {
        $product_ids = DB::table('combos_products')->where('combo_id', $request->combo_id)->get()->pluck('product_id');
        return response()->json(['combo_products' => $this->get_product_info($product_ids)]);
    }

    public function addCartCombo(Request $request)
    {

        $email = $request->email;
        $combo_id = $request->combo_id;

        $user = DB::table('users')->where('email', $email)->first();

        $check = DB::table('cart_combo')->where('user_id', '=', $user->id)
            ->where('combo_id', '=', $combo_id)->first();

        if (!$check) {

            DB::table('cart_combo')->insert([

                'user_id' => $user->id,
                'combo_id' => $combo_id,
                'qty' => 1

            ]);


            return response()
                ->json(['message' => 'Combo added to cart'], 200);
        } else {
            return response()
                ->json(['message' => 'Combo is already added into cart'], 200);
        }
    }

    public function remove_combo_from_cart(Request $request)
    {

        $email = $request->email;
        $combo_id = $request->combo_id;

        $user = DB::table('users')->where('email', $email)->first();

        $check = DB::table('cart_combo')->where('user_id', '=', $user->id)
            ->where('combo_id', '=', $combo_id);

        $check->delete();
        
        return response()
            ->json(['message' => 'Combo removed from cart'], 200);
    }

    public function add_combo_qty(Request $request)
    {

        $email = $request->email;
        $combo_id = $request->combo_id;

        $user = DB::table('users')->where('email', $email)->first();



        $cart = DB::table('cart_combo')->where('user_id', '=', $user->id)
            ->where('combo_id', '=', $combo_id)->increment('qty', 1);


        return response()
            ->json(['message' => 'Combo quantity increased by 1'], 200);
    }

    public function decrease_combo_qty(Request $request)
    {

        $email = $request->email;
        $combo_id = $request->combo_id;

        $user = DB::table('users')->where('email', $email)->first();

        if(empty($user)){
            return response()
                ->json(['message' => 'Invalid user'], 400);
        }

        DB::table('cart_combo')->where('user_id', '=', $user->id)
            ->where('combo_id', '=', $combo_id)->decrement('qty', 1);


        $cart = DB::table('cart_combo')->where('user_id', '=', $user->id)
            ->where('combo_id', '=', $combo_id)->first();


        if(empty($cart)){
            return response()
                ->json(['message' => 'Invalid Combo ID'], 400);
        }

        if($cart->qty == 0){

            DB::table('cart_combo')->where('user_id', '=', $user->id)
            ->where('combo_id', '=', $combo_id)->delete();

            return response()
            ->json(['message' => 'Quantity zero. Combo removed.'], 200);
        }

        return response()
            ->json(['message' => 'Combo quantity decreased by 1'], 200);
    }

    /*Api for Combo*/

    /*Api for points setting*/
    public function get_points_setting(){
        $p_s = DB::table('settings')->whereIn('name' , 
        ['points_welcome_bonus', 
        'points_profile_finish', 
        'points_birthday', 
        'points_ref_commission_rate', 
        'points_review_post',
        'points_system_enabled'])
        ->get()->pluck('value', 'name');
        
        /*$result = [];
        foreach($p_s as $ps){
            $result['']
        }*/
        return response()->json($p_s);
    }
    /*Api for point setting*/
    
    /*Api for memberships*/
    public function get_memberships(){
        $mem = DB::table('memberships as m')
            ->join('membership_descriptions as md', function($join){
                $join->on('m.membership_id', 'md.membership_id');
            })
            ->LeftJoin('image_categories', function ($join) {
                $join->on('image_categories.image_id', '=', 'm.membership_image')->where(function ($query) {
                    $query->where('image_categories.image_type', '=', 'THUMBNAIL')
                        ->where('image_categories.image_type', '!=', 'THUMBNAIL')
                        ->orWhere('image_categories.image_type', '=', 'ACTUAL');
                });
            })
            ->orderBy('m.membership_points_from')
            ->select(
                'm.membership_id',
                'm.membership_name',
                'image_categories.path as membership_image_path',
                'm.membership_points_from',
                'm.membership_points_to',
                'm.membership_discount_percentage',
                'm.membership_cap_value',
                'md.membership_description',
                'm.membership_has_validity',
                'm.membership_valid_till'
            )
            ->where('md.language_id', 1)
            ->get();
            
            $mem = $mem->map(function($m) {
              $m->membership_image_path = url('/').'/'.$m->membership_image_path;
              return $m;
            });
            
        return response()->json(['memberships' => $mem], 200);
    }
    
    public function get_user_membership_info(Request $request){
        
        $user = DB::table('users as u')->where('email', $request->email)->first();
        
        $sPoints = $user->spoints;
        $pPoints = $user->ppoints;
        
        $data['spoints'] = $sPoints;
        $data['ppoints'] = $pPoints;
        
        $mem = DB::table('memberships as m')
            ->join('membership_descriptions as md', function($join){
                $join->on('m.membership_id', 'md.membership_id');
            })
            ->LeftJoin('image_categories', function ($join) {
                $join->on('image_categories.image_id', '=', 'm.membership_image')->where(function ($query) {
                    $query->where('image_categories.image_type', '=', 'THUMBNAIL')
                        ->where('image_categories.image_type', '!=', 'THUMBNAIL')
                        ->orWhere('image_categories.image_type', '=', 'ACTUAL');
                });
            })
            ->orderBy('m.membership_points_from')
            ->select(
                'm.membership_id',
                'm.membership_name',
                'image_categories.path as membership_image_path',
                'm.membership_points_from',
                'm.membership_points_to',
                'm.membership_discount_percentage',
                'm.membership_cap_value',
                'md.membership_description'
            )
            ->where('md.language_id', 1)
            ->get();
            
        foreach($mem as $m){
            if($sPoints >= $m->membership_points_from && $sPoints <= $m->membership_points_to){
                $data['current_membership'] = $m;
            }
            else{
                break;
            }
        }
        
        return response()->json(['membership_info' => $data]);
    }
    /*Api for memberships*/









    public function testing(Request $request)
    {

        $products = DB::table('products')
            ->LeftJoin('bundles_products', 'bundles_products.product_id', '=', 'products.products_id')
            ->LeftJoin('products_description', 'products_description.products_id', '=', 'products.products_id')
            ->LeftJoin('products as sub_products', 'sub_products.parent_products_id', '=', 'products.products_id')
            ->LeftJoin('images', 'images.id', '=', 'products.products_image')
            ->LeftJoin('flash_sale', 'flash_sale.products_id', '=', 'products.products_id')
            ->LeftJoin('specials', 'specials.products_id', '=', 'products.products_id')
            ->LeftJoin('image_categories', function ($join) {
                $join->on('image_categories.image_id', '=', 'products.products_image')->where(function ($query) {
                    $query->where('image_categories.image_type', '=', 'THUMBNAIL')
                        ->where('image_categories.image_type', '!=', 'THUMBNAIL')
                        ->orWhere('image_categories.image_type', '=', 'ACTUAL');
                });
            })

            ->where('products_description.language_id', '=', 1)
            ->where('products.products_status', '=', 1)

            ->where('products.parent_products_id', '=', null)
            // ->where('flash_sale.flash_status', '!=', 0)
            ->orderBy('products.products_id', 'ASC')


            ->select(
                'products.products_id as products_products_id',

                'bundles_products.product_id as product_in_bundles',
                'products.*',
                'products_description.*',
                'products_description.products_id as products_description_products_id',
                'images.name as image_of_product',
                'image_categories.path as path',
                'flash_sale.*',
                'flash_sale.products_id as flash_sale_products_id',
                DB::raw('0 as flash_sale_timer_duration'),
                DB::raw('0 as flash_sale_timer_status'),
                'specials.*',
                DB::raw('0 as special_discount_price_status'),
                'specials.products_id as specials_products_id',
                'specials.status as specials_status',
                'sub_products.products_id  as product_variation_id',
                'sub_products.products_weight  as product_variation_weight',
                'sub_products.products_weight_unit  as product_variation_unit'
            )
            // ->orderBy('products_products_id', 'DESC')
            ->groupBy('products_products_id')

            ->get();


        $nowTime = date("Y-m-d H:i:s", time());

        for ($i = 0; $i < count($products); $i++) {
            $expiry  = date("Y-m-d H:i:s", $products[$i]->expires_date);
            $flash_expires_date  = date("Y-m-d H:i:s",  $products[$i]->flash_expires_date);

            $flash_start_date  = date("Y-m-d H:i:s",  $products[$i]->flash_start_date);



            if ($products[$i]->specials_id != null && $expiry > $nowTime && $products[$i]->specials_status == 1) {

                $products[$i]->special_discount_price_status = 1;
            }

            if ($products[$i]->flash_sale_id != null && $flash_expires_date > $nowTime &&  $products[$i]->flash_status == 1) {


                $dtDiff = $products[$i]->flash_expires_date - time();
                $totalDays = intval($dtDiff / (24 * 60 * 60));
                $totalHours = $totalDays * 24;

                $products[$i]->flash_sale_timer_status = 1;
                $products[$i]->flash_sale_timer_duration = $totalHours;
            }
        }

        return response()->json(['test' => $products]);
    }

    public function testing_products_variations(Request $request)
    {

        $products = DB::table('products')
            ->LeftJoin('bundles_products', 'bundles_products.product_id', '=', 'products.products_id')
            ->LeftJoin('products_description', 'products_description.products_id', '=', 'products.products_id')
            ->LeftJoin('images', 'images.id', '=', 'products.products_image')
            ->LeftJoin('flash_sale', 'flash_sale.products_id', '=', 'products.products_id')
            ->LeftJoin('specials', 'specials.products_id', '=', 'products.products_id')
            ->LeftJoin('image_categories', function ($join) {
                $join->on('image_categories.image_id', '=', 'products.products_image')->where(function ($query) {
                    $query->where('image_categories.image_type', '=', 'THUMBNAIL')
                        ->where('image_categories.image_type', '=', 'THUMBNAIL')
                        ->orWhere('image_categories.image_type', '=', 'THUMBNAIL');
                });
            })
            ->where('products.parent_products_id', '=', $request->product_parent_id)
            ->where('products_description.language_id', '=', 1)
            ->where('products.products_status', '=', 1)
            ->where('products.products_status', '=', 1)



            ->select(
                'products.products_id as products_products_id',
                'bundles_products.product_id as product_in_bundles',
                'products.*',
                'products_description.*',
                'products_description.products_id as products_description_products_id',
                'images.name as image_of_product',
                'image_categories.path as path',
                'flash_sale.*',
                'flash_sale.products_id as flash_sale_products_id',
                DB::raw('0 as flash_sale_timer_duration'),
                DB::raw('0 as flash_sale_timer_status'),
                'specials.*',
                DB::raw('0 as special_discount_price_status'),
                'specials.products_id as specials_products_id',
                'specials.status as specials_status'
            )
            ->get();


        $nowTime = date("Y-m-d H:i:s", time());

        for ($i = 0; $i < count($products); $i++) {
            $expiry  = date("Y-m-d H:i:s", $products[$i]->expires_date);
            $flash_expires_date  = date("Y-m-d H:i:s",  $products[$i]->flash_expires_date);

            $flash_start_date  = date("Y-m-d H:i:s",  $products[$i]->flash_start_date);



            if ($products[$i]->specials_id != null && $expiry > $nowTime && $products[$i]->specials_status == 1) {

                $products[$i]->special_discount_price_status = 1;
            }

            if ($products[$i]->flash_sale_id != null && $flash_expires_date > $nowTime &&  $products[$i]->flash_status == 1) {


                $dtDiff = $products[$i]->flash_expires_date - time();
                $totalDays = intval($dtDiff / (24 * 60 * 60));
                $totalHours = $totalDays * 24;

                $products[$i]->flash_sale_timer_status = 1;
                $products[$i]->flash_sale_timer_duration = $totalHours;
            }
        }

        return response()->json(['testing_products_variations' => $products]);
    }














    public function recomended(Request $request)
    {

        $categories = DB::table('categories')
            ->where('categories.parent_id', '=', $request->parent_id)
            ->where('categories.categories_status', '=', 1)
            ->select('categories.*')
            ->get();
        if ($categories->count() > 0) {
            $cat_ids = [];
            foreach ($categories as $categorie) {
                $cat_ids[] = $categorie->categories_id;
            }



            $products = DB::table('products_to_categories')->whereIn('categories_id', $cat_ids)
                ->join('products', 'products.products_id', '=', 'products_to_categories.products_id')
                ->join('products_description', 'products_description.products_id', '=', 'products_to_categories.products_id')

                /* ->LeftJoin('image_categories', function ($join) {
                    $join->on('image_categories.image_id', '=', 'products.products_image')->where(function ($query) {
                        $query->where('image_categories.image_type', '=', 'THUMBNAIL')
                            ->where('image_categories.image_type', '!=', 'THUMBNAIL')
                            ->orWhere('image_categories.image_type', '=', 'ACTUAL');
                    });
                }) */

                ->LeftJoin('product_images_cloud', function ($join) {
                    $join->on('product_images_cloud.product_id', '=', 'products.products_id')->where(function ($query) {
                        $query->where('product_images_cloud.image_no', '=', 0);
                    });
                })

                ->where('products_description.language_id', '=', 1)
                ->where('products.products_status', '=', 1)
                ->where('products.is_feature', '=', 1)

                ->select('products.*', 'products_description.*', /* 'image_categories.path as path', */'product_images_cloud.url as path')
                ->get();

            return response()
                ->json(['message' => 'Recomended Products', 'recomended' => $products]);
        } else {
            return response()
                ->json(['message' => 'This category does not any sub category']);
        }
    }


    public function recentproducts_old(Request $request)
    {

        // $product_ids = DB::table('products')->orderBy('products_id', 'DESC')->get();

        // return response()->json($product_ids->pluck('products_id'));

        $products = DB::table('products')
            ->join('products_description', 'products_description.products_id', '=', 'products.products_id')
            ->join('images', 'images.id', '=', 'products.products_image')
            ->LeftJoin('image_categories', function ($join) {
                $join->on('image_categories.image_id', '=', 'products.products_image')->where(function ($query) {
                    $query->where('image_categories.image_type', '=', 'THUMBNAIL')
                        ->where('image_categories.image_type', '!=', 'THUMBNAIL')
                        ->orWhere('image_categories.image_type', '=', 'ACTUAL');
                });
            })
            ->where('products_description.language_id', '=', 1)
            ->where('products.products_status', '=', 1)
            ->orderBy('products.products_id', 'DESC')

            ->select('products_description.*', 'products.*', 'images.name as image_of_product', 'image_categories.path as path')
            ->get();

        return response()
            ->json(['message' => 'Recently added', 'recently added' => $products]);
    }


    public function recentproducts(Request $request)
    {

        $products = DB::table('products')

            ->LeftJoin('products_description', 'products_description.products_id', '=', 'products.products_id')

            ->LeftJoin('product_images_cloud', function ($join) {
                $join->on('product_images_cloud.product_id', '=', 'products.products_id')->where(function ($query) {
                    $query->where('product_images_cloud.image_no', '=', 0);
                });
            })

            ->where('products_description.language_id', '=', 1)
            ->where('products.products_status', '=', 1)
            ->where('products.products_in_stock', '>', 0)
            //->where('products.parent_products_id', '=', null)
            ->orderBy('products.products_id', 'DESC')


            ->select(
                'products.products_id as products_products_id',
                'products.*',
                'products_description.*',
                'products_description.products_id as products_description_products_id',
                'product_images_cloud.url as path'
            )
            ->addSelect(DB::raw("null as variant"))

            ->take(100)
            //->where('product_images_cloud.url', '!=', null)
            //->groupBy('products_products_id')
            //->where('products.products_id', '<', 2181)
            ->get();

            $pro = $products->groupBy('parent_products_id');

            foreach($pro as $v_key => $p_list){

                if($v_key != ""){

                    $var_pro = [];

                    foreach($p_list as $key => $p){
                        $var_pro[$key]['products_id'] = $p->products_id;
                        $var_pro[$key]['products_in_stock'] = $p->products_in_stock;
                        $var_pro[$key]['path'] = $p->path;
                        $var_pro[$key]['products_points'] = $p->products_points;
                        $var_pro[$key]['products_price'] = $p->products_price;
                        $var_pro[$key]['products_weight'] = $p->products_weight;
                        $var_pro[$key]['products_weight_unit'] = $p->products_weight_unit;
                    }

                    if(!empty($pro[""]->where('products_id', $v_key)->first())){
                        $pro[""]->where('products_id', $v_key)->first()->variant = $var_pro;
                    }
                    else{
                        //return response()->json($v_key);
                        if(count($var_pro) == 1){
                            $pro[""]->push($p_list[0]);
                        }
                        elseif(count($var_pro) > 1){
                            $pro[""]->push($p_list[0]);
                            unset($var_pro[0]);
                            $pro[""]->where('products_id', $p_list[0]->products_id)->first()->variant = $var_pro;
                        }
                    }
                }

            }


        //return response()->json($pro[""]->where('products_id', 2175));

        $result = $pro[""]->sortByDesc('products_id');

        return response()->json(['message' => 'Recently added', 'recently added' =>  $result->values()->all()]);
    }














    public function flashsaleproducts_old(Request $request)
    {

        $products = DB::table('flash_sale')

            ->join('products', 'products.products_id', '=', 'flash_sale.products_id')
            ->join('products_description', 'products_description.products_id', '=', 'products.products_id')
            ->join('images', 'images.id', '=', 'products.products_image')
            ->LeftJoin('image_categories', function ($join) {
                $join->on('image_categories.image_id', '=', 'products.products_image')->where(function ($query) {
                    $query->where('image_categories.image_type', '=', 'THUMBNAIL')
                        ->where('image_categories.image_type', '!=', 'THUMBNAIL')
                        ->orWhere('image_categories.image_type', '=', 'ACTUAL');
                });
            })
            ->where('products_description.language_id', '=', 1)
            ->where('products.products_status', '=', 1)
            ->where('flash_sale.flash_status', '=', 1)

            ->select('products_description.*', 'products.*', 'images.name as image_of_product', 'flash_sale.*',  'image_categories.path as path')
            ->get();

        return response()
            ->json(['message' => 'All flash sale products', 'flash_sale_products' => $products]);
    }






    public function flashsaleproducts(Request $request)
    {


        $products = DB::table('flash_sale')
            ->LeftJoin('products', 'products.products_id', '=', 'flash_sale.products_id')
            ->LeftJoin('bundles_products', 'bundles_products.product_id', '=', 'products.products_id')
            ->LeftJoin('products_description', 'products_description.products_id', '=', 'products.products_id')
            ->LeftJoin('products as sub_products', 'sub_products.parent_products_id', '=', 'products.products_id')
            ->LeftJoin('images', 'images.id', '=', 'products.products_image')


            ->LeftJoin('products_to_hotcats', 'products_to_hotcats.products_id', '=', 'products.products_id')
            ->LeftJoin('hotcats', 'products_to_hotcats.hotcats_id', '=', 'hotcats.hotcats_id')

            ->LeftJoin('products_msd', 'products_msd.products_id', '=', 'products.products_id')
            ->LeftJoin('memberships', 'products_msd.level_id', '=', 'memberships.membership_id')

            ->LeftJoin('specials', 'specials.products_id', '=', 'products.products_id')

            /* ->LeftJoin('image_categories', function ($join) {
                $join->on('image_categories.image_id', '=', 'products.products_image')->where(function ($query) {
                    $query->where('image_categories.image_type', '=', 'THUMBNAIL')
                        ->where('image_categories.image_type', '=', 'THUMBNAIL')
                        ->orWhere('image_categories.image_type', '=', 'THUMBNAIL');
                });
            }) */

            ->LeftJoin('product_images_cloud', function ($join) {
                $join->on('product_images_cloud.product_id', '=', 'products.products_id')->where(function ($query) {
                    $query->where('product_images_cloud.image_no', '=', 0);
                });
            })

            ->where('products_description.language_id', '=', 1)
            ->where('products.products_status', '=', 1)
            ->where('flash_sale.flash_status', '=', 1)
            ->where('products.parent_products_id', '=', null)



            ->select(
                'products.products_id as products_products_id',
                'bundles_products.product_id as product_in_bundles',
                'products.*',
                'products_description.*',
                'products_description.products_id as products_description_products_id',
                'images.name as image_of_product',
                /* 'image_categories.path as path', */
                'product_images_cloud.url as path',
                'flash_sale.*',
                'flash_sale.products_id as flash_sale_products_id',
                DB::raw('0 as flash_sale_timer_duration'),
                DB::raw('0 as flash_sale_timer_status'),
                'specials.*',
                DB::raw('0 as special_discount_price_status'),
                'specials.products_id as specials_products_id',
                'specials.status as specials_status',
                'sub_products.products_id  as product_variation_id',
                'sub_products.products_weight  as product_variation_weight',
                'sub_products.products_weight_unit  as product_variation_unit',



                'hotcats.hotcats_id as hotcat_id',
                'hotcats.hotcat_name as hotcat_name',
                'hotcats.hotcats_color_code as hotcats_color_code',
                'memberships.membership_id as msd_id',
                'memberships.membership_name as msd_name',
                'memberships.membership_discount_percentage as msd_discount',
                'memberships.membership_points_from as msd_points_from',
                'memberships.membership_points_to as msd_points_to',
                'memberships.membership_cap_value as msd_cap_value',
                'memberships.membership_has_validity as msd_has_validity',
                'memberships.membership_valid_till as msd_valid_till',
                'memberships.membership_status as msd_status'
            )
            ->orderBy('products_products_id', 'DESC')
            // ->take(20)  
            ->groupBy('products_products_id')
            ->get();


        $nowTime = date("Y-m-d H:i:s", time());

        for ($i = 0; $i < count($products); $i++) {
            $expiry  = date("Y-m-d H:i:s", $products[$i]->expires_date);
            $flash_expires_date  = date("Y-m-d H:i:s",  $products[$i]->flash_expires_date);

            $flash_start_date  = date("Y-m-d H:i:s",  $products[$i]->flash_start_date);



            if ($products[$i]->specials_id != null && $expiry > $nowTime && $products[$i]->specials_status == 1) {

                $products[$i]->special_discount_price_status = 1;
            }

            if ($products[$i]->flash_sale_id != null && $flash_expires_date > $nowTime &&  $products[$i]->flash_status == 1) {


                $dtDiff = $products[$i]->flash_expires_date - time();
                $totalDays = intval($dtDiff / (24 * 60 * 60));
                $totalHours = $totalDays * 24;

                $products[$i]->flash_sale_timer_status = 1;
                $products[$i]->flash_sale_timer_duration = $totalHours;
            }
        }

        return response()->json(['message' => 'All flash sale products', 'flash_sale_products' => $products]);
    }








    public function exclusiveproducts_old(Request $request)
    {

        $products = DB::table('products')
            ->join('products_description', 'products_description.products_id', '=', 'products.products_id')
            ->join('images', 'images.id', '=', 'products.products_image')
            ->LeftJoin('image_categories', function ($join) {
                $join->on('image_categories.image_id', '=', 'products.products_image')->where(function ($query) {
                    $query->where('image_categories.image_type', '=', 'THUMBNAIL')
                        ->where('image_categories.image_type', '=', 'THUMBNAIL')
                        ->orWhere('image_categories.image_type', '=', 'THUMBNAIL');
                });
            })
            ->where('products.products_price_market', '=', 0)
            ->orwhere('products.products_price_market', '=', null)
            ->where('products.products_status', '=', 1)
            ->where('products_description.language_id', '=', 1)
            ->select('products_description.*', 'products.*', 'images.name as image_of_product', 'image_categories.path as path')
            ->get();

        return response()
            ->json(['exclusive_products' => $products]);
    }


    public function exclusiveproducts(Request $request)
    {

        $products = DB::table('products')
            ->LeftJoin('products_description', 'products_description.products_id', '=', 'products.products_id')
            ->LeftJoin('bundles_products', 'bundles_products.product_id', '=', 'products.products_id')
            ->LeftJoin('products as sub_products', 'sub_products.parent_products_id', '=', 'products.products_id')
            ->LeftJoin('images', 'images.id', '=', 'products.products_image')
            ->LeftJoin('flash_sale', 'flash_sale.products_id', '=', 'products.products_id')
            ->LeftJoin('specials', 'specials.products_id', '=', 'products.products_id')

            ->LeftJoin('products_to_hotcats', 'products_to_hotcats.products_id', '=', 'products.products_id')
            ->LeftJoin('hotcats', 'products_to_hotcats.hotcats_id', '=', 'hotcats.hotcats_id')

            ->LeftJoin('products_msd', 'products_msd.products_id', '=', 'products.products_id')
            ->LeftJoin('memberships', 'products_msd.level_id', '=', 'memberships.membership_id')

            /* ->LeftJoin('image_categories', function ($join) {
                $join->on('image_categories.image_id', '=', 'products.products_image')->where(function ($query) {
                    $query->where('image_categories.image_type', '=', 'THUMBNAIL')
                        ->where('image_categories.image_type', '=', 'THUMBNAIL')
                        ->orWhere('image_categories.image_type', '=', 'THUMBNAIL');
                });
            }) */

            ->LeftJoin('product_images_cloud', function ($join) {
                $join->on('product_images_cloud.product_id', '=', 'products.products_id')->where(function ($query) {
                    $query->where('product_images_cloud.image_no', '=', 0);
                });
            })

            ->where('products.products_price_market', '=', 0)
            ->where('products_description.language_id', '=', 1)
            ->where('products.products_status', '=', 1)
            ->where('products.parent_products_id', '=', null)



            ->select(
                'products.products_id as products_products_id',
                'bundles_products.product_id as product_in_bundles',
                'products.*',
                'products_description.*',
                'products_description.products_id as products_description_products_id',
                'images.name as image_of_product',
                /* 'image_categories.path as path', */
                'product_images_cloud.url as path',
                'flash_sale.*',
                'flash_sale.products_id as flash_sale_products_id',
                DB::raw('0 as flash_sale_timer_duration'),
                DB::raw('0 as flash_sale_timer_status'),
                'specials.*',
                DB::raw('0 as special_discount_price_status'),
                'specials.products_id as specials_products_id',
                'specials.status as specials_status',
                'sub_products.products_id  as product_variation_id',
                'sub_products.products_weight  as product_variation_weight',
                'sub_products.products_weight_unit  as product_variation_unit',


                'hotcats.hotcats_id as hotcat_id',
                'hotcats.hotcat_name as hotcat_name',
                'hotcats.hotcats_color_code as hotcats_color_code',
                'memberships.membership_id as msd_id',
                'memberships.membership_name as msd_name',
                'memberships.membership_discount_percentage as msd_discount',
                'memberships.membership_points_from as msd_points_from',
                'memberships.membership_points_to as msd_points_to',
                'memberships.membership_cap_value as msd_cap_value',
                'memberships.membership_has_validity as msd_has_validity',
                'memberships.membership_valid_till as msd_valid_till',
                'memberships.membership_status as msd_status'
            )
            // ->orderBy('products_products_id', 'DESC')
            // ->take(20)  
            ->groupBy('products_products_id')
            ->get();


        $nowTime = date("Y-m-d H:i:s", time());

        for ($i = 0; $i < count($products); $i++) {
            $expiry  = date("Y-m-d H:i:s", $products[$i]->expires_date);
            $flash_expires_date  = date("Y-m-d H:i:s",  $products[$i]->flash_expires_date);

            $flash_start_date  = date("Y-m-d H:i:s",  $products[$i]->flash_start_date);



            if ($products[$i]->specials_id != null && $expiry > $nowTime && $products[$i]->specials_status == 1) {

                $products[$i]->special_discount_price_status = 1;
            }

            if ($products[$i]->flash_sale_id != null && $flash_expires_date > $nowTime &&  $products[$i]->flash_status == 1) {


                $dtDiff = $products[$i]->flash_expires_date - time();
                $totalDays = intval($dtDiff / (24 * 60 * 60));
                $totalHours = $totalDays * 24;

                $products[$i]->flash_sale_timer_status = 1;
                $products[$i]->flash_sale_timer_duration = $totalHours;
            }
        }

        return response()->json(['exclusive_products' => $products]);
    }














    public function products_points_redeem_old(Request $request)
    {

        $products = DB::table('products')
            ->join('products_description', 'products_description.products_id', '=', 'products.products_id')
            ->join('images', 'images.id', '=', 'products.products_image')
            ->LeftJoin('image_categories', function ($join) {
                $join->on('image_categories.image_id', '=', 'products.products_image')->where(function ($query) {
                    $query->where('image_categories.image_type', '=', 'THUMBNAIL')
                        ->where('image_categories.image_type', '=', 'THUMBNAIL')
                        ->orWhere('image_categories.image_type', '=', 'THUMBNAIL');
                });
            })
            ->where('products.products_points_redeem', '!=', null)
            ->where('products_description.language_id', '=', 1)
            ->where('products.products_status', '=', 1)
            ->select('products_description.*', 'products.*', 'images.name as image_of_product', 'image_categories.path as path')
            ->get();

        return response()
            ->json(['redeem_products' => $products]);
    }


    public function products_points_redeem(Request $request)
    {

        $products = DB::table('products')
            ->LeftJoin('bundles_products', 'bundles_products.product_id', '=', 'products.products_id')
            ->LeftJoin('products_description', 'products_description.products_id', '=', 'products.products_id')
            ->LeftJoin('products as sub_products', 'sub_products.parent_products_id', '=', 'products.products_id')
            ->LeftJoin('images', 'images.id', '=', 'products.products_image')
            ->LeftJoin('flash_sale', 'flash_sale.products_id', '=', 'products.products_id')
            ->LeftJoin('specials', 'specials.products_id', '=', 'products.products_id')

            /* ->LeftJoin('image_categories', function ($join) {
                $join->on('image_categories.image_id', '=', 'products.products_image')->where(function ($query) {
                    $query->where('image_categories.image_type', '=', 'THUMBNAIL')
                        ->where('image_categories.image_type', '=', 'THUMBNAIL')
                        ->orWhere('image_categories.image_type', '=', 'THUMBNAIL');
                });
            }) */

            ->LeftJoin('product_images_cloud', function ($join) {
                $join->on('product_images_cloud.product_id', '=', 'products.products_id')->where(function ($query) {
                    $query->where('product_images_cloud.image_no', '=', 0);
                });
            })

            ->where('products.products_points_redeem', '!=', null)
            ->where('products_description.language_id', '=', 1)
            ->where('products.products_status', '=', 1)
            ->where('products.parent_products_id', '=', null)



            ->select(
                'products.products_id as products_products_id',
                'bundles_products.product_id as product_in_bundles',
                'products.*',
                'products_description.*',
                'products_description.products_id as products_description_products_id',
                'images.name as image_of_product',
                /* 'image_categories.path as path', */
                'product_images_cloud.url as path',
                'flash_sale.*',
                'flash_sale.products_id as flash_sale_products_id',
                DB::raw('0 as flash_sale_timer_duration'),
                DB::raw('0 as flash_sale_timer_status'),
                'specials.*',
                DB::raw('0 as special_discount_price_status'),
                'specials.products_id as specials_products_id',
                'specials.status as specials_status',
                'sub_products.products_id  as product_variation_id',
                'sub_products.products_weight  as product_variation_weight',
                'sub_products.products_weight_unit  as product_variation_unit'
            )
            // ->orderBy('products_products_id', 'DESC')
            // ->take(20)  
            ->groupBy('products_products_id')
            ->get();


        $nowTime = date("Y-m-d H:i:s", time());

        for ($i = 0; $i < count($products); $i++) {
            $expiry  = date("Y-m-d H:i:s", $products[$i]->expires_date);
            $flash_expires_date  = date("Y-m-d H:i:s",  $products[$i]->flash_expires_date);

            $flash_start_date  = date("Y-m-d H:i:s",  $products[$i]->flash_start_date);



            if ($products[$i]->specials_id != null && $expiry > $nowTime && $products[$i]->specials_status == 1) {

                $products[$i]->special_discount_price_status = 1;
            }

            if ($products[$i]->flash_sale_id != null && $flash_expires_date > $nowTime &&  $products[$i]->flash_status == 1) {


                $dtDiff = $products[$i]->flash_expires_date - time();
                $totalDays = intval($dtDiff / (24 * 60 * 60));
                $totalHours = $totalDays * 24;

                $products[$i]->flash_sale_timer_status = 1;
                $products[$i]->flash_sale_timer_duration = $totalHours;
            }
        }

        return response()->json(['redeem_products' => $products]);
    }











    public function featuredproducts_old(Request $request)
    {

        $products = DB::table('products')
            ->join('products_description', 'products_description.products_id', '=', 'products.products_id')
            ->join('images', 'images.id', '=', 'products.products_image')
            ->LeftJoin('image_categories', function ($join) {
                $join->on('image_categories.image_id', '=', 'products.products_image')->where(function ($query) {
                    $query->where('image_categories.image_type', '=', 'THUMBNAIL')
                        ->where('image_categories.image_type', '=', 'THUMBNAIL')
                        ->orWhere('image_categories.image_type', '=', 'THUMBNAIL');
                });
            })
            ->where('products.is_feature', '!=', 0)
            ->where('products_description.language_id', '=', 1)
            ->where('products.products_status', '=', 1)
            ->select('products_description.*', 'products.*', 'images.name as image_of_product', 'image_categories.path as path')
            ->get();

        return response()
            ->json(['featured_products' => $products]);
    }


    public function featuredproducts(Request $request)
    {

        $products = DB::table('products')
            ->LeftJoin('bundles_products', 'bundles_products.product_id', '=', 'products.products_id')
            ->LeftJoin('products_description', 'products_description.products_id', '=', 'products.products_id')
            ->LeftJoin('products as sub_products', 'sub_products.parent_products_id', '=', 'products.products_id')
            ->LeftJoin('images', 'images.id', '=', 'products.products_image')
            ->LeftJoin('flash_sale', 'flash_sale.products_id', '=', 'products.products_id')
            ->LeftJoin('specials', 'specials.products_id', '=', 'products.products_id')

            ->LeftJoin('products_to_hotcats', 'products_to_hotcats.products_id', '=', 'products.products_id')
            ->LeftJoin('hotcats', 'products_to_hotcats.hotcats_id', '=', 'hotcats.hotcats_id')

            ->LeftJoin('products_msd', 'products_msd.products_id', '=', 'products.products_id')
            ->LeftJoin('memberships', 'products_msd.level_id', '=', 'memberships.membership_id')


            /* ->LeftJoin('image_categories', function ($join) {
                $join->on('image_categories.image_id', '=', 'products.products_image')->where(function ($query) {
                    $query->where('image_categories.image_type', '=', 'THUMBNAIL')
                        ->where('image_categories.image_type', '!=', 'THUMBNAIL')
                        ->orWhere('image_categories.image_type', '=', 'ACTUAL');
                });
            }) */

            ->LeftJoin('product_images_cloud', function ($join) {
                $join->on('product_images_cloud.product_id', '=', 'products.products_id')->where(function ($query) {
                    $query->where('product_images_cloud.image_no', '=', 0);
                });
            })

            ->where('products_description.language_id', '=', 1)
            ->where('products.is_feature', '!=', 0)
            ->where('products.products_status', '=', 1)
            ->where('products.parent_products_id', '=', null)



            ->select(
                'products.products_id as products_products_id',
                'bundles_products.product_id as product_in_bundles',
                'products.*',
                'products_description.*',
                'products_description.products_id as products_description_products_id',
                'images.name as image_of_product',
                /* 'image_categories.path as path', */
                'product_images_cloud.url as path',
                'flash_sale.*',
                'flash_sale.products_id as flash_sale_products_id',
                DB::raw('0 as flash_sale_timer_duration'),
                DB::raw('0 as flash_sale_timer_status'),
                'specials.*',
                DB::raw('0 as special_discount_price_status'),
                'specials.products_id as specials_products_id',
                'specials.status as specials_status',
                'sub_products.products_id  as product_variation_id',
                'sub_products.products_weight  as product_variation_weight',
                'sub_products.products_weight_unit  as product_variation_unit',


                'hotcats.hotcats_id as hotcat_id',
                'hotcats.hotcat_name as hotcat_name',
                'hotcats.hotcats_color_code as hotcats_color_code',
                'memberships.membership_id as msd_id',
                'memberships.membership_name as msd_name',
                'memberships.membership_discount_percentage as msd_discount',
                'memberships.membership_points_from as msd_points_from',
                'memberships.membership_points_to as msd_points_to',
                'memberships.membership_cap_value as msd_cap_value',
                'memberships.membership_has_validity as msd_has_validity',
                'memberships.membership_valid_till as msd_valid_till',
                'memberships.membership_status as msd_status'
            )
            // ->orderBy('products_products_id', 'DESC')
            // ->take(20)  
            ->groupBy('products_products_id')
            ->get();


        $nowTime = date("Y-m-d H:i:s", time());

        for ($i = 0; $i < count($products); $i++) {
            $expiry  = date("Y-m-d H:i:s", $products[$i]->expires_date);
            $flash_expires_date  = date("Y-m-d H:i:s",  $products[$i]->flash_expires_date);

            $flash_start_date  = date("Y-m-d H:i:s",  $products[$i]->flash_start_date);



            if ($products[$i]->specials_id != null && $expiry > $nowTime && $products[$i]->specials_status == 1) {

                $products[$i]->special_discount_price_status = 1;
            }

            if ($products[$i]->flash_sale_id != null && $flash_expires_date > $nowTime &&  $products[$i]->flash_status == 1) {


                $dtDiff = $products[$i]->flash_expires_date - time();
                $totalDays = intval($dtDiff / (24 * 60 * 60));
                $totalHours = $totalDays * 24;

                $products[$i]->flash_sale_timer_status = 1;
                $products[$i]->flash_sale_timer_duration = $totalHours;
            }
        }

        return response()->json(['message' => 'featured_products', 'featured_products' =>  $products]);
    }




















    public function specialproducts_old(Request $request)
    {

        $products = DB::table('specials')
            ->join('products', 'products.products_id', '=', 'specials.products_id')
            ->join('products_description', 'products_description.products_id', '=', 'products.products_id')
            ->join('images', 'images.id', '=', 'products.products_image')
            ->LeftJoin('image_categories', function ($join) {
                $join->on('image_categories.image_id', '=', 'products.products_image')->where(function ($query) {
                    $query->where('image_categories.image_type', '=', 'THUMBNAIL')
                        ->where('image_categories.image_type', '!=', 'THUMBNAIL')
                        ->orWhere('image_categories.image_type', '=', 'ACTUAL');
                });
            })
            ->where('products_description.language_id', '=', 1)
            ->where('specials.status', '=', 1)
            ->where('products.products_status', '=', 1)
            ->select('products_description.*', 'products.*', 'images.name as image_of_product', 'specials.*', 'image_categories.path as path')
            ->get();

        return response()
            ->json(['message' => 'All Special products', 'special products' => $products]);
    }



    public function specialproducts(Request $request)
    {


        $products = DB::table('specials')
            ->join('products', 'products.products_id', '=', 'specials.products_id')
            ->LeftJoin('bundles_products', 'bundles_products.product_id', '=', 'products.products_id')
            ->LeftJoin('products_description', 'products_description.products_id', '=', 'products.products_id')
            ->LeftJoin('products as sub_products', 'sub_products.parent_products_id', '=', 'products.products_id')
            ->LeftJoin('images', 'images.id', '=', 'products.products_image')
            ->LeftJoin('flash_sale', 'flash_sale.products_id', '=', 'products.products_id')

            ->LeftJoin('products_to_hotcats', 'products_to_hotcats.products_id', '=', 'products.products_id')
            ->LeftJoin('hotcats', 'products_to_hotcats.hotcats_id', '=', 'hotcats.hotcats_id')

            ->LeftJoin('products_msd', 'products_msd.products_id', '=', 'products.products_id')
            ->LeftJoin('memberships', 'products_msd.level_id', '=', 'memberships.membership_id')


            //->LeftJoin('specials', 'specials.products_id', '=', 'products.products_id')
            /* ->LeftJoin('image_categories', function ($join) {
                $join->on('image_categories.image_id', '=', 'products.products_image')->where(function ($query) {
                    $query->where('image_categories.image_type', '=', 'THUMBNAIL')
                        ->where('image_categories.image_type', '!=', 'THUMBNAIL')
                        ->orWhere('image_categories.image_type', '=', 'ACTUAL');
                });
            }) */

            ->LeftJoin('product_images_cloud', function ($join) {
                $join->on('product_images_cloud.product_id', '=', 'products.products_id')->where(function ($query) {
                    $query->where('product_images_cloud.image_no', '=', 0);
                });
            })

            ->where('products_description.language_id', '=', 1)
            ->where('products.products_status', '=', 1)
            ->where('products.parent_products_id', '=', null)
            ->where('specials.status', '=', 1)



            ->select(
                'products.products_id as products_products_id',
                'bundles_products.product_id as product_in_bundles',
                'products.*',
                'products_description.*',
                'products_description.products_id as products_description_products_id',
                'images.name as image_of_product',
                /* 'image_categories.path as path', */
                'product_images_cloud.url as path',
                'flash_sale.*',
                'flash_sale.products_id as flash_sale_products_id',
                DB::raw('0 as flash_sale_timer_duration'),
                DB::raw('0 as flash_sale_timer_status'),
                'specials.*',
                DB::raw('0 as special_discount_price_status'),
                'specials.products_id as specials_products_id',
                'specials.status as specials_status',
                'sub_products.products_id  as product_variation_id',
                'sub_products.products_weight  as product_variation_weight',
                'sub_products.products_weight_unit  as product_variation_unit',



                'hotcats.hotcats_id as hotcat_id',
                'hotcats.hotcat_name as hotcat_name',
                'hotcats.hotcats_color_code as hotcats_color_code',
                'memberships.membership_id as msd_id',
                'memberships.membership_name as msd_name',
                'memberships.membership_discount_percentage as msd_discount',
                'memberships.membership_points_from as msd_points_from',
                'memberships.membership_points_to as msd_points_to',
                'memberships.membership_cap_value as msd_cap_value',
                'memberships.membership_has_validity as msd_has_validity',
                'memberships.membership_valid_till as msd_valid_till',
                'memberships.membership_status as msd_status'
            )
            // ->orderBy('products_products_id', 'DESC')
            // ->take(20)  
            ->groupBy('products_products_id')
            ->get();


        $nowTime = date("Y-m-d H:i:s", time());

        for ($i = 0; $i < count($products); $i++) {
            $expiry  = date("Y-m-d H:i:s", $products[$i]->expires_date);
            $flash_expires_date  = date("Y-m-d H:i:s",  $products[$i]->flash_expires_date);

            $flash_start_date  = date("Y-m-d H:i:s",  $products[$i]->flash_start_date);



            if ($products[$i]->specials_id != null && $expiry > $nowTime && $products[$i]->specials_status == 1) {

                $products[$i]->special_discount_price_status = 1;
            }

            if ($products[$i]->flash_sale_id != null && $flash_expires_date > $nowTime &&  $products[$i]->flash_status == 1) {


                $dtDiff = $products[$i]->flash_expires_date - time();
                $totalDays = intval($dtDiff / (24 * 60 * 60));
                $totalHours = $totalDays * 24;

                $products[$i]->flash_sale_timer_status = 1;
                $products[$i]->flash_sale_timer_duration = $totalHours;
            }
        }

        return response()->json(['message' => 'All Special products', 'special products' => $products]);
    }
















    // add fav products
    public function addfavproducts(Request $request)
    {

        $email = $request->email;
        $product_id = $request->product_id;

        $user = DB::table('users')->where('email', $email)->first();
        $id = $user->id;
        if (DB::table('liked_products')
            ->where(['liked_products_id' => $product_id, 'liked_customers_id' => $id])->first()
        ) {

            return response()
                ->json(['message' => 'Item is already in cart']);
        } else {
            $values = array(
                'liked_products_id' => $product_id,
                'liked_customers_id' => $id,
                'date_liked' => now()
            );
            $values = DB::table('liked_products')->insert($values);

            return response()->json(['message' => 'Added in favourite products']);
        }
    }

    public function deletefavproducts(Request $request)
    {

        $email = $request->email;
        $product_id = $request->product_id;

        $user = DB::table('users')->where('email', $email)->first();
        $id = $user->id;
        $fav = DB::table('liked_products')->where(['liked_products_id' => $product_id, 'liked_customers_id' => $id]);

        if ($fav) {

            $fav->delete();
            return response()
                ->json(['message' => 'Product has been removed from favorites.']);
        } else {

            return response()
                ->json(['message' => 'Item is not in fav list.']);
        }
    }

    public function getfavproducts(Request $request)
    {

        $email = $request->email;

        $user = DB::table('users')->where('email', $email)->first();
        $id = $user->id;

        $values = DB::table('liked_products')->where('liked_customers_id', '=', $id)->get();

        $pro = [];
        foreach ($values as $val) {
            $pro[] = $val->liked_products_id;
        }

        $products = DB::table('products')
            ->join('products_description', 'products_description.products_id', '=', 'products.products_id')
            ->join('images', 'images.id', '=', 'products.products_image')

            /* ->LeftJoin('image_categories', function ($join) {
                $join->on('image_categories.image_id', '=', 'products.products_image')->where(function ($query) {
                    $query->where('image_categories.image_type', '=', 'THUMBNAIL')
                        ->where('image_categories.image_type', '!=', 'THUMBNAIL')
                        ->orWhere('image_categories.image_type', '=', 'ACTUAL');
                });
            }) */

            ->LeftJoin('product_images_cloud', function ($join) {
                $join->on('product_images_cloud.product_id', '=', 'products.products_id')->where(function ($query) {
                    $query->where('product_images_cloud.image_no', '=', 0);
                });
            })

            ->where('products_description.language_id', '=', 1)
            ->where('products.products_status', '=', 1)
            ->whereIn('products.products_id', $pro)
            ->select('products_description.*', 'products.*', 'images.name as image_of_product', /* 'image_categories.path as path', */'product_images_cloud.url as path')
            ->get();

        return response()
            ->json(['message' => 'All favourite products', 'fav products' => $products]);
    }

    //get allcategories
    public function allcategories(Request $request)
    {

        $categories = DB::table('categories')->where('categories.categories_id', '!=', -1)
            ->where('categories.categories_status', '=', 1)
            ->get();
        $categories_description = DB::table('categories_description')->get();
        return response()
            ->json(['categories' => $categories, 'description' => $categories_description]);

        //     $categoryResponse = Product::allcategories($request);
        //    print $categoryResponse;

    }

    //getallproducts
    public function getallproducts(Request $request)
    {

        $pro = Product::all();

        return response()->json(['products' => $pro]);

        //     $categoryResponse = Product::getallproducts($request);
        //    print $categoryResponse;

    }

    public function rootcategories(Request $request)
    {
        $categories = DB::table('categories')
            //->join('images', 'images.id', '=', 'categories.categories_icon')
            ->join('categories_description', 'categories_description.categories_id', '=', 'categories.categories_id')
            /* ->LeftJoin('image_categories', function ($join) {
                $join->on('image_categories.image_id', '=', 'categories.categories_icon')->where(function ($query) {
                    $query->where('image_categories.image_type', '=', 'THUMBNAIL')
                        ->where('image_categories.image_type', '=', 'THUMBNAIL')
                        ->orWhere('image_categories.image_type', '=', 'THUMBNAIL');
                });
            }) */
            ->where('categories.parent_id', '=', 0)
            ->where('categories.categories_status', '=', 1)
            ->where('categories_description.language_id', '=', 1)
            ->select('categories.*', /* 'images.name as icon_of_category', */
             'categories_description.categories_name', 'categories_description.categories_description',
              /* 'image_categories.path as path', */
              'categories.categories_icon as path')
            ->orderBy('categories.sort_order', 'ASC')
            ->get();

        return response()
            ->json(['root_categories' => $categories]);
    }

    public function parentcategories(Request $request)
    {
        // $has_pre_cat = false;

        // if(isset($request->has_pre_cat)){
        //     $has_pre_cat = $request->has_pre_cat;
        // }

        $pre_catIds = [8645, 8646, 8647];

        $categories = DB::table('categories')

            ->join('categories_description', 'categories_description.categories_id', '=', 'categories.categories_id')

            ->when(!($request->has_pre_cat == true), function($query) use ($pre_catIds){
                $query->whereNotIn('categories.categories_id', $pre_catIds);
            })

            ->where('categories.parent_id', '=', 8542)
            ->where('categories.categories_id', '!=', -1)
            ->where('categories.categories_status', '=', 1)
            ->where('categories_description.language_id', '=', 1)
            ->select('categories.*',
             'categories_description.categories_name', 'categories_description.categories_description',
              'categories.categories_icon as path')
            ->orderBy('categories.sort_order', 'DESC')
            ->get();

        return response()
            ->json(['parent_categories' => $categories]);
    }

    /* public function childcategories(Request $request)
    {
        $has_pre_cat = false;

        if(isset($request->has_pre_cat)){
            $has_pre_cat = $request->has_pre_cat;
        }

        $pre_catIds = [8533, 8534, 8535];

        $categories = DB::table('categories')
            //->join('images', 'images.id', '=', 'categories.categories_icon')
            ->join('categories_description', 'categories_description.categories_id', '=', 'categories.categories_id')
            ->when(!$has_pre_cat, function($query) use ($pre_catIds){
                $query->whereNotIn('categories.categories_id', $pre_catIds);
            })
            ->where('categories.parent_id', '=', $request->parent_id)
            ->where('categories.categories_status', '=', 1)
            ->where('categories_description.language_id', '=', 1)
            ->select('categories.*',
             'categories_description.categories_name', 'categories_description.categories_description',
              'categories.categories_icon as path')
            ->orderBy('categories.sort_order', 'DESC')
            ->get();

        return response()
            ->json(['child_categories' => $categories]);
    } */

    public function getAllParentCatProducts(Request $request){

        $product_ids = DB::table('categories')
                            ->where('categories.parent_id', '=', $request->parent_id)
                            ->where('categories.categories_status', '=', 1)
                            ->Join('products_to_categories', 'categories.categories_id', '=', 'products_to_categories.categories_id')
                            ->select('products_to_categories.products_id')
                            ->get()->pluck('products_id');

        $products = $this->get_product_info($product_ids);
        if(!empty($products)){
            return response()->json($products);
        }
        else{
            return response()->json([]);
        }
    }

    public function childcategories(Request $request)
    {
        $categories = DB::table('categories')
                ->join('categories_description', 'categories_description.categories_id', '=', 'categories.categories_id')
                ->where('categories.parent_id', '=', $request->parent_id)
                ->where('categories.categories_status', '=', 1)
                ->where('categories_description.language_id', '=', 1)

                ->select('categories.*', 'categories_description.categories_name', 'categories_description.categories_description')
                ->get();

            return response()
                ->json(['child_categories' => $categories]);
    }

    public function catproducts_old(Request $request)
    {

        $products = DB::table('products_to_categories')->where('categories_id', '=', $request->cat_id)
            ->join('products', 'products.products_id', '=', 'products_to_categories.products_id')
            ->join('products_description', 'products_description.products_id', '=', 'products_to_categories.products_id')
            ->LeftJoin('image_categories', function ($join) {
                $join->on('image_categories.image_id', '=', 'products.products_image')->where(function ($query) {
                    $query->where('image_categories.image_type', '=', 'THUMBNAIL')
                        ->where('image_categories.image_type', '=', 'THUMBNAIL')
                        ->orWhere('image_categories.image_type', '=', 'THUMBNAIL');
                });
            })

            ->where('products_description.language_id', '=', 1)
            ->where('products.products_status', '=', 1)
            ->join('images', 'images.id', '=', 'products.products_image')
            ->select('products_to_categories.*', 'products.*', 'products_description.*', 'images.name as image_of_product', 'image_categories.path as path')
            ->get();

        return response()
            ->json(['category_products' => $products]);
    }


    public function catproducts_old_2(Request $request)
    {

        $products = DB::table('products_to_categories')
            ->where('categories_id', '=', $request->cat_id)
            ->join('products', 'products.products_id', '=', 'products_to_categories.products_id')

            ->LeftJoin('products_to_hotcats', 'products_to_hotcats.products_id', '=', 'products.products_id')
            ->LeftJoin('hotcats', 'products_to_hotcats.hotcats_id', '=', 'hotcats.hotcats_id')

            ->LeftJoin('products_msd', 'products_msd.products_id', '=', 'products.products_id')
            ->LeftJoin('memberships', 'products_msd.level_id', '=', 'memberships.membership_id')

            ->LeftJoin('bundles_products', 'bundles_products.product_id', '=', 'products.products_id')
            ->LeftJoin('products_description', 'products_description.products_id', '=', 'products.products_id')
            ->LeftJoin('products as sub_products', 'sub_products.parent_products_id', '=', 'products.products_id')
            ->LeftJoin('images', 'images.id', '=', 'products.products_image')
            ->LeftJoin('flash_sale', 'flash_sale.products_id', '=', 'products.products_id')
            ->LeftJoin('specials', 'specials.products_id', '=', 'products.products_id')
            ->LeftJoin('image_categories', function ($join) {
                $join->on('image_categories.image_id', '=', 'products.products_image')->where(function ($query) {
                    $query->where('image_categories.image_type', '=', 'THUMBNAIL')
                        ->where('image_categories.image_type', '=', 'THUMBNAIL')
                        ->orWhere('image_categories.image_type', '=', 'THUMBNAIL');
                });
            })

            ->where('products_description.language_id', '=', 1)
            ->where('products.products_status', '=', 1)
            ->where('products.parent_products_id', '=', null)


            ->select(
                'products.products_id as products_products_id',
                'bundles_products.product_id as product_in_bundles',
                'products.*',
                'products_description.*',
                'products_description.products_id as products_description_products_id',
                'images.name as image_of_product',
                'image_categories.path as path',
                'flash_sale.*',
                'flash_sale.products_id as flash_sale_products_id',
                DB::raw('0 as flash_sale_timer_duration'),
                DB::raw('0 as flash_sale_timer_status'),
                'specials.*',
                DB::raw('0 as special_discount_price_status'),
                'specials.products_id as specials_products_id',
                'specials.status as specials_status',
                'sub_products.products_id  as product_variation_id',
                'sub_products.products_weight  as product_variation_weight',
                'sub_products.products_weight_unit  as product_variation_unit',

                'hotcats.hotcats_id as hotcat_id',
                'hotcats.hotcat_name as hotcat_name',
                'hotcats.hotcats_color_code as hotcats_color_code',
                'memberships.membership_id as msd_id',
                'memberships.membership_name as msd_name',
                'memberships.membership_discount_percentage as msd_discount',
                'memberships.membership_points_from as msd_points_from',
                'memberships.membership_points_to as msd_points_to',
                'memberships.membership_cap_value as msd_cap_value',
                'memberships.membership_has_validity as msd_has_validity',
                'memberships.membership_valid_till as msd_valid_till',
                'memberships.membership_status as msd_status'
            )
            // ->orderBy('products_products_id', 'DESC')
            // ->take(20)  
            ->groupBy('products_products_id')
            ->get();


        $nowTime = date("Y-m-d H:i:s", time());

        for ($i = 0; $i < count($products); $i++) {
            $expiry  = date("Y-m-d H:i:s", $products[$i]->expires_date);
            $flash_expires_date  = date("Y-m-d H:i:s",  $products[$i]->flash_expires_date);

            $flash_start_date  = date("Y-m-d H:i:s",  $products[$i]->flash_start_date);



            if ($products[$i]->specials_id != null && $expiry > $nowTime && $products[$i]->specials_status == 1) {

                $products[$i]->special_discount_price_status = 1;
            }

            if ($products[$i]->flash_sale_id != null && $flash_expires_date > $nowTime &&  $products[$i]->flash_status == 1) {


                $dtDiff = $products[$i]->flash_expires_date - time();
                $totalDays = intval($dtDiff / (24 * 60 * 60));
                $totalHours = $totalDays * 24;

                $products[$i]->flash_sale_timer_status = 1;
                $products[$i]->flash_sale_timer_duration = $totalHours;
            }
        }

        return response()->json(['category_products' => $products]);
    }

    public function catproducts(Request $request)
    {

        $products = DB::table('products_to_categories')

            ->where('categories_id', '=', $request->cat_id)

            ->join('products', 'products.products_id', '=', 'products_to_categories.products_id')
            ->LeftJoin('products_description', 'products_description.products_id', '=', 'products.products_id')
            ->LeftJoin('products as sub_products', 'sub_products.parent_products_id', '=', 'products.products_id')
            ->LeftJoin('images', 'images.id', '=', 'products.products_image')

            /* ->LeftJoin('image_categories', function ($join) {
                $join->on('image_categories.image_id', '=', 'products.products_image')->where(function ($query) {
                    $query->where('image_categories.image_type', '=', 'THUMBNAIL')
                        ->where('image_categories.image_type', '=', 'THUMBNAIL')
                        ->orWhere('image_categories.image_type', '=', 'THUMBNAIL');
                });
            }) */

            ->LeftJoin('product_images_cloud', function ($join) {
                $join->on('product_images_cloud.product_id', '=', 'products.products_id')->where(function ($query) {
                    $query->where('product_images_cloud.image_no', '=', 0);
                });
            })

            ->where('products_description.language_id', '=', 1)
            ->where('products.products_status', '=', 1)
            ->where('products.parent_products_id', '=', null)


            ->select(
                'products.products_id as products_products_id',
                'products.*',
                'products_description.*',
                'products_description.products_id as products_description_products_id',
                'images.name as image_of_product',
                /* 'image_categories.path as path', */
                'product_images_cloud.url as path',
                'sub_products.products_id  as product_variation_id',
                'sub_products.products_weight  as product_variation_weight',
                'sub_products.products_weight_unit  as product_variation_unit'
            )
            ->orderBy('products.products_id', 'DESC')
            ->groupBy('products_products_id')
            ->get();

        return response()->json(['category_products' => $products]);
    }

    public function getCategoryProducts(Request $request){
        if($request->cat_id == '8534'){ //Deals
            return $this->get_super_deals($request);
        }
        if($request->cat_id == '8533'){ //Combo
            return $this->combos($request);
        }
        if($request->cat_id == '8535'){ //Bundle
            return $this->bundles($request);
        }

        $product_ids = DB::table('products_to_categories')->where('categories_id', $request->cat_id)->get()->pluck('products_id');

        // $products = $this->get_product_info($product_ids);
        $products = $this->get_product_info_incl_variable($product_ids);
        

        if(!empty($products)){
            return response()->json(['products' => $products]);
        }
        else{
            return response()->json(['products' => []]);
        } 
    }











    public function productSearch(Request $request)
    {
        /*return response()
        ->json(['searched_products' => '']);*/

        $searchTerm = $request->name;

        $products = DB::table('products')
            ->join('products_description', 'products_description.products_id', '=', 'products.products_id')
            ->join('images', 'images.id', '=', 'products.products_image')
            ->where('products_name', 'LIKE', "%{$searchTerm}%")
            ->where('products.products_status', '=', 1)
            ->select('products_description.*', 'products.*', 'images.name as image_of_product')
            ->get();

        return response()
            ->json(['searched_products' => $products]);
    }

    public function addCart(Request $request)
    {

        $email = $request->email;
        $product_id = $request->product_id;

        $user = DB::table('users')->where('email', $email)->first();

        $cart = new Cart();
        $cart->user_id = $user->id;
        $cart->product_id = $product_id;
        $cart->save();

        return response()
            ->json(['message' => 'product is added in cart'], 200);
    }

    /*public function addCartBundle(Request $request)
    {

        $email = $request->email;
        $bundle_id = $request->bundle_id;

        $user = DB::table('users')->where('email', $email)->first();

        $check = DB::table('cart_bundle')->where('user_id', '=', $user->id)
            ->where('bundle_id', '=', $bundle_id)->first();

        if (!$check) {

            DB::table('cart_bundle')->insert([

                'user_id' => $user->id,
                'bundle_id' => $bundle_id,
                'qty' => 1

            ]);


            return response()
                ->json(['message' => 'bundle is added in cart'], 200);
        } else {
            return response()
                ->json(['message' => 'bundle is already in cart'], 200);
        }
    }*/

    /*public function remove_bundle_from_cart(Request $request)
    {

        $email = $request->email;
        $bundle_id = $request->bundle_id;

        $user = DB::table('users')->where('email', $email)->first();

        $check = DB::table('cart_bundle')->where('user_id', '=', $user->id)
            ->where('bundle_id', '=', $bundle_id)->first();
        $check->delete();
        return response()
            ->json(['message' => 'Bundle is removed from cart'], 200);
    }*/


    public function getAllcartPro(Request $request)
    {

        $email = $request->email;

        $users = DB::table('users')->where('email', $email)->get();
        $f_user = DB::table('users')->where('email', $email)->first();

        $ids = [];
        foreach ($users as $user) {
            $ids[] = $user->id;
        }

        $cartItems = Cart::whereIn('user_id', $ids)->get();

        $cart_ids = [];
        foreach ($cartItems as $cartItem) {
            $cart_ids[] = $cartItem->product_id;
        }

        $products = DB::table('products')
            ->join('products_description', 'products_description.products_id', '=', 'products.products_id')
            ->join('images', 'images.id', '=', 'products.products_image')
            ->join('cart', 'cart.product_id', '=', 'products.products_id')
            ->where('products_description.language_id', '=', 1)
            ->where('products.products_status', '=', 1)
            ->whereIn('products.products_id', $cart_ids)->select('cart.qty as cart_quantity', 'products_description.*', 'products.*', 'images.name as image_of_product')
            ->get();


        $bundles = DB::table('cart_bundle')->where('user_id', '=', $f_user->id)

            ->join('bundles', 'bundles.id', '=', 'cart_bundle.bundle_id')


            //->join('images', 'images.id', '=', 'bundles.bg_image_id')
            ->LeftJoin('image_categories', function ($join) {
                $join->on('image_categories.image_id', '=', 'bundles.bg_image_id')->where(function ($query) {
                    $query->where('image_categories.image_type', '=', 'THUMBNAIL')
                        ->where('image_categories.image_type', '=', 'THUMBNAIL')
                        ->orWhere('image_categories.image_type', '=', 'THUMBNAIL');
                });
            })

            ->join('bundles_info', 'bundles_info.bundle_id', '=', 'bundles.id')
            ->where('cart_bundle.user_id', '=', $f_user->id)
            ->where('bundles_info.language_id', '=', 1)
            ->select('cart_bundle.*', 'bundles.*', 'image_categories.path as path', 'bundles_info.bundle_title', 'bundles_info.bundle_tos')
            ->get();




        return response()
            ->json(['message' => 'cart products', 'cartproducts' => $products, 'cart_bundles' => $bundles], 200);
    }

    public function removeCart(Request $request)
    {

        $email = $request->email;
        $product_id = $request->product_id;

        $user = DB::table('users')->where('email', $email)->first();

        $cart = Cart::where('user_id', '=', $user->id)
            ->where('product_id', '=', $product_id)->first();

        $cart->delete();

        return response()
            ->json(['message' => 'product is removed from cart'], 200);
    }

    public function removeallCart(Request $request)
    {

        $email = $request->email;

        $user = DB::table('users')->where('email', $email)->first();
        //       $user = DB::table('users')->get();


        $cart = Cart::where('user_id', '=', $user->id)
            ->get();
        $bundles = DB::table('cart_bundle')->where('user_id', '=', $user->id)->get();


        if ($bundles->count() == 0 &&  $cart->count() == 0) {

            return response()
                ->json(['message' => 'your cart is empty'], 200);
        }


        if ($bundles->count() > 0) {
            foreach ($bundles as $bun) {
                $bun->delete();
            }
        }


        if ($cart->count() > 0) {

            foreach ($cart as $car) {
                $car->delete();
            }
        }

        return response()
            ->json(['message' => 'ALL cart items are flushed'], 200);
    }

    public function addqty(Request $request)
    {

        $email = $request->email;
        $product_id = $request->product_id;

        $user = DB::table('users')->where('email', $email)->first();

        if(empty($user)){
            return response()
                ->json(['message' => 'Invalid user'], 400);
        }
        
        DB::table('cart')->where('user_id', '=', $user->id)
            ->where('product_id', '=', $product_id)->increment('qty', 1);

        return response()
            ->json(['message' => 'product quantity updated'], 200);
    }

    public function decreaseqty(Request $request)
    {

        $email = $request->email;
        $product_id = $request->product_id;

        $user = DB::table('users')->where('email', $email)->first();

        if(empty($user)){
            return response()
                ->json(['message' => 'Invalid user'], 400);
        }
        
        DB::table('cart')->where('user_id', '=', $user->id)
            ->where('product_id', '=', $product_id)->decrement('qty', 1);

        $cart = DB::table('cart')->where('user_id', '=', $user->id)
            ->where('product_id', '=', $product_id)->first();

        if(empty($cart)){
            return response()
                ->json(['message' => 'Invalid Product ID'], 400);
        }

        if($cart->qty == 0){

            DB::table('cart')->where('user_id', '=', $user->id)
            ->where('product_id', '=', $product_id)->delete();

            return response()
            ->json(['message' => 'Quantity zero. Product removed.'], 200);
        }

        return response()
            ->json(['message' => 'Product quantity updated'], 200);
    }


    /*public function add_bundle_qty(Request $request)
    {

        $email = $request->email;
        $bundle_id = $request->bundle_id;

        $user = DB::table('users')->where('email', $email)->first();



        $cart = DB::table('cart_bundle')->where('user_id', '=', $user->id)
            ->where('bundle_id', '=', $bundle_id)->increment('qty', 1);


        return response()
            ->json(['message' => 'product quantity updated'], 200);
    }

    public function decrease_bundle_qty(Request $request)
    {

        $email = $request->email;
        $bundle_id = $request->bundle_id;

        $user = DB::table('users')->where('email', $email)->first();

        $cart = DB::table('cart_bundle')->where('user_id', '=', $user->id)
            ->where('bundle_id', '=', $bundle_id)->decrement('qty', 1);


        return response()
            ->json(['message' => 'product quantity updated'], 200);
    }*/




    public function sliderimages(Request $request)
    {

        $sliders = DB::table('sliders_images')
            ->where('sliders_images.status', '=', 1)
            ->leftJoin('image_categories', 'sliders_images.sliders_image', '=', 'image_categories.image_id')
            ->where('image_categories.image_type', 'ACTUAL')
            ->select('sliders_images.*', 'image_categories.path')

            ->get();

        return response()
            ->json(['message' => 'slider_images', 'sliders' => $sliders], 200);
    }

    public function settings(Request $request)
    {

        $sliders = DB::table('settings')->get();

        return response()
            ->json(['message' => 'settings', 'settings' => $sliders], 200);
    }



    public function hotcat(Request $request)
    {
        $products = DB::table('hotcats')
            ->LeftJoin('image_categories', function ($join) {
                $join->on('image_categories.image_id', '=', 'hotcats.hotcat_image')->where(function ($query) {
                    $query->where('image_categories.image_type', '=', 'THUMBNAIL')
                        ->where('image_categories.image_type', '!=', 'THUMBNAIL')
                        ->orWhere('image_categories.image_type', '=', 'ACTUAL');
                });
            })
            ->select('hotcats.*', 'image_categories.path as path')
            ->where('hotcats_status', '=', 1)
            ->get();

        return response()
            ->json(['message' => 'HotCategories', 'hotcategories' => $products]);
    }

    public function collection(Request $request)
    {
        $list = DB::table('packages')
        ->LeftJoin('packages_info', 'packages_info.package_id', '=', 'packages.id')
        ->LeftJoin('image_categories', function ($join) {
            $join->on('image_categories.image_id', '=', 'packages.bg_image_id')->where(function ($query) {
                $query->where('image_categories.image_type', '=', 'THUMBNAIL')
                    ->where('image_categories.image_type', '!=', 'THUMBNAIL')
                    ->orWhere('image_categories.image_type', '=', 'ACTUAL');
            });
        })
        ->where('packages.parent_id', NULL)
        ->where('packages_info.language_id', '=', 1)
        ->where('packages.status', '=', 1)
        ->select('packages.id as id', 'packages_info.package_title as title', 'packages.color_code as color_code', 'image_categories.path as package_image_path', 'packages_info.package_desc as package_desc')
        ->get();
        
        foreach ($list as $i => $o) {
            $child_packages = DB::table('packages')
            
                ->LeftJoin('packages_info', 'packages_info.package_id', '=', 'packages.id')
                ->LeftJoin('image_categories', function ($join) {
                    $join->on('image_categories.image_id', '=', 'packages.bg_image_id')->where(function ($query) {
                        $query->where('image_categories.image_type', '=', 'THUMBNAIL')
                            ->where('image_categories.image_type', '!=', 'THUMBNAIL')
                            ->orWhere('image_categories.image_type', '=', 'ACTUAL');
                    });
                })
                ->where('packages.parent_id', $o->id)
                ->where('packages_info.language_id', '=', 1)
                ->where('packages.status', '=', 1)
                ->select('packages.id as id', 'packages_info.package_title as title', 'packages.color_code as color_code', 'image_categories.path as package_image_path', 'packages_info.package_desc as package_desc')
                ->get();
                
            $list[$i]->child_packages = $child_packages;
        }

        return response()
            ->json(['message' => 'Collection', 'collections' => $list]);
    }

    public function get_super_deals(Request $request)
    {
        $super_deals = DB::table('super_deals')
                        ->LeftJoin('image_categories', 'image_categories.image_id', '=', 'super_deals.bg_image_id')
                        ->where('super_deals.status', 1)
                        ->select('super_deals.id as id', 'super_deals.cap_amount as cap_amount', 'super_deals.type as type', 'image_categories.path as bg_image_path')
                        ->first();

        if(isset($super_deals)){
            $sd_products = DB::table('super_deals_products')->get();
            $pid_to_price = $sd_products->pluck('new_product_price', 'product_id');
            $pid_to_point = $sd_products->pluck('new_point', 'product_id');
            $product_ids = $sd_products->pluck('product_id');

            $products = $this->get_product_info($product_ids);

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
        return response()
            ->json(['super_deals' => $super_deals]);
    }
    
    public function get_flash_deals(Request $request)
    {
        $flash_deals = DB::table('flash_deals')
                        ->where('flash_deals.status', 1)
                        ->select('flash_deals.id as id', 'flash_deals.start_time as start_time', 'flash_deals.end_time as end_time')
                        ->first();

        //return response()->json([$flash_deals->start_time, date("Y-m-d h:i:s")]);
        $flash_deals->current_time = date("Y-m-d h:i:s");

        if($flash_deals->start_time > date("Y-m-d h:i:s")){
            return response()
            ->json(['flash_deals' => [], 'result' => false, 'status' => 200, 'msg' => 'Flash deals have not started yet.']);
        }

        if($flash_deals->end_time <= date("Y-m-d h:i:s")){
            return response()
            ->json(['flash_deals' => [], 'result' => false, 'status' => 200, 'msg' => 'Flash deals has ended.']);
        }

        if(isset($flash_deals)){
            $sd_products = DB::table('flash_deals_products')->get();
            $pid_to_price = $sd_products->pluck('new_product_price', 'product_id');
            $product_ids = $sd_products->pluck('product_id');

            $products = $this->get_product_info($product_ids);

            foreach($products as $p){
                $p->flash_deals_price = $pid_to_price[$p->product_id];
            }

            $flash_deals->products = $products;
        }

        //return response()->json(date("Y-m-d h:i:s"));

        return response()
            ->json(['flash_deals' => $flash_deals, 'result' => true, 'status' => 200]);
    }

    /*public function collection_product(Request $request)
    {

        $id = $request->id;
        $query = DB::table('packages_products');
        $query->select(
            'packages_products.id',
            'products.*',
            'products_description.products_name',
            'image_categories.path',
            'hotcats.hotcats_id as hotcat_id',
            'hotcats.hotcat_name as hotcat_name',
            'hotcats.hotcats_color_code as hotcats_color_code',
            'memberships.membership_id as msd_id',
            'memberships.membership_name as msd_name',
            'memberships.membership_discount_percentage as msd_discount',
            'memberships.membership_points_from as msd_points_from',
            'memberships.membership_points_to as msd_points_to',
            'memberships.membership_cap_value as msd_cap_value',
            'memberships.membership_has_validity as msd_has_validity',
            'memberships.membership_valid_till as msd_valid_till',
            'memberships.membership_status as msd_status'
        );
        $query->leftJoin('products', 'products.products_id', '=', 'packages_products.product_id');
        $query->leftJoin('products_description', 'products_description.products_id', '=', 'products.products_id');

        $query->leftJoin('products_to_hotcats', 'products_to_hotcats.products_id', '=', 'products.products_id');
        $query->leftJoin('hotcats', 'products_to_hotcats.hotcats_id', '=', 'hotcats.hotcats_id');

        $query->leftJoin('products_msd', 'products_msd.products_id', '=', 'products.products_id');
        $query->leftJoin('memberships', 'products_msd.level_id', '=', 'memberships.membership_id');

        $query->LeftJoin('image_categories', function ($join) {
            $join->on('image_categories.image_id', '=', 'products.products_image')
                ->where(function ($query) {
                    $query->where('image_categories.image_type', '=', 'THUMBNAIL')
                        ->where('image_categories.image_type', '!=', 'THUMBNAIL')
                        ->orWhere('image_categories.image_type', '=', 'ACTUAL');
                });
        });
        $query->where('packages_products.package_id', $id);
        $query->where('products_description.language_id', 1);
        $list = $query->get();

        return response()
            ->json(['message' => 'collection_product', 'collection_product' => $list]);
    }*/
    
    
    /*Collection*/
    public function collection_product(Request $request)
    {

        $id = $request->collection_id;
        $product_ids = DB::table('packages_products')
        ->where('packages_products.package_id', $id)->get()->pluck('product_id');
        
        $products = $this->get_product_info($product_ids);
        
        return response()
            ->json(['message' => 'collection_product', 'collection_product' => $products]);
    }

    public function get_collection_packages(Request $request)
    {

        $id = $request->collection_id;

        $query = DB::table('packages')->where('parent_id', $id)->where('status', 1)
            ->leftJoin('packages_info', 'packages_info.package_id', '=', 'packages.id');

        $query->LeftJoin('image_categories', function ($join) {
            $join->on('image_categories.image_id', '=', 'packages.bg_image_id')
                ->where(function ($query) {
                    $query->where('image_categories.image_type', '=', 'THUMBNAIL')
                        ->where('image_categories.image_type', '!=', 'THUMBNAIL')
                        ->orWhere('image_categories.image_type', '=', 'ACTUAL');
                });
        });

        $query->where('packages_info.language_id', 1);

        $query->select('packages.id as package_id', 'packages.parent_id as parent_id', 'packages_info.package_title as title', 'packages_info.package_desc as description', 'image_categories.path as image_path');

        $list = $query->get();

        return response()
            ->json(['message' => 'collection_packages', 'collection_packages' => $list]);
    }
    
    public function addCartPackage(Request $request)
    {

        $email = $request->email;
        $package_id = $request->collection_id;

        $user = DB::table('users')->where('email', $email)->first();

        $check = DB::table('cart_package')->where('user_id', '=', $user->id)
            ->where('package_id', '=', $package_id)->first();

        if (!$check) {

            DB::table('cart_package')->insert([

                'user_id' => $user->id,
                'package_id' => $package_id,
                'qty' => 1

            ]);


            return response()
                ->json(['message' => 'Collection added to cart'], 200);
        } else {
            return response()
                ->json(['message' => 'Collection is already added into cart'], 200);
        }
    }

    public function remove_package_from_cart(Request $request)
    {

        $email = $request->email;
        $package_id = $request->collection_id;

        $user = DB::table('users')->where('email', $email)->first();

        $check = DB::table('cart_package')->where('user_id', '=', $user->id)
            ->where('package_id', '=', $package_id);

        $check->delete();
        
        return response()
            ->json(['message' => 'Collection removed from cart'], 200);
    }

    public function add_package_qty(Request $request)
    {

        $email = $request->email;
        $package_id = $request->collection_id;

        $user = DB::table('users')->where('email', $email)->first();



        $cart = DB::table('cart_package')->where('user_id', '=', $user->id)
            ->where('package_id', '=', $package_id)->increment('qty', 1);


        return response()
            ->json(['message' => 'Collection quantity increased by 1'], 200);
    }

    public function decrease_package_qty(Request $request)
    {

        $email = $request->email;
        $package_id = $request->collection_id;

        $user = DB::table('users')->where('email', $email)->first();

        $cart = DB::table('cart_package')->where('user_id', '=', $user->id)
            ->where('package_id', '=', $package_id)->decrement('qty', 1);


        return response()
            ->json(['message' => 'Collection quantity decreased by 1'], 200);
    }
    /*Collection*/
    

    public function terms(Request $request)
    {

        $pages = DB::table('pages')
            ->join('pages_description', 'pages_description.page_id', '=', 'pages.page_id')

            ->where('pages_description.language_id', '=', 1)
            ->where('pages.type', '=', 1)
            ->where('pages.page_id', '=', 2)
            ->select('pages.*', 'pages_description.*')
            ->first();

        return response()
            ->json(['message' => 'Terms', 'terms' => $pages]);
    }

    public function single_setting(Request $request)
    {

        $id = $request->id;

        $sliders = DB::table('settings')->where('id', '=', $id)->first();

        return response()
            ->json(['message' => 'Single Settings', 'settings' => $sliders], 200);
    }

    public function app_menus_main(Request $request)
    {

        $products = DB::table('app_menus')
            ->join('app_menus_langs', 'app_menus_langs.app_menu_id', '=', 'app_menus.id')
            ->where('app_menus_langs.language_id', '=', 1)
            ->where('app_menus.menu_type', '=', 'Main')
            ->where('app_menus.status', '=', 1)
            ->select('app_menus.*', 'app_menus_langs.*')
            ->get();
        $bg = DB::table('settings')->where('id', '=', 151)
            ->first();

        return response()
            ->json(['message' => 'App Menus Main', 'welcome_image' => $bg, 'app_menus_main' => $products]);
    }

    public function app_menus_bottom(Request $request)
    {
        $products = DB::table('app_menus')
            ->join('app_menus_langs', 'app_menus_langs.app_menu_id', '=', 'app_menus.id')
            ->where('app_menus_langs.language_id', '=', 1)
            ->where('app_menus.menu_type', '=', 'Bottom')
            ->select('app_menus.*', 'app_menus_langs.*')
            ->get();
        $bg = DB::table('settings')->where('id', '=', 151)
            ->first();
        return response()
            ->json(['message' => 'App Menus Bottom', 'welcome_image' => $bg, 'app_menus_bottom' => $products]);
    }

    public function app_menus(Request $request)
    {

        $bg = DB::table('settings')->where('id', '=', 151)
            ->first();

        $products = DB::table('app_menus')
            ->join('app_menus_langs', 'app_menus_langs.app_menu_id', '=', 'app_menus.id')
            ->where('app_menus_langs.language_id', '=', 1)

            ->select('app_menus.*', 'app_menus_langs.*')
            ->get();

        return response()
            ->json(['message' => 'App Menus', 'welcome_image' => $bg, 'app_menus' => $products]);
    }

    public function couponsall(Request $request)
    {

        $top_offers = DB::table('coupons')->where('expiry_date', '>', now())
            ->get();

        return response()
            ->json(['message' => 'All Coupons', 'coupons' => $top_offers]);
    }

    public function privacy(Request $request)
    {

        $pages = DB::table('pages')
            ->join('pages_description', 'pages_description.page_id', '=', 'pages.page_id')

            ->where('pages_description.language_id', '=', 1)
            ->where('pages.type', '=', 1)
            ->where('pages.page_id', '=', 1)
            ->select('pages.*', 'pages_description.*')
            ->get();

        return response()
            ->json(['message' => 'Privacy', 'privacy' => $pages]);
    }

    public function allpages(Request $request)
    {

        $pages = DB::table('pages')
            ->join('pages_description', 'pages_description.page_id', '=', 'pages.page_id')

            ->where('pages_description.language_id', '=', 1)
            ->where('pages.type', '=', 1)
            ->select('pages.*', 'pages_description.*')
            ->get();

        return response()
            ->json(['message' => 'All PAGES', 'pages' => $pages]);
    }

    public function getpages(Request $request)
    {

        $pages_id = $request->page_id;

        $pages = DB::table('pages_description')->where('page_id', $pages_id)->first();

        return response()
            ->json(['message' => 'CURRENT PAGE', 'current_page' => $pages]);
    }

    public function getter()
    {

        $language_id = '1';

        $manufacturers = Manufacturers::sortable(['manufacturers_id' => 'desc'])->leftJoin('manufacturers_info', 'manufacturers_info.manufacturers_id', '=', 'manufacturers.manufacturers_id')->LeftJoin('image_categories', function ($join) {
            $join->on('image_categories.image_id', '=', 'manufacturers.manufacturer_image')->where(function ($query) {
                $query->where('image_categories.image_type', '=', 'THUMBNAIL')
                    ->where('image_categories.image_type', '!=', 'THUMBNAIL')
                    ->orWhere('image_categories.image_type', '=', 'ACTUAL');
            });
        })
            ->select('manufacturers.manufacturers_id as id', 'manufacturers.manufacturer_image as image', 'manufacturers.manufacturer_name as name', 'manufacturers_info.manufacturers_url as url', 'manufacturers_info.url_clicked', 'manufacturers_info.date_last_click as clik_date', 'image_categories.path as path')
            ->where('manufacturers_info.languages_id', $language_id)->get();
        return $manufacturers;
    }
    
    public function get_top_brands(Request $request){
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
            ->where('manufacturers.is_top', '=', 1)

            ->select('manufacturers.manufacturers_id as id', 'manufacturers_info.*', 'manufacturers.manufacturer_image as image', 'manufacturer_image_header as header_image', 'manufacturers.manufacturer_name as name', 'manufacturers_info.manufacturers_url as url', 'manufacturers_info.url_clicked', 'manufacturers_info.date_last_click as clik_date', 'header.path as header_image_path', 'image_categories.path as path')
            ->get();
        
        return response()
            ->json(['message' => 'All active brands', 'brands' => $brands]);
        
    }

    public function manufacturers(Request $request)
    {

        $products = DB::table('manufacturers')
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

            ->select('manufacturers.manufacturers_id as id', 'manufacturers.is_top as is_top', 'manufacturers_info.*', 'manufacturers.manufacturer_image as image', 'manufacturer_image_header as header_image', 'manufacturers.manufacturer_name as name', 'manufacturers_info.manufacturers_url as url', 'manufacturers_info.url_clicked', 'manufacturers_info.date_last_click as clik_date', 'header.path as header_image_path', 'image_categories.path as path')
            ->get();

        return response()
            ->json(['message' => 'All active manufacturers', 'manufacturers' => $products]);
    }

    public function get_categories_by_brand(Request $request){

        $brand_id = $request->brand_id;

        $brand_product_ids = DB::table('products')
            ->where('manufacturers_id', $brand_id)
            ->where('products_in_stock', '>', 0)
            ->where('parent_products_id', '=', null)
            ->where('products_status', 1)
            ->get()->pluck('products_id');

        //return response()->json($brand_product_ids);

        $brand_categories_ids = DB::table('products_to_categories')
            ->whereIn('products_id', $brand_product_ids)
            ->groupBy('products_id')
            ->select(DB::raw('MAX(categories_id) as categories_id'))
            ->distinct()->get(['categories_id'])->pluck('categories_id');

        //return response()->json($brand_product_ids);

        $categories = DB::table('categories')
        ->join('categories_description', 'categories_description.categories_id', '=', 'categories.categories_id')

        ->whereIn('categories.categories_id', $brand_categories_ids)

        ->where('categories.categories_status', '=', 1)
        ->where('categories_description.language_id', '=', 1)
        ->select('categories.*',
            'categories_description.categories_name', 'categories_description.categories_description',
            'categories.categories_icon as path')
        ->orderBy('categories.sort_order', 'ASC')
        ->get();

        return response()
            ->json(['categories' => $categories]);

    }

    public function get_products_by_brand_and_categories(Request $request){
        $pro_ids_from_cat = DB::table('products_to_categories')
            ->where('categories_id', $request->category_id)
            ->distinct()->get(['products_id'])->pluck('products_id');

        $product_ids = DB::table('products')
            ->where('manufacturers_id', $request->brand_id)
            ->whereIn('products_id', $pro_ids_from_cat)
            ->where('products_in_stock', '>', 0)
            ->where('parent_products_id', '=', null)
            ->where('products_status', 1)
            ->get()->pluck('products_id');

        $products = $this->get_product_info($product_ids);

        return response()
            ->json(['products' => $products]);
    }

    public function banners(Request $request)
    {

        $products = DB::table('banners')
            ->join('images', 'images.id', '=', 'banners.banners_image')

            ->select('banners.*', 'images.name as image_of_banner')
            ->get();

        return response()
            ->json(['message' => 'All banners', 'banners' => $products]);
    }

    /*
     public function top_offers(Request $request){
      
          $top_offers = DB::table('top_offers')
            ->where('language_id', '=', 1) 
            ->get();
        
           return response()->json(['message'=> 'Top Offers', 'top_offers'=>$top_offers]);
     }
    
    
    */

    // likeproduct
    public function likeproduct(Request $request)
    {
        $categoryResponse = Product::likeproduct($request);
        print $categoryResponse;
    }

    // likeProduct
    public function unlikeproduct(Request $request)
    {
        $categoryResponse = Product::unlikeproduct($request);
        print $categoryResponse;
    }

    //getfilters
    public function getfilters(Request $request)
    {
        $categoryResponse = Product::getfilters($request);
        print $categoryResponse;
    }

    //getfilterproducts
    public function getfilterproducts(Request $request)
    {
        $categoryResponse = Product::getfilterproducts($request);
        print $categoryResponse;
    }

    //getsearchdata
    public function getsearchdata(Request $request)
    {
        $categoryResponse = Product::getsearchdata($request);
        print $categoryResponse;
    }

    //getquantity
    public function getquantity(Request $request)
    {
        $response = Product::getquantity($request);
        print $response;
    }

    //shippingMethods
    public function shppingbyweight(Request $request)
    {
        $categoryResponse = Product::shppingbyweight($request);
        print $categoryResponse;
    }

    /* Single product api */
    public function get_single_product(Request $request)
    {
        
       $produtc = DB::table('products')->where('products_id', $request['product_id'])->first();
       
        $hotCat = DB::table('products_to_hotcats')->where('products_id', $request['product_id'])->get();

        $h_infos = "";
     
        if(!empty($hotCat)){
            $h_infos = DB::table('hotcats')->select('hotcats_id', 'hotcat_name', 'hotcats_color_code')->where('hotcats_id', $hotCat[0]->hotcats_id)->first();
        }
        
        $produtc->hotcat_id = $h_infos->hotcats_id;
        $produtc->hotcat_name = $h_infos->hotcat_name;
        $produtc->hotcat_color_code = $h_infos->hotcats_color_code;

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
        $p_img = DB::table('product_images_cloud')->where('product_id', $p->product_id)->get();

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
    /* Single product api */

    public function get_product_info($product_ids = null){

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
                    ->where('p.parent_products_id', '=', null)
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



    public function hotcats_products(Request $request)
    {
        $product_ids = DB::table('products_to_hotcats')->where('hotcats_id', $request->hot_id)->get()->pluck('products_id');
        
        //dd(1);
        //return response()->json($product_ids);
        if(!empty($product_ids)){
            //return response()->json($product_ids);
            $products = $this->get_product_info($product_ids);
            //return response()->json($product_ids);
            return response()->json(['products' => $products]);
        }
        
        return response()->json(['products' => []]);
    }
    
    public function isJson($string) {
         json_decode($string);
         return (json_last_error() == JSON_ERROR_NONE);
    }
    
    /*Order*/
    public function create_order(Request $request){
        
        $content = $request->getContent();
        $data = json_decode($content);
        
        DB::table('orders')->insert([
            'orders_id' => $data->orderId,
            'customers_id' => $data->order_create_by_user_id,
            'order_create_by_user_email' => $data->order_create_by_user_email,
            'order_create_by_user_name' => $data->order_create_by_user_name,
            'order_time' => $data->order_time,
            'total_price' => $data->total_price,
            'applied_coupon_code' => $data->applied_coupon_code,
            'applied_coupon_id' => $data->applied_coupon_id,
            'total_purchase_item_count' => $data->total_purchase_item_count,
            'order_status' => $data->order_status,
            'total_bonus_points' => $data->total_bonus_points,
            'total_points' => $data->total_points,
        ]);
        
        foreach($data->ordered_products as $o){
            DB::table('orders_items')->insert([
                'orders_id' => $o->order_id,
                'item_id' => $o->item_id,
                'unit' => $o->unit,
                'point' => $o->point,
                'bonus_point' => $o->bonus_point,
                'name' => $o->name,
                'type' => $o->type
            ]);
        }
        foreach($data->ordered_bundles as $o){
            DB::table('orders_items')->insert([
                'orders_id' => $o->order_id,
                'item_id' => $o->item_id,
                'unit' => $o->unit,
                'point' => $o->point,
                'bonus_point' => $o->bonus_point,
                'name' => $o->name,
                'type' => $o->type
            ]);
        }
        foreach($data->ordered_combo as $o){
            DB::table('orders_items')->insert([
                'orders_id' => $o->order_id,
                'item_id' => $o->item_id,
                'unit' => $o->unit,
                'point' => $o->point,
                'bonus_point' => $o->bonus_point,
                'name' => $o->name,
                'type' => $o->type
            ]);
        }
        
        return response()->json([
            'status' => 'success',
            'msg' => 'Order created successfully.'
            ]);
    }
    
    public function get_order_items(Request $request){
        $order_id = $request->order_id;
        
        $items = DB::table('orders_items')->where('orders_id', $order_id)->get();
        
        if(!$items->isEmpty()){
            return response()->json([
                'status' => 'success',
                'msg' => '',
                'order_items' => $items
                ]);
        }
        else{
            return response()->json([
                'status' => 'success',
                'msg' => 'no item found',
                'order_items' => $items
            ]);
        }
    }

    public function get_past_orders(Request $request){
        $email = $request->user_email;

        $orders = DB::table('orders')->where('order_create_by_user_email', $email)
            ->select(
            'orders_id',
            'customers_id',
            'order_create_by_user_email',
            'order_create_by_user_name',
            'order_time',
            'total_price',
            'applied_coupon_code',
            'applied_coupon_id',
            'total_purchase_item_count',
            'order_status',
            'total_bonus_points',
            'total_points'
            )->get();

        return response()->json(['orders' => $orders]);

    }
    /*Order*/
    
    /*Item Quantity*/
    public function get_item_quantity(Request $request){
        $id = $request->id;
        $type = $request->type;
        
        if($type == 'product'){
            $p = DB::table('products')->where('products_id', $id)->first();
            
            if(!empty($p)){
                return response()->json([
                    'status' => 'success',
                    'stock' => $p->products_in_stock
                ]);
            }
            else{
                return response()->json(['msg' => 'Invalid product id.']);
            }
        }
        elseif($type == 'combo'){
            $c = DB::table('combos')->where('id', $id)->first();
            
            if(!empty($c)){
                return response()->json([
                    'status' => 'success',
                    'stock' => $c->stock
                ]);
            }
            else{
                return response()->json(['msg' => 'Invalid combo id.']);
            }
        }
        elseif($type == 'bundle'){
            $b = DB::table('bundles')->where('id', $id)->first();
            
            if(!empty($b)){
                return response()->json([
                    'status' => 'success',
                    'stock' => $b->stock
                ]);
            }
            else{
                return response()->json(['msg' => 'Invalid bundle id.']);
            }
        }
        else{
            return response()->json(['msg' => 'Invalid type.']);
        }
    }
    /*Item Quantity*/
    
    /*Get cart item*/
    public function get_cart_data(Request $request){

        $user = DB::table('users')->where('email', $request->email)->first();
        $userId = -1;

        //return response()->json([$user]);
        
        if(!empty($user)){
            
            $userId = $user->id;
        }
        else{
            return response()->json(['msg' => 'Invalid user email.']);
        }
        
        
        if(!empty($userId)){
            
            $cartProd = DB::table('cart')->where('user_id', $userId)->get();

            //return response()->json($cartProd);

            $product_ids_k = $cartProd->pluck('product_id');

            $prod = $this->get_product_info($product_ids_k);

            foreach($prod as $p){
                $p->product_quantity = $cartProd->where('product_id', $p->product_id)->first()->qty;
            }
            
            $cart_combo = DB::table('cart_combo')->where('user_id', $userId)->get();
            $combo_ids = $cart_combo->pluck('combo_id');


            $cart_bundle = DB::table('cart_bundle')->where('user_id', $userId)->get();
            $bundle_ids = $cart_bundle->pluck('bundle_id');

            
            $combos = DB::table('combos')

            ->LeftJoin('combos_info', 'combos_info.combo_id', '=', 'combos.id')

            ->LeftJoin('image_categories', function ($join) {
                $join->on('image_categories.image_id', '=', 'combos.bg_image_id')->where(function ($query) {
                    $query->where('image_categories.image_type', '=', 'THUMBNAIL')
                        ->where('image_categories.image_type', '!=', 'THUMBNAIL')
                        ->orWhere('image_categories.image_type', '=', 'ACTUAL');
                });
            })

            ->where('combos_info.language_id', '=', 1)
            ->where('combos.status', '=', 1)
            ->whereIn('combos.id', $combo_ids)
            ->select('combos.id as id', 'combos_info.combo_title as title', 'combos.discount as discount', 'image_categories.path as combo_image_path', 'combos.has_msd as has_msd')
            ->get();

            foreach ($combos as $c) {

                $combo_details = DB::table('combos_products')
                    ->where('combos_products.combo_id', $c->id)
                    ->select('product_id', 'quantity')
                    ->get();
                
                $pid_to_quantity = $combo_details->pluck('quantity', 'product_id');
                $product_ids = $combo_details->pluck('product_id');
    
                $products = $this->get_product_info($product_ids);
                
                if ($c->has_msd == 1) {
    
                    $c->has_msd = 'Y';
    
                    $msd = DB::table('combos_msd')
    
                        ->where('combos_msd.combo_id', $c->id)
    
                        ->join('memberships', 'memberships.membership_id', '=', 'combos_msd.membership_id')
    
                        ->LeftJoin('image_categories', function ($join) {
                            $join->on('image_categories.image_id', '=', 'memberships.membership_image')->where(function ($query) {
                                $query->where('image_categories.image_type', '=', 'THUMBNAIL')
                                    ->where('image_categories.image_type', '!=', 'THUMBNAIL')
                                    ->orWhere('image_categories.image_type', '=', 'ACTUAL');
                            });
                        })
    
                        ->select(
                            'memberships.membership_id as msd_id',
                            'memberships.membership_name as membership_name',
                            'image_categories.path as membership_image_path',
                            'combos_msd.discount as membership_discount'
                        )
                        ->get();
    
                    $c->msd_info = $msd;
                } else {
                    $c->has_msd = 'N';
                }
    
                $c->number_of_products = count($products);
                $c->combo_quantity = $cart_combo->where('combo_id', $c->id)->first()->qty;

                $c->total_price = round($products->sum(function ($t) use ($pid_to_quantity) {
                    return $t->product_price * $pid_to_quantity[$t->product_id];
                }));
                
                $c->total_point = round($products->sum(function ($t) use ($pid_to_quantity) {
                    return $t->product_points * $pid_to_quantity[$t->product_id];
                }));
    
                $c->discount_amount = round(($c->total_price * $c->discount) / 100);
                $c->combo_total = $c->total_price - $c->discount_amount;
                foreach($products as $p){
                    $p->products_quantity = $pid_to_quantity[$p->product_id];
                }
                $c->products = $products;
                
            }
            
            
            
            $bundles = DB::table('bundles')

            ->LeftJoin('bundles_info', 'bundles_info.bundle_id', '=', 'bundles.id')

            ->LeftJoin('image_categories', function ($join) {
                $join->on('image_categories.image_id', '=', 'bundles.bg_image_id')->where(function ($query) {
                    $query->where('image_categories.image_type', '=', 'THUMBNAIL')
                        ->where('image_categories.image_type', '!=', 'THUMBNAIL')
                        ->orWhere('image_categories.image_type', '=', 'ACTUAL');
                });
            })

            ->where('bundles_info.language_id', '=', 1)
            ->whereIn('bundles.id', $bundle_ids)
            ->where('bundles.status', '=', 1)
            ->select(
                'bundles.id as id',
                'bundles_info.bundle_title as bundle_title',
                'bundles.bundle_type as bundle_type',
                'bundles.discount as discount',
                'bundles.has_msd as has_msd',
                'image_categories.path as bundle_image_path'
            )

            ->get();


            foreach ($bundles as $b) {

                $combo_details = DB::table('bundles_products')
                    ->where('bundles_products.bundle_id', $b->id)
                    ->select('product_id', 'quantity')
                    ->get();
                
                $pid_to_quantity = $combo_details->pluck('quantity', 'product_id');
                $product_ids = $combo_details->pluck('product_id');
    
                $products = $this->get_product_info($product_ids);
    
                if ($b->has_msd == 'Y') {
    
                    $msd = DB::table('bundles_msd')
    
                        ->where('bundles_msd.bundle_id', $b->id)
    
                        ->join('memberships', 'memberships.membership_id', '=', 'bundles_msd.level_id')
    
                        ->LeftJoin('image_categories', function ($join) {
                            $join->on('image_categories.image_id', '=', 'memberships.membership_image')->where(function ($query) {
                                $query->where('image_categories.image_type', '=', 'THUMBNAIL')
                                    ->where('image_categories.image_type', '!=', 'THUMBNAIL')
                                    ->orWhere('image_categories.image_type', '=', 'ACTUAL');
                            });
                        })
    
                        ->select(
                            'memberships.membership_id as msd_id',
                            'memberships.membership_name as membership_name',
                            'image_categories.path as membership_image_path',
                            'bundles_msd.discount as membership_discount'
                        )
                        ->get();
    
                    $b->msd_info = $msd;
                }
    
                $b->number_of_products = count($products);
                $b->bundle_quantity = $cart_bundle->where('bundle_id', $b->id)->first()->qty;
                
                $b->total_price = round($products->sum(function ($t) use ($pid_to_quantity) {
                    return $t->product_price * $pid_to_quantity[$t->product_id];
                }));
                
                $b->total_point = round($products->sum(function ($t) use ($pid_to_quantity) {
                    return $t->product_points * $pid_to_quantity[$t->product_id];
                }));
    
                if ($b->bundle_type == 1) {
    
                    $b->bundle_type = 'price';
                    
    
                    $b->discount_amount = round(($b->total_price * $b->discount) / 100);
                    $b->bundle_total = $b->total_price - $b->discount_amount;
    
                } elseif ($b->bundle_type == 2) {
    
                    $b->bundle_type = 'point';
                    
    
                    $b->incremented_point = round(($b->total_point * $b->discount) / 100);
                    $b->bundle_total = round($b->total_point + $b->incremented_point);
                }
                foreach($products as $p){
                    $p->products_quantity = $pid_to_quantity[$p->product_id];
                }
                $b->products = $products;
            }

            return response()
                ->json(['combos' => $combos, 'products' => $prod, 'bundles' => $bundles]);
        }
        else{
            return response()->json(['msg' => 'Invalid user email.']);
        }
    }
    /*Get cart item*/
    
    /*Create address*/
    public function create_or_update_address(Request $request){
        
        if(!empty($request->user_id)){
            
            $user = DB::table('users')->find($request->user_id);
            
            if(empty($user)){
                return response()->json(['msg' => 'Invalid user id. No user found.']);
            }
            
            DB::table('users_address')->where('user_id', $request->user_id)->delete();
            
            DB::table('users_address')->insert([
                'user_id' => (isset($request->user_id) ? $request->user_id : ''),
                'addressLine1' => (isset($request->user_id) ? $request->addressLine1 : ''),
                'addressLine2' => (isset($request->user_id) ? $request->addressLine2 : ''),
                'landmark' => (isset($request->user_id) ? $request->landmark : ''),
                'city' => (isset($request->user_id) ? $request->city : ''),
                'zipCode' => (isset($request->user_id) ? $request->zipCode : ''),
                'contactNumber' => (isset($request->user_id) ? $request->contactNumber : ''),
                'addressType' => (isset($request->user_id) ? $request->addressType : ''),
                'state' => (isset($request->user_id) ? $request->state : ''),
                'country' => (isset($request->user_id) ? $request->country : ''),
                'latitute' => (isset($request->user_id) ? $request->latitute : ''),
                'longitute' => (isset($request->user_id) ? $request->longitute : ''),
            ]);
            
            return response()->json(['msg' => 'Address created/updated successfully.']);
        }
        else{
            return response()->json(['msg' => 'Invalid user id.']);
        }
    }
    /*Create address*/
    
    /*Get users address*/
    public function get_users_address(Request $request){
        if(!empty($request->user_id)){
            $user = DB::table('users')->find($request->user_id);
            
            if(empty($user)){
                return response()->json(['msg' => 'Invalid user id. No user found.']);
            }
            $address = DB::table('users_address')->where('user_id', $request->user_id)->first();
            return response()->json(['address' => $address]);
        }
        else{
            return response()->json(['msg' => 'Invalid user id.']);
        }
    }
    /*Get users address*/
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
