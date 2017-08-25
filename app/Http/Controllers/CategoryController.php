<?php

namespace App\Http\Controllers;

use App\Category;
use App\Admin;
use Auth;
use App\Http\Requests\CategoryStoreRequest;
use App\Http\Requests\CategoryUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth:admin');
  }


  public function index()
  {
    return view('categories.show');
  }

  public function showCategories()
  {
    $categories = Category::orderBy('created_at', 'desc')->get();

    foreach ($categories as $category) {
      $admins[$category->admin->id] = $category->admin;
    }

    return response()->json(['categories' => $categories], 200);
  }

  public function store(CategoryStoreRequest $request)
  {
    $category = new Category();

    $admin = Admin::find(Auth::guard('admin')->id());

    $category->name = $request->name;
    $category->description = $request->description;
    $category->admin()->associate($admin);

    $category->save();

    //return view('categories.edit')->withCategory($category);
    return response()->json(['message' =>'Category Created Successfully', 'category' => $category], 200);
  }

  public function update(CategoryUpdateRequest $request, $id)
  {
    $this->validate($request, [
      'name' => Rule::unique('one_categories')->ignore($id)
    ]);

    $category = Category::find($id);

    $currentAdmin = Admin::find(Auth::guard('admin')->id());

    if (($category->admin_id == $currentAdmin->id) || ($currentAdmin->role == 1) || ($currentAdmin->role < $category->admin->role))
    {
      $category->name = $request->name;
      $category->description = $request->description;
      $category->save();
    }

    return response()->json(['message' => 'Category Successfully UPDATED', 'category' => $category]);
  }

  public function destroy($id)
  {

    $category = Category::find($id);

    $currentAdmin = Admin::find(Auth::guard('admin')->id());

    if (($category->admin_id == $currentAdmin->id) || ($currentAdmin->role == 1) || ($currentAdmin->role < $category->admin->role))
    {
      $category->delete();
    }

    return response()->json(['message' => 'Category Successfully DELETED']);
  }
}
