<template>
    <li><a @mouseover="checkData" id="currentUser_data" :href="'/users/' +user_username"><img  :src="'../images/users/avatars/' + user_avatar" /><span id="currentUser_name"> {{  user_name }}</span></a></li>
</template>

<script>
export default {
  props: ['authUser'],

  data() {
    return {
      user_username: this.authUser.username,
      user_avatar: this.authUser.avatar,
      user_name: this.authUser.name.split(" ")[0],
    }
  },

  methods: {
    checkData() {
      axios.put("http://one.app/updateProfile", {
      })
      .then(
        response => {
          if (response.data.user)
          {
            //console.log(response.data.user);
            this.user_name = response.data.user.name.split(" ")[0];
            this.user_username = response.data.user.username;
            this.user_avatar = response.data.user.avatar;
          }

          if (response.data.redirect) {
            window.location.href = response.data.redirect;
          }
        }
      )
      .catch(
        error => {
          if (error.response) {
            console.log("Error 1");
             console.log(error.response.data);

           } else if (error.request) {
             console.log("Error 2");
             console.log(error.request);
           } else {
             console.log("Error 3");
             console.log('Error', error.message);
           }
           console.log(error.config);
        }
      );
    }
  },

  created() {
    //this.user_name = this.authUser.name.split(" ")[0];
  },
}

/*
<li>
  <navbar
    :auth-user='{!! Auth::user()->toJson() !!}'
  ></navbar>
</li>
*/
</script>
