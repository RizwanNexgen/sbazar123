<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\Core\Images;
use App\Models\Core\Languages;
use App\Models\Core\Manufacturers;
use App\Models\Core\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use DB;

class ManufacturerController extends Controller
{

    public function __construct(Manufacturers $manufacturer, Languages $language, Images $images, Setting $setting)
    {
        $this->manufacturers = $manufacturer;
        $this->language = $language;
        $this->images = $images;
        $this->Setting = $setting;
        $this->myVarsetting = new SiteSettingController($setting);
    }

    public function display()
    {
        $manufacturers = $this->manufacturers->paginator(20);

        foreach($manufacturers as $i=>$o)
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
            $query->where('products.manufacturers_id', $o->id);
            $query->where('products.products_in_stock', '>', 0);
            $query->where('products_description.language_id', 1);
            $manufacturers[$i]->products = $query->get();
            $manufacturers[$i]->total_products = count($manufacturers[$i]->products);
        }

        $result['commonContent'] = $this->Setting->commonContent();

        return view("admin.manufacturers.index")->with('manufacturers', $manufacturers)->with('result', $result);
    }

    public function add(Request $request)
    {
        $allimage = $this->images->getimages();
        $title = array('pageTitle' => Lang::get("labels.AddManufacturer"));
        $result['commonContent'] = $this->Setting->commonContent();
        $result['languages'] = $this->myVarsetting->getLanguages();
        return view("admin.manufacturers.add", $title)->with('allimage', $allimage)->with('result', $result);
    }

    public function insert(Request $request)
    {
        $title = array('pageTitle' => Lang::get("labels.AddManufacturer"));
        $this->manufacturers->insert($request);
        return redirect()->back()->with('update', 'Content has been created successfully!');
    }

    public function edit(Request $request)
    {
        
        
        $title = array('pageTitle' => Lang::get("labels.EditManufacturers"));
        $manufacturers_id = $request->id;
        //dd($request->id);
        $editManufacturer = $this->manufacturers->edit($manufacturers_id);
        //dd($editManufacturer);
        $allimage = $this->images->getimages();        
        $result['commonContent'] = $this->Setting->commonContent();
        $result['languages'] = $this->myVarsetting->getLanguages();
        
        //dd($result, $editManufacturer);
        
        return view("admin.manufacturers.edit", $title)->with('result', $result)->with('editManufacturer', $editManufacturer)->with('allimage', $allimage);
    }

    public function update(Request $request)
    {
        $messages = 'update is not successfull';
        $title = array('pageTitle' => Lang::get("labels.EditManufacturers"));
        $this->validate($request, [
            'id' => 'required',
            //'oldImage' => 'required',
            'old_slug' => 'required',
            'slug' => 'required',
            'name' => 'required',
           // 'manufacturers_url' => 'required',

        ]);
        $this->manufacturers->updaterecord($request);
        return redirect()->back()->with('update', 'Content has been created successfully!');

    }

    //delete Manufacturers
    public function delete(Request $request)
    {

        $this->manufacturers->destroyrecord($request);
        return redirect()->back()->withErrors([Lang::get("labels.manufacturersDeletedMessage")]);
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
