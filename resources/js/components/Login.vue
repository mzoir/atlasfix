<template>
  <div class="login-page" :style="{ backgroundImage: `linear-gradient(rgba(255,255,255,0.93), rgba(255,255,255,0.9)), url(${funfact1})` }">
    <img src="@/assets/hhf.png" class="corner-img" />
    
    <link rel="stylesheet" href="https://unpkg.com/@phosphor-icons/web@2.1.1/src/regular/style.css" />
    <div class="container-xxl app-shell px-3 px-md-5">
      <!-- TOP BACK -->
      <div class="row justify-content-center">
        <div class="col-12 col-lg-10 col-xl-8">
          <div class="pt-3">
            <RouterLink class="back-link" to="/">← Retour</RouterLink>
          </div>

          <div class="login-card text-center">
            <div class="avatar mx-auto">H</div>

            <h1 class="title mt-3">Bienvenue</h1>
            <p class="sub">Connectez-vous à votre compte</p>

            <!-- ERROR -->
            <div v-if="errorMsg" class="alert alert-danger text-start mt-3 mb-0">
              {{ errorMsg }}
            </div>
            <!-- EMAIL -->
            <div class="text-start mt-3">
              <label class="lbl-row mb-2">
                <span class="ico"><i class="f-ico ph ph-envelope"></i></span>
                <span>Adresse email</span>
              </label>
              <input
                v-model.trim="email"
                class="form-control inp"
                type="email"
                placeholder="exemple@email.com"
                autocomplete="email"
              />
            </div>

            <!-- PASSWORD -->
            <div class="text-start mt-3">
              <label class="lbl-row mb-2">
                <span class="ico"><i class="f-ico ph ph-lock"></i></span>
                <span>Mot de passe</span>
              </label>

              <div class="position-relative">
                <input
                  v-model="password"
                  class="form-control inp pe-5"
                  :type="showPwd ? 'text' : 'password'"
                  placeholder="••••••••"
                  autocomplete="current-password"
                />
                <button class="eye-btn" type="button" @click="showPwd = !showPwd" aria-label="Afficher le mot de passe">
                  👁️
                </button>
              </div>
            </div>

            <!-- remember/forgot -->
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-2 mt-3">
              <label class="remember">
                <input v-model="remember" class="form-check-input mt-0" type="checkbox" />
                <span>Se souvenir de moi</span>
              </label>

              <a class="forgot" href="#">Mot de passe oublié ?</a>
            </div>

            <!-- primary -->
            <button class="btn primary-btn w-100 mt-3" :disabled="loading" @click="login">
              <span v-if="!loading">Se connecter</span>
              <span v-else>Connexion...</span>
            </button>

            <!-- OR -->
            <div class="or-row my-4">
              <div class="hr"></div>
              <div class="or-txt">OU</div>
              <div class="hr"></div>
            </div>

            <!-- social (with images) -->
            <button class="btn pill-btn pill-orange w-100" type="button">
              <img :src="app" alt="App" class="social-img" /> <span>S'inscrire avec l'application</span>
            </button>

            <button class="btn pill-btn pill-white w-100 mt-2" type="button" @click="loginWithGoogle">
              <img :src="gmail" alt="Gmail" class="social-img" /> <span>Continuer avec Google</span>
            </button>

            <button class="btn pill-btn pill-white w-100 mt-2" type="button">
              <img :src="face" alt="Facebook" class="social-img" /> <span>Continuer avec Facebook</span>
            </button>

            <div class="bottom-link mt-3">
              Vous n'avez pas de compte ?
              <RouterLink to="/choose">Créer un compte</RouterLink>
            </div>
          </div>
        </div>
      </div>

      <div class="pb-4"></div>
    </div>
  </div>
</template>

<script setup>
import { ref } from "vue"
import { RouterLink, useRouter } from "vue-router"
import axios from "axios"

import funfact1 from "@/assets/worker.jpg"
import gmail from "@/assets/gmail1.png"
import face from "@/assets/Vector(2).png"
import app from "@/assets/Vector(1).png"

const router = useRouter()

const API_BASE = import.meta.env.VITE_API_BASE_URL || "http://127.0.0.1:8000"

const email = ref("")
const password = ref("")
const remember = ref(false)
const showPwd = ref(false)

const loading = ref(false)
const errorMsg = ref("")

const api = axios.create({
  baseURL: API_BASE,
  headers: { Accept: "application/json" },
  withCredentials: false,
})

