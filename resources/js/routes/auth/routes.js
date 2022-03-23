const Login = () => import(/* webpackChunkName: "login" */ '@auth/login.vue')

export default [
  {
    name: 'login',
    path: '/login',
    component: Login
  }
]
