<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\AdminControllers\SiteSettingController;
use App\Http\Controllers\Controller;
use App\Models\Core\Coupon;
use App\Models\Core\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Validator;
use App\Models\Core\Images;

class CouponsController extends Controller
{
    //
    public function __construct(Coupon $coupon, Setting $setting, Images $images)
    {
        $this->Coupon = $coupon;
        $this->myVarSetting = new SiteSettingController($setting);
        $this->Setting = $setting;
        $this->images = $images;
    }

    public function display(Request $request)
    {

        $title = array('pageTitle' => Lang::get("labels.ListingCoupons"));
        $result = array();
        $message = array();
        $coupons = Coupon::sortable()
            ->orderBy('created_at', 'DESC')
            ->paginate(7);
        $result['coupons'] = $coupons;
        //get function from other controller
        $result['currency'] = $this->myVarSetting->getSetting();
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.coupons.index", $title)->with('result', $result)->with('coupons', $coupons);

    }

    public function filter(Request $request)
    {

        $result = array();
        $message = array();
        $title = array('pageTitle' => Lang::get("labels.EditSubCategories"));
        $name = $request->FilterBy;
        $param = $request->parameter;
        switch ($name) {
            case 'Code':$coupons = Coupon::sortable()->where('code', 'LIKE', '%' . $param . '%')
                    ->orderBy('created_at', 'DESC')
                    ->paginate(7);

                break;
            case 'CouponType':$coupons = Coupon::sortable()->where('discount_type', 'LIKE', '%' . $param . '%')
                    ->orderBy('created_at', 'DESC')
                    ->paginate(7);

                break;
            case 'CouponAmount':
                $coupons = Coupon::sortable()->where('amount', 'LIKE', '%' . $param . '%')
                    ->orderBy('created_at', 'DESC')
                    ->paginate(7);

                break;
            case 'Description':
                $coupons = Coupon::sortable()->where('description', 'LIKE', '%' . $param . '%')
                    ->orderBy('created_at', 'DESC')
                    ->paginate(7);

                break;
            default:

                break;
        }

        $result['coupons'] = $coupons;
        //get function from other controller
        $result['currency'] = $this->myVarSetting->getSetting();
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.coupons.index", $title)->with('result', $result)->with('coupons', $coupons)->with('name', $name)->with('param', $param);
    }

    public function add(Request $request)
    {

        $title = array('pageTitle' => Lang::get("labels.AddCoupon"));
        $result = array();
        $message = array();
        $result['message'] = $message;
        $emails = $this->Coupon->email();
        $result['emails'] = $emails;
        $products = $this->Coupon->cutomers();
        $result['products'] = $products;
        $categories = $this->Coupon->categories();        
        $result['categories'] = $categories;
        $result['commonContent'] = $this->Setting->commonContent();
        $result['level_types'] = DB::table('user_level_types')->orderBy('max_points', 'ASC')->get();
        $result['ref_ids'] = DB::table('users')->select('referral_id', 'user_name', 'id')->where('referral_id', '!=', '')->get();
        $result['brands'] = DB::table('manufacturers')->select('manufacturers_id', 'manufacturer_name')->where('manufacturer_name', '!=', '')->get();
        $result['allimage'] = $this->images->getimages();
        return view("admin.coupons.add", $title)->with('result', $result);
    }

