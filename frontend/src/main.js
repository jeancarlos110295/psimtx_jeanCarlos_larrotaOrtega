import Vue from 'vue'
import './plugins/axios'
import './components'

import App from './App.vue'
import router from './router'
import store from './store'
import vuetify from './plugins/vuetify';


Vue.config.productionTip = false

new Vue({
  router,
  store,
  vuetify,
  render: h => h(App),
  created(){
    this.$store.commit("setLoginState", {accion: "updateState"})
  }
}).$mount('#app')
