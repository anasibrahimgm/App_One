<template>
  <div class="user-basicInfo">
    <div class="basicInfo-left">
      <img v-show="!owner" :src="user_avatar" style="height: 160px;"/>

      <div v-show="owner" class="profile-change-img-container">
          <img :src="user_avatar" class="profile-change-img"/>

          <input type='file' id='profile-img' style='visibility:hidden; height: 11px;' @change="changeAvatar" />
          <label for='profile-img'>
            <div class="middle" style="top: 4%; left: 11%;">
              Change <i class="fa fa-pencil" aria-hidden="true"></i>
            </div>
          </label>

      </div>
    </div>

    <div class="basicInfo-right">
      <div class="info">
        <span v-show="!showEditName">
          <h3 class="userName"> {{ user_name_show }} <i v-show="owner" v-on:click="showEditName = true" class="fa fa-pencil" aria-hidden="true"></i></h3>
        </span>

        <span v-show="showEditName">
          <input type="text" v-model="user_name" v-on:keyup.enter="editName" v-on:keyup.esc="showEditName = false" class="form-control userName userNameEdit"/>
        </span>

        <span v-show="!showEditBio">
          <p class="userBio"> {{ user_bio_show }} <i v-show="owner" v-on:click="showEditBio = true" class="fa fa-pencil" aria-hidden="true"></i></p>
        </span>

        <span v-show="showEditBio">
          <textarea class="form-control userBio userBioEdit" rows="5" cols="40" placeholder="Bio" v-model="user_bio" v-on:keyup.esc="showEditBio = false" v-on:keyup.enter="editBio">
          </textarea>
        </span>
      </div>
    </div>

  </div>
</template>

<script>
export default{
  props: ['user', 'own'],

  data() {
    return {
      owner: this.own,

      user_avatar: this.user.avatar,
      user_avatar_show: this.user.avatar,
      user_name: this.user.name,
      user_name_show: this.user.name,
      user_bio: this.user.bio,
      user_bio_show: this.user.bio,

      showEditName: false,
      showEditBio: false,
    }
  },

  methods: {
    changeAvatar(e) {
      var fileReader = new FileReader();
      fileReader.readAsDataURL(e.target.files[0]);

      fileReader.onload = (e) => {
        this.user_avatar = e.target.result;
        this.user_avatar_show = e.target.result;

        axios.put("http://anasibrahimgm-app-one.herokuapp.com/updateProfile", {
          avatar: this.user_avatar,
        })
        .then(
          response => {
            console.log(response);
          }
        )
        .catch(
          error => {
            if (error.response) {
              console.log("Error 1");
               console.log(error.response);

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

    editName() {
      this.showEditName = false;
      this.user_name_show = this.user_name;
      axios.put("http://anasibrahimgm-app-one.herokuapp.com/updateProfile", {
        name: this.user_name,
      })
      .then(
        response => {
          console.log(response);
        }
      )
      .catch(
        error => {
          if (error.response) {
            console.log("Error 1");
             console.log(error.response);

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

    editBio() {
      this.showEditBio = false;
      this.user_bio_show = this.user_bio;
      axios.put("http://anasibrahimgm-app-one.herokuapp.com/updateProfile", {
        bio: this.user_bio,
      })
      .then(
        response => {
          console.log(response);
        }
      )
      .catch(
        error => {
          if (error.response) {
            console.log("Error 1");
             console.log(error.response);

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

  created() {

  },

}
</script>
