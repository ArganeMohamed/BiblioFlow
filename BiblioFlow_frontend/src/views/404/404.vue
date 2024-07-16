<template>
    <div>
        <h1>Erreur 404 page non trouvée</h1>
        <router-link :to="{name:'HomeComponent'}">Page d'accueil</router-link>
    </div>
</template>

<style scoped>
    div {
        height: 55vh;
        background: #f8f4ee;
        text-align: center;
        padding-top: 40px;
    }
</style>