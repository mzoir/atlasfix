<template>
  <div class="page" :style="{ backgroundImage: `linear-gradient(rgba(255,255,255,0.93)),url(${funfact1})` }">

    <!-- Phosphor Icons CDN -->
    <link rel="stylesheet" href="https://unpkg.com/@phosphor-icons/web@2.1.1/src/regular/style.css" />

    <div class="pt-3 ps-5 back-wrap">
      <button class="back-btn" type="button" @click="goBack">← Retour</button>
    </div>

    <div class="row justify-content-center">
      <div class="col-12 col-lg-8">

        <!-- Header -->
        <div class="text-center mb-4">
          <h1 class="head-title">Créer un compte Client</h1>
          <p class="head-sub">Rejoignez notre plateforme et trouvez les meilleurs artisans</p>
        </div>

        <!-- Formulaire -->
        <form class="formCard" @submit.prevent="submitClient">

          <!-- Nom -->
          <div class="mb-3">
            <label class="lblRow mb-2">
              <i class="f-ico ph ph-user"></i> Nom complet <b>*</b>
            </label>
            <input v-model.trim="client.nom" class="form-control inp" type="text"
                   placeholder="Ex: Ahmed El Amrani" required />
          </div>

          <!-- Email -->
          <div class="mb-3">
            <label class="lblRow mb-2">
              <i class="f-ico ph ph-envelope"></i> Adresse email <b>*</b>
            </label>
            <input v-model.trim="client.email" class="form-control inp" type="email"
                   placeholder="exemple@email.com" required />
          </div>

          <!-- Phone -->
          <div class="mb-3">
            <label class="lblRow mb-2">
              <i class="f-ico ph ph-phone"></i> Numéro de téléphone <b>*</b>
            </label>
            <input v-model.trim="client.phone" class="form-control inp" type="tel"
                   placeholder="06 XX XX XX XX" required />
          </div>

          <!-- Birth -->
          <div class="mb-3">
            <label class="lblRow mb-2">
              <i class="f-ico ph ph-calendar"></i> Date de naissance <b>*</b>
            </label>
            <div class="position-relative">
              <input
                v-model="client.birth"
                class="form-control inp pe-5"
                type="date"
                :max="maxBirthDate"
                required
              />
              <span class="rightIcon"><i class="ph ph-calendar"></i></span>
            </div>
            <small class="text-muted d-block mt-1">
              Sélectionnez votre date de naissance
            </small>
          </div>

          <!-- Ville -->
          <div class="mb-3">
            <label class="lblRow mb-2">
              <i class="f-ico ph ph-map-pin"></i> Ville <b>*</b>
            </label>
            <div class="position-relative">
              <select v-model="client.ville" class="form-select inp pe-5" required>
                <option value="" disabled>Ville</option>
                <option v-for="ville in villes" :key="ville">{{ ville }}</option>
              </select>
              <span class="rightIcon">▾</span>
            </div>
          </div>

          <!-- Adresse -->
          <div class="mb-3">
            <label class="lblRow mb-2">
              <i class="f-ico ph ph-house"></i> Adresse
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
              <i class="f-ico ph ph-lock"></i> Mot de passe <b>*</b>
            </label>
            <div class="position-relative">
              <input v-model="client.pass" class="form-control inp pe-5"
                     :type="showPass ? 'text' : 'password'"
                     placeholder="Minimum 6 caractères" minlength="6" required />
              <button class="eye" type="button" @click="showPass = !showPass">
                <i :class="showPass ? 'ph ph-eye-slash' : 'ph ph-eye'"></i>
              </button>
            </div>
          </div>

          <!-- Confirm Password -->
          <div class="mb-3">
            <label class="lblRow mb-2">
              <i class="f-ico ph ph-lock"></i> Confirmer le mot de passe <b>*</b>
            </label>
            <div class="position-relative">
              <input v-model="client.pass2" class="form-control inp pe-5"
                     :type="showPass2 ? 'text' : 'password'"
                     placeholder="Retapez votre mot de passe" minlength="6" required />
              <button class="eye" type="button" @click="showPass2 = !showPass2">
                <i :class="showPass2 ? 'ph ph-eye-slash' : 'ph ph-eye'"></i>
              </button>
            </div>
          </div>

          <!-- Terms -->
          <div class="terms mb-3">
            <input id="t" v-model="client.accept" type="checkbox" required />
            <label for="t">
              J'accepte les <span class="link">conditions générales d'utilisation</span> et la
              <span class="link">politique de confidentialité</span>
            </label>
          </div>

          <!-- Error message -->
          <div v-if="errorMsg" class="err-box mb-3">
            <span class="err-ico">⚠</span> {{ errorMsg }}
          </div>

          <!-- Submit -->
          <button class="submit w-100" type="submit" :disabled="loading">
            {{ loading ? "Création..." : "Créer mon compte" }}
          </button>

        </form>

        <!-- Why create an account -->
        <div class="why-box mt-3">
          <h3 class="why-title ps-4">Pourquoi créer un compte ?</h3>
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
</template>

