export default {
    find() {
        return async (id) => {
            const { data } = await axios.get("/categories/" + id);
            // console.log(data);
            return data;
        };
    },
};
