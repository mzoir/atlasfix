<template>
  <section class="best-sec py-5">
    <div class="container-xxl app-shell px-3 px-md-5 text-center">

      <h2 class="best-title mb-2">Nos artisans les mieux notés</h2>
      <p class="best-sub mb-4">
        Des professionnels bien notés, prêts à vous aider dans vos projets.
      </p>

      <!-- Loading skeletons -->
      <div v-if="loading" class="position-relative">
        <div class="track">
          <div class="row flex-nowrap g-4 m-0">
            <div class="col-11 col-sm-7 col-lg-4 p-0" v-for="i in 4" :key="i">
              <article class="aCard h-100">
                <div class="aTop d-flex gap-3">
                  <div class="aAvatar skel"></div>
                  <div class="aMeta text-start d-flex flex-column gap-2 pt-1">
                    <div class="skel skel-line long"></div>
                    <div class="skel skel-line medium"></div>
                    <div class="skel skel-line short"></div>
                    <div class="skel skel-line short"></div>
                  </div>
                </div>
                <div class="aBody text-start mt-3 d-flex flex-column gap-2">
                  <div class="skel skel-line long"></div>
                  <div class="skel skel-line long"></div>
                  <div class="skel skel-line medium"></div>
                  <div class="skel skel-line long"></div>
                  <div class="skel skel-line medium"></div>
                </div>
              </article>
            </div>
          </div>
        </div>
      </div>

      <!-- Error -->
      <div v-else-if="error" class="py-5 text-center">
        <p style="color:rgba(31,42,68,0.55); font-weight:800;">{{ error }}</p>
        <button class="btnP solid px-4" style="width:auto; height:38px; border-radius:999px;" @click="fetchArtisans">Réessayer</button>
      </div>

      <!-- Cards -->
      <div v-else class="position-relative">

        <!-- arrows -->
        <button class="navA left d-none d-lg-grid" type="button" aria-label="Prev" @click="scroll(-1)">‹</button>
        <button class="navA right d-none d-lg-grid" type="button" aria-label="Next" @click="scroll(1)">›</button>

        <!-- track -->
        <div ref="track" class="track" @scroll="onScroll">
          <div class="row flex-nowrap g-4 m-0">
            <div class="col-11 col-sm-7 col-lg-4 p-0" v-for="a in artisans" :key="a.id">
              <article class="aCard h-100">

                <!-- header -->
                <div class="aTop d-flex gap-3">
                  <div class="aAvatar-wrap">
                    <img
                      v-if="a.profile_photo || a.photo"
                      :src="a.profile_photo || a.photo"
                      :alt="a.name"
                      class="aAvatar aAvatar-img"
                      @error="onImgError"
                    />
                    <div v-else class="aAvatar aAvatar-placeholder">
                      {{ initials(a.name || a.first_name) }}
                    </div>
                  </div>

                  <div class="aMeta text-start">
                    <div class="d-flex align-items-center gap-2">
                      <div class="aName">{{ a.name || (a.first_name + ' ' + a.last_name) }}</div>
                      <span v-if="a.verified || a.is_verified" class="verify">✓</span>
                    </div>

                    <div class="aSpec">{{ a.specialty || a.service || a.metier || 'Artisan' }}</div>

                    <div class="aLoc d-flex align-items-center gap-2">
                      <span class="pin">⦿</span>
                      <span>{{ a.city || a.ville || '—' }}</span>
                    </div>

                    <div class="aRate d-flex align-items-center gap-2">
                      <span class="star">★</span>
                      <span class="rateTxt">{{ formatRating(a.rating) }}/5</span>
                      <span class="rateSmall">({{ a.reviews_count || a.avis_count || 0 }} avis)</span>
                    </div>
                  </div>
                </div>

                <!-- body -->
                <div class="aBody text-start">
                  <div class="aAbout">À propos</div>
                  <p class="aDesc">
                    {{ a.about || a.description || a.bio || 'Artisan professionnel à votre service.' }}
                  </p>

                  <div class="aLast" v-if="a.last_review">
                    <div class="aLastTitle">Dernier avis — {{ a.last_review.author }} {{ a.last_review.rating }}/5</div>
                    <div class="aLastTime">{{ a.last_review.date }}</div>
                    <div class="aLastGood">{{ a.last_review.comment }}</div>
                  </div>
                  <div class="aLast" v-else>
                    <div class="aLastTitle">Dernier avis de Michael 5/5</div>
                    <div class="aLastTime">Mardi à 14h</div>
                    <div class="aLastGood">Excellent travail</div>
                  </div>
                </div>

                <!-- buttons -->
                <div class="aBtns d-flex gap-2">
                  <button class="btnP ghost flex-fill" type="button" @click="voirProfil(a)">Voir le profil</button>
                  <button class="btnP solid flex-fill" type="button">Contacter</button>
                </div>

              </article>
            </div>
          </div>
        </div>

        <!-- dots reactive -->
        <div class="dots mt-4 d-flex justify-content-center gap-2">
          <span
            v-for="(a, i) in artisans"
            :key="i"
            class="dot"
            :class="{ active: i === activeDot }"
            @click="scrollToIndex(i)"
            style="cursor:pointer"
          ></span>
        </div>

      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'
