export default {
    find() {
        return async (id) => {
            const { data } = await axios.get("/users/" + id + "?type=1");
            // console.log(data);
            return data;
        };
    },
};
