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
const Login = () => import("../components/Login.vue")
const Sign = () => import("../components/choose.vue")
const faq = () => import ("../components/faq.vue")
const ArtisanProfile =  ( ) => import ("../components/pages/Artisanprofile.vue")

const demandes =  ( ) => import ("../components/pages/mesdemandes.vue")
const messages = () => import ('../components/pages/message.vue')
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
        { path: "login", component: Login },
        { path: "choose", component: Sign },
        {path:"goprofile" , component: ProfilePage},
        {path:"faq" , component:faq },
        { path: "artisan/:id", name: "artisan-profile", component: ArtisanProfile },
          {path:"messages" , component:messages },
          {path:"demandes" , component:demandes },
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
