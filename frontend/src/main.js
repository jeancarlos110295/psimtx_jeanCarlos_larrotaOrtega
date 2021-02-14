import Vue from 'vue'
import './plugins/axios'
import './components'

import App from './App.vue'
import router from './router'
import store from './store'
import vuetify from './plugins/vuetify';


router.beforeEach((to, from, next) =>{
  let isAuthenticated = store.state.stateLogin;

  if(to.meta.requiresAuth){
    (isAuthenticated) ? next() : next({path : '/Login'})
  }
  next()
})

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
