<template>
  <div class="faq-page">

    <!-- ═══════════════════════════════════════════
         HERO
    ════════════════════════════════════════════ -->
    <section class="faq-hero atlas-section">
      <div class="hero-bg-grad"></div>
      <div class="container hero-container text-center">
        <span class="section-badge">
          <svg width="14" height="14" fill="none" viewBox="0 0 24 24" style="margin-right:6px;vertical-align:middle">
            <circle cx="12" cy="12" r="9" stroke="#fc5a15" stroke-width="1.8"/>
            <path d="M12 8v4M12 16h.01" stroke="#fc5a15" stroke-width="2" stroke-linecap="round"/>
          </svg>
          Centre d'aide
        </span>
        <h1 class="faq-hero-title mt-3">
          Comment pouvons<br>nous vous aider ?
        </h1>
        <p class="faq-hero-sub mt-2">Trouvez rapidement des réponses à vos questions les plus fréquentes</p>

        <!-- Search -->
        <div class="faq-search-wrap mx-auto mt-4">
          <svg class="search-ico" width="18" height="18" fill="none" viewBox="0 0 24 24">
            <circle cx="11" cy="11" r="7" stroke="rgba(0,0,0,0.35)" stroke-width="1.8"/>
            <path d="M16.5 16.5l3.5 3.5" stroke="rgba(0,0,0,0.35)" stroke-width="1.8" stroke-linecap="round"/>
          </svg>
          <input
            v-model="search"
            type="text"
            class="faq-search-input"
            placeholder="Rechercher une question..."
          />
        </div>
      </div>
    </section>

    <!-- ═══════════════════════════════════════════
         FAQ CONTENT
    ════════════════════════════════════════════ -->
    <section class="faq-content-section py-5">
      <div class="container py-2">

        <!-- Tabs -->
        <div class="faq-tabs d-flex flex-wrap gap-2 mb-5">
          <button
            v-for="tab in tabs"
            :key="tab.key"
            class="faq-tab-btn"
            :class="{ active: activeTab === tab.key }"
            @click="activeTab = tab.key"
          >
            <span v-html="tab.icon" class="tab-icon"></span>
            {{ tab.label }}
          </button>
        </div>

        <div class="row g-4">
          <!-- Accordion -->
          <div class="col-12 col-lg-7">
            <div class="faq-accordion">
              <div
                v-for="(item, i) in filteredFaqs"
                :key="i"
                class="faq-item"
                :class="{ open: openIndex === i }"
              >
                <button class="faq-question" @click="toggle(i)">
                  <span>{{ item.q }}</span>
                  <span class="faq-toggle-icon">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                      <path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                  </span>
                </button>
                <div class="faq-answer">
                  <p>{{ item.a }}</p>
                </div>
              </div>

              <p v-if="filteredFaqs.length === 0" class="no-results">
                Aucune question ne correspond à votre recherche.
              </p>
            </div>
          </div>

          <!-- Sidebar -->
          <div class="col-12 col-lg-5">
            <!-- Help card -->
            <div class="help-card mb-4">
              <div class="help-card-icon">
                <svg width="28" height="28" fill="none" viewBox="0 0 24 24">
                  <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" stroke="#fff" stroke-width="1.8" stroke-linejoin="round"/>
                </svg>
              </div>
              <h5 class="help-card-title mt-3">Besoin d'aide ?</h5>
              <p class="help-card-sub">Notre équipe est là pour vous accompagner</p>
              <button class="help-card-btn">Contacter le support</button>
            </div>

            <!-- Contact info -->
            <div class="contact-card">
              <h6 class="contact-title">Nous contacter</h6>
              <div class="contact-list">
                <div class="contact-item" v-for="c in contacts" :key="c.label">
                  <div class="contact-icon-wrap" :style="{ background: c.bg }">
                    <span v-html="c.icon"></span>
                  </div>
                  <div>
                    <div class="contact-label">{{ c.label }}</div>
                    <div class="contact-value">{{ c.value }}</div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ═══════════════════════════════════════════
         APP DOWNLOAD
    ════════════════════════════════════════════ -->
    <section class="app-section atlas-section pattern-lr py-5">
      <div class="container py-4">
        <div class="row align-items-center g-4">
          <div class="col-12 col-md-5 text-center">
            <div class="phone-mockup">
              <div class="phone-screen">
                <span>YOUR<br>DESIGN<br>HERE</span>
              </div>
            </div>
          </div>
          <div class="col-12 col-md-7">
            <h2 class="app-title">
              Téléchargez<br>l'application AtlasFix
            </h2>
            <p class="app-sub mt-3">
              Trouvez le bon artisan au bon moment, directement depuis votre smartphone.
            </p>
            <div class="d-flex flex-wrap gap-3 mt-4">
              <a href="#" class="store-btn">
                <svg width="20" height="20" viewBox="0 0 512 512" fill="white"><path d="M325.3 234.3L104.6 13l280.8 161.2-60.1 60.1zM47 0C34 6.8 25.3 19.2 25.3 35.3v441.3c0 16.1 8.7 28.5 21.7 35.3l232.6-233-232.6-78.9zM464.6 223l-56.6-32.5-63.3 57.5 63.3 57.5 56.6-32.4c16.1-9.2 16.1-24.5 0-50.1zM104.6 499l280.8-161.2-60.1-60.1L104.6 499z"/></svg>
                <div>
                  <div class="store-label">GET IT ON</div>
                  <div class="store-name">Google Play</div>
                </div>
              </a>
              <a href="#" class="store-btn">
                <svg width="20" height="20" viewBox="0 0 814 1000" fill="white"><path d="M788.1 340.9c-5.8 4.5-108.2 62.2-108.2 190.5 0 148.4 130.3 200.9 134.2 202.2-.6 3.2-20.7 71.9-68.7 141.9-42.8 61.6-87.5 123.1-155.5 123.1s-85.5-39.5-164-39.5c-76 0-103.7 40.8-165.9 40.8s-105-57.8-155.5-127.4C46 389.2 45 272.8 45 261.7c0-144.1 94.2-220.5 182.5-220.5 72.7 0 124.3 47.8 166.1 47.8 39.5 0 101.1-50.8 181.9-50.8 30.2 0 114.7 3.2 174.9 78.4zm-325.5-83.4c-7.1-36.2-21.6-78.1-43.2-112.4-21.6-34.4-62.7-75.5-105.1-90.9 0 3.8-.6 7.7-.6 11.5 0 37.5 13.5 76.1 35.1 107.8 21.5 30.8 62.7 67.7 113.8 84z"/></svg>
                <div>
                  <div class="store-label">Download on the</div>
                  <div class="store-name">App Store</div>
                </div>
              </a>
            </div>
          </div>
        </div>
      </div>
    </section>

  </div>
