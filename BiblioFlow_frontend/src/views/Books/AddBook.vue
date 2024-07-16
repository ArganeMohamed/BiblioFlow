<template>
<div class="add-book">
    <div class="add-main">
        <form class="add-form" @submit.prevent="submitBook">
            <div class="add-form-group">
                <label for="title">Titre:</label>
                <input type="text" class="add-inpts" id="title" required v-model="book.title" />
            </div>
            <div class="add-form-group">
                <label for="author">Auteur:</label>
                <div class="add">
                    <select id="author" class="add-inpts" v-model="book.author_id" required>
                        <option disabled selected>Choisissez un Auteur</option>
                        <option v-for="author in authors" :key=author.id :value="author.id">
                            {{ author.name }}
                        </option>
                    </select>
                    <button class="showForm" @click="showAuthorForm">
                        <i class="fa-solid fa-plus"></i>
                    </button>
                </div>
                <form v-if="addAuthor" @submit.prevent="addNewAuthor">
                    <div class="add-form-group">
                        <div>
                            <input type="text" placeholder="author nom..." id="" class="add-inpts-items" v-model="newAuthor.name">
                            <div class="items">
                                <textarea placeholder="Author Bio..."  v-model="newAuthor.bio"></textarea>
                                <button class="item-submit" type="submit">
                                    <i class="fa-solid fa-paper-plane"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="add-form-group">
                <label for="genre">Genre:</label>
                    <div class="add">
                        <select id="genre" class="add-inpts" v-model="book.genre_id" required>
                            <option disabled selected>Choisissez un Genre</option>
                            <option v-for="genre in genres" :key=genre.id :value="genre.id">
                                {{ genre.name }}
                            </option>
                        </select>
                        <button class="showForm" @click="showGenreForm">
                            <i class="fa-solid fa-plus"></i>
                        </button>
                    </div>
                    <form v-if="addGenre" @submit.prevent="addNewGenre">
                        <div class="add-form-group items">
                            <input type="text" placeholder="genre nom..." id="" class="add-inpts-items" v-model="genre" required>
                            <button class="item-submit" type="submit" >
                                <i class="fa-solid fa-paper-plane"></i>
                            </button>
                        </div>
                    </form>
            </div>
            <div class="add-form-group">
                <label for="genre">Langues :</label>
                    <div class="add">
                        <select id="langue" class="add-inpts" v-model="book.langue_id" required>
                            <option disabled selected>Choisissez une Langue</option>
                            <option v-for="langue in langues" :key=langue.id :value="langue.id">
                                {{ langue.langue }}
                            </option>
                        </select>
                        <button class="showForm" @click="showLangueForm">
                            <i class="fa-solid fa-plus"></i>
                        </button>
                    </div>
                    <form v-if="addLangue" @submit.prevent="addNewLangue">
                        <div class="add-form-group items">
                            <input type="text" placeholder="genre nom..." id="" class="add-inpts-items" v-model="langue" required>
                            <button class="item-submit" type="submit" >
                                <i class="fa-solid fa-paper-plane"></i>
                            </button>
                        </div>
                    </form>
            </div>
            <div class="add-form-group">
                <label for="date">Date:</label>
                <input type="date" class="add-inpts" id="date" required v-model="book.publication_date"/>
            </div>
            <div class="add-form-group">
                <label for="isbn">ISBN:</label>
                <input type="text" class="add-inpts" id="isbn" required v-model="book.isbn"/>
            </div>
            <div class="add-form-group">
                <label for="nbr_page">Nombre de Pages:</label>
                <input type="number" class="add-inpts" id="nbr_page" required v-model="book.nbr_pages"/>
            </div>
            <div class="add-form-group">
                <label for="description">Description:</label>
                <textarea id="description" class="add-inpts" required v-model="book.description"></textarea>
            </div>
            <div class="add-form-group">
                <label for="image">Image:</label>
                <input type="file" id="image" class="add-inpts" @change="onFileChange" accept="image/*" required />
            </div>
            <div class="add-form-group">
                <label for="pdf_file">PDF Ficher :</label>
                <input type="file" id="pdf_file" class="add-inpts" @change="onPDFFileChange" accept=".pdf" required/>
            </div>
            <button type="submit" class="add-book-btn">Ajouter livre</button>
        </form>
    </div>
