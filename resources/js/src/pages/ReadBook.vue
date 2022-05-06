<template>
  <div>
    <top-book-navigator :is-drawer-open.sync="ifTopMenuShow"></top-book-navigator>
    <div v-swiper:bookSwiper="swiperOption" @tap="onSwiperTap" @slideChange="onSwipeChange">
      <div class="swiper-wrapper">
        <div class="swiper-slide" :key="key" v-for="(page, key) in pages">
          <v-sheet :id="'page-' + key" color="white" elevation="1" height="100vh" width="100vw"></v-sheet>
        </div>
      </div>
    </div>
    <foot-book-navigator :is-drawer-open.sync="ifTitleAndMenuShow"></foot-book-navigator>
  </div>
</template>

<script>
import Book from 'epubjs'
import { ref } from '@vue/composition-api'
import Rendition from 'epubjs/src/rendition'
import VerticalNavMenu from '../layouts/components/vertical-nav-menu/VerticalNavMenu.vue'
import TopBookNavigator from '../layouts/components/lib-nav-menu/TopBookNavigator.vue'
import FootBookNavigator from '../layouts/components/lib-nav-menu/FootBookNavigator.vue'

export default {
  props: {
    lastPage: {
      type: Number,
      default: 0,
    },
  },
  components: {
    TopBookNavigator,
    FootBookNavigator,
    VerticalNavMenu,
  },
  setup() {
    const ifTopMenuShow = ref(null)
    const ifTitleAndMenuShow = ref(null)
    return {
      book: null,
      pages: null,
      bookName: null,
      currentPage: 0,
      rendition: null,
      locations: null,
      navigation: null,
      isBookAvailable: false,
      ifTopMenuShow,
      ifTitleAndMenuShow,
      pagesOverActive: 2,
      pagesHistory: {},
      swiperOption: {
        pagination: {
          // el: '.swiper-pagination',
          // clickable: true,
        },
      },
    }
  },
  mounted() {
    this.book = new Book()
    this.bookName = 'varta_u_gri.epub'
    this.openBook()
  },
  methods: {
    onSwiperTap() {
      if (!this.ifTitleAndMenuShow && !this.ifTopMenuShow) {
        setTimeout(() => {
          this.ifTopMenuShow = !this.ifTopMenuShow
          this.ifTitleAndMenuShow = !this.ifTitleAndMenuShow
        }, 100)
      }
    },
    onSwipeChange() {
      this.jumpTo(this.bookSwiper.activeIndex)
    },
    charsPerPage() {
      const fontSize = 16
      const fontConst = 2
      const lineHeight = 1.5
      const lineChars = Math.floor((window.innerWidth * fontConst) / fontSize)
      const pageLines = Math.floor(window.innerHeight / fontSize / lineHeight)
      return pageLines * lineChars
    },
    pageHistory(page, selector = '') {
      if (this.pagesHistory[page]) {
        return this.pagesHistory[page]
      } else if (selector != '') {
        const element = document.querySelector(selector)
        if (element) {
          this.pagesHistory[page] = element.innerHTML
          return element.innerHTML
        }
      }
    },
    updatePagesHistory(pages) {
      let resolved = []
      return new Promise(resolve => {
        if (pages.length == 0) return resolve()
        pages.forEach(page => {
          if (!this.pageHistory(page)) {
            this.rendition.attachTo('page-' + page)
            this.rendition.display(this.pages[page]).then(section => {
              this.pageHistory(page, '#page-' + page)
              resolved.push(page)
            })
          } else {
            resolved.push(page)
          }
          if (pages.length - resolved.length <= 1) return resolve()
        })
      })
    },
    async jumpTo(page) {
      const startActive = Math.max(0, page - this.pagesOverActive)
      const endActive = Math.min(this.pages.length, page + this.pagesOverActive + 1)
      let activePages = [...Array(endActive).keys()].slice(startActive, endActive)
      this.updatePagesHistory(activePages).then(() => {
        activePages.forEach(page => {
          const slide = document.querySelector('#page-' + page)
          if (slide && slide.innerHTML == '' && this.pageHistory(page)) {
            slide.innerHTML = this.pageHistory(page)
          }
        })
      })
    },
    openBook() {
      this.currentPage = this.lastPage
      this.book.open(this.bookName, 'epub')
      this.rendition = new Rendition(this.book, {
        flow: 'paginated',
        height: '100%',
        width: '100%',
      })
      this.book.ready
        .then(() => {
          this.navigation = this.book.navigation
          return this.book.locations.generate(this.charsPerPage())
        })
        .then(book => {
          this.locations = this.book.locations
          this.pages = this.locations._locations.slice(1)
          this.pagesTotal = this.locations.total
          this.jumpTo(this.currentPage)
          this.isBookAvailable = true
        })
    },
  },
}
</script>

<style lang="scss" scoped>
@import '~@resources/sass/preset/pages/library.scss';
</style>
