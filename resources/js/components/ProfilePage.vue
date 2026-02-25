<template>
  <section class="profile-page">
    <div class="container-xxl app-shell px-3 px-md-5">

      <!-- Top row: back + title + edit -->
      <div class="d-flex align-items-start justify-content-between gap-3 flex-wrap">
        <div>
          <button class="back-link" type="button" @click="goBack">← Retour</button>
          <h1 class="page-title mb-1">Mon profil</h1>
          <p class="page-sub mb-0">Gérez vos informations personnelles</p>
        </div>

        <button class="btn-edit" type="button" @click="toggleEdit">
          ✎ <span>{{ editing ? "Enregistrer" : "Modifier" }}</span>
        </button>
      </div>

      <div class="divider my-4"></div>

      <!-- Orange banner -->
      <div class="banner-card">
        <div class="row g-3 align-items-center">
          <!-- avatar -->
          <div class="col-12 col-md-auto">
            <div class="avatar-wrap">
              <img
                class="avatar-img"
                :src="profile.avatarUrl"
                alt="Avatar"
              />
              <button class="avatar-edit" type="button" v-if="editing" title="Changer la photo">
                ✎
              </button>
            </div>
          </div>

          <!-- main info -->
          <div class="col-12 col-md">
            <div class="name-row">
              <div class="banner-name">{{ profile.firstName }} {{ profile.lastName }}</div>
            </div>

            <div class="banner-lines">
              <div class="line">
                <span class="ico">✉</span>
                <span class="txt">{{ profile.email }}</span>
              </div>
              <div class="line">
                <span class="ico">☎</span>
                <span class="txt">{{ profile.phone }}</span>
              </div>
              <div class="line">
                <span class="ico">📍</span>
                <span class="txt">{{ profile.address }}, {{ profile.city }}</span>
              </div>
            </div>
          </div>

          <!-- stats -->
          <div class="col-12 col-md-auto">
            <div class="stats">
              <div class="stat">
                <div class="stat-ico">🕒</div>
                <div class="stat-num">{{ profile.requests }}</div>
                <div class="stat-lbl">Demandes</div>
              </div>
              <div class="stat">
                <div class="stat-ico">👤</div>
                <div class="stat-num">{{ profile.completed }}</div>
                <div class="stat-lbl">Projets terminés</div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Tabs -->
      <ul class="nav nav-tabs atlas-tabs mt-4" role="tablist">
        <li class="nav-item" role="presentation">
          <button
            class="nav-link"
            :class="{ active: tab === 'info' }"
            type="button"
            @click="tab='info'"
          >
            Informations personnelles
          </button>
        </li>
        <li class="nav-item" role="presentation">
          <button
            class="nav-link"
            :class="{ active: tab === 'prefs' }"
            type="button"
            @click="tab='prefs'"
          >
            Préférences
          </button>
        </li>
        <li class="nav-item" role="presentation">
          <button
            class="nav-link"
            :class="{ active: tab === 'security' }"
            type="button"
            @click="tab='security'"
          >
            Sécurité
          </button>
        </li>
      </ul>

      <!-- Content card -->
      <div class="content-card">
        <!-- INFO TAB -->
        <div v-if="tab === 'info'">
          <h3 class="card-h">Informations personnelles</h3>

          <div class="row g-3">
            <div class="col-12 col-md-6">
              <label class="f-label">Prénom</label>
              <input class="form-control f-inp" v-model.trim="profile.firstName" :disabled="!editing" />
            </div>

            <div class="col-12 col-md-6">
              <label class="f-label">Nom</label>
              <input class="form-control f-inp" v-model.trim="profile.lastName" :disabled="!editing" />
            </div>

            <div class="col-12 col-md-6">
              <label class="f-label">Email</label>
              <input class="form-control f-inp" type="email" v-model.trim="profile.email" :disabled="true" />
            </div>

            <div class="col-12 col-md-6">
              <label class="f-label">Téléphone</label>
              <input class="form-control f-inp" v-model.trim="profile.phone" :disabled="!editing" />
            </div>

            <div class="col-12 col-md-6">
              <label class="f-label">Adresse</label>
              <input class="form-control f-inp" v-model.trim="profile.address" :disabled="!editing" />
            </div>

            <div class="col-12 col-md-6">
              <label class="f-label">Ville</label>
              <input class="form-control f-inp" v-model.trim="profile.city" :disabled="!editing" />
            </div>

            <div class="col-12 col-md-6">
              <label class="f-label">Code postal</label>
              <input class="form-control f-inp" v-model.trim="profile.zip" :disabled="!editing" />
            </div>

            <!-- ✅ Date picker same as we did -->
            <div class="col-12 col-md-6">
              <label class="f-label">Date de naissance</label>
              <input
                class="form-control f-inp"
                type="date"
                v-model="profile.birth"
                :max="maxBirthDate"
                :disabled="!editing"
              />
            </div>
          </div>
        </div>

        <!-- PREFS TAB -->
        <div v-else-if="tab === 'prefs'">
          <h3 class="card-h">Préférences</h3>
          <div class="text-muted small">À compléter حسب ما تحتاج.</div>
        </div>

        <!-- SECURITY TAB -->
        <div v-else>
          <h3 class="card-h">Sécurité</h3>
          <div class="text-muted small">À compléter: تغيير كلمة المرور…</div>
        </div>
      </div>

      <div class="pb-4"></div>
    </div>
  </section>
