<template>
  <v-dialog v-model="isDialogVisible" persistent max-width="600px">
    <template #activator="{ on, attrs }">
      <v-btn color="primary" dark v-bind="attrs" v-on="on"> New book </v-btn>
    </template>
    <div v-if="success != ''" class="alert alert-success">
      {{ success }}
    </div>
    <v-card>
      <v-card-title>
        <span class="headline">Book</span>
      </v-card-title>
      <v-card-text>
        <v-container>
          <v-row>
            <v-col cols="12">
              <v-text-field v-model="title" label="Title" outlined dense></v-text-field>
            </v-col>
            <v-col cols="12">
              <v-textarea v-model="desc" label="Description" outlined hide-details></v-textarea>
            </v-col>
            <v-col cols="12" sm="6">
              <v-select
                v-model="lang"
                :hint="`${lang.value}, ${lang.key}`"
                :items="langs"
                item-text="value"
                item-value="key"
                label="Language"
                persistent-hint
                return-object
                single-line
              ></v-select>
            </v-col>
            <v-col cols="12" sm="6"
              ><v-file-input
                show-size
                placeholder="Book cover image"
                accept="image/png, image/jpeg, image/bmp"
                @change="onCoverChange"
              ></v-file-input>
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
      title: '',
      cover: '',
      desc: '',
      success: '',
      lang: {
        key: 'ua',
        value: 'Українська',
      },
      langs: [
        {
          key: 'ua',
          value: 'Українська',
        },
        {
          key: 'en',
          value: 'Англійська',
        },
      ],
      isDialogVisible,
    }
  },
  methods: {
    onCoverChange(file) {
      this.cover = file
    },
    onBookStore() {
      let existingObj = this
      const config = {
        headers: {
          'content-type': 'multipart/form-data',
        },
      }
      let data = new FormData()
      data.append('title', this.title)
      data.append('cover', this.cover)
      data.append('lang', this.lang.key)
      data.append('desc', this.desc)
      this.axios
        .post('/api/books', data, config)
        .then(function ({ data }) {
          console.log(data)
          existingObj.success = data.success
        })
        .catch(function (error) {
          existingObj.output = error
        })
    },
  },
}
</script>