<template>
  <div>
    <v-alert
      dismissible
      dense
      type="error"
      v-if="errorMsg ? errorMsg.length : false"
    >
      <div v-for="(error, i) in errorMsg" :key="i">• {{ error }}</div>
    </v-alert>
    <v-alert dismissible dense type="error" v-if="value.length > 0">
      <div v-for="(error, i) in value" :key="i">• {{ error }}</div>
    </v-alert>
  </div>
</template>
<script>
export default {
  data() {
    return {};
  },
  props: {
    value: {
      type: Array,
      default: () => []
    },
    errorMsg: {
      type: Array,
      default: () => []
    }
  }
};
</script>
