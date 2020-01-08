<template>
	<b-container class="mt-4">
		<PostForm class="mb-5" />
		<b-card-group deck>
			<PostItem v-for="post in myPost.posts" :key="post.id" :post="post" />
		</b-card-group>
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
