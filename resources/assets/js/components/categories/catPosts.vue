<template>
  <div>
      <div class="col-md-12 posts-container">
        <div v-for="post in category.posts">
          <post-content
            :post-data="post"
            :authId="authId"
            >
          </post-content>
        </div>
      </div>
  </div>
</template>

<script>
export default{
  props: ['category', 'authId'],

  data() {
    return {

    }
  },

  methods: {

  },

  created() {
  },

}
</script>
