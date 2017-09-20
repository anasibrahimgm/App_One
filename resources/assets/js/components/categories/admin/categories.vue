<template>
  <div>
    <form @submit.prevent="createNewCategory">
      <div class="col-md-8 col-md-offset-2 form-input-space">
        <input v-model="newCategoryName" type="text" class="form-control" required placeholder="Category Name: " minlength="5" maxlength="100" />
        <span class="help-block danger">
          {{ newCategoryNameError }}
        </span>
      </div>

      <div class="col-md-8 col-md-offset-2 form-input-space">
        <textarea v-model="newCategoryDesc" class="form-control" cols="50" rows="3" placeholder="Category Description: " required minlength="5" maxlength="255"></textarea>
        <span class="help-block danger">
          {{ newCategoryDescError }}
        </span>
      </div>

      <div class="col-md-4 col-md-offset-4" style="text-align: center; margin-top:11px;">
        <button class="btn btn-success" type="submit">Create New Category </button>
      </div>
    </form>
    <div v-show="categories.length" class="col-md-8 col-md-offset-2 cats_table">
      <table class="table">
      <thead>
        <th class="name">Name</th>
        <th class="desc">Description</th>
        <th class="adminName">Creator</th>
        <th class="users_count">Users</th>
        <th class="posts_count">Posts</th>
        <th class="actions"></th>
      </thead>

      <tbody>
          <tr v-for="category in categories">
            <td class="name">
              <p>{{ category.name }}</p>
            </td>
            <td class="desc">
              <p>{{ category.description }}</p>
            </td>
            <td class="adminName">{{ category.admin.name }}</td>
            <td class="users_count">{{ category.users_count }}</td>
            <td class="posts_count">{{ category.cat_posts_count }}</td>
            <td class="actions">
              <span v-show="accessActions(category)">
                <button @click="deleteCategory(category.id)" class="btn btn-danger btn-sm"><i title="Delete Post" class="fa fa-2x fa-trash-o" aria-hidden="true"></i></button>

                <button class="btn btn-default btn-sm" data-toggle="modal" :data-target="'#editModal' + category.id" @click="editCategory(category)"><i title="Edit Post" class="fa fa-2x fa-pencil-square-o" aria-hidden="true"></i></button>
                <div class="modal fade" :id="'editModal' + category.id" role="dialog">
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                      <div class="modal-header" style="text-align:left;">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Delete?</h4>
                      </div>
                      <div class="modal-body" style="text-align:left;">
                        <div>
                          <input v-model="editCategoryName" type="text" class="form-control" required placeholder="New Category Name: " minlength="5" maxlength="100" />
                          <span class="help-block danger">
                            {{ editCategoryNameError }}
                          </span>
                        </div>

                        <div>
                          <textarea v-model="editCategoryDesc" class="form-control" cols="50" rows="3" placeholder="New Category Description: " required minlength="5" maxlength="255"></textarea>
                          <span class="help-block danger">
                            {{ editCategoryDescError }}
                          </span>
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button @click="updateCategory(category, editCategoryName, editCategoryDesc)" type="button" class="btn btn-primary">Update</button>
                      </div>
                    </div>
                  </div>
                </div>
              </span>
            </td>
          </tr>
      </tbody>
    </table>
    </div>
  </div>
</template>

<script>

