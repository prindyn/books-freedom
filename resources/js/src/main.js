import Vue from 'vue'
import axios from 'axios'
import App from './App.vue'
import store from './store'
import router from './router'
import { auth } from './utils'
import 'swiper/css/swiper.css'
import VueAxios from 'vue-axios'
import '@/plugins/vue-composition-api'
import vuetify from './plugins/vuetify'
import '@resources/sass/styles/styles.scss'
import FlashMessage from '@smartweb/vue-flash-message';
import VueAwesomeSwiper from 'vue-awesome-swiper'

Vue.use(FlashMessage)
Vue.use(VueAxios, axios)
Vue.prototype.auth = auth;
Vue.config.productionTip = false
Vue.use(VueAwesomeSwiper)

new Vue({
  router,
  store,
  vuetify,
  render: h => h(App),
}).$mount('#app')
