import Vue from 'vue'
import VueRouter from 'vue-router'

import routes from './routes'

Vue.use(VueRouter)

/*
 * If not building with SSR mode, you can
 * directly export the Router instantiation;
 *
 * The function below can be async too; either use
 * async/await or return a Promise which resolves
 * with the Router instance.
 */

export default function ({ store }) {
  const Router = new VueRouter({
    scrollBehavior: () => ({ x: 0, y: 0 }),
    routes,

    // Leave these as they are and change in quasar.conf.js instead!
    // quasar.conf.js -> build -> vueRouterMode
    // quasar.conf.js -> build -> publicPath
    mode: process.env.VUE_ROUTER_MODE,
    base: process.env.VUE_ROUTER_BASE
  })

  Router.beforeEach(async (to, from, next) => {
    if (store.getters['auth/token'] && !store.getters['auth/check']) {
      try {
        await store.dispatch('auth/fetchUser')
      } catch (e) {}
    }
    const route = reroute(to)
    if (route) {
      next(route)
    } else {
      next()
    }
  })
  const rules = {
    guest: { fail: 'index', check: () => (!store.getters['auth/check']) },
    auth: { fail: 'login', check: () => (store.getters['auth/check']) }
  }
  function reroute (to) {
    let failRoute = false,
      checkResult = false
    to.meta.rules && to.meta.rules.forEach(rule => {
      let check = false
      if (Array.isArray(rule)) {
        const checks = []
        for (const i in rule) {
          checks[i] = rules[rule[i]].check()
          check = check || checks[i]
        }
        if (!check && !failRoute) {
          failRoute = rules[rule[checks.indexOf(false)]].fail
        }
      } else {
        check = rules[rule].check()
        if (!check && !failRoute) {
          failRoute = rules[rule].fail
        }
      }
      checkResult = checkResult && check
    })
    if (!checkResult && failRoute) {
      return { name: failRoute }
    }
    return false
  }
  return Router
}
