import Vue from 'vue';
import Vuex from 'vuex';
import post from './modules/post';
import auth from './modules/auth';

// Load Vuex
Vue.use(Vuex);

// Create store
const myStore = new Vuex.Store({
	modules: {
		myPost: post,
		myAuth: auth
	}
});

export default myStore;
