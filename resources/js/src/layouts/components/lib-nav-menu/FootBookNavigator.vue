<template>
  <v-navigation-drawer
    bottom
    absolute
    hide-overlay
    height="7rem"
    width="100%"
    :value="isDrawerOpen"
    @input="val => $emit('update:is-drawer-open', val)"
  >
    <v-list-item>
      <v-list-item-content>
        <div class="text-center">
          <v-slider
            height="2rem"
            v-model="curPage"
            hideDetails
            min="0"
            :max="pagesTotal"
            @mouseup="() => $emit('navpageupdate', curPage - 1)"
          ></v-slider>
          <v-pagination
            v-model="curPage"
            @input="() => $emit('navpageupdate', curPage - 1)"
            :length="pagesTotal"
            :total-visible="6"
            circle
          ></v-pagination>
        </div>
      </v-list-item-content>
    </v-list-item>
  </v-navigation-drawer>
</template>

<script>
export default {
  props: {
    pagesTotal: {
      type: Number,
      default: 0,
    },
    curNavPage: {
      type: Number,
      default: 0,
    },
    isDrawerOpen: {
      type: Boolean,
      default: null,
    },
  },
  setup() {
    const curPage = 0
    return {
      curPage,
    }
  },
  mounted() {
    this.curPage = this.curNavPage + 1
  },
  watch: {
    curNavPage() {
      this.curPage = this.curNavPage + 1
    },
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
.v-navigation-drawer__content .v-list-item {
  padding: 0 !important;
}
.v-navigation-drawer__content .v-list-item__content {
  display: flow-root;
}
</style>