</template>

<script setup>
import { ref, computed } from 'vue'

const search = ref('')
const activeTab = ref('all')
const openIndex = ref(null)

const tabs = [
  {
    key: 'all',
    label: 'Tous',
    icon: `<svg width="14" height="14" fill="none" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.8"/></svg>`
  },
  {
    key: 'clients',
    label: 'Pour les clients',
    icon: `<svg width="14" height="14" fill="none" viewBox="0 0 24 24"><circle cx="9" cy="7" r="4" stroke="currentColor" stroke-width="1.8"/><path d="M3 21c0-4 3-6 6-6h0" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/><circle cx="17" cy="9" r="3" stroke="currentColor" stroke-width="1.8"/><path d="M14 21c0-3 1.5-5 3-5s3 2 3 5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>`
  },
  {
    key: 'providers',
    label: 'Pour les prestataires',
    icon: `<svg width="14" height="14" fill="none" viewBox="0 0 24 24"><rect x="3" y="7" width="18" height="13" rx="2" stroke="currentColor" stroke-width="1.8"/><path d="M8 7V5a4 4 0 0 1 8 0v2" stroke="currentColor" stroke-width="1.8"/></svg>`
  },
]

const allFaqs = [
  { tab: 'clients', q: 'Comment puis-je réserver un service sur AtlasFix ?', a: 'Pour réserver un service, recherchez le type de professionnel dont vous avez besoin, consultez les profils disponibles dans votre zone, sélectionnez un prestataire et choisissez un créneau horaire. La réservation est confirmée instantanément.' },
  { tab: 'clients', q: 'Quels moyens de paiement sont acceptés ?', a: 'AtlasFix accepte les paiements par carte bancaire (Visa, Mastercard), virement bancaire, et paiement en espèces directement au prestataire selon les modalités convenues.' },
  { tab: 'clients', q: 'Puis-je annuler ou modifier une réservation ?', a: 'Oui, vous pouvez annuler ou modifier une réservation depuis votre espace client jusqu\'à 24 heures avant l\'intervention. Passé ce délai, des frais d\'annulation peuvent s\'appliquer.' },
  { tab: 'clients', q: 'Comment laisser un avis sur un prestataire ?', a: 'Après chaque intervention, vous recevrez une notification vous invitant à évaluer le prestataire. Vous pouvez noter la qualité du service, la ponctualité et le rapport qualité-prix.' },
  { tab: 'clients', q: 'Les prestataires sont-ils vérifiés ?', a: 'Oui, tous les prestataires sur AtlasFix passent par un processus de vérification incluant la validation de leur identité, de leurs qualifications et de leurs antécédents professionnels.' },
  { tab: 'clients', q: 'Que se passe-t-il en cas d\'incident lors d\'une intervention ?', a: 'AtlasFix dispose d\'un service de médiation pour résoudre tout litige. En cas d\'incident, contactez notre support dans les 48h suivant l\'intervention avec les détails et photos si nécessaire.' },
  { tab: 'providers', q: 'Comment devenir prestataire sur AtlasFix ?', a: 'Inscrivez-vous en tant qu\'artisan depuis la page d\'inscription, renseignez votre profil avec vos compétences, zone d\'intervention et tarifs, puis soumettez vos documents pour validation. Notre équipe vous contactera sous 48h.' },
  { tab: 'providers', q: 'Comment recevoir mes paiements ?', a: 'Les paiements sont versés directement sur votre compte bancaire après chaque intervention validée. Les virements sont traités chaque semaine, le lundi.' },
  { tab: 'providers', q: 'Puis-je gérer mon agenda sur la plateforme ?', a: 'Oui, vous disposez d\'un tableau de bord complet pour gérer vos disponibilités, accepter ou refuser des demandes et suivre l\'historique de vos interventions.' },
]

