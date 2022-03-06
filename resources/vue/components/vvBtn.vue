<template>
  <v-btn
    @click="invokeAction(action)"
    v-bind="$attrs"
    :loading="$store.state.app.loading"
    :disabled="$store.state.app.loading || isDisabled"
  >
    <slot></slot>
  </v-btn>
</template>
<script>
export default {
  props: {
    isDisabled: Boolean
  },
  data() {
    return {
      action: Function
    };
  },
  mounted() {
    this.action = this.$listeners.click;
  },
  methods: {
    invokeAction(action) {
      action.call(this.$parent);
    }
  }
};
</script>
