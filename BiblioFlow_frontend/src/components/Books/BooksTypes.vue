<template>
    <div class="book-types">
        <div class="container">
            <h2>Types de livres</h2>
            <div class="types">
                <div class="type" v-for="(type, i) in BooksType" :key="i">
                    {{ type.name }}
                </div>
            </div>        
        </div>
    </div>
</template>

<script>
    import axios from "axios";
    export default {
        data () {
            return ({
                BooksType : []
            })
        },

        mounted() {
            this.getBooksType();
        },

        methods: {
            getBooksType() {
                axios.get("http://localhost:8000/api/list/genres")
                .then(
                    res => this.BooksType = res.data.genres
                )
            }
        }
    }
</script>

<style>
.book-types {
    background: #f8f4ee;
    padding: 70px 0;
    text-align: center;
    width: 70%;
}

.book-types h2 {
    font-size: 2em;
    margin-bottom: 30px;
}


.types {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
}

.type {
    background: #fff;
    padding: 20px 30px;
    border-radius: 5px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    margin: 2px;
}
@media (max-width: 800px) {
    .types {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
}           
}
</style>