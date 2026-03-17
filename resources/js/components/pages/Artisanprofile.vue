<template>
  <div class="profile-page">

    <!-- Back -->
    <div class="container-xxl px-3 px-md-5 pt-3">
      <button class="back-btn" @click="router.back()">← Retour à la liste</button>
    </div>

    <!-- Loading -->
    <div v-if="loading" class="container-xxl px-3 px-md-5 py-5">
      <div class="row g-4">
        <div class="col-lg-3">
          <div class="skel skel-block" style="height:420px;border-radius:16px"></div>
        </div>
        <div class="col-lg-9 d-flex flex-column gap-3">
          <div class="skel skel-block" style="height:120px;border-radius:16px"></div>
          <div class="skel skel-block" style="height:220px;border-radius:16px"></div>
          <div class="skel skel-block" style="height:180px;border-radius:16px"></div>
        </div>
      </div>
    </div>

    <!-- Error -->
    <div v-else-if="error" class="container-xxl px-3 px-md-5 py-5 text-center">
      <p class="text-muted fw-bold">{{ error }}</p>
      <button class="btn-orange" @click="fetchArtisan">Réessayer</button>
    </div>

    <!-- Content -->
    <div v-else-if="artisan" class="container-xxl px-3 px-md-5 py-4">
      <div class="row g-4">

        <!-- ══════════ LEFT SIDEBAR ══════════ -->
        <div class="col-lg-3">

          <!-- Identity card -->
          <div class="side-card text-center mb-3">
            <div class="avatar-wrap mx-auto mb-3">
              <img
                v-if="artisan.profile_photo"
                :src="artisan.profile_photo"
                :alt="artisan.name"
                class="avatar-img"
              />
              <div v-else class="avatar-placeholder">{{ initials(artisan.name) }}</div>
            </div>
            <h2 class="artisan-name">{{ artisan.name }}</h2>
            <p class="artisan-spec">{{ artisan.speciality || artisan.services?.[0] || 'Artisan' }}</p>
            <div class="artisan-city">
              <span class="city-pin">📍</span> {{ artisan.ville || '—' }}
            </div>
            <div v-if="artisan.is_verified" class="verified-badge mt-2">
              ✓ Profil vérifié
            </div>

            <div class="atelier-badge mt-2">
              🏠 Option dépôt en atelier disponible
            </div>

            <div class="action-btns mt-3 d-flex gap-2 justify-content-center">
              <button class="btn-icon green" title="Appeler">📞</button>
              <button class="btn-orange flex-fill" @click="contacter">Demandez maintenant.</button>
              <button class="btn-icon red" title="Urgence">🚨</button>
            </div>

            <div class="rating-block mt-3">
              <div class="d-flex align-items-center gap-2 mb-2">
                <span class="big-star">★</span>
                <span class="big-rating">{{ averageRating ?? formatRating(artisan.rating) }}</span>
                <span class="review-count text-muted">{{ reviews.length }} avis</span>
              </div>
              <div v-for="(pct, i) in ratingBars" :key="i" class="rating-bar-row">
                <span class="bar-label">{{ 5 - i }}</span>
                <div class="bar-track">
                  <div class="bar-fill" :style="{ width: pct + '%' }"></div>
                </div>
                <span class="bar-pct">{{ pct }}%</span>
              </div>
            </div>
          </div>

          <!-- Stats -->
          <div class="side-card mb-3">
            <div class="stats-title">Statistiques</div>
            <div class="stat-row">
              <span class="stat-label">Taux de réponse</span>
              <span class="stat-val">{{ artisan.response_rate || '98%' }}</span>
            </div>
            <div class="stat-row">
              <span class="stat-label">Temps de réponse</span>
              <span class="stat-val">{{ artisan.response_time || '2h' }}</span>
            </div>
            <div class="stat-row">
              <span class="stat-label">Projets complétés</span>
              <span class="stat-val">{{ artisan.projects_count || 0 }}</span>
            </div>
            <div class="stat-row">
              <span class="stat-label">Membre depuis</span>
              <span class="stat-val">{{ memberSince }}</span>
            </div>
          </div>

          <!-- Trust badges -->
          <div class="side-card trust-card">
            <div class="stats-title mb-3">Badges de confiance</div>
            <div class="trust-item">
              <span class="trust-icon green">✓</span>
              <div>
                <div class="trust-name">Identité vérifiée</div>
                <div class="trust-sub">Document officiel valide</div>
              </div>
            </div>
            <div class="trust-item">
              <span class="trust-icon blue">🏛</span>
              <div>
                <div class="trust-name">Profession licenciée</div>
                <div class="trust-sub">License professionnelle validée</div>
              </div>
            </div>
            <div class="trust-item">
              <span class="trust-icon orange">⚡</span>
              <div>
                <div class="trust-name">Réponse rapide</div>
                <div class="trust-sub">Répond en moins de 2h</div>
              </div>
            </div>
          </div>

        </div>

        <!-- ══════════ RIGHT CONTENT ══════════ -->
        <div class="col-lg-9">

          <!-- À propos -->
          <div class="content-card mb-4">
            <h3 class="section-title">À propos</h3>
            <p class="about-text">{{ artisan.description || 'Artisan professionnel à votre service.' }}</p>

            <div class="mt-3">
              <div class="section-sub mb-2">Type de services</div>
              <div class="d-flex flex-wrap gap-2">
                <span v-for="svc in (artisan.services || [])" :key="svc" class="service-tag">{{ svc }}</span>
                <span v-if="!artisan.services?.length" class="service-tag">{{ artisan.speciality || 'Artisan' }}</span>
              </div>
            </div>
          </div>

          <!-- Galerie -->
          <div class="content-card mb-4" v-if="artisan.portfolio_images?.length">
            <h3 class="section-title">Galerie de projets</h3>
            <div class="gallery-grid">
              <div
                v-for="(img, i) in artisan.portfolio_images"
                :key="i"
                class="gallery-item"
                @click="openGallery(i)"
              >
                <img :src="fullUrl(img)" :alt="'Photo ' + (i+1)" class="gallery-img" />
                <div class="gallery-overlay">🔍</div>
              </div>
            </div>
          </div>

          <!-- Certifications -->
          <div class="content-card mb-4">
            <h3 class="section-title">🎓 Certifications</h3>
            <div v-if="artisan.certifications?.length">
              <div v-for="(cert, i) in artisan.certifications" :key="i" class="cert-item">
                <span class="cert-icon">🎓</span>
                <div>
                  <div class="cert-name">{{ cert.name }}</div>
                  <div class="cert-date">Délivrée en {{ cert.year }}</div>
                </div>
              </div>
            </div>
            <div v-else>
              <div class="cert-item">
                <span class="cert-icon">🎓</span>
                <div>
                  <div class="cert-name">{{ artisan.diplome || 'Certification professionnelle' }}</div>
                  <div class="cert-date">Professionnel certifié</div>
                </div>
              </div>
            </div>
          </div>

          <!-- Réserver -->
          <div class="content-card mb-4">
            <h3 class="section-title">📅 Réserver un artisan</h3>
            <p class="text-muted small mb-3">Planifiez votre demande par date et heure</p>
            <div class="row g-3 mb-3">
              <div class="col-md-6">
                <label class="form-label-custom">📅 Sélectionner une date</label>
                <input type="date" v-model="bookDate" class="form-input-custom" :min="today" />
              </div>
              <div class="col-md-6">
                <label class="form-label-custom">🕐 Sélectionner une heure</label>
                <input type="time" v-model="bookTime" class="form-input-custom" />
              </div>
            </div>
            <div v-if="reservError"   class="alert-msg error   mb-2">{{ reservError }}</div>
            <div v-if="reservSuccess" class="alert-msg success mb-2">{{ reservSuccess }}</div>
            <button class="btn-orange w-100" @click="reserver" :disabled="reservLoading">
              <span v-if="reservLoading">⏳ Envoi en cours...</span>
              <span v-else>Demandez maintenant.</span>
            </button>
          </div>

          <!-- Paiement sécurisé -->
          <div class="content-card mb-4">
            <h3 class="section-title">🔒 Paiement sécurisé</h3>
            <p class="text-muted small mb-3">Vos paiements sont protégés par notre système d'entiercement.</p>
            <div class="payment-item">
              <span>💳</span>
              <div>
                <div class="pay-name">Carte bancaire</div>
                <div class="pay-sub">Visa, Mastercard, Amex</div>
              </div>
            </div>
            <div class="payment-item mt-2">
              <span>🛡</span>
              <div>
                <div class="pay-name">Protection Entiercement</div>
                <div class="pay-sub">Votre paiement est sécurisé. L'artisan reçoit le paiement uniquement après validation du travail.</div>
              </div>
            </div>
            <div class="payment-item mt-2">
              <span>🔄</span>
              <div>
                <div class="pay-name">Politique d'annulation</div>
                <div class="pay-sub">
                  • Annulation gratuite jusqu'à 24h avant<br>
                  • Frais de 25% entre 24h et 12h avant<br>
                  • Frais de 50% moins de 12h avant<br>
                  • Remboursement complet si l'artisan annule
                </div>
              </div>
            </div>
          </div>

          <!-- Avis clients -->
          <div class="content-card mb-4">
            <h3 class="section-title">Avis clients ({{ reviews.length }})</h3>

            <div v-if="reviews.length === 0" class="text-muted small py-3">Aucun avis pour le moment.</div>

            <div v-for="(rev, i) in reviews" :key="rev.id ?? i" class="review-item">
              <div class="rev-avatar">{{ rev.initials }}</div>
              <div class="rev-body">
                <div class="d-flex justify-content-between align-items-start">
                  <div>
                    <div class="rev-name">{{ rev.name }}</div>
                    <div class="rev-date">{{ rev.date }}</div>
                  </div>
                  <div class="rev-stars">
                    <span v-for="s in 5" :key="s" :class="s <= rev.rating ? 'star-on' : 'star-off'">★</span>
                  </div>
                </div>
                <p class="rev-text">{{ rev.comment }}</p>
              </div>
            </div>

            <!-- Formulaire avis -->
            <div class="leave-review mt-4">
              <div class="d-flex align-items-center gap-2 mb-2">
                <span class="form-label-custom mb-0">Note :</span>
                <span
                  v-for="s in 5" :key="s"
                  class="star-pick"
                  :class="s <= newNote ? 'star-on' : 'star-off'"
                  @click="newNote = s"
                >★</span>
              </div>
              <div v-if="avisError"   class="alert-msg error   mb-2">{{ avisError }}</div>
              <div v-if="avisSuccess" class="alert-msg success mb-2">{{ avisSuccess }}</div>
              <div class="d-flex gap-2">
                <input
                  v-model="newComment"
                  type="text"
                  class="review-input flex-fill"
                  placeholder="Laisser un commentaire..."
                  :disabled="avisLoading"
                />
                <button class="btn-send" @click="submitReview" :disabled="avisLoading">
                  <span v-if="avisLoading">⏳</span>
                  <span v-else>➤</span>
                </button>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>

    <!-- Gallery lightbox -->
    <div v-if="galleryOpen" class="lightbox" @click.self="galleryOpen = false">
      <button class="lb-close" @click="galleryOpen = false">✕</button>
      <button class="lb-prev" @click="galleryPrev">‹</button>
      <img :src="fullUrl(artisan.portfolio_images[galleryIndex])" class="lb-img" />
      <button class="lb-next" @click="galleryNext">›</button>
    </div>

  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'

