<template>
  <div class="library-wrapper library-v1">
    <div class="library-inner">
      <a id="prev" href="#prev" @click="prevPage" class="navlink"></a>

      <v-card class="library-card">
        <v-card-text>
          <div id="read" class="scrolled"></div>
        </v-card-text>
      </v-card>
      <a id="next" href="#next" @click="nextPage" class="navlink"></a>
    </div>
  </div>
</template>

<script>
import { mdiFacebook, mdiTwitter, mdiGithub, mdiGoogle, mdiEyeOutline, mdiEyeOffOutline } from '@mdi/js'
import { ref } from '@vue/composition-api'
import Epub from 'epubjs'
const DOWNLOAD_URL = 'stratieghiyi_i_taktiki_spilkuva.epub'
global.epub = Epub

export default {
  data() {
    return {
      ifTitleAndMenuShow: false,
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
      defaultFontSize: 16,
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
      defaultTheme: 0,
      bookAvailable: false,
      navigation: null,
      progress: 0,
    }
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
      this.hideTitleAndMenu()
    },
    hideTitleAndMenu() {
      this.ifTitleAndMenuShow = false
      this.$refs.menuBar.hideSetting()
      this.$refs.menuBar.hideContent()
    },
    onProgressChange(progress) {
      const percentage = progress / 100
      const location = percentage > 0 ? this.locations.cfiFromPercentage(percentage) : 0
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
      if (!this.ifTitleAndMenuShow) {
        this.$refs.menuBar.hideSetting()
      }
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
        flow: 'scrolled-doc',
        width: '100%',
      })
      
      this.rendition.display()
      this.rendition.on('relocated', function (location) {
        console.log(location)
      })
      this.rendition.on('rendered', function (section) {
        var prevNav, nextNav, prevLabel, nextLabel
        var nextSection = section.next()
        var prevSection = section.prev()

        if (nextSection) {
          nextNav = this.book.navigation.get(nextSection.href)

          if (nextNav) {
            nextLabel = nextNav.label
          } else {
            nextLabel = 'next'
          }

          next.textContent = nextLabel + ' »'
        } else {
          next.textContent = ''
        }

        if (prevSection) {
          prevNav = this.book.navigation.get(prevSection.href)

          if (prevNav) {
            prevLabel = prevNav.label
          } else {
            prevLabel = 'previous'
          }

          prev.textContent = '« ' + prevLabel
        } else {
          prev.textContent = ''
        }
      })

      this.themes = this.rendition.themes
      this.setFontSize(this.defaultFontSize)
      this.registerTheme()
      this.setTheme(this.defaultTheme)
      this.book.ready
        .then(() => {
          this.navigation = this.book.navigation

          return this.book.locations.generate()
        })
        .then(result => {
          this.locations = this.book.locations
          this.bookAvailable = true
        })
    },
  },
}
</script>

<style lang="scss">
@import '~@resources/sass/preset/pages/library.scss';
</style>
