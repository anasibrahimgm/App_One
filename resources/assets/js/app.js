
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
import userProfile from './components/userProfile.vue'
import userData from './components/userData.vue'
import profilePosts from './components/userPosts.vue'
import createPost from './components/createPost.vue'
import postContent from './components/postContent.vue'
import editProfile from './components/editProfile.vue'
import navbar from './components/navbar.vue'
import editPost from './components/editPost.vue'
import categories from './components/categories.vue'


Vue.component('user-profile', userProfile);
Vue.component('user-data', userData);
Vue.component('user-posts', profilePosts);
Vue.component('create-post', createPost);
Vue.component('post-content', postContent);
Vue.component('edit-profile', editProfile);
Vue.component('navbar', navbar);
Vue.component('edit-post', editPost);
Vue.component('show-categories', categories);

const app = new Vue({
    el: '#app',
});
