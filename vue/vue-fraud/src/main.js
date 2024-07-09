import { createApp } from 'vue'
import { createPinia } from 'pinia'
const app = createApp(App)
import '@/store/navbar.js'
const pinia = createPinia()
app.use(pinia)

import App from './App.vue'
import router from './routes'
import 'bootstrap/dist/css/bootstrap.min.css'
import 'bootstrap'
createApp(App).use(router).mount('#app')