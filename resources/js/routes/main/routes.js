const CategoriesIndex = () =>
  import(/* webpackChunkName: "categories-index" */ '@main/categories/index.vue')
const CategoriesIndexCreate = () =>
  import(/* webpackChunkName: "categories-index-create" */ '@main/categories/index/create.vue')
const CategoriesIndexIdUpdate = () =>
  import(/* webpackChunkName: "categories-index-id-update" */ '@main/categories/index/_id/update.vue')
const CustomersIndex = () =>
  import(/* webpackChunkName: "customers-index" */ '@main/customers/index.vue')
const DashboardIndex = () =>
  import(/* webpackChunkName: "dashboard-index" */ '@main/dashboard/index.vue')
const MenuIndex = () =>
  import(/* webpackChunkName: "menu-index" */ '@main/menu/index.vue')
const UsersIndex = () =>
  import(/* webpackChunkName: "users-index" */ '@main/users/index.vue')
const CustomersCreate = () =>
  import(/* webpackChunkName: "customers-create" */ '@main/customers/create.vue')
const MenuCreate = () =>
  import(/* webpackChunkName: "menu-create" */ '@main/menu/create.vue')
const UsersCreate = () =>
  import(/* webpackChunkName: "users-create" */ '@main/users/create.vue')
const CustomersIdUpdate = () =>
  import(/* webpackChunkName: "customers-id-update" */ '@main/customers/_id/update.vue')
const MenuIdUpdate = () =>
  import(/* webpackChunkName: "menu-id-update" */ '@main/menu/_id/update.vue')
const UsersIdUpdate = () =>
  import(/* webpackChunkName: "users-id-update" */ '@main/users/_id/update.vue')

export default [
  {
    name: 'categories-index',
    path: '/categories',
    component: CategoriesIndex,
    meta: {
      breadcrumb: 'Categories'
    },
    children: [
      {
        name: 'categories-index-create',
        path: 'create',
        component: CategoriesIndexCreate,
        meta: {
          breadcrumb: 'Create'
        }
      },
      {
        name: 'categories-index-id-update',
        path: ':id/update',
        component: CategoriesIndexIdUpdate,
        meta: {
          breadcrumb: 'Update'
        }
      }
    ]
  },
  {
    name: 'customers-index',
    path: '/customers',
    component: CustomersIndex,
    meta: {
      breadcrumb: 'Customers'
    }
  },
  {
    name: 'dashboard-index',
    path: '/dashboard',
    component: DashboardIndex,
    meta: {
      breadcrumb: 'Dashboard'
    }
  },
  {
    name: 'menu-index',
    path: '/menu',
    component: MenuIndex,
    meta: {
      breadcrumb: 'Menu'
    }
  },
  {
    name: 'users-index',
    path: '/users',
    component: UsersIndex,
    meta: {
      breadcrumb: 'Users'
    }
  },
  {
    name: 'customers-create',
    path: '/customers/create',
    component: CustomersCreate,
    meta: {
      breadcrumb: 'Create'
    }
  },
  {
    name: 'menu-create',
    path: '/menu/create',
    component: MenuCreate,
    meta: {
      breadcrumb: 'Create'
    }
  },
  {
    name: 'users-create',
    path: '/users/create',
    component: UsersCreate,
    meta: {
      breadcrumb: 'Create'
    }
  },
  {
    name: 'customers-id-update',
    path: '/customers/:id/update',
    component: CustomersIdUpdate,
    meta: {
      breadcrumb: 'Update'
    }
  },
  {
    name: 'menu-id-update',
    path: '/menu/:id/update',
    component: MenuIdUpdate,
    meta: {
      breadcrumb: 'Update'
    }
  },
  {
    name: 'users-id-update',
    path: '/users/:id/update',
    component: UsersIdUpdate,
    meta: {
      breadcrumb: 'Update'
    }
  }
]
