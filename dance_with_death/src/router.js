import Vue from 'vue'
import Router from 'vue-router'
import App from './App'
import Layout from './Layout'
import Appointments from './Appointments'
import Home from './Home'
Vue.use(Router)

export default new Router({
  mode: 'history',
  base: process.env.BASE_URL,
  routes:
  [
    {
      path: '/',
      component: Layout,
      children:
      [
        {
          path: '/index/home',
          name: 'Home',
          component: Home
        },
        {
          path: '/index/appointments',
          name: 'Appointments',
          component: Appointments
        }
      ]
    }
  ]
})