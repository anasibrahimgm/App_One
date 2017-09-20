<template>
  <div>
    <form @submit.prevent="updateProfile" class="form-horizontal">
        <div class="user-basicInfo">
          <div class="basicInfo-left">
            <div class="basicInfo-left-edit">
              <div class="profile-change-img-container">
                  <img :src="show_user_avatar" class="profile-change-img" style="height: 200px; width:200px;"/>

                  <input type='file' id='profile-img' style='visibility:hidden; height: 11px;' @change="changeAvatar" />
                  <label for='profile-img'>
                    <div class="middle" style="top: 12%; left: 11%;">
                      Change <i class="fa fa-pencil" aria-hidden="true"></i>
                    </div>
                  </label>
              </div>
            </div>
          </div>

          <div class="basicInfo-right">
            <div class="info">
              <input v-model="user_name" class="form-control userName userNameEdit" id="editName" required placeholder="Name" type="text">
              <textarea v-model="user_bio" class="form-control userBio userBioEdit" rows="5" cols="40" placeholder="Bio">{{ user_bio }}</textarea>
            </div>
          </div>
        </div>
                              <div class="horizontalTab"></div>
        <div class="edit_fields">
          <div class="edit_fields-left">
            <p>Username:</p>
          </div>

          <div class="edit_fields-right">
            <div class="form-group">
              <div class="col-md-10">
                <input v-model="user_username" class="form-control" placeholder="Username" autofocus id="username" required type="text">
              </div>
            </div>
          </div>

          </div>

          <div class="edit_fields">
            <div class="edit_fields-left">
              <p>Email:</p>
            </div>
            <div class="edit_fields-right">
              <div class="form-group">
                <div class="col-md-10">
                  <input v-model="user_email" class="form-control" placeholder="E-Mail Address" required type="email">
                </div>
              </div>
            </div>
          </div>

          <div class="edit_fields">
            <div class="edit_fields-left">
              <p>Password:</p>
            </div>
            <div class="edit_fields-right">
              <div class="form-group">
                <div class="col-md-10">
                  <input v-model="user_password" class="form-control" placeholder="Change Password" id="password" type="password">
                </div>
              </div>

              <div class="form-group">
                <div class="col-md-10">
                  <input v-bind:class="{red:confirmClass}" v-model="user_password_confirmation" class="form-control" placeholder="Confirm Password Change" id="password-confirm"  type="password">
                </div>
              </div>
            </div>
          </div>

            <div class="form-group">
                <div style="text-align: center">
                  <input class="btn btn-primary btn-lg" type="submit" value="Save Changes" v-bind:disabled="confirmClass" />
                </div>
            </div>

        </form>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  props: ['authUser'],

  data() {
    return {
      user_avatar: this.authUser.avatar,
      show_user_avatar: "images/users/avatars/" + this.authUser.avatar,
      user_name: this.authUser.name,
      user_bio: this.authUser.bio,
      user_username: this.authUser.username,
      user_email: this.authUser.email,
      user_password: '',
      user_password_confirmation: '',
    }
  },

  methods: {
    changeAvatar(e) {
      var fileReader = new FileReader();
      fileReader.readAsDataURL(e.target.files[0]);

      fileReader.onload = (e) => {
        this.user_avatar = e.target.result;
        this.show_user_avatar = e.target.result;
      }
    },

    updateProfile() {
        axios.put("http://anasibrahimgm-app-one.herokuapp.com/updateProfile", {
          avatar: this.user_avatar,
          name: this.user_name,
          bio: this.user_bio,
          username: this.user_username,
          email: this.user_email,
          password: this.user_password,
        })
        .then(
          response => {
            console.log(response);
            this.user_password = '';
            this.user_password_confirmation = '';

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
    },
  },

  computed: {
    confirmClass() {
        if (this.user_password != this.user_password_confirmation)
        {
          return true;
        }
    },
  },

  created() {
    console.log(this.authUser);
  },

}
</script>

<style scoped>
.red {
  color: #C9302C;
  background-color: rgba(169, 68, 66, 0.23);
}
</style>
