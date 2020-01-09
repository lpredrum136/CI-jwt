import axios from 'axios';
import router from '../../router';
import setAuthToken from '../../utils/setAuthToken';

const state = {
	token: localStorage.getItem('token'),
	isAuthenticated: null,
	loading: true,
	user: null
};

const getters = { myAuth: state => state };

const actions = {
	// Load user
	async loadUser({ commit }) {
		// Check localStorage for token
		if (localStorage.token) setAuthToken(localStorage.token);

		try {
			const res = await axios.get('/users/auth');
			commit('USER_LOADED', res.data);
		} catch (error) {
			commit('AUTH_ERROR');
		}
	},

	// Register user
	async register({ commit }, formData) {
		try {
			const res = await axios.post('/users/register', formData);
			commit('REGISTER_SUCCESS', res.data);
			actions.loadUser({ commit });
			router.push('/posts');
		} catch (error) {
			console.log(error.response.data);
			commit('REGISTER_FAIL');
		}
	},

	// Login user
	async login({ commit }, formData) {
		try {
			const res = await axios.post('/users/login', formData);
			commit('LOGIN_SUCCESS', res.data);
			actions.loadUser({ commit });
			router.push('/posts');
		} catch (error) {
			console.log(error.response.data);
			commit('LOGIN_FAIL');
		}
	},

	// Logout user
	logout({ commit }) {
		commit('LOGOUT');
		router.push('/login');
	}
};

const mutations = {
	REGISTER_SUCCESS: (state, userInfo) => {
		localStorage.setItem('token', userInfo.token);
		state.token = userInfo.token;
		state.isAuthenticated = true;
		state.loading = false;
	},
	REGISTER_FAIL: state => {
		localStorage.removeItem('token');
		state.token = null;
		state.isAuthenticated = false;
		state.loading = false;
	},
	LOGIN_SUCCESS: (state, userInfo) => {
		localStorage.setItem('token', userInfo.token);
		state.token = userInfo.token;
		state.isAuthenticated = true;
		state.loading = false;
	},
	LOGIN_FAIL: state => {
		localStorage.removeItem('token');
		state.token = null;
		state.isAuthenticated = false;
		state.loading = false;
	},
	LOGOUT: state => {
		localStorage.removeItem('token');
		state.token = null;
		state.isAuthenticated = false;
		state.loading = false;
		state.user = null;
	},
	USER_LOADED: (state, userInfo) => {
		state.isAuthenticated = true;
		state.loading = false;
		state.user = userInfo;
	},
	AUTH_ERROR: state => {
		localStorage.removeItem('token');
		state.token = null;
		state.isAuthenticated = false;
		state.loading = false;
	}
};

export default { state, getters, actions, mutations };
