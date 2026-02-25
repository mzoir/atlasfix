import { createRouter, createWebHistory } from "vue-router"
import MainLayout from "../components/layouts.vue"
import AuthCallback from "../components/view.vue"

// ✅ keep ONE import فقط (and correct name)
import Regsiter from "../components/register/ArtisanRegister.vue"
import ProfilePage from "../components/ProfilePage.vue"

const Home = () => import("../components/pages/home.vue")
const About = () => import("../components/about.vue")
const Services = () => import("../components/service.vue")
const Contact = () => import("../components/contact.vue")
const FAQ = () => import("../components/about.vue")
const Login = () => import("../components/Login.vue")
const Sign = () => import("../components/choose.vue")

// ✅ FIX: must be a function, not "import(...)"
const CreateAccount = () => import("../components/createaccount.vue")

export default createRouter({
  history: createWebHistory(),
  routes: [
    {
      path: "/",
      component: MainLayout,
      children: [
        { path: "", name: "home", component: Home },
        { path: "about", component: About },
        { path: "services", component: Services },
        { path: "contact", component: Contact },
        { path: "faq", component: FAQ },
        { path: "login", component: Login },
        { path: "choose", component: Sign },
        {path:"goprofile" , component: ProfilePage},
         
         {
           path: "/auth/callback",
           name: "auth-callback",
           component: AuthCallback,
         },
        // ✅ FIX: remove leading "/" because it's inside children
        { path: "createaccount", component: CreateAccount },

        // ✅ FIX: remove leading "/" because it's inside children
        { path: "register/artisan", component: Regsiter },
      ],
    },
  ],
  scrollBehavior() {
    return { top: 0 }
  },
})
