import { createApp } from 'vue'
import App from './App.vue'
import { createRouter, createWebHistory } from 'vue-router'
import './index.css'
import store from './store'
import MainPage from './views/MainPage.vue'
import authPage from './views/authPage.vue'
import registerPage from './views/registerPage.vue'
import profilePage from './views/profilePage.vue'
import FavoritesView from './views/FavoritesView.vue'
import HistoryView from './views/HistoryView.vue'
import SettingsView from './views/SettingsView.vue'
const router = createRouter({
  routes: [
    {
      path: '/',
      component: MainPage
    },
    {
      path: '/authPage',
      component: authPage
    },
    {
      path: '/registerPage',
      component: registerPage
    },
    {
      path: '/profilePage',
      component: profilePage,
      children: [
        {
          path: '/profilePage/favorites',
          component: FavoritesView
        },
        {
          path: '/profilePage/history',
          component: HistoryView
        },
        {
          path: '/profilePage/settings',
          component: SettingsView
        }
      ]
    }
  ],
  history: createWebHistory()
})

const app = createApp(App)

app.use(router)
app.mount('#app')
app.use(store)
