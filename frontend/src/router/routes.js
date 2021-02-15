export default [
  ...applyRules(['guest'], [
    {
      path: '/',
      component: () => import('layouts/AuthLayout.vue'),
      children: [
        {
          path: '',
          name: 'login',
          component: () => import('pages/auth/Index.vue')
        }
      ]
    }
  ]),
  ...applyRules(['auth'], [
    {
      path: '/home',
      component: () => import('layouts/MainLayout.vue'),
      children: [
        // Pantalla inicial Dashboard
        {
          path: '',
          name: 'index',
          component: () => import('pages/dashboard/Index.vue')
        },
        // Rutas del perfil de usuario
        {
          path: '/perfil',
          name: 'perfil',
          component: () => import('pages/user/Index.vue')
        },
        {
          path: '/change_password',
          name: 'password',
          component: () => import('pages/user/Password.vue')
        }
      ]
    }
  ]),
  { path: '*', redirect: { name: 'index' } }
]
function applyRules (rules, routes) {
  for (const i in routes) {
    routes[i].meta = routes[i].meta || {}

    if (!routes[i].meta.rules) {
      routes[i].meta.rules = []
    }
    routes[i].meta.rules.unshift(...rules)

    if (routes[i].children) {
      routes[i].children = applyRules(rules, routes[i].children)
    }
  }

  return routes
}
