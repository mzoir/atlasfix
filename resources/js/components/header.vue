<template>
  <header class="header-frame fixed-top">
    <div class="container-xxl app-shell px-3 px-md-5">
      <div class="d-flex align-items-center justify-content-between gap-3">

        <!-- LEFT : LOGO -->
        <RouterLink class="logo d-inline-flex align-items-center" to="/">
          <img class="logo-img" src="../assets/Exclude.png" alt="AtlasFix" />
        </RouterLink>

        <!-- CENTER : NAV (desktop only) -->
        <nav class="nav-pill d-none d-lg-flex" aria-label="Main navigation">
          <RouterLink class="nav-item" to="/about">À propos</RouterLink>
          <span class="sep"></span>
          <RouterLink class="nav-item" to="/services">Services</RouterLink>
          <span class="sep"></span>
          <RouterLink class="nav-item" to="/contact">Contact</RouterLink>
          <span class="sep"></span>
          <RouterLink class="nav-item" to="/faq">FAQ's</RouterLink>
        </nav>

        <!-- RIGHT : ACTIONS (desktop) -->
        <div class="actions d-none d-lg-flex align-items-center gap-2">

          <!-- Bell -->
          <button class="bell" type="button" aria-label="Notifications">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
              <path d="M18 8a6 6 0 10-12 0c0 7-3 7-3 7h18s-3 0-3-7Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
              <path d="M13.7 21a2 2 0 01-3.4 0" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
            </svg>
          </button>

          <!-- NOT logged in -->
          <template v-if="!isLogged">
            <RouterLink class="btnx login" to="/Login">Log In</RouterLink>
            <RouterLink class="btnx signup" to="/choose">Sign Up</RouterLink>
          </template>

          <!-- Logged in → Mon compte button + dropdown -->
          <template v-else>
            <div class="account-wrap" ref="accountRef">
              <button class="account-btn" @click="menuOpen = !menuOpen" type="button">
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none">
                  <circle cx="12" cy="8" r="4" stroke="currentColor" stroke-width="2"/>
                  <path d="M4 20c0-4 3.6-7 8-7s8 3 8 7" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                </svg>
                <span>Mon compte</span>
              </button>

              <transition name="drop">
                <div v-if="menuOpen" class="account-dropdown">
                  <RouterLink class="drop-item" to="/goprofile" @click="menuOpen = false">
                    <span class="drop-icon"><svg width="16" height="16" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="8" r="4" stroke="currentColor" stroke-width="2"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg></span>
                    Mon profil
                  </RouterLink>
                  <RouterLink class="drop-item" to="/paiements" @click="menuOpen = false">
                    <span class="drop-icon"><svg width="16" height="16" viewBox="0 0 24 24" fill="none"><rect x="2" y="5" width="20" height="14" rx="3" stroke="currentColor" stroke-width="2"/><path d="M2 10h20" stroke="currentColor" stroke-width="2"/></svg></span>
                    Mes paiements
                  </RouterLink>
                  <RouterLink class="drop-item" to="/messages" @click="menuOpen = false">
                    <span class="drop-icon"><svg width="16" height="16" viewBox="0 0 24 24" fill="none"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/></svg></span>
                    Mes messages
                  </RouterLink>
                  <RouterLink class="drop-item" to="/demandes" @click="menuOpen = false">
                    <span class="drop-icon"><svg width="16" height="16" viewBox="0 0 24 24" fill="none"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8l-6-6z" stroke="currentColor" stroke-width="2"/><path d="M14 2v6h6M9 13h6M9 17h4" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg></span>
                    Mes demandes
                  </RouterLink>
                  <RouterLink class="drop-item" to="/agenda" @click="menuOpen = false">
                    <span class="drop-icon"><svg width="16" height="16" viewBox="0 0 24 24" fill="none"><rect x="3" y="4" width="18" height="18" rx="2" stroke="currentColor" stroke-width="2"/><path d="M16 2v4M8 2v4M3 10h18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg></span>
                    Agenda
                  </RouterLink>
                  <div class="drop-divider"></div>
                  <button class="drop-item logout-item" type="button" @click="logout">
                    <span class="drop-icon"><svg width="16" height="16" viewBox="0 0 24 24" fill="none"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4M16 17l5-5-5-5M21 12H9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></span>
                    Se déconnecter
                  </button>
                </div>
              </transition>
            </div>
          </template>

          <!-- Language -->
          <button class="lang" type="button" aria-label="Language">
            <span class="lang-text">FR</span>
            <span class="flags"><span class="flag fr"></span></span>
            <span class="chev">▾</span>
          </button>

        </div>

        <!-- MOBILE RIGHT: bell + burger -->
        <div class="mobile-right d-flex d-lg-none align-items-center gap-2">
          <button v-if="isLogged" class="bell" type="button" aria-label="Notifications">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
              <path d="M18 8a6 6 0 10-12 0c0 7-3 7-3 7h18s-3 0-3-7Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
              <path d="M13.7 21a2 2 0 01-3.4 0" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
            </svg>
          </button>

          <button
            class="burger"
            type="button"
            :aria-expanded="mobileOpen"
            aria-label="Toggle menu"
            @click="mobileOpen = !mobileOpen"
          >
            <span class="burger-line" :class="{ open: mobileOpen }"></span>
            <span class="burger-line" :class="{ open: mobileOpen }"></span>
            <span class="burger-line" :class="{ open: mobileOpen }"></span>
          </button>
        </div>

      </div>
    </div>

    <!-- ── MOBILE DRAWER ── -->
    <transition name="drawer">
      <div v-if="mobileOpen" class="mobile-drawer" @click.self="mobileOpen = false">
        <div class="drawer-inner">

          <!-- Nav links -->
          <nav class="drawer-nav">
            <RouterLink class="drawer-link" to="/about"    @click="mobileOpen = false">À propos</RouterLink>
            <RouterLink class="drawer-link" to="/services" @click="mobileOpen = false">Services</RouterLink>
            <RouterLink class="drawer-link" to="/contact"  @click="mobileOpen = false">Contact</RouterLink>
            <RouterLink class="drawer-link" to="/faq"      @click="mobileOpen = false">FAQ's</RouterLink>
          </nav>

          <div class="drawer-divider"></div>

          <!-- Auth section -->
          <template v-if="!isLogged">
            <div class="drawer-auth">
              <RouterLink class="btnx login full" to="/Login"  @click="mobileOpen = false">Log In</RouterLink>
              <RouterLink class="btnx signup full" to="/choose" @click="mobileOpen = false">Sign Up</RouterLink>
            </div>
          </template>

          <template v-else>
            <div class="drawer-account">
              <RouterLink class="drawer-link" to="/goprofile" @click="mobileOpen = false">
                <span class="drop-icon"><svg width="16" height="16" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="8" r="4" stroke="currentColor" stroke-width="2"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg></span>
                Mon profil
              </RouterLink>
              <RouterLink class="drawer-link" to="/paiements" @click="mobileOpen = false">
                <span class="drop-icon"><svg width="16" height="16" viewBox="0 0 24 24" fill="none"><rect x="2" y="5" width="20" height="14" rx="3" stroke="currentColor" stroke-width="2"/><path d="M2 10h20" stroke="currentColor" stroke-width="2"/></svg></span>
                Mes paiements
              </RouterLink>
              <RouterLink class="drawer-link" to="/messages" @click="mobileOpen = false">
                <span class="drop-icon"><svg width="16" height="16" viewBox="0 0 24 24" fill="none"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/></svg></span>
                Mes messages
              </RouterLink>
              <RouterLink class="drawer-link" to="/demandes" @click="mobileOpen = false">
                <span class="drop-icon"><svg width="16" height="16" viewBox="0 0 24 24" fill="none"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8l-6-6z" stroke="currentColor" stroke-width="2"/><path d="M14 2v6h6M9 13h6M9 17h4" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg></span>
                Mes demandes
              </RouterLink>
              <RouterLink class="drawer-link" to="/agenda" @click="mobileOpen = false">
                <span class="drop-icon"><svg width="16" height="16" viewBox="0 0 24 24" fill="none"><rect x="3" y="4" width="18" height="18" rx="2" stroke="currentColor" stroke-width="2"/><path d="M16 2v4M8 2v4M3 10h18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg></span>
                Agenda
              </RouterLink>
              <div class="drawer-divider"></div>
              <button class="drawer-link logout-item" type="button" @click="logout">
                <span class="drop-icon"><svg width="16" height="16" viewBox="0 0 24 24" fill="none"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4M16 17l5-5-5-5M21 12H9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></span>
                Se déconnecter
              </button>
            </div>
          </template>

          <!-- Language -->
          <div class="drawer-lang">
            <button class="lang" type="button" aria-label="Language">
              <span class="lang-text">FR</span>
              <span class="flags"><span class="flag fr"></span></span>
              <span class="chev">▾</span>
            </button>
          </div>

        </div>
      </div>
    </transition>

  </header>
