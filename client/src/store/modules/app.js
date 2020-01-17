import axios from 'axios';
import router from '../../router';
import setAuthToken from '../../utils/setAuthToken';

const state = {
	app: null
};

const getters = { myApp: state => state };

const actions = {
	// Register App
	async appRegister({ commit }, formData) {
		try {
			const res = await axios.post('/api/app/register', formData);
			commit('APP_REGISTER_SUCCESS', res.data);
		} catch (error) {
			console.log(error.response.data);
			commit('APP_REGISTER_FAIL');
		}
	}
};

const mutations = {
	APP_REGISTER_SUCCESS: (state, appInfo) => (state.app = appInfo),
	APP_REGISTER_FAIL: state => (state.app = null)
};

export default { state, getters, actions, mutations };
