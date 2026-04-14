<?php

namespace App\Http\Controllers\Admin;

use App\Models\Faq;
use App\Helpers\MediaHelper;
use Illuminate\Http\Request;
use App\Models\PaymentGateway;
use App\Models\HomepageContent;
use App\Http\Controllers\Controller;

class HomePageContoller extends Controller
{
  public function index()
  {
    return view('admin.homepage.welcome');
  }

  public function login()
  {
    return view('admin.homepage.login');
  }

  public function why()
  {
    $whys = HomepageContent::where('type', 'why')->get();
    return view('admin.homepage.why', ['whys' => $whys]);
  }

  public function how()
  {
    $whys = HomepageContent::where('type', 'how')->get();
    return view('admin.homepage.how', ['hows' => $whys]);
  }


  public function testimonials()
  {
    $whys = HomepageContent::where('type', 'testimonials')->get();
    return view('admin.homepage.testimonials', ['testimonials' => $whys]);
  }


  public function faqs()
  {
    $faqs = Faq::all();
    return view('admin.homepage.faqs', ['faqs' => $faqs]);
  }


  public function faqUpdate(Request $request)
  {

    $faq = Faq::findOrFail($request->id);
    $faq->question = $request->question;
    $faq->answer = $request->answer;
    $faq->save();

    return redirect()->back()->with('success', 'FAQ Contents Updated!');
  }

  public function faqCreate(Request $request)
  {
    $faq = new Faq();
    $faq->question = $request->question;
    $faq->answer = $request->answer;
    $faq->save();

    return redirect()->back()->with('success', 'New FAQ Contents Created!');
  }



  public function faqDelete($id)
  {

    $assistant = Faq::findOrFail($id);

    $assistant->delete();

    return redirect()->back()->with('success', 'FAQ Deleted Successfully!');
  }

  public function update(Request $request)
  {
    $request->validate([
      'wvideo' => 'mimes:mp4,webm',
      'image' => 'mimes:jpg,jpeg,png',
    ]);
    foreach ($request->except(['_token', 'wvideo','image']) as $key => $value) {
      update_settings($key, $value);
    }

    if ($request->wvideo) {

      $file = $request->wvideo;
      $filename = $file->getClientOriginalName();
      $locaion = base_path('/public/assets/front/images/home/');
      $file->move($locaion, $filename);

      update_settings('welcome_video', $filename);
    }

    if ($request->image) {

      $img = MediaHelper::handleUpdateImage($request->image, '/' . $request->image, [1200, 880]);

      update_settings('login_page_image', $img);
    }

    return redirect()->back()->with('success', 'Contents Updated!');
  }



  public function updateImage(Request $request)
  {

    $request->validate([
      'logo' => 'mimes:png,jpg,jpeg',
      'favicon' => 'mimes:ico',
    ]);
    if ($request->logo) {
      $logo = MediaHelper::handleSettingsImage($request->logo, get_settings('system_logo'));
      //dd($logo);
      update_settings('system_logo', $logo);
    }

    if ($request->favicon) {
      $logo = MediaHelper::handleSettingsImage($request->favicon, get_settings('system_favicon'));
      update_settings('system_favicon', $logo);
    }

    return redirect()->back()->with('success', 'Settings Updated!');
  }



  public function gateway()
  {
    $gateways = PaymentGateway::all();
    return view('admin.gateway.index', ['gateways' => $gateways]);
  }

  public function contentUpdate(Request $request)
  {

    $request->validate([
      'icon' => 'mimes:png,jpg,jpeg',
    ]);

    $content = HomepageContent::findOrFail($request->id);
    $content->title = $request->title;
    $content->text = $request->details;
    $content->type = $request->type;

    if ($request->icon) {

      $content->icon = MediaHelper::handleUpdateImage($request->icon, '/' . $request->icon, [100, 100]);
    }

    if ($request->type == "testimonials") {
      $content->image = $request->image;
    } else {
      if ($request->image) {
        $request->validate([
          'image' => 'mimes:png,jpg,jpeg',
        ]);

        $content->image = MediaHelper::handleUpdateImage($request->image, '/' . $request->image, [625, 600]);
      }
    }



    $content->save();
    return redirect()->back()->with('success', $request->section . ' Updated Successfully!');
  }


  public function contentStore(Request $request)
  {

    $request->validate([
      'icon' => 'mimes:png,jpg,jpeg',
    ]);

    $content = new HomepageContent();
    $content->title = $request->title;
    $content->text = $request->details;
    $content->type = $request->type;

    if ($request->icon) {

      $content->icon = MediaHelper::handleUpdateImage($request->icon, '', [100, 100]);
    }

    if ($request->type == "testimonials") {
      $content->image = $request->image;
    } else {
      if ($request->image) {

        $request->validate([
          'image' => 'mimes:png,jpg,jpeg',
        ]);

        $content->image = MediaHelper::handleUpdateImage($request->image, '', [625, 600]);
      }
    }

    $content->save();
    return redirect()->back()->with('success', $request->section . ' Added Successfully!');
  }


  public function contentDelete($id)
  {

    $assistant = HomepageContent::findOrFail($id);

    $assistant->delete();

    return redirect()->back()->with('success', 'Section Contents Deleted Successfully!');
  }
}
