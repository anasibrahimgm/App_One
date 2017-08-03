<template>
  <div class="col-md-12 post-content">
    <div class="post-content-left">
      <div class="post-content-left-img">
        <a :href="postOwner.username"><img :src="postOwner.avatar" /></a>
      </div>
    </div>
        <!-- Post Content RIGHT -->
    <div class="post-content-right">
      <div class="col-md-12 post-data-edit">
        <div class="post-data-edit-left">
          <ul class="post-data">
            <li class="post-owner"><a :href="postOwner.username">{{ postOwner.name }}</a></li>
            <li class="post-time"><a :href="post.slug">{{ post.created_at }}</a></li>
          </ul>
        </div>

        <!-- IF owner is Auth::user() -->
        <div class="post-data-edit-right" v-show="owner">
          <span class="left" @click="deletePost"><i title="Delete Post" class="fa fa-2x fa-trash-o" aria-hidden="true"></i></span>
          <span class="right" ><i title="Edit Post" class="fa fa-2x fa-pencil-square-o" aria-hidden="true"></i></span>
        </div>

      </div>

      <div class="col-md-12">
        <h3>{{ post.title }}</h3>
        <!-- Post Content LEFT -->
        <p class="lead" style="font-size:17px;">{{ post.body.substr(0, 250) }}
          <div v-show="post.body.length > 250 ">
          ......<a :href="post.slug">Continue Reading</a>
          </div>
        </p>
      </div>

      <div class="col-md-12" v-show="post.image">
          <a :href="postImage">
            <img :src="postImage" width="100%" style="border-radius:6px;"/>
          </a>
      </div>

      </div>
  </div>
</template>

<script>
import axios from 'axios';

export default{
  props: ['post', 'owner', 'postOwner'],

  data() {
    return {
      postImage:'',
    }
  },

  methods: {
    deletePost() {
      axios.delete("http://one.app/posts/" + this.post.id)
      .then(
        response => {
          console.log(response);
          this.$emit('postDeleted', this.post.id);
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
    },
  },

  created() {
    this.post.slug = "../posts/" + this.post.slug;

    if (this.post.image)    
      this.postImage = "../images/posts/" +this.post.image;
  },

}
</script>
