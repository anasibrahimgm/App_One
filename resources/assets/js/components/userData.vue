<template>
  <div class="user-basicInfo">
    <div class="basicInfo-left">
      <!--img :src="user_avatar" /-->
      <div class="post-create-img-container">
        <img :src="user_avatar" class="post-create-img"/>
          <div class="middle" style="top: 3%; left: 5%;">
            <button class="btn btn-danger" >Remove Image</button>
          </div>
      </div>
    </div>

    <div class="basicInfo-right">
      <div class="info">
        <span v-show="!canEditName">
          <h3 class="userName"> {{ user_name }} <i v-show="owner" v-on:click="showEditName" class="fa fa-pencil" aria-hidden="true"></i></h3>
        </span>

        <span v-show="canEditName">
          <input type="text" v-model="user_name" v-on:keyup.enter="editName" v-on:keyup.esc="cancelEditName" class="form-control userName userNameEdit"/>
        </span>

        <span v-show="!canEditBio">
          <p class="userBio"> {{ user.bio }} <i v-show="owner" v-on:click="showEditBio" class="fa fa-pencil" aria-hidden="true"></i></p>
        </span>

        <span v-show="canEditBio">
          <textarea class="form-control userBio userBioEdit" rows="5" cols="40" placeholder="Bio" v-model="user_bio">
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
      user_avatar: this.user.avatar,
      user_name: this.user.name,
      user_bio: this.user.bio,

      canEditName: false,
      canEditBio: false,
      owner: this.own,
    }
  },

  methods: {
    showEditName() {
      this.canEditName = true;
    },

    editName() {
      console.log(this.user_name);
      this.canEditName = false;
      axios.put("http://one.app/changeProfile", {
        name: this.user_name,
      })
      .then(
        response => {
          console.log(response);
        }
      )
      .catch(
        error => {
          console.log(error);
          if (error.response) {
            console.log("Error 1");
             // The request was made and the server responded with a status code
             // that falls out of the range of 2xx
             console.log(error.response.data);

             console.log("Error 2");
             console.log(error.response.status);

             console.log("Error 3");
             console.log(error.response.headers);
           } else if (error.request) {
             // The request was made but no response was received
             // `error.request` is an instance of XMLHttpRequest in the browser and an instance of
             // http.ClientRequest in node.js
             console.log("Error 4");
             console.log(error.request);
           } else {
             // Something happened in setting up the request that triggered an Error
             console.log("Error 5");
             console.log('Error', error.message);
           }
           console.log(error.config);
        }
      );
    },

    cancelEditName() {
      this.canEditName = false;
    },

    showEditBio() {
      this.canEditBio = true;
    },

    editBio() {

    },

    cancelEditBio() {
      this.canEditBio = false;
    },
  },

  created() {
      console.log(this.user);
    //if (this.usertype === 'owner') {
      //this.owner = true;
    //}

  }

}
</script>
