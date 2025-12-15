import { createApp } from 'vue';
import App from './App.vue';
import router from '../router';
import axios from 'axios';
import { Icon } from '@iconify/vue'
import Toast from 'vue-toastification';
import "vue-toastification/dist/index.css";

window.axios = axios;

// request interceptor -- runs before every request
axios.interceptors.request.use(
  config => {
    const token = localStorage.getItem('auth_token');
    if (token) {
      config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
  },
  error => {
    return Promise.reject(error);
  }
);

const app = createApp(App);

const options = {
    position: 'top-center',
    timeout: 1500,
    closeOnClick: true,
    pauseOnHover: true,
    draggable: true,
}
app.component('Icon', Icon)

app.use(router);
app.use(Toast, options);
app.mount("#app");
