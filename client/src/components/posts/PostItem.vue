<template>
  <b-card bg-variant="light" class="text-center mb-3" style="min-width: 18rem;">
    <b-card-body>
      <b-card-title>{{post.title}}</b-card-title>
      <b-card-sub-title class="mb-2">
        <b-badge variant="secondary">{{post.name}}</b-badge>
      </b-card-sub-title>
      <b-card-text>{{post.body}}</b-card-text>
      <b-card-text>
        by
        <strong>{{post.author}}</strong>
      </b-card-text>
    </b-card-body>
    <b-button class="mx-1" variant="info" :to="`/post/edit/${post.id}`">Edit</b-button>
    <b-button class="mx-1" variant="danger">Delete</b-button>
  </b-card>
</template>

<script>
export default {
  name: 'PostItems',
  props: ['post']
};
</script>

<style>
</style>