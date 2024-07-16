import { createRouter, createWebHistory } from 'vue-router';
import Home from "../views/Home/HomeComponent.vue";
import NonPage from "../views/404/404.vue";
import AddBook from "../views/Books/AddBook.vue";
import UpdateBook from "../views/Books/EditeBook.vue";
import BooksList from "../views/Books/FetchBooks.vue";
import SingleBook from "../views/Books/SingleBook.vue";
import SignUp from "../views/Users/SIgnUp.vue";
import Login from "../views/Users/Login.vue";
import searchBook from "../views/Books/SearchBook.vue";
import Profile from "../views/Users/Profile.vue";

import axios from "axios";

const routes = [
  {
    path: "/",
    name: "HomeComponent",
    component: Home,
    meta: { requiresAuth: true }
  },
  {
    path: "/addbook",
    name: "AddBook",
    component: AddBook,
    meta: { requiresAuth: true, isAdmin: true }
  },
  {
    path: "/update/:id",
    name: "UpdateBook",
    component: UpdateBook,
    meta: { requiresAuth: true, isAdmin: true }
  },
  {
    path: "/books",
    name: "BooksList",
    component: BooksList,
    meta: { requiresAuth: true }
  },
  {
    path: "/signup",
    name: "SignUp",
    component: SignUp,
    meta: { guestOnly: true }
  },
  {
    path: "/login",
    name: "Login",
    component: Login,
    meta: { guestOnly: true }
  },
  {
    path: "/book/:id",
    name: "SingleBook",
    component: SingleBook,
    meta: { requiresAuth: true }
  },
  {
    path: "/search/:query",
    name: "searchBook",
    component: searchBook,
    meta: { requiresAuth: true }
  },
  {
    path:"/user/profile",
    name:"Profile",
    component:Profile,
    meta:{requiresAuth:true}
  },
  {
    path: "/:catchAll(.*)",
    name: "NotFound",
    component: NonPage,
    meta: { requiresAuth: true }
  }
];

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
});

const checkTokenValidity = async () => {
  try {
    const token = localStorage.getItem('token');
    if (!token) {
      return { isAuthenticated: false, isAdmin: false };
    }
    
    const response = await axios.post('http://localhost:8000/api/auth/checktoken', {token:token});
    const user = JSON.parse(localStorage.getItem('user'));
    return { isAuthenticated: response.data.status === 200, isAdmin: user.role === 'admin' };
  } catch (error) {
    return { isAuthenticated: false, isAdmin: false };
  }
};

router.beforeEach(async (to, from, next) => {
  const { isAuthenticated, isAdmin } = await checkTokenValidity();

  if (to.matched.some(record => record.meta.requiresAuth) && !isAuthenticated) {
    next('/login');
  } else if (to.matched.some(record => record.meta.isAdmin) && !isAdmin) {
    next('/');
  } else if (to.matched.some(record => record.meta.guestOnly) && isAuthenticated) {
    next('/');
  } else {
    next();
  }
});

export default router;
