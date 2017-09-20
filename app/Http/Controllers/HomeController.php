<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\User;
use App\Category;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::with('posts.category', 'posts.user', 'posts.comments', 'posts.comments.user', 'categories.posts.user', 'categories.posts.comments.user', 'categories.posts.category')
                ->find(Auth::guard('web')->id());

        $categories = Category::all();//->only('id', 'name', 'description');

        $diff = $categories->diff($user->categories);//remaining categories

        $user->remainingCats = $diff;

        $user->mergedPosts = $user->posts;

        foreach($user->categories as $cat)
        {
          foreach($cat->posts as $post)
          {
            if ($post->user_id != $user->id)
            {
              $user->mergedPosts->prepend($post);
            }
          }
        }

        $user->mergedPosts->sortBy('updated_at');

        return view('home')->withUser($user);
    }
}
