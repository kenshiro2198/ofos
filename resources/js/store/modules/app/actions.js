export default {
    async fetchUser({
        state
    }) {
        const {
            data
        } = await axios.get("/me");
        state.user = data;
    },
    async getUser() {
        const {
            data
        } = await axios.get("/me");
        return data;
    },
    dateCompare(event, date) {
        if (!date) return;
        let release_date = new Date(date);
        let now_date = new Date();
        release_date.setHours(0, 0, 0, 0);
        now_date.setHours(0, 0, 0, 0);
        return now_date >= release_date;
    },
};
