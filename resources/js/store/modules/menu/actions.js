import { requestIndex } from "@js/util";
export default {
    async fetch(ctx, options) {
        requestIndex("/items", ctx, options);
    },
    async save({ state, commit }, form) {
        // console.log(form);
        if (form.id) {
            const { data } = await axios.put("/items/" + form.id, form);
            return data;
        } else {
            const { data } = await axios.post("/items", form);
            return data;
        }
    },
    async delete({ state, commit }, { id, callback = () => {} }) {
        const res = await axios.delete("/items/" + id); // delete
        callback(res.data);
    },
};
