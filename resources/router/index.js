import { createRouter, createWebHistory } from 'vue-router'
import RegisterPage from '../js/pages/RegisterPage.vue'
import LoginPage from '../js/pages/LoginPage.vue'
import HomePage from '../js/pages/HomePage.vue'
import RecipeDetailPage from '../js/pages/RecipeDetailPage.vue'
import MyRecipesPage from '../js/pages/MyRecipesPage.vue'

const routes = [
  { path: '/', name: 'home', component: HomePage },
  { path: '/register', name: 'register', component: RegisterPage },
  { path: '/login', name: 'login', component: LoginPage },
  { path: '/recipes/:id', name: 'recipeDetail', component: RecipeDetailPage},
  { path: '/my-recipes', name: 'myRecipes', component: MyRecipesPage }
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

export default router