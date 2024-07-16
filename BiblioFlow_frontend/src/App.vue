<template>
  <div class="home-main">
    <Header v-if="showHeaderFooter" />
    <router-view></router-view>
    <Footer v-if="showHeaderFooter" />
  </div>
</template>

<script>
import Header from "./components/Header.vue";
import Footer from "./components/Footer.vue";

export default {
  components: { Header, Footer },
  computed: {
    showHeaderFooter() {
      const noHeaderFooterRoutes = ['Login', 'SignUp'];
      return !noHeaderFooterRoutes.includes(this.$route.name);
    }
  },
  watch: {
    '$route.name': 'evaluateHeaderFooter'
  },
  methods: {
    evaluateHeaderFooter() {
      this.showHeaderFooter;
    }
  }
}
</script>

<style>
  body {
    font-family: 'Lato', sans-serif;  
  }
  * {
    margin: 0%;
    padding: 0%;
  }
  .home-main {
    width: 100%;
    height: 100%;
  }
</style>
