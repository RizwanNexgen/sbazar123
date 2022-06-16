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
use App\Models\Core\AppMenus;
use Illuminate\Support\Facades\Validator;

class AppMenuController extends Controller
{
  public function __construct(Setting $setting)
  {    
    $this->Setting = $setting;
    $this->myVarsetting = new SiteSettingController($setting);
  }

  public function display(){
    $data = [];
    $data['pageTitle'] = 'Menubar'; 

    $data['list'] = DB::table('app_menus')
    ->select('app_menus.*', 'app_menus_langs.title')
    ->leftJoin('app_menus_langs', 'app_menus_langs.app_menu_id', '=', 'app_menus.id')    
    ->where('app_menus_langs.language_id', 1)
    ->orderBy('app_menus.id', 'ASC')
    ->paginate(10);

    $result['commonContent'] = $this->Setting->commonContent();
    
    return view("admin.app_menus.index", $data)->with('result', $result);
  }
  

    public function add(Request $request)
    {
        $data = [];
        $data['pageTitle'] = 'Add New Menu';        
        $result['commonContent'] = $this->Setting->commonContent();
        $result['languages'] = $this->myVarsetting->getLanguages();

        if ($request->isMethod('post')) 
        {
            $validator = Validator::make($request->all(), [
                'title_1' => 'required',
                'photo' => 'nullable|image|max:2000|dimensions:min_width=50,min_height=50,max_width=2000,max_height=2000',                                              
                'url' => 'nullable|url|max:150'
            ]); 

            if ($validator->fails()) {
                return redirect()
                        ->back()
                        ->withErrors($validator)
                        ->withInput();
            }

            $AppMenus = new AppMenus;
            $AppMenus->url = $request->url;
            $AppMenus->menu_type = $request->menu_type;  
            if($request->menu_type=='Main')
            {
                if($request->hasFile('photo')) 
                {
                    $file = $request->file('photo');
                    $path = $file->store('public/app/backgrounds');
                    $AppMenus->bg_image = $file->hashName();        
                }  
            }    
            elseif($request->menu_type=='Bottom')
            {
                if($request->hasFile('photo')) 
                {
                    $file = $request->file('photo');
                    $path = $file->store('public/app/icons');
                    $AppMenus->icon = $file->hashName();        
                }  
            }                     
                                    
            $AppMenus->save();
            $app_menu_id = $AppMenus->id;

            foreach($result['languages'] as $key=>$languages)
            {
                $title = 'title_'.$languages->languages_id;
                $request_title = $request->$title;

                DB::table('app_menus_langs')->insert([
                    'app_menu_id' => $app_menu_id,
                    'language_id' => $languages->languages_id,
                    'title' => $request_title
                ]);
            }

            return redirect('admin/appmenus/display');
        }

        return view("admin.app_menus.add", $data)->with('result', $result);
    }

    public function edit($id, Request $request)
    {
        $data = [];
        $data['pageTitle'] = 'Edit Menu';        
        $result['commonContent'] = $this->Setting->commonContent();
        $result['languages'] = $this->myVarsetting->getLanguages();

        $data['info'] = AppMenus::find($id);
        $menu_langs = DB::table('app_menus_langs')->where('app_menu_id', $id)->get();

        $app_menus_langs = [];
        foreach($menu_langs as $o)
        {
            $app_menus_langs[$o->language_id] = $o;
        }
        $data['app_menus_langs'] = $app_menus_langs;

        if ($request->isMethod('post')) 
        {
            $validator = Validator::make($request->all(), [
                'title_1' => 'required',
                'photo' => 'nullable|image|max:2000|dimensions:min_width=50,min_height=50,max_width=2000,max_height=2000',                                              
                'url' => 'nullable|url|max:150'
            ]); 

            if ($validator->fails()) {
                return redirect()
                        ->back()
                        ->withErrors($validator)
                        ->withInput();
            }

            $AppMenus = AppMenus::find($id);
            $AppMenus->url = $request->url;
            $AppMenus->menu_type = $request->menu_type;  
            if($request->menu_type=='Main')
            {
                if($request->hasFile('photo')) 
                {
                    $file = $request->file('photo');
                    $path = $file->store('public/app/backgrounds');
                    $AppMenus->bg_image = $file->hashName();  
                    $AppMenus->icon = '';      
                }  
            }    
            elseif($request->menu_type=='Bottom')
            {
                if($request->hasFile('photo')) 
                {
                    $file = $request->file('photo');
                    $path = $file->store('public/app/icons');
                    $AppMenus->icon = $file->hashName();   
                    $AppMenus->bg_image = '';      
                }  
            }                         
            $AppMenus->save();

            foreach($result['languages'] as $key=>$languages)
            {
                
                $title = 'title_'.$languages->languages_id;
                $request_title = $request->$title;

                if(!empty($app_menus_langs[$languages->languages_id]))
                {
                    DB::table('app_menus_langs')
                    ->where('app_menu_id', $id)
                    ->where('language_id', $languages->languages_id)
                    ->update([                                                
                        'title' => $request_title
                    ]);
                }
                else
                {
                    DB::table('app_menus_langs')->insert([
                        'app_menu_id' => $id,
                        'language_id' => $languages->languages_id,
                        'title' => $request_title
                    ]);
                }

            }

            return redirect('admin/appmenus/display');
        }

        return view("admin.app_menus.edit", $data)->with('result', $result);
    }

  

  public function delete($id, Request $request){
      AppMenus::destroy($id);
      DB::table('app_menus_langs')->where('app_menu_id', $id)->delete();
      $message = Lang::get("Menu Deleted Successfully");
      return redirect()->back()->withErrors([$message]);
  }
}