</template>

<script setup>
import { reactive, ref, onMounted } from "vue"
import { useRouter } from "vue-router"
import axios from "axios"

const router = useRouter()

const API_BASE = import.meta.env.VITE_API_BASE_URL || "http://127.0.0.1:8000"

const tab = ref("info")
const editing = ref(false)
const loading = ref(false)

const maxBirthDate = new Date().toISOString().split("T")[0]

const profile = reactive({
  avatarUrl: "",
  firstName: "",
  lastName: "",
  email: "",
  phone: "",
  address: "",
  city: "",
  zip: "",
  birth: "",      // yyyy-mm-dd
  requests: 0,
  completed: 0,
})

function authHeaders() {
  const token = localStorage.getItem("token")
  if (!token) return null
  return { Authorization: `Bearer ${token}`, Accept: "application/json" }
}

/** Split "name" from google into first/last if you don't store them separately */
function splitName(fullName = "") {
  const parts = (fullName || "").trim().split(/\s+/)
  const first = parts.shift() || ""
  const last = parts.join(" ")
  return { first, last }
}

/** ✅ Load REAL user from Laravel (Google or normal) */
async function loadProfile() {
  const headers = authHeaders()
  if (!headers) {
    router.push("/login")
    return
  }

  loading.value = true
  try {
    // ✅ IMPORTANT: you need this endpoint in Laravel
    // return user + profile fields
    const res = await axios.get(`${API_BASE}/api/me`, { headers })

    const u = res.data?.user || res.data // depending on your response

    // avatar (Google provides picture usually)
    profile.avatarUrl = u?.avatar_url || u?.photo || u?.picture || ""

    // name (if backend returns name only)
    if (u?.first_name || u?.last_name) {
      profile.firstName = u.first_name || ""
      profile.lastName = u.last_name || ""
    } else {
      const { first, last } = splitName(u?.name || "")
      profile.firstName = first
      profile.lastName = last
    }

    profile.email = u?.email || ""
    profile.phone = u?.phone || ""
    profile.address = u?.address || u?.adresse || ""
    profile.city = u?.city || u?.ville || ""
    profile.zip = u?.zip || u?.code_postal || ""

    // birth should be yyyy-mm-dd for input type="date"
    profile.birth = (u?.date_of_birth || u?.birth || "").slice(0, 10)

    // stats if your backend provides them
    profile.requests = u?.requests_count ?? u?.requests ?? 0
    profile.completed = u?.completed_count ?? u?.completed ?? 0
  } catch (e) {
    // token invalid => back to login
    localStorage.removeItem("token")
    router.push("/login")
  } finally {
    loading.value = false
  }
}

/** ✅ Save profile to Laravel */
async function saveProfile() {
  const headers = authHeaders()
  if (!headers) return router.push("/login")

  // adjust payload to match your DB columns
  const payload = {
    first_name: profile.firstName,
    last_name: profile.lastName,
    phone: profile.phone,
    address: profile.address,
    city: profile.city,
    zip: profile.zip,
    date_of_birth: profile.birth, // yyyy-mm-dd
  }

  await axios.put(`${API_BASE}/api/profile`, payload, { headers })
}

/** UI */
function goBack() {
  router.back()
}

async function toggleEdit() {
  try {
    if (!editing.value) {
      // enter edit mode
      editing.value = true
      return
    }

    // leaving edit mode => save
    await saveProfile()
    editing.value = false
    alert("Profil mis à jour ✅")
  } catch (e) {
    alert(e?.response?.data?.message || "Erreur lors de la mise à jour ❌")
  }
}

onMounted(loadProfile)
</script>





<style scoped>
/* keep space under fixed header (your header is 102px) */
.profile-page{
  padding-top: 102px;
  padding-bottom: 12px;
  background: #fbf7f2;
}

