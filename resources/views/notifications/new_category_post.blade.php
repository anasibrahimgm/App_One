<a href="{{route('posts.show', $notification->data['post_slug'] )}}">
  <b>{{ title_case($notification->data['post_user']) }}</b>
  created a new <b><i>{{ $notification->data['category_name'] }}</i></b> Post
</a>
