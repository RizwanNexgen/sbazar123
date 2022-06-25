<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\AdminControllers\AlertController;
use App\Http\Controllers\AdminControllers\SiteSettingController;
use App\Http\Controllers\Controller;
use App\Models\Core\Categories;
use App\Models\Core\Images;
use App\Models\Core\Languages;
use App\Models\Core\Manufacturers;
use App\Models\Core\Products;
use App\Models\Core\Hotcats;
use App\Models\Core\Reviews;
use App\Models\Core\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;

class ProductController extends Controller
{

    public function __construct(Products $products, Languages $language, Images $images, Categories $category, Setting $setting,
        Manufacturers $manufacturer, Reviews $reviews, Hotcats $hotcats) {
        $this->category = $category;
        $this->hotcats = $hotcats;
        $this->reviews = $reviews;
        $this->language = $language;
        $this->images = $images;
        $this->manufacturer = $manufacturer;
        $this->products = $products;
        $this->myVarsetting = new SiteSettingController($setting);
        $this->myVaralter = new AlertController($setting);
        $this->Setting = $setting;

        $this->s3_credential = array(
            "service" => "s3",
            "aws_access_key_id" => env('S3_ACCESS_KEY_ID'),
            "aws_secret_access_key" => env("S3_SECRET_ACCESS_KEY"),
            "region" => env("S3_REGION"),
            /* "headers" => array("Cache-Control" => "max-age=31536000, public"), */
            "path" => "",
        );
    }

    public function reviews(Request $request)
    {
        $title = array('pageTitle' => Lang::get("labels.reviews"));
        $result = array();
        $data = $this->reviews->paginator();
        $result['reviews'] = $data;
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.reviews.index", $title)->with('result', $result);

    }

    public function editreviews($id, $status)
    {
        if ($status == 1) {
            DB::table('reviews')
                ->where('reviews_id', $id)
                ->update([
                    'reviews_status' => 1,
                ]);
            DB::table('reviews')
                ->where('reviews_id', $id)
                ->update([
                    'reviews_read' => 1,
                ]);
        } elseif ($status == 0) {
            DB::table('reviews')
                ->where('reviews_id', $id)
                ->update([
                    'reviews_read' => 1,
                ]);
        } else {
            DB::table('reviews')
                ->where('reviews_id', $id)
                ->update([
                    'reviews_read' => 1,
                    'reviews_status' => -1,
                ]);
        }
        $message = Lang::get("labels.reviewupdateMessage");
        return redirect()->back()->withErrors([$message]);

    }

    public function display(Request $request)
    {
        //return 1;
      
        $language_id = '1';
        $categories_id = $request->categories_id;
        $product = $request->product;
        $title = array('pageTitle' => Lang::get("labels.Products"));

        $subCategories = $this->category->allcategories($language_id);

       $products = $this->products->paginator($request);

        $results['products'] = $products;
        $results['currency'] = $this->myVarsetting->getSetting();
        $results['units'] = $this->myVarsetting->getUnits();
        $results['subCategories'] = $subCategories;
        $currentTime = array('currentTime' => time());
        $result['commonContent'] = $this->Setting->commonContent();
        $results['brand_list'] = $this->manufacturer->getter($language_id);
        return view("admin.products.index", $title)->with('result', $result)->with('results', $results)->with('categories_id', $categories_id)->with('product', $product);

    }

