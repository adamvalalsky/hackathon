require('./bootstrap');

window.Vue = require('vue');

import Vue from 'vue'
import Vuesax from 'vuesax'
import VueRouter from 'vue-router'
import draggable from 'vuedraggable'
import 'vuesax/dist/vuesax.css'
import 'material-icons/iconfont/material-icons.css';
import Editor from '@tinymce/tinymce-vue';
import store from './store'


require('./plugins/tinymce.js');



Vue.component('main-menu', require('./components/Menu.vue'));
Vue.component('side-bar', require('./components/SideBar.vue'));
Vue.component('add-newsletter', require('./components/newsletter/Add.vue'));
Vue.component('editor', Editor);
Vue.component('draggable', draggable);




Vue.use(Vuesax, {
  theme:{
    colors:{
      primary:'#0079c1',
      success:'rgb(23, 201, 100)',
      danger:'rgb(242, 19, 93)',
      warning:'rgb(255, 130, 0)',
      dark:'rgb(36, 33, 69)'
    }
  }
})



Vue.use(VueRouter)
const routes = [
  //newsletters
  { path: '/newsletters', component: require('./components/newsletter/All.vue') },
  { path: '/newsletter/add', component: require('./components/newsletter/Add.vue') },
  { path: '/', component: require('./components/newsletter/All.vue') },
  { path: '/newsletter/edit/:id', component: require('./components/newsletter/Posts.vue') },
  //posts
  { path: '/post/add/:newsletter_id', component: require('./components/post/Add.vue') },
  { path: '/post/edit/:post_id', component: require('./components/post/Edit.vue') },
  //sponsors
  { path: '/sponsors', component: require('./components/sponsor/All.vue') },
  { path: '/sponsor/add', component: require('./components/sponsor/Add.vue') },
  { path: '/sponsor/edit/:sponsor_id', component: require('./components/sponsor/Edit.vue') },
  //images
  { path: '/images', component: require('./components/images/All.vue') },
  //user
  { path: '/user/info', component: require('./components/user/Info.vue') },
  { path: '/user/edit', component: require('./components/user/Edit.vue') },
  //user
  { path: '/users', component: require('./components/users/All.vue'),meta: { checkIfUserIsAdmin: true} },
  { path: '/user/add', component: require('./components/users/Add.vue'),meta: { checkIfUserIsAdmin: true} },
  { path: '/user/edit/:user_id', component: require('./components/users/Edit.vue'),meta: { checkIfUserIsAdmin: true} },
  { path: '/*', redirect:'/newsletters' },
]
const router = new VueRouter({
  routes
})


Vue.prototype.$monthsHelper=[
  {text:'Január',value:1},
  {text:'Február',value:2},
  {text:'Marec',value:3},
  {text:'Apríl',value:4},
  {text:'Máj',value:5},
  {text:'Jún',value:6},
  {text:'September',value:9},
  {text:'Október',value:10},
  {text:'November',value:11},
  {text:'December',value:12},
];

Vue.prototype.$apiURL = "http://10.236.255.88:8000""/api/kiosk/11112222/";
router.beforeEach((to, from, next) => {
  store.dispatch('sidebar/close');
  //middleware check if user is admin
  if (to.matched.some(record => record.meta.checkIfUserIsAdmin)) {
    if(store.state.user.user.role_id ===3){
      next({
        path: '/newsletters',
        query: { redirect: to.fullPath }
      })
    }else{
      next();
    }
  } else {
    next() // make sure to always call next()!
  }
});



store.dispatch('user/load');
store.dispatch('newsletters/load');

//wait for user data being loaded
setTimeout(function(){
  var vm = new Vue({
      store,
      router,
      el: '#app',
  });
}, 100);
