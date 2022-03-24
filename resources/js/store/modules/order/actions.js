import { requestIndex } from "@js/util";
export default {
    async fetch(ctx, options) {
        requestIndex("/orders", ctx, options);
    },
    async save({ state, commit }, form) {
        // console.log(form);
        if (form.id) {
            const { data } = await axios.put("/orders/" + form.id, form);
            return data;
        } else {
            const { data } = await axios.post("/orders", form);
            return data;
        }
    },
    async delete({ state, commit }, { id, callback = () => {} }) {
        const res = await axios.delete("/orders/" + id); // delete
        callback(res.data);
    },
};
