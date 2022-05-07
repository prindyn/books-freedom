<template>
  <v-navigation-drawer
    clipped
    absolute
    floating
    hide-overlay
    height="3rem"
    width="100%"
    :value="isDrawerOpen"
    @input="val => $emit('update:is-drawer-open', val)"
  >
    <v-list-item>
      <v-list-item-content>
        <v-list-item-title>John Leider</v-list-item-title>
      </v-list-item-content>
    </v-list-item>
  </v-navigation-drawer>
</template>

<script>
export default {
  props: {
    isDrawerOpen: {
      type: Boolean,
      default: null,
    },
  },
  data() {
    return {
      mini: true,
    }
  },
}
</script>

<style lang="scss" scoped>
.v-navigation-drawer--close {
  transform: translateY(-100%) !important;
}
.v-navigation-drawer--open {
  transform: translateY(0%) !important;
}
</style>