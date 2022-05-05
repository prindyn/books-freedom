<template>
  <div>
    <swipe-list
      class="card"
      :items="mockSwipeList"
      transition-key="id"
      @swipeout:contentclick="contentClick"
      @swipeout:click="itemClick"
      @swipeout:doubleclick="itemDblClick"
    >
      <template slot-scope="{ index }">
        <div class="card-content">
          <span>{{ index }}</span>
        </div>
      </template>
      <template slot="left" slot-scope="{}"> </template>
      <template slot="right" slot-scope="{}"> </template>
    </swipe-list>
  </div>
</template>
<script>
import { SwipeList, SwipeOut } from 'vue-swipe-actions'
export default {
  components: {
    SwipeOut,
    SwipeList,
  },
  data() {
    return {
      enabled: true,
      mockSwipeList: [{}],
    }
  },
  methods: {
    revealFirstRight() {
      this.$refs.list.revealRight(0)
    },
    revealFirstLeft() {
      this.$refs.list.revealLeft(0)
    },
    closeFirst() {
      this.$refs.list.closeActions(0)
    },
    closeAll() {
      this.$refs.list.closeActions()
    },
    remove(item) {
      this.mockSwipeList = this.mockSwipeList.filter(i => i !== item)
      // console.log(e, 'remove');
    },
    itemClick(e) {
      console.log(e, 'item click')
    },
    fbClick(e) {
      console.log(e, 'First Button Click')
    },
    sbClick(e) {
      console.log(e, 'Second Button Click')
    },
    contentClick(e) {
      console.log(e, 'content click')
    },
    itemClick(e) {
      console.log(e, 'item click')
    },
    itemDblClick(e) {
      console.log(e, 'item double click')
    },
    fbClick(e) {
      console.log(e, 'First Button Click')
    },
    sbClick(e) {
      console.log(e, 'Second Button Click')
    },
  },
}
</script>
<style lang="scss">
@import 'vue-swipe-actions/dist/vue-swipe-actions.css';
</style>