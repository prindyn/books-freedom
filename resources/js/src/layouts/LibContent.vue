<template>
  <v-app>
    <v-main>
      <v-container fluid>
        <slot></slot>
      </v-container>
    </v-main>
  </v-app>
</template>

<script>
export default {}
</script>

<style lang="scss" scoped>
.v-main__wrap {
  .container {
    padding: 0;
  }
}
</style>