const route  = useRoute()
const router = useRouter()

const artisanId = route.params.id
const API_BASE  = 'http://127.0.0.1:8000/api'

// ── State ──────────────────────────────────────────────
const artisan      = ref(null)
const loading      = ref(true)
const error        = ref(null)
const bookDate     = ref('')
const bookTime     = ref('00:00')
const galleryOpen  = ref(false)
const galleryIndex = ref(0)

// Réservation
const reservLoading = ref(false)
const reservSuccess = ref('')
const reservError   = ref('')

// Avis
const reviews      = ref([])
const newComment   = ref('')
const newNote      = ref(5)
const avisLoading  = ref(false)
const avisError    = ref('')
const avisSuccess  = ref('')

// Calculé dynamiquement depuis les vrais avis
const ratingBars = computed(() => {
  const total = reviews.value.length
  if (total === 0) return [0, 0, 0, 0, 0]
  return [5, 4, 3, 2, 1].map(star => {
    const count = reviews.value.filter(r => r.rating === star).length
    return Math.round((count / total) * 100)
  })
})

const averageRating = computed(() => {
  const total = reviews.value.length
  if (total === 0) return null
  const sum = reviews.value.reduce((acc, r) => acc + r.rating, 0)
  return (sum / total).toFixed(1)
})

