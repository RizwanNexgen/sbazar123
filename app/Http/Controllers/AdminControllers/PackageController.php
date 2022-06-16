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
use App\Models\Core\Package;
use App\Models\Core\PackageProduct;

class PackageController extends Controller
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
                       
        $list = Package::where('parent_id', NULL)->paginate(10);                    

        
        
        foreach($list as $i=>$o)
        {            
            $child_packages = Package::where('parent_id', $o->id)->get(); 

            foreach($child_packages as $j=>$c)
            {
                $child_packages[$j]->image_category = DB::table('image_categories')->where('image_id', $c->bg_image_id)->first();
            }

            $list[$i]->child_packages = $child_packages;
            
            $list[$i]->image_category = DB::table('image_categories')->where('image_id', $o->bg_image_id)->first();
        }            

        $data['list'] = $list;

        $data['result']['commonContent'] = $this->Setting->commonContent();

        return view("admin.collections.index", $data); 
    }
 
    public function add(Request $request)
    {
        $data = [];

        $data['allimage'] = $this->images->getimages();       

        $data['result']['commonContent'] = $this->Setting->commonContent();

        $data['result']['languages'] = $languages = $this->myVarsetting->getLanguages();                

        if ($request->isMethod('post'))
        {
            /*$validatedData = $request->validate([                                
                'discount' => 'nullable|numeric|min:1|max:100',
                'expire_date' => 'nullable|date',  
                'image_id' => 'required',                                                 
            ]);*/    

            $package = new Package;
            $package->parent_id = $request->parent_id;
            $package->bg_image_id = $request->image_id;
            //$package->start_time = $request->start_time; 
            //$package->end_time = $request->end_time;
            $package->status = $request->status;
            $package->color_code = $request->color_code;
            
            /*if(!empty($request->start_time))
            {                
                $arr = explode('/', $request->start_time);
                $time = strtotime($arr[2].'-'.$arr[1].'-'.$arr[0].' '.date('H:i:s'));
                $package->start_time = date('Y-m-d H:i:s', $time); 
            } 
            if(!empty($request->end_time))
            {                
                $arr = explode('/', $request->end_time);
                $time = strtotime($arr[2].'-'.$arr[1].'-'.$arr[0].' '.date('H:i:s'));
                $package->end_time = date('Y-m-d H:i:s', $time); 
            } */            
            $package->save();

            foreach($languages as $o)
            {
                $title_field = 'package_title_'.$o->languages_id;
                $package_title = $request->$title_field;

                $desc_field = 'package_description_'.$o->languages_id;
                $package_desc = $request->$desc_field;

                DB::table('packages_info')->insert([
                    'package_id' => $package->id,
                    'language_id' => $o->languages_id,
                    'package_title' => $package_title,
                    'package_desc' => $package_desc
                ]);
            }
            

            return redirect('admin/packages/display')->with('update', 'Record inserted successfully');
        }
        
        $data['packages'] = Package::where('parent_id', NULL)->get();  

        return view("admin.collections.add", $data);
    }

    public function edit($id, Request $request)
    {
        
        
        $data = [];

        $data['info'] = Package::find($id);
        
        $data['packages_info'] = DB::table('packages_info')
        ->select('packages_info.*', 'languages.name')
        ->leftJoin('languages', 'languages.languages_id', '=', 'packages_info.language_id')
        ->where('package_id', $id)        
        ->get();

        $data['allimage'] = $this->images->getimages();       

        $data['result']['commonContent'] = $this->Setting->commonContent();

        $data['result']['languages'] = $languages = $this->myVarsetting->getLanguages();
        
        
        if ($request->isMethod('post'))
        {
            /*$validatedData = $request->validate([                                
                'discount' => 'nullable|numeric|min:1|max:100',
                'expire_date' => 'nullable|date',  
                'image_id' => 'required',                                                 
            ]);*/    
            //dd($request->all());
            $package = Package::find($id);
            if(!empty($request->image_id))
            {
                $package->bg_image_id = $request->image_id;
            }
            $package->parent_id = $request->parent_id;
            //$package->start_time = $request->start_time;
            //$package->end_time = $request->end_time;
            $package->status = $request->status;
            $package->color_code = $request->color_code;
            $package->save();

            foreach($languages as $o)
            {
                $title_field = 'package_title_'.$o->languages_id;
                $package_title = $request->$title_field;

                $desc_field = 'package_desc_'.$o->languages_id;
                $package_desc = $request->$desc_field;

                DB::table('packages_info')
                ->where('package_id', $id)
                ->where('language_id', $o->languages_id)
                ->update([                                        
                    'package_title' => $package_title,
                    'package_desc' => $package_desc
                ]);
            }            

            return redirect('admin/packages/edit/'.$id)->with('update', 'Record updated successfully');
        }
        
        $data['packages'] = Package::where('parent_id', NULL)->get(); 

        
        return view("admin.collections.edit", $data);
    }

    
    public function products($id, Request $request)
    {
        $data = [];

        $data['info'] = Package::find($id);
        
        $data['packages_info'] = DB::table('packages_info')
        ->select('packages_info.*', 'languages.name')
        ->leftJoin('languages', 'languages.languages_id', '=', 'packages_info.language_id')
        ->where('package_id', $id)        
        ->get();

        $data['allimage'] = $this->images->getimages();       

        $data['result']['commonContent'] = $this->Setting->commonContent();

        $data['result']['languages'] = $languages = $this->myVarsetting->getLanguages();                

        $query = DB::table('packages_products');
        $query->select('packages_products.id', 'products.*', 'products_description.products_name', 'image_categories.path');
        $query->leftJoin('products', 'products.products_id', '=', 'packages_products.product_id');
        $query->leftJoin('products_description', 'products_description.products_id', '=', 'products.products_id');
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
        $data['products'] = $query->get();
        
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
        $query->whereNotIn('products.products_id', function ($query) use ($id) {
            $query->select('product_id')
                    ->from('packages_products')
                    ->where('package_id', $id);
        });                  
        $data['list'] = $query->get();
        
        return view("admin.collections.products", $data);
    }

    public function delete($id, Request $request)
    {

        $package = Package::find($id);
        
        DB::table('packages_info')->where('package_id', $package->id)->delete();
        DB::table('packages_products')->where('package_id', $package->id)->delete();
        Package::destroy($package->id);

        return redirect('admin/packages/display');
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
            $query->whereNotIn('products.products_id', function ($query) use ($request) {
                $query->select('product_id')
                      ->from('packages_products')
                      ->where('package_id', $request->package_id);
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
        $package_id = $request->package_id;
        
        $count = PackageProduct::where('product_id', $product_id)->where('package_id', $package_id)->count();

        if($count==0)
        {
            $package_product = new PackageProduct;
            $package_product->product_id = $product_id;
            $package_product->package_id = $package_id;
            $package_product->save();

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

    public function remove_product($product_id, $package_id, Request $request)
    {
        
        $count = PackageProduct::where('product_id', $product_id)->where('package_id', $package_id)->count();

        if($count>0)
        {
            DB::table('packages_products')->where('product_id', $product_id)->where('package_id', $package_id)->delete();
        }
        
        return back();
    }

}
