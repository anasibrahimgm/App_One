<template>
  <div class="container">

    <div class="row">
      <div class="col-md-9">
        <user-data
          :user="profileUser"
          :own="owner"
        >
        </user-data>

        <div class="horizontalTab"></div>

        <div class="feeds">

          <div class="feeds-left">
            <p class="horizontalTabSmall">Feeds</p>
            <ul class="nav nav-pills nav-stacked">
              <li class="active"><a data-toggle="pill" href="#posts">Posts&nbsp;<span class="badge">{{ profileUser.posts_no }}</span></a></li>
              <li><a data-toggle="pill" href="#cats">Categories&nbsp;<span class="badge">{{ profileUser.categories.length }}</span></a></li>
              <li><a data-toggle="pill" href="#replies">Replies&nbsp;<span class="badge">{{ profileUser.replies_no }}</span></a></li>
            </ul>
          </div>

          <div class="feeds-right">
              <div class="tab-content info">

                <div id="posts" class="tab-pane fade in active">
                  <user-posts
                    :user="profileUser"
                    :authId="authId"
                    :allcategories="allcategories"
                  >
                  </user-posts>
                </div>
                <div id="cats" class="tab-pane fade">

                  <p class="horizontalTabSmall">Categories</p>
                    <!--p class="lead" v-show="!profileUser.comments_no && !owner">This User has No Comments</p-->
                    <h1>All Categories</h1>
                    <p style="color: #F30" v-for="category in allcategories">
                      {{ category.name }}
                    </p>

                    <h1>User Categories</h1>
                    <p style="color: #F3E" v-for="category in profileUser.categories">
                      {{ category.name }}
                    </p>
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
  props: ['profileUser', 'authId'],

  data() {
    return {
      owner: false,
      allcategories: [],
    }
  },

  methods: {

  },

  created() {

    if (this.authId && (this.authId == this.profileUser.id) )
    {
      this.owner= true;
    }

    this.profileUser.avatar = "../images/users/avatars/" + this.profileUser.avatar;

    axios.get("http://one.app/categories/")
    .then(
      response => {
        if (response.data.categories)
          this.allcategories = response.data.categories;
        })
    .catch(
      error => {
         console.log(error);
       });
         
  },

}
</script>
