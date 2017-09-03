<template>
  <div class="col-md-12 create-post">
    <form @submit.prevent="submitPost">
      <div class="col-md-12 form-input-space" v-show="!createNewPost" style="padding: 10px 10px 0;">
        <input @click="createNewPost = true" type="text" class="form-control form-title" placeholder="Create New Post....." />
      </div>

      <div v-show="createNewPost">
        <div class="col-md-12 form-input-space" style="text-align:right;">
          <i @click="createNewPost = false" title="Cancel" class="fa fa-times" aria-hidden="true"></i>
        </div>

        <div class="col-md-12">
          Category:
          <span v-show="!remCats">
            <select class="form-control" v-model="selectedCat">
              <option v-for="category in myCategories">{{ category.name }}</option>
            </select>
          </span>

          <span v-show="remCats">
            <select class="form-control" v-model="selectedCat">
              <option v-for="category in remainingCats">{{ category.name }}</option>
            </select>
          </span>
        </div>

        <div class="col-md-12" style="margin: 10px 0;">
          <input @click="remCats = !remCats" type="checkbox" class="custom-control-input"> Other Categories
        </div>

        <div class="col-md-12 form-input-space">
          <input v-model="title" type="text" class="form-control form-title" required placeholder="Title: " minlength="5" maxlength="255" />
          <span class="help-block danger">
            {{ titleError }}
          </span>
        </div>

        <div class="col-md-12 form-input-space">
          <input v-model="slug" type="text" class="form-control form-slug" required placeholder="Slug: " minlength="5" maxlength="255" />
          <span class="help-block danger">
            {{ slugError }}
          </span>
          Generate Slug
        </div>

        <div class="col-md-12 form-input-space">
          <textarea v-model="body" class="form-control" cols="50" rows="7" placeholder="Body:"></textarea>
          <span class="help-block danger">
            {{ bodyError}}
          </span>
        </div>

        <div class="col-md-12 form-input-space post-image">
          <div v-if="!image">
            <input type='file' class='post-img'  id='img'style='visibility:hidden; height: 11px;' @change="imageChanged" />
            <label title='Please Choose an Image' for='img'><p class="add-post-img"><i class="fa fa-plus-circle fa-lg" aria-hidden="true"></i> Add Image</p></label>
          </div>

          <div v-else>
            <div class="post-create-img-container">
              <img :src="image" class="post-create-img"/>
                <div class="middle">
                  <button class="btn btn-danger"  @click="removeImage">Remove Image</button>
                </div>
              </div>
          </div>
        </div>

        <div class="col-md-12" style="text-align: center; margin-top:11px;">
          <button class="btn btn-primary btn-lg btn-block" type="submit">Save Post</button>
        </div>
      </div>
    </form>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  props: ['remainingCats', 'myCategories'],

  data() {
    return {
      createNewPost: false,
      title: '',
      slug: '',//automatically created after title, must be unique
      body: '',
      image:'',

      titleError: '',
      slugError: '',
      bodyError: '',

      remCats: false,
      selectedCat: '',
      selectedCatID: '',
      searchCat: [],
    }
  },

  methods: {
    imageChanged(e) {
      var fileReader = new FileReader();
      fileReader.readAsDataURL(e.target.files[0]);

      fileReader.onload = (e) => {
        this.image = e.target.result
      }
    },

    removeImage: function (e) {
      this.image = '';
    },

    submitPost() {
      this.remCats ? (this.searchCat = this.remainingCats) :  (this.searchCat = this.myCategories);

      const position  = this.searchCat.findIndex(
        (element) => {
          return element.name == this.selectedCat;
        }
      );

      this.selectedCatID = this.searchCat[position].id;

      axios.post("http://one.app/posts/", {
        title: this.title,
        slug: this.slug,
        body: this.body,
        image: this.image,
        category: this.selectedCatID,
      })
      .then(
        response => {
          console.log(response);
          //console.log(response.data.post);
          this.$emit('newPost', response.data.post);

          this.createNewPost = false;
          this.title = '';
          this.titleError = '';
          this.slug = '';
          this.slugError = '';
          this.body = '';
          this.bodyError = '';
          this.image = '';
          this.selectedCat = '';
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
             if (error.response.data.title)
                this.titleError = error.response.data.title[0];

             if (error.response.data.slug)
                this.slugError = error.response.data.slug[0];

             if (error.response.data.body)
                this.bodyError = error.response.data.body[0];

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
  },

  created() {

  },

}
</script>

<style>
.select2-container{
  width: 100% !important;
}

.select2-container--default .select2-selection--single {
  border-radius: 0 !important;
}

textarea {
  border: 0 !important;
  border-radius: 0 !important;
}
</style>
