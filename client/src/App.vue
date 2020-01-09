<template>
  <div id="app">
    <Navbar />
    <router-view />
  </div>
</template>

<script>
import Navbar from './components/layout/Navbar';
import { mapActions, mapGetters } from 'vuex';

export default {
  name: 'App',
  components: { Navbar },
  computed: mapGetters(['myAuth']),
  methods: { ...mapActions(['loadUser']) },
  created() {
    this.loadUser();
  }
};
</script>

<style>
@import './assets/styles/styles.css';
</style>
