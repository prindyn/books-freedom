<template>
  <div>
    <top-book-navigator :is-drawer-open.sync="ifTitleAndMenuShow"></top-book-navigator>
    <div v-swiper:bookSwiper="swiperOption" @tap="onSwiperTap" @slideChange="onSwipeChange">
      <div class="swiper-wrapper">
        <div class="swiper-slide" :key="key" v-for="(page, key) in pages">
          <v-sheet :id="'page-' + key" color="white" elevation="1" height="100vh" width="100vw"></v-sheet>
        </div>
      </div>
    </div>
    <foot-book-navigator
      :pages-total="pagesTotal"
      :cur-nav-page="currentPage"
      @navPageUpdate="onCurNavPageUpdate"
      :is-drawer-open.sync="ifTitleAndMenuShow"
    ></foot-book-navigator>
    <v-overlay color="transparent" :value="loader">
      <v-progress-circular color="var(--v-anchor-base)" indeterminate size="64"></v-progress-circular>
    </v-overlay>
    <v-overlay color="transparent" :value="!loader && !pagesTotal">
      <div class="text-center">
        <v-btn icon @click="readBook()">
          <v-icon color="var(--v-anchor-base)" x-large>{{ icons.mdiRefresh }}</v-icon>
        </v-btn>
      </div>
      <div class="text-center" style="color: var(--v-info-base)">Please, try again</div>
    </v-overlay>
  </div>
</template>

<script>
import Book from 'epubjs'
import { mdiRefresh } from '@mdi/js'
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
    return {
      book: null,
      pages: null,
      loader: false,
      bookName: null,
      pagesTotal: 0,
      currentPage: 0,
      rendition: null,
      locations: null,
      navigation: null,
      overActivePages: 1,
      isBookAvailable: false,
      ifTitleAndMenuShow: false,
      pagesHistory: {},
      swiperOption: {
        pagination: {
          // el: '.swiper-pagination',
          // clickable: true,
        },
      },
      icons: {
        mdiRefresh,
      },
    }
  },
  mounted() {
    this.readBook('d19dab72d332700e827463b877f2504c.epub')
  },
  watch: {
    isBookAvailable() {
      this.loader = !this.isBookAvailable
    },
  },
  methods: {
    onSwiperTap() {
      setTimeout(() => {
        this.ifTitleAndMenuShow = !this.ifTitleAndMenuShow
      }, 100)
    },
    onSwipeChange() {
      this.jumpTo(this.bookSwiper.activeIndex)
    },
    onCurNavPageUpdate(page) {
      this.bookSwiper.slideTo(page)
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
      this.currentPage = this.bookSwiper.activeIndex
      const startActive = Math.max(0, page - this.overActivePages)
      const endActive = Math.min(this.pages.length, page + this.overActivePages + 1)
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
    readBook(book = '') {
      this.loader = true
      this.book = new Book()
      this.bookName = book ? book : this.bookName
      this.requestBook(this.bookName).then(requested => {
        setTimeout(() => this.openBook(requested), 1000)
      })
    },
    requestBook(book) {
      return new Promise(resolve => {
        this.axios
          .get('api/books/request/' + book)
          .then(({ data }) => {
            return resolve(data.book ? data.book : '')
          })
          .catch(error => {
            return resolve('')
          })
      })
    },
    openBook(book) {
      if (!book) {
        return (this.loader = false)
      }
      this.currentPage = this.lastPage
      this.book.open('api/books/download/' + book, 'epub')
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
