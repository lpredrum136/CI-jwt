<template>
  <b-container>
    <b-card
      title="Sign Up"
      title-tag="h1"
      sub-title="Create Your Account"
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
            aria-describedby="password-help-block"
            required
            v-model="password"
          ></b-form-input>
          <b-form-text id="password-help-block">Your password must be at least 6 characters long.</b-form-text>
        </b-form-group>

        <b-form-group>
          <b-form-select v-model="privilege" :options="privilegeOptions" required></b-form-select>
        </b-form-group>

        <b-button type="submit" variant="primary">Create Account</b-button>

        <p class="mt-2">
          Already have an account?
          <b-link to="/login" :style="{ textDecoration: 'none' }">Sign In</b-link>
        </p>
      </b-form>
    </b-card>
  </b-container>
</template>

<script>
import { mapActions } from 'vuex';

export default {
  name: 'Register',
  data() {
    return {
      username: '',
      password: '',
      privilege: null,
      privilegeOptions: [
        { value: null, text: 'Select Privilege' },
        { value: 'admin', text: 'Administrator' },
        { value: 'user', text: 'Normal User' }
      ]
    };
  },
  methods: {
    ...mapActions(['register']),
    onSubmit(event) {
      event.preventDefault();
      this.register({
        username: this.username,
        password: this.password,
        privilege: this.privilege
      });
    }
  }
};
</script>

<style>
</style>