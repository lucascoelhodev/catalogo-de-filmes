import { createRouter, createWebHistory } from 'vue-router'
import Search from './views/Search.vue'
import Favorites from './views/Favorites.vue'

const routes = [
  { path: '/', component: Search, name: 'Search' },
  { path: '/favorites', component: Favorites, name: 'Favorites' },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

export default router
