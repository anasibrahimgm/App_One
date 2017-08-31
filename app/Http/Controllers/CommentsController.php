<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;
use App\User;
use App\Post;
use Auth;
use App\Notifications\newComment;

class CommentsController extends Controller
{
    public function __construct()
    {
      $this->middleware('auth')->only(['create', 'delete']);
    }

    public function showPostComments($id)
    {
      $comments = Comment::where('post_id', $id)->orderBy('created_at', 'desc')->get();

      foreach ($comments as $comment) {
        $users[$comment->user->id] = $comment->user;
      }

      return response()->json(['comments' => $comments], 200);
    }

    public function create(Request $request)
    {
      $this->validate($request, [
        'body' => 'required|string|min:5',
      ]);

      $user = User::find(Auth::id());
      $comment = new Comment();
      $post = Post::find($request->postid);

      $comment->body = $request->body;
      $comment->post()->associate($post);
      $comment->user()->associate($user);

      $comment->save();

      if ($post->user->id != Auth::id())//the commenter is not the post creator
        $post->user->notify(new newComment($post->title, $post->slug));

      return response()->json(['message' => 'Comment Successfully Created', 'comment' => $comment]);
    }

    public function delete($id)
    {
      $comment = Comment::find($id);

      if (Auth::id() == $comment->user_id)
        $comment->delete();

      return response()->json(['message' => 'Comment Successfully DELETED']);
    }
}
