<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\Core\Images;
use App\Models\Core\Languages;
use App\Models\Core\Hotcats;
use App\Models\Core\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

class HotController extends Controller
{

    public function __construct(Hotcats $hotcat, Languages $language, Images $images, Setting $setting)
    {
        $this->hotcats = $hotcat;
        $this->language = $language;
        $this->images = $images;
        $this->Setting = $setting;
        $this->myVarsetting = new SiteSettingController($setting);
    }

    public function display()
    {
        $title = array('pageTitle' => Lang::get("labels.Hotcat"));
        $hotcats = $this->hotcats->paginator(20);        
        $result['commonContent'] = $this->Setting->commonContent();
     // dd($hotcats);
        return view("admin.hotcats.index")->with('hotcats', $hotcats)->with('result', $result);
    }

    public function add(Request $request)
    {
        $allimage = $this->images->getimages();
        $title = array('pageTitle' => Lang::get("labels.AddHotcat"));
        $result['commonContent'] = $this->Setting->commonContent();
        $result['languages'] = $this->myVarsetting->getLanguages();
        return view("admin.hotcats.add", $title)->with('allimage', $allimage)->with('result', $result);
    }

    public function insert(Request $request)
    {
        $title = array('pageTitle' => Lang::get("labels.AddHotcat"));
        $this->hotcats->insert($request);
        return redirect()->back()->with('update', 'Content has been created successfully!');
    }

    public function edit(Request $request)
    {
        $title = array('pageTitle' => Lang::get("labels.EditHotcats"));
        $hotcats_id = $request->id;
        $editHotcat = $this->hotcats->edit($hotcats_id);
        $allimage = $this->images->getimages();        
        $result['commonContent'] = $this->Setting->commonContent();
        $result['languages'] = $this->myVarsetting->getLanguages();
        return view("admin.hotcats.edit", $title)->with('result', $result)->with('editHotcat', $editHotcat)->with('allimage', $allimage);
    }

    public function update(Request $request)
    {
        $messages = 'update is not successfull';
        $title = array('pageTitle' => Lang::get("labels.EditHotcats"));
        $this->validate($request, [
            'id' => 'required',
            //'oldImage' => 'required',
            'old_slug' => 'required',
            'slug' => 'required',
            'name' => 'required',
           // 'hotcats_url' => 'required',

        ]);
        $this->hotcats->updaterecord($request);
        return redirect()->back()->with('update', 'Content has been created successfully!');

    }

    //delete Hotcats
    public function delete(Request $request)
    {

        $this->hotcats->destroyrecord($request);
        return redirect()->back()->withErrors([Lang::get("labels.hotcatsDeletedMessage")]);
    }

    public function filter(Request $request)
    {

        $name = $request->FilterBy;
        $param = $request->parameter;
        $title = array('pageTitle' => Lang::get("labels.Hotcats"));
        $hotcats = $this->hotcats->filter($name, $param);
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.hotcats.index", $title)->with('result', $result)->with('hotcats', $hotcats)->with('name', $name)->with('param', $param);
    }

}
