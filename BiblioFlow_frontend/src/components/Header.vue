<template>
  <nav class="navBar">
      <div class="logo">
        <img src="../assets/Imgs/logo1.png" width="40" class="logo-img">
      </div>
      <ul class="links-list">
          <li class="link-item">
            <router-link class="link" :to="{name:'HomeComponent'}">Accueil</router-link>
          </li>
          <li class="link-item" v-if="role && role == 'admin'">
            <router-link class="link" :to="{name:'AddBook'}">Ajouter un livre</router-link>
          </li>
          <li class="link-item">
            <router-link class="link" :to="{name:'BooksList'}">Livres</router-link>
          </li>
      </ul>
      <button class="signup-btn" @click="profileUser"><i class="fa-solid fa-user"></i></button>
  </nav>
</template>

<script>
  export default {
    data () {
      return {
        role: JSON.parse(localStorage.getItem('user')).role,
      }
    },
    methods: {
      profileUser() {
        this.$router.push({name:"Profile"})
      }
    }
  }
</script>

<style scoped>
  .navBar {
    display: flex;
    justify-content: space-evenly;
    align-items: center;
    margin-top: 0px;
    background: #F8F4EE;
    padding-top: 2px;
    /* position: fixed; */
    width: 100%
  }
  .links-list {
    display: flex;
    justify-content: space-between;
    align-items: center;
    list-style: none;
  }
  .link-item {
    margin: 0 20px;
  }
  .link {
    text-decoration: none;
    color: black;
  }
  .signup-btn {
    padding: 10px 20px;
    border-radius: 5px;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    background-color: #ff7e00; 
    color: white;
    border: none;
    cursor: pointer;
  }
  .signup-btn:hover {
    background-color: #ff5700;
  }
  .logo-img {
    border-radius: 30px;
  }

</style>