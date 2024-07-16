<template>
    <div class="books-list">
        <main>
            <div v-if="books.length" class="book-grid">
                <div v-for="book in books" :key="book.id" class="book-card" @click="singleBook(book.id)">
                <div class="image-container">
                    <img :src="`http://localhost:8000/images/${book.image}`" :alt="book.title" class="book-image"/>
                </div>
                <h2>{{ book.title }}</h2>
                <p><strong>Auteur:</strong> {{ book.authors.name }}</p>
                <p><strong>Genre:</strong> {{ book.genres.name }}</p>
                <p>{{ book.description }}</p>
                </div>
            </div>
            <div v-else class="noBook">
                <h1>Livre introuvable</h1>
            </div>
        </main>
    </div>
</template>

<script>
    import axios from "axios";
    export default {
        data () {
            return({
                bookName: this.$route.params.query,
                books:[],
                bookNotFound:false
            })
        },

        mounted () {
            axios.get(`http://localhost:8000/api/book/search/${this.bookName}`)
            .then(res => {
                if(res.data.status == 200) {
                    this.books = res.data.books;
                    console.log(this.book)
                } else {
                    this.bookNotFound = true;
                }
            })            
        },
        methods: {
            singleBook(id) {
                this.$router.push(`/book/${id}`)
            }
        }
    }
</script>

<style scoped>
    .books-list {
    font-family: 'Lato', sans-serif;
    background-color: #f7f3eb;
    padding: 20px;
    }

    main {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
    border-radius: 8px;
    }

    h1 {
    text-align: center;
    margin-bottom: 20px;
    color: #333;
    }

    .book-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 20px;
    }

    .book-card {
    border: 1px solid #e6e6e6;
    border-radius: 8px;
    padding: 15px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s, box-shadow 0.3s;
    background-color: #fff;
    }

    .book-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
    }

    .image-container {
    width: 100%;
    height: 300px; 
    overflow: hidden;
    display: flex;
    justify-content: center;
    align-items: center;
    }

    .book-image {
    width: 100%;
    height: 100%;
    object-fit: cover; 
    border-radius: 8px;
    margin-bottom: 20px;
    }

    .book-card h2 {
    margin: 0 0 10px 0;
    color: #ff7e00;
    }

    .book-card p {
    margin: 5px 0;
    color: #333;
    }

    .book-card p strong {
    color: #000;
    }

    .noBook {
    height: 49vh;
    }
</style>