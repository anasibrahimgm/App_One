<template>
  <div class="col-md-12 post-content">
    <div :class="completePost? 'col-md-8 col-md-offset-2' : ''">
      <div class="post-content-left">
        <div class="post-content-left-img">
          <a<img :src="postOwner.avatar" />
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

          <!-- IF owner is Auth::unser() -->
          <div class="post-data-edit-right" v-show="owner">
            <span class="left" data-toggle="modal" :data-target="'#deleteModal' + post.id"><i title="Delete Post" class="fa fa-2x fa-trash-o" aria-hidden="true"></i></span>

            <div class="modal fade" :id="'deleteModal' + post.id" role="dialog">
              <div class="modal-dialog modal-lg">
                <div class="modal-content">
                  <div class="modal-header" style="text-align:left;">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Delete?</h4>
                  </div>
                  <div class="modal-body" style="text-align:left;">
                    <p>{{ post.title }}</p>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button @click="deletePost" type="button" class="btn btn-danger" data-dismiss="modal">Delete</button>
                  </div>
                </div>
              </div>
            </div>

            <span class="right" ><a :href="post.slug+'/edit'"><i title="Edit Post" class="fa fa-2x fa-pencil-square-o" aria-hidden="true"></i></a></span>
          </div>

        </div>

        <div class="col-md-12">
          <h3>{{ post.title }}</h3>
          <!-- Post Content LEFT -->
          <span v-show="!completePost" class="lead" style="font-size:17px;">{{ post.body.substr(0, 250) }}
            <div v-show="post.body.length > 250 ">
            ......<a :href="post.slug">Continue Reading</a>
            </div>
          </span>
          <span v-show="completePost" class="lead" style="font-size:17px;">
            {{ post.body }}</span>
        </div>
        <div class="col-md-12" v-show="post.image">
            <img :src="postImage" data-toggle="modal" :data-target="'#postImageModal' + post.id" width="100%" style="border-radius:6px;"/>

            <div class="modal fade" :id="'postImageModal' + post.id" role="dialog">
              <div class="modal-dialog modal-lg">
                <div class="modal-content">
                  <div class="modal-header" style="text-align:left;">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <img :src="postImage" width="100%" style="border-radius:6px;"/>
                  </div>
                </div>
              </div>
            </div>
        </div>


        </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default{
  props: ['post', 'owner', 'postOwner', 'completePost'],

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
          if (this.completePost)
            window.location.href="http://one.app"
          else
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
    this.postOwner.username = "../users/" + this.postOwner.username;

    if (this.post.image)
      this.postImage = "../images/posts/" +this.post.image;

    if (this.completePost)
    {
      this.postOwner.avatar = "../images/users/avatars/" + this.postOwner.avatar;
    }
  },

}
</script>

<style>
.post-content .col-md-8 {
  border: 1px solid rgba(0, 0, 255, 0.14);
  border-radius: 5px;
  padding: 10px;
}
</style>