<script>
import funfact1 from "@/assets/worker.jpg"

import { http } from "../api/http"

export default {
  data() {
    return {
      funfact1,
      errorMsg: '',
      client: {
        nom:     '',
        email:   '',
        phone:   '',
        birth:   '',
        ville:   '',
        address: '',
        pass:    '',
        pass2:   '',
        accept:  false
      },
      villes: [
        'Casablanca', 'Rabat', 'Fès', 'Marrakech', 'Tanger',
        'Agadir', 'Meknès', 'Oujda', 'Kénitra', 'Tétouan'
      ],
      showPass:     false,
      showPass2:    false,
      loading:      false,
      maxBirthDate: new Date().toISOString().split('T')[0]
    }
  },

  methods: {
    async submitClient() {
      this.errorMsg = ''

      // ── Client-side validation ──────────────────────
      if (!this.client.nom || !this.client.email || !this.client.phone || !this.client.birth || !this.client.ville) {
        this.errorMsg = "Veuillez remplir tous les champs obligatoires."
        return
      }
      if (this.client.pass.length < 6) {
        this.errorMsg = "Le mot de passe doit contenir au moins 6 caractères."
        return
      }
      if (this.client.pass !== this.client.pass2) {
        this.errorMsg = "Les mots de passe ne correspondent pas."
        return
      }
      if (!this.client.accept) {
        this.errorMsg = "Veuillez accepter les conditions générales d'utilisation."
        return
      }

      // ── POST /register/client ───────────────────────
      // Route::post('/register/client', [UserController::class, 'register'])
      this.loading = true
      try {
        const res = await http.post('/register/client', {
          name:                  this.client.nom,
          email:                 this.client.email,
          phone:                 this.client.phone,
          date_of_birth:         this.client.birth,
          ville:                 this.client.ville,
          adresse:               this.client.address,
          password:              this.client.pass,
          password_confirmation: this.client.pass2,
        })

        // Save token & user
        localStorage.setItem('token', res.data.token)
        if (res.data.user) {
          localStorage.setItem('user', JSON.stringify(res.data.user))
        }

        // Redirect home
        window.location.href = '/'

      } catch (e) {
        console.error(e)

        // Laravel returns validation errors as:
        // { message: "...", errors: { email: ["The email has already been taken."] } }
        if (e?.response?.data?.errors) {
          const firstError = Object.values(e.response.data.errors)[0]
          this.errorMsg = Array.isArray(firstError) ? firstError[0] : firstError
        } else {
          this.errorMsg = e?.response?.data?.message || "Une erreur est survenue, veuillez réessayer."
        }
      } finally {
        this.loading = false
      }
    },

    mockLocate() {
      this.client.address = "Adresse simulée via géolocalisation"
    },

    goBack() {
      window.history.back()
    }
  }
}
</script>

<style scoped>
/* ===== GENERAL ===== */
.page {
  position: relative;
  padding-top: 150px;
  padding-bottom: 50px;
  overflow: hidden;
  background-position: 60% top;
  background-repeat: no-repeat;
  background-size: cover;
  opacity: 0.98;
}

.back-wrap {
  position: relative;
  z-index: 2;
}

