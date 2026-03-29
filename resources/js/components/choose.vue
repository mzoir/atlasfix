<template>
  <div class="page" :style="{ backgroundImage: `linear-gradient(180deg, #FFFFFF 0%, rgba(255,255,255,0.9) 49.52%, #FFFFFF 100%), url(${funfact1})` }">
  <img src="@/assets/left.png" class="corner-img"  />
    <div class="container-xxl app-shell px-3 px-md-5">
      <!-- Top bar -->
      <div class="pt-3 px-2 ps-5">
        <button class="back-btn" type="button" @click="goBack">← Retour</button>
      </div>

      <!-- ===== VIEW 1 : CHOOSE ROLE ===== -->
      <div v-if="view === 'choose'" class="mt-3">
        <div class="text-center mb-4">
          <h1 class="head-title">Créer un compte</h1>
          <p class="head-sub">Choisissez le type de compte qui vous correspond</p>
        </div>

        <div class="role-card-row">
          <!-- Client -->
          <div class="role-card-col">
            <article class="role-card h-100">
              <div class="iconBox">
                <img src="../assets/profile.svg" alt="Client" class="role-icon" />
              </div>
              <h2 class="role-title">Je suis un Client</h2>
              <p class="desc">Trouvez des artisans qualifiés pour tous vos projets</p>
              <span class="desc">de rénovation et d'entretien</span>
              <h1></h1>
              <ul class="list">
                <li><span class="check">✓</span> Accès à des centaines d'artisans certifiés</li>
                <li><span class="check">✓</span> Comparez les devis rapidement</li>
                <li><span class="check">✓</span> Consultez les avis et notes des artisans</li>
                <li><span class="check">✓</span> Service client disponible 7j/7</li>
              </ul>
               <RouterLink to="/register/client" class="w-100 d-block">
                <button class="cta w-100" type="button">Se connecter</button>
              </RouterLink>
            </article>
          </div>

          <!-- Artisan -->
          <div class="role-card-col">
            <article class="role-card h-100">
              <div class="iconBox">
                <img src="../assets/artisa.svg" alt="Artisan" class="role-icon" />
              </div>
              <h2 class="role-title">Je suis un Artisan</h2>
              <p class="desc">
                Développez votre activité et trouvez de nouveaux clients en rejoignant notre plateforme
              </p>
              <h1></h1>
              <ul class="list">
                <li><span class="check">✓</span> Recevez des demandes de clients locaux</li>
                <li><span class="check">✓</span> Créez votre profil et portfolio</li>
                <li><span class="check">✓</span> Gérez vos interventions facilement</li>
                <li><span class="check">✓</span> Construisez votre réputation en ligne</li>
              </ul>
              <RouterLink to="/register/artisan" class="w-100 d-block">
                <button class="cta w-100" type="button">Se connecter</button>
              </RouterLink>
            </article>
          </div>
        </div>
      </div>

      <!-- ===== VIEW 2 : CLIENT FORM ===== -->
      <div v-else-if="view === 'client'" class="mt-3 pagec " :style="{ backgroundImage: `linear-gradient(rgba(255,255,255,0.93), rgba(255,255,255,0.9)), url(${funfact1})` }">
        
        <div class="text-center mb-4">
          <h1 class="head-title">Créer un compte Client</h1>
          <p class="head-sub">Rejoignez notre plateforme et trouvez les meilleurs artisans</p>
        </div>

        <div class="row justify-content-center">
          <div class="col-12 col-lg-8">

            <form class="formCard" @submit.prevent="submitClient">
              <!-- Nom -->
              <div class="mb-3">
                <label class="lblRow mb-2">
                  <span class="ico">👤</span> Nom complet <b>*</b>
                </label>
                <input v-model.trim="client.nom" class="form-control inp" type="text"
                       placeholder="Ex: Ahmed El Amrani" required />
              </div>

              <!-- Email -->
              <div class="mb-3">
                <label class="lblRow mb-2">
                  <span class="ico">✉️</span> Adresse email <b>*</b>
                </label>
                <input v-model.trim="client.email" class="form-control inp" type="email"
                       placeholder="exemple@email.com" required />
              </div>

              <!-- Phone -->
              <div class="mb-3">
                <label class="lblRow mb-2">
                  <span class="ico">📞</span> Numéro de téléphone <b>*</b>
                </label>
                <input v-model.trim="client.phone" class="form-control inp" type="tel"
                       placeholder="06 XX XX XX XX" required />
              </div>

              <!-- Birth -->
              <div class="mb-3">
                <label class="lblRow mb-2">
                  <span class="ico">📅</span> Date de naissance <b>*</b>
                </label>
                <div class="position-relative">
                  <input
                    v-model="client.birth"
                    class="form-control inp pe-5"
                    type="date"
                    :max="maxBirthDate"
                    required
                  />
                  <span class="rightIcon">📅</span>
                </div>
                <small class="text-muted d-block mt-1">
                  Sélectionnez votre date de naissance
                </small>
              </div>

              <!-- Ville -->
              <div class="mb-3">
                <label class="lblRow mb-2">
                  <span class="ico">📍</span> Ville <b>*</b>
                </label>
                <div class="position-relative">
                  <select v-model="client.ville" class="form-select inp pe-5" required>
                    <option value="" disabled>Ville</option>
                    <option>Casablanca</option>
                    <option>Rabat</option>
                    <option>Fès</option>
                    <option>Marrakech</option>
                    <option>Tanger</option>
                  </select>
                  <span class="rightIcon">▾</span>
                </div>
              </div>

              <!-- Adresse -->
              <div class="mb-3">
                <label class="lblRow mb-2">
                  <span class="ico">🏠</span> Adresse
                </label>
                <div class="row g-2">
                  <div class="col-12 col-md-8">
                    <input v-model.trim="client.address" class="form-control inp" type="text"
                           placeholder="Adresse complète" />
                  </div>
                  <div class="col-12 col-md-4">
                    <button class="locBtn w-100" type="button" @click="mockLocate">
                      Me localiser
                    </button>
                  </div>
                </div>
              </div>

              <!-- Password -->
              <div class="mb-3">
                <label class="lblRow mb-2">
                  <span class="ico">🔒</span> Mot de passe <b>*</b>
                </label>
                <div class="position-relative">
                  <input v-model="client.pass" class="form-control inp pe-5"
                         :type="showPass ? 'text' : 'password'"
                         placeholder="Minimum 6 caractères" minlength="6" required />
                  <button class="eye" type="button" @click="showPass = !showPass">
                    {{ showPass ? '🙈' : '👁️' }}
                  </button>
                </div>
              </div>

              <!-- Confirm -->
              <div class="mb-3">
                <label class="lblRow mb-2">
                  <span class="ico">🔒</span> Confirmer le mot de passe <b>*</b>
                </label>
                <div class="position-relative">
                  <input v-model="client.pass2" class="form-control inp pe-5"
                         :type="showPass2 ? 'text' : 'password'"
                         placeholder="Retapez votre mot de passe" minlength="6" required />
                  <button class="eye" type="button" @click="showPass2 = !showPass2">
                    {{ showPass2 ? '🙈' : '👁️' }}
                  </button>
                </div>
              </div>

              <!-- Terms -->
              <div class="terms mb-3">
                <input id="t" v-model="client.accept" type="checkbox" />
                <label for="t">
                  J'accepte les <span class="link">conditions générales d'utilisation</span> et la
                  <span class="link">politique de confidentialité</span>
                </label>
              </div>

              <button class="submit w-100" type="submit" :disabled="loading">
                {{ loading ? "Création..." : "Créer mon compte" }}
              </button>
            </form>

            <!-- ===== WHY CREATE AN ACCOUNT BOX ===== -->
            <div class="why-box mt-3">
              <h3 class="why-title">Pourquoi créer un compte ?</h3>
              <ul class="why-list">
                <li><span class="why-check">✓</span> Créez et gérez vos demandes de service facilement</li>
                <li><span class="why-check">✓</span> Recevez des devis de plusieurs artisans qualifiés</li>
                <li><span class="why-check">✓</span> Suivez l'état de vos demandes en temps réel</li>
                <li><span class="why-check">✓</span> Communiquez directement avec les artisans via la messagerie</li>
                <li><span class="why-check">✓</span> Consultez votre historique de demandes et d'avis</li>
              </ul>
            </div>

            <div class="pb-4"></div>
          </div>
        </div>
      </div>

      <div v-else class="mt-3 text-center">
        <h1 class="head-title">Créer un compte Artisan</h1>
        <p class="head-sub">(On ajoute ce formulaire après)</p>
      </div>

    </div>
  </div>
