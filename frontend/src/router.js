import { createRouter, createWebHistory } from 'vue-router'
import MainPage from './views/MainPage.vue'
import AuthForm from './views/userAuthForm.vue'
import registerPage from './views/registerPage.vue'
import profilePage from './views/profilePage.vue'
import FavoritesView from './views/FavoritesView.vue'
import HistoryView from './views/HistoryView.vue'
import SettingsView from './views/SettingsView.vue'
import addAnime from './views/addAnime.vue'
import editAnime from './views/editAnime.vue'

export const router = createRouter({
  routes: [
    {
      path: '/',
      component: MainPage
    },
    {
      path: '/auth',
      component: AuthForm
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
    },
    {
      path: '/addAnime',
      component: addAnime
    },
    {
      path: '/editAnime/:id',
      component: editAnime
    }
  ],
  history: createWebHistory()
})
