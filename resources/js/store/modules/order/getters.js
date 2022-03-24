export default {
    find() {
        return async (id) => {
            const { data } = await axios.get("/orders/" + id);
            // console.log(data);
            return data;
        };
    },
};