const today = new Date().toISOString().split('T')[0]

// ── Token Sanctum ──────────────────────────────────────
function getToken() {
  return localStorage.getItem('token') || ''
}

// ── Fetch artisan ──────────────────────────────────────
async function fetchArtisan() {
  loading.value = true
  error.value   = null
  try {
    const res  = await fetch(`${API_BASE}/artisans`)
    if (!res.ok) throw new Error(`Erreur serveur (${res.status})`)
    const data = await res.json()
    const list = Array.isArray(data) ? data : (data.data ?? data.artisans ?? [])
    const found = list.find(a => String(a.id) === String(artisanId))
    if (!found) throw new Error('Artisan introuvable.')
    artisan.value = found
  } catch (e) {
    error.value = e.message
  } finally {
    loading.value = false
  }
}

// ── Fetch avis (public) ────────────────────────────────
async function fetchAvis() {
  try {
    const res  = await fetch(`${API_BASE}/artisans/${artisanId}/avis`)
    if (!res.ok) return
    const data = await res.json()
    reviews.value = (data.avis ?? []).map(a => ({
      id:       a.id,
      initials: initials(a.client?.name ?? 'U'),
      name:     a.client?.name ?? 'Utilisateur',
      date:     formatDate(a.created_at),
      rating:   a.note,
      comment:  a.commentaire ?? '',
    }))
  } catch (_) {}
}

