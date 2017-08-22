<template>
  <div class="container">

    <div class="row">
      <div class="col-md-9">
        <user-data
          :user="profileUser"
          :own="owner">
        </user-data>

        <div class="horizontalTab"></div>

        <div class="feeds">

          <div class="feeds-left">
            <p class="horizontalTabSmall">Feeds</p>
            <ul class="nav nav-pills nav-stacked">
              <li class="active"><a data-toggle="pill" href="#posts">Posts&nbsp;<span class="badge">{{ profileUser.posts_no }}</span></a></li>
              <li><a data-toggle="pill" href="#comments">Comments&nbsp;<span class="badge">{{ profileUser.comments_no }}</span></a></li>
              <li><a data-toggle="pill" href="#replies">Replies&nbsp;<span class="badge">{{ profileUser.replies_no }}</span></a></li>
            </ul>
          </div>

          <div class="feeds-right">
              <div class="tab-content info">
                <user-posts
                  :user="profileUser"
                  :own="owner"
                  :currentUser="currentUser"
                  :loggedIn="loggedIn"
                  >
                </user-posts>

                <div id="comments" class="tab-pane fade">
                  <p class="horizontalTabSmall">Comments</p>
                  <!--@if( !$user->comments_no and ($user->id != Auth::id()) )-->
                    <p class="lead" v-show="!profileUser.comments_no && !owner">This User has No Comments</p>
                </div>

                <div id="replies" class="tab-pane fade">
                  <p class="horizontalTabSmall">Replies</p>
                  <!--@if( !$user->replies_no and ($user->id != Auth::id()) )-->
                    <p class="lead" v-show="!profileUser.replies_no && !owner">This User has No Replies</p>
                </div>
              </div>
          </div>
        </div>

      </div>

      <div class="col-md-3">
        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  props: ['currentUser', 'profileUser', 'loggedIn'],

  data() {
    return {
      owner: false,
    }
  },

  methods: {
  },

  created() {
    this.profileUser.avatar = "../images/users/avatars/" + this.profileUser.avatar;

    if (this.currentUser) {//if logged in User
      if (this.currentUser.id == this.profileUser.id) {
        this.owner= true;
      }
    }
    else {
      console.log("Not logged in");
    }
  },

}
</script>
