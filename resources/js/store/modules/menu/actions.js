import { requestIndex } from "@js/util";
export default {
    async fetch(ctx, options) {
        requestIndex("/items", ctx, options);
        // const { data } = await axios.get('/departments');
        // commit('setList', data);
    },
    async save({ state, commit }, form) {
        // console.log(form);
        if (form.id) {
            await axios.put("/items/" + form.id, form);
        } else {
            await axios.post("/items", form);
        }
    },
    async delete({ state, commit }, { id, callback = () => {} }) {
        const res = await axios.delete("/items/" + id); // delete
        callback(res.data);
    },
};
