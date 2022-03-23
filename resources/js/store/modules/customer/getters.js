export default {
    find() {
        return async (id) => {
            const { data } = await axios.get("/users/" + id + "?type=2");
            // console.log(data);
            return data;
        };
    },
};
