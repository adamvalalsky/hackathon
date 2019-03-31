window.axios = require('axios');
import Vue from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'

Vue.config.productionTip = false
Vue.prototype.$apiURL = "http://10.236.255.88:8000/api/kiosk/11112222/";

store.dispatch('patients/load');


setTimeout(function(){
	new Vue({
	  store,
	  router,
	  render: h => h(App)
	}).$mount('#app');
}, 100);
