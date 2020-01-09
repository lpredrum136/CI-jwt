<template>
  <b-card bg-variant="light" class="text-center mb-3" style="min-width: 18rem;">
    <b-card-body>
      <b-card-title>{{ post.title }}</b-card-title>
      <b-card-sub-title class="mb-2">
        <b-badge variant="secondary">{{ post.name }}</b-badge>
      </b-card-sub-title>
      <b-card-text>{{ post.body }}</b-card-text>
      <b-card-text>
        by
        <strong>{{ post.author }}</strong>
      </b-card-text>
    </b-card-body>
    <template v-if="myAuth.loading">Loading post...</template>
    <template v-else-if="myAuth.user !== null">
      <template v-if="myAuth.user.privilege == 'admin'">
        <b-button class="mx-1" variant="info" :to="`/post/edit/${post.id}`">Edit</b-button>
        <b-button class="mx-1" variant="danger" @click="deletePost(post.id)">Delete</b-button>
      </template>
      <template v-if="myAuth.user.privilege == 'user' && myAuth.user.username == post.author">
        <b-button class="mx-1" variant="info" :to="`/post/edit/${post.id}`">Edit</b-button>
        <b-button class="mx-1" variant="danger" @click="deletePost(post.id)">Delete</b-button>
      </template>
    </template>
  </b-card>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';

export default {
  name: 'PostItems',
  props: ['post'],
  computed: mapGetters(['myAuth']),
  methods: { ...mapActions(['deletePost']) }
};
</script>

<style></style>
