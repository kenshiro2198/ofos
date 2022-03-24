export default {
    drawer: false,
    history: null,
    busy: false,
    loginBusy: false,
    filter: false,
    user: null,
    loading: false,
    cart: 0,
    navigation_items: [
        {
            title: "Dashboard",
            icon: "mdi-view-dashboard",
            to: "/dashboard",
        },
        {
            title: "Users",
            icon: "mdi-account-outline",
            to: "/users",
        },
        {
            title: "Customers",
            icon: "mdi-account-group",
            to: "/customers",
        },
        {
            title: "Categories",
            icon: "mdi-view-dashboard-variant",
            to: "/categories",
        },
        {
            title: "Food Menu",
            icon: "mdi-egg-fried",
            to: "/menu",
        },
        {
            title: "Orders",
            icon: "mdi-format-list-bulleted",
            to: "/orders",
        },
        {
            title: "Reports",
            icon: "mdi-file",
            to: "/reports",
        },
    ],
};
