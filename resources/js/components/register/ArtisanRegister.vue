<template>
  <section class="register-page">

    <!-- Phosphor Icons CDN -->
    <link rel="stylesheet" href="https://unpkg.com/@phosphor-icons/web@2.1.1/src/regular/style.css" />

    <div class="container-xxl app-shell px-3 px-md-5">

      <!-- Top bar -->
      <div class="pt-3 ps-5">
        <button class="back-btn" type="button" @click="goBack">← Retour</button>
      </div>

      <!-- Title -->
      <div class="title-wrap text-center">
        <h1 class="t-title">Devenez Artisan Partenaire</h1>
        <p class="t-sub">Rejoignez notre plateforme et développez votre activité</p>
      </div>

      <!-- ===== STEPPER ===== -->
      <div class="stepper-wrap">

        <div class="step-item">
          <div class="step-circle" :class="{ active: currentStep === 1, done: currentStep > 1 }">
            <span v-if="currentStep > 1" class="done-check">✓</span>
            <span v-else>1</span>
          </div>
          <div class="step-label" :class="{ active: currentStep >= 1 }">Informations<br></div>
        </div>

        <div class="step-line" :class="{ done: currentStep > 1 }"></div>

        <div class="step-item">
          <div class="step-circle" :class="{ active: currentStep === 2, done: currentStep > 2 }">
            <span v-if="currentStep > 2" class="done-check">✓</span>
            <span v-else>2</span>
          </div>
          <div class="step-label" :class="{ active: currentStep >= 2 }">professionnelles<br></div>
        </div>

        <div class="step-line" :class="{ done: currentStep > 2 }"></div>

        <div class="step-item">
          <div class="step-circle" :class="{ active: currentStep === 3, done: currentStep > 3 }">
            <span v-if="currentStep > 3" class="done-check">✓</span>
            <span v-else>3</span>
          </div>
          <div class="step-label" :class="{ active: currentStep >= 3 }">Portfolio</div>
        </div>

      </div>
      <!-- ===== END STEPPER ===== -->

      <!-- FORM CARD -->
      <div class="row justify-content-center">
        <div class="col-12 col-lg-10 col-xl-9">
          <div class="form-card">

            <!-- STEP 1 -->
            <div v-if="currentStep === 1">
              <h2 class="card-title">Informations personnelles</h2>

              <div class="mb-3">
                <label class="f-label">
                  <i class="f-ico ph ph-user"></i> Nom complet <span class="req">*</span>
                </label>
                <input class="form-control f-inp" v-model.trim="step1.nom_complet" placeholder="Ex: Mohammed Bennani" />
              </div>

              <div class="mb-3">
                <label class="f-label">
                  <i class="f-ico ph ph-calendar"></i> Date de naissance <span class="req">*</span>
                </label>
                <input class="form-control f-inp" v-model="step1.date_of_birth" type="date" :max="maxBirthDate" />
              </div>

              <div class="mb-3">
                <label class="f-label">
                  <i class="f-ico ph ph-envelope"></i> Adresse email <span class="req">*</span>
                </label>
                <input class="form-control f-inp" v-model.trim="step1.email" placeholder="exemple@email.com" />
              </div>

              <div class="mb-3">
                <label class="f-label">
                  <i class="f-ico ph ph-phone"></i> Numéro de téléphone <span class="req">*</span>
                </label>
                <input class="form-control f-inp" v-model.trim="step1.phone" placeholder="06 XX XX XX XX" />
              </div>

              <!-- Error -->
              <div v-if="errorMsg" class="err-box">
                <span class="err-ico">⚠</span> {{ errorMsg }}
              </div>

              <div class="d-flex justify-content-end">
                <button class="btn-atlas primary" type="button" @click="nextStep" :disabled="loading">
                  {{ loading ? 'Chargement...' : 'Suivant' }}
                </button>
              </div>
            </div>

            <!-- STEP 2 -->
            <div v-else-if="currentStep === 2">
              <h2 class="card-title">Informations professionnelles</h2>

              <div class="mb-3">
                <label class="f-label">
                  <i class="f-ico ph ph-wrench"></i> Service principal <span class="req">*</span>
                </label>
                <input class="form-control f-inp" v-model.trim="profile.new_service_name"
                  placeholder="Ex: Plomberie, Électricité..." />
              </div>

              <div class="mb-3">
                <label class="f-label">
                  <i class="f-ico ph ph-toolbox"></i> Type de service <span class="req">*</span>
                </label>
                <input class="form-control f-inp" v-model.trim="profile.diplome"
                  placeholder="Ex: Installation, Réparation..." />
              </div>

              <div class="mb-3">
                <label class="f-label">
                  <i class="f-ico ph ph-map-pin"></i> Ville <span class="req">*</span>
                </label>
                <input class="form-control f-inp" v-model.trim="profile.ville" placeholder="Sélectionnez une ville" />
              </div>

              <div class="mb-3">
                <label class="f-label">
                  <i class="f-ico ph ph-house"></i> Adresse <span class="req">*</span>
                </label>
                <div class="row g-2">
                  <div class="col-12 col-md-8">
                    <input class="form-control f-inp" v-model.trim="profile.adresse" placeholder="Adresse complète" />
                  </div>
                  <div class="col-12 col-md-4">
                    <button class="btn-atlas orange w-100" type="button" @click="mockLocate">
                      Me localiser
                    </button>
                  </div>
                </div>
              </div>

              <div class="mb-3">
                <label class="f-label">
                  <i class="f-ico ph ph-graduation-cap"></i> Copie de votre diplôme
                </label>
                <div class="file-row">
                  <input class="form-control f-inp" :value="profile.diplome_file?.name || ''"
                    placeholder="Scannez le diplôme" readonly />
                  <label class="file-btn" title="Choisir un fichier">
                    <input type="file" class="file-hidden" @change="onDiplomeFile" />
                    ⤓
                  </label>
                </div>
              </div>

              <!-- Error -->
              <div v-if="errorMsg" class="err-box">
                <span class="err-ico">⚠</span> {{ errorMsg }}
              </div>

              <div class="d-flex justify-content-between">
                <button class="btn-atlas ghost" type="button" @click="prevStep">Précédent</button>
                <button class="btn-atlas primary" type="button" @click="nextStep">Suivant</button>
              </div>
            </div>

            <!-- STEP 3 -->
            <div v-else>
              <h2 class="card-title">Portfolio et description</h2>

              <div class="mb-3">
                <label class="f-label">
                  <i class="f-ico ph ph-note-pencil"></i> Description <span class="req">*</span>
                </label>
                <textarea class="form-control f-text" v-model.trim="profile.description"
                  placeholder="Décrivez votre expérience, vos qualifications..."></textarea>
                <div class="tiny">{{ (profile.description || '').length }} caractères</div>
              </div>

              <div class="mb-3">
                <label class="f-label">
                  <i class="f-ico ph ph-images"></i> Photos de vos réalisations <span class="req">*</span>
                </label>
                <label class="upload-zone">
                  <input type="file" class="file-hidden" @change="onImages" multiple accept="image/*" />
                  <div class="upIcon">⤒</div>
                  <div class="upTitle">Cliquez pour télécharger ou glissez vos images</div>
                  <div class="upSub">PNG, JPG jusqu'à 4MB (minimum 3 photos)</div>
                  <div v-if="profile.images?.length" class="upFiles">
                    <div v-for="(f, i) in profile.images" :key="i" class="fileChip">{{ f.name }}</div>
                  </div>
                </label>
              </div>

              <div class="terms mb-3">
                <input id="terms" type="checkbox" v-model="accepted" />
                <label for="terms">
                  J'accepte les <span class="link">conditions générales d'utilisation</span> et la
                  <span class="link">politique de confidentialité</span>
                </label>
              </div>

              <div class="row g-2">
                <div class="col-12 col-md-6">
                  <label class="f-label">
                    <i class="f-ico ph ph-lock"></i> Mot de passe <span class="req">*</span>
                  </label>
                  <input class="form-control f-inp" v-model="pass.password" type="password" placeholder="••••••••" />
                </div>
                <div class="col-12 col-md-6">
                  <label class="f-label">
                    <i class="f-ico ph ph-lock"></i> Confirmer le mot de passe <span class="req">*</span>
                  </label>
                  <input class="form-control f-inp" v-model="pass.password_confirmation" type="password"
                    placeholder="••••••••" />
                </div>
              </div>

              <!-- Error -->
              <div v-if="errorMsg" class="err-box mt-3">
                <span class="err-ico">⚠</span> {{ errorMsg }}
              </div>

              <div class="d-flex justify-content-between mt-3">
                <button class="btn-atlas ghost" type="button" @click="prevStep">Précédent</button>
                <button class="btn-atlas primary" type="button" @click="nextStep" :disabled="loading">
                  {{ loading ? 'Envoi en cours...' : 'Soumettre ma candidature' }}
                </button>
              </div>
            </div>

          </div>

          <!-- WHY CARD -->
          <div class="why-card mt-3">
            <h3 class="why">Pourquoi nous rejoindre ?</h3>
            <ul>
              <li><span class="tick">✓</span> Accédez à des milliers de clients potentiels</li>
              <li><span class="tick">✓</span> Gérez vos rendez-vous et paiements facilement</li>
              <li><span class="tick">✓</span> Protection par système d'entiercement</li>
              <li><span class="tick">✓</span> Développez votre réputation avec les avis clients</li>
            </ul>
          </div>

          <div class="pb-4"></div>
        </div>
      </div>

    </div>
  </section>
