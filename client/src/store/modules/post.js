import axios from 'axios';
import router from '../../router';

const state = {
	posts: [],
	post: null,
	loading: true,
	error: {}
};

const getters = { myPost: state => state };

const actions = {
	// Get all posts
	async getPosts({ commit }) {
		try {
			const res = await axios.get('/posts');
			commit('GET_POSTS', res.data);
		} catch (error) {
			console.log(error.response.data);
		}
	},

	// Get post by id
	async getPost({ commit }, id) {
		try {
			const res = await axios.get(`/post/${id}`);
			commit('GET_POST', res.data);
		} catch (error) {
			console.log(error.response.data);
		}
	},

	// Add Post
	async addPost({ commit }, formData) {
		try {
			const res = await axios.post('/posts/create', formData);
			commit('ADD_POST', res.data);
		} catch (error) {
			console.log(error.response.data);
		}
	},

	// Edit Post
	async editPost({ commit }, { id, formData }) {
		try {
			const res = await axios.post(`/post/edit/${id}`, formData);
			router.push('/posts');
		} catch (error) {
			console.log(error.response.data);
		}
	},

	// Delete Post
	async deletePost({ commit }, id) {
		try {
			await axios.delete(`/post/delete/${id}`);
			commit('DELETE_POST', id);
		} catch (error) {
			console.log(error.response.data);
		}
	}
};

const mutations = {
	GET_POSTS: (state, posts) => {
		state.posts = posts.data;
		state.loading = false;
	},
	GET_POST: (state, post) => {
		state.post = post.data;
		state.loading = false;
	},
	ADD_POST: (state, post) => {
		state.posts.unshift(post);
	},
	DELETE_POST: (state, id) => {
		state.posts = state.posts.filter(post => post.id != id);
	}
};

export default { state, getters, actions, mutations };