export default{

  props: ['currentAdmin', 'a'],

  data() {
    return {
      categories: [],
      newCategoryName: '',
      newCategoryNameError: '',
      newCategoryDesc: '',
      newCategoryDescError: '',

      editCategoryName: '',
      editCategoryNameError: '',
      editCategoryDesc: '',
      editCategoryDescError: '',
    }
  },

  methods: {
    accessActions(category) {
      if ((category.admin.id == this.currentAdmin.id) || (this.currentAdmin.role == 1) || (this.currentAdmin.role < category.admin.role))
      {
        return true;
      }
    },

    createNewCategory() {
      axios.post("http://anasibrahimgm-app-one.herokuapp.com/admin/categories/create", {
        name: this.newCategoryName,
        description: this.newCategoryDesc,
      })
      .then(
        response => {
          console.log(response);
          this.newCategoryName = '';
          this.newCategoryNameError = '';
          this.newCategoryDesc = '';
          this.newCategoryDescError = '';
          this.categories.unshift(response.data.category);
        }
      )
      .catch(
        error => {
          //console.log(error);
          if (error.response) {
            console.log("Error 1");
             console.log(error.response.data);

             if (error.response.data.name)
               this.newCategoryNameError = error.response.data.name[0];
             else
               this.newCategoryNameError = '';

             if (error.response.data.description)
               this.newCategoryDescError = error.response.data.description[0];
             else
                this.newCategoryDescError = '';
           }
        }
      );
    },

    editCategory(category) {
      this.editCategoryName = category.name;
      this.editCategoryDesc = category.description;
    },

    updateCategory(category, editCategoryName, editCategoryDesc) {
      axios.put("http://anasibrahimgm-app-one.herokuapp.com/admin/categories/" + category.id + "/edit", {
        name: editCategoryName,
        description: editCategoryDesc,
      })
      .then(
        response => {
          console.log(response);
          category.name = response.data.category.name;
          category.description = response.data.category.description;

          this.editCategoryNameError = '';
          this.editCategoryDescError = '';
        }
      )
      .catch(
        error => {
          if (error.response) {
            console.log("Error 1");
             console.log(error.response.data);

             if (error.response.data.name)
               this.editCategoryNameError = error.response.data.name[0];
             else
               this.editCategoryNameError = '';

             if (error.response.data.description)
               this.editCategoryDescError = error.response.data.description[0];
             else
                this.editCategoryDescError = '';
           }
         }
      );
    },

    deleteCategory(id) {
      axios.delete("http://anasibrahimgm-app-one.herokuapp.com/admin/categories/" + id + "/delete")
      .then(
        response => {
          console.log(response);

          const position  = this.categories.findIndex(
            (element) => {
              return element.id == id;
            }
          );
          this.categories.splice(position, 1);
          console.log(this.categories);
        }
      )
      .catch(
        error => {
          console.log(error);
          if (error.response) {
            console.log("Error 1");
             console.log(error.response.data);

           }
        }
      );
    },
  },

  computed: {

  },

  created() {
    //console.log("this.currentAdmin: ");
    //console.log(this.currentAdmin);
    axios.get("http://anasibrahimgm-app-one.herokuapp.com/admin/categories/show")
    .then(
      response => {
        console.log(response);
        this.categories = response.data.categories;
      }
    )
    .catch(
      error => {
        console.log(error);
        if (error.response) {
          console.log("Error 1");
           console.log(error.response.data);
         }
      }
    );
  },

}
</script>

<style scoped>
.cats_table {
  margin-top: 50px;
  border: 2px solid #FFF;
  padding: 5px 0;
  border-radius: 5px;
}

th {
  padding-left: 8px;
}

td {
  padding-left: 5px;
}

tr {
  overflow: hidden;
  box-sizing: border-box;
  background-color: #fff;
  border: 1px solid #F4F4EF;
  margin: 10px 0;
}

.name {
  float: left;
  width: 20%;
  box-sizing: border-box;
  overflow: hidden;
}

.desc {
  float: left;
  width: 40%;
  box-sizing: border-box;
  overflow: hidden;
}

.adminName {
  float: left;
  width: 13%;
  box-sizing: border-box;
  overflow: hidden;
}

.users_count {
  float: left;
  width: 7%;
  box-sizing: border-box;
  overflow: hidden;
}

.posts_count {
  float: left;
  width: 7%;
  box-sizing: border-box;
  overflow: hidden;
}

.actions{
  float: right;
  width: 13%;
  box-sizing: border-box;
  overflow: hidden;
}

.fa-trash-o:hover {
  color: #FFF;
}

</style>
