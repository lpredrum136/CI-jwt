import axios from 'axios';

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

	// Add Post
	async addPost({ commit }, formData) {
		try {
			const res = await axios.post('/posts/create', formData);
			commit('ADD_POST', res.data);
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
	ADD_POST: (state, post) => {
		state.posts.unshift(post);
	}
};

export default { state, getters, actions, mutations };
