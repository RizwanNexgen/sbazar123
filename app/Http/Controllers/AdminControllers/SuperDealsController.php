<?php

namespace App\Http\Controllers\AdminControllers;

use App\Models\Core\Languages;
use App\Models\Core\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Exception;
use App\Models\Core\Images;
use App\Models\Core\SuperDeals;
use App\Models\Core\SuperDealsProduct;

class SuperDealsController extends Controller
{

    public function __construct(Setting $setting, Images $images)
    {
        $this->Setting = $setting;
        $this->images = $images;
        $this->myVarsetting = new SiteSettingController($setting);
    }

    public function display(Request $request)
    {
        
        $data = [];
        $data['allimage'] = $this->images->getimages();       

        $data['result']['commonContent'] = $this->Setting->commonContent();
    
        $data['result']['languages'] = $languages = $this->myVarsetting->getLanguages();
                       
        $list = SuperDeals::first();
        $list->image_category = DB::table('image_categories')->where('image_id', $list->bg_image_id)->first();
        
        //dd($list);

        $query = DB::table('super_deals_products');
        $query->select('super_deals_products.new_product_price', 'super_deals_products.new_point', 'products.*', 'products_description.products_name', 'image_categories.path');
        $query->leftJoin('products', 'products.products_id', '=', 'super_deals_products.product_id');
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
        $list->products = $query->get();

        $data['list'] = $list;

        $data['result']['commonContent'] = $this->Setting->commonContent();
        //dd($data);
        return view("admin.super_deals.index", $data); 
    }
 
    public function update_super_deals(Request $request)
    {
        
        //dd($request->all());
    
        if ($request->isMethod('post'))
        {   
    
            $super_deals = SuperDeals::find(1);
            if($request->bg_image_id != null){
                $super_deals->bg_image_id = $request->bg_image_id;
            }
            $super_deals->cap_amount = $request->cap_amount;
            $super_deals->status = $request->status;
            $super_deals->type = $request->type;
            $super_deals->update();
            
            foreach($request->product_id as $key => $pid){
                if($request->type == 'price'){
                    SuperDealsProduct::where('product_id', $pid)->update(['new_product_price' => $request->product_ss[$key], 'new_point' => '']);
                }
                else{
                    SuperDealsProduct::where('product_id', $pid)->update(['new_point' => $request->product_ss[$key], 'new_product_price' => '']);
                }
            }
            
            return redirect('admin/super-deals/display')->with('update', 'Record updated successfully');
        }
    }
    
    public function products(Request $request)
    {
        $data = [];
    
        $data['allimage'] = $this->images->getimages();       
    
        $data['result']['commonContent'] = $this->Setting->commonContent();
    
        $data['result']['languages'] = $languages = $this->myVarsetting->getLanguages();
        
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
        $query->whereNotIn('products.products_id', function ($query) {
            $query->select('product_id')
                    ->from('super_deals_products');
        });                  
        $data['list'] = $query->get();
        
        return view("admin.super_deals.products", $data);
    }
    
    
    public function search_products(Request $request)
    {
        $q = $request->q;
    
        if(strlen($q)>0)
        {
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
            $query->whereNotIn('products.products_id', function ($query) {
                $query->select('product_id')
                      ->from('super_deals_products');
            });    
            $query->where(function ($query) use ($q) {
                $query->where('products_description.products_name', 'like', '%'.$q.'%')
                      ->orWhere('products.products_sku', 'like', '%'.$q.'%')
                      ->orWhere('products.products_id', $q);        
            });        
            $products = $query->get();
        }
        else
        {
            $products = [];
        }
    
        return response()->json($products);   
    }
    
    public function add_product(Request $request)
    {
        $product_id = $request->product_id;
        
        $count = SuperDealsProduct::where('product_id', $product_id)->count();
    
        if($count==0)
        {
            $super_deals_product = new SuperDealsProduct;
            $super_deals_product->product_id = $product_id;
            $super_deals_product->save();
    
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
            $query->where('products.products_id', $product_id);    
            $query->where('products_description.language_id', 1);                            
            $product = $query->first();
    
            $response = ['product'=>$product, 'error'=>'N'];
        }
        else 
        {
            $response = ['error'=>'Y', 'error_msg'=>'Product already added'];
        }
    
        return response()->json($response);   
    }
    
    public function remove_product($product_id, Request $request)
    {
        
        $count = SuperDealsProduct::where('product_id', $product_id)->count();
    
        if($count>0)
        {
            DB::table('super_deals_products')->where('product_id', $product_id)->delete();
        }
        
        return back();
    }

}
