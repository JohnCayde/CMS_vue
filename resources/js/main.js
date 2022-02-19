import Vue from 'vue'
import App from './App.vue'
import store from './store'

new Vue({
    store,
    render: h=>h(App)
}).$mount("#app")

Vue.config.devtools = false
Vue.config.debug = false
Vue.config.silent = true