    public function add(Request $request)
    {


        $title = array('pageTitle' => Lang::get("labels.AddProduct"));
        $language_id = '1';
        $allimage = $this->images->getimages();
        $result = array();
        $categories = $this->category->recursivecategories($request);

        $parent_id = array();
        $option = '<ul class="list-group list-group-root well">';

        foreach ($categories as $parents) {

            if (in_array($parents->categories_id, $parent_id)) {
                $checked = 'checked';
            } else {
                $checked = '';
            }

            $option .= '<li href="#" class="list-group-item">
          <label style="width:100%">
            <input id="categories_' . $parents->categories_id . '" ' . $checked . ' type="checkbox" class=" required_one categories sub_categories" name="categories[]" value="' . $parents->categories_id . '">
          ' . $parents->categories_name . '
          </label></li>';

            if (isset($parents->childs)) {
                $option .= '<ul class="list-group">
          <li class="list-group-item">';
                $option .= $this->childcat($parents->childs, $parent_id);
                $option .= '</li></ul>';
            }
        }
        $option .= '</ul>';

        $result['categories'] = $option;


        $hotcats = $this->hotcats->getter($language_id);
         //$result['hotcats'] = $this->hotcats->getter($language_id);
        // echo "<pre>";
        // print_r($hotcats); exit;

        $parent_id = array();
        $option = '<ul class="list-group list-group-root well">';

        foreach ($hotcats as $parents) {

           

            $option .= '<li href="#" class="list-group-item">
          <label style="width:100%">
            <input id="hotcats_' . $parents->id . '"  type="checkbox" class=" required_one hotcats " name="hotcats[]" value="' . $parents->id . '">
          ' . $parents->name . '
          </label></li>';

        }
        $option .= '</ul>';

        $result['hotcats'] = $option;






        $result['manufacturer'] = $this->manufacturer->getter($language_id);
        $taxClass = DB::table('tax_class')->get();
        $result['taxClass'] = $taxClass;
        $result['languages'] = $this->myVarsetting->getLanguages();
        $result['units'] = $this->myVarsetting->getUnits();
        $result['commonContent'] = $this->Setting->commonContent();
        
        $result['main_products'] = DB::table('products')
        ->select('products.products_id', 'products_description.products_name')
        ->leftJoin('products_description', 'products_description.products_id', '=', 'products.products_id')
        ->where('products_type', 1)
        ->where('parent_products_id', NULL)
        ->where('products_description.language_id', $language_id)
        ->orderBy('products_description.products_name', 'ASC')
        ->get();
        
        $result['user_levels'] = DB::table('memberships')->get();
        
        $result['bundles'] = DB::table('bundles')
        ->select('bundles.id', 'bundles_info.bundle_title')
        ->leftJoin('bundles_info', 'bundles_info.bundle_id', '=', 'bundles.id')
        //->whereRaw('bundles.expire_at >= ?', [date('Y-m-d H:i:s')])
        ->where('bundles_info.language_id', $language_id)
        ->get();
        
        $result['combos'] = DB::table('combos')
        ->select('combos.id', 'combos_info.combo_title')
        ->leftJoin('combos_info', 'combos_info.combo_id', '=', 'combos.id')
        ->where('combos.status', 1)
        ->where('combos_info.language_id', $language_id)
        ->get();
        
        return view("admin.products.add", $title)->with('result', $result)->with('allimage', $allimage);

    }

    public function childcat($childs, $parent_id)
    {

        $contents = '';
        foreach ($childs as $key => $child) {

            if (in_array($child->categories_id, $parent_id)) {
                $checked = 'checked';
            } else {
                $checked = '';
            }

            $contents .= '<label> <input id="categories_' . $child->categories_id . '" parents_id="' . $child->parent_id . '"  type="checkbox" name="categories[]" class="required_one sub_categories categories sub_categories_' . $child->parent_id . '" value="' . $child->categories_id . '" ' . $checked . '> ' . $child->categories_name . '</label>';

            if (isset($child->childs)) {
                $contents .= '<ul class="list-group">
        <li class="list-group-item">';
                $contents .= $this->childcat($child->childs, $parent_id);
                $contents .= "</li></ul>";
            }

        }
        return $contents;
    }

