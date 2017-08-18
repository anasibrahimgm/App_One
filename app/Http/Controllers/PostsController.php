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

    public function userPosts($user_id)
    {
        $posts = Post::where('user_id', $user_id)->orderBy('id', 'desc')->get();

        $user = User::find($user_id);
        $user->avatar = asset("images/users/avatars/$user->avatar");

        return response()->json(['posts' => $posts, 'user' => $user], 200);
    }

    public function store(PostStoreRequest $request)
    {
        $post = new Post();
        $user = User::find(Auth::id());

        $post->user()->associate($user);
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

        $user->posts_no++;
        $user->save();

        Session::flash('success', 'Post added');

        return response()->json(['message', 'Post Successfully Created', 'post' => $post], 200);
    }

    public function show($slug)
    {
        $post = Post::where('slug', $slug)->first();
        return view('posts.show')->withPost($post);
    }

    public function edit($slug)
    {

      $post = Post::where('slug', $slug)->first();

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

      if ($post->user_id == Auth::id())
      {
        $post->title = $request->title;
        $post->slug = $request->slug;
        $post->body = Purifier::clean($request->body);

        $msg = 'Anas';

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
      $user->posts_no--;
      //$user->posts()->detatch($post->id);
      $user->save();
      if ($post->image)
        Storage::delete("images/posts/".$post->image);

      $post->delete();

      return response()->json(['message' => 'you deleted the post'], 200);
    }
}