    public function insert(Request $request)
    {
        if ($request->free_shipping !== null) {
            $free_shipping = $request->free_shipping;
        } else {
            $free_shipping = '0';
        }

        $code = $request->code;
        $description = $request->description;
        $discount_type = $request->discount_type;
        $amount = $request->amount;

        $date = str_replace('/', '-', $request->expiry_date);
        $expiry_date = date('Y-m-d', strtotime($date));

        if ($request->individual_use !== null) {
            $individual_use = $request->individual_use;
        } else {
            $individual_use = 0;
        }

        //include products
        if ($request->product_ids !== null) {
            $product_ids = implode(',', $request->product_ids);
        } else {
            $product_ids = '';
        }

        if ($request->exclude_product_ids !== null) {
            $exclude_product_ids = implode(',', $request->exclude_product_ids);
        } else {
            $exclude_product_ids = '';
        }

        //limit
        $usage_limit = $request->usage_limit;
        $usage_limit_per_user = $request->usage_limit_per_user;

        //$limit_usage_to_x_items = $request->limit_usage_to_x_items;

        if ($request->product_categories !== null) {
            $product_categories = implode(',', $request->product_categories);
        } else {
            $product_categories = '';
        }

        if ($request->excluded_product_categories !== null) {
            $excluded_product_categories = implode(',', $request->excluded_product_categories);
        } else {
            $excluded_product_categories = '';
        }

        if ($request->exclude_discount !== null) {
            $exclude_discount = $request->exclude_discount;
        } else {
            $exclude_discount = 0;
        }

        if ($request->exclude_flash_deals !== null) {
            $exclude_flash_deals = $request->exclude_flash_deals;
        } else {
            $exclude_flash_deals = 0;
        }
        
        if ($request->exclude_super_deals !== null) {
            $exclude_super_deals = $request->exclude_super_deals;
        } else {
            $exclude_super_deals = 0;
        }
        
        if ($request->exclude_combo !== null) {
            $exclude_combo = $request->exclude_combo;
        } else {
            $exclude_combo = 0;
        }
        
        if ($request->exclude_bundle !== null) {
            $exclude_bundle = $request->exclude_bundle;
        } else {
            $exclude_bundle = 0;
        }
        
        if ($request->exclude_msd !== null) {
            $exclude_msd = $request->exclude_msd;
        } else {
            $exclude_msd = 0;
        }

        if ($request->email_restrictions !== null) {
            $email_restrictions = implode(',', $request->email_restrictions);
        } else {
            $email_restrictions = '';
        }

        if ($request->level_restrictions !== null) {
            $level_restrictions = implode(',', $request->level_restrictions);
        } else {
            $level_restrictions = '';
        }

        $minimum_amount = $request->minimum_amount;
        $maximum_amount = $request->maximum_amount;

        if ($request->usage_count !== null) {
            $usage_count = $request->usage_count;
        } else {
            $usage_count = 0;
        }

        if ($request->used_by !== null) {
            $used_by = $request->used_by;
        } else {
            $used_by = '';
        }

        if ($request->limit_usage_to_x_items !== null) {
            $limit_usage_to_x_items = $request->limit_usage_to_x_items;
        } else {
            $limit_usage_to_x_items = 0;
        }

        if($request->image_id !== null){
            $background_image_id = $request->image_id;
        }else{
            $background_image_id = 0;
        }

        if ($request->ref_id_restrictions !== null) {
            $ref_id_restrictions = implode(',', $request->ref_id_restrictions);
        } else {
            $ref_id_restrictions = '';
        }

        if ($request->include_brands !== null) {
            $include_brands = implode(',', $request->include_brands);
        } else {
            $include_brands = '';
        }

        $validator = Validator::make(
            array(
                'code' => $request->code,
            ),
            array(
                'code' => 'required',
            )
        );
        //check validation
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {

            //check coupon already exist
            $couponInfo = $this->Coupon->coupon($code);

            if (count($couponInfo) > 0) {
                return redirect()->back()->withErrors(Lang::get("labels.CouponAlreadyError"))->withInput();
            } else if (empty($code)) {
                return redirect()->back()->withErrors(Lang::get("labels.EnterCoupon"))->withInput();
            } else {

                $coupon_id = DB::table('coupons')->insertGetId([
                    'code'  	 				 =>   $code,
                    'created_at'				 =>   date('Y-m-d H:i:s'),
                    'description'				 =>   $description,
                    'discount_type'	 			 =>   $discount_type,
                    'amount'	 	 			 =>   $amount,
                    'individual_use'	 		 =>   $individual_use,
                    'product_ids'	 			 =>   $product_ids,
                    'exclude_product_ids'		 =>   $exclude_product_ids,
                    'usage_limit'	 			 =>   $usage_limit,
                    'usage_limit_per_user'	 	 =>   $usage_limit_per_user,
                    'usage_count'	 	         =>   $usage_count,
                    'used_by'	 	             =>   $used_by,
                    'limit_usage_to_x_items'	 =>   $limit_usage_to_x_items ,
                    'product_categories'	 	 =>   $product_categories,
                    'excluded_product_categories'=>   $excluded_product_categories,
                    
                    'exclude_discount'		 =>   $exclude_discount,
                    'exclude_flash_deals'		 =>   $exclude_flash_deals,
                    'exclude_super_deals'		 =>   $exclude_super_deals,
                    'exclude_combo'		 =>   $exclude_combo,
                    'exclude_bundle'		 =>   $exclude_bundle,
                    'exclude_msd'		 =>   $exclude_msd,
                    
                    'email_restrictions'	 	 =>   $email_restrictions,                    
                    'minimum_amount'	 		 =>   $minimum_amount,
                    'maximum_amount'	 		 =>   $maximum_amount,
                    'expiry_date'				 =>	  $expiry_date,
                    'free_shipping'				 =>   $free_shipping,
                    'level_restrictions'	 	 =>   $level_restrictions,
                    'background_image_id'		 =>   $background_image_id,
                    'ref_id_restrictions'		 =>   $ref_id_restrictions,
                    'include_brands'		     =>   $include_brands,
                ]);

                /*
                $coupon_id = $this->Coupon->addcoupon($code, $description,
                    $discount_type, $amount, $individual_use, $product_ids,
                    $exclude_product_ids, $usage_limit, $usage_limit_per_user, $usage_count
                    , $used_by, $limit_usage_to_x_items, $product_categories, $excluded_product_categories,
                    $exclude_sale_items, $email_restrictions, $minimum_amount, $maximum_amount, $expiry_date, $free_shipping);
                */

                return redirect('admin/coupons/display')->with('success', Lang::get("labels.CouponAddedMessage"));
            }
        }

    }

