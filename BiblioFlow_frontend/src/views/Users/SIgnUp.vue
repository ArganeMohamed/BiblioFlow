<template>
    <div class="signup">
        <div class="signup-body">
            <form class="signup-form" @submit.prevent="signUpUser">
                <div class="signup-group">
                    <label for="" class="signup-label">Nom :</label>
                    <input type="text" class="signup-input" v-model="user.nom" required>
                </div>
                <div class="signup-group">
                    <label for="" class="signup-label">Prenom :</label>
                    <input type="text" class="signup-input" v-model="user.prenom" required>
                </div>
                <div class="signup-group">
                    <label for="" class="signup-label">E-mail :</label>
                    <input type="email" class="signup-input"  v-model="user.email" required>
                </div>
                <div class="signup-group">
                    <label for="" class="signup-label">Mot de passe :</label>
                    <input type="password" class="signup-input" v-model="user.password" required>
                </div>
                <input type="submit" value="Créer un compte" class="signup-btn">
                <p class="login-link">Vous avez un compte ? <router-link :to="{ name:'Login' }">Se connecter</router-link></p>
            </form>
        </div>
    </div>
</template>

<script>
    import axios from "axios";
    export default {
        data () {
            return {
                user: {
                    nom:"",
                    prenom:"",
                    email:"",
                    password:"",
                    role:"user",
                }
            }
        },
        methods: {
            signUpUser() {
                axios.post("http://localhost:8000/api/auth/register", this.user)
                .then(
                    this.$router.push({name:"Login"})
                )
            }
        }
    }
</script>

<style scoped>
.signup {
    height: 94vh;
    font-family: 'Lato', sans-serif;
    background: #F8F4EE;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 20px;
}

.signup-body {
    max-width: 600px;
    width: 100%;
    margin: 0 auto;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
}

.signup-group {
    margin-bottom: 15px;
}

.signup-label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
    color: #333;
}

.signup-input {
    width: 100%;
    padding: 10px;
    border-radius: 5px;
    border: 1px solid #ccc;
    box-sizing: border-box;
    text-align: center;
}

.signup-btn {
    width: 100%;
    padding: 10px;
    background-color: #ff7e00;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
    font-weight: bold;
}

.signup-btn:hover {
    background-color: #ff5700;
}

.signup-img {
    max-width: 100%;
    height: auto;
    border-radius: 8px;
}

.login-link {
    text-align: center;
    margin-top: 10px;
}
</style>
