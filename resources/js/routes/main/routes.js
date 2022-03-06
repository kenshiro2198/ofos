const Index = () => import(/* webpackChunkName: "index" */ '@main/index.vue')
const CategoryIndex = () =>
  import(/* webpackChunkName: "category-index" */ '@main/category/index.vue')
const ContactUsIndex = () =>
  import(/* webpackChunkName: "contact-us-index" */ '@main/contact-us/index.vue')
const TrackOrderIndex = () =>
  import(/* webpackChunkName: "track-order-index" */ '@main/track-order/index.vue')

export default [
  {
    name: 'index',
    path: '/',
    component: Index,
    meta: {
      breadcrumb: 'Home'
    }
  },
  {
    name: 'category-index',
    path: '/category',
    component: CategoryIndex
  },
  {
    name: 'contact-us-index',
    path: '/contact-us',
    component: ContactUsIndex,
    meta: {
      breadcrumb: 'Contact Us'
    }
  },
  {
    name: 'track-order-index',
    path: '/track-order',
    component: TrackOrderIndex,
    meta: {
      breadcrumb: 'Track Order'
    }
  }
]
