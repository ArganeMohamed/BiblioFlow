<template>
    <div class="update-book">
      <div class="update-main">
        <form class="update-form" v-if="book" @submit.prevent="updateBook">
          <div class="update-form-group">
            <label for="title">Titre:</label>
            <input type="text" class="update-inpts" id="title" required v-model="book.title" />
          </div>
          <div class="update-form-group">
            <label for="author">Auteur:</label>
            <select id="author" class="update-inpts" required v-model="book.author_id">
              <option v-for="author in authors" :key="author.id" :value="author.id">
                {{ author.name }}
              </option>
            </select>
          </div>
          <div class="update-form-group">
            <label for="genre">Genre:</label>
            <select id="genre" class="update-inpts" required v-model="book.genre_id">
              <option v-for="genre in genres" :key="genre.id" :value="genre.id">
                {{ genre.name }}
              </option>
            </select>
          </div>
          <div class="update-form-group">
            <label for="langue">Langue:</label>
            <select id="langue" class="update-inpts" required v-model="book.langue_id">
              <option v-for="langue in langues" :key="langue.id" :value="langue.id">
                {{ langue.langue }}
              </option>
            </select>
          </div>
          <div class="update-form-group">
            <label for="date">Date:</label>
            <input type="date" class="update-inpts" id="date" required v-model="book.publication_date" />
          </div>
          <div class="update-form-group">
            <label for="isbn">ISBN:</label>
            <input type="text" class="update-inpts" id="isbn" required v-model="book.isbn" />
          </div>
          <div class="update-form-group">
            <label for="nbr_page">Nombre de Pages:</label>
            <input type="number" class="update-inpts" id="nbr_page" required v-model="book.nbr_pages" />
          </div>
          <div class="update-form-group">
            <label for="description">Description:</label>
            <textarea id="description" class="update-inpts" required v-model="book.description"></textarea>
          </div>
          <div class="update-form-group">
            <label for="image">Image:</label>
            <input type="file" id="image" class="update-inpts" @change="onFileChange" />
          </div>
          <button type="submit" class="update-book-btn">Modifier Livre</button>
        </form>
        <div v-else>
          <h2>Livre introuvable</h2>
        </div>
      </div>
    </div>
</template>
  
<script>
  import axios from "axios";
  export default {
    data() {
      return {
        id: this.$route.params.id,
        book: null,
        authors: [],
        genres: [],
        langues: [],
        selectedFile: null,
      };
    },
    mounted() {
      this.getBook();
      this.getAuthors();
      this.getGenres();
      this.getLangues();
    },
    methods: {
      getBook() {
        axios.get(`http://localhost:8000/api/book/${this.id}`).then((res) => (this.book = res.data.Book));
      },
      getAuthors() {
        axios.get(`http://localhost:8000/api/list/authors`).then((res) => (this.authors = res.data.authors));
      },
      getGenres() {
        axios.get(`http://localhost:8000/api/list/genres`).then((res) => (this.genres = res.data.genres));
      },
      getLangues() {
        axios.get(`http://localhost:8000/api/list/langues`).then((res) => (this.langues = res.data.langues));
      },
      onFileChange(event) {
        this.selectedFile = event.target.files[0];
      },
      updateBook() {
        const formData = new FormData();
        formData.append("title", this.book.title);
        formData.append("author_id", this.book.author_id);
        formData.append("genre_id", this.book.genre_id);
        formData.append("langue_id", this.book.langue_id);
        formData.append("publication_date", this.book.publication_date);
        formData.append("isbn", this.book.isbn);
        formData.append("nbr_pages", this.book.nbr_pages);
        formData.append("description", this.book.description);
        if (this.selectedFile) {
          formData.append("image", this.selectedFile);
        }
        axios.post(`http://localhost:8000/api/updateBook/${this.id}`, formData, {
          headers: {
            'Content-Type': 'multipart/form-data'
          }
        })
        .then(this.$router.push({ name: 'BooksList' }))
      }
    },
  };
</script>

<style scoped>
.update-book {
    font-family: 'Lato', sans-serif;
    background: #F8F4EE;
    padding: 20px;
}

.update-main {
    max-width: 600px;
    margin: 0 auto;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
}

.update-form-group {
    margin-bottom: 15px;
}

.update-form-group label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
    color: #333;
}

.update-inpts {
    width: 100%;
    padding: 10px;
    border-radius: 5px;
    border: 1px solid #ccc;
    box-sizing: border-box;
    text-align: center;
}

.update-form-group textarea {
    resize: vertical;
}

.update-book-btn {
    width: 100%;
    padding: 15px;
    background-color: #ff7e00;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
    font-weight: bold;
}

.update-book-btn:hover {
    background-color: #ff5700;
}
</style>