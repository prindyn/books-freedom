<template>
  <v-fade-transition mode="out-in">
    <v-btn icon color="secondary" :to="{ path: path }">
      <v-icon>
        {{ icons.mdiUndoVariant }}
      </v-icon>
    </v-btn>
  </v-fade-transition>
</template>

<script>
import { mdiUndoVariant } from '@mdi/js'

export default {
  props: ['path'],
  setup() {
    return {
      icons: {
        mdiUndoVariant,
      },
    }
  },
}
</script>

<style>
</style>
