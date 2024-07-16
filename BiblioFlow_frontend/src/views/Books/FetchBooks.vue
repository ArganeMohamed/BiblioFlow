<template>
  <div class="books-list">
    <form @submit.prevent="filterBookFunc" class="filterBookForm">
      <select class="filterBookSelect" v-model="filterBook.langue">
        <option :value="null" disabled selected>Langues</option>
        <option v-for="langue in langues" :key="langue.id" :value="langue.id">{{ langue.langue }}</option>
      </select>
      <select class="filterBookSelect" v-model="filterBook.author">
        <option :value="null" disabled selected>Auteurs</option>
        <option v-for="author in authors" :key="author.id" :value="author.id">{{ author.name }}</option>
      </select>
      <select class="filterBookSelect" v-model="filterBook.genre">
        <option :value="null" disabled selected>Genres</option>
        <option v-for="genre in genres" :key="genre.id" :value="genre.id">{{ genre.name }}</option>
      </select>
      <button type="submit" class="filterBookButton">Filtrer</button>
    </form>
    <main>
      <div v-if="paginatedBooks.length" class="book-grid">
        <div v-for="book in paginatedBooks" :key="book.id" class="book-card" @click="singleBook(book.id)">
          <div class="image-container">
            <img :src="`http://localhost:8000/images/${book.image}`" :alt="book.title" class="book-image"/>
          </div>
          <h2>{{ book.title }}</h2>
          <p><strong>Author:</strong> {{ book.authors.name }}</p>
          <p><strong>Genre:</strong> {{ book.genres.name }}</p>
          <p>{{ book.description }}</p>
        </div>
      </div>
      <div v-else class="noBook">
        <p>Aucun livre disponible.</p>
      </div>
      <div class="pagination-controls" v-if="totalPages > 1">
        <button @click="prevPage" :disabled="currentPage === 1">Précédent</button>
        <span>Page {{ currentPage }} of {{ totalPages }}</span>
        <button @click="nextPage" :disabled="currentPage === totalPages">Suivant</button>
      </div>
    </main>
  </div>
</template>

<script>
  import axios from "axios"
  export default {
    data() {
      return {
        books: [],
        authors:[],
        genres: [],
        langues:[],
        filterBook:{langue:null,author:null ,genre:null},
        currentPage: 1,
        itemsPerPage: 8
      };
    },

    computed: {
      totalPages() {
        return Math.ceil(this.books.length / this.itemsPerPage);
      },
      paginatedBooks() {
        const start = (this.currentPage - 1) * this.itemsPerPage;
        const end = start + this.itemsPerPage;
        return this.books.slice(start, end);
      }
    },

    methods: {
      getBooks() {
        axios.get("http://localhost:8000/api/list/books")
        .then(res => {
          this.books = Array.isArray(res.data.books) ? res.data.books : [];
        })
        .catch(error => {
          console.error("Error fetching books:", error);
          this.books = [];
        });
      },

      getAuthors() {
        axios.get( "http://localhost:8000/api/list/authors")
        .then(res => {
            if (Array.isArray(res.data.authors)) {
                this.authors = res.data.authors;
            } else {
                console.error('Authors data is not an array:', res.data.authors);
            }
        });
      },
      getGenres() {
        axios.get("http://localhost:8000/api/list/genres")
        .then(res => {
            if (Array.isArray(res.data.genres)) {
                this.genres = res.data.genres;
            } else {
                console.error('Authors data is not an array:', res.data.genres);
            }
        });
      },
      getLangues() {
        axios.get("http://localhost:8000/api/list/langues")
        .then(res => {
            if (Array.isArray(res.data.langues)) {
                this.langues = res.data.langues;
            } else {
                console.error('Langues data is not an array:', res.data.langues);
            }
        });
      },
      filterBookFunc() {
        axios.get("http://localhost:8000/api/list/books/filter", {
          params: {
            author: this.filterBook.author,
            genre: this.filterBook.genre,
            langue: this.filterBook.langue
          }
        }).then(res => {
          this.books = Array.isArray(res.data.books) ? res.data.books : [];
        })
      },
      nextPage() {
        if (this.currentPage < this.totalPages) {
          this.currentPage++;
        }
      },
      prevPage() {
        if (this.currentPage > 1) {
          this.currentPage--;
        }
      },
      singleBook(id) {
        this.$router.push({ name: 'SingleBook', params: { id: id } })
      },
      likeBook(id) {
        alert(id);
      }
    },

    mounted() {
      this.getBooks(),
      this.getAuthors(),
      this.getGenres(),
      this.getLangues()
    }
  };
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

.pagination-controls {
  display: flex;
  justify-content: center;
  align-items: center;
  margin-top: 20px;
}

.pagination-controls button {
  background-color: #ff7e00;
  color: #fff;
  border: none;
  padding: 10px 15px;
  margin: 0 5px;
  border-radius: 5px;
  cursor: pointer;
  transition: background-color 0.3s;
}

.pagination-controls button:disabled {
  background-color: #ddd;
  cursor: not-allowed;
}

.pagination-controls span {
  margin: 0 10px;
  color: #333;
}

.noBook {
  height: 41vh;
}

.filterBookForm {
  width: 100%;
  display: flex;
  justify-content: center;
  margin-bottom: 20px; 
}

.filterBookSelect {
  margin: 0 10px; 
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 5px;
  background-color: #fff;
  color: #333;
  font-size: 16px;
  outline: none;
  transition: border-color 0.3s;
}

.filterBookSelect:focus {
  border-color: #ff7e00; 
}

.filterBookButton {
  padding: 10px 20px;
  border: none;
  border-radius: 5px;
  background-color: #ff7e00;
  color: #fff;
  font-size: 16px;
  cursor: pointer;
  transition: background-color 0.3s;
}

.filterBookButton:hover {
  background-color: #e06b00; 
}

@media (max-width: 768px) {
  .filterBookForm {
    flex-direction: column; 
    align-items: center; 
  }

  .filterBookSelect {
    width: 80%; 
    margin: 5px 0; 
  }

  .filterBookButton {
    width: 80%; 
    margin-top: 10px; 
  }
}



</style>
