<template>
  <div>
    <div id="posts" class="tab-pane fade in active">
      <p class="horizontalTabSmall">Posts</p>

      <div v-show="own">
        <p class="lead" v-show="!user.posts_no">Create Your First Post</p>
        <create-post
          @newPost="onNewPost($event)">
        </create-post>
      </div>

      <!--@if( !$user->posts_no and ($user->id != Auth::id()) )-->
      <p class="lead" v-show="!user.posts_no && !own">This User has No Posts</p>

      <div class="col-md-12 posts-container">
        <post-content
          v-for="post in posts"
          :post="post"
          :owner="own"
          :postOwner="user"
          :loggedIn="loggedIn"
          :currentUser="currentUser"
          @postDeleted="onPostDeleted($event)"
          >
        </post-content>
      </div>
    </div>
  </div>
</template>

<script>
import postContent from './postContent.vue';

export default{
  props: ['user', 'own', 'loggedIn', 'currentUser'],

  components: {
    'post-content': postContent,
  },

  data() {
    return {
      posts: [],
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
  },

}
</script>