    public function edit(Request $request, $product_id)
    {
        
        $language_id = '1';
        $allimage = $this->images->getimages();
        $result = $this->products->edit($request);
        //dd($result);
        $categories = $this->category->recursivecategories($request);

        $parent_id = $result['categories_array'];
        $option = '<ul class="list-group list-group-root well">';

        foreach ($categories as $parents) {

            if (in_array($parents->categories_id, $parent_id)) {
                $checked = 'checked';
            } else {
                $checked = '';
            }

            $option .= '<li href="#" class="list-group-item">
        <label style="width:100%">
          <input id="categories_' . $parents->categories_id . '" ' . $checked . ' type="checkbox" class=" required_one categories sub_categories" name="categories[]" value="' . $parents->categories_id . '">
        ' . $parents->categories_name . '
        </label></li>';

            if (isset($parents->childs)) {
                $option .= '<ul class="list-group">
        <li class="list-group-item">';
                $option .= $this->childcat($parents->childs, $parent_id);
                $option .= '</li></ul>';
            }
        }

        $option .= '</ul>';
        $result['categories'] = $option;


        $hotcat_parent_id = $result['hotcats_array'];
        $hotcats = $this->hotcats->getter($language_id);
         //$result['hotcats'] = $this->hotcats->getter($language_id);
        // echo "<pre>";
        // print_r($hotcats); exit;

        $option = '<ul class="list-group list-group-root well">';

        foreach ($hotcats as $parents) {

              if (in_array($parents->id, $hotcat_parent_id)) {
                $checked = 'checked';
            } else {
                $checked = '';
            }

            $option .= '<li href="#" class="list-group-item">
          <label style="width:100%">
            <input id="hotcats_' . $parents->id . '" ' . $checked . ' type="checkbox" class=" required_one hotcats " name="hotcats[]" value="' . $parents->id . '">
          ' . $parents->name . '
          </label></li>';

        }
        $option .= '</ul>';

        $result['hotcats'] = $option;





        $title = array('pageTitle' => Lang::get("labels.EditProduct"));
        $result['commonContent'] = $this->Setting->commonContent();
        
        $result['main_products'] = DB::table('products')
        ->select('products.products_id', 'products_description.products_name')
        ->leftJoin('products_description', 'products_description.products_id', '=', 'products.products_id')
        ->where('products_type', 1)
        ->where('parent_products_id', NULL)
        ->where('products_description.language_id', $language_id)
        ->orderBy('products_description.products_name', 'ASC')
        ->get();
        
        $result['user_levels'] = DB::table('memberships')->get();
        
        $result['bundles'] = DB::table('bundles')
        ->select('bundles.id', 'bundles_info.bundle_title')
        ->leftJoin('bundles_info', 'bundles_info.bundle_id', '=', 'bundles.id')
        //->whereRaw('bundles.expire_at >= ?', [date('Y-m-d H:i:s')])
        ->where('bundles_info.language_id', $language_id)
        ->get();
        
        $result['combos'] = DB::table('combos')
        ->select('combos.id', 'combos_info.combo_title')
        ->leftJoin('combos_info', 'combos_info.combo_id', '=', 'combos.id')
        ->where('combos.status', 1)
        ->where('combos_info.language_id', $language_id)
        ->get();
        
        $product_bundle = DB::table('bundles_products')
        ->select('bundle_id')        
        ->where('product_id', $request->id)
        ->first();
        
        $product_combo = DB::table('combos_products')
        ->select('combo_id')        
        ->where('product_id', $request->id)
        ->first();

        if(empty($product_bundle->bundle_id))
        {
            $result['bundle_id'] = '';
        }
        else
        {
            $result['bundle_id'] = $product_bundle->bundle_id;
        }
        
        if(empty($product_combo->combo_id))
        {
            $result['combo_id'] = '';
        }
        else
        {
            $result['combo_id'] = $product_combo->combo_id;
        }
        
        //dd($result);
        return $result;
        return view("admin.products.edit", $title)->with('result', $result)->with('allimage', $allimage);

    }

    public function update(Request $request)
    {
        $startdate = strtotime($request->flash_start_date);
        $expiredate = strtotime($request->flash_expires_date);
        $startdate = $request->flash_start_date;
        $starttime = $request->flash_start_time;
        $start_date = str_replace('/','-',$startdate.' '.$starttime);
        $flash_start_date = strtotime($start_date);
        $expiredate = $request->flash_expires_date;
        $expiretime = $request->flash_end_time;
        $expire_date = str_replace('/','-',$expiredate.' '.$expiretime);
        $flash_expires_date = strtotime($expire_date);


        if($flash_start_date > $flash_expires_date){
            $request->session()->flash('message.level', 'danger');
            $request->session()->flash('message.content', 'Flash sale start date can not be greater then expiry date');
            return redirect()->back();
        }
        
       
        $result = $this->products->updaterecord($request);
        $products_id = $request->id;
        
        return redirect('admin/products/display');
    }

    public function delete(Request $request)
    {
        $this->products->deleterecord($request);
        return redirect()->back()->withErrors([Lang::get("labels.ProducthasbeendeletedMessage")]);

    }

    public function delete_ajax(Request $request)
    {
        $this->products->deleterecord($request);
        return response()->json([
            'status' => 1,
            'msg' => 'Product deleted.'
        ]);
    }

