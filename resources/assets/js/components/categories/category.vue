<template>
  <div class="col-md-9 col-md-offset-2">
    <h3>{{category.name}}</h3>
    <h4>{{category.description}}</h4>
    <p><i class="fa fa-list" aria-hidden="true"></i> {{category.posts.length == 0 ? 'No' : category.posts.length }} {{category.posts.length == 1 ? 'Post' : 'Posts'}}</p>
    <p><i class="fa fa-users" aria-hidden="true"></i> {{category.users.length == 0 ? 'No' : category.users.length }} {{category.users.length == 1 ? 'Subscriber' : 'Subscribers'}}</p>

    <div class="col-md-12 posts-container">
      <div v-for="post in category.posts">
        <post-content
        :post-data="post"
        :authId="authId"
        >
       </post-content>
      </div>
    </div>
  </div>
</template>

<script>
export default{
  props: ['category', 'authId'],
}
</script>
