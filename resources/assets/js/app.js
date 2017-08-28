
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
import catPosts from './components/categories/catPosts.vue'


import createPost from './components/posts/createPost.vue'
import editPost from './components/posts/editPost.vue'
import postContent from './components/posts/postContent.vue'
import profilePosts from './components/posts/userPosts.vue'

import editProfile from './components/profile/editProfile.vue'
import userData from './components/profile/userData.vue'
import userProfile from './components/profile/userProfile.vue'

import navbar from './components/navbar.vue'


Vue.component('admin-categories', adminCategories);
Vue.component('category-posts', catPosts);

Vue.component('create-post', createPost);
Vue.component('edit-post', editPost);
Vue.component('post-content', postContent);
Vue.component('user-posts', profilePosts);

Vue.component('edit-profile', editProfile);
Vue.component('user-data', userData);
Vue.component('user-profile', userProfile);

Vue.component('navbar', navbar);

const app = new Vue({
    el: '#app',

    data: {
        anasibrahim: 'my name is anas ibrahim',
    },
});

var osama = 'my name is anas ibrahim';
