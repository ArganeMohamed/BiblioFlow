<template>
  <div>
    <div class="book-detail-page" v-if="book ">
      <div class="book-content">
        <div class="book-image-container">
          <img :src="`http://localhost:8000/images/${book.Book.image}`" class="book-image" />
        </div>
        <div class="book-info">
          <h1>{{ book.Book.title }}</h1>
          <p v-if="book.Book.authors"><strong>Auteur:</strong> {{ book.Book.authors.name }}</p>
          <p v-if="book.Book.genres"><strong>Genre:</strong> {{ book.Book.genres.name }}</p>
          <p><strong>Date de publication :</strong> {{ book.Book.publication_date }}</p>
          <p><strong>ISBN:</strong> {{ book.Book.isbn }}</p>
          <p><strong>Nombre de pages:</strong> {{ book.Book.nbr_pages }}</p>
          <p v-if="book.Book.langues"><strong>Langue:</strong> {{ book.Book.langues.langue }}</p>
          <p><strong>Resume:</strong> {{ book.Book.description }}</p>
          <div v-if="book.Book.pdf_file" class="download-section">
            <a :href="`http://localhost:8000/pdfs/${book.Book.pdf_file}`" download="Book.pdf" class="download-link" target="_blank">Télécharger le PDF</a>
          </div>
          <div v-if="!liked">
            <button class="likeBtn" @click="likeBook(book.Book.id)"><i class="fa-regular fa-heart"></i></button>
          </div>
          <div v-else>
            <p>Liked</p>
          </div>
          <div v-if="role && role == 'admin'" class="btn-events">
            <button class="btn delete-book" @click="deleteBook(book.Book.id)">Supprimer</button>
            <button class="btn update-book" @click="updatePage(book.Book.id)">Modifier</button>
          </div>
        </div>
      </div>
      <div class="author-info" v-if="book.Book.authors">
        <h2>A propos de l'auteur : </h2>
        <p><b>{{ book.Book.authors.name }} : </b> {{ book.Book.authors.bio }}</p>
      </div>
      <form @submit.prevent="addComment(book.Book.id)" class="comment-form">
        <h2>Ajouter un commentaire</h2>
        <div class="form-group">
          <label for="comment">Commentaire</label>
          <textarea class="form-control" id="comment" v-model="comment" required></textarea>
          <input type="submit" class="submit-btn" value="Envoyer">
        </div>
      </form>
      <div class="comments" v-if="comments.length > 0">
        <div class="comment" v-for="comment in comments" :key="comment.id">
          <p><strong>{{ comment.nom }} {{ comment.prenom }}:</strong> {{ comment.comment }}</p>
        </div>
      </div>
      <div v-else class="no-comment">Aucun commentaire</div>

    </div>
    <div v-else class="loading">
      <h2>Chargement en cours...</h2>
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
      role: JSON.parse(localStorage.getItem('user')).role,
      userID: JSON.parse(localStorage.getItem('user')).id,
      comment:null,
      comments: [],
      liked: true
    }
  },
  mounted() {
    this.fetchBook();
    this.getComments();
    this.checkLike()
  },
  methods: {
    fetchBook() {
      axios.get(`http://localhost:8000/api/book/${this.id}`)
        .then(res => {
          this.book = res.data;
          this.bookID = res.data.Book.id
        })
    },
    updatePage(id) {
      this.$router.push({ name: "UpdateBook", params: { id: id } });
    },
    deleteBook(id) {
      axios.delete(`http://localhost:8000/api/book/delete/${id}`)
        .then(() => {
          this.$router.push({ name: "BooksList" });
        });
    },
    likeBook(id) {
      const userID = JSON.parse(localStorage.getItem("user")).id;
      const bookID = id;
      axios.post('http://localhost:8000/api/addLike', {user_id:userID, book_id:bookID})
      .then(this.liked = true)
    },
    addComment() {
      const data = {
        user_id: this.userID,
        book_id: parseInt(this.id),
        comment: this.comment 
      }
      axios.post("http://localhost:8000/api/addComment", data)
      .then(res => console.log(res.data))
      const user = JSON.parse(localStorage.getItem("user"))
      this.comments.push({nom:user.nom, prenom:user.prenom, comment:data.comment});
    },
    getComments() {
      axios.post("http://localhost:8000/api/books/list/comments", {book_id: this.id})
      .then(res => {
        if(res.data.status === 200) {
          this.comments = res.data.comments
        }
      })
    },
    checkLike() {
      axios.post("http://localhost:8000/api/books/checkLike", { book_id:parseInt(this.id), user_id: JSON.parse(localStorage.getItem("user")).id} )
      .then(res => {
        if(res.data.liked) {
          this.liked = true
        } else {
          this.liked = false
        }
      })
    }
  }
};
</script>

