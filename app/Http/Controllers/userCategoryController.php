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
    $categories = Category::orderBy('created_at', 'desc')->get();
    return response()->json(['categories' => $categories], 200);
  }

  public function show($id)
  {
    $category = Category::with('posts.user', 'posts.category', 'posts.comments.user')
                        ->find($id);

    return view('categories.show')->withCategory($category);
  }

}
