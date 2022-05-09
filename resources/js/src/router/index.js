import Vue from 'vue'
import VueRouter from 'vue-router'
import { auth } from '@/utils'

Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    name: 'dashboard',
    component: () => import('@/views/dashboard/Dashboard.vue'),
  },
  {
    path: '/typography',
    name: 'typography',
    component: () => import('@/views/typography/Typography.vue'),
  },
  {
    path: '/icons',
    name: 'icons',
    component: () => import('@/views/icons/Icons.vue'),
  },
  {
    path: '/cards',
    name: 'cards',
    component: () => import('@/views/cards/Card.vue'),
  },
  {
    path: '/simple-table',
    name: 'simple-table',
    component: () => import('@/views/simple-table/SimpleTable.vue'),
  },
  {
    path: '/form-layouts',
    name: 'form-layouts',
    component: () => import('@/views/form-layouts/FormLayouts.vue'),
  },
  {
    path: '/pages/account-settings',
    name: 'pages-account-settings',
    component: () => import('@/views/pages/account-settings/AccountSettings.vue'),
  },
  {
    path: '/login',
    name: 'login',
    component: () => import('@/pages/Login.vue'),
    meta: {
      layout: 'blank',
      public: true,
      unauth: true,
    },
  },
  {
    path: '/register',
    name: 'register',
    component: () => import('@/pages/Register.vue'),
    meta: {
      layout: 'blank',
      public: true,
      unauth: true,
    },
  },
  {
    path: '/library',
    name: 'library',
    component: () => import('@/pages/Library.vue'),
    meta: {
      layout: 'lib-content',
      public: true,
    },
  },
  {
    path: '/read',
    name: 'read',
    component: () => import('@/pages/ReadBook.vue'),
    meta: {
      layout: 'lib-content',
      public: true,
    },
  },
  {
    path: '/error-404',
    name: 'error-404',
    component: () => import('@/views/Error.vue'),
    meta: {
      layout: 'blank',
    },
  },
  {
    path: '*',
    redirect: 'error-404',
  },
]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes,
})

router.beforeEach((to, from, next) => {
  if (to.matched.some(record => !record.meta.public)) {
    if (!auth.check()) router.push('/login')
  }
  else if (to.matched.some(record => record.meta.unauth)) {
    if (auth.check()) router.push('/')
  }
  return next()
});

export default router
