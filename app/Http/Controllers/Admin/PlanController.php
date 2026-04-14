<?php

namespace App\Http\Controllers\Admin;

use App\Models\Plan;
use App\Models\Conversation;
use Illuminate\Http\Request;
use App\Models\AiInstruction;
use App\Http\Controllers\Controller;

class PlanController extends Controller
{
    //

    public function index(){
        $plans = Plan::all();
        return view('admin.plan.index',['plans' => $plans]);
    }


  public function submit(Request $request)
  {

    // $request->validate([
    //   'logo' => 'mimes:png,jpg,jpeg',
    //   'favicon' => 'mimes:ico',
    // ]);

    $plan               = new Plan();
    $plan->name         = $request->name;
    $plan->type         = $request->type;
    $plan->api_type         = $request->api_type;
    $plan->max_bots     = $request->max_bots;
    $plan->price        = $request->price;
    $plan->credits      = $request->credits;
    $plan->features      = $request->features;
    $plan->subtitle      = $request->subtitle;
    $plan->save();


    return redirect()->back()->with('success', 'New Plan Created Successfully!');
  }


  public function update(Request $request)
  {


    $plan               = Plan::findOrFail($request->id);
    $plan->name         = $request->name;
    $plan->api_type         = $request->api_type;
    $plan->type         = $request->type;
    $plan->max_bots     = $request->max_bots;
    $plan->price        = $request->price;
    $plan->credits      = $request->credits;
    $plan->features      = $request->features;
    $plan->subtitle      = $request->subtitle;
    $plan->save();


    return redirect()->back()->with('success', 'Plan Updated Successfully!');
  }

    public function plandelete($id){

        $plan = Plan::findOrFail($id);
        $plan->delete();

        return redirect()->back();
    }


    public function chatSubmit(Request $request){


          return $request->content;
    }

}
