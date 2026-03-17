<template>
  <div class="demandes-page">

    <!-- ═══════════════════════════════════════
         VIEW: LIST (mes demandes)
    ════════════════════════════════════════ -->
    <div v-if="view === 'list'" class="container-xxl px-3 px-md-5 py-4">

      <!-- Header -->
      <div class="d-flex align-items-start align-items-md-center justify-content-between flex-column flex-md-row gap-3 mb-4">
        <div>
          <h1 class="page-title mb-1">Mes demandes</h1>
          <p class="page-sub">Gérez vos demandes de service et consultez les réponses des artisans</p>
        </div>
        <button class="btn-orange px-4" @click="startWizard">+ Nouvelle demande</button>
      </div>

      <!-- Filters -->
      <div class="filters-bar mb-4 d-flex flex-wrap align-items-center gap-2">
        <span class="filter-label">🔽 Filtrer par statut :</span>
        <button
          v-for="f in filters" :key="f.value"
          class="filter-btn"
          :class="{ active: activeFilter === f.value }"
          @click="activeFilter = f.value"
        >
          {{ f.label }} <span v-if="f.count !== undefined">({{ f.count }})</span>
        </button>
      </div>

      <!-- Loading -->
      <div v-if="loading" class="text-center py-5">
        <div class="spinner mx-auto"></div>
      </div>

      <!-- Error -->
      <div v-else-if="loadError" class="alert-msg error mb-3">⚠️ {{ loadError }}</div>

      <!-- Empty -->
      <div v-else-if="filteredRequests.length === 0" class="empty-state">
        <div class="empty-icon">📋</div>
        <p>Aucune demande trouvée.</p>
        <button class="btn-orange mt-2" @click="startWizard">Créer une demande</button>
      </div>

      <!-- Demande cards -->
      <div v-else class="d-flex flex-column gap-3">
        <div v-for="req in filteredRequests" :key="req.id" class="demande-card">

          <!-- Card header -->
          <div class="demande-header d-flex align-items-center justify-content-between flex-wrap gap-2"
               @click="toggleExpand(req.id)">
            <div class="d-flex align-items-center gap-3">
              <span class="demande-title">{{ req.service_name ?? req.category ?? 'Demande' }}</span>
              <span v-if="req.responses_count > 0" class="badge-responses">
                {{ req.responses_count }} réponse{{ req.responses_count > 1 ? 's' : '' }}
              </span>
            </div>
            <div class="d-flex align-items-center gap-2">
              <button class="icon-btn" title="Voir" @click.stop="viewRequest(req)">👁</button>
              <button class="icon-btn" title="Modifier" @click.stop>✏️</button>
              <button class="icon-btn danger" title="Supprimer" @click.stop="deleteRequest(req.id)">🗑</button>
              <span class="expand-arrow" :class="{ rotated: expanded.includes(req.id) }">▼</span>
            </div>
          </div>

          <!-- Card meta -->
          <div class="demande-meta d-flex flex-wrap gap-3">
            <span v-if="req.adresse || req.ville">📍 {{ req.adresse ?? req.ville }}</span>
            <span v-if="req.created_at">📅 {{ formatDate(req.created_at) }}</span>
            <span v-if="req.description" class="demande-desc">{{ req.description }}</span>
          </div>

          <!-- Expanded: artisan offers -->
          <div v-if="expanded.includes(req.id) && req.artisans?.length" class="artisans-section mt-3">
            <div class="artisans-title">Artisans ayant répondu ({{ req.artisans.length }})</div>
            <div class="row g-3 mt-1">
              <div v-for="artisan in req.artisans" :key="artisan.id" class="col-12 col-md-6 col-lg-4">
                <div class="artisan-offer-card">
                  <div class="d-flex align-items-center gap-2 mb-2">
                    <div class="art-avatar">{{ initials(artisan.name) }}</div>
                    <div>
                      <div class="art-name">{{ artisan.name }}</div>
                      <div class="art-spec">{{ artisan.speciality ?? 'Artisan' }}</div>
                      <div class="art-rating">
                        ⭐ {{ artisan.rating ?? '—' }}
                        <span class="text-muted small">({{ artisan.reviews_count ?? 0 }} avis)</span>
                      </div>
                    </div>
                  </div>
                  <div class="offer-row">
                    <div>
                      <div class="offer-label">Prix proposé</div>
                      <div class="offer-price">{{ artisan.prix_propose ? artisan.prix_propose + '€' : '—' }}</div>
                    </div>
                    <div>
                      <div class="offer-label">Durée estimée</div>
                      <div class="offer-duration">{{ artisan.duree_estimee ?? 'None' }}</div>
                    </div>
                  </div>
                  <div class="offer-time small text-muted mb-2">
                    ⏱ Répondu {{ artisan.responded_at ? 'il y a ' + formatTimeAgo(artisan.responded_at) : '—' }}
                  </div>
                  <div class="d-flex gap-2 mb-2">
                    <button class="btn-refuse flex-fill" @click="refuseOffer(artisan)">Refuser l'offre</button>
                    <button class="btn-accept flex-fill" @click="acceptOffer(artisan)">Accepter l'offre</button>
                  </div>
                  <div class="d-flex gap-2 justify-content-center">
                    <button class="art-action-btn" @click="goToMessages(artisan)">💬 Message</button>
                    <button class="art-action-btn">📞 Appel</button>
                    <button class="art-action-btn" @click="goToProfile(artisan)">👁 Profil</button>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>

    </div>

    <!-- ═══════════════════════════════════════
         VIEW: WIZARD (nouvelle demande)
    ════════════════════════════════════════ -->
    <div v-else class="container-xxl px-3 px-md-5 py-4">

      <!-- Back + title -->
      <div class="mb-3">
        <button class="back-btn" @click="view = 'list'">← Retour</button>
      </div>
      <h1 class="page-title mb-1">Nouvelle demande</h1>
      <p class="page-sub mb-4">
        Les meilleurs aide-ménagères de votre région seront automatiquement avertis et vous
        <span class="text-orange fw-bold">recevez différentes offres par mail dans les 4 heures</span>
      </p>

      <!-- Stepper -->
      <div class="stepper d-flex align-items-center justify-content-center mb-4">
        <div v-for="(s, i) in steps" :key="i" class="d-flex align-items-center">
          <div class="step-item text-center">
            <div class="step-circle" :class="{ active: wizardStep >= i+1, done: wizardStep > i+1 }">
              {{ i + 1 }}
            </div>
            <div class="step-label" :class="{ active: wizardStep >= i+1 }">{{ s }}</div>
          </div>
          <div v-if="i < steps.length - 1" class="step-line" :class="{ active: wizardStep > i+1 }"></div>
        </div>
      </div>

      <!-- ── STEP 1: Catégorie ── -->
      <div v-if="wizardStep === 1" class="wizard-card">
        <h3 class="wizard-title">Choisissez une catégorie</h3>
        <p class="wizard-sub">Sélectionnez la catégorie qui correspond à votre besoin</p>
        <div class="row g-3 mt-2">
          <div v-for="cat in categories" :key="cat.id" class="col-6 col-sm-4 col-md-3">
            <div
              class="cat-card"
              :class="{ selected: form.category_id === cat.id }"
              @click="form.category_id = cat.id; form.category_name = cat.name"
            >
              <div class="cat-icon" :style="{ background: cat.color }">
                <span>{{ cat.icon }}</span>
              </div>
              <div class="cat-name">{{ cat.name }}</div>
            </div>
          </div>
        </div>
        <button class="btn-orange w-100 mt-4" :disabled="!form.category_id" @click="wizardStep = 2">
          Continuer
        </button>
      </div>

      <!-- ── STEP 2: Services ── -->
      <div v-if="wizardStep === 2" class="wizard-card">
        <div class="d-flex align-items-center gap-3 mb-3">
          <div class="cat-icon-sm" :style="{ background: selectedCategory?.color }">
            <span>{{ selectedCategory?.icon }}</span>
          </div>
          <h3 class="wizard-title mb-0">{{ selectedCategory?.name }}</h3>
        </div>
        <h4 class="fw-bold mb-1">Choisissez les services</h4>
        <p class="wizard-sub mb-3">Sélectionnez un ou plusieurs services dans la catégorie</p>
        <div class="d-flex flex-column gap-2">
          <label
            v-for="svc in selectedCategory?.services ?? []"
            :key="svc"
            class="service-checkbox"
            :class="{ selected: form.services.includes(svc) }"
          >
            <input
              type="checkbox"
              :value="svc"
              v-model="form.services"
              class="visually-hidden"
            />
            <span class="check-box" :class="{ checked: form.services.includes(svc) }"></span>
            {{ svc }}
          </label>
        </div>
        <button class="btn-orange w-100 mt-4" :disabled="form.services.length === 0" @click="wizardStep = 3">
          Continuer
        </button>
      </div>

      <!-- ── STEP 3: Détails ── -->
      <div v-if="wizardStep === 3" class="wizard-card">
        <h3 class="wizard-title">Détails de votre demande</h3>
        <p class="wizard-sub mb-4">Fournissez les informations nécessaires pour que les artisans puissent vous faire une offre précise</p>

        <div class="form-group mb-3">
          <label class="form-lbl">🏠 Mode de prestation *</label>
          <select v-model="form.mode" class="form-ctrl">
            <option value="">Sélectionnez une mode de prestation</option>
            <option>À domicile</option>
            <option>En atelier</option>
            <option>À distance</option>
          </select>
        </div>

        <div class="form-group mb-3">
          <label class="form-lbl">📄 Description du travail *</label>
          <textarea v-model="form.description" class="form-ctrl" rows="4"
            placeholder="Décrivez en détail le travail à réaliser..."></textarea>
        </div>

        <div class="form-group mb-3">
          <label class="form-lbl">📍 Adresse *</label>
          <input v-model="form.adresse" type="text" class="form-ctrl"
            placeholder="Entrez votre adresse complète" />
        </div>


        <div class="form-group mb-3">
          <label class="form-lbl">ℹ️ Ville</label>
          <input v-model="form.ville" class="form-ctrl" 
            placeholder="Ecrire votre ville domicile">
        </div>


        <div class="form-group mb-3">
          <label class="form-lbl">ℹ️ Informations complémentaires</label>
          <textarea v-model="form.info_complementaire" class="form-ctrl" rows="3"
            placeholder="Ajoutez des informations qui peuvent aider l'artisan (accès, contraintes, horaires préférés...)"></textarea>
        </div>

        <div class="form-group mb-4">
          <label class="form-lbl">📷 Photos (optionnel)</label>
          <p class="wizard-sub mb-2">Ajoutez des photos pour mieux illustrer votre demande</p>
          <button class="btn-photo w-100" type="button" @click="$refs.photoInput.click()">
            📷 Ajouter des photos
          </button>
          <input ref="photoInput" type="file" accept="image/*" multiple class="d-none"
            @change="handlePhotos" />
          <div v-if="form.photos.length" class="d-flex flex-wrap gap-2 mt-2">
            <div v-for="(p, i) in form.photos" :key="i" class="photo-thumb">
              <img :src="p.preview" :alt="'photo ' + (i+1)" />
              <button class="photo-remove" @click="form.photos.splice(i,1)">✕</button>
            </div>
          </div>
        </div>

        <!-- Errors -->
        <div v-if="submitError" class="alert-msg error mb-3">⚠️ {{ submitError }}</div>
        <div v-if="submitSuccess" class="alert-msg success mb-3">✅ {{ submitSuccess }}</div>

        <div class="d-flex gap-3">
          <button class="btn-prev" @click="wizardStep = 2">Précédent</button>
          <button class="btn-orange flex-fill" :disabled="submitLoading" @click="submitDemande">
            <span v-if="submitLoading">⏳ Envoi...</span>
            <span v-else>Publier la demande</span>
          </button>
        </div>
      </div>

    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { useRouter } from 'vue-router'

