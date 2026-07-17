import { createRouter, createWebHistory } from 'vue-router'
import weatherRoutes from '@/router/weather.router'

const router = createRouter({
  history: createWebHistory(),
  routes: [...weatherRoutes],
})

export default router
