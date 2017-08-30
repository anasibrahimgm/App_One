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
                  <user-posts
                    :user="profileUser"
                    :authId="authId"
                    :allcategories="allcategories"
                  >
                  </user-posts>
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
                      <span v-for="category in remainingcategories" class="label label-primary">
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
  props: ['profileUser', 'allcategories', 'authId'],

  data() {
    return {
      owner: false,
      remainingcategories: [],
      usercategories: this.profileUser.categories,
    }
  },

  methods: {
    subscribe(categoryId, status) {

      const position = this.allcategories.findIndex (
        element => {
          return element.id == categoryId;
        }
      );

      axios.post('http://one.app/categories/' + categoryId + (status ? '/subscribe' : '/unsubscribe') )
      .then(
        response => {
          console.log(response);
          if (response.data.category)
          {
            if (status) { //subscribe
              this.usercategories.push(this.allcategories[position]);//add the subscribed category to usercategories
              this.remainingcategories.splice(position, 1);//delete the subscribed category from remaining categories
            }
            else { //unsubscribe
              this.remainingcategories.push(this.allcategories[position]);//add the unsubscribed category to the remaining categories
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

      this.remainingcategories = this.allcategories.filter(o1 => this.usercategories.filter(o2 => o2.id === o1.id).length === 0);
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
