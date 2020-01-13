<template>
  <b-container class="mt-4">
    <p v-if="myPost.loading || myAuth.loading">...Loading</p>
    <b-alert
      v-else-if="myPost.post !== null && myPost.post.author !== myAuth.user.username && myAuth.user.privilege !== 'admin'"
      show
      variant="danger"
    >Unauthorised</b-alert>
    <b-form v-else-if="myPost.post !== null" @submit="onSubmit">
      <b-alert variant="info" show>Edit your post</b-alert>
      <b-form-group>
        <b-form-input
          id="title"
          v-model="myPost.post.title"
          type="text"
          required
          placeholder="Title"
        ></b-form-input>
      </b-form-group>
      <b-form-group>
        <b-form-textarea id="body" v-model="myPost.post.body" required placeholder="Body"></b-form-textarea>
      </b-form-group>
      <b-form-group>
        <b-form-input
          id="author"
          v-model="myPost.post.author"
          type="text"
          required
          placeholder="Author"
        ></b-form-input>
      </b-form-group>
      <b-form-group>
        <b-form-input
          id="category_id"
          v-model="myPost.post.category_id"
          type="text"
          required
          placeholder="Category ID"
        ></b-form-input>
      </b-form-group>
      <b-button type="submit" variant="primary">Submit</b-button>
    </b-form>
  </b-container>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';

export default {
  name: 'PostEdit',

  computed: mapGetters(['myPost', 'myAuth']),
  methods: {
    ...mapActions(['getPost', 'editPost']),
    onSubmit(event) {
      event.preventDefault();

      const id = this.$route.params.id;
      const formData = {
        title: this.myPost.post.title,
        body: this.myPost.post.body,
        author: this.myPost.post.author,
        category_id: this.myPost.post.category_id
      };

      this.editPost({ id, formData });
    }
  },
  created() {
    this.getPost(this.$route.params.id);
  }
};
</script>

<style></style>
