<template>
  <v-app>
    <v-app-bar app static flat absolute color="transparent">
      <div class="boxed-container w-full">
        <div class="d-flex align-center mx-6">
          <v-text-field
            rounded
            dense
            outlined
            :prepend-inner-icon="icons.mdiMagnify"
            class="app-bar-search flex-grow-0"
            hide-details
          ></v-text-field>

          <v-spacer></v-spacer>

          <theme-switcher></theme-switcher>
        </div>
      </div>
    </v-app-bar>

    <v-main>
      <div class="app-content-container boxed-container pa-6">
        <slot></slot>
      </div>
    </v-main>

    <v-footer app inset color="transparent" absolute height="56" class="px-0">
      <div class="boxed-container w-full">
        <div class="mx-6 d-flex justify-space-between"></div>
      </div>
    </v-footer>
    <FlashMessage></FlashMessage>
  </v-app>
</template>

<script>
import { ref } from '@vue/composition-api'
import { mdiMagnify, mdiGithub } from '@mdi/js'
import ThemeSwitcher from './components/ThemeSwitcher.vue'
import VerticalBookMenu from './components/vertical-nav-menu/VerticalBookMenu.vue'

export default {
  components: {
    VerticalBookMenu,
    ThemeSwitcher,
  },
  setup() {
    const isDrawerOpen = ref(null)

    return {
      isDrawerOpen,
      icons: {
        mdiMagnify,
        mdiGithub,
      },
    }
  },
}
</script>

<style lang="scss" scoped>
.v-app-bar ::v-deep {
  .v-toolbar__content {
    padding: 0;

    .app-bar-search {
      .v-input__slot {
        padding-left: 18px;
      }
    }
  }
}

.boxed-container {
  max-width: 1440px;
  margin-left: auto;
  margin-right: auto;
}

.app-bar-search {
  max-width: 70vw;
}
</style>
