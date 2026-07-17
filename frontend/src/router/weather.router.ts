import type { RouteRecordRaw } from 'vue-router'

const weatherRoutes: RouteRecordRaw[] = [
  {
    path: '/',
    name: 'weather.home',
    component: () => import('@/views/Weather/ViewWeatherHome.vue'),
  },
]

export default weatherRoutes
