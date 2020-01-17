import Vue from 'vue';
import VueRouter from 'vue-router';
import myStore from '../store';

import Landing from '../components/layout/Landing.vue';
import Posts from '../components/posts/Posts.vue';
import PostEdit from '../components/posts/PostEdit.vue';

import Register from '../components/auth/Register.vue';
import Login from '../components/auth/Login.vue';

import AppRegister from '../components/apps/Register.vue';
import AppAuthorise from '../components/oauth/AppAuthorise.vue';

Vue.use(VueRouter);

const routes = [
	{
		path: '/',
		name: 'Landing',
		component: Landing,
		beforeEnter: (to, from, next) => {
			if (localStorage.token) next('/posts');
			else next();
		}
	},
	{
		path: '/posts',
		name: 'Posts',
		component: Posts,
		beforeEnter: (to, from, next) => {
			if (localStorage.token) next();
			else next('/login');
		}
	},
	{
		path: '/post/edit/:id',
		name: 'PostEdit',
		component: PostEdit,
		beforeEnter: (to, from, next) => {
			if (localStorage.token) next();
			else next('/login');
		}
	},
	{
		path: '/register',
		name: 'Register',
		component: Register,
		beforeEnter: (to, from, next) => {
			if (localStorage.token) next('/posts');
			else next();
		}
	},
	{
		path: '/login',
		name: 'Login',
		component: Login,
		beforeEnter: (to, from, next) => {
			if (localStorage.token) next('/posts');
			else next();
		}
	},
	{
		path: '/app/register',
		name: 'AppRegister',
		component: AppRegister
	},
	{
		path: '/app/authorise',
		name: 'AppAuthorise',
		component: AppAuthorise
	}
];

const router = new VueRouter({
	mode: 'hash',
	routes
});

export default router;
