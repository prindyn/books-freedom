<template>
  <div class="ebook">
    <title-bar :ifTitleAndMenuShow="ifTitleAndMenuShow"></title-bar>
    <div class="read-wrapper">
      <div id="read"></div>
      <div class="mask">
        <div class="left" @click="prevPage"></div>
        <div class="center" @click="toggleTitleAndMenu"></div>
        <div class="right" @click="nextPage"></div>
      </div>
    </div>
    <menu-bar
      :ifTitleAndMenuShow="ifTitleAndMenuShow"
      @getCurrentLocation="getCurrentLocation"
      :fontSizeList="fontSizeList"
      :defaultFontSize="defaultFontSize"
      @setFontSize="setFontSize"
      :themeList="themeList"
      :defaultTheme="defaultTheme"
      @setTheme="setTheme"
      :bookAvailable="bookAvailable"
      @onProgressChange="onProgressChange"
      @jumpTo="jumpTo"
      :navigation="navigation"
      :parentProgress="progress"
      ref="menuBar"
    >
    </menu-bar>
  </div>
</template>
<script>
import TitleBar from '@/components/TitleBar'
import MenuBar from '@/components/MenuBar'
import Epub from 'epubjs'
const DOWNLOAD_URL = 'varta_u_gri.epub'
global.epub = Epub

export default {
  components: {
    TitleBar,
    MenuBar,
  },
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
        width: window.innerWidth,
        height: window.innerHeight,
      })
      this.rendition.display()
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
  mounted() {
    this.showEpub()
  },
}
</script>

<style scoped lang='scss'>
</style>