<template>
  <div class="col-md-12 post-content">
    <div id="fb-root"></div>

    <div :class="completePost? 'col-md-8 col-md-offset-2' : ''">
      <div class="post-content-left">
        <div class="post-content-left-img">
          <img :src="postOwner.avatar" />
        </div>
      </div>
          <!-- Post Content RIGHT -->
      <div class="post-content-right">
        <div class="post-content-right-top">
          <div class="post-top-left">
            <ul class="post-data">
              <li class="post-owner"><a :href="postOwner.username">{{ postOwner.name }}</a></li>
              <li class="post-time"><a :href="post.slug">{{ post.created_at }}</a></li>
            </ul>
          </div>

          <!-- IF owner is Auth::unser() -->
          <div class="post-top-right" v-show="owner">
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

      <div class="col-md-12">
        <div class="fb-share-button" :data-href="post.slug" data-layout="button_count" data-size="small" data-mobile-iframe="true"><a class="fb-xfbml-parse-ignore" target="_blank" :href="post.slug">Share</a></div>

        <div class="fb-send" :data-href="post.slug"></div>

        <a class="twitter-share-button"
           :href="'https://twitter.com/intent/tweet?text=' + tweetContent "
           target="blank"
           style="background-color:#1B95E0; color:white !important; width:30px  !important; height:20px !important;padding:2px 5px;border-radius:3px;"
           >
       <i class="fa fa-twitter" aria-hidden="true"></i>Tweet</a>
      </div>

                                  <!-- START Comments Area -->

      <div class="col-md-12 commentsHorizontalTab">
        <br />
      </div>

      <div v-show="loggedIn" class="col-md-12 form-input-space" style="padding: 15px;">        <input v-model="comment" v-on:keyup.enter="submitComment" type="text" class="form-control form-title" placeholder="Comment.." />
        <span class="help-block danger">
          {{ commentError }}
        </span>
      </div>

      <div class="col-md-12">
        <i class="fa fa-comments" aria-hidden="true"></i> {{ comments.length }} Comments
      </div>

      <div class="col-md-12 comment-content" v-for="comment in comments">
        <div class="comment-content-left">
          <img :src="'../images/users/avatars/' + comment.user.avatar" style="width: 50px; height: 50px;"/>
        </div>
        <div class="comment-content-middle">
          <h4 style="margin-bottom:0;"><a :href="comment.user.username">{{ comment.user.name }}</a></h4>
          <p>{{ comment.body }}</p>
        </div>

        <div v-if="currentUser.id == comment.user.id" class="comment-content-right">
          <span style="padding:2px;"><i v-on:click="deleteComment(comment.id)" title="Delete Comment" class="fa fa-2x fa-trash-o" aria-hidden="true"></i></span>
        </div>
      </div>

                                  <!-- END Comments Area -->
    </div>
  </div>
</template>

