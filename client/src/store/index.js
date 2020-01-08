import Vue from 'vue';
import Vuex from 'vuex';
import post from './modules/post';

// Load Vuex
Vue.use(Vuex);

// Create store
const myStore = new Vuex.Store({
	modules: {
		myPost: post
	}
});

export default myStore;
