import { requestIndex } from "@js/util";
export default {
    async fetch(ctx, options) {
        requestIndex("/categories", ctx, options);
        // const { data } = await axios.get('/departments');
        // commit('setList', data);
    },
    async save({ state, commit }, form) {
        // console.log(form);
        if (form.id) {
            await axios.put("/categories/" + form.id, form);
        } else {
            await axios.post("/categories", form);
        }
    },
    async delete({ state, commit }, { id, callback = () => {} }) {
        const res = await axios.delete("/categories/" + id); // delete
        callback(res.data);
    },
};
