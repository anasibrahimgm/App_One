<template>
  <div>
      <p class="horizontalTabSmall">Posts</p>

      <div v-show="owner">
        <p class="lead" v-show="!user.posts_no">Create Your First Post</p>
        <create-post
          :remainingCats="user.remainingCats"
          :myCategories="user.categories"
          @newPost="onNewPost($event)">
        </create-post>
      </div>

      <p class="lead" v-show="!user.posts_no && !owner">This User has No Posts</p>

      <div class="col-md-12 posts-container">
        <div v-for="post in posts">
          <post-content
            :post="post"
            :authId="authId"
            @postDeleted="onPostDeleted($event)"
            >
          </post-content>
        </div>
      </div>

  </div>
</template>

<script>
export default{
  props: ['userData', 'authId', 'homePage'],

  data() {
    return {
      owner: false,
      user: this.userData,
      posts: [],
    }
  },

  methods: {
    onNewPost(post) {
      this.user.posts.unshift(post);
    },

    onPostDeleted(id) {
      const position  = this.user.posts.findIndex(
        (element) => {
          return element.id == id;
        }
      );
      this.user.posts.splice(position, 1);
      console.log(this.user.posts);
    }
  },

  created() {
    if (this.authId && (this.authId == this.user.id) )
    {
      this.owner= true;
    }

    if(this.homePage)
    {
      console.log("Home PAGE");
      this.posts = this.user.mergedPosts;//+ this.user.categories.posts;
      //console.log(this.posts);
    }
    else {
      //console.log("USER PAGE");
      this.posts = this.user.posts;
    }

    if (this.user.posts && (this.user.posts.length > 1) )
      this.user.posts.reverse();

    console.log(this.user.posts);
  },

}
</script>

<style scoped>
.posts-container {
  margin-top: 10px;
}
</style>
