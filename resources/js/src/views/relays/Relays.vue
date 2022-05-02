<template>
  <v-card>
    <v-card-title> Search & Filter </v-card-title>
    <v-row class="px-2 ma-0">
      <v-col cols="12" sm="4">
        <v-select label="Outlined style" dense outlined></v-select>
      </v-col>
      <br class="clear" />
    </v-row>
    <hr role="separator" aria-orientation="horizontal" class="mt-4 v-divider theme--light" />
    <v-card-text class="d-flex align-center flex-wrap pb-0">
      <v-text-field class="relay-search me-3 mb-0" label="Outlined" outlined dense></v-text-field>
      <v-spacer></v-spacer>
      <relay-form-modal></relay-form-modal>
      
      <div class="d-flex align-center flex-wrap"></div>
    </v-card-text>
    <v-data-table :headers="headers" :items="userList" :items-per-page="10" fixed-header height="300">
      <!-- name -->
      <template #[`item.full_name`]="{ item }">
        <div class="d-flex align-center">
          <v-avatar
            :color="item.avatar ? '' : 'primary'"
            :class="item.avatar ? '' : 'v-avatar-light-bg primary--text'"
            size="32"
          >
            <v-img v-if="item.avatar" :src="`/images/avatars/${item.avatar}`"></v-img>
            <span v-else>{{ item.full_name.slice(0, 2).toUpperCase() }}</span>
          </v-avatar>
          <div class="d-flex flex-column ms-3">
            <span class="d-block font-weight-semibold text--primary text-truncate">{{ item.full_name }}</span>
            <small>{{ item.post }}</small>
          </div>
        </div>
      </template>

      <!-- salary -->
      <template #[`item.salary`]="{ item }">
        {{ `$${item.salary}` }}
      </template>

      <!-- status -->
      <template #[`item.status`]="{ item }">
        <v-chip
          small
          :color="statusColor[status[item.status]]"
          :class="`${statusColor[status[item.status]]}--text`"
          class="v-chip-light-bg"
        >
          {{ status[item.status] }}
        </v-chip>
      </template>
    </v-data-table>
  </v-card>
</template>

<script>
import { mdiSquareEditOutline, mdiDotsVertical } from '@mdi/js'
import data from './datatable-data'
import RelayFormModal from './RelayFormModal.vue'

export default {
  components: {
    RelayFormModal,
  },
  setup() {
    const statusColor = {
      /* eslint-disable key-spacing */
      Current: 'primary',
      Professional: 'success',
      Rejected: 'error',
      Resigned: 'warning',
      Applied: 'info',
      /* eslint-enable key-spacing */
    }

    return {
      addRelayModal: false,
      headers: [
        { text: 'NAME', value: 'full_name' },
        { text: 'EMAIL', value: 'email' },
        { text: 'DATE', value: 'start_date' },
        { text: 'SALARY', value: 'salary' },
        { text: 'AGE', value: 'age' },
        { text: 'STATUS', value: 'status' },
      ],
      userList: data,
      status: {
        1: 'Current',
        2: 'Professional',
        3: 'Rejected',
        4: 'Resigned',
        5: 'Applied',
      },
      statusColor,

      // icons
      icons: {
        mdiSquareEditOutline,
        mdiDotsVertical,
      },
    }
  },
}
</script>
<style lang="css">
.relay-search {
  max-height: 55px;
  max-width: 200px;
}
</style>
        