const router   = useRouter()
const API_BASE = 'http://127.0.0.1:8000/api'

function getToken() { return localStorage.getItem('token') || '' }

// ── Views ──────────────────────────────────────────────
const view       = ref('list')   // 'list' | 'wizard'
const wizardStep = ref(1)
const steps      = ['Catégorie', 'Service', 'Détails']

// ── List state ──────────────────────────────────────────
const loading      = ref(false)
const loadError    = ref('')
const requests     = ref([])
const activeFilter = ref('all')
const expanded     = ref([])

// ── Form state ─────────────────────────────────────────
const form = ref({
  category_id:          null,
  category_name:        '',
  services:             [],
  mode:                 '',
  description:          '',
  adresse:              '',
  info_complementaire:  '',
  photos:               [],
})
const submitLoading = ref(false)
const submitError   = ref('')
const submitSuccess = ref('')
const photoInput    = ref(null)

// ── Categories (static list matching the design) ────────
const categories = [
  { id:1,  name:'Réparations générales',         icon:'🔧', color:'#4a4a6a', services:['Serrurerie','Vitrage','Plâtrerie','Carrelage'] },
  { id:2,  name:'Plomberie',                     icon:'💧', color:'#1e90ff', services:['Installation sanitaire','Réparation de fuites','Débouchage','Chauffe-eau','WC & Lavabo'] },
  { id:3,  name:'Électricité',                   icon:'⚡', color:'#f5a623', services:['Tableau électrique','Prises & Interrupteurs','Éclairage','Domotique'] },
  { id:4,  name:'Peinture',                      icon:'🖌️', color:'#9b59b6', services:['Peinture intérieure','Peinture extérieure','Enduit','Décoration'] },
  { id:5,  name:'Électroménager',                icon:'🔴', color:'#e74c3c', services:['Réfrigérateur','Lave-linge','Lave-vaisselle','Four'] },
  { id:6,  name:'Nettoyage',                     icon:'🧹', color:'#1abc9c', services:['Nettoyage maison','Nettoyage bureau','Vitres','Après travaux'] },
  { id:7,  name:'Déménagement',                  icon:'🚚', color:'#3498db', services:['Déménagement local','Déménagement national','Stockage','Montage meubles'] },
  { id:8,  name:'Chauffage, Ventilation et Climatisation', icon:'❄️', color:'#0dcaf0', services:['Climatisation','Chauffage','VMC','Pompe à chaleur'] },
  { id:9,  name:'Mécanicien Mobile',             icon:'🚗', color:'#2c3e50', services:['Vidange','Freins','Batterie','Diagnostic'] },
  { id:10, name:'Vidange Mobile',                icon:'🔶', color:'#e67e22', services:['Vidange huile','Filtre à air','Filtre à huile'] },
  { id:11, name:'Assistance Routière',           icon:'🆘', color:'#e74c3c', services:['Dépannage','Remorquage','Crevaison'] },
  { id:12, name:"Organisation d'Évènements",     icon:'🎊', color:'#ff6b9d', services:['Mariage','Anniversaire','Séminaire'] },
  { id:13, name:'Photographie',                  icon:'📷', color:'#8e44ad', services:['Portrait','Événement','Produit'] },
  { id:14, name:'Vidéographie',                  icon:'🎥', color:'#6c3483', services:['Mariage','Corporate','Clip'] },
  { id:15, name:'Musique & Animation',           icon:'🎵', color:'#e91e8c', services:['DJ','Live','Animation enfants'] },
  { id:16, name:'Beauté & Style',               icon:'💅', color:'#ff4081', services:['Coiffure','Maquillage','Onglerie'] },
  { id:17, name:'Services de Restauration',      icon:'🍽️', color:'#ff6b35', services:['Traiteur','Chef à domicile','Buffet'] },
  { id:18, name:"Décoration d'Évènements",       icon:'🎨', color:'#e91e63', services:['Fleurs','Ballons','Décoration salle'] },
  { id:19, name:'Location de Matériel',          icon:'📦', color:'#00897b', services:['Sono','Lumières','Tentes'] },
  { id:20, name:'Réparation Ordinateurs',        icon:'💻', color:'#1565c0', services:['Virus','Disque dur','Écran','Logiciel'] },
  { id:21, name:'Réseau & WiFi',                 icon:'📶', color:'#e53935', services:['Installation WiFi','Fibre','Câblage'] },
  { id:22, name:'Maison Connectée',              icon:'🏠', color:'#f57c00', services:['Caméras','Alarme','Domotique'] },
  { id:23, name:'Support Technique',             icon:'🎧', color:'#00695c', services:['Assistance PC','Formation','Téléassistance'] },
  { id:24, name:'Réparation Téléphones & Tablettes', icon:'📱', color:'#1976d2', services:['Écran cassé','Batterie','Logiciel'] },
  { id:25, name:'Lavage auto à domicile',        icon:'🚙', color:'#37474f', services:['Lavage extérieur','Intérieur','Polissage'] },
  { id:26, name:'Car Detailing',                 icon:'🚘', color:'#2e7d32', services:['Full détailing','Céramique','Jantes'] },
  { id:27, name:'Diagnostic OBD mobile',         icon:'🔌', color:'#7b1fa2', services:['Diagnostic','Effacement défauts','Rapport'] },
]

