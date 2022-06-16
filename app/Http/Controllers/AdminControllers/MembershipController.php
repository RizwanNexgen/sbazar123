<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\Core\Images;
use App\Models\Core\Languages;
use App\Models\Core\Memberships;
use App\Models\Core\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

class MembershipController extends Controller
{

    public function __construct(Memberships $membership, Languages $language, Images $images, Setting $setting)
    {
        $this->membership = $membership;
        $this->language = $language;
        $this->images = $images;
        $this->Setting = $setting;
        $this->myVarsetting = new SiteSettingController($setting);
    }

    public function display()
    {
        $title = array('pageTitle' => Lang::get("labels.Membership"));
        $membership = $this->membership->paginator(20);        
        $result['commonContent'] = $this->Setting->commonContent();
     // dd($membership);
        return view("admin.Membership.index", $title)->with('membership', $membership)->with('result', $result);
    }

    public function add(Request $request)
    {
        $allimage = $this->images->getimages();
        $title = array('pageTitle' => "Add Membership");
        $result['commonContent'] = $this->Setting->commonContent();
        $result['languages'] = $this->myVarsetting->getLanguages();
        return view("admin.Membership.add", $title)->with('allimage', $allimage)->with('result', $result);
    }

    public function insert(Request $request)
    {
        $this->membership->insert($request);
        return redirect()->back()->with('update', 'Content has been created successfully!');
    }

    public function edit(Request $request)
    {
        
        
        $title = array('pageTitle' => 'Edit Membership');
        $membership_id = $request->id;
        $editMembership = $this->membership->edit($membership_id);
        $allimage = $this->images->getimages();        
        $result['commonContent'] = $this->Setting->commonContent();
        $result['languages'] = $this->myVarsetting->getLanguages();
        
        //dd($result, $editMembership);
        
        return view("admin.Membership.edit", $title)->with('result', $result)->with('editMembership', $editMembership)->with('allimage', $allimage);
    }

    public function update(Request $request)
    {
        $messages = 'update is not successfull';

        $this->validate($request, [
            'id' => 'required',
            //'oldImage' => 'required',
            //'old_slug' => 'required',
            //'slug' => 'required',
            'name' => 'required',
           // 'membership_url' => 'required',

        ]);
        $this->membership->updaterecord($request);
        return redirect()->back()->with('update', 'Content has been updated successfully!');

    }

    //delete membership
    public function delete(Request $request)
    {

        $this->membership->destroyrecord($request);
        return redirect()->back()->withErrors("Deleted successfully");
    }

    public function filter(Request $request)
    {

        $name = $request->FilterBy;
        $param = $request->parameter;
        $title = array('pageTitle' => Lang::get("labels.Membership"));
        $membership = $this->membership->filter($name, $param);
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.Membership.index", $title)->with('result', $result)->with('membership', $membership)->with('name', $name)->with('param', $param);
    }

}