    public function edit(Request $request, $id)
    {

        $title = array('pageTitle' => Lang::get("labels.EditCoupon"));
        $result = array();
        $message = array();
        $result['message'] = $message;
        //coupon
        $coupon = $this->Coupon->getcoupon($id);
        
        if(!empty($coupon[0]->background_image_id))
        {            
            $coupon[0]->background_image_arr = DB::table('image_categories')->where('image_id', $coupon[0]->background_image_id)->first();                    
        }       

        $result['coupon'] = $coupon;
        $emails = $this->Coupon->getemail();
        $result['emails'] = $emails;
        $products = $this->Coupon->cutomers();
        $result['products'] = $products;
        $categories = $this->Coupon->categories();
        $result['categories'] = $categories;

        $result['level_types'] = DB::table('user_level_types')->orderBy('max_points', 'ASC')->get();
        $result['ref_ids'] = DB::table('users')->select('referral_id', 'user_name', 'id')->where('referral_id', '!=', '')->get();
        $result['brands'] = DB::table('manufacturers')->select('manufacturers_id', 'manufacturer_name')->where('manufacturer_name', '!=', '')->get();

        $result['commonContent'] = $this->Setting->commonContent();
        $result['allimage'] = $this->images->getimages();
        return view("admin.coupons.edit", $title)->with('result', $result);
    }