<script>
(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v2.10&appId=410148912712065";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

import axios from 'axios';

export default{
  props: ['post', 'owner', 'postOwner', 'completePost', 'loggedIn', 'currentUser'],

  data() {
    return {
      postImage:'',
      comment: '',
      commentError: '',
      comments: [],
      tweetContent: '',
      deletedComment:'',
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

    submitComment() {
      axios.post("http://one.app/comments/create", {
        postid: this.post.id,
        body: this.comment,
      })
      .then(
        response => {
          console.log(response.data.comment);
          this.comment = '';
          this.comments.unshift(response.data.comment);
        }
      )
      .catch(
        error => {
          console.log(error);
          if (error.response) {
             console.log("Error 1");
             if (error.response.data.body)
                this.commentError = error.response.data.body[0];

             console.log("Error 2");
             console.log(error.response.status);

             console.log("Error 3");
             console.log(error.response.headers);
           } else if (error.request) {
             console.log("Error 4");
             console.log(error.request);
           } else {
             console.log("Error 5");
             console.log('Error', error.message);
           }
           console.log(error.config);
        }
      );
    },

    deleteComment(commentId) {
      axios.delete("http://one.app/comments/" + commentId + "/delete")
      .then(
        response => {
          console.log(response);

          const position  = this.comments.findIndex(
            (element) => {
              return element.id == commentId;
            }
          );
          this.comments.splice(position, 1);
        }
      )
      .catch(
        error => {
          console.log(error);
          if (error.response) {
             console.log("Error 1");
             if (error.response.data.body)
                this.commentError = error.response.data.body[0];

             console.log("Error 2");
             console.log(error.response.status);

             console.log("Error 3");
             console.log(error.response.headers);
           } else if (error.request) {
             console.log("Error 4");
             console.log(error.request);
           } else {
             console.log("Error 5");
             console.log('Error', error.message);
           }
           console.log(error.config);
        }
      );
    },
  },

  created() {
    this.tweetContent = 'See "' + this.post.title + '" at ' + 'http://one.app/posts/' + this.post.slug;
    this.post.slug = "../posts/" + this.post.slug;
    this.postOwner.username = "../users/" + this.postOwner.username;

    if (this.post.image)
      this.postImage = "../images/posts/" +this.post.image;

    if (this.completePost)
    {
      this.postOwner.avatar = "../images/users/avatars/" + this.postOwner.avatar;
    }

    axios.get("http://one.app/postcomments/" +this.post.id)
    .then(
      response => {
        this.comments = response.data.comments;
      }
    )
    .catch(
      error => {
        if (error.response) {
           console.log("Error 1");
           console.log(error.response);

           console.log("Error 2");
           console.log(error.response.status);

           console.log("Error 3");
           console.log(error.response.headers);
         } else if (error.request) {
           console.log("Error 4");
           console.log(error.request);
         } else {
           console.log("Error 5");
           console.log('Error', error.message);
         }
         console.log(error.config);
      }
    );

  },

}
</script>

<style>
.post-content {
  overflow: hidden;
  box-sizing: border-box;
  background-color: #fff;
  border: 1px solid #F4F4EF;
  border-radius: 5px;
  padding: 0 2px 10px;
  margin: 10px 0;
}

.post-content-left{
  float: left;
  width: 10%;
  box-sizing: border-box;
  overflow: hidden;
}

.post-content-left-img {
  padding: 5px;
  margin-top: 4px;
}

.post-content-left img {
  width: 95%;
  height: 95%;
  border-radius: 50%;
}

.post-content-right{
  float: right;
  width: 90%;
  box-sizing: border-box;
  overflow: hidden;
}

.post-content-right ul  {
  list-style: none;
}

.post-content-right-top {
  overflow: hidden;
  box-sizing: border-box;
  background-color: #fff;
}


.post-top-left {
  float: left;
  width: 85%;
  box-sizing: border-box;
  overflow: hidden;
}

.post-top-right {
  float: right;
  width: 15%;
  box-sizing: border-box;
  overflow: hidden;
  padding-top: 10px;
}


.post-content .col-md-8 {
  border: 1px solid rgba(0, 0, 255, 0.14);
  border-radius: 5px;
  padding: 10px;
}

.commentsHorizontalTab:after {
  content: '';
  display: block;
  height: 1px;
  background-color: rgba(0, 0, 255, 0.37);
  margin: 10px 0 0;
}

.comment-content {
  overflow: hidden;
  box-sizing: border-box;
  background-color: #fff;
  border-top: 1px solid #F4F4EF;
  margin: 10px 0;
}

.comment-content-left {
  float: left;
  width: 10%;
  box-sizing: border-box;
  overflow: hidden;
}

.comment-content-middle {
  float: left;
  width: 84%;
  box-sizing: border-box;
  overflow: hidden;
}

.comment-content-right{
  float: left;
  width: 6%;
  box-sizing: border-box;
  overflow: hidden;
  padding-top: 10px;
}

</style>