const router = useRouter()

const API_BASE = 'http://127.0.0.1:8000/api'

const track     = ref(null)
const artisans  = ref([])
const loading   = ref(true)
const error     = ref(null)
const activeDot = ref(0)

/* ── Fetch ──────────────────────────────────────────── */
async function fetchArtisans() {
  loading.value = true
  error.value   = null
  try {
    const res  = await fetch(`${API_BASE}/artisans`)
    if (!res.ok) throw new Error(`Erreur serveur (${res.status})`)
    const data = await res.json()

    const list = Array.isArray(data) ? data : (data.data ?? data.artisans ?? [])

    artisans.value = [...list]
      .sort((a, b) => (parseFloat(b.rating) || 0) - (parseFloat(a.rating) || 0))
      .slice(0, 4)
  } catch (e) {
    error.value = e.message || 'Impossible de charger les artisans.'
  } finally {
    loading.value = false
  }
}

/* ── Scroll helpers ─────────────────────────────────── */
function scroll(dir) {
  if (!track.value) return
  track.value.scrollBy({ left: dir * 380, behavior: 'smooth' })
}

function scrollToIndex(i) {
  if (!track.value) return
  const card = track.value.querySelector('.col-11')
  if (!card) return
  track.value.scrollTo({ left: i * (card.offsetWidth + 24), behavior: 'smooth' })
}

function onScroll() {
  if (!track.value) return
  const card = track.value.querySelector('.col-11')
  if (!card) return
  activeDot.value = Math.round(track.value.scrollLeft / (card.offsetWidth + 24))
}

/* ── Helpers ────────────────────────────────────────── */
function initials(name = '') {
  return name.split(' ').map(w => w[0]).join('').toUpperCase().slice(0, 2) || 'A'
}

function formatRating(r) {
  const n = parseFloat(r)
  return isNaN(n) ? '—' : n.toFixed(1)
}

function onImgError(e) {
  e.target.style.display = 'none'
}

function voirProfil(artisan) {
  router.push({ name: 'artisan-profile', params: { id: artisan.id } })
}

onMounted(fetchArtisans)
</script>

<style scoped>
.best-sec {
  background: #fff;
}

/* title */
.best-title {
  font-weight: 900;
  font-size: clamp(28px, 3vw, 44px);
  color: #111;
}
.best-sub {
  color: rgba(0,0,0,0.55);
  font-weight: 700;
}

/* track */
.track {
  overflow-x: auto;
  overflow-y: hidden;
  scroll-behavior: smooth;
  -webkit-overflow-scrolling: touch;
  padding: 10px 4px;
  scrollbar-width: none;
}
.track::-webkit-scrollbar { display: none; }

/* card */
.aCard {
  background: #fff;
  border-radius: 16px;
  box-shadow: 0 14px 30px rgba(0,0,0,0.12);
  padding: 18px;
  display: flex;
  flex-direction: column;
  min-height: 430px;
}