</template>

<script setup>
import { ref, reactive } from "vue"
import { http } from "../api/http"

const currentStep = ref(1)
const tempId      = ref(null)
const accepted    = ref(false)
const loading     = ref(false)
const errorMsg    = ref('')

const maxBirthDate = new Date().toISOString().split("T")[0]

const step1 = reactive({
  nom_complet:   "",
  date_of_birth: "",
  email:         "",
  phone:         "",
})

const profile = reactive({
  new_service_name: "",
  ville:            "",
  adresse:          "",
  diplome:          "",
  description:      "",
  diplome_file:     null,
  images:           [],
})

const pass = reactive({
  password:              "",
  password_confirmation: "",
})

function goBack() {
  if (currentStep.value > 1) {
    currentStep.value--
  } else {
    window.history.back()
  }
}

function mockLocate() {
  profile.adresse = "Ex: Bd d'Anfa, Casablanca"
}

function prevStep() {
  errorMsg.value = ''
  if (currentStep.value > 1) currentStep.value--
}

function onDiplomeFile(e) {
  profile.diplome_file = e.target.files?.[0] || null
}

function onImages(e) {
  profile.images = Array.from(e.target.files || [])
}

async function nextStep() {
  errorMsg.value = ''
  try {
    loading.value = true

    if (currentStep.value === 1) {
      if (!step1.nom_complet || !step1.email || !step1.phone) {
        errorMsg.value = "Veuillez remplir tous les champs obligatoires."
        return
      }
      const res = await http.post("/register/artisan/start", {
        nom_complet:   step1.nom_complet,
        email:         step1.email,
        phone:         step1.phone,
        date_of_birth: step1.date_of_birth || null,
      })
      tempId.value      = res.data.temp_id
      currentStep.value = 2
      return
    }

    if (currentStep.value === 2) {
      if (!tempId.value) {
        errorMsg.value = "Session expirée, veuillez recommencer."
        return
      }
      if (!profile.ville || !profile.new_service_name) {
        errorMsg.value = "Veuillez remplir tous les champs obligatoires."
        return
      }
      currentStep.value = 3
      return
    }

    if (currentStep.value === 3) {
      if (!accepted.value) {
        errorMsg.value = "Veuillez accepter les conditions générales d'utilisation."
        return
      }
      if (!pass.password || !pass.password_confirmation) {
        errorMsg.value = "Veuillez remplir les deux champs de mot de passe."
        return
      }
      if (pass.password !== pass.password_confirmation) {
        errorMsg.value = "Les mots de passe ne correspondent pas."
        return
      }
      if (!tempId.value) {
        errorMsg.value = "Session expirée, veuillez recommencer."
        return
      }

      const fd = new FormData()
      fd.append("temp_id",          tempId.value)
      fd.append("ville",            profile.ville || "")
      fd.append("adresse",          profile.adresse || "")
      fd.append("diplome",          profile.diplome || "")
      fd.append("description",      profile.description || "")
      fd.append("new_service_name", profile.new_service_name || "")
      if (profile.diplome_file) fd.append("diplome_file", profile.diplome_file)
      if (profile.images?.length)
        profile.images.forEach((file) => fd.append("images[]", file))

      const profileRes = await http.post("/register/artisan/complete-profile", fd)
      console.log("Images saved:", profileRes.data.images_saved)

      const authRes = await http.post("/register/artisan/set-password", {
        temp_id:               tempId.value,
        password:              pass.password,
        password_confirmation: pass.password_confirmation,
      })

      localStorage.setItem("token", authRes.data.token)
      window.location.href = "/"
    }

  } catch (e) {
    console.error(e)
    errorMsg.value = e?.response?.data?.message || e.message || "Une erreur est survenue, veuillez réessayer."
  } finally {
    loading.value = false
  }
}
</script>

