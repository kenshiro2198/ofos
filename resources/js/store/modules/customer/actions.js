import { requestIndex } from "@js/util";
export default {
    async fetch(ctx, options) {
        requestIndex("/users?type=2", ctx, options);
        // const { data } = await axios.get('/departments');
        // commit('setList', data);
    },
    async save({ state, commit }, form) {
        // console.log(form);
        if (form.id) {
            await axios.put("/users/" + form.id, form);
        } else {
            await axios.post("/users", form);
        }
    },
    async delete({ state, commit }, { id, callback = () => {} }) {
        const res = await axios.delete("/users/" + id); // delete
        callback(res.data);
    },
};