</div>
</template>

<script>
    import axios from 'axios'; 
    export default {
        data() {
            return ({
                book:{ 
                    title: "", 
                    author_id: "", 
                    genre_id: "", 
                    langue_id: "", 
                    publication_date: "", 
                    isbn: "", 
                    nbr_pages: "", 
                    description: "", 
                    image: null,
                    pdf_file: null
                },
                authors: [],
                genres: [],
                langues: [],
                addAuthor:false,
                addGenre:false,
                addLangue:false,
                newAuthor:{
                    name:"",
                    bio:"",
                },
                genre:"",
                langue:""
            })
        },

        mounted() {
            this.getAuthors();
            this.getGenres();
            this.getLangues();
        },

        methods: {
            submitBook () {
                let formData = new FormData();
                formData.append("title", this.book.title);
                formData.append("author_id", this.book.author_id);
                formData.append("genre_id", this.book.genre_id);
                formData.append("langue_id", this.book.langue_id);
                formData.append("publication_date", this.book.publication_date);
                formData.append("isbn", this.book.isbn);
                formData.append("nbr_pages", this.book.nbr_pages);
                formData.append("description", this.book.description);
                formData.append("image", this.book.image);
                formData.append("pdf_file", this.book.pdf_file);

                axios.post( "http://localhost:8000/api/addBook", formData, {
                    headers:{
                        "Content-Type": "multipart/form-data"
                    }
                })
                .then(this.$router.push({ name: 'BooksList' }));           
            },

            onFileChange(e) {
                this.book.image = e.target.files[0];
            },
            onPDFFileChange(e) {
                this.book.pdf_file = e.target.files[0];
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
            showGenreForm() {
                this.addGenre = true;
            },
            showAuthorForm() {
                this.addAuthor = true;
            },
            showLangueForm() {
                this.addLangue = true;
            },
            addNewGenre() {
                axios.post("http://localhost:8000/api/addGenre", {name: this.genre})
                .then(res => {
                        if(res.data.status === 200) {
                            this.addGenre = false,
                            this.genres.push(res.data.genre)
                            this.genre=""
                        }
                    }
                )
            },
            addNewLangue() {
                axios.post("http://localhost:8000/api/addLangue", {langue: this.langue})
                .then(res => {
                        if(res.data.status === 200) {
                            this.addLangue = false,
                            this.langues.push(res.data.langue)
                            this.langue=""
                        }
                    }
                )
            },
            addNewAuthor() {
                axios.post("http://localhost:8000/api/addAuthor", this.newAuthor)
                .then(res => {
                        if(res.data.status === 200) {
                            this.addAuthor = false,
                            this.authors.push(res.data.author),
                            this.newAuthor = { name: '', bio: '' };
                        }
                    }
                )
            }
        }
    }
</script>
  
<style scoped>
.add-book {
font-family: 'Lato', sans-serif;
background: #F8F4EE;
padding: 20px;
}

.add-main {
max-width: 600px;
margin: 0 auto;
padding: 20px;
border-radius: 8px;
box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
}

.add-form-group {
margin-bottom: 15px;
}

.add-form-group label {
display: block;
margin-bottom: 5px;
font-weight: bold;
color: #333;
}

.add-inpts {
width: 100%;
padding: 10px;
border-radius: 5px;
border: 1px solid #ccc;
box-sizing: border-box;
text-align: center;
}

.add-form-group textarea {
resize: vertical;
}

.add-book-btn {
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

.add-book-btn:hover {
background-color: #ff5700;
}

.add { 
    display: flex;
    align-items: center;
}

.add .showForm {
    color: white;
    padding: 10px 10px;
    border: none;
    background: #ff7e00;
    border-radius: 5px;
    cursor: pointer;
}

.add-inpts-items{
    width: 60%;
    padding: 10px;
    border-radius: 5px;
    border: 1px solid #ccc;
    text-align: center;
}

.items {
    display: flex;
    align-items: center;
    margin-top: 2px;
}

.item-submit {
    color: white;
    background: #ff7e00;
    padding: 10px 10px;
    border-radius: 5px;
    border: none;
    cursor: pointer;
}

.items textarea {
    width: 65%;
    border-radius: 5px;
    padding: 5px;
    border: 1px solid #ccc;
    box-sizing: border-box;
    text-align: center;
}
</style>