// ── Computed ───────────────────────────────────────────
const selectedCategory = computed(() =>
  categories.find(c => c.id === form.value.category_id)
)

const filters = computed(() => [
  { value: 'all',      label: 'Tous',      count: requests.value.length },
  { value: 'pending',  label: '⏳ En attente', count: requests.value.filter(r => r.statut === 'pending' || !r.statut).length },
  { value: 'accepted', label: '✅ Accepté',    count: requests.value.filter(r => r.statut === 'accepted').length },
  { value: 'refused',  label: '❌ Refusé',     count: requests.value.filter(r => r.statut === 'refused').length },
])

const filteredRequests = computed(() => {
  if (activeFilter.value === 'all') return requests.value
  return requests.value.filter(r => {
    if (activeFilter.value === 'pending')  return !r.statut || r.statut === 'pending'
    if (activeFilter.value === 'accepted') return r.statut === 'accepted'
    if (activeFilter.value === 'refused')  return r.statut === 'refused'
    return true
  })
})

// ── Fetch requests ─────────────────────────────────────
async function fetchRequests() {
  loading.value   = true
  loadError.value = ''
  try {
    const res  = await fetch(`${API_BASE}/requests`, {
      headers: { 'Authorization': `Bearer ${getToken()}`, 'Accept': 'application/json' }
    })
    const data = await res.json()
    if (!res.ok) { loadError.value = data.message ?? `Erreur ${res.status}`; return }
    const list = Array.isArray(data) ? data : (data.data ?? data.requests ?? [])
    requests.value = list.map(r => ({
      ...r,
      responses_count: r.responses_count ?? r.artisans?.length ?? 0,
      artisans: r.artisans ?? [],
    }))
  } catch (e) {
    loadError.value = 'Impossible de charger les demandes.'
  } finally {
    loading.value = false
  }
}

