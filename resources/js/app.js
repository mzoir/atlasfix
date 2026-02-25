import { createApp } from "vue"
import App from "./components/app.vue"
import router from "./router"
import 'bootstrap/dist/css/bootstrap.min.css'
import 'bootstrap/dist/js/bootstrap.bundle.min.js'

import "./assets/atlasfix.css"



createApp(App).use(router).mount("#app")
