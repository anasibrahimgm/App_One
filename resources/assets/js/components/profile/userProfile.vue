<template>
  <div class="container">

    <div class="row">
      <div class="col-md-12">
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
              <li><a data-toggle="pill" href="#cats">Categories&nbsp;<span class="badge">{{ usercategories.length }}</span></a></li>
              <li><a data-toggle="pill" href="#replies">Replies&nbsp;<span class="badge">{{ profileUser.replies_no }}</span></a></li>
            </ul>
          </div>

          <div class="feeds-right">
              <div class="tab-content info">

                <div id="posts" class="tab-pane fade in active">
                  <posts
                    :user-data="profileUser"
                    :authId="authId"
                  >
                  </posts>
                </div>
                <div id="cats" class="tab-pane fade">

                  <p class="horizontalTabSmall">Categories</p>
                    <h3 v-show="owner">My Categories</h3>
                    <h4 v-show="!usercategories.length"><i>No Subscribed Categories</i></h4>
                    <span v-for="category in usercategories" class="label label-success">
                      <a data-toggle="tooltip" data-placement="top" data-html="true" :title="category.description.length > 50 ? (category.description.substr(0, 50) + '....') : category.description" :href="'../categories/' + category.id">{{ category.name }}</a>  <i class="fa fa-minus-circle" aria-hidden="true" v-show="owner" @click="subscribe(category.id, false)" title="Unsubscribe"></i></span>
                    </span>

                    <div v-show="owner">
                      <h3>Other Categories</h3>
                      <span v-for="category in remainingCats" class="label label-primary">
                        <a data-toggle="tooltip" data-placement="top" data-html="true" :title="category.description.length > 50 ? (category.description.substr(0, 50) + '....') : category.description" :href="'../categories/' + category.id">{{ category.name }}</a>  <i class="fa fa-plus-circle" aria-hidden="true" v-show="owner" @click="subscribe(category.id, true)" title="Subscribe"></i></span>
                      </span>
                    </div>
                </div>

                <div id="replies" class="tab-pane fade">
                  <p class="horizontalTabSmall">Replies</p>
                  <p class="lead" v-show="!profileUser.replies_no && !owner">This User has No Replies</p>
                </div>
              </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</template>

<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
});

import axios from 'axios';

export default {
  props: ['profileUser', 'authId'],

  data() {
    return {
      owner: false,
      remainingCats: this.profileUser.remainingCats,
      usercategories: this.profileUser.categories,
      searchCat: [],
    }
  },

  methods: {
    subscribe(categoryId, status) {
      status ? (this.searchCat = this.remainingCats) :  (this.searchCat = this.usercategories);

      const position = this.searchCat.findIndex (
        element => {
          return element.id == categoryId;
        }
      );

      axios.post('http://one.app/categories/' + categoryId + '/subscribe' )
      .then(
        response => {
          console.log(response);
          if (response.data.category)
          {
            if (status) { //subscribe
              this.usercategories.push(this.remainingCats[position]);//add the subscribed category to usercategories
              this.remainingCats.splice(position, 1);//delete the subscribed category from remaining categories
            }
            else { //unsubscribe
              this.remainingCats.push(this.usercategories[position]);//add the unsubscribed category to the remaining categories
              this.usercategories.splice(position, 1);//delete the subscribed category from remaining categories
            }
          }
        }
      )
      .catch(
        error => {
          console.log(error);
        }
      );
    },
  },

  created() {

    if (this.authId && (this.authId == this.profileUser.id) )
    {
      this.owner= true;

      //this.remainingCats = this.allcategories.filter(o1 => this.usercategories.filter(o2 => o2.id === o1.id).length === 0);
    }

    this.profileUser.avatar = "../images/users/avatars/" + this.profileUser.avatar;

  },

}
</script>

<style scoped>
.unsubscribe {
  cursor: pointer;
}

.label {
  margin-right: 5px;
}

.label a {
  text-decoration: none;
  color: #FFF !important;
}
</style>
