import Vue from 'vue';
import Vuex from 'vuex';
import post from './modules/post';
import auth from './modules/auth';
import app from './modules/app';
import oauth from './modules/oauth';

// Load Vuex
Vue.use(Vuex);

// Create store
const myStore = new Vuex.Store({
	modules: {
		myPost: post,
		myAuth: auth,
		myApp: app,
		myOAuth: oauth
	}
});

export default myStore;
