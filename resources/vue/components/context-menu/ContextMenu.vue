<template>
	<v-menu
		eager
		absolute
		v-model="visible"
		:position-x="x"
		:position-y="y"
		offset-y
		close-on-content-click
		nudge-top="18"
		nudge-left="18"
		content-class="context-menu"
		@update:return-value="hide"
	>
		<div class="pa-2">
			<v-card rounded v-if="visible" min-width="170px">
				<v-list dense rounded>
					<template v-for="(item, i) in visibleItems">
						<v-list-item @click="invokeAction(item)" :key="i">
							<v-icon
								:color="item.icon == 'mdi-delete' ? 'error' : 'teal'"
								small
								class="mr-4"
								>{{ item.icon }}</v-icon
							>
							<v-list-item-title style="letter-spacing: 0.5px;">{{
								item.text
							}}</v-list-item-title>
						</v-list-item>
					</template>
				</v-list>
			</v-card>
		</div>
	</v-menu>
</template>

<script>
export default {
	props: {
		items: {
			type: Array
		}
	},
	data: () => ({
		visible: false,
		x: 0,
		y: 0,
		rowItem: undefined,
		component: undefined,
		visibleItems: [],
		selectedRow: null
	}),
	methods: {
		invokeAction(item) {
			if (item.key && !item.action) {
				this.component.$emit(`context:${item.key}`, this.rowItem);
			} else if (item.action) {
				item.action.call(this.rowItem, this.rowItem);
			}
		},
		highlightRow(e) {
			if (e.path[1].localName == "tr") {
				this.selectedRow = e.path[1];
			} else if (e.path[1].localName == "td") {
				this.selectedRow = e.path[2];
			}
			this.selectedRow.className = "selected";
		},
		async show(item, component) {
			const e = window.event;
			this.x = e.clientX;
			this.y = e.clientY;

			this.component = component;
			//   check if there is any available items to show
			let vItems = [];
			for (let i = 0; i < this.items.length; i++) {
				const _item = this.items[i];
				_item.init ? _item.init.call(this.component, item) : {};
				let visible = false;
				if (_item.visible) {
					visible = await _item.visible.call(this.component, item);
				} else {
					visible = typeof _item.visible === "undefined";
				}
				if (visible) vItems.push(_item);
			}
			this.visibleItems = vItems;
			// this.visibleItems = this.items.filter(
			//   e =>
			//     (e.init && e.init.call(e, item)) ||
			//     typeof e.visible === "undefined" ||
			//     e.visible.call(e, item)
			// );
			if (this.visibleItems.length == 0) {
				this.$toast.warning("No available actions for the selected item!");
				return;
			} else {
				this.highlightRow(e);
			}

			this.rowItem = item;
			this.visible = false;

			this.$nextTick(() => {});
			this.visible = true;
		},
		hide() {
			this.selectedRow.classList.remove("selected");
			this.rowItem = undefined;
			this.visible = false;
		}
	}
};
</script>
<style >
.v-list-item--link:before {
	pointer-events: all !important;
}
.context-menu {
	box-shadow: unset !important;
}
.v-list--dense .v-list-item,
.v-list-item--dense {
	min-height: 32px !important;
}
</style>