async function login() {
  errorMsg.value = ""
  if (!email.value || !password.value) {
    errorMsg.value = "Veuillez remplir l'email et le mot de passe."
    return
  }

  loading.value = true
  try {
    const res = await api.post("/api/login", {
      email: email.value,
      password: password.value,
      remember: remember.value,
    })

    const token = res?.data?.token || res?.data?.access_token
    if (!token) throw new Error("Token manquant dans la réponse API.")

    localStorage.setItem("token", token)
    if (res?.data?.user) localStorage.setItem("user", JSON.stringify(res.data.user))

    api.defaults.headers.common.Authorization = `Bearer ${token}`
    axios.defaults.headers.common.Authorization = `Bearer ${token}`

    window.location.href = "/"
  } catch (err) {
    const status = err?.response?.status
    const data = err?.response?.data

    if (status === 422 && data?.errors) {
      const firstKey = Object.keys(data.errors)[0]
      errorMsg.value = data.errors[firstKey]?.[0] || "Données invalides."
    } else if (status === 401) {
      errorMsg.value = data?.message || "Email ou mot de passe incorrect."
    } else {
      errorMsg.value = data?.message || err?.message || "Erreur de connexion."
    }
  } finally {
    loading.value = false
  }
}

function loginWithGoogle() {
  window.location.href = `${API_BASE}/auth/google/redirect`
}
</script>

<style scoped>
.login-page {
 z-index: 0; /* important */
  position: relative;
  padding-top: 102px;
  padding-bottom: 50px;
  background-position: right ;
  background-repeat: no-repeat;
  background-size: cover;
}

/* gradient overlay */
.login-page::after {
  content: "";
  position: absolute;
  inset: 0;
  pointer-events: none;
  z-index: 0;
}

/* back link */
.back-link {
  font-family: "Inter";
  font-weight: 400;
  font-size: 16px;
  line-height: 24px;
  letter-spacing: -0.31px;
  text-align: center;
  text-decoration: none;
  color: rgba(98, 116, 142, 1);
}

.f-ico {
  color: #ff5a1f;
  font-size: 17px;
  flex-shrink: 0;
  width: 18px;
  text-align: center;
  line-height: 1;
}

/* card */
.login-card {
    z-index: 3;
  background: #fff;
  border-radius: 18px;
  box-shadow: 0 18px 50px rgba(0,0,0,0.12);
  padding: 28px 20px;
  margin-top: 14px;
}

/* avatar */
.avatar {
  width: 56px;
  height: 56px;
  border-radius: 14px;
  background: #fc5a15;
  color: #fff;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  font-size: 30px;
  line-height: 36px;
}

/* typography */
.title {
  margin: 0;
  color: rgba(49, 65, 88, 1);
  font-size: 30px;
}
.sub {
  margin: 8px 0 0;
  color: rgba(98, 116, 142, 1);
  font-size: 16px;
}

/* labels */
.lbl-row {
  display: flex;
  align-items: center;
  gap: 10px;
  color: rgba(49, 65, 88, 1);
}
.ico { color: #fc5a15; }

/* inputs */
.inp {
  height: 52px;
  border-radius: 10px;
  border: 1px solid rgba(0,0,0,0.18);
  font-weight: 700;
}
.inp:focus {
  border-color: rgba(252,90,21,0.8);
  box-shadow: 0 0 0 4px rgba(252,90,21,0.12);
}

/* eye button */
.eye-btn {
  position: absolute;
  right: 10px;
  top: 50%;
  transform: translateY(-50%);
  border: none;
  background: transparent;
  cursor: pointer;
  opacity: 0.75;
}

/* remember/forgot */
.remember { display: inline-flex; gap: 10px; align-items: center; }
.forgot { color: #fc5a15; text-decoration: none; }

/* primary button */
.primary-btn {
  height: 56px;
  border-radius: 10px;
  border: 1px solid #fc5a15;
  background: #fff;
  color: rgba(252, 90, 21, 1);
}
.primary-btn:hover { background: rgba(252,90,21,0.06); }

/* OR line */
.or-row { display: flex; align-items: center; gap: 14px; }
.hr { flex: 1; height: 1px; background: rgba(0,0,0,0.12); }
.or-txt { color: rgba(0,0,0,0.5); font-weight: 900; }

/* corner image */
.corner-img {

  z-index: -1; /* 🔥 key fix */
  position: absolute;
  bottom: 2px;
  right: 0;
  height: auto;
  width: auto;
  max-width: 641px;
min-height: 565px;
opacity: 1;
       /* 🔥 behind */
  pointer-events: none; /* no click issues */

}

/* pills */
.pill-btn {
  height: 54px;
  border-radius: 10px;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 12px;
  font-size: 16px;
}
.pill-orange { background: #fc5a15; color: #fff; border-color: #fc5a15; }
.pill-white { background: #fff; color: rgba(31,42,68,0.85); border: 1px solid rgba(0,0,0,0.18); }

/* social images */
.social-img { width: 24px; height: 24px; object-fit: contain; }

/* bottom link */
.bottom-link { font-size: 16px; color: rgba(31,42,68,0.7); text-align: center; }
.bottom-link a { color: #fc5a15; text-decoration: none; }
</style>