<style scoped>
.register-page {
  min-height: 100vh;
  padding-top: 102px;
  padding-bottom: 200px;
}

.back-btn {
  display: block;
  padding-right: 950px;
  margin: 0 auto;
  font-family: "Inter";
  font-weight: 400;
  font-size: 16px;
  line-height: 24px;
  letter-spacing: -0.31px;
  z-index: 3;
  color: rgba(98, 116, 142, 1);
  background: none;
  border: none;
  border-radius: 0;
  cursor: pointer;
}

.title-wrap {
  margin: 18px 0 24px;
}

.t-title {
  font-family: "Poppins", sans-serif;
  font-weight: 500;
  font-size: 36px;
  line-height: 40px;
  letter-spacing: 0.37px;
  text-align: center;
  margin: 0;
  color: rgba(49, 65, 88, 1);
}

.t-sub {
  font-family: "Poppins", sans-serif;
  font-weight: 400;
  font-size: 16px;
  line-height: 24px;
  letter-spacing: -0.31px;
  text-align: center;
  color: rgba(98, 116, 142, 1);
  margin: 6px 0 0;
}

/* ===== STEPPER ===== */
.stepper-wrap {
  display: flex;
  align-items: flex-start;
  justify-content: center;
  margin: 0 auto 32px;
  max-width: 640px;
  padding: 0 16px;
}

