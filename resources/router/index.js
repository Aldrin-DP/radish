import { createRouter, createWebHistory } from 'vue-router'
import RegisterPage from '../js/pages/RegisterPage.vue'
import LoginPage from '../js/pages/LoginPage.vue'


const routes = [
  { path: '/register', name: 'register', component: RegisterPage },
  { path: '/login', name: 'login', component: LoginPage },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

export default router