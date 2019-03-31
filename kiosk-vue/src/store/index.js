import Vue from 'vue'
import Vuex from 'vuex'
import patients from './modules/patients.js'

Vue.use(Vuex)



export default new Vuex.Store({
  modules: {
    patients
  },
})
