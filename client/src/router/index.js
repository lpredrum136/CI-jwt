import Vue from 'vue';
import VueRouter from 'vue-router';
import myStore from '../store';

import Landing from '../components/layout/Landing.vue';
import Posts from '../components/posts/Posts.vue';
import PostEdit from '../components/posts/PostEdit.vue';

Vue.use(VueRouter);

const routes = [
	{
		path: '/',
		name: 'Landing',
		component: Landing
	},
	{
		path: '/posts',
		name: 'Posts',
		component: Posts
	},
	{
		path: '/post/edit/:id',
		name: 'PostEdit',
		component: PostEdit
	}
];

const router = new VueRouter({
	mode: 'hash',
	routes
});

export default router;