/* TOP LEFT */
.page::before {
  content: "";
  position: absolute;
  top: -100px;
  left: 0;
  width: 641px;
  height: 565px;
  opacity: 1;
  background:
    linear-gradient(180deg, #FFFFFF 0%, rgba(255,255,255,0) 60%, #FFFFFF 100%),
    url('@/assets/leftc.svg') no-repeat center;
  background-size: cover;
  z-index: 0;
}

/* BOTTOM RIGHT */
.page::after {
  content: "";
  position: absolute;
  bottom: 0;
  right: 0;
  width: 641px;
  height: 565px;
  background:
    linear-gradient(180deg, #FFFFFF 0%, rgba(255,255,255,0) 50%, #FFFFFF 100%),
    url('@/assets/rightc.svg') no-repeat center;
  background-size: cover;
  z-index: 0;
}

/* keep content above */
.formCard,
.head-title,
.head-sub,
.why-box {
  position: relative;
  z-index: 1;
}

/* Header */
.head-title {
  font-family: "Poppins";
  font-weight: 400;
  font-size: 48px;
  line-height: 48px;
  letter-spacing: -0.5px;
  text-align: center;
  color: rgba(49, 65, 88, 1);
  background: transparent;
  margin: 0;
}

.back-btn {
  display: block;
  padding-right: 865px;
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

.head-sub {
  font-family: Poppins;
  font-weight: 400;
  font-size: 20px;
  line-height: 28px;
  text-align: center;
  margin: 10px 0 0;
  color: #6f7f93;
}

/* FORM */
.formCard {
  background: #fff;
  border-radius: 18px;
  box-shadow: 0 20px 60px rgba(0, 0, 0, 0.18);
  padding: 22px;
  border: 1px solid rgba(0,0,0,0.06);
}

.lblRow {
  font-family: "Poppins", sans-serif;
  font-weight: 400;
  font-size: 17px;
  line-height: 24px;
  letter-spacing: -0.31px;
  color: rgba(49, 65, 88, 1);
  display: flex;
  align-items: center;
  gap: 8px;
}
.lblRow b { color: rgba(252, 90, 21, 1); }

.f-ico {
  color: #ff5a1f;
  font-size: 17px;
  flex-shrink: 0;
  width: 18px;
  text-align: center;
  line-height: 1;
}

.inp {
  font-family: "Poppins";
  font-weight: 400;
  font-size: 16px;
  line-height: 100%;
  letter-spacing: -0.31px;
  color: rgba(10, 10, 10, 0.5);
  height: 44px;
  border-radius: 10px;
  border: 1px solid #d7dee8;
}
.inp:focus {
  border-color: #ff5a1f;
  box-shadow: 0 0 0 3px rgba(255, 90, 31, 0.12);
}

.position-relative { position: relative; }

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
  color: #7b8aa0;
  opacity: 0.8;
}

.locBtn, .submit {
  height: 44px;
  border: 0;
  border-radius: 10px;
  background: #ff5a1f;
  color: #fff;
  font-weight: 900;
  cursor: pointer;
}

.submit {
  font-family: "Inter", sans-serif;
  font-weight: 400;
  font-size: 16px;
  line-height: 24px;
  letter-spacing: -0.31px;
  text-align: center;
  color: rgba(255, 255, 255, 1);
  height: 56px;
  box-shadow: 0 10px 26px rgba(255, 90, 31, 0.35);
}
.submit:disabled {
  opacity: 0.7;
  cursor: not-allowed;
}

/* ERROR BOX */
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
}
.err-ico {
  font-size: 16px;
  flex-shrink: 0;
}

/* Terms */
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
.link { color: #ff5a1f; font-weight: 800; }

/* WHY BOX */
.why-box {
  background: #eef4fb;
  border-radius: 18px;
  padding: 28px 0px;
}
.why-title {
  margin-bottom: 10px;
  font-family: "Inter", sans-serif;
  font-weight: 400;
  font-size: 16px;
  line-height: 24px;
  letter-spacing: -0.31px;
  color: rgba(49, 65, 88, 1);
}
.why-list li {
  padding: 4px;
  display: flex;
  align-items: center;
  gap: 10px;
  font-size: 15px;
}
.why-check {
  font-family: "Inter";
  font-weight: 400;
  font-size: 14px;
  line-height: 20px;
  letter-spacing: -0.15px;
  color: #ff5a1f;
  margin-right: 10px;
}

/* Responsive */
@media (max-width: 768px) {
  .formCard { padding: 16px; }
  .why-box  { padding: 20px 16px; }
  .back-btn { padding-right: 0; }
}
</style>