<?php

namespace App\Http\Controllers;

use App\Category;
use App\User;
use App\Post;
use Auth;
use Illuminate\Http\Request;

class userCategoryController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth:web')->only(['subscribe', 'unsubscribe']);
  }


  public function index()
  {
    $categories = Category::get();
    return response()->json(['categories' => $categories], 200);
  }

  public function show($id)
  {
    $category = Category::with('users', 'posts.user', 'posts.category', 'posts.comments.user')
                        ->find($id);

    return view('categories.show')->withCategory($category);
  }

  public function subscribe($id)
  {
    $category = Category::find($id);
    $user = User::find(Auth::id());

    $category->users()->toggle($user->id);

    return response()->json(['message'=>'Category successfully Un/Subscribed','category' => $category], 200);
  }
}
