<template>
  <transition name="slide-right">
    <div class="content">
      <div class="content-wrapper" v-if="bookAvailable">
        <div class="content-item" v-for="(item, index) in navigation.toc" :key="index" @click="jumpTo(item.href)">
          <span class="text">{{ item.label }}</span>
        </div>
      </div>
      <div class="empty" v-else>Some text</div>
    </div>
  </transition>
</template>
<script>
export default {
  props: {
    ifShowContent: Boolean,
    navigation: Object,
    bookAvailable: Boolean,
  },
  methods: {
    jumpTo(target) {
      this.$emit('jumpTo', target)
    },
  },
}
</script>

<style scoped lang='scss'>

</style>