    public function insert(Request $request)
    {
        $startdate = strtotime($request->flash_start_date);
        $expiredate = strtotime($request->flash_expires_date);
        $startdate = $request->flash_start_date;
        $starttime = $request->flash_start_time;
        $start_date = str_replace('/','-',$startdate.' '.$starttime);
        $flash_start_date = strtotime($start_date);
        $expiredate = $request->flash_expires_date;
        $expiretime = $request->flash_end_time;
        $expire_date = str_replace('/','-',$expiredate.' '.$expiretime);
        $flash_expires_date = strtotime($expire_date);


        if($flash_start_date > $flash_expires_date){
            $request->session()->flash('message.level', 'danger');
            $request->session()->flash('message.content', 'Flash sale start date can not be greater then expiry date');
            return redirect()->back();
        }
        
        $title = array('pageTitle' => Lang::get("labels.AddAttributes"));
        $language_id = '1';
        $products_id = $this->products->insert($request);
        $result['data'] = array('products_id' => $products_id, 'language_id' => $language_id);
        $alertSetting = $this->myVaralter->newProductNotification($products_id);
        
        return redirect('admin/products/display');
    }

    public function addinventory(Request $request)
    {
        $title = array('pageTitle' => Lang::get("labels.ProductInventory"));
        $id = $request->id;
        $result = $this->products->addinventory($id);
        
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.products.inventory.add", $title)->with('result', $result);

    }

    public function ajax_min_max($id)
    {
        $title = array('pageTitle' => Lang::get("labels.ProductInventory"));
        $result = $this->products->ajax_min_max($id);
        return $result;

    }

    public function insert_ajax(Request $request){

        $startdate = strtotime($request->flash_start_date);
        $expiredate = strtotime($request->flash_expires_date);
        $startdate = $request->flash_start_date;
        $starttime = $request->flash_start_time;
        $start_date = str_replace('/','-',$startdate.' '.$starttime);
        $flash_start_date = strtotime($start_date);
        $expiredate = $request->flash_expires_date;
        $expiretime = $request->flash_end_time;
        $expire_date = str_replace('/','-',$expiredate.' '.$expiretime);
        $flash_expires_date = strtotime($expire_date);


        if($flash_start_date > $flash_expires_date){
            $request->session()->flash('message.level', 'danger');
            $request->session()->flash('message.content', 'Flash sale start date can not be greater then expiry date');
            return redirect()->back();
        }
        
        $title = array('pageTitle' => Lang::get("labels.AddAttributes"));
        $language_id = '1';
        return $this->products->insert_ajax($request);
        $result['data'] = array('products_id' => $products_id, 'language_id' => $language_id);
        $alertSetting = $this->myVaralter->newProductNotification($products_id);
        
        return redirect('admin/products/display');

    }

    public function ajax_attr($id)
    {
        $title = array('pageTitle' => Lang::get("labels.ProductInventory"));
        $result = $this->products->ajax_attr($id);
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.products.inventory.attribute_div")->with('result', $result);

    }
    
    public function ajax_attr_inventory($id){
        $result = $this->products->ajax_attr($id);
        return $result;
    }
    
    public function addinventoryfromsidebar(Request $request)
    {
        $title = array('pageTitle' => Lang::get("labels.ProductInventory"));
        $result['products'] = DB::table('products')
            ->leftJoin('products_description', 'products_description.products_id', '=', 'products.products_id')
            ->where('products_description.language_id', 1)
            ->get();

        $result['commonContent'] = $this->Setting->commonContent();

        return view("admin.products.inventory.add2", $title)->with('result', $result);

    }

