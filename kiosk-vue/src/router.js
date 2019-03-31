import Vue from 'vue'
import Router from 'vue-router'
import Home from './views/Home.vue'
import Non_ordered from './views/Non-ordered.vue'
import Ordered from './views/Ordered.vue'
import QueueNumber from './views/QueueNumber.vue'

Vue.use(Router)

export default new Router({
  mode: 'history',
  base: process.env.BASE_URL,
  routes: [
    {
      path: '/',
      name: 'home',
      component: Home
    },
    {
      path: '/non-ordered',
      name: 'non-ordered',
      component: Non_ordered
    }
    ,
    {
      path: '/ordered',
      name: 'ordered',
      component: Ordered
    },{
      path: '/queue/:number',
      name: 'queue',
      component: QueueNumber
    }
  ]
})
