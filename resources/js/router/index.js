import { createRouter, createWebHistory } from "vue-router"
import MainLayout from "../components/layouts.vue"
import AuthCallback from "../components/view.vue"

import Regsiter from "../components/register/ArtisanRegister.vue"
import ProfilePage from "../components/ProfilePage.vue"

import ClientRegister from "../components/register/ClientRegis.vue"

const paim                    = () => import("../components/register/paim.vue")
const Home                    = () => import("../components/pages/home.vue")
const About                   = () => import("../components/about.vue")
const Services                = () => import("../components/service.vue")
const Contact                 = () => import("../components/contact.vue")
const Login                   = () => import("../components/Login.vue")
const Sign                    = () => import("../components/choose.vue")
const faq                     = () => import("../components/faq.vue")
const ArtisanProfile          = () => import("../components/pages/Artisanprofile.vue")
const demandes                = () => import("../components/pages/mesdemandes.vue")
const messages                = () => import("../components/pages/message.vue")
const CreateAccount           = () => import("../components/createaccount.vue")

// ── NEW PAGES ──────────────────────────────────────────────────────────────
const PolitiqueConfiance      = () => import("../components/pages/ui/PolitiqueConfiance.vue")
const PolitiquePaiement       = () => import("../components/pages/ui/PolitiquePaiement.vue")
const ConseilsPratiques       = () => import("../components/pages/ui/ConseilsPratiques.vue")
const PolitiqueConfidentialite= () => import("../components/pages/ui/PolitiqueConfidentialite.vue")
const ConditionsGenerales     = () => import("../components/pages/ui/ConditionsGenerales.vue")
export default createRouter({
  history: createWebHistory(),
  routes: [
    {
      path: "/",
      component: MainLayout,
      children: [
        { path: "",               name: "home",            component: Home },
        { path: "about",                                   component: About },
        { path: "services",                                component: Services },
        { path: "contact",                                 component: Contact },
        { path: "login",                                   component: Login },
        { path: "choose",                                  component: Sign },
        { path: "goprofile",                               component: ProfilePage },
        { path: "faq",                                     component: faq },
        { path: "artisan/:id",    name: "artisan-profile", component: ArtisanProfile },
        { path: "messages",                                component: messages },
        { path: "demandes",                                component: demandes },
        { path: "/auth/callback", name: "auth-callback",   component: AuthCallback },
        { path: "createaccount",                           component: CreateAccount },
        { path: "register/artisan",                        component: Regsiter },

        // ── NEW ROUTES ────────────────────────────────────────────────────
        { path: "politique-confiance",       name: "politique-confiance",       component: PolitiqueConfiance },
        { path: "politique-paiement",        name: "politique-paiement",        component: PolitiquePaiement },
        { path: "conseils",                  name: "conseils",                  component: ConseilsPratiques },
        { path: "politique-confidentialite", name: "politique-confidentialite", component: PolitiqueConfidentialite },
        { path: "conditions-generales",      name: "conditions-generales",      component: ConditionsGenerales },
          { path: "/register/client", component: ClientRegister },
            { path: "/paiment", component: paim },
      ],
    },
  ],
  scrollBehavior() {
    return { top: 0 }
  },
})