</template>

<script setup>
import { reactive, ref } from "vue"
import { RouterLink } from "vue-router"
import { http } from "./api/http"

import funfact1 from "@/assets/worker.jpg"

const view = ref("choose")
const showPass = ref(false)
const showPass2 = ref(false)
const loading = ref(false)

const tempId = ref(null)

const maxBirthDate = new Date().toISOString().split("T")[0]

const client = reactive({
  nom: "",
  email: "",
  phone: "",
  birth: "",
  ville: "",
  address: "",
  pass: "",
  pass2: "",
  accept: false,
})

const goBack = () => {
  if (view.value === "choose") return
  view.value = "choose"
}

const mockLocate = () => {
  client.address = "Ex: Bd d'Anfa, Casablanca"
}

async function submitClient() {
  try {
    if (!client.accept) return alert("Veuillez accepter les conditions.")
    if (client.pass !== client.pass2) return alert("Les mots de passe ne correspondent pas.")
    if (!client.birth) return alert("Veuillez sélectionner votre date de naissance.")

    loading.value = true

    const startPayload = {
      name: client.nom,
      email: client.email,
      phone: client.phone,
      ville: client.ville,
      date_of_birth: client.birth,
    }

    const startRes = await http.post("/register/user/start", startPayload)
    tempId.value = startRes.data.temp_id

    const passPayload = {
      temp_id: tempId.value,
      password: client.pass,
      password_confirmation: client.pass2,
    }

    const passRes = await http.post("/register/user/set-password", passPayload)

    if (passRes.data?.token) {
      localStorage.setItem("token", passRes.data.token)
    }

    alert("Compte créé ✅")
  } catch (e) {
    console.error(e)
    alert(e?.response?.data?.message || e.message || "Erreur ❌")
  } finally {
    loading.value = false
  }
}
</script>

