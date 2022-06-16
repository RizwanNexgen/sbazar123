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
use App\Models\Core\Newsletter;
use Notification;
use App\Notifications\SendNewsletter;

class NewsletterController extends Controller
{
  public function __construct(Setting $setting)
  {    
    $this->Setting = $setting;
  }

  public function display(){
    $data = [];
    $data['pageTitle'] = 'Newsletters';    
    $data['list'] = Newsletter::paginate(10);
    $result['commonContent'] = $this->Setting->commonContent();
    return view("admin.newsletters.index", $data)->with('result', $result);
  }


  public function filter(Request $request){
    $title = array('pageTitle' => Lang::get("labels.SubCategories"));
    $categories = $this->Categories->filter($request);
    return view("admin.categories.index", $title)->with(['categories'=> $categories, 'name'=> $request->FilterBy, 'param'=> $request->parameter]);
  }

  public function add(Request $request){
    $data = [];
    $data['pageTitle'] = 'Add Newsletter';        
    $result['commonContent'] = $this->Setting->commonContent();

    if ($request->isMethod('post')) 
    {
        $validatedData = $request->validate([
            'subject' => 'required',
            'description' => 'required',                                   
        ]); 

        $newsletter = new Newsletter;
        $newsletter->subject = $request->subject;                   
        $newsletter->description = $request->description;                       
        $newsletter->save();

        return redirect('admin/newsletters/display');
    }

    return view("admin.newsletters.add", $data)->with('result', $result);
  }

  public function edit($id, Request $request){
    $data = [];
    $data['pageTitle'] = 'Add Newsletter';        
    $result['commonContent'] = $this->Setting->commonContent();
    $data['info'] = Newsletter::find($id);
    if ($request->isMethod('post')) 
    {
        $validatedData = $request->validate([
            'subject' => 'required',
            'description' => 'required',                                   
        ]); 

        $newsletter = Newsletter::find($id);
        $newsletter->subject = $request->subject;                   
        $newsletter->description = $request->description;                       
        $newsletter->save();

        return redirect('admin/newsletters/display');
    }

    return view("admin.newsletters.edit", $data)->with('result', $result);
  }

  public function send($id, Request $request){
    $data = [];
    $data['pageTitle'] = 'Send Newsletter';        
    $result['commonContent'] = $this->Setting->commonContent();
    
    $data['info'] = Newsletter::find($id);
    
    if ($request->isMethod('post')) 
    {
        $validatedData = $request->validate([
            'subject' => 'required',
            'description' => 'required',                                   
        ]); 

        if(empty($request->level_type))
        {
           $users = DB::table('users')
            ->select('first_name','last_name','email')
            ->where('role_id', 2)
            ->where('status', 1)
            ->get();
        }
        else
        {
            $users = DB::table('users')
            ->select('first_name','last_name','email')
            ->where('user_level_id', $request->level_type)
            ->where('role_id', 2)
            ->where('status', 1)
            ->get();
        }
        
        $count = 0;
        
        if(count($users)>0)
        {
            foreach($users as $o)
            {
                Notification::route('mail',  $o->email)->notify(new SendNewsletter($o, $request->subject, $request->description));
                
                $count++;
            }
        }

        return redirect('admin/newsletters/display')->withErrors(['Newsletter Send to '.$count.' customers']);
    }

    $data['user_level_types'] = DB::table('user_level_types')->get();

    return view("admin.newsletters.send", $data)->with('result', $result);
  }

  public function delete($id, Request $request){
      Newsletter::destroy($id);
      $message = Lang::get("labels.Newsletter Deleted Successfully");
      return redirect()->back()->withErrors([$message]);
  }
}
