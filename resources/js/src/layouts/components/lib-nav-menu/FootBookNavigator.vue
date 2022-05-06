<template>
  <v-navigation-drawer
    bottom
    absolute
    hide-overlay
    height="80px"
    width="100%"
    :value="isDrawerOpen"
    @input="val => $emit('update:is-drawer-open', val)"
  >
    <v-list-item>
      <v-list-item-content>
        <div class="text-center">
          <v-pagination :length="4" circle></v-pagination>
        </div>
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
  position: fixed !important;
  transform: translateY(100%) !important;
}
.v-navigation-drawer--open {
  transform: translateY(0%) !important;
}
</style>