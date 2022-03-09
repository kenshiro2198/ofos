const Index = () => import(/* webpackChunkName: "index" */ '@main/index.vue')
const CategoryIndex = () =>
  import(/* webpackChunkName: "category-index" */ '@main/category/index.vue')
const ContactUsIndex = () =>
  import(/* webpackChunkName: "contact-us-index" */ '@main/contact-us/index.vue')
const MenuIndex = () =>
  import(/* webpackChunkName: "menu-index" */ '@main/menu/index.vue')
const TrackOrderIndex = () =>
  import(/* webpackChunkName: "track-order-index" */ '@main/track-order/index.vue')
const MenuProductSearch = () =>
  import(/* webpackChunkName: "menu-product-search" */ '@main/menu/product-search.vue')

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
    name: 'menu-index',
    path: '/menu',
    component: MenuIndex,
    meta: {
      breadcrumb: 'Home'
    }
  },
  {
    name: 'track-order-index',
    path: '/track-order',
    component: TrackOrderIndex,
    meta: {
      breadcrumb: 'Track Order'
    }
  },
  {
    name: 'menu-product-search',
    path: '/menu/product-search',
    component: MenuProductSearch,
    meta: {
      breadcrumb: 'Home'
    }
  }
]
