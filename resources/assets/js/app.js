
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
import axios from 'axios';

import adminCategories from './components/categories/admin/categories.vue'
import category from './components/categories/category.vue'

import showNotifications from './components/notifications/notifications.vue'

import createPost from './components/posts/createPost.vue'
import editPost from './components/posts/editPost.vue'
import postContent from './components/posts/postContent.vue'
import posts from './components/posts/posts.vue'

import editProfile from './components/profile/editProfile.vue'
import userData from './components/profile/userData.vue'
import userProfile from './components/profile/userProfile.vue'

import navbar from './components/navbar.vue'


Vue.component('admin-categories', adminCategories);
Vue.component('category', category);

Vue.component('show-notifications', showNotifications);

Vue.component('create-post', createPost);
Vue.component('edit-post', editPost);
Vue.component('post-content', postContent);
Vue.component('posts', posts);

Vue.component('edit-profile', editProfile);
Vue.component('user-data', userData);
Vue.component('user-profile', userProfile);

Vue.component('navbar', navbar);

window.my_var = 'my name is anas ibrahim';

//console.log("my_var, app.js");
//console.log(my_var);
//console.log("my_var, app.js");

var currentUser='first';

//myFunction();

function myFunction() {
axios.get("http://anasibrahimgm-app-one.herokuapp.com/mydata/")
.then(
  response => {
    //console.log("INSIDE--currentUser, app.js");
    currentUser = response.data.currentUser;
    //console.log(currentUser);
    //console.log("INSIDE--currentUser, app.js");
  }
)
.catch(
  error => {
    ////console.log(error);
  }
);
}
//currentUser = response;

//console.log("OUTSIDE--currentUser, app.js");
//console.log(currentUser);
//console.log("OUTSIDE--currentUser, app.js");


const app = new Vue({
    el: '#app',

    data: {
        anasibrahim: 'my name is anas ibrahim',
    },
});