/* top */
.back-link{
  background: transparent;
  border: 0;
  color: rgba(0,0,0,0.55);
  font-weight: 900;
  cursor: pointer;
  padding: 0;
}
.page-title{
  margin: 6px 0 0;
  font-weight: 900;
  color: #1f2a44;
  font-size: clamp(26px, 3.2vw, 34px);
}
.page-sub{
  color: rgba(31,42,68,0.6);
  font-weight: 700;
}

/* edit button */
.btn-edit{
  height: 44px;
  padding: 0 18px;
  border-radius: 12px;
  border: 0;
  background: #ff5a1f;
  color: #fff;
  font-weight: 900;
  display: inline-flex;
  align-items: center;
  gap: 10px;
  box-shadow: 0 12px 24px rgba(255,90,31,0.28);
  cursor: pointer;
}

.divider{
  height: 1px;
  background: rgba(0,0,0,0.08);
}

/* banner */
.banner-card{
  border-radius: 18px;
  padding: 18px 18px;
  color: #fff;
  background: linear-gradient(90deg, #ff7b32 0%, #ff5a1f 55%, #ff3d00 100%);
  box-shadow: 0 18px 50px rgba(0,0,0,0.12);
}

/* avatar */
.avatar-wrap{
  width: 96px;
  height: 96px;
  border-radius: 999px;
  border: 4px solid rgba(255,255,255,0.7);
  overflow: hidden;
  position: relative;
  margin-inline: auto;
}
.avatar-img{
  width: 100%;
  height: 100%;
  object-fit: cover;
}
.avatar-edit{
  position: absolute;
  right: 8px;
  bottom: 8px;
  width: 30px;
  height: 30px;
  border-radius: 999px;
  border: 0;
  background: rgba(255,255,255,0.9);
  color: #ff5a1f;
  font-weight: 900;
  cursor: pointer;
}

/* banner text */
.banner-name{
  font-weight: 900;
  font-size: 22px;
  line-height: 1.1;
}
.banner-lines{
  margin-top: 10px;
  display: flex;
  flex-direction: column;
  gap: 6px;
}
.line{
  display: flex;
  gap: 10px;
  align-items: center;
  opacity: 0.95;
}
.ico{
  width: 18px;
  display: inline-flex;
  justify-content: center;
}
.txt{
  font-weight: 700;
  font-size: 13px;
}

/* stats */
.stats{
  display: flex;
  gap: 14px;
  justify-content: center;
}
.stat{
  width: 110px;
  border-radius: 14px;
  background: rgba(255,255,255,0.16);
  border: 1px solid rgba(255,255,255,0.25);
  padding: 12px 10px;
  text-align: center;
}
.stat-ico{
  width: 38px;
  height: 38px;
  border-radius: 12px;
  background: rgba(255,255,255,0.22);
  display: inline-flex;
  align-items: center;
  justify-content: center;
  margin-bottom: 8px;
}
.stat-num{
  font-weight: 900;
  font-size: 20px;
  line-height: 1;
}
.stat-lbl{
  font-weight: 800;
  font-size: 11px;
  opacity: 0.9;
  margin-top: 6px;
}

/* tabs */
.atlas-tabs{
  border-bottom: 1px solid rgba(0,0,0,0.10);
}
.atlas-tabs .nav-link{
  border: 0;
  color: rgba(31,42,68,0.65);
  font-weight: 900;
  padding: 12px 18px;
}
.atlas-tabs .nav-link.active{
  color: #ff5a1f;
  border-bottom: 3px solid #ff5a1f;
  background: transparent;
}

/* content */
.content-card{
  background: #fff;
  border-radius: 14px;
  padding: 18px;
  box-shadow: 0 18px 45px rgba(0,0,0,0.08);
  border: 1px solid rgba(0,0,0,0.06);
}
.card-h{
  margin: 0 0 14px;
  font-weight: 900;
  color: #243044;
  font-size: 16px;
}

/* inputs */
.f-label{
  font-size: 12px;
  font-weight: 800;
  color: #2b3645;
  margin-bottom: 6px;
}
.f-inp{
  height: 44px;
  border-radius: 10px;
  border: 1px solid #d7dee8;
  font-weight: 700;
  font-size: 13px;
}
.f-inp:focus{
  border-color:#ff5a1f;
  box-shadow: 0 0 0 3px rgba(255,90,31,0.12);
}

/* responsive tweaks */
@media (max-width: 576px){
  .banner-card{ padding: 16px; }
  .stats{ justify-content: flex-start; }
  .stat{ width: 48%; }
}
</style>