// ── Réserver ───────────────────────────────────────────
async function reserver() {
  reservSuccess.value = ''
  reservError.value   = ''

  if (!bookDate.value || !bookTime.value) {
    reservError.value = 'Veuillez sélectionner une date et une heure.'
    return
  }
  if (!getToken()) {
    reservError.value = 'Vous devez être connecté pour réserver.'
    return
  }

  reservLoading.value = true
  try {
    const res = await fetch(`${API_BASE}/reservations`, {
      method:  'POST',
      headers: {
        'Content-Type':  'application/json',
        'Authorization': `Bearer ${getToken()}`,
        'Accept':        'application/json',
      },
      body: JSON.stringify({
        artisan_id: artisanId,
        date:       bookDate.value,
        heure:      bookTime.value,
      }),
    })

    const data = await res.json()

    if (!res.ok) {
      reservError.value = data.errors
        ? Object.values(data.errors).flat().join(' ')
        : (data.message ?? 'Erreur lors de la réservation.')
      return
    }

    reservSuccess.value = `✅ Réservation envoyée pour le ${bookDate.value} à ${bookTime.value} !`
    bookDate.value = ''
    bookTime.value = '00:00'
  } catch (_) {
    reservError.value = 'Erreur réseau. Veuillez réessayer.'
  } finally {
    reservLoading.value = false
  }
}

// ── Soumettre un avis ──────────────────────────────────
async function submitReview() {
  avisSuccess.value = ''
  avisError.value   = ''

  if (!newComment.value.trim()) {
    avisError.value = 'Le commentaire ne peut pas être vide.'
    return
  }
  if (!getToken()) {
    avisError.value = 'Vous devez être connecté pour laisser un avis.'
    return
  }

  avisLoading.value = true
  try {
    // 1. Récupérer les réservations du client
    const resR = await fetch(`${API_BASE}/reservations`, {
      headers: {
        'Authorization': `Bearer ${getToken()}`,
        'Accept':        'application/json',
      },
    })
    if (!resR.ok) throw new Error('Impossible de récupérer vos réservations.')
    const allReservations = await resR.json()

    // 2. Trouver une réservation terminée avec cet artisan sans avis
    const list = Array.isArray(allReservations) ? allReservations : (allReservations.data ?? [])
    const eligible = list.find(r =>
      String(r.artisan_id) === String(artisanId) &&
      r.statut === 'terminee' &&
      !r.avis
    )

    if (!eligible) {
      avisError.value = 'Vous devez avoir une réservation terminée avec cet artisan pour laisser un avis.'
      return
    }

    // 3. Soumettre l'avis
    const resA = await fetch(`${API_BASE}/reservations/${eligible.id}/avis`, {
      method:  'POST',
      headers: {
        'Content-Type':  'application/json',
        'Authorization': `Bearer ${getToken()}`,
        'Accept':        'application/json',
      },
      body: JSON.stringify({
        note:        newNote.value,
        commentaire: newComment.value.trim(),
      }),
    })

    const data = await resA.json()

    if (!resA.ok) {
      avisError.value = data.errors
        ? Object.values(data.errors).flat().join(' ')
        : (data.message ?? "Erreur lors de l'envoi de l'avis.")
      return
    }

    avisSuccess.value = '✅ Avis soumis avec succès !'
    newComment.value  = ''
    newNote.value     = 5
    await fetchAvis()
  } catch (e) {
    avisError.value = e.message || 'Erreur réseau.'
  } finally {
    avisLoading.value = false
  }
}

