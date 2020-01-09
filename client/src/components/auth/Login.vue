<template>
  <b-container>
    <b-card
      title="Sign In"
      title-tag="h1"
      sub-title="Log into your account"
      sub-title-tag="h4"
      class="mt-3 page-title mx-auto text-center"
      style="width: 50%"
    >
      <b-form @submit="onSubmit">
        <b-form-group>
          <b-form-input id="username" placeholder="Username" required v-model="username"></b-form-input>
        </b-form-group>

        <b-form-group>
          <b-form-input
            id="password"
            type="password"
            placeholder="Password"
            required
            v-model="password"
          ></b-form-input>
        </b-form-group>

        <b-button type="submit" variant="primary">Login</b-button>

        <p class="mt-2">
          Don't have an account?
          <b-link to="/register" :style="{ textDecoration: 'none' }">Register</b-link>
        </p>
      </b-form>
    </b-card>
  </b-container>
</template>

<script>
import { mapActions } from 'vuex';

export default {
  name: 'Login',
  data() {
    return { username: '', password: '' };
  },
  methods: {
    ...mapActions(['login']),
    onSubmit(event) {
      event.preventDefault();
      this.login({ username: this.username, password: this.password });
    }
  }
};
</script>

<style>
</style>