<style scoped>
.page {
  position: relative;
  padding-top: 102px;
  padding-bottom: 200px;
  background-image: 
    linear-gradient(180deg, #FFFFFF 0%, rgba(255,255,255,0) 49.52%, #FFFFFF 100%),
    v-bind("'url(' + funfact1 + ')'");
  background-position: top;
  background-repeat: no-repeat;
  background-size: cover;
}
.pt-3.px-2.ps-5 {
  text-align: left;
}

/* ── Card row ─────────────────────────────────────────── */
.role-card-row {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  gap: 24px;
  max-width: 1024px;
  margin: 0 auto;
}
.role-card-col {
  flex: 1 1 0;
  min-width: 280px;
  max-width: 496px;
}
.corner-img {
  position: absolute;
  opacity: 100%;
  background-position: bottom  ;
  bottom: 0;
  left: 0;
  max-width: 641px;
  max-height: 565px;
  height: auto;
  width: auto;
  pointer-events: none;
  z-index: 0;

  
}
.back-btn {
  margin-left: 0;
  padding-left: 80px;
  text-align: left;
  font-family: "inter";
  font-weight: 400;
  font-size: 16px;
  line-height: 24px;
  letter-spacing: -0.31px;
  color: rgba(98, 116, 142, 1);
  background: transparent;
  border: 0;
  cursor: pointer;
}
.head-title {
  font-family: "Poppins";
  font-weight: 400;
  font-size: 48px;
  line-height: 48px;
  letter-spacing: -0.5px;
  text-align: center;
  color: rgba(49, 65, 88, 1);
  margin: 0;
}
.head-sub {
  font-family: Poppins;
  font-weight: 400;
  font-size: 20px;
  line-height: 28px;
  letter-spacing: -0.45px;
  text-align: center;
  margin: 10px 0 0;
  color: #6f7f93;
}
.role-card {
  border-radius: 22px;
  background: #ffffff;
  box-shadow: 0 20px 60px rgba(0, 0, 0, 0.18);
  padding: 34px 34px 26px;
  position: relative;
  overflow: hidden;
}
.role-card::after {
  content: "";
  position: absolute;
  top: -60px;
  right: -60px;
  width: 160px;
  height: 160px;
  border-radius: 999px;
  background: rgba(255, 153, 120, 0.18);
}
.iconBox {
  width: 80px;
  height: 80px;
  border-radius: 14px;
  background: #ff5a1f;
  display: flex;
  align-items: center;
  justify-content: center;
  margin-bottom: 18px;
}
.role-icon {
  width: 38px;
  height: 38px;
  object-fit: contain;
}
.role-title {
  margin: 0;
  font-family: 'Poppins', sans-serif;
  font-style: normal;
  font-weight: 400;
  font-size: 30px;
  line-height: 36px;
  letter-spacing: 0.4px;
  color: rgba(49, 65, 88, 1);
}
.desc {
  font-family: 'Poppins', sans-serif;
  margin: 10px 0 0px;
  color: rgba(98, 116, 142, 1);
  font-size: 15px;
  line-height: 1.5;
}
.list {
  list-style: none;
  padding: 0;
  margin: 0 0 22px;
  display: flex;
  flex-direction: column;
  gap: 12px;
  font-family: 'Poppins', sans-serif;
  font-weight: 400;
  font-size: 14px;
  line-height: 20px;
  letter-spacing: -0.31px;
  color: rgba(98, 116, 142, 1);
}
.check {
  display: inline-flex;
  width: 20px;
  height: 20px;
  border-radius: 999px;
  align-items: center;
  justify-content: center;
  border: 2px solid #ff5a1f;
  color: #ff5a1f;
  font-weight: 900;
  margin-right: 10px;
  transform: translateY(2px);
}
.cta {
  height: 56px;
  border: 0;
  border-radius: 14px;
  background: #ff5a1f;
  color: #fff;
  font-weight: 900;
  font-size: 16px;
  cursor: pointer;
  box-shadow: 0 10px 26px rgba(255, 90, 31, 0.35);
}

/* ===== WHY BOX ===== */
.why-box {
  background: #eef4fb;
  border-radius: 18px;
  padding: 28px 32px;
}
.why-title {
  font-family: "Poppins";
  font-weight: 500;
  font-size: 18px;
  line-height: 26px;
  color: rgba(49, 65, 88, 1);
  margin: 0 0 18px;
}
.why-list {
  list-style: none;
  padding: 0;
  margin: 0;
  display: flex;
  flex-direction: column;
  gap: 12px;
}
.why-list li {
  font-family: "Poppins";
  font-weight: 400;
  font-size: 15px;
  line-height: 22px;
  color: rgba(98, 116, 142, 1);
  display: flex;
  align-items: center;
  gap: 10px;
}
.why-check {
  display: inline-flex;
  width: 18px;
  height: 18px;
  border-radius: 999px;
  align-items: center;
  justify-content: center;
  border: 2px solid #ff5a1f;
  color: #ff5a1f;
  font-weight: 900;
  font-size: 11px;
  flex-shrink: 0;
}

/* ===== FORM ===== */
.formCard {
  background: #fff;
  border-radius: 18px;
  box-shadow: 0 20px 60px rgba(0, 0, 0, 0.18);
  padding: 22px;
  border: 1px solid rgba(0, 0, 0, 0.06);
}
.lblRow {
  display: flex;
  align-items: center;
  gap: 10px;
  font-weight: 800;
  color: #2b3645;
  font-size: 14px;
}
.lblRow b {
  color: #ff5a1f;
}
.inp {
  height: 44px;
  border-radius: 10px;
  border: 1px solid #d7dee8;
  font-weight: 700;
}
.inp:focus {
  border-color: #ff5a1f;
  box-shadow: 0 0 0 3px rgba(255, 90, 31, 0.12);
}
.rightIcon {
  position: absolute;
  right: 12px;
  top: 50%;
  transform: translateY(-50%);
  color: #7b8aa0;
  pointer-events: none;
}
.eye {
  position: absolute;
  right: 10px;
  top: 50%;
  transform: translateY(-50%);
  border: 0;
  background: transparent;
  cursor: pointer;
  font-size: 16px;
  opacity: 0.8;
}
.locBtn {
  height: 44px;
  border: 0;
  border-radius: 10px;
  background: #ff5a1f;
  color: #fff;
  font-weight: 900;
  cursor: pointer;
}
.terms {
  background: #f7f9fc;
  border-radius: 12px;
  padding: 14px;
  display: flex;
  gap: 10px;
  align-items: flex-start;
}
.terms input {
  width: 16px;
  height: 16px;
  margin-top: 2px;
}
.terms label {
  font-size: 13px;
  color: #5b6b7c;
  line-height: 1.4;
  font-weight: 600;
}
.link {
  color: #ff5a1f;
  font-weight: 800;
}
.submit {
  height: 56px;
  border: 0;
  border-radius: 12px;
  background: #ff5a1f;
  color: #fff;
  font-weight: 900;
  font-size: 16px;
  cursor: pointer;
  box-shadow: 0 10px 26px rgba(255, 90, 31, 0.35);
}
.submit:disabled {
  opacity: 0.7;
  cursor: not-allowed;
}

/* Responsive */
@media (max-width: 768px) {
  .role-card-row {
    flex-direction: column;
    align-items: center;
  }
  .role-card-col {
    width: 100%;
    max-width: 90%;
  }
  .role-card {
    padding: 20px 16px;
  }
  .formCard {
    padding: 16px;
  }
  .why-box {
    padding: 20px 16px;
  }
}
</style>