import Vuetify from "@js/plugins/vuetify";
import Confirm from './Confirm.vue';
import "@mdi/font/css/materialdesignicons.css";
const Install = {
	install(Vue, options) {
		const vuetify = Vuetify;
		const property = (options && options.property) || '$confirm';
		var cmp;
		function createDialogCmp(options) {
			// create element as parent container of element
			const div = document.createElement('div');
			document.body.appendChild(div);

			return new Promise((resolve) => {
				cmp = new Vue(
					Object.assign(
						{
							vuetify //use vuetify to resolve theme dependency
						},
						Confirm,
						{
							propsData: Object.assign({}, Vue.prototype.$confirm.options, options),
							destroyed: (c) => {
								resolve(cmp.value);
							}
						}
					)
				);
				// mount component to container
				cmp.$mount(div);
			});
		}

		function show(message, options = {}) {
			options.message = message;
			return createDialogCmp(options);
		}

		Vue.prototype[property] = show;
		Vue.prototype[property].options = options || {};
	}
};

export default Install;
