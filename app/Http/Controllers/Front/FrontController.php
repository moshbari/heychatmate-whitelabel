<?php

namespace App\Http\Controllers\Front;

use App\Models\Faq;
use App\Models\Page;
use App\Models\Plan;
use App\Models\Subscriber;
use Illuminate\Http\Request;
use App\Models\HomepageContent;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class FrontController extends Controller
{
  public function index()
  {
    return redirect()->route("login");
    $data = [];
    $data['whys'] = HomepageContent::where('type', 'why')->get();
    $data['hows'] = HomepageContent::where('type', 'how')->get();
    $data['testimonials'] = HomepageContent::where('type', 'testimonials')->get();
    $data['plans'] = Plan::where('status', 1)->get();
    $faqs = Faq::all();

    $half = ceil($faqs->count() / 2);
    $chunks = $faqs->chunk($half);

    $data['faqdats'] = $chunks;
    $data['plans'] = Plan::orderBy('name', 'desc')->get()->groupBy('type');

    return view('front.index', $data);
  }

  public function pages($slug)
  {

    switch ($slug) {
      case 'pricing':
        $data = [];
        $data['plans'] = Plan::orderBy('name', 'desc')->get()->groupBy('type');
        $data['page'] = Page::where('slug', $slug)->first();
        return view('front.pricing', $data);
        break;
      case 'contact':
        $data = [];
        $data['page'] = Page::where('slug', $slug)->first();
        return view('front.contact', $data);
        break;

      default:
        if (Page::where('slug', $slug)->exists()) {

          $data = [];
          $data['page'] = Page::where('slug', $slug)->first();
          return view('front.page', $data);
        }
        abort(404);
        break;
    }
  }

  public function subscribe(Request $request){
    $messages = array(
      'email.unique' => 'You Are Already Subscribed!',
      'email.required' => 'Please Eneter a Valid Email.',
      'email.email' => 'Please Eneter a Valid Email.'
    );
    $validator = Validator::make($request->all(), [
      'email' => 'required|email|unique:subscribers',
    ], $messages);
    //dd($validator->errors()->messages()['email'][0]);

    if ($validator->fails()) {

      return response()->json(['<span style="color:red">'. $validator->errors()->messages()['email'][0].'</span>']);
    } else {
      $data = new Subscriber();
      $data->email = $request->email;
      $data->save();
      return response()->json(['<span style="color:green">Subscribed Successfully!</span>']);
    }
  }

  public function contact(Request $request){

    $validator = Validator::make($request->all(), [
      'email' => 'required|email',
      'subject' => 'required',
      'phone' => 'required',
      'message' => 'required',
    ]);
    $allerrors = "";
    foreach ($validator->errors()->all() as $error) {
      # code...
      // dd($error);
      $allerrors .= "* ".$error ."<br>";
    }
    //dd($allerrors);

    if ($validator->fails()) {

      return response()->json(['status' => 'error','message'=>'<span style="color:red">'. $allerrors.'</span>']);

    } else {

      $data['name'] = $request->name;
      $data['email'] = $request->email;
      $data['subject'] = $request->subject;
      $data['message'] = "Email: " . $request->email . "<br>Phone: ".$request->phone. "<br>Message: ".$request->message;

      contactEmail($data);
      return response()->json(['status' => 'success', 'message' => '<span style="color:green">Thank you for contacting us!</span>']);
    }
  }
}
