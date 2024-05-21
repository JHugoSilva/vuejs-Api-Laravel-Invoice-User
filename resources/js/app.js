import './bootstrap';
// import { createApp } from 'vue/dist/vue.esm-bundler.js'
import Swal from 'sweetalert2/dist/sweetalert2.js'
import 'sweetalert2/dist/sweetalert2.css'

window.Swal = Swal

const toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timeProgressBar: true
})

window.toast = toast


import { createApp } from 'vue'

import App from './components/App.vue'
import router from './router/';

const app = createApp(App)
app.use(router)
app.mount('#app')
