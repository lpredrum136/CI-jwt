<template>
  <b-container>
    <b-card
      title="Application Registration"
      title-tag="h1"
      sub-title="Register your application to use REST API"
      sub-title-tag="h4"
      class="mt-3 page-title mx-auto text-center"
      style="width: 50%"
    >
      <b-form @submit="onSubmit">
        <b-form-group>
          <b-form-input id="appname" placeholder="Application Name" required v-model="appname"></b-form-input>
        </b-form-group>

        <b-form-group>
          <b-form-input
            id="redirect_uri"
            placeholder="Redirect URI"
            required
            v-model="redirect_uri"
          ></b-form-input>
        </b-form-group>

        <b-form-group label="Request Scope">
          <b-form-checkbox-group id="checkbox-scopes" v-model="selected" name="checkbox-scopes">
            <b-form-checkbox value="create">Create</b-form-checkbox>
            <b-form-checkbox value="read">Read</b-form-checkbox>
            <b-form-checkbox value="update">Update</b-form-checkbox>
            <b-form-checkbox value="delete">Delete</b-form-checkbox>
          </b-form-checkbox-group>
        </b-form-group>

        <b-button type="submit" variant="primary">Register Application</b-button>
      </b-form>
    </b-card>

    <b-card
      title="Application Registration Successful"
      title-tag="h1"
      sub-title="Save this information"
      sub-title-tag="h4"
      class="mt-3 page-title mx-auto text-center"
      style="width: 75%"
      v-if="myApp.app != null"
    >
      <b-card-text>
        <b-list-group>
          <b-list-group-item>
            <strong class="text-primary">Application name:</strong>
            {{ myApp.app.appname }}
          </b-list-group-item>
          <b-list-group-item>
            <strong class="text-primary">Client ID:</strong>
            {{ myApp.app.client_id }}
          </b-list-group-item>
          <b-list-group-item>
            <strong class="text-primary">Client secret:</strong>
            {{ myApp.app.client_secret }}
          </b-list-group-item>
          <b-list-group-item>
            <strong class="text-primary">Callback URI:</strong>
            {{ myApp.app.redirect_uri }}
          </b-list-group-item>
          <b-list-group-item>
            <strong class="text-primary">Scopes:</strong>
            {{ myApp.app.scopes }}
          </b-list-group-item>
        </b-list-group>
      </b-card-text>
    </b-card>
  </b-container>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';

export default {
  name: 'AppRegister',
  data() {
    return {
      selected: [],
      appname: '',
      redirect_uri: ''
    };
  },
  computed: mapGetters(['myApp']),
  methods: {
    ...mapActions(['appRegister']),
    onSubmit(event) {
      event.preventDefault();
      this.appRegister({
        appname: this.appname,
        redirect_uri: this.redirect_uri,
        scopes: this.selected.join(' ')
      });
    }
  }
};
</script>

<style>
</style>