.step-item {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 10px;
  flex: 0 0 auto;
  min-width: 90px;
}

.step-circle {
  width: 48px;
  height: 48px;
  border-radius: 999px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-family: "Inter", sans-serif;
  font-weight: 700;
  font-size: 16px;
  background: #e9eef7;
  color: rgba(98, 116, 142, 1);
  transition: background 0.25s, color 0.25s;
  flex-shrink: 0;
}

.step-circle.active {
  background: #ff5a1f;
  color: #fff;
  box-shadow: 0 6px 18px rgba(255, 90, 31, 0.30);
}

.step-circle.done {
  background: #ff5a1f;
  color: #fff;
}

.done-check {
  font-size: 18px;
  font-weight: 900;
}

.step-label {
  font-family: "Inter", sans-serif;
  font-weight: 600;
  font-size: 11px;
  line-height: 14px;
  text-align: center;
  color: rgba(98, 116, 142, 1);
  transition: color 0.25s;
}

.step-label.active {
  color: rgba(49, 65, 88, 1);
}

.step-line {
  flex: 1;
  height: 3px;
  border-radius: 999px;
  background: #e9eef7;
  margin-top: 22px;
  transition: background 0.25s;
  min-width: 24px;
}

.step-line.done {
  background: #ff5a1f;
}

/* ===== FORM CARD ===== */
.form-card {
  background: #fff;
  border-radius: 14px;
  padding: 26px;
  box-shadow: 0 22px 60px rgba(0, 0, 0, 0.12);
  border: 1px solid rgba(17, 24, 39, 0.08);
}

.card-title {
  font-weight: 500;
  font-size: 24px;
  line-height: 32px;
  font-family: "Poppins", sans-serif;
  letter-spacing: 0.07px;
  color: rgba(49, 65, 88, 1);
  margin-bottom: 20px;
}

.f-label {
  font-family: "Inter", sans-serif;
  font-weight: 400;
  font-size: 16px;
  line-height: 24px;
  letter-spacing: -0.31px;
  color: rgba(49, 65, 88, 1);
  margin-bottom: 6px;
  display: flex;
  align-items: center;
  gap: 8px;
}

.f-ico {
  color: rgba(252, 90, 21, 1);
  font-size: 16px;
  flex-shrink: 0;
  width: 16px;
  text-align: center;
  line-height: 1;
}

.req {
  color: #ff5a1f;
  font-weight: 900;
  margin-left: auto;
}

.f-inp {
  font-family: "Inter", sans-serif;
  font-weight: 400;
  font-size: 16px;
  line-height: 100%;
  letter-spacing: -0.31px;
  color: rgba(10, 10, 10, 0.5);
  height: 42px;
  border-radius: 10px;
  border: 1px solid #d7dee8;
}

.f-inp:focus {
  border-color: #ff5a1f;
  box-shadow: 0 0 0 3px rgba(255, 90, 31, 0.12);
  outline: none;
}

.f-text {
  min-height: 110px;
  border-radius: 10px;
  border: 1px solid #d7dee8;
  font-weight: 600;
  font-size: 13px;
}

.f-text:focus {
  border-color: #ff5a1f;
  box-shadow: 0 0 0 3px rgba(255, 90, 31, 0.12);
  outline: none;
}

.tiny {
  margin-top: 6px;
  font-size: 11px;
  color: rgba(36, 48, 68, 0.55);
  font-weight: 700;
}

.file-row {
  display: flex;
  gap: 10px;
  align-items: center;
}