// ── Submit demande ─────────────────────────────────────
async function submitDemande() {
  submitError.value   = ''
  submitSuccess.value = ''

  if (!form.value.description.trim()) { submitError.value = 'La description est obligatoire.'; return }
  if (!form.value.adresse.trim())     { submitError.value = "L'adresse est obligatoire."; return }

  submitLoading.value = true
  try {
    const payload = {
      category_id:         form.value.category_id,
      service_name:        form.value.services.join(', '),
      mode_prestation:     form.value.mode,
      description:         form.value.description,
   ville : form.value.ville,
      adresse:             form.value.adresse,
      info_complementaire: form.value.info_complementaire,

    }

    const res = await fetch(`${API_BASE}/requests`, {
      method:  'POST',
      headers: {
        'Content-Type':  'application/json',
        'Authorization': `Bearer ${getToken()}`,
        'Accept':        'application/json',
      },
      body: JSON.stringify(payload),
    })
    const data = await res.json()

    if (!res.ok) {
      submitError.value = data.errors
        ? Object.values(data.errors).flat().join(' ')
        : (data.message ?? 'Erreur lors de la publication.')
      return
    }

    submitSuccess.value = '✅ Demande publiée avec succès !'
    resetForm()
    await fetchRequests()
    setTimeout(() => { view.value = 'list'; submitSuccess.value = '' }, 1500)

  } catch (_) {
    submitError.value = 'Erreur réseau. Veuillez réessayer.'
  } finally {
    submitLoading.value = false
  }
}

