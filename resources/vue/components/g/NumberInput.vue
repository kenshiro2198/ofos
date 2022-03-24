<template>
    <v-text-field
        class="mt-1 number-tfield"
        v-model="text"
        name="name"
        placeholder="0.00"
        @keydown="checkInput"
        @blur="blurInput($event)"
        v-bind="$attrs"
        ref="numberInput"
        @change="$emit('change', $event)"
    >
        <template #append>
            <slot name="append"> </slot>
        </template>
    </v-text-field>
</template>
<script>
export default {
    props: {
        value: {
            type: undefined,
            default: 0,
        },
        decimal: {
            type: Boolean,
            default: true,
        },
    },
    inject: {
        $validator: "$validator",
    },
    $_veeValidate: {
        value() {
            return this.original;
        },
    },
    data() {
        return {
            original: 0,
            text: "0",
        };
    },
    mounted() {
        this.transformValue(this.value);
    },
    methods: {
        // focusPointer(e) {
        //   const input = document.getElementById("numberinput");
        //   input.focus();
        //   input.setSelectionRange(0, 1);
        // },
        blurInput(e) {
            let vm = this;

            let res = /^[a-zA-Z]+$/.test(vm.text);
            if (res) {
                vm.text = "0";
            }
            this.original = vm.text;
            vm.text = vm.formatNumber(vm.text);

            vm.$emit("blur", e);
            this.$emit("input", this.original);
        },
        isLetter(str) {
            return str.length === 1 && str.match(/[a-z]/i);
        },
        checkInput(e) {
            const isNumber = isFinite(event.key);

            const hasDot =
                e.target.value.indexOf(".") > -1 &&
                [110, 190].includes(e.keyCode);

            const isZero =
                parseFloat(this.text) == 0 && [96, 48].includes(e.keyCode);

            const ctrlA = e.keyCode == 65 && e.ctrlKey;
            const ctrlV = e.keyCode == 86 && e.ctrlKey;
            const ctrlC = e.keyCode == 67 && e.ctrlKey;

            if (
                !ctrlC &&
                !ctrlV &&
                !ctrlA &&
                (!isNumber || e.keyCode == 32) &&
                (![37, 38, 39, 40, 8, 46, 110, 190].includes(e.keyCode) ||
                    isZero ||
                    hasDot)
            ) {
                e.preventDefault();
                return false;
            }

            // this.transformValue(this.text);
        },
        transformValue(e) {
            // const val = e.target.value;
            let val = e;
            if (val === "" || val == null) {
                this.text = "";
                this.$emit("input", null);
                return;
            }
            val = val.toString();
            const num = parseFloat(val.replace(/,/g, ""));
            this.original = num;
            const formatted = Number(num).toLocaleString(undefined, {
                minimumFractionDigits: this.decimal ? 2 : 0,
            });
            let el = this.$el.querySelector("input");
            let startPos = el.selectionStart;
            let endPos = el.selectionEnd;
            this.text = formatted;
            // el.focus
            this.$emit("input", this.original);

            var setSelectionRange = function () {
                el.setSelectionRange(startPos, startPos);
            };
            if (el === document.activeElement) {
                setSelectionRange();
                setTimeout(setSelectionRange, 1); // Android Fix
            }

            // if (startPos && endPos) el.setSelectionRange(startPos, endPos);
        },
    },
    watch: {
        value(val) {
            this.transformValue(val);
        },
    },
};
</script>
<style>
.number-tfield input {
    text-align: right !important;
}
</style>