const filteredFaqs = computed(() => {
  return allFaqs.filter(f => {
    const matchTab = activeTab.value === 'all' || f.tab === activeTab.value
    const matchSearch = !search.value || f.q.toLowerCase().includes(search.value.toLowerCase())
    return matchTab && matchSearch
  })
})

function toggle(i) {
  openIndex.value = openIndex.value === i ? null : i
}

const contacts = [
  {
    label: 'Téléphone',
    value: '+212 5XX-XXXXXX',
    bg: 'rgba(99,102,241,0.10)',
    icon: `<svg width="16" height="16" fill="none" viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2A19.79 19.79 0 0 1 2.08 4.18 2 2 0 0 1 4.06 2h3.06a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z" stroke="#6366f1" stroke-width="1.8"/></svg>`
  },
  {
    label: 'Email',
    value: 'support@atlasfix.ma',
    bg: 'rgba(34,197,94,0.10)',
    icon: `<svg width="16" height="16" fill="none" viewBox="0 0 24 24"><rect x="2" y="4" width="20" height="16" rx="2" stroke="#22c55e" stroke-width="1.8"/><path d="M2 7l10 7 10-7" stroke="#22c55e" stroke-width="1.8" stroke-linecap="round"/></svg>`
  },
  {
    label: 'Horaires',
    value: 'Lun – Ven : 9h – 18h',
    bg: 'rgba(168,85,247,0.10)',
    icon: `<svg width="16" height="16" fill="none" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9" stroke="#a855f7" stroke-width="1.8"/><path d="M12 7v5l3 3" stroke="#a855f7" stroke-width="1.8" stroke-linecap="round"/></svg>`
  },
]
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

.faq-page {
  font-family: 'Plus Jakarta Sans', sans-serif;
}

/* ── shared ── */
.atlas-section { position: relative; overflow: hidden; }
.atlas-section > * { position: relative; z-index: 2; }

.pattern-lr::before,
.pattern-lr::after {
  content: "";
  position: absolute;
  width: 340px; height: 340px;
  background-image: radial-gradient(circle, rgba(252,90,21,0.10) 0%, transparent 70%),
    repeating-conic-gradient(rgba(252,90,21,0.05) 0deg, transparent 10deg, transparent 30deg);
  background-size: contain;
  background-repeat: no-repeat;
  z-index: 0;
  pointer-events: none;
}
.pattern-lr::before { left: -80px; top: 30px; }
.pattern-lr::after  { right: -80px; bottom: 30px; }