<style scoped>
.book-detail-page {
  font-family: 'Lato', sans-serif;
  background-color: #f7f3eb;
  padding: 40px;
  display: flex;
  flex-direction: column;
  align-items: center;
  text-align: center;
}

.book-content {
  display: flex;
  align-items: flex-start;
  background-color: #fff;
  border: 1px solid #e6e6e6;
  border-radius: 8px;
  padding: 40px;
  max-width: 1200px;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
  transition: transform 0.3s, box-shadow 0.3s;
  text-align: left;
}

.book-content:hover {
  transform: translateY(-5px);
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
}

.book-image-container {
  flex: 1;
  margin-right: 40px;
}

.book-image {
  width: 100%;
  height: auto;
  border-radius: 8px;
  max-width: 300px; 
}

.book-info {
  flex: 2;
}

.book-info h1 {
  margin: 0 0 15px 0;
  color: #ff7e00;
  font-size: 2em;
}

.book-info p {
  margin: 10px 0;
  color: #333;
  line-height: 1.6;
}

.book-info p strong {
  color: #000;
}

.author-info, .rating-review, .related-books, .book-comments, .purchase-links {
  margin-top: 40px;
  width: 100%;
  max-width: 1200px;
  text-align: left;
}

.author-info h2 {
  margin-bottom: 20px;
  color: #333;
}

.btn {
  margin: 5px;
  padding: 10px 15px;
  border-radius: 5px;
  color: #fff;
  border: none;
  cursor: pointer;
  transition: background-color 0.3s;
}

.delete-book {
  background-color: rgba(255, 99, 71, 1); 
}

.update-book {
  background-color: rgba(30, 144, 255, 1); 
}

.download-section {
  margin:20px 0px;
}

.download-link {
  display: inline-block;
  border-radius: 5px;
  text-decoration: none;
  color: rgba(30, 144, 255, 1);
}

.loading {
  background: #F8F4EE;
  height: 50vh;
  text-align: center;
  padding-top: 75px;
}

.likeBtn {
  background: none;
  border: none;
  cursor: pointer;
  font-size: 30px;
  color: #ff7e00;
  transition: transform 0.3s, color 0.3s;
  margin: 5px;
}

.comment-form {
  width: 80%; 
  max-width: 800px;
}

.comment-form h2 {
  margin-bottom: 10px;
  color: #333;
  font-size: 1.4em;
}

.comment-form .form-group {
  display: flex;
  flex-direction: column;
  width: 100%;
}

.comment-form .form-group label {
  margin-bottom: 5px;
  font-weight: bold;
  color: #555;
}

.comment-form .form-control {
  padding: 10px;
  border: 1px solid #ddd;
  border-radius: 4px;
  resize: vertical;
  min-height: 50px;
}

.comment-form .submit-btn {
  margin-top: 10px;
  padding: 10px 15px;
  border: none;
  border-radius: 4px;
  background-color: #ff7e00;
  color: #fff;
  font-size: 1em;
  cursor: pointer;
  transition: background-color 0.3s;
  align-self: flex-start;
}

.comment-form .submit-btn:hover {
  background-color: #e56b00;
}

.comments {
  width: 100%; 
  margin: 20px 0;
}

.comment {
  padding: 10px;
  text-align: start;
}

.comment p {
  margin: 0;
}

.comment-form {
  width: 100%; /* Ajuste la largeur pour prendre tout l'espace disponible */
  margin: 20px 0;
}

.comment-form h2 {
  margin-bottom: 10px;
}

.comment-form .form-group {
  margin-bottom: 10px;
}

.comment-form .form-control {
  width: 100%; /* Ajuste la largeur pour prendre tout l'espace disponible */
  padding: 10px;
  margin-bottom: 10px;
  border: 1px solid #ddd;
  border-radius: 4px;
}

.comment-form input[type="submit"] {
  background-color: #ff7e00;
  color: white;
  padding: 10px 20px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  transition: background-color 0.3s;
}

.comment-form input[type="submit"]:hover {
  background-color: #ff5500;
}


</style>