.file-btn {
  width: 44px;
  height: 42px;
  border-radius: 10px;
  border: 1px solid rgba(255, 90, 31, 0.35);
  background: rgba(255, 90, 31, 0.08);
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  font-weight: 900;
  color: #ff5a1f;
  flex-shrink: 0;
}

.file-hidden {
  display: none;
}

.upload-zone {
  width: 100%;
  border-radius: 10px;
  border: 2px dashed rgba(36, 48, 68, 0.18);
  background: #fafbff;
  padding: 18px;
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 8px;
  cursor: pointer;
}

.upIcon {
  width: 40px;
  height: 40px;
  border-radius: 999px;
  display: flex;
  align-items: center;
  justify-content: center;
  background: rgba(255, 90, 31, 0.10);
  color: #ff5a1f;
  font-weight: 900;
}

.upTitle {
  font-weight: 900;
  color: #2b3645;
  font-size: 13px;
  text-align: center;
}

.upSub {
  font-weight: 700;
  color: rgba(43, 54, 69, 0.55);
  font-size: 11px;
  text-align: center;
}

.upFiles {
  width: 100%;
  margin-top: 8px;
  display: flex;
  flex-wrap: wrap;
  gap: 8px;
  justify-content: center;
}

.fileChip {
  font-size: 11px;
  font-weight: 800;
  color: #2b3645;
  background: rgba(43, 54, 69, 0.06);
  border: 1px solid rgba(43, 54, 69, 0.10);
  padding: 6px 10px;
  border-radius: 999px;
}

.terms {
  background: #f7f9fc;
  border-radius: 10px;
  padding: 12px;
  display: flex;
  gap: 10px;
  align-items: flex-start;
}

.terms input {
  width: 16px;
  height: 16px;
  margin-top: 2px;
  flex-shrink: 0;
}

.terms label {
  font-size: 12px;
  font-weight: 700;
  color: rgba(43, 54, 69, 0.75);
  line-height: 1.35;
}

.link {
  color: #ff5a1f;
  font-weight: 900;
}

/* ===== ERROR BOX ===== */
.err-box {
  display: flex;
  align-items: center;
  gap: 10px;
  background: #fff5f5;
  border: 1px solid rgba(229, 57, 53, 0.25);
  border-radius: 10px;
  padding: 12px 16px;
  color: #c62828;
  font-size: 13px;
  font-weight: 700;
  margin-bottom: 14px;
}

.err-ico {
  font-size: 16px;
  flex-shrink: 0;
}

/* ===== BUTTONS ===== */
.btn-atlas {
  height: 42px;
  padding: 0 20px;
  border-radius: 10px;
  font-weight: 900;
  border: 0;
  cursor: pointer;
  font-size: 13px;
  font-family: "Inter", sans-serif;
}

.btn-atlas:disabled {
  opacity: 0.6;
  cursor: not-allowed;
}

.btn-atlas.primary {
  background: #ff5a1f;
  color: #fff;
  box-shadow: 0 10px 20px rgba(255, 90, 31, 0.25);
}

.btn-atlas.orange {
  background: #ff5a1f;
  color: #fff;
  height: 42px;
}

.btn-atlas.ghost {
  background: #fff;
  color: #2b3645;
  border: 1px solid rgba(43, 54, 69, 0.18);
}

/* ===== WHY CARD ===== */
.why-card {
  background: #eaf3ff;
  border-radius: 10px;
  padding: 18px 20px;
}

.why {
  font-family: "Inter", sans-serif;
  font-weight: 400;
  color: rgba(49, 65, 88, 1);
  font-size: 16px;
  line-height: 24px;
  letter-spacing: -0.31px;
}

.why-card h3 {
  margin: 0 0 10px;
}

.why-card ul {
  margin: 0;
  padding: 0;
  list-style: none;
  display: flex;
  flex-direction: column;
  gap: 8px;
}

.why-card li {
  font-family: "Inter", sans-serif;
  font-weight: 400;
  font-size: 14px;
  line-height: 20px;
  letter-spacing: -0.15px;
  color: rgba(98, 116, 142, 1);
}

.tick {
  color: #ff5a1f;
  font-weight: 400;
  margin-right: 10px;
}

@media (max-width: 576px) {
  .form-card    { padding: 18px; }
  .stepper-wrap { padding: 0 4px; }
  .step-item    { min-width: 70px; }
  .step-circle  { width: 40px; height: 40px; font-size: 14px; }
  .step-label   { font-size: 10px; }
  .step-line    { margin-top: 18px; }
}
</style>