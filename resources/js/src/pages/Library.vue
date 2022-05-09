<template>
  <div>
    <div v-swiper:bookSwiper="swiperOption" class='vertical-swiper'>
      <div class="swiper-wrapper vertical-swiper">
        <div class="swiper-slide vertical-swiper" :key="key" v-for="(book, key) in books">
          <v-sheet :id="'book-' + key" color="white" elevation="1" height="100vh" width="100vw">
            {{ 'Book: ' + key }}
          </v-sheet>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { ref } from '@vue/composition-api'
import { mdiBookOpenVariant } from '@mdi/js'

export default {
  setup() {
    const books = [
      {
        id: 1,
        name: 'varta_u_gri',
        title: 'Варта у грі',
        desc: 'Опис книги',
      },
      {
        id: 2,
        name: 'varta_u_gri',
        title: 'Варта у грі',
        desc: 'Опис книги',
      },
    ]
    return {
      books,
      icons: {
        mdiBookOpenVariant,
      },
      swiperOption: {
        class: 'vertical-swiper',
      },
    }
  },
}
</script>

<style lang="scss" scoped>
@import '@resources/sass//preset/mixins.scss';
</style>