    public function addnewstock(Request $request)
    {

        //dd($request->all());

        DB::beginTransaction();

        try{

            \Tinify\setKey(env("TINIFY_API_KEY"));
       
            DB::table('products')->where('products_id', $request->products_id)->update([
                'products_in_stock' => $request->stock,
                'products_min_stock' => $request->min_level,
                'products_max_stock' => $request->max_level,
                'products_min_order' => $request->products_min_order,
                'expire_date' => date('Y-m-d', strtotime(str_replace('/', '-', $request->expire_date))),
            ]);

            if($request->hasFile('p_main_img')){
                DB::table('product_images_cloud')->where('product_id', $request->products_id)->where('image_no', 0)->delete();

                $file_name = date('m-d-Y_H:i:s') . '_'. $request->file('p_main_img')->getClientOriginalName();
                $source = \Tinify\fromFile($request->file('p_main_img'));
                $this->s3_credential['path'] = env('S3_BUCKET_NAME'). '/product-images'. '/' . $file_name;
                $source->store($this->s3_credential);

                DB::table('product_images_cloud')->insert([
                    'product_id' => $request->products_id,
                    'url' => 'http://'.env('S3_BUCKET_NAME') . '.s3.' . env('S3_REGION') . '.amazonaws.com/product-images/' . $file_name,
                    'image_no' => 0,
                ]);
            }
            
            if($request->hasFile('p_sub_image_1')){

                DB::table('product_images_cloud')->where('product_id', $request->products_id)->where('image_no', 1)->delete();

                $file_name = date('m-d-Y_H:i:s') . '_'. $request->file('p_sub_image_1')->getClientOriginalName();
                $source = \Tinify\fromFile($request->file('p_sub_image_1'));
                $this->s3_credential['path'] = env('S3_BUCKET_NAME'). '/product-images'. '/' . $file_name;
                $source->store($this->s3_credential);

                DB::table('product_images_cloud')->insert([
                    'product_id' => $request->products_id,
                    'url' => 'http://'.env('S3_BUCKET_NAME') . '.s3.' . env('S3_REGION') . '.amazonaws.com/product-images/' . $file_name,
                    'image_no' => 1,
                ]);
            }
            
            if($request->hasFile('p_sub_image_2')){

                DB::table('product_images_cloud')->where('product_id', $request->products_id)->where('image_no', 2)->delete();

                $file_name = date('m-d-Y_H:i:s') . '_'. $request->file('p_sub_image_2')->getClientOriginalName();
                $source = \Tinify\fromFile($request->file('p_sub_image_2'));
                $this->s3_credential['path'] = env('S3_BUCKET_NAME'). '/product-images'. '/' . $file_name;
                $source->store($this->s3_credential);

                DB::table('product_images_cloud')->insert([
                    'product_id' => $request->products_id,
                    'url' => 'http://'.env('S3_BUCKET_NAME') . '.s3.' . env('S3_REGION') . '.amazonaws.com/product-images/' . $file_name,
                    'image_no' => 2,
                ]);
            }
            
            if($request->hasFile('p_sub_image_3')){
                DB::table('product_images_cloud')->where('product_id', $request->products_id)->where('image_no', 3)->delete();

                $file_name = date('m-d-Y_H:i:s') . '_'. $request->file('p_sub_image_3')->getClientOriginalName();
                $source = \Tinify\fromFile($request->file('p_sub_image_3'));
                $this->s3_credential['path'] = env('S3_BUCKET_NAME'). '/product-images'. '/' . $file_name;
                $source->store($this->s3_credential);

                DB::table('product_images_cloud')->insert([
                    'product_id' => $request->products_id,
                    'url' => 'http://'.env('S3_BUCKET_NAME') . '.s3.' . env('S3_REGION') . '.amazonaws.com/product-images/' . $file_name,
                    'image_no' => 3,
                ]);

            }

            DB::commit();
        }
        catch (\Exception $e) {
            DB::rollback();

            return $e->getMessage();

        }
        
        return redirect()->back();

    }
    
    public function get_single_product($id){
        $p = DB::table('products')->where('products_id', $id)->first();
        
        $p_img = DB::table('product_images_cloud')->where('product_id', $id)->get();

        $images[0] = null;
        $images[1] = null;
        $images[2] = null;
        
        $p->main_image = $p_img->where('image_no', 0)->first() != null ? $p_img->where('image_no', 0)->first()->url : '';

        $images[0] = $p_img->where('image_no', 1)->first() != null ? $p_img->where('image_no', 1)->first()->url : '';
        $images[1] = $p_img->where('image_no', 2)->first() != null ? $p_img->where('image_no', 2)->first()->url : '';
        $images[2] = $p_img->where('image_no', 3)->first() != null ? $p_img->where('image_no', 3)->first()->url : '';
        $p->sub_images = $images;

        return response()->json($p);
    }

    public function addminmax(Request $request)
    {

       //dd($request);
       $this->products->addminmax($request);
       return redirect()->back()->withErrors([Lang::get("labels.Min max level added successfully")]);

    }