// ── Helpers ────────────────────────────────────────────
function initials(name = '') {
  return name.split(' ').map(w => w[0]).join('').toUpperCase().slice(0, 2) || 'U'
}
function formatRating(r) {
  const n = parseFloat(r)
  return isNaN(n) ? '—' : n.toFixed(1)
}
function fullUrl(path) {
  if (!path) return ''
  if (path.startsWith('http')) return path
  return `http://127.0.0.1:8000/${path}`
}
function formatDate(iso) {
  if (!iso) return ''
  return new Date(iso).toLocaleDateString('fr-FR', { day: '2-digit', month: 'short', year: 'numeric' })
}

const memberSince = computed(() => {
  if (!artisan.value?.created_at) return '2024'
  return new Date(artisan.value.created_at).getFullYear()
})

function contacter() { 


  router.push({ name: 'artisan-profile', params: { id: artisan.id } })




}
function openGallery(i) { galleryIndex.value = i; galleryOpen.value = true }
function galleryPrev() { galleryIndex.value = (galleryIndex.value - 1 + artisan.value.portfolio_images.length) % artisan.value.portfolio_images.length }
function galleryNext() { galleryIndex.value = (galleryIndex.value + 1) % artisan.value.portfolio_images.length }

onMounted(async () => {
  await fetchArtisan()
  await fetchAvis()
})
</script>

<style scoped>
.profile-page {
  padding-top:111px;
  background: #f7f8fa;
  min-height: 100vh;
  font-family: 'Segoe UI', 'Helvetica Neue', sans-serif;
  color: #1f2a44;
}

.back-btn {
  background: none;
  border: none;
  color: #1f2a44;
  font-weight: 800;
  font-size: 0.9rem;
  cursor: pointer;
  padding: 0;
  opacity: .7;
  transition: opacity .2s;
}
.back-btn:hover { opacity: 1; }

.side-card,
.content-card {
  background: #fff;
  border-radius: 16px;
  padding: 20px;
  box-shadow: 0 2px 16px rgba(0,0,0,0.07);
}

.avatar-wrap {
  width: 100px;
  height: 100px;
  border-radius: 50%;
  overflow: hidden;
  border: 3px solid rgba(255,90,23,0.4);
}
.avatar-img { width: 100%; height: 100%; object-fit: cover; }
.avatar-placeholder {
  width: 100%;
  height: 100%;
  background: rgba(255,90,23,0.1);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 2rem;
  font-weight: 900;
  color: #ff5a17;
}

