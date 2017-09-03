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

      <!--@if( !$user->posts_no and ($user->id != Auth::id()) )-->
      <p class="lead" v-show="!user.posts_no && !owner">This User has No Posts</p>

      <div class="col-md-12 posts-container">
        <div v-for="post in posts">
          <post-content
            :post-data="post"
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
  props: ['user', 'authId'],

  data() {
    return {
      owner: false,
      posts: this.user.posts,
    }
  },

  methods: {
    onNewPost(post) {
      this.posts.unshift(post);
    },

    onPostDeleted(id) {
      const position  = this.posts.findIndex(
        (element) => {
          return element.id == id;
        }
      );
      this.posts.splice(position, 1);
      console.log(this.posts);
    }
  },

  created() {
    if (this.authId && (this.authId == this.user.id) )
    {
      this.owner= true;
    }

    /*
    if (this.user.posts_no != 0)
    {
      axios.get("http://one.app/userPosts/" + this.user.id)
      .then(
        response => {
          console.log(response);
          this.posts = response.data.posts;
          //this.user = response.data.user;
        }
      )
      .catch(
        error => {
          console.log(error);
          if (error.response) {
            console.log("Error 1");
             // The request was made and the server responded with a status code
             // that falls out of the range of 2xx
             console.log(error.response.data);

             console.log("Error 2");
             console.log(error.response.status);

             console.log("Error 3");
             console.log(error.response.headers);
           } else if (error.request) {
             // The request was made but no response was received
             // `error.request` is an instance of XMLHttpRequest in the browser and an instance of
             // http.ClientRequest in node.js
             console.log("Error 4");
             console.log(error.request);
           } else {
             // Something happened in setting up the request that triggered an Error
             console.log("Error 5");
             console.log('Error', error.message);
           }
           console.log(error.config);
        }
      );
    }
    else {
      console.log("this User has NO POSTS");
    }

    */
  },

}
</script>

<style scoped>
.posts-container {
  margin-top: 10px;
}
</style>