    public function displayProductImages(Request $request)
    {

        $title = array('pageTitle' => Lang::get("labels.AddImages"));
        $products_id = $request->id;
        $result = $this->products->displayProductImages($request);
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.products/images/index", $title)->with('result', $result)->with('products_id', $products_id);

    }

    public function addProductImages($products_id)
    {
        $title = array('pageTitle' => Lang::get("labels.AddImages"));
        $allimage = $this->images->getimages();
        $result = $this->products->addProductImages($products_id);
        $result['commonContent'] = $this->Setting->commonContent();
        return view('admin.products.images.add', $title)->with('result', $result)->with('products_id', $products_id)->with('allimage', $allimage);

    }

    public function insertProductImages(Request $request)
    {
        $product_id = $this->products->insertProductImages($request);
        return redirect()->back()->with('product_id', $product_id);
    }

    public function editProductImages($id)
    {

        $allimage = $this->images->getimages();
        $products_images = $this->products->editProductImages($id);
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin/products/images/edit")->with('result', $result)->with('products_images', $products_images)->with('allimage', $allimage);

    }

    public function updateproductimage(Request $request)
    {

        $title = array('pageTitle' => Lang::get("labels.Manage Values"));
        $result = $this->products->updateproductimage($request);
        return redirect()->back();

    }

    public function deleteproductimagemodal(Request $request)
    {

        $products_id = $request->products_id;
        $id = $request->id;
        $result['data'] = array('products_id' => $products_id, 'id' => $id);
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin/products/images/modal/delete")->with('result', $result);

    }

    public function deleteproductimage(Request $request)
    {
        $this->products->deleteproductimage($request);
        return redirect()->back()->with('success', trans('labels.DeletedSuccessfully'));

    }

    public function addproductattribute(Request $request)
    {
        $title = array('pageTitle' => Lang::get("labels.AddAttributes"));
        $result = $this->products->addproductattribute($request);
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.products.attribute.add", $title)->with('result', $result);
    }

    public function addnewdefaultattribute(Request $request)
    {
        $products_attributes = $this->products->addnewdefaultattribute($request);
        return ($products_attributes);
    }

    public function editdefaultattribute(Request $request)
    {
        $result = $this->products->editdefaultattribute($request);
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin/products/pop_up_forms/editdefaultattributeform")->with('result', $result);
    }

    public function updatedefaultattribute(Request $request)
    {
        $products_attributes = $this->products->updatedefaultattribute($request);
        return ($products_attributes);

    }

    public function deletedefaultattributemodal(Request $request)
    {

        $products_id = $request->products_id;
        $products_attributes_id = $request->products_attributes_id;
        $result['data'] = array('products_id' => $products_id, 'products_attributes_id' => $products_attributes_id);
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin/products/modals/deletedefaultattributemodal")->with('result', $result);

    }

    public function deletedefaultattribute(Request $request)
    {
        $products_attributes = $this->products->deletedefaultattribute($request);
        return ($products_attributes);
    }

    public function showoptions(Request $request)
    {
        $products_attributes = $this->products->showoptions($request);
        return ($products_attributes);
    }

    public function editoptionform(Request $request)
    {
        $result = $this->products->editoptionform($request);
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin/products/pop_up_forms/editproductattributeoptionform")->with('result', $result);

    }

    public function updateoption(Request $request)
    {
        $products_attributes = $this->products->updateoption($request);
        return ($products_attributes);
    }

    public function showdeletemodal(Request $request)
    {

        $products_id = $request->products_id;
        $products_attributes_id = $request->products_attributes_id;
        $result['data'] = array('products_id' => $products_id, 'products_attributes_id' => $products_attributes_id);
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin/products/modals/deleteproductattributemodal")->with('result', $result);

    }

    public function deleteoption(Request $request)
    {

        $products_attributes = $this->products->deleteoption($request);
        return ($products_attributes);

    }

    public function getOptionsValue(Request $request)
    {
        $value = $this->products->getOptionsValue($request);
        if (count($value) > 0) {
            foreach ($value as $value_data) {
                $value_name[] = "<option value='" . $value_data->products_options_values_id . "'>" . $value_data->options_values_name . "</option>";
            }
        } else {
            $value_name = "<option value=''>" . Lang::get("labels.ChooseValue") . "</option>";
        }
        print_r($value_name);
    }

    public function currentstock(Request $request)
    {

        $result = $this->products->currentstock($request);
        print_r(json_encode($result));

    }

}
