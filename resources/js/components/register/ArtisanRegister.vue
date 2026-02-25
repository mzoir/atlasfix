<template>
  <section class="register-page">
    <div class="container-xxl app-shell px-3 px-md-5">

      <!-- Title -->
      <div class="title-wrap text-center">
        <h1 class="t-title">Devenez Artisan Partenaire</h1>
        <p class="t-sub">Rejoignez notre plateforme et développez votre activité</p>
      </div>

      <!-- Stepper -->
      <div class="stepper-wrap">
        <div class="stepper">
          <div class="stepLine" :class="{ on: currentStep >= 2 }"></div>
          <div class="stepLine r" :class="{ on: currentStep >= 3 }"></div>

          <div class="step" :class="{ active: currentStep >= 1 }">
            <div class="dot">1</div>
            <div class="lbl">Informations</div>
          </div>

          <div class="step" :class="{ active: currentStep >= 2 }">
            <div class="dot">2</div>
            <div class="lbl">Professionnel</div>
          </div>

          <div class="step" :class="{ active: currentStep >= 3 }">
            <div class="dot">3</div>
            <div class="lbl">Portfolio</div>
          </div>
        </div>
      </div>

      <!-- FORM CARD -->
      <div class="row justify-content-center">
        <div class="col-12 col-lg-10 col-xl-9">
          <div class="form-card">

            <!-- STEP 1 -->
            <div v-if="currentStep === 1">
              <h2 class="card-title">Informations personnelles</h2>

              <div class="mb-3">
                <label class="f-label"><span class="req">*</span> Nom complet</label>
                <input class="form-control f-inp" v-model.trim="step1.nom_complet" placeholder="Ex: Mohammed Bennani" />
              </div>

              <div class="mb-3">
                <label class="f-label"><span class="req">*</span> Date de naissance</label>
                <input class="form-control f-inp" v-model="step1.date_of_birth" type="date" :max="maxBirthDate" />
              </div>

              <div class="mb-3">
                <label class="f-label"><span class="req">*</span> Adresse email</label>
                <input class="form-control f-inp" v-model.trim="step1.email" placeholder="exemple@email.com" />
              </div>

              <div class="mb-3">
                <label class="f-label"><span class="req">*</span> Numéro de téléphone</label>
                <input class="form-control f-inp" v-model.trim="step1.phone" placeholder="06 XX XX XX XX" />
              </div>

              <div class="d-flex justify-content-end">
                <button class="btn-atlas primary" type="button" @click="nextStep">
                  Suivant
                </button>
              </div>
            </div>

            <!-- STEP 2 -->
            <div v-else-if="currentStep === 2">
              <h2 class="card-title">Informations professionnelles</h2>

              <div class="mb-3">
                <label class="f-label"><span class="req">*</span> Service principal</label>
                <input class="form-control f-inp" v-model.trim="profile.new_service_name"
                  placeholder="Sélectionnez un service" />
              </div>

              <div class="mb-3">
                <label class="f-label"><span class="req">*</span> Type de service</label>
                <input class="form-control f-inp" v-model.trim="profile.diplome"
                  placeholder="Ex: Installation, Réparation..." />
              </div>

              <div class="mb-3">
                <label class="f-label"><span class="req">*</span> Ville</label>
                <input class="form-control f-inp" v-model.trim="profile.ville" placeholder="Sélectionnez une ville" />
              </div>

              <div class="mb-3">
                <label class="f-label"><span class="req">*</span> Adresse</label>

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
                <label class="f-label"><span class="req">*</span> Copie de votre diplôme</label>

                <div class="file-row">
                  <input class="form-control f-inp" :value="profile.diplome_file?.name || ''"
                    placeholder="Scannez le diplôme" readonly />
                  <label class="file-btn" title="Choisir un fichier">
                    <input type="file" class="file-hidden" @change="onDiplomeFile" />
                    ⤓
                  </label>
                </div>
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
                <label class="f-label"><span class="req">*</span> Description</label>
                <textarea class="form-control f-text" v-model.trim="profile.description"
                  placeholder="Décrivez votre expérience, vos qualifications et ce qui vous distingue des autres artisans..."></textarea>
                <div class="tiny">{{ (profile.description || '').length }} caractères</div>
              </div>

              <div class="mb-3">
                <label class="f-label"><span class="req">*</span> Photos de vos réalisations</label>

                <label class="upload-zone">
                  <input type="file" class="file-hidden" @change="onImages" multiple />
                  <div class="upIcon">⤒</div>
                  <div class="upTitle">Cliquez pour télécharger ou glissez vos images</div>
                  <div class="upSub">PNG, JPG jusqu'à 10MB (minimum 3 photos)</div>
                  <div v-if="profile.images?.length" class="upFiles">
                    <div v-for="(f, i) in profile.images" :key="i" class="fileChip">
                      {{ f.name }}
                    </div>
                  </div>
                </label>
              </div>

              <div class="terms mb-3">
                <input id="terms" type="checkbox" v-model="accepted" />
                <label for="terms">
                  J'accepte les <span class="link">conditions générales d’utilisation</span> et la
                  <span class="link">politique de confidentialité</span>
                </label>
              </div>

              <div class="row g-2">
                <div class="col-12 col-md-6">
                  <label class="f-label"><span class="req">*</span> Mot de passe</label>
                  <input class="form-control f-inp" v-model="pass.password" type="password" placeholder="••••••••" />
                </div>
                <div class="col-12 col-md-6">
                  <label class="f-label"><span class="req">*</span> Confirmer le mot de passe</label>
                  <input class="form-control f-inp" v-model="pass.password_confirmation" type="password"
                    placeholder="••••••••" />
                </div>
              </div>

              <div class="d-flex justify-content-between mt-3">
                <button class="btn-atlas ghost" type="button" @click="prevStep">Précédent</button>
                <button class="btn-atlas primary" type="button" @click="nextStep">
                  Soumettre ma candidature
                </button>
              </div>
            </div>

          </div>

          <!-- WHY CARD UNDER -->
          <div class="why-card mt-3">
            <h3>Pourquoi nous rejoindre ?</h3>
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
const tempId = ref(null)
const accepted = ref(false)
const maxBirthDate = new Date().toISOString().split("T")[0]

