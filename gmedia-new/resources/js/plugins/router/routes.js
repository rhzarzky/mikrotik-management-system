export const routes = [
  { path: '/', redirect: '/login' },
  {
    path: '/',
    component: () => import('@/layouts/default.vue'),
    children: [
      {
        path: 'dashboard',
        name: 'dashboard',
        component: () => import('@/pages/dashboard.vue'),
      },
      {
        path: 'user',
        name: 'user',
        component: () => import('@/pages/user.vue'),
      },
      {
        path: 'router',
        name: 'router',
        component: () => import('@/pages/router.vue'),
      },
      {
        path: 'interface',
        name: 'interface',
        component: () => import('@/pages/dashboard-router.vue'),
      },
      {
        path: 'user-hotspot',
        name: 'user-hotspot',
        component: () => import('@/pages/user-hotspot.vue'),
      },
      {
        path: 'user-profile',
        name: 'user-profile',
        component: () => import('@/pages/user-profile.vue'),
      },
      {
        path: 'account-settings',
        name: 'account-settings',
        component: () => import('@/pages/account-settings.vue'),
      },
    ],
  },
  {
    path: '/',
    component: () => import('@/layouts/blank.vue'),
    children: [
      {
        path: 'login',
        name: 'login',
        component: () => import('@/pages/login.vue'),
      },
      {
        path: 'register',
        component: () => import('@/pages/register.vue'),
      },
      {
        path: '/:pathMatch(.*)*',
        component: () => import('@/pages/[...error].vue'),
      },
    ],
  },
]
