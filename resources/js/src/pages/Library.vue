<template>
  <div>
    <v-row>
      <v-col v-for="book in books" :key="book.id" cols="12" md="6" lg="4">
        <v-card>
          <v-card-title>{{ book.title }}</v-card-title>
          <v-card-text>{{ book.desc }}</v-card-text>
          <v-card-actions class="dense">
            <v-btn icon :to="{ path: 'read', query: { book: book.name } }"
              ><v-icon>
                {{ icons.mdiBookOpenVariant }}
              </v-icon></v-btn
            >
          </v-card-actions>
        </v-card>
      </v-col>
    </v-row>
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
    ]
    return {
      books,
      icons: {
        mdiBookOpenVariant,
      },
    }
  },
}
</script>

<style lang="scss" scoped>
@import '@resources/sass//preset/mixins.scss';

.avatar-center {
  top: -2rem;
  left: 1rem;
  border: 3px solid white;
  position: absolute;
}
</style>
