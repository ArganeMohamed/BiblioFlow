<template>
    <div class="main-body">
        <div class="body-home">
            <div class="body-text">
                <h1>BiblioFlow</h1>
                <p>Votre solution ultime pour gérer et organiser votre bibliothèque.</p>
                <router-link class="books-link" :to="{name : 'BooksList'}">Voir nos livres</router-link>
            </div>
            <div class="body-img">
                <img src="../../assets/Imgs/image.webp" alt="Library Image">
            </div>
        </div>
        <form class="body-search" @submit.prevent="searchBooks">
            <input type="text" placeholder="Recherche..." v-model="search" required>
            <button type="submit" class="btn-search">Recherche</button>
        </form>
        <Types />
    </div>
</template>

<script>
    import Types from "../../components/Books/BooksTypes.vue";
    export default {
        components : { Types },

        data() {
            return {
                search : "",
            }
        },

        methods : {
            searchBooks() {
                this.$router.push({name:"searchBook", params:{query:this.search}});
            }
        }
    }
</script>

<style scoped>
    .main-body {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
        height: 100%;
        background: #F8F4EE;
        padding-top: 50px;
    }
    .body-home {
        display: flex;
        justify-content: center; 
        align-items: center; 
        width: 80%;
        margin-bottom: 20px; 
    }
    .body-text {
        width: 45%;
        padding-right: 20px; 
        margin-right: 20px; 
    }
    .body-text h1 {
        font-size: 2.5em;
        margin-bottom: 20px;
    }
    .body-text p {
        font-size: 1.2em;
        margin-bottom: 30px;
    }
    .body-img {
        width: 35%;
    }
    .body-img img {
        width: 100%;
        border-radius: 30px;
    }
    .books-link {
        padding: 10px 20px;
        border-radius: 5px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        background-color: #ff7e00; 
        color: white;
        border: none;
        cursor: pointer;
        text-decoration: none;
    }
    .books-link:hover {
        background-color: #ff5700;
    }
    .body-search {
        margin-top: 20px;
        padding: 35px 0px;
        width: 100%;
        display: flex;
        justify-content: center;
        background: #fff8f0;
    }
    .body-search input {
        width: 100%;
        max-width: 400px;
        padding: 10px;
        font-size: 1em;
        border-radius: 5px;
        border: 1px solid #ccc;
    }
    .btn-search  {
        padding: 10px 20px;
        border-radius: 5px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        background-color: #ff7e00; 
        color: white;
        border: none;
        cursor: pointer;
    }
    .btn-search:hover {
        background-color: #ff5700;
    }
    @media (max-width: 800px) {
        .body-home {
            flex-direction: column;
        }
        .body-text {
            width: 100%;
            padding-right: 0; 
            margin-right: 0; 
            margin-bottom: 20px; 
        }
        .body-img {
            width: 70%;
        }
        .body-search {
            width: 60%;
        }
    }
</style>