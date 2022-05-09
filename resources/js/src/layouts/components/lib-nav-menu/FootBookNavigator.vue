<template>
  <div class="text-center">
    <v-bottom-sheet :value="isDrawerOpen" inset hide-overlay persistent no-click-animation>
      <v-card tile>
        <v-list>
          <v-slider
            v-model="curPage"
            min="0"
            :max="pagesTotal"
            @mouseup="() => $emit('navPageUpdate', curPage - 1)"
          ></v-slider>
          <v-list-item>
            <v-list-item-content>
              <v-pagination
                v-model="curPage"
                @input="() => $emit('navPageUpdate', curPage - 1)"
                :length="pagesTotal"
                circle
              ></v-pagination>
            </v-list-item-content>
          </v-list-item>
        </v-list>
      </v-card>
    </v-bottom-sheet>
  </div>
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
    return {
      curPage: 1,
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
.v-card::v-deep {
  .v-input {
    padding: 0 1rem;
    margin-top: -1.2rem;
  }
  .v-input__control {
    height: 2rem !important;
  }
}
.v-dialog__content {
  top: auto !important;
  bottom: 0 !important;
  height: fit-content !important;
}
</style>