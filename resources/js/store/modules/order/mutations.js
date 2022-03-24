export default {
	set(state, list) {
		state.list = list;
	},
	total(state, total) {
		state.totalItems = total;
	},
	setItem(state, item) {
		state.item = item;
	}
};
