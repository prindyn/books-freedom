<template>
  <div class="lib-container">
    <div class="row">
      <div class="col col-10 book">
        <v-card class="book-card">
          <v-card-text>
            <div @click="toggleTitleAndMenu"  id="read"></div>
          </v-card-text>
          <div v-show="ifTitleAndMenuShow" class="bookPanelBottom">
            <v-slider
              :value="progress"
              step="0.01"
              hide-details
              :disabled="loader"
              class="bookProgress"
              @change="onProgressChange"
            ></v-slider>
            <v-pagination v-model="currentPage" :disabled="loader" :length="pagesLength" class="bookNav"></v-pagination>
          </div>
        </v-card>
      </div>
    </div>
    <v-dialog v-model="loader" hide-overlay persistent class="bookLoader">
      <v-card color="primary" dark>
        <v-card-text class="pt-3">
          Please wait...
          <v-progress-linear indeterminate color="white" class="mb-0"></v-progress-linear>
        </v-card-text>
      </v-card>
    </v-dialog>
    <div @click="toggleTitleAndMenu" class="menuLayour"></div>
  </div>
</template>

<script>
import { mdiChevronLeft, mdiChevronRight } from '@mdi/js'
import { ref } from '@vue/composition-api'
import Epub from 'epubjs'
const DOWNLOAD_URL = 'varta_u_gri.epub'
global.epub = Epub

export default {
  props: {
    lastPage: {
      type: Number,
      default: 1,
    },
  },
  data() {
    return {
      icons: {
        mdiChevronLeft,
        mdiChevronRight,
      },
      fontSizeList: [
        {
          fontSize: 12,
        },
        {
          fontSize: 14,
        },
        {
          fontSize: 16,
        },
        {
          fontSize: 18,
        },
        {
          fontSize: 20,
        },
        {
          fontSize: 22,
        },
        {
          fontSize: 24,
        },
      ],
      themeList: [
        {
          name: 'default',
          style: {
            body: {
              color: '#000',
              background: '#fff',
            },
          },
        },
        {
          name: 'eye',
          style: {
            body: {
              color: '#000',
              background: '#ceeaba',
            },
          },
        },
        {
          name: 'night',
          style: {
            body: {
              color: '#fff',
              background: '#000',
            },
          },
        },
        {
          name: 'gold',
          style: {
            body: {
              color: '#000',
              background: 'rgb(238, 232, 170)',
            },
          },
        },
      ],
      book: null,
      progress: 0,
      loader: true,
      navigation: null,
      pagesLength: 0,
      currentPage: 0,
      prevSection: null,
      nextSection: null,
      defaultTheme: 0,
      bookAvailable: false,
      defaultFontSize: 16,
      ifTitleAndMenuShow: false,
    }
  },
  watch: {
    bookAvailable() {
      this.loader = !this.bookAvailable
    },
    currentPage() {
      this.onPaginationChange(this.currentPage)
    },
  },
  mounted() {
    this.showEpub()
  },
  methods: {
    getCurrentLocation() {
      if (this.rendition) {
        this.showProgress()
      }
    },
    showProgress() {
      const currentLoction = this.rendition.currentLocation()
      this.progress = this.bookAvailable ? this.locations.percentageFromCfi(currentLoction.start.cfi) : 0
      this.progress = Math.round(this.progress * 100)
    },
    jumpTo(href) {
      this.rendition.display(href).then(() => {
        this.showProgress()
      })
      // this.hideTitleAndMenu()
    },
    hideTitleAndMenu() {
      this.ifTitleAndMenuShow = false
      this.$refs.menuBar.hideSetting()
      this.$refs.menuBar.hideContent()
    },
    onPaginationChange(page) {
      const percentage = (page * 1) / this.pagesLength
      const location = percentage > 0 ? this.locations.cfiFromPercentage(percentage) : 0
      this.jumpTo(location)
    },
    onProgressChange(progress) {
      const percentage = progress / 100
      const location = percentage > 0 ? this.locations.cfiFromPercentage(percentage) : 0
      this.currentPage = this.locations.locationFromCfi(location)
      this.rendition.display(location)
    },
    setTheme(index) {
      this.themes.select(this.themeList[index].name)
      this.defaultTheme = index
    },
    registerTheme() {
      this.themeList.forEach(theme => {
        this.themes.register(theme.name, theme.style)
      })
    },
    setFontSize(fontSize) {
      this.defaultFontSize = fontSize
      if (this.themes) {
        this.themes.fontSize(fontSize + 'px')
      }
    },
    toggleTitleAndMenu() {
      this.ifTitleAndMenuShow = !this.ifTitleAndMenuShow
      // this.ifTitleAndMenuShow = !this.ifTitleAndMenuShow
      // if (!this.ifTitleAndMenuShow) {
      //   this.$refs.menuBar.hideSetting()
      // }
    },
    prevPage() {
      if (this.rendition) {
        this.rendition.prev().then(() => {
          this.showProgress()
        })
      }
    },
    nextPage() {
      if (this.rendition) {
        this.rendition.next().then(() => {
          this.showProgress()
        })
      }
    },
    showEpub() {
      this.book = new Epub(DOWNLOAD_URL)
      this.rendition = this.book.renderTo('read', {
        flow: 'paginated',
        width: '100%',
      })

      this.rendition.display()
      this.rendition.on('relocated', function (location) {
        // console.log(location)
      })
      this.rendition.on('rendered', function (section) {
        var prevNav, nextNav, prevLabel, nextLabel
        this.nextSection = section.next()
        this.prevSection = section.prev()

        if (this.nextSection) {
          nextNav = this.book.navigation.get(this.nextSection.href)

          if (nextNav) {
            nextLabel = nextNav.label
          }
        }

        if (this.prevSection) {
          prevNav = this.book.navigation.get(this.prevSection.href)

          if (prevNav) {
            prevLabel = prevNav.label
          }
        }
      })

      this.themes = this.rendition.themes
      this.setFontSize(this.defaultFontSize)
      this.registerTheme()
      this.setTheme(this.defaultTheme)
      this.book.ready
        .then(() => {
          this.navigation = this.book.navigation
          return this.book.locations.generate(1500)
        })
        .then(book => {
          this.locations = this.book.locations
          this.pagesLength = this.locations.total
          this.currentPage = this.lastPage
          this.bookAvailable = true
        })
    },
  },
}
</script>

<style lang="scss" scoped>
@import '~@resources/sass/preset/pages/library.scss';
.v-dialog__content--active {
  height: 90vh !important;
  background-color: #ffffff;
}
</style>
