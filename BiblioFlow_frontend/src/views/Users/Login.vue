<template>
    <div class="login">
        <div class="login-body">
            <p v-if="checkUser" class="alert">Mauvais email ou mot de passe</p>
            <form class="login-form" @submit.prevent="logInUser">
                <div class="login-group">
                    <label for="email" class="login-label">E-mail :</label>
                    <input type="email" class="login-input" id="email" v-model="user.email" required>
                </div>
                <div class="login-group">
                    <label for="password" class="login-label">Mot de passe :</label>
                    <input type="password" class="login-input" id="password" v-model="user.password" required>
                </div>
                <input type="submit" value="Se Connecter" class="login-btn">
                <p class="signup-link">Vous n'avez pas de compte ? <router-link :to="{ name:'SignUp' }">S'inscrire</router-link></p>
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
                    email: '',
                    password:''
                },
                checkUser:false,
            }
        },
        mounted() {
            localStorage.setItem("user", JSON.stringify({role: "user"}));
        },
        methods: {
            logInUser() {
                axios.post("http://localhost:8000/api/auth/login", this.user)
                .then(res => {
                    if(res.data.status == 200) {
                        localStorage.setItem('token', res.data.token);
                        localStorage.setItem('user', JSON.stringify(res.data.user));
                        this.$router.push({ name: 'HomeComponent' });
                    } else {
                        this.checkUser = true;
                    }
                })
            }
        }
    }
</script>

<style scoped>
.login {
    height: 94vh;
    font-family: 'Lato', sans-serif;
    background: #F8F4EE;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 20px;
}

.login-body {
    max-width: 600px;
    width: 100%;
    margin: 0 auto;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
}

.login-group {
    margin-bottom: 15px;
}

.login-label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
    color: #333;
}

.login-input {
    width: 100%;
    padding: 10px;
    border-radius: 5px;
    border: 1px solid #ccc;
    box-sizing: border-box;
    text-align: center;
}

.login-btn {
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

.login-btn:hover {
    background-color: #ff5700;
}

.login-img {
    max-width: 100%;
    height: auto;
    border-radius: 8px;
}

.signup-link {
    text-align: center;
    margin-top: 10px;
}

.alert {
    margin: 10px;
    text-align: center;
    color: red;
    font-weight: bold;
}
</style>
