<template>
	<b-form @submit="onSubmit">
		<b-alert variant="info" show>Say Something...</b-alert>
		<b-form-group>
			<b-form-input
				id="title"
				v-model="title"
				type="text"
				required
				placeholder="Title"
			></b-form-input>
		</b-form-group>
		<b-form-group>
			<b-form-textarea
				id="body"
				v-model="body"
				required
				placeholder="Body"
			></b-form-textarea>
		</b-form-group>
		<b-form-group>
			<b-form-input
				id="author"
				v-model="author"
				type="text"
				required
				placeholder="Author"
			></b-form-input>
		</b-form-group>
		<b-form-group>
			<b-form-input
				id="category_id"
				v-model="category_id"
				type="text"
				required
				placeholder="Category ID"
			></b-form-input>
		</b-form-group>
		<b-button type="submit" variant="primary">Submit</b-button>
	</b-form>
</template>

<script>
import { mapActions } from 'vuex';

export default {
	name: 'PostForm',
	data() {
		return {
			title: '',
			body: '',
			author: '',
			category_id: ''
		};
	},
	methods: {
		...mapActions(['addPost']),
		onSubmit(event) {
			event.preventDefault();

			const formData = {
				title: this.title,
				body: this.body,
				author: this.author,
				category_id: this.category_id
			};

			this.addPost(formData);

			this.title = '';
			this.body = '';
			this.author = '';
			this.category_id = '';
		}
	}
};
</script>

<style scoped>
.form-control {
	outline: none;
	box-shadow: none !important;
	border: 1px solid #ccc !important;
}
</style>
