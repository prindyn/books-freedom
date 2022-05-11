<template>
  <v-fade-transition mode="out-in">
    <v-btn icon color="secondary" @click="hasHistory() ? $router.go(-1) : $router.push(path)">
      <v-icon>
        {{ icons.mdiUndoVariant }}
      </v-icon>
    </v-btn>
  </v-fade-transition>
</template>

<script>
import { mdiUndoVariant } from '@mdi/js'

export default {
  props: {
    path: {
      type: String,
      default: '/',
    },
  },
  data() {
    return {
      icons: {
        mdiUndoVariant,
      },
    }
  },
  methods: {
    hasHistory() {
      console.log(window.history);
      return true;
      return window.history.length > 2 && !this.path
    },
  },
}
</script>

<style>
</style>
