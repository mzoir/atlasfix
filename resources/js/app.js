import { createApp } from "vue"
import App from "./components/app.vue"
import router from "./router"
import '@fortawesome/fontawesome-free/css/all.min.css';
import 'bootstrap/dist/css/bootstrap.min.css'
import 'bootstrap/dist/js/bootstrap.bundle.min.js'

import "./assets/atlasfix.css"

import './assets/policy.css'   // ← add this line
import './assets/main.css'     // your existing global css



createApp(App).use(router).mount("#app")