/* ── HERO ── */
.faq-hero {
  padding: 80px 0 60px;
  background: linear-gradient(160deg, #fff8f5 0%, #fff 50%, #f0f4ff 100%);
}
.hero-bg-grad {
  position: absolute; inset: 0;
  background:
    radial-gradient(ellipse 60% 50% at 50% -10%, rgba(252,90,21,0.08) 0%, transparent 70%),
    radial-gradient(ellipse 40% 40% at 80% 100%, rgba(99,102,241,0.06) 0%, transparent 70%);
}
.hero-container { position: relative; z-index: 2; }

.section-badge {
  display: inline-flex;
  align-items: center;
  background: rgba(252,90,21,0.08);
  color: #fc5a15;
  font-weight: 700;
  font-size: 13px;
  padding: 6px 18px;
  border-radius: 50px;
  border: 1px solid rgba(252,90,21,0.2);
}

.faq-hero-title {
  font-size: clamp(32px, 5vw, 58px);
  font-weight: 800;
  color: #0b0b0b;
  line-height: 1.1;
  letter-spacing: -0.5px;
}
.faq-hero-sub {
  font-size: 15px;
  color: rgba(0,0,0,0.45);
  font-weight: 500;
}

/* Search */
.faq-search-wrap {
  position: relative;
  max-width: 560px;
  background: #fff;
  border-radius: 14px;
  border: 1.5px solid rgba(0,0,0,0.09);
  box-shadow: 0 10px 30px rgba(0,0,0,0.08);
  display: flex;
  align-items: center;
  padding: 0 18px;
  height: 54px;
}
.search-ico { flex-shrink: 0; }
.faq-search-input {
  flex: 1;
  border: none;
  outline: none;
  font-size: 14px;
  font-family: inherit;
  color: #0b0b0b;
  background: transparent;
  padding: 0 12px;
  font-weight: 500;
}
.faq-search-input::placeholder { color: rgba(0,0,0,0.35); }

/* ── CONTENT SECTION ── */
.faq-content-section { background: #fff; }

/* Tabs */
.faq-tabs { border-bottom: none; }

.faq-tab-btn {
  display: inline-flex;
  align-items: center;
  gap: 7px;
  border: 1.5px solid rgba(0,0,0,0.10);
  background: #fff;
  color: rgba(0,0,0,0.6);
  font-family: inherit;
  font-weight: 600;
  font-size: 13.5px;
  padding: 9px 20px;
  border-radius: 50px;
  cursor: pointer;
  transition: all .2s;
}
.faq-tab-btn .tab-icon { display: flex; align-items: center; }
.faq-tab-btn:hover { border-color: #fc5a15; color: #fc5a15; }
.faq-tab-btn.active {
  background: #fc5a15;
  border-color: #fc5a15;
  color: #fff;
  box-shadow: 0 6px 18px rgba(252,90,21,0.30);
}

/* Accordion */
.faq-accordion { display: flex; flex-direction: column; gap: 10px; }

.faq-item {
  border: 1.5px solid rgba(0,0,0,0.08);
  border-radius: 14px;
  overflow: hidden;
  background: #fff;
  transition: border-color .2s, box-shadow .2s;
}
.faq-item:hover { border-color: rgba(252,90,21,0.25); }
.faq-item.open {
  border-color: rgba(252,90,21,0.35);
  box-shadow: 0 4px 18px rgba(252,90,21,0.08);
}

.faq-question {
  width: 100%;
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 12px;
  padding: 18px 20px;
  background: transparent;
  border: none;
  font-family: inherit;
  font-size: 14.5px;
  font-weight: 600;
  color: #0b0b0b;
  text-align: left;
  cursor: pointer;
}
.faq-toggle-icon {
  flex-shrink: 0;
  width: 28px; height: 28px;
  border-radius: 50%;
  background: rgba(0,0,0,0.05);
  display: flex; align-items: center; justify-content: center;
  color: rgba(0,0,0,0.4);
  transition: transform .25s, background .2s, color .2s;
}
.faq-item.open .faq-toggle-icon {
  transform: rotate(180deg);
  background: rgba(252,90,21,0.10);
  color: #fc5a15;
}

.faq-answer {
  max-height: 0;
  overflow: hidden;
  transition: max-height .35s ease, padding .3s;
  padding: 0 20px;
}
.faq-item.open .faq-answer {
  max-height: 300px;
  padding: 0 20px 18px;
}
.faq-answer p {
  margin: 0;
  font-size: 14px;
  line-height: 1.72;
  color: rgba(0,0,0,0.5);
}

.no-results {
  text-align: center;
  color: rgba(0,0,0,0.4);
  font-size: 14px;
  padding: 32px 0;
}

/* ── HELP CARD ── */
.help-card {
  background: linear-gradient(135deg, #fc5a15 0%, #ff7a3d 100%);
  border-radius: 18px;
  padding: 28px 24px;
  text-align: center;
  box-shadow: 0 16px 40px rgba(252,90,21,0.30);
}
.help-card-icon {
  width: 52px; height: 52px;
  border-radius: 14px;
  background: rgba(255,255,255,0.20);
  display: flex; align-items: center; justify-content: center;
  margin: 0 auto;
}
.help-card-title {
  font-size: 18px;
  font-weight: 800;
  color: #fff;
  margin: 0;
}
.help-card-sub {
  font-size: 13px;
  color: rgba(255,255,255,0.75);
  margin: 6px 0 0;
}
.help-card-btn {
  margin-top: 18px;
  width: 100%;
  height: 42px;
  border-radius: 10px;
  border: 1.5px solid rgba(255,255,255,0.80);
  background: transparent;
  color: #fff;
  font-family: inherit;
  font-weight: 700;
  font-size: 13.5px;
  cursor: pointer;
  transition: background .2s, color .2s;
}
.help-card-btn:hover { background: #fff; color: #fc5a15; }

/* ── CONTACT CARD ── */
.contact-card {
  border: 1.5px solid rgba(0,0,0,0.07);
  border-radius: 18px;
  padding: 22px 20px;
  background: #fff;
  box-shadow: 0 4px 18px rgba(0,0,0,0.05);
}
.contact-title {
  font-size: 14px;
  font-weight: 700;
  color: #0b0b0b;
  margin-bottom: 16px;
}
.contact-list { display: flex; flex-direction: column; gap: 14px; }
.contact-item { display: flex; align-items: center; gap: 12px; }
.contact-icon-wrap {
  width: 36px; height: 36px;
  border-radius: 10px;
  display: flex; align-items: center; justify-content: center;
  flex-shrink: 0;
}
.contact-label { font-size: 11px; font-weight: 600; color: rgba(0,0,0,0.35); }
.contact-value { font-size: 13px; font-weight: 600; color: #0b0b0b; margin-top: 1px; }

/* ── APP SECTION ── */
.app-section {
  background: linear-gradient(160deg, #fff8f5 0%, #fff 50%, #f5f0ff 100%);
}

.app-title {
  font-size: clamp(26px, 3.5vw, 42px);
  font-weight: 800;
  color: #0b0b0b;
  line-height: 1.15;
  letter-spacing: -0.3px;
}
.app-sub {
  font-size: 15px;
  color: rgba(0,0,0,0.5);
  line-height: 1.7;
  max-width: 420px;
}

.store-btn {
  display: inline-flex;
  align-items: center;
  gap: 10px;
  background: #0b0b0b;
  color: #fff;
  border-radius: 12px;
  padding: 11px 20px;
  text-decoration: none;
  transition: transform .2s, box-shadow .2s;
  box-shadow: 0 8px 20px rgba(0,0,0,0.18);
}
.store-btn:hover { transform: translateY(-2px); box-shadow: 0 12px 28px rgba(0,0,0,0.22); }
.store-label { font-size: 10px; font-weight: 500; opacity: .75; line-height: 1; }
.store-name  { font-size: 15px; font-weight: 700; line-height: 1.3; }

/* Phone mockup */
.phone-mockup {
  display: inline-block;
  width: 210px;
  aspect-ratio: 9/19;
  background: #0b0b0b;
  border-radius: 36px;
  padding: 12px 8px;
  box-shadow: 0 30px 60px rgba(0,0,0,0.25), 0 0 0 2px rgba(255,255,255,0.08) inset;
  position: relative;
}
.phone-screen {
  width: 100%;
  height: 100%;
  border-radius: 26px;
  background: linear-gradient(135deg, #fc5a15 0%, #ff8c55 100%);
  display: flex; align-items: center; justify-content: center;
  font-size: 16px;
  font-weight: 800;
  color: rgba(255,255,255,0.85);
  text-align: center;
  letter-spacing: 1px;
  line-height: 1.5;
}

/* ── responsive ── */
@media (max-width: 767px) {
  .faq-hero { padding: 60px 0 40px; }
  .phone-mockup { width: 160px; }
  .app-section .col-12:first-child { order: 2; }
  .app-section .col-12:last-child  { order: 1; }
}
</style>