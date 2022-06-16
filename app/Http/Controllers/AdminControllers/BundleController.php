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
use App\Models\Core\Bundle;
use App\Models\Core\BundleProduct;

class BundleController extends Controller
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
                       
        $list = Bundle::paginate(10);                    

        foreach($list as $i=>$o)
        {
            $query = DB::table('bundles_products');
            $query->select('bundles_products.bundle_product_id', 'bundles_products.quantity', 'products.*', 'products_description.products_name', 'image_categories.path');
            $query->leftJoin('products', 'products.products_id', '=', 'bundles_products.product_id');
            $query->leftJoin('products_description', 'products_description.products_id', '=', 'products.products_id');
            $query->LeftJoin('image_categories', function ($join) {
                $join->on('image_categories.image_id', '=', 'products.products_image')
                    ->where(function ($query) {
                        $query->where('image_categories.image_type', '=', 'THUMBNAIL')
                            ->where('image_categories.image_type', '!=', 'THUMBNAIL')
                            ->orWhere('image_categories.image_type', '=', 'ACTUAL');
                    });
            });
            $query->where('bundles_products.bundle_id', $o->id);
            $query->where('products.products_in_stock', '>', 0);
            $query->where('products_description.language_id', 1);
            $list[$i]->products = $query->get();
        }    

        $data['list'] = $list;

        $data['result']['commonContent'] = $this->Setting->commonContent();

        return view("admin.bundles.index", $data); 
    }
 
    public function add(Request $request)
    {
        $data = [];

        $data['allimage'] = $this->images->getimages();       

        $data['result']['commonContent'] = $this->Setting->commonContent();

        $data['result']['languages'] = $languages = $this->myVarsetting->getLanguages();
        
        $data['user_level_types'] = $user_level_types = DB::table('user_level_types')->get();

        if ($request->isMethod('post'))
        {
            /*$validatedData = $request->validate([                                
                'discount' => 'nullable|numeric|min:1|max:100',
                'expire_date' => 'nullable|date',  
                'image_id' => 'required',                                                 
            ]);*/    

            $bundle = new Bundle;
            $bundle->bundle_type = $request->bundle_type;
            $bundle->status = $request->status;
            $bundle->bg_image_id = $request->image_id;
            $bundle->discount = $request->discount;
            $bundle->has_msd = $request->has_msd;
            $bundle->points = $request->points;
            $bundle->save();

            foreach($languages as $o)
            {
                $title_field = 'bundle_title_'.$o->languages_id;
                $bundle_title = $request->$title_field;

                $tos_field = 'bundle_tos_'.$o->languages_id;
                $bundle_tos = $request->$tos_field;

                DB::table('bundles_info')->insert([
                    'bundle_id' => $bundle->id,
                    'language_id' => $o->languages_id,
                    'bundle_title' => $bundle_title,
                    'bundle_tos' => $bundle_tos
                ]);
            }

            foreach($user_level_types as $level)
            {
                $level_discount_field = 'level_discount_'.$level->id;
                $level_discount = $request->$level_discount_field;

                DB::table('bundles_msd')->insert([
                    'bundle_id' => $bundle->id,
                    'level_id' => $level->id,
                    'discount' => $level_discount
                ]);
            }

            return redirect('admin/bundles/display')->with('update', 'Record inserted successfully');
        }
        
        return view("admin.bundles.add", $data);
    }

    public function edit($id, Request $request)
    {
        $data = [];

        $data['info'] = Bundle::find($id);

        $data['bundles_msd'] = DB::table('bundles_msd')
        ->select('bundles_msd.*', 'user_level_types.level_title')
        ->leftJoin('user_level_types', 'user_level_types.id', '=', 'bundles_msd.level_id')
        ->where('bundle_id', $id)
        ->get();

        $data['bundles_info'] = DB::table('bundles_info')
        ->select('bundles_info.*', 'languages.name')
        ->leftJoin('languages', 'languages.languages_id', '=', 'bundles_info.language_id')
        ->where('bundle_id', $id)        
        ->get();

        $data['allimage'] = $this->images->getimages();       

        $data['result']['commonContent'] = $this->Setting->commonContent();

        $data['result']['languages'] = $languages = $this->myVarsetting->getLanguages();
        
        $data['user_level_types'] = $user_level_types = DB::table('user_level_types')->get();

        if ($request->isMethod('post'))
        {
            /*$validatedData = $request->validate([                                
                'discount' => 'nullable|numeric|min:1|max:100',
                'expire_date' => 'nullable|date',  
                'image_id' => 'required',                                                 
            ]);*/    
            //dd($request->all());
            
            $bundle = Bundle::find($id);
            if(!empty($request->image_id))
            {
                $bundle->bg_image_id = $request->image_id;
            }
            $bundle->bundle_type = $request->bundle_type;
            $bundle->status = $request->status;
            $bundle->discount = $request->discount;
            $bundle->has_msd = $request->has_msd;
            $bundle->points = $request->points;
            //$bundle->expire_at = $request->expire_date;                
            $bundle->save();

            foreach($languages as $o)
            {
                $title_field = 'bundle_title_'.$o->languages_id;
                $bundle_title = $request->$title_field;

                $tos_field = 'bundle_tos_'.$o->languages_id;
                $bundle_tos = $request->$tos_field;

                DB::table('bundles_info')
                ->where('bundle_id', $id)
                ->where('language_id', $o->languages_id)
                ->update([                                        
                    'bundle_title' => $bundle_title,
                    'bundle_tos' => $bundle_tos
                ]);
            }

            foreach($user_level_types as $level)
            {
                $level_discount_field = 'level_discount_'.$level->id;
                $level_discount = $request->$level_discount_field;

                DB::table('bundles_msd')
                ->where('bundle_id', $id)
                ->where('level_id', $level->id)
                ->update([
                    'discount' => $level_discount
                ]);
            }

            return redirect('admin/bundles/display')->with('update', 'Record updated successfully');
        }
        
        return view("admin.bundles.edit", $data);
    }

    public function update_bundle_quantity(Request $request)
    {                
        if($request->quantity>0)
        {
            $update = BundleProduct::find($request->bundle_product_id);
            $update->quantity = $request->quantity;
            $update->save();
        }

        return redirect('admin/bundles/display');
        
    }
    
    public function delete($id, Request $request)
    {

        $bundle = Bundle::find($id);
        
        DB::table('bundles_info')->where('bundle_id', $bundle->id)->delete();
        DB::table('bundles_products')->where('bundle_id', $bundle->id)->delete();
        Bundle::destroy($bundle->id);

        return redirect('admin/bundles/display');
    }

    public function delete_bundle_product($id, Request $request)
    {        
        BundleProduct::destroy($id);        

        return redirect('admin/bundles/display');
    }

    public function filter(Request $request)
    {

        $name = $request->FilterBy;
        $param = $request->parameter;
        $title = array('pageTitle' => Lang::get("labels.Manufacturers"));
        $manufacturers = $this->manufacturers->filter($name, $param);
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.manufacturers.index", $title)->with('result', $result)->with('manufacturers', $manufacturers)->with('name', $name)->with('param', $param);
    }

}