/* avatar */
.aAvatar-wrap {
  flex: 0 0 auto;
}
.aAvatar {
  width: 92px;
  height: 92px;
  border-radius: 999px;
  background: #f2f2f2;
  border: 2px solid rgba(255,90,23,0.55);
}
.aAvatar-img {
  object-fit: cover;
}
.aAvatar-placeholder {
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.4rem;
  font-weight: 900;
  color: #ff5a17;
  background: rgba(255,90,23,0.08);
}

.aMeta { flex: 1; }

.aName {
  font-weight: 900;
  color: #1f2a44;
}
.verify {
  width: 18px;
  height: 18px;
  border-radius: 999px;
  background: rgba(0,120,255,0.12);
  color: #1a73e8;
  display: grid;
  place-items: center;
  font-size: 12px;
  font-weight: 900;
}

.aSpec {
  margin-top: 2px;
  font-size: 12px;
  color: rgba(31,42,68,0.55);
  font-weight: 800;
}
.aLoc {
  margin-top: 6px;
  font-size: 13px;
  color: rgba(31,42,68,0.75);
  font-weight: 800;
}
.pin { font-size: 12px; opacity: .7; }

.aRate {
  margin-top: 6px;
  font-size: 13px;
  font-weight: 900;
}
.star { color: #ff5a17; }
.rateTxt { color: rgba(31,42,68,0.85); }
.rateSmall { color: rgba(31,42,68,0.55); font-weight: 800; }

/* body */
.aBody {
  margin-top: 14px;
  flex: 1;
  display: flex;
  flex-direction: column;
}
.aAbout {
  font-weight: 900;
  color: rgba(31,42,68,0.9);
  margin-bottom: 8px;
}
.aDesc {
  color: rgba(31,42,68,0.62);
  font-weight: 700;
  font-size: 12px;
  line-height: 1.6;
  height: 130px;
  overflow: hidden;
}

.aLast { margin-top: 10px; font-size: 12px; }
.aLastTitle { color: rgba(31,42,68,0.85); font-weight: 900; }
.aLastTime  { margin-top: 4px; color: rgba(31,42,68,0.55); font-weight: 800; }
.aLastGood  { margin-top: 4px; color: #0a8f2a; font-weight: 900; }

/* buttons */
.aBtns { margin-top: 14px; }
.btnP {
  height: 38px;
  border-radius: 999px;
  font-weight: 900;
  font-size: 13px;
  border: 1px solid rgba(0,0,0,0.10);
  background: #fff;
  cursor: pointer;
}
.btnP.ghost {
  background: #f0f0f0;
  border-color: transparent;
  color: rgba(31,42,68,0.9);
}
.btnP.solid {
  background: #ff5a17;
  border: 0;
  color: #fff;
}
.btnP.solid:hover { background: #ff4a05; }
.btnP.ghost:hover { background: #e4e4e4; }

/* arrows */
.navA {
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  width: 44px;
  height: 44px;
  border-radius: 999px;
  border: 1px solid rgba(0,0,0,0.10);
  background: rgba(255,255,255,0.95);
  box-shadow: 0 10px 20px rgba(0,0,0,0.08);
  cursor: pointer;
  font-size: 28px;
  line-height: 0;
  place-items: center;
  color: rgba(0,0,0,0.55);
  z-index: 2;
}
.navA.left  { left: -10px; }
.navA.right { right: -10px; }
.navA:hover {
  color: #ff5a17;
  border-color: rgba(255,90,23,0.35);
}

/* dots */
.dot {
  width: 8px;
  height: 8px;
  border-radius: 999px;
  background: rgba(0,0,0,0.18);
  transition: background 0.2s, width 0.2s, height 0.2s;
}
.dot.active {
  background: #ff5a17;
  width: 10px;
  height: 10px;
}

/* skeleton shimmer */
.skel {
  background: linear-gradient(90deg, #f2f2f2 25%, #e8e8e8 50%, #f2f2f2 75%);
  background-size: 200% 100%;
  animation: shimmer 1.4s infinite;
  border-radius: 6px;
}
.skel-line        { height: 12px; }
.skel-line.long   { width: 85%; }
.skel-line.medium { width: 60%; }
.skel-line.short  { width: 40%; }

@keyframes shimmer {
  0%   { background-position: 200% 0; }
  100% { background-position: -200% 0; }
}
</style>