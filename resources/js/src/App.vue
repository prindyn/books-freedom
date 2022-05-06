<template>
  <component :is="resolveLayout">
    <router-view></router-view>
  </component>
</template>

<script>
import { computed } from '@vue/composition-api'
import { useRouter } from '@/utils'
import LayoutBlank from '@/layouts/Blank.vue'
import LayoutContent from '@/layouts/Content.vue'
import LayoutLibContent from '@/layouts/LibContent.vue'
import UpgradeToPro from './components/UpgradeToPro.vue'

export default {
  components: {
    LayoutBlank,
    LayoutContent,
    LayoutLibContent,
    UpgradeToPro,
  },
  setup() {
    const { route } = useRouter()

    const resolveLayout = computed(() => {
      // Handles initial route
      if (route.value.name === null) return null

      if (route.value.meta.layout === 'blank') return 'layout-blank'
      if (route.value.meta.layout === 'lib-content') return 'layout-lib-content'

      return 'layout-content'
    })

    return {
      resolveLayout,
    }
  },
}
</script>
