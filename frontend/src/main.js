import { createApp } from 'vue'
import App from './App.vue'
import { createRouter, createWebHistory } from 'vue-router'
import './index.css'
import store from './store'
import MainPage from './views/MainPage.vue'
const router = createRouter({
  routes: [
    {
      path: '/',
      component: MainPage
    }
  ],
  history: createWebHistory()
})

const app = createApp(App)

app.use(router)
app.mount('#app')
app.use(store)
