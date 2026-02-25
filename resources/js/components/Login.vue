<template>
  <div class="login-page">
    <div class="container-xxl app-shell px-3 px-md-5">
      <!-- TOP BACK -->
      <div class="pt-3">
        <RouterLink class="back-link" to="/">← Retour</RouterLink>
      </div>

      <!-- CARD -->
      <div class="row justify-content-center">
        <div class="col-12 col-lg-10 col-xl-8">
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
                <span class="ico">✉️</span>
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
                <span class="ico">🔒</span>
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
            <div
              class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-2 mt-3"
            >
              <label class="remember">
                <input v-model="remember" class="form-check-input mt-0" type="checkbox" />
                <span>Se souvenir de moi</span>
              </label>

              <a class="forgot" href="#">Mot de passe oublié ?</a>
            </div>

            <!-- primary -->
            <button
              class="btn primary-btn w-100 mt-3"
              :disabled="loading"
              @click="login"
            >
              <span v-if="!loading">Se connecter</span>
              <span v-else>Connexion...</span>
            </button>

            <!-- OR -->
            <div class="or-row my-4">
              <div class="hr"></div>
              <div class="or-txt">OU</div>
              <div class="hr"></div>
            </div>

            <!-- social (unchanged UI) -->
            <button class="btn pill-btn pill-orange w-100" type="button">
              ✉️ <span>S'inscrire avec l'application</span>
            </button>

            <button class="btn pill-btn pill-white w-100 mt-2" type="button"    @click="loginWithGoogle">
              <span class="g">G</span> <span>Continuer avec Google</span>
            </button>

            <button class="btn pill-btn pill-white w-100 mt-2" type="button">
              <span class="f">f</span> <span>Continuer avec Facebook</span>
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

const router = useRouter()

// ✅ Change this to your backend base URL
// Example: "http://127.0.0.1:8000" or "https://api.atlasfix.ma"
const API_BASE = import.meta.env.VITE_API_BASE_URL || "http://127.0.0.1:8000"

const email = ref("")
const password = ref("")
const remember = ref(false)
const showPwd = ref(false)

const loading = ref(false)
const errorMsg = ref("")

// optional: keep axios config centralized
const api = axios.create({
  baseURL: API_BASE,
  headers: { Accept: "application/json" },
  withCredentials: false, // set true only if you use Sanctum cookies
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

    // ✅ adjust if your API returns access_token instead of token
    const token = res?.data?.token || res?.data?.access_token
    if (!token) {
      throw new Error("Token manquant dans la réponse API.")
    }

    localStorage.setItem("token", token)
    // optional
    if (res?.data?.user) localStorage.setItem("user", JSON.stringify(res.data.user))

    // Set default Authorization for future requests
    api.defaults.headers.common.Authorization = `Bearer ${token}`
    axios.defaults.headers.common.Authorization = `Bearer ${token}`

    // redirect where you want
    window.location.href = "/"
  } catch (err) {
    // Laravel validation / auth errors usually are here
    const status = err?.response?.status
    const data = err?.response?.data

    if (status === 422 && data?.errors) {
      // show first validation error
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
  // This route must exist in Laravel: /auth/google/redirect
  window.location.href = `${API_BASE}/auth/google/redirect`
}
</script>

<style scoped>
/* page spacing under fixed header */
.login-page{
  padding-top: 102px;
  padding-bottom: 12px;
}

/* back link */
.back-link{
  text-decoration: none;
  color: rgba(0,0,0,0.65);
  font-weight: 800;
}

/* card (responsive width comes from bootstrap cols) */
.login-card{
  background: #fff;
  border-radius: 18px;
  box-shadow: 0 18px 50px rgba(0,0,0,0.12);
  padding: 28px 20px;
  margin-top: 14px;
}
@media (min-width: 768px){
  .login-card{ padding: 34px 70px 28px; }
}

/* avatar */
.avatar{
  width: 56px;
  height: 56px;
  border-radius: 14px;
  background: #fc5a15;
  color: #fff;
  font-weight: 900;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  font-size: 26px;
}

/* typography */
.title{
  margin: 0;
  font-size: clamp(32px, 4vw, 44px);
  color: #1f2a44;
  font-weight: 900;
}
.sub{
  margin: 8px 0 0;
  color: rgba(31,42,68,0.65);
  font-weight: 700;
}

/* labels */
.lbl-row{
  display: flex;
  align-items: center;
  gap: 10px;
  color: rgba(31,42,68,0.85);
  font-weight: 800;
}
.ico{ color: #fc5a15; }

/* inputs (bootstrap form-control + our look) */
.inp{
  height: 52px;
  border-radius: 10px;
  border: 1px solid rgba(0,0,0,0.18);
  font-weight: 700;
}
.inp:focus{
  border-color: rgba(252,90,21,0.8);
  box-shadow: 0 0 0 4px rgba(252,90,21,0.12);
}

/* eye button */
.eye-btn{
  position: absolute;
  right: 10px;
  top: 50%;
  transform: translateY(-50%);
  border: none;
  background: transparent;
  cursor: pointer;
  opacity: 0.75;
}

/* remember */
.remember{
  display: inline-flex;
  gap: 10px;
  align-items: center;
  color: rgba(31,42,68,0.75);
  font-weight: 800;
}

/* forgot */
.forgot{
  color: #fc5a15;
  text-decoration: none;
  font-weight: 900;
}

/* primary */
.primary-btn{
  height: 56px;
  border-radius: 10px;
  border: 2px solid #fc5a15;
  background: #fff;
  color: #fc5a15;
  font-weight: 900;
  font-size: 18px;
}
.primary-btn:hover{
  background: rgba(252,90,21,0.06);
}

/* OR line */
.or-row{
  display:flex;
  align-items:center;
  gap: 14px;
}
.hr{ flex:1; height:1px; background: rgba(0,0,0,0.12); }
.or-txt{ color: rgba(0,0,0,0.5); font-weight: 900; }

/* pills */
.pill-btn{
  height: 54px;
  border-radius: 10px;
  border: 1px solid rgba(0,0,0,0.18);
  font-weight: 900;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 12px;
}
.pill-orange{
  background: #fc5a15;
  border-color: #fc5a15;
  color: #fff;
}
.pill-white{
  background: #fff;
  color: rgba(31,42,68,0.85);
}

/* letters */
.g{ font-weight: 900; color: #ea4335; }
.f{ font-weight: 900; color: #1877f2; }

/* bottom link */
.bottom-link{
  color: rgba(31,42,68,0.7);
  font-weight: 800;
}
.bottom-link a{
  color:#fc5a15;
  text-decoration:none;
  font-weight: 900;
}
</style>
