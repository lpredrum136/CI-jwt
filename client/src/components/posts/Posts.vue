<template>
  <b-container class="mt-4">
    <p v-if="myPost.loading">Loading...</p>
    <template v-else>
      <PostForm />
      <hr />
      <b-card-group deck>
        <PostItem v-for="post in myPost.posts" :key="post.id" :post="post" />
      </b-card-group>
    </template>
  </b-container>
</template>

<script>
import { mapGetters, mapActions } from 'vuex';
import PostItem from './PostItem';
import PostForm from './PostForm';

export default {
  name: 'Posts',
  components: { PostItem, PostForm },
  computed: mapGetters(['myPost']),
  methods: mapActions(['getPosts']),
  created() {
    this.getPosts();
  }
};
</script>

<style></style>
