<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Session;
use App\Post;
use App\User;
use Purifier;
use Image;
use Storage;
use App\Http\Requests\PostStoreRequest;
use App\Http\Requests\PostUpdateRequest;
use Illuminate\Validation\Rule;
use App\Category;
use App\Notifications\newCategoryPost;

class PostsController extends Controller
{

    public function __construct ()
    {
      $this->middleware('auth')->only(['store', 'edit', 'update', 'destroy']);
    }

    public function index()
    {
        //
    }

    public function store(PostStoreRequest $request)
    {
        $post = new Post();
        $user = User::find(Auth::id());
        $category = Category::find($request->category);

        $post->user()->associate($user);
        $post->category()->associate($category);

        /*
        //these two worked!!
        $post->user()->associate($user);
        $post->category()->associate($category);
        */

        $post->title = $request->title;
        $post->slug = $request->slug;
        $post->body = Purifier::clean($request->body);

        if ($request->has('image')) {
          $exploded = explode(",", $request->image);

          $decoded = base64_decode($exploded[1]);

          if(str_contains($exploded[0], 'jpeg'))
            $extension = 'jpg';
          else
            $extension = 'png';

          $fileName = time(). '.' . $extension;
          $location = public_path('images/posts/' . $fileName);// storage path

          //file_put_contents($location, $decoded);
          Image::make($decoded)->save($location);
          $post->image = $fileName;
        }

        $post->save();

        //not after the foreach loop bc it possibly affects the last $user from the loop!
        $user->posts_no++;
        $user->save();

        foreach ($category->users as $user) {
          if ($user->id != Auth::id()) {
            $user->notify(new newCategoryPost($post->slug, $category->name));// we use Notifiable treat on User model
          }
        }

        return response()->json(['message', 'Post Successfully Created', 'post' => $post], 200);
    }

    public function show($slug)
    {
        $post = Post::with('user', 'category', 'comments.user')
                    ->where('slug', $slug)
                    ->first();

        return view('posts.show')->withPost($post);
    }

    public function edit($slug)
    {
      $post = Post::with('category', 'user.categories')
                  ->where('slug', $slug)
                  ->first();

      if ($post->user_id == Auth::id())
        return view('posts.edit')->withPost($post);
      else
        return "You CAN'T edit a post you haven't created";
    }

    public function update(PostUpdateRequest $request, $id)
    {
      $this->validate($request, [
        'slug' => Rule::unique('one_posts')->ignore($id)
      ]);

      $post = Post::find($id);
      $category = Category::find($request->category);


      if ($post->user_id == Auth::id())
      {
        $post->category()->associate($category);

        $post->title = $request->title;
        $post->slug = $request->slug;
        //if slug is changed, update the notification
        $post->body = Purifier::clean($request->body);

        if ($request->image != $post->image) {

          if ($post->image) {// if the post had an image
            Storage::delete("images/posts/".$post->image);
            //delete the old image from Storage

            $post->image = '';
          }

          if ($request->image) {//if there is an image in the request
            $exploded = explode(",", $request->image);

            $decoded = base64_decode($exploded[1]);

            if(str_contains($exploded[0], 'jpeg'))
              $extension = 'jpg';
            else
              $extension = 'png';

            $fileName = time(). '.' . $extension;
            $location = public_path('images/posts/' . $fileName);

            Image::make($decoded)->save($location);
            $post->image = $fileName;
          }
        }

        $post->save();

        return response()->json(['message' => 'Post Updated', 'post' => $post]);
      }
    }

    public function destroy($id)
    {
      $post = Post::find($id);

      $user = User::find($post->user_id);
      if ($post->image)
        Storage::delete("images/posts/".$post->image);

      //$post->comments()->dissociate($user);
      //$post->category()->disociate($category);

      $post->delete();

      $user->posts_no--;
      $user->save();

      /*////////delete the notification
      foreach ($category->users as $user) {
        if ($user->id != Auth::id()) {
          $user->notify(new newCategoryPost($post));// we use Notifiable treat on User model
        }
      }
      */

      return response()->json(['message' => 'you deleted the post'], 200);
    }
}
