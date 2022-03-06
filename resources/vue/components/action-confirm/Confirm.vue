<template>
	<v-app class="absolute">
		<v-dialog
			v-model="value"
			:max-width="width"
			persistent
			@keydown.esc="choose(false)"
		>
			<v-card tile>
				<v-card-title :class="`${color}--text`">
					<v-icon left :color="color">{{ icon }}</v-icon>
					{{ title }}
				</v-card-title>
				<v-card-text>
					{{ message }}
				</v-card-text>
				<v-card-actions>
					<v-spacer></v-spacer>
					<v-btn
						small
						outlined
						:color="color"
						:class="`white--text button-letter `"
						@click="choose(false)"
						v-if="!noNegative"
						>{{ negativeText }}</v-btn
					>
					<v-btn
						:color="positiveTextColor"
						class="button-letter"
						small
						text
						@click="choose(true)"
						>{{ positiveText }}</v-btn
					>
				</v-card-actions>
			</v-card>
		</v-dialog>
	</v-app>
</template>
<style scope>
.absolute {
	position: absolute;
}
</style>

<script>
import {
	VDialog,
	VCard,
	VCardTitle,
	VCardText,
	VCardActions,
	VSpacer,
	VBtn
} from "vuetify/lib";

export default {
	props: {
		icon: {
			type: String,
			default: "mdi-alert"
		},
		title: {
			type: String,
			default: "Warning"
		},
		positiveText: {
			type: String,
			default: "Yes"
		},
		positiveTextColor: {
			type: String,
			default: null
		},
		negativeText: {
			type: String,
			default: "No"
		},
		color: {
			type: String,
			default: "warning"
		},
		message: {
			type: String,
			required: true
		},
		noNegative: {
			type: Boolean,
			default: false
		},
		persistent: {
			type: Boolean,
			default: true
		},
		width: {
			type: Number,
			default: 350
		},
		onStop: {
			default: undefined
		}
	},
	data() {
		return {
			value: true,
			stop: false
		};
	},
	methods: {
		choose(value) {
			this.value = value;
			if (this.stop) this.onStop();
			this.$destroy();
		}
	}
};
</script>

<style lang="scss">
.button-letter {
	letter-spacing: 0.5px !important;
	font-weight: bold !important;
}
</style>