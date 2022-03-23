export default {
    find() {
        return async (id) => {
            const { data } = await axios.get("/items/" + id);
            // console.log(data);
            return data;
        };
    },
};
