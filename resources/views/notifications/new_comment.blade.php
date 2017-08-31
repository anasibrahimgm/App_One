<a href="{{route('posts.show', $notification->data['post_slug'] )}}">
  <b>{{ title_case($notification->data['commenter']) }}</b>
  commented on your <b><i>{{ $notification->data['post_title'] }}</i></b> Post
</a>
