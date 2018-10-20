
const routes = [
  {
    path: '/',
    component: () => import('layouts/MyLayout.vue'),
    children: [
      { path: '', component: () => import('pages/auth/Login.vue') }
    ]
  },
  {
    path: '/login',
    component: () => import('layouts/MyLayout.vue'),
    children: [
      { path: '', component: () => import('pages/auth/Login.vue') }
    ]
  },
  {
    path: '/register',
    component: () => import('layouts/MyLayout.vue'),
    children: [
      { path: '', component: () => import('pages/auth/Register.vue') }
    ]
  },
  {
    path: '/clients/userAdminRegister',
    component: () => import('layouts/MyLayout.vue'),
    children: [
      { path: '', component: () => import('pages/clients/UserAdminRegister.vue') }
    ]
  },
  {
    path: '/verify',
    component: () => import('layouts/MyLayout.vue'),
    children: [
      { path: '', component: () => import('pages/auth/Verify.vue') }
    ]
  },
  {
    path: '/recovery',
    component: () => import('layouts/MyLayout.vue'),
    children: [
      { path: '', component: () => import('pages/auth/Recovery.vue') }
    ]
  },
  {
    path: '/dashboard',
    component: () => import('layouts/MyLayout.vue'),
    children: [
      { path: '', component: () => import('pages/Dashboard.vue') }
    ]
  },
  {
    path: '/materials',
    component: () => import('layouts/MyLayout.vue'),
    children: [
      { path: '', component: () => import('pages/materials/Search.vue') }
    ]
  },
  {
    path: '/plans',
    component: () => import('layouts/MyLayout.vue'),
    children: [
      { path: '', component: () => import('pages/plans/List.vue') }
    ]
  },
  {
    path: '/clients/new',
    component: () => import('layouts/MyLayout.vue'),
    children: [
      { path: '', component: () => import('pages/clients/New.vue') }
    ]
  }
]

// Always leave this as last one
if (process.env.MODE !== 'ssr') {
  routes.push({
    path: '*',
    component: () => import('pages/Error404.vue')
  })
}

export default routes
