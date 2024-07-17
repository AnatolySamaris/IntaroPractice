import { createApp } from 'vue'
import App from './App.vue'
import { router } from './router'
import './index.css'
import store from './store'
import PrimeVue from 'primevue/config'
import 'primevue/resources/themes/aura-light-green/theme.css'
import ToastService from 'primevue/toastservice'

import Button from 'primevue/button'

const app = createApp(App)

app.use(PrimeVue)
app.use(ToastService)

app.use(router)

app.mount('#app')
app.use(store)

app.component('Button', Button)
