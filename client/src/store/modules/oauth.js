import axios from 'axios';

const state = {
	app: null,
	appAuthoriseLoading: true
};

const getters = { myOAuth: state => state };

const actions = {
	// Authorise app?
	async appAuthorise({ commit }, formData) {
		try {
			const res = await axios.post('/api/app/authorise', formData);
			commit('APP_AUTHORISE_SUCCESS', res.data);
		} catch (error) {
			console.log(error.response.data);
			commit('APP_AUTHORISE_FAIL');
		}
	}
};

const mutations = {
	APP_AUTHORISE_SUCCESS: (state, appInfo) => {
		state.app = appInfo;
		state.appAuthoriseLoading = false;
	},
	APP_AUTHORISE_FAIL: state => {
		state.app = null;
		state.appAuthoriseLoading = false;
	}
};

export default { state, getters, actions, mutations };
