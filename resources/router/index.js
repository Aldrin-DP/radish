import { createRouter, createWebHistory } from 'vue-router'
import { nextTick } from 'vue'

import RegisterPage from '../js/pages/RegisterPage.vue'
import LoginPage from '../js/pages/LoginPage.vue'
import HomePage from '../js/pages/HomePage.vue'
import RecipeDetailPage from '../js/pages/RecipeDetailPage.vue'
import MyRecipesPage from '../js/pages/MyRecipesPage.vue'
import FavoritesPage from '../js/pages/FavoritesPage.vue'
import ProfilePage from '../js/pages/ProfilePage.vue'


const routes = [
  { path: '/', name: 'home', component: HomePage },
  { path: '/register', name: 'register', component: RegisterPage },
  { path: '/login', name: 'login', component: LoginPage },
  { path: '/recipes/:id-:slug', name: 'recipeDetail', component: RecipeDetailPage},
  { path: '/my-recipes', name: 'myRecipes', component: MyRecipesPage, meta: { requiresAuth: true } },
  { path: '/favorites', name: 'favorites', component: FavoritesPage, meta: { requiresAuth: true } },
  { path: '/raddisher/:slug', name: 'raddisher', component: ProfilePage }
]


const router = createRouter({
  history: createWebHistory(),
  routes,
  scrollBehavior(to, from, savedPosition) {
    if (savedPosition) {
        return nextTick().then(() => {
            return savedPosition
        });
    }
    return { top: 0 }
  }
})

router.beforeEach((to, from, next) => {
    const isLoggedIn = !!localStorage.getItem('auth_token');

    if (to.meta.requiresAuth && !isLoggedIn) {
        next('/login');
    } else {
        next()
    }
});

export default router
