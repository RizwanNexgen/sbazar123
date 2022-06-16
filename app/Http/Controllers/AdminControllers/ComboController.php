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
use App\Models\Core\Combo;
use App\Models\Core\ComboProduct;

class ComboController extends Controller
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
                       
        $list = Combo::paginate(10);                    

        foreach($list as $i=>$o)
        {
            $query = DB::table('combos_products');
            $query->select('combos_products.combo_product_id', 'combos_products.quantity', 'products.*', 'products_description.products_name', 'image_categories.path');
            $query->leftJoin('products', 'products.products_id', '=', 'combos_products.product_id');
            $query->leftJoin('products_description', 'products_description.products_id', '=', 'products.products_id');
            $query->LeftJoin('image_categories', function ($join) {
                $join->on('image_categories.image_id', '=', 'products.products_image')
                    ->where(function ($query) {
                        $query->where('image_categories.image_type', '=', 'THUMBNAIL')
                            ->where('image_categories.image_type', '!=', 'THUMBNAIL')
                            ->orWhere('image_categories.image_type', '=', 'ACTUAL');
                    });
            });
            $query->where('combos_products.combo_id', $o->id);
            $query->where('products.products_in_stock', '>', 0);
            $query->where('products_description.language_id', 1);
            $list[$i]->products = $query->get();
        }    

        $data['list'] = $list;

        $data['result']['commonContent'] = $this->Setting->commonContent();

        return view("admin.combos.index", $data); 
    }
 
    public function add(Request $request)
    {
        $data = [];

        $data['allimage'] = $this->images->getimages();       

        $data['result']['commonContent'] = $this->Setting->commonContent();

        $data['result']['languages'] = $languages = $this->myVarsetting->getLanguages();
        
        $data['user_level_types'] = $user_level_types = DB::table('memberships')->get();

        if ($request->isMethod('post'))
        {
            /*$validatedData = $request->validate([                                
                'discount' => 'nullable|numeric|min:1|max:100',
                'expire_date' => 'nullable|date',  
                'image_id' => 'required',                                                 
            ]);*/    

            $combo = new Combo;
            $combo->bg_image_id = $request->image_id;
            $combo->discount = $request->discount;
            $combo->has_msd = $request->has_msd;
            $combo->status = $request->status; 
            $combo->save();

            foreach($languages as $o)
            {
                $title_field = 'combo_title_'.$o->languages_id;
                $combo_title = $request->$title_field;

                $tos_field = 'combo_tos_'.$o->languages_id;
                $combo_tos = $request->$tos_field;

                DB::table('combos_info')->insert([
                    'combo_id' => $combo->id,
                    'language_id' => $o->languages_id,
                    'combo_title' => $combo_title,
                    'combo_tos' => $combo_tos
                ]);
            }

            foreach($user_level_types as $level)
            {
                $level_discount_field = 'level_discount_'.$level->membership_id;
                $level_discount = $request->$level_discount_field;

                DB::table('combos_msd')->insert([
                    'combo_id' => $combo->id,
                    'membership_id' => $level->membership_id,
                    'discount' => $level_discount
                ]);
            }

            return redirect('admin/combos/display')->with('update', 'Record inserted successfully');
        }
        
        return view("admin.combos.add", $data);
    }

    public function edit($id, Request $request)
    {
        $data = [];

        $data['info'] = Combo::find($id);

        $data['combos_msd'] = DB::table('combos_msd')
        ->select('combos_msd.*', 'memberships.membership_name')
        ->leftJoin('memberships', 'memberships.membership_id', '=', 'combos_msd.membership_id')
        ->where('combo_id', $id)
        ->get();

        $data['combos_info'] = DB::table('combos_info')
        ->select('combos_info.*', 'languages.name')
        ->leftJoin('languages', 'languages.languages_id', '=', 'combos_info.language_id')
        ->where('combo_id', $id)        
        ->get();

        $data['allimage'] = $this->images->getimages();       

        $data['result']['commonContent'] = $this->Setting->commonContent();

        $data['result']['languages'] = $languages = $this->myVarsetting->getLanguages();
        
        $data['user_level_types'] = $user_level_types = DB::table('memberships')->get();

        if ($request->isMethod('post'))
        {
            /*$validatedData = $request->validate([                                
                'discount' => 'nullable|numeric|min:1|max:100',
                'expire_date' => 'nullable|date',  
                'image_id' => 'required',                                                 
            ]);*/    

            $combo = Combo::find($id);
            if(!empty($request->image_id))
            {
                $combo->bg_image_id = $request->image_id;
            }
            $combo->discount = $request->discount;
            $combo->has_msd = $request->has_msd;
            $combo->status = $request->status;                
            $combo->save();

            foreach($languages as $o)
            {
                $title_field = 'combo_title_'.$o->languages_id;
                $combo_title = $request->$title_field;

                $tos_field = 'combo_tos_'.$o->languages_id;
                $combo_tos = $request->$tos_field;

                DB::table('combos_info')
                ->where('combo_id', $id)
                ->where('language_id', $o->languages_id)
                ->update([                                        
                    'combo_title' => $combo_title,
                    'combo_tos' => $combo_tos
                ]);
            }

            foreach($user_level_types as $level)
            {
                $level_discount_field = 'level_discount_'.$level->membership_id;
                $level_discount = $request->$level_discount_field;

                DB::table('combos_msd')
                ->where('combo_id', $id)
                ->where('membership_id', $level->membership_id)
                ->update([
                    'discount' => $level_discount
                ]);
            }

            return redirect('admin/combos/display')->with('update', 'Record updated successfully');
        }
        
        return view("admin.combos.edit", $data);
    }

    public function update_combo_quantity(Request $request)
    {                
        if($request->quantity>0)
        {
            $update = ComboProduct::find($request->combo_product_id);
            $update->quantity = $request->quantity;
            $update->save();
        }

        return redirect('admin/combos/display');
        
    }
    
    public function delete($id, Request $request)
    {

        $combo = Combo::find($id);
        
        DB::table('combos_info')->where('combo_id', $combo->id)->delete();
        DB::table('combos_products')->where('combo_id', $combo->id)->delete();
        Combo::destroy($combo->id);

        return redirect('admin/combos/display');
    }

    public function delete_combo_product($id, Request $request)
    {        
        ComboProduct::destroy($id);        

        return redirect('admin/combos/display');
    }

    public function filter(Request $request)
    {
        //dd($request->all());
        $data = [];
        $list = [];
        
        $columnName = '';
        if($request->FilterBy == 'Name'){
            $list = Combo::leftJoin('combos_info', 'combos_info.combo_id', '=', 'combos.id')->where('combos_info.combo_title', 'LIKE', '%' . $request->parameter . '%')->groupBy('combos.id')->paginate('10');
        }
        else{
            $list = Combo::paginate('10');
        }

        foreach($list as $i=>$o)
        {
            $query = DB::table('combos_products');
            $query->select('combos_products.combo_product_id', 'combos_products.quantity', 'products.*', 'products_description.products_name', 'image_categories.path');
            $query->leftJoin('products', 'products.products_id', '=', 'combos_products.product_id');
            $query->leftJoin('products_description', 'products_description.products_id', '=', 'products.products_id');
            $query->LeftJoin('image_categories', function ($join) {
                $join->on('image_categories.image_id', '=', 'products.products_image')
                    ->where(function ($query) {
                        $query->where('image_categories.image_type', '=', 'THUMBNAIL')
                            ->where('image_categories.image_type', '!=', 'THUMBNAIL')
                            ->orWhere('image_categories.image_type', '=', 'ACTUAL');
                    });
            });
            $query->where('combos_products.combo_id', $o->id);
            $query->where('products_description.language_id', 1);
            $list[$i]->products = $query->get();
        }    

        $data['list'] = $list;

        $data['result']['commonContent'] = $this->Setting->commonContent();

        return view("admin.combos.index", $data);
        /*$name = $request->FilterBy;
        $param = $request->parameter;
        $title = array('pageTitle' => Lang::get("labels.Manufacturers"));
        $manufacturers = $this->combos->filter($name, $param);
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.manufacturers.index", $title)->with('result', $result)->with('manufacturers', $manufacturers)->with('name', $name)->with('param', $param);*/
    }

}
