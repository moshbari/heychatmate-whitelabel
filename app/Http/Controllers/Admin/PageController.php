<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Page;

class PageController extends Controller
{
  //
  public function index()
  {
    $pages = Page::all();
    return view('admin.pages.index', ['pages' => $pages]);
  }

  public function edit($id)
  {
    $page = Page::findOrFail($id);
    return view('admin.pages.edit', ['page' => $page]);
  }

  public function create()
  {
    return view('admin.pages.create');
  }

  public function menuOrder(Request $request)
  {
    foreach ($request->sorting as $key => $value) {
      # code...
      $page = Page::findOrFail($value);
      $page->menu_order = $key;
      $page->save();
    }
    return redirect()->back()->with('success', 'Menu order Saved Successfully!');
  }

  public function submit(Request $request)
  {

    $request->validate([
      'name'   => 'required|unique:pages',
      'slug'   => 'required|unique:pages',
    ]);

    $page               = new Page();
    $page->name         = $request->name;
    $page->title        = $request->title;
    $page->slug         = $request->slug;
    $page->contents     = $request->contents;
    $page->footer_link  = $request->footer_link != 1 ? 0 : 1;
    $page->header_link  = $request->header_link != 1 ? 0 : 1;
    $page->save();

    return redirect()->back()->with('success', 'New Page Created Successfully!');
  }


  public function update(Request $request, $id)
  {

    $request->validate([
      'name'   => 'required|unique:pages,name,' . $id,
      'slug'   => 'required|unique:pages,slug,' . $id,
    ]);

    $page               = Page::findOrFail($request->id);
    $page->name         = $request->name;
    $page->title        = $request->title;
    $page->slug         = $request->slug;
    $page->contents     = $request->contents;
    $page->footer_link  = $request->footer_link != 1 ? 0 : 1;
    $page->header_link  = $request->header_link != 1 ? 0 : 1;
    $page->save();

    return redirect()->back()->with('success', 'Page Updated Successfully!');
  }

  public function delete($id)
  {

    $page = Page::findOrFail($id);
    $page->delete();

    return redirect()->back()->with('success', 'Page Deleted Successfully!');
  }
}
