<template>
  <div>
    <v-text-field
      ref="input"
      slot="activator"
      v-bind="$attrs"
      @blur="commit"
      @keyup="keyUp"
      :placeholder="format"
      v-model="dateFormatted"
    >
      <template #label>
        <slot name="label"></slot>
      </template>
      <template #append>
        <v-menu
          v-model="dateDialogPicker"
          offset-y
          nudge-left="100"
          :close-on-content-click="false"
        >
          <template #activator="{ on }">
            <v-icon v-on="on">mdi-calendar</v-icon>
          </template>
          <v-date-picker
            ref="picker"
            @click:date="dateDialogPicker = false"
            v-model="datePicker"
            :min="min ? minimum : ''"
            @input="formatAndApply"
            no-title
          ></v-date-picker>
        </v-menu>
      </template>
    </v-text-field>
  </div>
</template>

<script>
export default {
  props: {
    value: {
      type: String
    },
    format: {
      type: String,
      default: "MM/DD/YYYY"
    },
    min: {
      type: String
    },
    empty: Boolean,
    birthday: Boolean
  },
  data() {
    let vm = this;
    return {
      dateDialogPicker: false,
      date: "",
      datePicker: "",
      dateFormatted: vm.empty ? "" : vm.$moment().format(vm.format),
      minimum: new Date().toISOString().substr(0, 10)
    };
  },
  created() {
    this.commit(this.value);
  },
  watch: {
    dateFormatted(e) {
      this.$emit("input", e);
    },
    value(val) {
      if (val) {
        this.formatAndApply(val);
      }
    },
    min(val) {
      this.minimum = val;
      if (this.value < val) {
        this.formatAndApply(val);
      }
    },
    dateFormatted(val) {
      if (val.length == 10) {
        this.commit("e");
      } else if (val.length == 0) {
        this.$emit("input", "");
      }
    },
    dateDialogPicker(e) {
      if (this.birthday) {
        e && setTimeout(() => (this.$refs.picker.activePicker = "YEAR"));
      }
    }
  },
  computed: {
    masker() {
      const mask = this.format.replace(/[a-zA-Z]/g, "#");
      return mask;
    },
    delimiter() {
      const index = this.format.search(/[^a-zA-Z]/g);
      return this.format[index];
    }
  },
  mounted() {
    if (this.value) {
      this.date = this.value;
      this.formatAndApply(this.value);
    }
  },
  methods: {
    commit(e) {
      if (this.dateFormatted.length != this.format.length) {
        this.dateFormatted = "";
        // this.error = true;
      } else {
        const d = this.$moment(this.dateFormatted).format("YYYY-MM-DD");
        this.$emit("input", d);
      }
    },
    keyDown(e) {
      let value = JSON.parse(JSON.stringify(this.dateFormatted)); //e.target.value;
      const v = (value + e.key).split(/[^a-zA-Z0-9]/);
      const f = this.format.split(/[^a-zA-Z]/);

      if (e.which == 8) {
        // if (value[value.length - 1] == this.delimiter) {
        this.dateFormatted = value.substring(0, value.length - 1);
        this.date = value.substring(0, value.length - 1);
        // }
        return;
      } else if (v.join("").length == 9 || isNaN(e.key)) {
        e.preventDefault();
        e.stopPropagation();
        return;
      }

      value += e.key;

      const element = f[v.length - 1];
      const _fv = JSON.parse(JSON.stringify(f))
        .splice(0, v.length)
        .join(this.delimiter);

      const blockValid = this.$moment(v.join(this.delimiter), _fv).isValid();

      if (!blockValid && e.key != "0") {
        e.preventDefault();
        e.stopPropagation();
      }
    },
    keyUp(e) {
      // const value = e.target.value;
      const f = this.format.split(/[^a-zA-Z]/);
      const v = this.dateFormatted.split(/[^a-zA-Z0-9]/);

      if (v[v.length - 1].length == f[v.length - 1].length && v.length != 3) {
        this.dateFormatted += "/";
        // e.target.value = this.date;
      }
    },
    formatAndApply(date) {
      this.datePicker = date;
      const d = this.$moment(date).format(this.format);
      this.dateFormatted = d;
      this.$emit("input", date);
    }
  }
};
</script>