const step1 = reactive({
  nom_complet: "",
  date_of_birth: "",
  email: "",
  phone: "",
})

const profile = reactive({
  new_service_name: "",
  ville: "",
  adresse: "",
  diplome: "",
  description: "",
  diplome_file: null,
  images: [],
})

const pass = reactive({
  password: "",
  password_confirmation: "",
})

function mockLocate() {
  profile.adresse = "Ex: Bd d'Anfa, Casablanca"
}

function prevStep() {
  if (currentStep.value > 1) currentStep.value--
}

function onDiplomeFile(e) {
  profile.diplome_file = e.target.files?.[0] || null
}

function onImages(e) {
  profile.images = Array.from(e.target.files || [])
}

async function nextStep() {
  try {
    // STEP 1
    if (currentStep.value === 1) {
      const res = await http.post("/register/artisan/start", step1)
      tempId.value = res.data.temp_id
      currentStep.value = 2
      return
    }

    // STEP 2
    if (currentStep.value === 2) {
      if (!tempId.value) throw new Error("temp_id manquant")

      const fd = new FormData()
      fd.append("temp_id", tempId.value)
      fd.append("ville", profile.ville)
      fd.append("adresse", profile.adresse)
      fd.append("diplome", profile.diplome)
      fd.append("description", profile.description)

      if (profile.new_service_name) fd.append("new_service_name", profile.new_service_name)
      if (profile.diplome_file) fd.append("diplome_file", profile.diplome_file)
      if (profile.images?.length) profile.images.forEach((f) => fd.append("images[]", f))

      await http.post("/register/artisan/complete-profile", fd, {
        headers: { "Content-Type": "multipart/form-data" },
      })

      currentStep.value = 3
      return
    }

    // STEP 3
    if (currentStep.value === 3) {
      if (!accepted.value) throw new Error("Veuillez accepter les conditions.")
      if (!tempId.value) throw new Error("temp_id manquant")

      const res = await http.post("/register/artisan/set-password", {
        temp_id: tempId.value,
        password: pass.password,
        password_confirmation: pass.password_confirmation,
      })

      localStorage.setItem("token", res.data.token)
      alert("Compte activé ✅")
       window.location.href = "/"
    }
  } catch (e) {
    console.error(e)
    alert(e?.response?.data?.message || e.message || "Erreur ❌")
  }
}
</script>

<style scoped>
/* ===== Black background like screenshot ===== */
.register-page {
  min-height: 100vh;
  padding-top: 102px;
  /* fixed header */
  padding-bottom: 24px;
}

