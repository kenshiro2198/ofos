export default {
    drawer: false,
    history: null,
    busy: false,
    loginBusy: false,
    filter: false,
    user: null,
    loading: false,
    navigation_items: [{
            title: "Borrowers",
            icon: "mdi-account-outline",
            to: "/borrowers/individual",
            access: "Borrowers"
        },
    ]
};
