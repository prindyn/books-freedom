<template>
  <div>
    <v-row class="space-around pt-5">
      <v-col cols="12" class="text-center" color="black">
        <v-text-field
          filled
          rounded
          solo
          dense
          full-width
          height="3rem"
          v-model="search"
          label="Search book..."
          :append-icon="icons.mdiMagnify"
          @click:append="onSearch"
          @keyup="onSearch"
        ></v-text-field>
      </v-col>
    </v-row>
    <v-row class="space-around">
      <v-scale-transition leave-absolute :key="key" v-for="(book, key) in books">
        <v-col class="py-2" cols="12" sm="6" md="4">
          <v-sheet rounded="xl" color="white" elevation="5" class="d-flex mx-3">
            <v-img
              height="inherit"
              max-width="5rem"
              content-class="col-3"
              transition="scale-transition"
              :lazy-src="asset('images/no-image.png')"
              :src="book.cover"
            ></v-img>
            <div class="col-6 pr-0">
              <v-list-item class="px-0">
                <v-list-item-content class="py-0">
                  <v-list-item-title class="text-xs font-weight-medium text--primary mb-0"
                    >{{ book.title }}
                  </v-list-item-title>
                  <v-list-item-subtitle
                    ><span class="text-xs">{{ book.author }}</span></v-list-item-subtitle
                  >
                  <v-list-item-action class="px-0 mx-0 mt-5 mb-auto">
                    <v-btn
                      :to="{ name: 'read', params: { book: book.source } }"
                      icon
                      height="max-content !important"
                      color="pink"
                      class="mt-auto"
                    >
                      <v-icon>{{ icons.mdiEyeOutline }}</v-icon>
                    </v-btn>
                  </v-list-item-action>
                </v-list-item-content>
              </v-list-item>
            </div>
            <div class="col-3 text-center d-flex align-center">
              <v-progress-circular :rotate="360" :size="50" :width="5" :value="book.last_page">
                {{ book.last_page + '%' }}
              </v-progress-circular>
            </div>
          </v-sheet>
        </v-col>
      </v-scale-transition>
    </v-row>
  </div>
</template>

<script>
import { ref } from '@vue/composition-api'
import { mdiMagnify, mdiEyeOutline, mdiBookOpenVariant } from '@mdi/js'

export default {
  data() {
    return {
      books: [],
      search: '',
      icons: {
        mdiMagnify,
        mdiEyeOutline,
        mdiBookOpenVariant,
      },
      swiperOption: {
        direction: 'vertical',
        slidesPerView: this.slidesPerView(),
      },
    }
  },
  mounted() {
    this.loadBooks()
  },
  methods: {
    onSearch() {
      this.loadBooks(this.search)
    },
    loadBooks(search = '') {
      search = search ? '?search=' + search : ''
      axios.get('/api/books' + search).then(({ data }) => {
        this.books = data.books
      })
    },
    slidesPerView() {
      return Math.floor(window.innerHeight / 100)
    },
  },
}
</script>

<style lang="scss" scoped>
@import '@resources/sass//preset/mixins.scss';
.v-sheet {
  height: 100px;
}

.row {
  margin: 0 !important;
}

.v-sheet > :first-child:not(.v-btn):not(.v-chip):not(.v-avatar) {
  border-radius: inherit;
}

.v-sheet > :nth-child(3) {
  color: var(--v-warning-base) !important;
}

.row.space-around:first-child {
  height: 10rem;
  background-color: $primary-shade--medium;
}

.row.space-around:nth-child(2) {
  min-height: 5rem;
  margin-top: -3rem !important;
  padding-top: 2rem !important;
  border-top-left-radius: 3rem !important;
  border-top-right-radius: 3rem !important;
  background-color: #f4f5fa !important;
}
</style>
