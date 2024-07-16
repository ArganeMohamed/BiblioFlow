<template>
    <main>
        <div class="profile">
            <h1>Bonjour {{ user.prenom }}</h1>
            <div class="liked-books">
                <h2>Livres aimés :</h2>
                <div v-if="likedBooks.length > 0">
                    <div v-for="book in likedBooks" :key="book.id" class="book-item" @click="singleBook(book.id)">
                        <img :src="`http://localhost:8000/images/${book.image}`" alt="Book Image" class="book-image">
                        <div class="book-details">
                            <h3>{{ book.title }}</h3>
                            <p>{{ book.description }}</p>
                        </div>
                    </div>
                </div>
                <p v-else>Aucun livre aimé trouvé.</p>
            </div>
        </div>
    </main>
</template>

<script>
import axios from "axios";

export default {
    data() {
        return {
            user: JSON.parse(localStorage.getItem('user')),
            likedBooks: [],
        };
    },
    mounted() {
        this.getLikedBooks();
    },
    methods: {
        getLikedBooks() {
            axios.post("http://localhost:8000/api/user/books/likes", { userID: this.user.id })
            .then(res => {
                if (res.data.status === 200) {
                    this.likedBooks = res.data.likedBooks;
                    console.log(res.data.likedBooks)
                }
            })
        },
        singleBook(id) {
            this.$router.push({ name: 'SingleBook', params: { id: id } })
        }
    }
};
</script>

<style scoped>
main {
    background: #F8F4EE;
    padding: 15px;
}

.profile {
    max-width: 800px;
    margin: 0 auto;
    padding: 30px;
    border: 1px solid #ccc;
    border-radius: 5px;
    background-color: #f9f9f9;
    margin-top: 15px;
}

.liked-books {
    margin-top: 20px;
}

.liked-books h2 {
    font-size: 1.5rem;
    margin-bottom: 10px;
}

.book-item {
    display: flex;
    margin-bottom: 20px;
}

.book-image {
    width: 120px;
    height: auto;
    margin-right: 20px;
    border-radius: 5px;
}

.book-details {
    flex: 1;
}

.book-details h3 {
    font-size: 1.2rem;
    margin-bottom: 5px;
}

.book-details p {
    color: #666;
}

.book-item:hover {
    cursor: pointer;
}
</style>