// ── Delete request ─────────────────────────────────────
async function deleteRequest(id) {
  if (!confirm('Supprimer cette demande ?')) return
  try {
    await fetch(`${API_BASE}/requests/${id}`, {
      method:  'DELETE',
      headers: { 'Authorization': `Bearer ${getToken()}` }
    })
    requests.value = requests.value.filter(r => r.id !== id)
  } catch (_) {}
}

// ── Helpers ────────────────────────────────────────────
function startWizard() {
  resetForm()
  wizardStep.value = 1
  view.value       = 'wizard'
}

function resetForm() {
  form.value = { category_id: null, category_name: '', services: [], mode: '',
    description: '', adresse: '', info_complementaire: '', photos: [] }
  wizardStep.value    = 1
  submitError.value   = ''
  submitSuccess.value = ''
}

function toggleExpand(id) {
  const idx = expanded.value.indexOf(id)
  if (idx === -1) expanded.value.push(id)
  else expanded.value.splice(idx, 1)
}

function handlePhotos(e) {
  const files = Array.from(e.target.files)
  files.forEach(f => {
    const reader = new FileReader()
    reader.onload = ev => form.value.photos.push({ file: f, preview: ev.target.result })
    reader.readAsDataURL(f)
  })
}

function initials(name = '') {
  return name.split(' ').map(w => w[0]).join('').toUpperCase().slice(0, 2) || '?'
}

