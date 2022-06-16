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
use App\Models\Core\FlashDeals;
use App\Models\Core\FlashDealsProduct;

class FlashDealsController extends Controller
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
                       
        $list = DB::table('flash_deals')->first();
        
        //dd($list);

        $query = DB::table('flash_deals_products');
        $query->select('flash_deals_products.new_product_price', 'products.*', 'products_description.products_name', 'image_categories.path');
        $query->leftJoin('products', 'products.products_id', '=', 'flash_deals_products.product_id');
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
        //dd($query->get());
        $list->products = $query->get();

        $data['list'] = $list;

        $data['result']['commonContent'] = $this->Setting->commonContent();
        //dd($data);
        return view("admin.flash_deals.index", $data); 
    }
 
    public function update_flash_deals(Request $request)
    {
        //dd(\Carbon\Carbon::parse($request->flash_end_date)->format('Y-m-d'));

        $s = str_replace('/', '-', $request->flash_start_date);
        $e = str_replace('/', '-', $request->flash_end_date);
        
        //dd(date('Y-m-d', strtotime($s)) .' '.date("H:i:s", strtotime($request->flash_end_time)));
    
        if ($request->isMethod('post'))
        {
    
            DB::table('flash_deals')->update([
                'start_time' => date('Y-m-d', strtotime($s)) .' '. date("H:i:s", strtotime($request->flash_start_time)),
                'end_time' => date('Y-m-d', strtotime($e)) .' '.date("H:i:s", strtotime($request->flash_end_time)),
                'status' => $request->status,
            ]);
            
            foreach($request->product_id as $key => $pid){
                DB::table('flash_deals_products')->where('product_id', $pid)->update(['new_product_price' => $request->product_ss[$key]]);
            }
            
            return redirect('admin/flash-deals/display')->with('update', 'Record updated successfully');
        }
    }
    
    public function products(Request $request)
    {
        $data = [];   
    
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
                    ->from('flash_deals_products');
        });                  
        $data['list'] = $query->get();
        
        return view("admin.flash_deals.products", $data);
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
                      ->from('flash_deals_products');
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
        
        $count = DB::table('flash_deals_products')->where('product_id', $product_id)->count();
    
        if($count==0)
        {
            DB::table('flash_deals_products')->insert([
                'product_id' => $product_id
            ]);
    
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
        
        $count = DB::table('flash_deals_products')->where('product_id', $product_id)->count();
    
        if($count>0)
        {
            DB::table('flash_deals_products')->where('product_id', $product_id)->delete();
        }
        
        return back();
    }

}
