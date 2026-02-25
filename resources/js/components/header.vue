<template>
  <header class="header-frame fixed-top">
    <div class="container-xxl app-shell px-3 px-md-5">
      <div class="d-flex align-items-center justify-content-between gap-3">

        <!-- LEFT : LOGO -->
        <RouterLink class="logo d-inline-flex align-items-center" to="/">
          <img class="logo-img" src="../assets/Exclude.png" alt="AtlasFix" />
        </RouterLink>

        <!-- ✅ ONE Mobile toggler only -->

        <!-- CENTER : NAV (desktop) -->
        <nav class="nav-pill d-none d-lg-flex" aria-label="Main navigation">
          <RouterLink class="nav-item" to="/about">À propos</RouterLink>
          <span class="sep"></span>
          <RouterLink class="nav-item" to="/services">Services</RouterLink>
          <span class="sep"></span>
          <RouterLink class="nav-item" to="/contact">Contact</RouterLink>
          <span class="sep"></span>
          <RouterLink class="nav-item" to="/faq">FAQ’s</RouterLink>
        </nav>

        <!-- RIGHT : ACTIONS -->
        <div class="actions d-none d-lg-flex align-items-center gap-2">
          <button class="bell" type="button" aria-label="Notifications">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
              <path
                d="M18 8a6 6 0 10-12 0c0 7-3 7-3 7h18s-3 0-3-7Z"
                stroke="currentColor"
                stroke-width="2"
                stroke-linejoin="round"
              />
              <path
                d="M13.7 21a2 2 0 01-3.4 0"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
              />
            </svg>
          </button>

         <template v-if="!isLogged">
  <RouterLink class="btnx login" to="/Login">Log In</RouterLink>
  <RouterLink class="btnx signup" to="/choose">Sign Up</RouterLink>
</template>

<template v-else>
  <button class="btnd logout" type="button" @click="logout"> Déconnexion </button>
  <button class="circle-btn" @click="goToProfile">
      👤
    </button>
</template>

          <button class="lang" type="button" aria-label="Language">
            <span class="lang-text">FR</span>
            <span class="flags"><span class="flag fr"></span></span>
            <span class="chev">▾</span>
          </button>
        </div>
      </div>

      <!-- Mobile menu -->
   

    </div>
  </header>
</template>

<script setup>
import { RouterLink } from "vue-router"
import { computed } from "vue"
import axios from "axios"
import { useRouter } from "vue-router"

const router = useRouter()

const isLogged = computed(() => !!localStorage.getItem("token"));



 function goToProfile() {
     router.push("/goprofile")
  }


async function logout() {
  try {
    const token = localStorage.getItem("token")
    if (token) {
      await axios.post(
        "http://127.0.0.1:8000/api/logout",
        {},
        { headers: { Authorization: `Bearer ${token}`, Accept: "application/json" } }
      )
    }
  } catch (e) {
   console.log('there is a problem here ')
  } finally {
    localStorage.removeItem("token")
    localStorage.removeItem("user")
    delete axios.defaults.headers.common.Authorization
    window.location.reload() // optional, ensures header refresh
  }
}
</script>

<style scoped>
/* ✅ transparent fixed header */
.header-frame{
  height: 102px;
  background: transparent !important;
  z-index: 1000;
  display: flex;
  position: fixed;
  align-items: center;
}
.logout{
  background: red;
  color: #eeebe9;
  border: 1px solid rgba(22, 21, 21, 0.85);
  
}

/* bootstrap toggler */
:global(.navbar-toggler){
  border: 1px solid rgba(0,0,0,0.12);
  border-radius: 12px;
  padding: 8px 10px;
  background: rgba(255,255,255,0.85);
}
:global(.navbar-toggler-icon){
  width: 1.25rem;
  height: 1.25rem;
}

/* logo */
.logo-img{
  width: 135px;
  height: 37px;
  object-fit: contain;
}

/* nav pill */
.nav-pill{
  border-radius: 10px;
  background: rgba(255,255,255,0.92);
  border: 1px solid rgba(0,0,0,0.08);
  box-shadow: 0 10px 22px rgba(0,0,0,0.12);
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 0 18px;
  min-height: 48px;
  gap: 2px;
}

.nav-item{
  text-decoration: none;
  font-size: 15px;
  font-weight: 600;
  color: rgba(0,0,0,0.78);
  padding: 10px 16px;
  white-space: nowrap;
}
.nav-item.router-link-active,
.nav-item.router-link-exact-active{
  color: #fc5a15;
}
.sep{
  width: 1px;
  height: 18px;
  background: rgba(0,0,0,0.22);
}

/* actions */
.bell{
  width: 44px;
  height: 44px;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  color: #fc5a15;
  background: transparent;
  border: 0;
}

/* buttons */
.btnx{
  width: 93px;
  height: 47px;
  background: #fc5a15;
  border-radius: 12px;
  font-weight: 700;
  font-size: 14px;
  cursor: pointer;
  border: 1px solid transparent;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  text-decoration: none;
}
.login{
  background: none;
  color: #fc5a15;
  border-color: rgba(252, 90, 21, 0.85);
}
.signup{
  color: #fff;
  box-shadow: 0 10px 18px rgba(252, 90, 21, 0.35);
}

.lang{
  height: 26px;
  border-radius: 20px;
  border: 0.5px solid rgba(0,0,0,0.2);
  cursor: pointer;
  font-weight: 700;
  color: rgba(0, 0, 0, 0.78);
  background: rgba(255,255,255,0.85);
  display: inline-flex;
  align-items: center;
  gap: 8px;
  padding: 0 10px;
}
.flag{ width:16px; height:10px; border-radius:2px; display:inline-block; }
.flag.fr{
  background: linear-gradient(90deg, #1f3cff 0 33%, #fff 33% 66%, #ff3b30 66% 100%);
}
.chev{ opacity: 0.7; font-size: 12px; }
</style>