.artisan-name { font-size: 1.1rem; font-weight: 900; color: #1f2a44; margin: 0 0 4px; }
.artisan-spec { font-size: 0.82rem; color: rgba(31,42,68,0.55); font-weight: 800; margin: 0 0 6px; }
.artisan-city { font-size: 0.82rem; color: rgba(31,42,68,0.7); font-weight: 700; }

.verified-badge {
  display: inline-block;
  background: rgba(34,197,94,0.1);
  color: #16a34a;
  font-size: 0.72rem;
  font-weight: 800;
  border-radius: 999px;
  padding: 4px 12px;
  border: 1px solid rgba(34,197,94,0.25);
}
.atelier-badge {
  display: inline-block;
  background: rgba(59,130,246,0.08);
  color: #1d4ed8;
  font-size: 0.7rem;
  font-weight: 800;
  border-radius: 999px;
  padding: 4px 12px;
  border: 1px solid rgba(59,130,246,0.2);
}

.btn-orange {
  background: #ff5a17;
  color: #fff;
  border: none;
  border-radius: 999px;
  padding: 10px 18px;
  font-weight: 900;
  font-size: 0.85rem;
  cursor: pointer;
  transition: background .2s;
}
.btn-orange:hover { background: #ff4a05; }
.btn-orange:disabled { opacity: 0.6; cursor: not-allowed; }

.btn-icon {
  width: 38px; height: 38px;
  border-radius: 50%;
  border: none;
  cursor: pointer;
  font-size: 1rem;
  display: grid;
  place-items: center;
}
.btn-icon.green { background: rgba(34,197,94,0.12); }
.btn-icon.red   { background: rgba(239,68,68,0.12); }

.rating-block { text-align: left; }
.big-star   { color: #ff5a17; font-size: 1.4rem; }
.big-rating { font-size: 1.4rem; font-weight: 900; color: #1f2a44; }
.review-count { font-size: 0.8rem; font-weight: 700; }

.rating-bar-row { display: flex; align-items: center; gap: 8px; margin-bottom: 4px; }
.bar-label { font-size: 0.75rem; font-weight: 800; width: 12px; }
.bar-track { flex: 1; height: 6px; background: #f0f0f0; border-radius: 999px; overflow: hidden; }
.bar-fill  { height: 100%; background: #1d4ed8; border-radius: 999px; transition: width .6s ease; }
.bar-pct   { font-size: 0.72rem; color: rgba(31,42,68,0.5); width: 30px; font-weight: 700; }

.stats-title { font-weight: 900; font-size: 0.95rem; color: #1f2a44; margin-bottom: 12px; }
.stat-row { display: flex; justify-content: space-between; padding: 7px 0; border-bottom: 1px solid #f0f0f0; font-size: 0.82rem; }
.stat-row:last-child { border-bottom: none; }
.stat-label { color: rgba(31,42,68,0.6); font-weight: 700; }
.stat-val   { font-weight: 900; color: #1f2a44; }

.trust-item { display: flex; align-items: flex-start; gap: 10px; margin-bottom: 12px; }
.trust-item:last-child { margin-bottom: 0; }
.trust-icon { width: 32px; height: 32px; border-radius: 50%; display: grid; place-items: center; font-size: 0.85rem; flex-shrink: 0; }
.trust-icon.green  { background: rgba(34,197,94,0.12);  color: #16a34a; }
.trust-icon.blue   { background: rgba(59,130,246,0.12); color: #1d4ed8; }
.trust-icon.orange { background: rgba(255,90,23,0.12);  color: #ff5a17; }
.trust-name { font-size: 0.82rem; font-weight: 900; color: #1f2a44; }
.trust-sub  { font-size: 0.72rem; color: rgba(31,42,68,0.5); font-weight: 700; }

.section-title { font-size: 1.05rem; font-weight: 900; color: #1f2a44; margin-bottom: 14px; padding-bottom: 10px; border-bottom: 2px solid #f0f0f0; }
.section-sub   { font-size: 0.82rem; font-weight: 900; color: rgba(31,42,68,0.6); }
.about-text    { font-size: 0.88rem; color: rgba(31,42,68,0.75); line-height: 1.7; font-weight: 600; }

.service-tag {
  background: rgba(255,90,23,0.08);
  color: #ff5a17;
  border: 1px solid rgba(255,90,23,0.2);
  border-radius: 999px;
  padding: 4px 14px;
  font-size: 0.78rem;
  font-weight: 800;
}

.gallery-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px; }
@media (max-width: 576px) { .gallery-grid { grid-template-columns: repeat(2, 1fr); } }
.gallery-item { position: relative; border-radius: 10px; overflow: hidden; cursor: pointer; aspect-ratio: 4/3; }
.gallery-img  { width: 100%; height: 100%; object-fit: cover; transition: transform .3s; }
.gallery-item:hover .gallery-img { transform: scale(1.06); }
.gallery-overlay { position: absolute; inset: 0; background: rgba(0,0,0,0); display: grid; place-items: center; font-size: 1.5rem; opacity: 0; transition: all .25s; }
.gallery-item:hover .gallery-overlay { background: rgba(0,0,0,0.35); opacity: 1; }

.cert-item { display: flex; align-items: center; gap: 12px; padding: 12px; background: #f8f9fa; border-radius: 10px; margin-bottom: 10px; }
.cert-icon { font-size: 1.2rem; }
.cert-name { font-size: 0.88rem; font-weight: 900; color: #1f2a44; }
.cert-date { font-size: 0.75rem; color: rgba(31,42,68,0.5); font-weight: 700; }

.form-label-custom  { display: block; font-size: 0.8rem; font-weight: 800; color: rgba(31,42,68,0.7); margin-bottom: 6px; }
.form-input-custom  { width: 100%; padding: 10px 14px; border: 1.5px solid #e8e8e8; border-radius: 10px; font-size: 0.88rem; font-weight: 700; color: #1f2a44; outline: none; transition: border .2s; }
.form-input-custom:focus { border-color: #ff5a17; }

.payment-item { display: flex; align-items: flex-start; gap: 12px; padding: 12px; border: 1px solid #f0f0f0; border-radius: 10px; font-size: 0.85rem; }
.pay-name { font-weight: 900; color: #1f2a44; }
.pay-sub  { font-size: 0.75rem; color: rgba(31,42,68,0.6); font-weight: 600; line-height: 1.6; margin-top: 2px; }

.review-item { display: flex; gap: 12px; padding: 14px 0; border-bottom: 1px solid #f0f0f0; }
.review-item:last-of-type { border-bottom: none; }
.rev-avatar { width: 38px; height: 38px; border-radius: 50%; background: rgba(255,90,23,0.12); color: #ff5a17; font-weight: 900; font-size: 0.9rem; display: grid; place-items: center; flex-shrink: 0; }
.rev-body  { flex: 1; }
.rev-name  { font-size: 0.88rem; font-weight: 900; color: #1f2a44; }
.rev-date  { font-size: 0.72rem; color: rgba(31,42,68,0.45); font-weight: 700; }
.rev-text  { font-size: 0.82rem; color: rgba(31,42,68,0.7); margin-top: 6px; line-height: 1.6; font-weight: 600; }
.star-on  { color: #f59e0b; }
.star-off { color: #e5e7eb; }

.star-pick { font-size: 1.4rem; cursor: pointer; transition: transform .15s; }
.star-pick:hover { transform: scale(1.2); }

.alert-msg { padding: 8px 14px; border-radius: 8px; font-size: 0.82rem; font-weight: 700; }
.alert-msg.success { background: rgba(34,197,94,0.1);  color: #16a34a; border: 1px solid rgba(34,197,94,0.25); }
.alert-msg.error   { background: rgba(239,68,68,0.08); color: #dc2626; border: 1px solid rgba(239,68,68,0.2); }

.review-input { padding: 10px 16px; border: 1.5px solid #e8e8e8; border-radius: 999px; font-size: 0.85rem; outline: none; font-weight: 600; color: #1f2a44; transition: border .2s; }
.review-input:focus { border-color: #ff5a17; }
.btn-send { width: 40px; height: 40px; border-radius: 50%; background: #ff5a17; color: #fff; border: none; cursor: pointer; font-size: 1rem; display: grid; place-items: center; }
.btn-send:hover { background: #ff4a05; }
.btn-send:disabled { opacity: 0.6; cursor: not-allowed; }

.lightbox { position: fixed; inset: 0; background: rgba(0,0,0,0.92); z-index: 9999; display: flex; align-items: center; justify-content: center; }
.lb-img   { max-width: 88vw; max-height: 88vh; border-radius: 12px; object-fit: contain; }
.lb-close, .lb-prev, .lb-next { position: absolute; background: rgba(255,255,255,0.12); border: none; color: #fff; cursor: pointer; border-radius: 50%; width: 44px; height: 44px; font-size: 1.4rem; display: grid; place-items: center; transition: background .2s; }
.lb-close { top: 20px; right: 20px; }
.lb-prev  { left: 20px; top: 50%; transform: translateY(-50%); }
.lb-next  { right: 20px; top: 50%; transform: translateY(-50%); }

.skel { background: linear-gradient(90deg, #f2f2f2 25%, #e8e8e8 50%, #f2f2f2 75%); background-size: 200% 100%; animation: shimmer 1.4s infinite; }
.skel-block { display: block; }
@keyframes shimmer { 0% { background-position: 200% 0; } 100% { background-position: -200% 0; } }
</style>