    public function update(Request $request)
    {

        $coupans_id = $request->id;
        if (!empty($request->free_shipping)) {
            $free_shipping = $request->free_shipping;
        } else {
            $free_shipping = '0';
        }
        $code = $request->code;
        $description = $request->description;
        $discount_type = $request->discount_type;
        $amount = $request->amount;
        $date = str_replace('/', '-', $request->expiry_date);
        $expiry_date = date('Y-m-d', strtotime($date));
        if (!empty($request->individual_use)) {
            $individual_use = $request->individual_use;
        } else {
            $individual_use = '';
        }

        //include products
        if (!empty($request->product_ids)) {
            $product_ids = implode(',', $request->product_ids);
        } else {
            $product_ids = '';
        }
        if (!empty($request->exclude_product_ids)) {
            $exclude_product_ids = implode(',', $request->exclude_product_ids);
        } else {
            $exclude_product_ids = '';
        }
        $usage_limit = $request->usage_limit;
        $usage_limit_per_user = $request->usage_limit_per_user;


        if (!empty($request->product_categories)) {
            $product_categories = implode(',', $request->product_categories);
        } else {
            $product_categories = '';
        }
        if (!empty($request->excluded_product_categories)) {
            $excluded_product_categories = implode(',', $request->excluded_product_categories);
        } else {
            $excluded_product_categories = '';
        }
        if (!empty($request->email_restrictions)) {
            $email_restrictions = implode(',', $request->email_restrictions);
        } else {
            $email_restrictions = '';
        }
        $minimum_amount = $request->minimum_amount;
        $maximum_amount = $request->maximum_amount;


        $validator = Validator::make(
            array(
                'code' => $request->code,
            ),
            array(
                'code' => 'required',
            )
        );

        if ($request->usage_count !== null) {
            $usage_count = $request->usage_count;
        } else {
            $usage_count = 0;
        }
        if ($request->used_by !== null) {
            $used_by = $request->used_by;
        } else {
            $used_by = '';
        }
        if ($request->limit_usage_to_x_items !== null) {
            $limit_usage_to_x_items = $request->limit_usage_to_x_items;
        } else {
            $limit_usage_to_x_items = 0;
        }

        if ($request->level_restrictions !== null) {
            $level_restrictions = implode(',', $request->level_restrictions);
        } else {
            $level_restrictions = '';
        }

        if ($request->ref_id_restrictions !== null) {
            $ref_id_restrictions = implode(',', $request->ref_id_restrictions);
        } else {
            $ref_id_restrictions = '';
        }

        if ($request->include_brands !== null) {
            $include_brands = implode(',', $request->include_brands);
        } else {
            $include_brands = '';
        }

        if ($request->exclude_discount !== null) {
            $exclude_discount = $request->exclude_discount;
        } else {
            $exclude_discount = 0;
        }

        if ($request->exclude_flash_deals !== null) {
            $exclude_flash_deals = $request->exclude_flash_deals;
        } else {
            $exclude_flash_deals = 0;
        }
        if ($request->exclude_super_deals !== null) {
            $exclude_super_deals = $request->exclude_super_deals;
        } else {
            $exclude_super_deals = 0;
        }
        if ($request->exclude_combo !== null) {
            $exclude_combo = $request->exclude_combo;
        } else {
            $exclude_combo = 0;
        }
        if ($request->exclude_bundle !== null) {
            $exclude_bundle = $request->exclude_bundle;
        } else {
            $exclude_bundle = 0;
        }
        if ($request->exclude_msd !== null) {
            $exclude_msd = $request->exclude_msd;
        } else {
            $exclude_msd = 0;
        }

        if($request->image_id !== null){
            $background_image_id = $request->image_id;
        }else{
            $background_image_id = $request->oldImage;
        }

        //check validation
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            //check coupon already exist
            $couponInfo = $this->Coupon->getcode($code);
            if (count($couponInfo) > 1) {
                return redirect()->back()->withErrors(Lang::get("labels.CouponAlreadyError"))->withInput();
            } else if (empty($code)) {
                return redirect()->back()->withErrors(Lang::get("labels.EnterCoupon"))->withInput();
            } else {

                /*
                //insert record
                $coupon_id = $this->Coupon->couponupdate($coupans_id, $code, $description, $discount_type, $amount, $individual_use,
                    $product_ids, $exclude_product_ids, $usage_limit, $usage_limit_per_user, $usage_count,
                    $limit_usage_to_x_items, $product_categories, $used_by, $excluded_product_categories,
                    $request, $email_restrictions, $minimum_amount, $maximum_amount, $expiry_date, $free_shipping);
                */

                DB::table('coupons')->where('coupans_id', $coupans_id)
                ->update([
                    'code'  	 				 =>   $code,                    
                    'free_shipping'				 =>   $free_shipping,    
                    'description'				 =>   $description,
                    'discount_type'	 			 =>   $discount_type,
                    'amount'	 	 			 =>   $amount,
                    'expiry_date'				 =>	  $expiry_date,
                    'individual_use'	 		 =>   $individual_use,
                    'product_ids'	 			 =>   $product_ids,
                    'exclude_product_ids'		 =>   $exclude_product_ids,
                    'usage_limit'	 			 =>   $usage_limit,
                    'usage_limit_per_user'	 	 =>   $usage_limit_per_user,
                    'product_categories'	 	 =>   $product_categories,
                    'excluded_product_categories'=>   $excluded_product_categories,
                    'email_restrictions'	 	 =>   $email_restrictions,   
                    'minimum_amount'	 		 =>   $minimum_amount,
                    'maximum_amount'	 		 =>   $maximum_amount,
                    'usage_count'	 	         =>   $usage_count,
                    'used_by'	 	             =>   $used_by,                    
                    'limit_usage_to_x_items'	 =>   $limit_usage_to_x_items,  
                    'level_restrictions'	 	 =>   $level_restrictions,
                    'ref_id_restrictions'		 =>   $ref_id_restrictions,
                    'include_brands'		     =>   $include_brands,
                    
                    'exclude_discount'		 =>   $exclude_discount,
                    'exclude_flash_deals'		 =>   $exclude_flash_deals,
                    'exclude_super_deals'		 =>   $exclude_super_deals,
                    'exclude_combo'		 =>   $exclude_combo,
                    'exclude_bundle'		 =>   $exclude_bundle,
                    'exclude_msd'		 =>   $exclude_msd,
                    
                    'background_image_id'		 =>   $background_image_id,                    
                    'updated_at'				 =>   date('Y-m-d H:i:s'),
                ]);

                $message = Lang::get("labels.CouponUpdatedMessage");
                return redirect()->back()->withErrors([$message]);
            }

        }

    }

    public function delete(Request $request)
    {
        $deletecoupon = DB::table('coupons')->where('coupans_id', '=', $request->id)->delete();
        return redirect()->back()->withErrors([Lang::get("labels.CouponDeletedMessage")]);
    }

}
