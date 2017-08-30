<template>
  <div class="col-md-8 col-md-offset-2">
    <form @submit.prevent="submitPost">
      <div class="col-md-6">
        <i class="fa fa-calendar" aria-hidden="true"></i> Created At: {{ post.created_at}}
      </div>
      <div class="col-md-6">
        <i class="fa fa-calendar" aria-hidden="true"></i> Updated At:  {{ post.updated_at}}
      </div>
      <br/><br/>

      <div class="col-md-12">
        Category: {{ post.category.name }}
        <span v-show="!allCats">
          <select class="form-control" v-model="selectedCat">
            <option v-for="category in post.user.categories">{{ category.name }}</option>
            <!--option value="" :selected="anasibrahim">one</option>
             :selected="category.id == post.category.id ? true : false"
            <option value="">two</option-->
          </select>
        </span>

        <span v-show="allCats">
          <select class="form-control" v-model="selectedCat">
            <option v-for="category in allcategories">{{ category.name }}</option>
          </select>
        </span>
      </div>

      <div class="col-md-12" style="margin: 10px 0;">
        <input @click="allCats = !allCats" type="checkbox" class="custom-control-input"> All Categories
      </div>

      <div class="col-md-12 form-input-space">
        Title:
        <input v-model="title" type="text" class="form-control form-title" required placeholder="Title: " minlength="5" maxlength="255" />
        <span class="help-block danger">
          {{ titleError }}
        </span>
      </div>

      <div class="col-md-12 form-input-space">
        Slug:
        <input v-model="slug" type="text" class="form-control form-slug" required placeholder="Slug: " minlength="5" maxlength="255" />
        <span class="help-block danger">
          {{ slugError }}
        </span>
      </div>

      <div class="col-md-12 form-input-space">
        Body:
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
            <img :src="showImage" class="post-create-img" style="max-height:450px;"/>
              <div class="middle">
                <button class="btn btn-danger"  @click="removeImage">Remove Image</button>
              </div>
            </div>
        </div>
      </div>

      <div class="col-md-12" style="text-align: center; margin-top:11px;">
        <button class="btn btn-primary btn-lg btn-block" type="submit">Update Post</button>
      </div>
    </form>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  props: ['post'],
  data() {
    return {
      anasibrahim: true,
      title: this.post.title,
      slug: this.post.slug,//automatically created after title, must be unique
      body: this.post.body,
      image:'',
      showImage: '',

      titleError: '',
      slugError: '',
      bodyError: '',

      allcategories: [],
      allCats: false,
      selectedCat: '',
      selectedCatID: this.post.category.id,
    }
  },

  methods: {
    imageChanged(e) {
      var fileReader = new FileReader();
      fileReader.readAsDataURL(e.target.files[0]);

      fileReader.onload = (e) => {
        this.image = e.target.result
        this.showImage = e.target.result
      }
    },

    removeImage: function (e) {
      this.image = '';
        this.showImage = '';
    },

    submitPost() {
      const position  = this.allcategories.findIndex(
        (element) => {
          return element.name == this.selectedCat;
        }
      );
      
      if (this.allcategories[position])
        this.selectedCatID = this.allcategories[position].id;

      if (this.image)
        console.log("this.image : " + this.image);

      axios.put("http://one.app/posts/" + this.post.id, {
        title: this.title,
        slug: this.slug,
        body: this.body,
        image: this.image,
        category: this.selectedCatID,
      })
      .then(
        response => {
          console.log(response);
          window.location.href = "../" + response.data.post.slug;
        }
      )
      .catch(
        error => {
          console.log(error);
          if (error.response) {
            console.log("Error 1");
            console.log(error.response.data);
            if (error.response.data.title)
               this.titleError = error.response.data.title[0];

            if (error.response.data.slug)
               this.slugError = error.response.data.slug[0];

            if (error.response.data.body)
               this.bodyError = error.response.data.body[0];
           }
        }
      );

    },
  },

  created() {
    axios.get("http://one.app/categories/")
    .then(
      response => {
        if (response.data.categories)
          this.allcategories = response.data.categories;
        })
    .catch(
      error => {
         console.log(error);
       });

    if (this.post.image)
    {
      this.image = this.post.image;
      this.showImage = "../../images/posts/" + this.image;
    }
  },

}
</script>