/* ===== Title ===== */
.title-wrap {
  margin: 18px 0 14px;
}

.t-title {
  margin: 0;
  font-weight: 900;
  color: rgba(0, 0, 0, 0.7);
  font-size: clamp(22px, 3vw, 28px);
}

.t-sub {
  margin: 6px 0 0;
  color: rgba(0, 0, 0, 0.7);
  font-weight: 600;
  font-size: 13px;
}

/* ===== Stepper ===== */
.stepper-wrap {
  display: flex;
  justify-content: center;
  margin: 10px 0 18px;
}

.stepper {
  width: min(980px, 100%);
  position: relative;
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 12px 8px 6px;
}

.step {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 8px;
  opacity: .45;
  z-index: 2;
}

.step.active {
  opacity: 1;
}

.dot {
  width: 34px;
  height: 34px;
  border-radius: 999px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: 900;
  color: #0b0b0b;
  background: #e9eef7;
}

.step.active .dot {
  background: #ff5a1f;
  color: #fff;
}

.lbl {
  color: rgba(233, 238, 247, .75);
  font-size: 12px;
  font-weight: 700;
}

/* connecting lines */
.stepLine {
  position: absolute;
  left: 16%;
  right: 50%;
  top: 28px;
  height: 3px;
  background: rgba(233, 238, 247, .25);
  border-radius: 999px;
  z-index: 1;
}

.stepLine.r {
  left: 50%;
  right: 16%;
}

.stepLine.on {
  background: #ff5a1f;
}

/* ===== Form card ===== */
.form-card {
  background: #fff;
  border-radius: 14px;
  padding: 26px;
  box-shadow: 0 22px 60px rgba(0, 0, 0, 0.45);
  border: 1px solid rgba(17, 24, 39, 0.10);
}

/* title inside card */
.card-title {
  margin: 0 0 14px;
  font-weight: 900;
  color: #243044;
  font-size: 16px;
}

/* inputs */
.f-label {
  font-size: 12px;
  font-weight: 800;
  color: #2b3645;
  margin-bottom: 6px;
}

.req {
  color: #ff5a1f;
  font-weight: 900;
}

.f-inp {
  height: 42px;
  border-radius: 10px;
  border: 1px solid #d7dee8;
  font-weight: 700;
  font-size: 13px;
}

.f-inp:focus {
  border-color: #ff5a1f;
  box-shadow: 0 0 0 3px rgba(255, 90, 31, 0.12);
}

.f-text {
  min-height: 110px;
  border-radius: 10px;
  border: 1px solid #d7dee8;
  font-weight: 700;
  font-size: 13px;
}

.f-text:focus {
  border-color: #ff5a1f;
  box-shadow: 0 0 0 3px rgba(255, 90, 31, 0.12);
}

.tiny {
  margin-top: 6px;
  font-size: 11px;
  color: rgba(36, 48, 68, 0.55);
  font-weight: 700;
}

/* diploma row like screenshot */
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
}

.file-hidden {
  display: none;
}

/* upload zone */
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

/* terms */
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

/* buttons */
.btn-atlas {
  height: 40px;
  padding: 0 18px;
  border-radius: 10px;
  font-weight: 900;
  border: 0;
  cursor: pointer;
  font-size: 13px;
}

.btn-atlas.primary {
  background: #ff5a1f;
  color: #fff;
  box-shadow: 0 10px 20px rgba(255, 90, 31, 0.25);
}

.btn-atlas.orange {
  background: #ff5a1f;
  color: #fff;
}

.btn-atlas.ghost {
  background: #fff;
  color: #2b3645;
  border: 1px solid rgba(43, 54, 69, 0.18);
}

/* why card under */
.why-card {
  background: #eaf3ff;
  border-radius: 10px;
  padding: 18px 20px;
}

.why-card h3 {
  margin: 0 0 10px;
  font-size: 13px;
  font-weight: 900;
  color: #2b3645;
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
  font-size: 12px;
  font-weight: 700;
  color: rgba(43, 54, 69, 0.75);
}

.tick {
  color: #ff5a1f;
  font-weight: 900;
  margin-right: 10px;
}

/* responsive spacing */
@media (max-width: 576px) {
  .form-card {
    padding: 18px;
  }

  .stepLine {
    display: none;
  }
}
</style>
