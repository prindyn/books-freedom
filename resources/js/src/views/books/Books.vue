<template>
  <v-dialog v-model="isDialogVisible" persistent max-width="600px">
    <template #activator="{ on, attrs }">
      <v-btn color="primary" dark v-bind="attrs" v-on="on"> New book </v-btn>
    </template>
    <v-card>
      <v-card-title>
        <span class="headline">Book</span>
      </v-card-title>
      <v-card-text>
        <v-container>
          <v-row>
            <v-col cols="12">
              <v-text-field ref="title" v-model="book.title" label="Title" outlined dense></v-text-field>
            </v-col>
            <v-col cols="12">
              <v-textarea ref="desc" v-model="book.desc" label="Description" outlined hide-details></v-textarea>
            </v-col>
            <v-col cols="12" sm="6"
              ><v-file-input
                show-size
                placeholder="Cover image"
                accept="image/png, image/jpeg, image/bmp"
                @change="onCoverChange"
              ></v-file-input>
            </v-col>
            <v-col cols="12" sm="6"
              ><v-file-input
                show-size
                placeholder="Source file"
                accept="*/epub"
                @change="onSourceChange"
              ></v-file-input>
            </v-col>
            <v-col cols="12">
              <v-combobox
                ref="author"
                v-model="book.author"
                clearable
                hide-selected
                multiple
                label="Authors"
                small-chips
                solo
              >
              </v-combobox>
            </v-col>
            <v-col cols="12" sm="6">
              <v-select
                ref="lang"
                v-model="book.lang"
                :hint="`${book.lang.value}, ${book.lang.key}`"
                :items="langs"
                item-text="value"
                item-value="key"
                label="Language"
                persistent-hint
                return-object
                single-line
              ></v-select>
            </v-col>
          </v-row>
        </v-container>
      </v-card-text>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn color="error" outlined @click="isDialogVisible = false"> Close </v-btn>
        <v-btn color="success" @click="onBookStore"> Save </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script>
import { ref } from '@vue/composition-api'

export default {
  setup() {
    const isDialogVisible = ref(false)

    return {
      book: {
        title: null,
        desc: null,
        cover: null,
        source: null,
        author: [],
        lang: { key: 'ua', value: 'Українська' },
      },
      langs: [
        { key: 'ua', value: 'Українська' },
        { key: 'en', value: 'Англійська' },
      ],
      errors: null,
      success: null,
      isDialogVisible,
    }
  },
  methods: {
    removeAuthor(item) {
      this.book.author.splice(this.book.author.indexOf(item), 1)
      this.book.author = [...this.book.author]
    },
    onCoverChange(file) {
      this.book.cover = file
    },
    onSourceChange(file) {
      this.book.source = file
    },
    onBookStore() {
      const config = {
        headers: {
          'content-type': 'multipart/form-data',
        },
      }
      let obj = this.bookFormData()
      this.axios
        .post('/api/books', obj.form, config)
        .then(function ({ data }) {
          obj.flashMessage.success({ message: data.message })
        })
        .catch(function ({ response }) {
          obj.errors = response.data.errors
          obj.flashMessage.error({ message: Object.entries(obj.errors)[0][1][0] })
        })
    },
    bookFormData() {
      let obj = this
      obj.form = new FormData()
      for (const [key, val] of Object.entries(obj.book)) {
        if (obj.book[key] instanceof Array) {
          obj.form.append(key, obj.book[key])
        } else if (obj.book[key] instanceof Object) {
          obj.form.append(key, obj.book[key].key)
        } else if (obj.book[key]) {
          obj.form.append(key, obj.book[key])
        }
      }
      if (obj.book.cover) {
        obj.form.append('cover', obj.book.cover)
      }
      if (obj.book.source) {
        obj.form.append('source', obj.book.source)
      }
      return obj
    },
  },
}
</script>