</template>

<script setup>
import { RouterLink } from "vue-router"
import { computed, ref, onMounted, onBeforeUnmount } from "vue"
import axios from "axios"
import { useRouter } from "vue-router"

const router     = useRouter()
const menuOpen   = ref(false)
const mobileOpen = ref(false)
const accountRef = ref(null)

const isLogged = computed(() => !!localStorage.getItem("token"))

function handleClickOutside(e) {
  if (accountRef.value && !accountRef.value.contains(e.target)) {
    menuOpen.value = false
  }
}

// Close mobile drawer on resize to desktop
function handleResize() {
  if (window.innerWidth >= 992) mobileOpen.value = false
}

onMounted(() => {
  document.addEventListener('mousedown', handleClickOutside)
  window.addEventListener('resize', handleResize)
})
onBeforeUnmount(() => {
  document.removeEventListener('mousedown', handleClickOutside)
  window.removeEventListener('resize', handleResize)
})

async function logout() {
  menuOpen.value   = false
  mobileOpen.value = false
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
    console.log('logout error', e)
  } finally {
    localStorage.removeItem("token")
    localStorage.removeItem("user")
    delete axios.defaults.headers.common.Authorization
    window.location.reload()
  }
}
</script>

<style scoped>
/* ── Header shell ─────────────────────────────────────── */
.header-frame {
  height: 72px;
  background: transparent !important;
  z-index: 1000;
  display: flex;
  align-items: center;
  width: 100%;
  left: 0;
  right: 0;
}

