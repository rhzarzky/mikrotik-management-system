import { createApp } from 'vue'
import App from '@/App.vue'
import { registerPlugins } from '@core/utils/plugins'
import HighchartsVue from 'highcharts-vue'

// Styles
import '@core-scss/template/index.scss'
import '@layouts/styles/index.scss'

// Create vue app
const app =   createApp(App).use(HighchartsVue)


// Register plugins
registerPlugins(app)

// Mount vue app
app.mount('#app')
