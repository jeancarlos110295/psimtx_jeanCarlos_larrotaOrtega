import Vue from 'vue'
import VueRouter from 'vue-router'

import paths from './rutas'

function route (path, view, name) {
  return {
    name: name || view,
    path,
    component: (resovle) => import(
      `@/views/${view}.vue`
    ).then(resovle)
  }
}

Vue.use(VueRouter)


const router = new VueRouter({
  mode: "history",

  routes: paths.map(path => route(path.path, path.view, path.name, path.redirect)).concat([
    { path: '*', redirect: '/' }
  ]),
  scrollBehavior (to, from, savedPosition) {
    if (savedPosition) {
      return savedPosition
    }
    if (to.hash) {
      return { selector: to.hash }
    }
    return { x: 0, y: 0 }
  }
})

export default router
