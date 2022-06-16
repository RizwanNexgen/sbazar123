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
use App\Models\Core\Faq;

class FaqController extends Controller
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
                       
        $list = DB::table('faq')
        ->select('faq.id', 'faq.question', 'faq.answer', 'faq_cat.name as faq_cat_name')
        ->join('faq_cat', 'faq.cat_id', '=', 'faq_cat.id')
        ->paginate(10);

        $data['list'] = $list;

        $data['result']['commonContent'] = $this->Setting->commonContent();

        return view("admin.faq.index", $data); 
    }
 
    public function add(Request $request)
    {
        $data = [];       

        $data['result']['commonContent'] = $this->Setting->commonContent();

        $data['result']['languages'] = $languages = $this->myVarsetting->getLanguages();

        $data['faq_cat'] = DB::table('faq_cat')->get();

        if ($request->isMethod('post'))
        {   

            DB::table('faq')->insert([
                'cat_id' => $request->faq_cat,
                'question' => $request->question,
                'answer' => $request->answer,
            ]);

            return redirect('admin/faq/display')->with('update', 'Record inserted successfully');
        }
        
        return view("admin.faq.add", $data);
    }

    public function edit($id, Request $request)
    {
        $data = [];

        $data['info'] = DB::table('faq')->where('id', $id)->first();   

        $data['result']['commonContent'] = $this->Setting->commonContent();

        $data['result']['languages'] = $languages = $this->myVarsetting->getLanguages();

        $data['faq_cat'] = DB::table('faq_cat')->get();
        
        if ($request->isMethod('post'))
        {
            DB::table('faq')->where('id', $id)->update([
                'cat_id' => $request->faq_cat,
                'question' => $request->question,
                'answer' => $request->answer,
            ]);

            return redirect('admin/faq/display')->with('update', 'Record updated successfully');
        }
        
        return view("admin.faq.edit", $data);
    }

    public function delete($id, Request $request)
    {

        DB::table('faq')->where('id', $id)->delete();

        return redirect('admin/faq/display');
    }

}
