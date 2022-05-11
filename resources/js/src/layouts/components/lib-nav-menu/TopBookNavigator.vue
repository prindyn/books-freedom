<template>
  <div class="text-center">
    <v-bottom-sheet
      content-class="sheet-pos-top"
      :value="isDrawerOpen"
      inset
      hide-overlay
      persistent
      no-click-animation
    >
      <v-toolbar>
        <v-toolbar-title>
          <history-back-btn></history-back-btn>
          Title
        </v-toolbar-title>
      </v-toolbar>
    </v-bottom-sheet>
  </div>
</template>
<script>
import HistoryBackBtn from '../HistoryBackBtn.vue'
export default {
  props: {
    isDrawerOpen: {
      type: Boolean,
      default: null,
    },
  },
  components: {
    HistoryBackBtn,
  },
  data() {
    return {}
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
  top: 0 !important;
  bottom: auto !important;
  height: fit-content !important;
}
</style>