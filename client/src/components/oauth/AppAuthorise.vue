<template>
  <b-container class="mt-3">
    <b-alert v-if="myOAuth.appAuthoriseLoading" show variant="info" class="text-center">Loading...</b-alert>

    <b-alert
      v-else-if="myOAuth.app == null"
      show
      variant="danger"
    >Unauthorised. Invalid application credentials.</b-alert>

    <b-card
      v-else
      title="Application Authorisation"
      title-tag="h1"
      :sub-title="`${myOAuth.app.appname} wants to access your data.`"
      sub-title-tag="h4"
      class="mt-3 page-title mx-auto text-center"
      style="width: 50%"
    >
      <b-form v-if="!myAuth.loading && !myAuth.isAuthenticated" @submit="onSubmitNotAuthenticated">
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

        <b-button type="submit" variant="primary">Allow</b-button>
      </b-form>
      <b-button v-else variant="success">Allow</b-button>
    </b-card>
  </b-container>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';

export default {
  name: 'AppAuthorise',
  data() {
    return { username: '', password: '' };
  },
  computed: mapGetters(['myOAuth', 'myAuth']),
  methods: {
    ...mapActions(['appAuthorise', 'login']),
    onSubmitNotAuthenticated(event) {
      event.preventDefault();
      this.login({
        username: this.username,
        password: this.password,
        isOAuthAuthorise: {
          check: true,
          client_id: this.$route.query.client_id,
          redirect_uri: this.$route.query.redirect_uri,
          scopes: this.$route.query.scopes
        }
      });
    }
  },
  created() {
    this.appAuthorise({
      client_id: this.$route.query.client_id,
      redirect_uri: this.$route.query.redirect_uri,
      scopes: this.$route.query.scopes
    });
  }
};
</script>

<style>
</style>