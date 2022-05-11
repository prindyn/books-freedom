<template>
  <div>
    <div v-if="books" v-swiper:bookSwiper="swiperOption" class="vertical-swiper">
      <div class="swiper-wrapper vertical-swiper">
        <div class="swiper-slide vertical-swiper" :key="key" v-for="(book, key) in books">
          <v-sheet :id="'book-' + key" color="white" elevation="1" height="100vh" width="100vw">
            {{ 'Book: ' + key }}
            <img :src="book.cover" alt="">
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
  data() {
    return {
      books: [],
      icons: {
        mdiBookOpenVariant,
      },
      swiperOption: {
        class: 'vertical-swiper',
      },
    }
  },
  mounted() {
    this.loadBooks()
  },
  methods: {
    loadBooks() {
      axios.get('/api/books').then(({ data }) => {
        this.books = data.books
      })
    },
  },
}
</script>

<style lang="scss" scoped>
@import '@resources/sass//preset/mixins.scss';
</style>