function formatDate(iso) {
  if (!iso) return ''
  return new Date(iso).toLocaleDateString('fr-FR', { day: 'numeric', month: 'long', year: 'numeric' })
}

function formatTimeAgo(iso) {
  if (!iso) return ''
  const diff = Date.now() - new Date(iso)
  if (diff < 3600000)  return Math.floor(diff / 60000) + ' min'
  if (diff < 86400000) return Math.floor(diff / 3600000) + 'h'
  return Math.floor(diff / 86400000) + ' jour(s)'
}

function viewRequest(req)      { /* navigate to detail if needed */ }
function acceptOffer(artisan)  { alert('Offre acceptée : ' + artisan.name) }
function refuseOffer(artisan)  { alert('Offre refusée : ' + artisan.name) }
function goToMessages(artisan) { router.push('/messages') }
function goToProfile(artisan)  { router.push('/artisan/' + artisan.id) }

onMounted(fetchRequests)
</script>

<style scoped>
.demandes-page {
  padding-top: 111px;
  background: #f7f8fa;
  min-height: 100vh;
  font-family: 'Segoe UI', 'Helvetica Neue', sans-serif;
  color: #1f2a44;
}

/* ── Page header ─────────────────────────────── */
.page-title { font-size: 1.8rem; font-weight: 900; color: #1f2a44; margin: 0; }
.page-sub   { font-size: 0.88rem; color: rgba(31,42,68,0.6); font-weight: 600; margin: 0; }
.text-orange { color: #ff5a17; }

.back-btn {
  background: none; border: none;
  font-weight: 800; font-size: 0.9rem;
  color: #1f2a44; cursor: pointer;
  opacity: .7; padding: 0;
}
.back-btn:hover { opacity: 1; }

/* ── Buttons ─────────────────────────────────── */
.btn-orange {
  background: #ff5a17; color: #fff;
  border: none; border-radius: 10px;
  padding: 11px 20px; font-weight: 900;
  font-size: 0.88rem; cursor: pointer;
  transition: background .2s; white-space: nowrap;
}
.btn-orange:hover    { background: #ff4a05; }
.btn-orange:disabled { opacity: .6; cursor: not-allowed; }

.btn-prev {
  background: none; color: #1f2a44;
  border: 1.5px solid #e0e0e0;
  border-radius: 10px; padding: 11px 22px;
  font-weight: 800; font-size: 0.88rem;
  cursor: pointer; transition: border-color .2s;
}
.btn-prev:hover { border-color: #1f2a44; }

.btn-photo {
  border: 1.5px dashed #e0e0e0;
  background: #fafafa; border-radius: 10px;
  padding: 14px; font-weight: 700;
  font-size: 0.88rem; color: rgba(31,42,68,0.6);
  cursor: pointer; transition: border-color .2s;
}
.btn-photo:hover { border-color: #ff5a17; color: #ff5a17; }

/* ── Filters ─────────────────────────────────── */
.filters-bar  { font-size: 0.85rem; }
.filter-label { font-weight: 800; color: rgba(31,42,68,0.6); }
.filter-btn {
  padding: 6px 14px; border-radius: 999px;
  border: 1.5px solid #e0e0e0;
  background: #fff; font-weight: 700;
  font-size: 0.8rem; cursor: pointer;
  color: #1f2a44; transition: all .15s;
}
.filter-btn:hover  { border-color: #ff5a17; color: #ff5a17; }
.filter-btn.active { background: #ff5a17; color: #fff; border-color: #ff5a17; }

/* ── Demande card ────────────────────────────── */
.demande-card {
  background: #fff; border-radius: 16px;
  padding: 20px 24px;
  box-shadow: 0 2px 12px rgba(0,0,0,0.06);
}
.demande-header { cursor: pointer; }
.demande-title  { font-size: 1rem; font-weight: 900; color: #1f2a44; }
.badge-responses {
  background: rgba(255,90,23,0.1); color: #ff5a17;
  border-radius: 999px; padding: 2px 10px;
  font-size: 0.75rem; font-weight: 800;
}
.demande-meta {
  font-size: 0.8rem; color: rgba(31,42,68,0.55);
  font-weight: 700; margin-top: 8px;
}
.demande-desc {
  font-style: italic;
  color: rgba(31,42,68,0.7);
}
.icon-btn {
  width: 32px; height: 32px; border-radius: 8px;
  border: 1px solid #f0f0f0; background: #f7f8fa;
  cursor: pointer; font-size: 0.85rem;
  display: flex; align-items: center; justify-content: center;
  transition: background .15s;
}
.icon-btn:hover       { background: #fff0eb; }
.icon-btn.danger:hover { background: rgba(239,68,68,0.1); }
.expand-arrow {
  font-size: 0.75rem; opacity: .4;
  transition: transform .25s;
}
.expand-arrow.rotated { transform: rotate(180deg); }

/* ── Artisan offer card ──────────────────────── */
.artisans-title { font-size: 0.9rem; font-weight: 900; color: #1f2a44; }
.artisan-offer-card {
  background: #f7f8fa; border-radius: 12px;
  padding: 14px; border: 1px solid #f0f0f0;
}
.art-avatar {
  width: 44px; height: 44px; border-radius: 50%;
  background: rgba(255,90,23,0.12); color: #ff5a17;
  font-weight: 900; font-size: 0.9rem;
  display: flex; align-items: center; justify-content: center;
  flex-shrink: 0;
}
.art-name   { font-size: 0.88rem; font-weight: 900; color: #1f2a44; }
.art-spec   { font-size: 0.72rem; color: rgba(31,42,68,0.5); font-weight: 700; }
.art-rating { font-size: 0.75rem; color: #f59e0b; font-weight: 800; }

.offer-row  { display: flex; justify-content: space-between; background: #fff; border-radius: 8px; padding: 10px 12px; margin-bottom: 8px; }
.offer-label   { font-size: 0.7rem; color: rgba(31,42,68,0.45); font-weight: 700; }
.offer-price   { font-size: 1rem; font-weight: 900; color: #ff5a17; }
.offer-duration{ font-size: 0.9rem; font-weight: 800; color: #1f2a44; }

.btn-refuse {
  padding: 8px 10px; border-radius: 8px;
  border: 1.5px solid #ff5a17; background: #fff;
  color: #ff5a17; font-weight: 800; font-size: 0.78rem;
  cursor: pointer; transition: all .15s;
}
.btn-refuse:hover { background: #fff0eb; }
.btn-accept {
  padding: 8px 10px; border-radius: 8px;
  border: none; background: #ff5a17;
  color: #fff; font-weight: 800; font-size: 0.78rem;
  cursor: pointer; transition: background .15s;
}
.btn-accept:hover { background: #ff4a05; }
.art-action-btn {
  flex: 1; padding: 6px 4px; border-radius: 8px;
  border: 1px solid #e0e0e0; background: #fff;
  font-size: 0.72rem; font-weight: 700; color: #1f2a44;
  cursor: pointer; text-align: center;
  transition: background .15s;
}
.art-action-btn:hover { background: #f7f8fa; }

/* ── Stepper ─────────────────────────────────── */
.stepper { gap: 0; }
.step-item { min-width: 60px; }
.step-circle {
  width: 36px; height: 36px; border-radius: 50%;
  background: #e0e0e0; color: rgba(31,42,68,0.4);
  font-weight: 900; font-size: 0.9rem;
  display: flex; align-items: center; justify-content: center;
  margin: 0 auto 6px; transition: all .25s;
}
.step-circle.active { background: #ff5a17; color: #fff; }
.step-circle.done   { background: #ff5a17; color: #fff; }
.step-label {
  font-size: 0.72rem; font-weight: 700;
  color: rgba(31,42,68,0.4); transition: color .25s;
}
.step-label.active { color: #ff5a17; }
.step-line {
  width: 80px; height: 2px;
  background: #e0e0e0; margin-bottom: 22px;
  transition: background .25s;
}
.step-line.active { background: #ff5a17; }

/* ── Wizard card ─────────────────────────────── */
.wizard-card {
  background: #fff; border-radius: 16px;
  padding: 28px 32px;
  box-shadow: 0 2px 16px rgba(0,0,0,0.07);
  max-width: 860px; margin: 0 auto;
}
.wizard-title { font-size: 1.3rem; font-weight: 900; color: #1f2a44; margin: 0 0 4px; }
.wizard-sub   { font-size: 0.85rem; color: rgba(31,42,68,0.55); font-weight: 600; margin: 0; }

/* ── Category cards ──────────────────────────── */
.cat-card {
  border: 1.5px solid #e8e8e8; border-radius: 12px;
  padding: 14px 10px; text-align: center;
  cursor: pointer; transition: all .2s;
  background: #fff;
}
.cat-card:hover   { border-color: #ff5a17; background: #fff8f5; }
.cat-card.selected { border-color: #ff5a17; background: #fff8f5; box-shadow: 0 0 0 2px rgba(255,90,23,0.2); }
.cat-icon {
  width: 52px; height: 52px; border-radius: 14px;
  display: flex; align-items: center; justify-content: center;
  font-size: 1.4rem; margin: 0 auto 8px;
}
.cat-icon-sm {
  width: 40px; height: 40px; border-radius: 10px;
  display: flex; align-items: center; justify-content: center;
  font-size: 1.1rem; flex-shrink: 0;
}
.cat-name { font-size: 0.75rem; font-weight: 800; color: #1f2a44; line-height: 1.3; }

/* ── Service checkboxes ──────────────────────── */
.service-checkbox {
  display: flex; align-items: center; gap: 12px;
  padding: 14px 16px; border-radius: 10px;
  border: 1.5px solid #e8e8e8; cursor: pointer;
  font-weight: 700; font-size: 0.9rem; color: #1f2a44;
  transition: all .15s; background: #fff;
}
.service-checkbox:hover   { border-color: #ff5a17; background: #fff8f5; }
.service-checkbox.selected { border-color: #ff5a17; background: #fff8f5; }
.check-box {
  width: 20px; height: 20px; border-radius: 5px;
  border: 2px solid #d0d0d0; flex-shrink: 0;
  transition: all .15s; background: #fff;
  display: flex; align-items: center; justify-content: center;
}
.check-box.checked {
  background: #ff5a17; border-color: #ff5a17;
}
.check-box.checked::after {
  content: '✓'; color: #fff; font-size: 0.75rem; font-weight: 900;
}

/* ── Form controls ───────────────────────────── */
.form-lbl {
  display: block; font-size: 0.82rem;
  font-weight: 800; color: #1f2a44;
  margin-bottom: 6px;
}
.form-ctrl {
  width: 100%; padding: 11px 14px;
  border: 1.5px solid #e8e8e8; border-radius: 10px;
  font-size: 0.88rem; font-weight: 600; color: #1f2a44;
  outline: none; transition: border .2s;
  background: #fff; box-sizing: border-box;
  resize: vertical;
}
.form-ctrl:focus { border-color: #ff5a17; }

/* ── Photo thumbs ────────────────────────────── */
.photo-thumb {
  position: relative; width: 64px; height: 64px;
  border-radius: 8px; overflow: hidden;
}
.photo-thumb img { width: 100%; height: 100%; object-fit: cover; }
.photo-remove {
  position: absolute; top: 2px; right: 2px;
  width: 18px; height: 18px; border-radius: 50%;
  background: rgba(0,0,0,0.55); color: #fff;
  border: none; font-size: 0.6rem; cursor: pointer;
  display: flex; align-items: center; justify-content: center;
}

/* ── Alert messages ──────────────────────────── */
.alert-msg {
  padding: 10px 14px; border-radius: 8px;
  font-size: 0.85rem; font-weight: 700;
}
.alert-msg.success { background: rgba(34,197,94,0.1);  color: #16a34a; border: 1px solid rgba(34,197,94,0.25); }
.alert-msg.error   { background: rgba(239,68,68,0.08); color: #dc2626; border: 1px solid rgba(239,68,68,0.2); }

/* ── Empty state ─────────────────────────────── */
.empty-state {
  text-align: center; padding: 60px 20px;
  color: rgba(31,42,68,0.35);
}
.empty-icon { font-size: 3rem; margin-bottom: 12px; }
.empty-state p { font-size: 0.95rem; font-weight: 700; }

/* ── Spinner ─────────────────────────────────── */
.spinner {
  width: 36px; height: 36px;
  border: 3px solid #f0f0f0; border-top-color: #ff5a17;
  border-radius: 50%; animation: spin .7s linear infinite;
}
@keyframes spin { to { transform: rotate(360deg); } }

/* ── Responsive ──────────────────────────────── */
@media (max-width: 576px) {
  .wizard-card  { padding: 20px 16px; }
  .page-title   { font-size: 1.4rem; }
  .step-line    { width: 40px; }
  .demande-card { padding: 16px; }
}
</style>