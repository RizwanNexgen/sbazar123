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
use App\Models\Core\FaqCat;

class FaqCatController extends Controller
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
                       
        $list = DB::table('faq_cat')
        ->paginate(10);

        $data['list'] = $list;

        $data['result']['commonContent'] = $this->Setting->commonContent();

        return view("admin.faq_cat.index", $data); 
    }
 
    public function add(Request $request)
    {
        $data = [];       

        $data['result']['commonContent'] = $this->Setting->commonContent();

        $data['result']['languages'] = $languages = $this->myVarsetting->getLanguages();

        if ($request->isMethod('post'))
        {   

            DB::table('faq_cat')->insert([
                'name' => $request->name,
            ]);

            return redirect('admin/faq-cat/display')->with('update', 'Record inserted successfully');
        }
        
        return view("admin.faq_cat.add", $data);
    }

    public function edit($id, Request $request)
    {
        $data = [];

        $data['info'] = DB::table('faq_cat')->where('id', $id)->first();   

        $data['result']['commonContent'] = $this->Setting->commonContent();

        $data['result']['languages'] = $languages = $this->myVarsetting->getLanguages();

        if ($request->isMethod('post'))
        {
            DB::table('faq_cat')->where('id', $id)->update([
                'name' => $request->name,
            ]);

            return redirect('admin/faq-cat/display')->with('update', 'Record updated successfully');
        }
        
        return view("admin.faq_cat.edit", $data);
    }

    public function delete($id, Request $request)
    {

        DB::table('faq_cat')->where('id', $id)->delete();

        return redirect('admin/faq-cat/display');
    }

}