.logo-img {
  width: 120px;
  height: 34px;
  object-fit: contain;
}

/* ── Nav pill (desktop) ───────────────────────────────── */
.nav-pill {
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
.nav-item {
  text-decoration: none;
  font-size: 15px;
  font-weight: 600;
  color: rgba(0,0,0,0.78);
  padding: 10px 16px;
  white-space: nowrap;
}
.nav-item.router-link-active,
.nav-item.router-link-exact-active { color: #fc5a15; }
.sep {
  width: 1px;
  height: 18px;
  background: rgba(0,0,0,0.22);
}

/* ── Bell ─────────────────────────────────────────────── */
.bell {
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

/* ── Login / Signup buttons ───────────────────────────── */
.btnx {
  height: 47px;
  width: 93px;
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
.btnx.full {
  width: 100%;
  height: 44px;
}
.login  { background: none; color: #fc5a15; border-color: rgba(252,90,21,0.85); }
.signup { color: #fff; box-shadow: 0 10px 18px rgba(252,90,21,0.35); }

/* ── Mon compte (desktop) ─────────────────────────────── */
.account-wrap { position: relative; }

.account-btn {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  padding: 0 16px;
  height: 44px;
  border-radius: 999px;
  border: 1px solid rgba(9,8,7,0.35);
  background: rgba(255,255,255,0.979);
  color: rgba(255,85,0,0.903);
  font-weight: 700;
  font-size: 14px;
  cursor: pointer;
  transition: background .2s, border-color .2s;
  white-space: nowrap;
}
.account-btn:hover {
  background: rgba(252,90,21,0.12);
  border-color: #fc5a15;
}

/* ── Dropdown (desktop) ───────────────────────────────── */
.account-dropdown {
  position: absolute;
  top: calc(100% + 12px);
  right: 0;
  width: 210px;
  background: #fff;
  border-radius: 14px;
  padding: 8px 0;
  box-shadow: 0 16px 40px rgba(0,0,0,0.12);
  border: 1px solid rgba(0,0,0,0.07);
  z-index: 999;
  overflow: hidden;
}

.drop-item {
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 11px 18px;
  font-size: 0.88rem;
  font-weight: 700;
  color: #1f2a44;
  text-decoration: none;
  background: none;
  border: none;
  width: 100%;
  cursor: pointer;
  transition: background .15s, color .15s;
  text-align: left;
}
.drop-item:hover { background: #fff5f1; color: #fc5a15; }

.drop-icon {
  width: 28px;
  height: 28px;
  border-radius: 8px;
  color: #fc5a15;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
}
.drop-item:hover .drop-icon { background: rgba(252,90,21,0.1); color: #fc5a15; }

.drop-divider, .drawer-divider {
  height: 1px;
  background: #f0f0f0;
  margin: 6px 0;
}

.logout-item { color: #e53935; }
.logout-item:hover { background: rgba(229,57,53,0.06); color: #e53935; }
.logout-item .drop-icon { color: #e53935; background: rgba(229,57,53,0.08); }

/* ── Dropdown animation ───────────────────────────────── */
.drop-enter-active, .drop-leave-active {
  transition: opacity .18s ease, transform .18s ease;
}
.drop-enter-from, .drop-leave-to {
  opacity: 0;
  transform: translateY(-8px) scale(0.97);
}

/* ── Language button ──────────────────────────────────── */
.lang {
  height: 26px;
  border-radius: 20px;
  border: 0.5px solid rgba(0,0,0,0.2);
  cursor: pointer;
  font-weight: 700;
  color: rgba(0,0,0,0.78);
  background: rgba(255,255,255,0.85);
  display: inline-flex;
  align-items: center;
  gap: 8px;
  padding: 0 10px;
}
.flag { width: 16px; height: 10px; border-radius: 2px; display: inline-block; }
.flag.fr { background: linear-gradient(90deg, #1f3cff 0 33%, #fff 33% 66%, #ff3b30 66% 100%); }
.chev { opacity: 0.7; font-size: 12px; }

/* ── Burger button ────────────────────────────────────── */
.burger {
  width: 40px;
  height: 40px;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  gap: 5px;
  background: rgba(255,255,255,0.9);
  border: 1px solid rgba(0,0,0,0.1);
  border-radius: 10px;
  cursor: pointer;
  padding: 0;
  flex-shrink: 0;
}

.burger-line {
  display: block;
  width: 20px;
  height: 2px;
  background: #1f2a44;
  border-radius: 2px;
  transition: transform .25s ease, opacity .25s ease;
  transform-origin: center;
}

/* Animate burger → X */
.burger-line:nth-child(1).open { transform: translateY(7px) rotate(45deg); }
.burger-line:nth-child(2).open { opacity: 0; transform: scaleX(0); }
.burger-line:nth-child(3).open { transform: translateY(-7px) rotate(-45deg); }

/* ── Mobile Drawer ────────────────────────────────────── */
.mobile-drawer {
  position: fixed;
  inset: 0;
  top: 72px;             /* sit below header */
  z-index: 999;
  background: rgba(0,0,0,0.25);
  backdrop-filter: blur(2px);
}

.drawer-inner {
  position: absolute;
  top: 0;
  right: 0;
  width: min(320px, 88vw);
  height: 100%;
  background: #fff;
  box-shadow: -8px 0 32px rgba(0,0,0,0.12);
  padding: 24px 0 32px;
  overflow-y: auto;
  display: flex;
  flex-direction: column;
  gap: 4px;
}

/* Drawer nav links */
.drawer-nav {
  display: flex;
  flex-direction: column;
  padding: 0 16px;
  gap: 2px;
}

.drawer-link {
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 13px 16px;
  font-size: 0.95rem;
  font-weight: 700;
  color: #1f2a44;
  text-decoration: none;
  background: none;
  border: none;
  width: 100%;
  cursor: pointer;
  border-radius: 10px;
  transition: background .15s, color .15s;
  text-align: left;
}
.drawer-link:hover,
.drawer-link.router-link-active {
  background: #fff5f1;
  color: #fc5a15;
}
.drawer-link.router-link-active { color: #fc5a15; }

.drawer-account {
  display: flex;
  flex-direction: column;
  padding: 0 16px;
  gap: 2px;
}

.drawer-auth {
  display: flex;
  flex-direction: column;
  padding: 8px 24px;
  gap: 10px;
}

.drawer-lang {
  padding: 8px 24px;
  margin-top: auto;
}

/* ── Drawer animation ─────────────────────────────────── */
.drawer-enter-active,
.drawer-leave-active {
  transition: opacity .22s ease;
}
.drawer-enter-active .drawer-inner,
.drawer-leave-active .drawer-inner {
  transition: transform .25s cubic-bezier(.4,0,.2,1);
}
.drawer-enter-from,
.drawer-leave-to {
  opacity: 0;
}
.drawer-enter-from .drawer-inner,
.drawer-leave-to .drawer-inner {
  transform: translateX(100%);
}
</style>