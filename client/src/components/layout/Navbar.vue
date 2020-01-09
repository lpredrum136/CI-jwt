<template>
  <div>
    <b-navbar toggleable="lg" type="dark" variant="dark">
      <b-navbar-brand to="/">
        <i class="fas fa-code"></i> CI JWT
      </b-navbar-brand>

      <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

      <b-collapse id="nav-collapse" is-nav>
        <!-- Right aligned nav items -->
        <b-navbar-nav class="ml-auto">
          <template v-if="!myAuth.loading && myAuth.isAuthenticated && myAuth.user !== null">
            <b-nav-item disabled>
              <i class="fas fa-user mr-2" style="color: white;"></i>
              <span class="mr-2" style="color: white;">Welcome {{myAuth.user.username}}</span>
              <b-badge variant="warning">{{myAuth.user.privilege}}</b-badge>
            </b-nav-item>
            <b-nav-item to="/posts">
              <i class="fas fa-book-reader"></i> Posts
            </b-nav-item>
            <b-nav-item @click="logout()">
              <i class="fas fa-power-off"></i> Logout
            </b-nav-item>
          </template>
          <template v-else>
            <b-nav-item to="/register">Register</b-nav-item>
            <b-nav-item to="/login">Login</b-nav-item>
          </template>
        </b-navbar-nav>
      </b-collapse>
    </b-navbar>
  </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex';

export default {
  name: 'Navbar',
  computed: mapGetters(['myAuth']),
  methods: {
    ...mapActions(['logout'])
  }
};
</script>

<style></style>
