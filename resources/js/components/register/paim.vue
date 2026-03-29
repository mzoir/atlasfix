<template>
  <div class="page">
    <div class="container-xxl px-3 px-md-5 py-5">

      <!-- Header -->
      <div class="text-center mb-5">
        <h1 class="page-title">Gérer mes <span class="accent">paiements</span></h1>
        <p class="page-sub">Consultez vos transactions et gérez vos moyens de paiement</p>
      </div>

      <!-- Summary Cards -->
      <div class="summary-grid mb-5">
        <div class="sum-card">
          <div class="sum-icon blue">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
              <rect x="2" y="5" width="20" height="14" rx="3" stroke="currentColor" stroke-width="2"/>
              <path d="M2 10h20" stroke="currentColor" stroke-width="2"/>
            </svg>
          </div>
          <div>
            <p class="sum-label">Abonnement actuel</p>
            <p class="sum-value">Plan Premium</p>
          </div>
          <span class="badge-active">Actif</span>
        </div>

        <div class="sum-card">
          <div class="sum-icon orange">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
              <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"/>
              <path d="M12 6v6l4 2" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
            </svg>
          </div>
          <div>
            <p class="sum-label">Prochain renouvellement</p>
            <p class="sum-value">15 Juillet 2025</p>
          </div>
        </div>

        <div class="sum-card">
          <div class="sum-icon green">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
              <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
            </svg>
          </div>
          <div>
            <p class="sum-label">Total payé ce mois</p>
            <p class="sum-value">75 MAD</p>
          </div>
        </div>
      </div>

      <div class="main-grid">

        <!-- LEFT: Payment Methods -->
        <div>
          <div class="section-card mb-4">
            <div class="section-head">
              <h2 class="section-title">Moyens de paiement</h2>
              <button class="btn-add" @click="showAddCard = !showAddCard">+ Ajouter</button>
            </div>

            <!-- Saved cards -->
            <div class="card-list">
              <div class="pay-card active-card">
                <div class="card-left">
                  <div class="card-brand visa">VISA</div>
                  <div>
                    <p class="card-num">•••• •••• •••• 4242</p>
                    <p class="card-exp">Expire 08/2027</p>
                  </div>
                </div>
                <div class="card-right">
                  <span class="badge-default">Par défaut</span>
                  <button class="btn-icon red" title="Supprimer">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none">
                      <polyline points="3 6 5 6 21 6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                      <path d="M19 6l-1 14H6L5 6" stroke="currentColor" stroke-width="2"/>
                      <path d="M10 11v6M14 11v6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                      <path d="M9 6V4h6v2" stroke="currentColor" stroke-width="2"/>
                    </svg>
                  </button>
                </div>
              </div>

              <div class="pay-card">
                <div class="card-left">
                  <div class="card-brand mc">MC</div>
                  <div>
                    <p class="card-num">•••• •••• •••• 8810</p>
                    <p class="card-exp">Expire 03/2026</p>
                  </div>
                </div>
                <div class="card-right">
                  <button class="btn-text">Définir par défaut</button>
                  <button class="btn-icon red" title="Supprimer">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none">
                      <polyline points="3 6 5 6 21 6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                      <path d="M19 6l-1 14H6L5 6" stroke="currentColor" stroke-width="2"/>
                      <path d="M10 11v6M14 11v6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                      <path d="M9 6V4h6v2" stroke="currentColor" stroke-width="2"/>
                    </svg>
                  </button>
                </div>
              </div>
            </div>

            <!-- Add card form -->
            <transition name="fade">
              <div v-if="showAddCard" class="add-card-form mt-3">
                <div class="mb-3">
                  <label class="flbl">Numéro de carte</label>
                  <input class="finp" type="text" placeholder="1234 5678 9012 3456" v-model="newCard.num" maxlength="19" />
                </div>
                <div class="row-2">
                  <div>
                    <label class="flbl">Date d'expiration</label>
                    <input class="finp" type="text" placeholder="MM/AA" v-model="newCard.exp" maxlength="5" />
                  </div>
                  <div>
                    <label class="flbl">CVV</label>
                    <input class="finp" type="password" placeholder="•••" v-model="newCard.cvv" maxlength="3" />
                  </div>
                </div>
                <div class="mb-3">
                  <label class="flbl">Nom sur la carte</label>
                  <input class="finp" type="text" placeholder="Ahmed El Amrani" v-model="newCard.name" />
                </div>
                <div class="form-actions">
                  <button class="btn-cancel" @click="showAddCard = false">Annuler</button>
                  <button class="btn-save" @click="saveCard">Enregistrer</button>
                </div>
              </div>
            </transition>
          </div>

          <!-- Current plan -->
          <div class="section-card">
            <h2 class="section-title mb-3">Mon abonnement</h2>
            <div class="plan-banner">
              <div class="plan-info">
                <div class="plan-icon">
                  <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path d="M12 2l2.4 7.4H22l-6.2 4.5 2.4 7.4L12 17l-6.2 4.3 2.4-7.4L2 9.4h7.6L12 2z" fill="currentColor"/>
                  </svg>
                </div>
                <div>
                  <p class="plan-name">Premium</p>
                  <p class="plan-price">75 MAD<span>/mois</span></p>
                </div>
              </div>
              <router-link class="btn-upgrade" to="/abonnement">Changer de plan</router-link>
            </div>
            <ul class="plan-features">
              <li><span class="chk">✓</span> Tout du plan Pro</li>
              <li><span class="chk">✓</span> Demandes illimitées</li>
              <li><span class="chk">✓</span> Support client 24/7</li>
              <li><span class="chk">✓</span> Portfolio jusqu'à 50 photos</li>
              <li><span class="chk">✓</span> Visibilité nationale</li>
              <li><span class="chk">✓</span> Badge Premium visible</li>
            </ul>
            <button class="btn-cancel-sub">Annuler l'abonnement</button>
          </div>
        </div>

        <!-- RIGHT: Transaction History -->
        <div class="section-card">
          <div class="section-head mb-3">
            <h2 class="section-title">Historique des transactions</h2>
            <select class="filter-select" v-model="filter">
              <option value="all">Tous</option>
              <option value="paid">Payé</option>
              <option value="failed">Échoué</option>
              <option value="refund">Remboursé</option>
            </select>
          </div>

          <div class="tx-list">
            <div
              v-for="tx in filteredTx"
              :key="tx.id"
              class="tx-row"
            >
              <div class="tx-left">
                <div class="tx-icon" :class="tx.type">
                  <svg v-if="tx.type === 'paid'" width="16" height="16" viewBox="0 0 24 24" fill="none">
                    <polyline points="20 6 9 17 4 12" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
                  <svg v-else-if="tx.type === 'failed'" width="16" height="16" viewBox="0 0 24 24" fill="none">
                    <line x1="18" y1="6" x2="6" y2="18" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/>
                    <line x1="6" y1="6" x2="18" y2="18" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/>
                  </svg>
                  <svg v-else width="16" height="16" viewBox="0 0 24 24" fill="none">
                    <polyline points="1 4 1 10 7 10" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    <path d="M3.51 15a9 9 0 102.13-9.36L1 10" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                  </svg>
                </div>
                <div>
                  <p class="tx-label">{{ tx.label }}</p>
                  <p class="tx-date">{{ tx.date }}</p>
                </div>
              </div>
              <div class="tx-right">
                <p class="tx-amount" :class="tx.type">{{ tx.type === 'refund' ? '+' : '-' }}{{ tx.amount }} MAD</p>
                <span class="tx-badge" :class="tx.type">
                  {{ tx.type === 'paid' ? 'Payé' : tx.type === 'failed' ? 'Échoué' : 'Remboursé' }}
                </span>
              </div>
            </div>

            <p v-if="filteredTx.length === 0" class="empty-state">Aucune transaction trouvée.</p>
          </div>
        </div>

      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'

const showAddCard = ref(false)
const filter = ref('all')

const newCard = ref({ num: '', exp: '', cvv: '', name: '' })

function saveCard() {
  // TODO: connect to API
  showAddCard.value = false
  newCard.value = { num: '', exp: '', cvv: '', name: '' }
}

const transactions = ref([
  { id: 1, label: 'Abonnement Premium — Juin 2025',  date: '01 Juin 2025',  amount: 75,  type: 'paid' },
  { id: 2, label: 'Abonnement Premium — Mai 2025',   date: '01 Mai 2025',   amount: 75,  type: 'paid' },
  { id: 3, label: 'Abonnement Premium — Avr 2025',   date: '01 Avr 2025',   amount: 75,  type: 'paid' },
  { id: 4, label: 'Abonnement Pro — Mar 2025',        date: '01 Mar 2025',   amount: 30,  type: 'paid' },
  { id: 5, label: 'Tentative paiement échouée',       date: '15 Fév 2025',   amount: 75,  type: 'failed' },
  { id: 6, label: 'Remboursement — Fév 2025',         date: '10 Fév 2025',   amount: 30,  type: 'refund' },
  { id: 7, label: 'Abonnement Pro — Jan 2025',        date: '01 Jan 2025',   amount: 30,  type: 'paid' },
])

const filteredTx = computed(() =>
  filter.value === 'all' ? transactions.value : transactions.value.filter(t => t.type === filter.value)
)
</script>

<style scoped>
/* PAGE */
.page {
  min-height: 100vh;
  background: linear-gradient(135deg, #f0f4ff 0%, #fef6f0 100%);
  padding-top: 90px;
}

/* HEADER */
.page-title {
  font-family: "Poppins", sans-serif;
  font-weight: 400;
  font-size: 44px;
  color: #314158;
  margin: 0;
}
.accent { color: #fc5a15; }
.page-sub {
  font-size: 17px;
  color: #6f7f93;
  margin: 8px 0 0;
}

/* SUMMARY CARDS */
.summary-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 16px;
}
.sum-card {
  background: #fff;
  border-radius: 16px;
  border: 1px solid rgba(0,0,0,0.07);
  padding: 20px;
  display: flex;
  align-items: center;
  gap: 14px;
  box-shadow: 0 4px 20px rgba(0,0,0,0.06);
}
.sum-icon {
  width: 46px;
  height: 46px;
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
}
.sum-icon.blue   { background: #eff6ff; color: #3b82f6; }
.sum-icon.orange { background: #fff5f0; color: #fc5a15; }
.sum-icon.green  { background: #f0fdf4; color: #22c55e; }
.sum-label { font-size: 12px; color: #6f7f93; margin: 0; }
.sum-value { font-size: 16px; font-weight: 700; color: #314158; margin: 2px 0 0; }
.badge-active {
  margin-left: auto;
  background: #f0fdf4;
  color: #16a34a;
  font-size: 11px;
  font-weight: 700;
  padding: 4px 10px;
  border-radius: 20px;
}

/* MAIN GRID */
.main-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 20px;
  align-items: start;
}

/* SECTION CARD */
.section-card {
  background: #fff;
  border-radius: 18px;
  border: 1px solid rgba(0,0,0,0.07);
  padding: 24px;
  box-shadow: 0 4px 24px rgba(0,0,0,0.06);
}
.section-head {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 18px;
}
.section-title {
  font-size: 18px;
  font-weight: 700;
  color: #314158;
  margin: 0;
}

/* ADD BUTTON */
.btn-add {
  background: #fff5f0;
  color: #fc5a15;
  border: 1px solid rgba(252,90,21,0.3);
  border-radius: 8px;
  padding: 6px 14px;
  font-size: 13px;
  font-weight: 700;
  cursor: pointer;
}
.btn-add:hover { background: #fc5a15; color: #fff; }

/* PAYMENT CARDS */
.card-list { display: flex; flex-direction: column; gap: 10px; }
.pay-card {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 14px 16px;
  border-radius: 12px;
  border: 1px solid #e8edf3;
  background: #fafbfc;
}
.active-card { border-color: #fc5a15; background: #fff8f5; }
.card-left { display: flex; align-items: center; gap: 14px; }
.card-brand {
  width: 46px;
  height: 30px;
  border-radius: 6px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 11px;
  font-weight: 900;
  letter-spacing: 0.5px;
}
.visa { background: #1a1f71; color: #fff; }
.mc   { background: #eb001b; color: #fff; }
.card-num  { font-size: 14px; font-weight: 700; color: #314158; margin: 0; letter-spacing: 1px; }
.card-exp  { font-size: 12px; color: #6f7f93; margin: 2px 0 0; }
.card-right { display: flex; align-items: center; gap: 10px; }
.badge-default {
  background: #fff5f0;
  color: #fc5a15;
  font-size: 11px;
  font-weight: 700;
  padding: 3px 10px;
  border-radius: 20px;
  border: 1px solid rgba(252,90,21,0.2);
}
.btn-icon {
  width: 30px;
  height: 30px;
  border-radius: 8px;
  border: 1px solid #fde8e8;
  background: #fff5f5;
  color: #e53935;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
}
.btn-icon:hover { background: #e53935; color: #fff; }
.btn-text {
  font-size: 12px;
  font-weight: 700;
  color: #6f7f93;
  background: none;
  border: none;
  cursor: pointer;
  text-decoration: underline;
}

/* ADD CARD FORM */
.add-card-form {
  background: #f7f9fc;
  border-radius: 12px;
  padding: 18px;
  border: 1px dashed #d0d8e4;
}
.flbl { font-size: 13px; font-weight: 600; color: #314158; display: block; margin-bottom: 6px; }
.finp {
  width: 100%;
  height: 42px;
  border-radius: 10px;
  border: 1px solid #d7dee8;
  padding: 0 12px;
  font-size: 14px;
  font-weight: 600;
  box-sizing: border-box;
  margin-bottom: 12px;
}
.finp:focus { outline: none; border-color: #fc5a15; box-shadow: 0 0 0 3px rgba(252,90,21,0.1); }
.row-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
.form-actions { display: flex; gap: 10px; }
.btn-cancel {
  flex: 1; height: 40px; border-radius: 10px;
  border: 1px solid #d7dee8; background: #fff;
  font-weight: 700; font-size: 14px; color: #6f7f93; cursor: pointer;
}
.btn-save {
  flex: 1; height: 40px; border-radius: 10px;
  border: none; background: #fc5a15;
  font-weight: 700; font-size: 14px; color: #fff; cursor: pointer;
  box-shadow: 0 6px 16px rgba(252,90,21,0.3);
}

/* PLAN BANNER */
.plan-banner {
  background: linear-gradient(135deg, #fff5f0, #ffe8da);
  border-radius: 14px;
  border: 1.5px solid rgba(252,90,21,0.25);
  padding: 18px 20px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 18px;
}
.plan-info { display: flex; align-items: center; gap: 14px; }
.plan-icon {
  width: 46px;
  height: 46px;
  border-radius: 12px;
  background: #fc5a15;
  color: #fff;
  display: flex;
  align-items: center;
  justify-content: center;
}
.plan-name { font-size: 16px; font-weight: 700; color: #314158; margin: 0; }
.plan-price { font-size: 22px; font-weight: 900; color: #fc5a15; margin: 2px 0 0; }
.plan-price span { font-size: 13px; font-weight: 500; color: #6f7f93; }
.btn-upgrade {
  background: #fc5a15;
  color: #fff;
  border: none;
  border-radius: 10px;
  padding: 10px 18px;
  font-size: 13px;
  font-weight: 700;
  cursor: pointer;
  text-decoration: none;
  white-space: nowrap;
}

/* FEATURES */
.plan-features { list-style: none; padding: 0; margin: 0 0 18px; }
.plan-features li { display: flex; align-items: center; gap: 10px; font-size: 14px; color: #314158; padding: 5px 0; }
.chk { color: #22c55e; font-weight: 900; font-size: 15px; }

.btn-cancel-sub {
  width: 100%;
  height: 40px;
  border-radius: 10px;
  border: 1px solid #fde8e8;
  background: #fff5f5;
  color: #e53935;
  font-size: 13px;
  font-weight: 700;
  cursor: pointer;
}
.btn-cancel-sub:hover { background: #e53935; color: #fff; }

/* TRANSACTION LIST */
.filter-select {
  height: 34px;
  border-radius: 8px;
  border: 1px solid #d7dee8;
  padding: 0 10px;
  font-size: 13px;
  font-weight: 600;
  color: #314158;
  cursor: pointer;
}

.tx-list { display: flex; flex-direction: column; gap: 4px; }
.tx-row {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 13px 14px;
  border-radius: 12px;
  border: 1px solid transparent;
  transition: background .15s;
}
.tx-row:hover { background: #f7f9fc; border-color: #e8edf3; }
.tx-left { display: flex; align-items: center; gap: 12px; }
.tx-icon {
  width: 34px;
  height: 34px;
  border-radius: 10px;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
}
.tx-icon.paid   { background: #f0fdf4; color: #16a34a; }
.tx-icon.failed { background: #fff5f5; color: #e53935; }
.tx-icon.refund { background: #eff6ff; color: #3b82f6; }
.tx-label { font-size: 13px; font-weight: 700; color: #314158; margin: 0; }
.tx-date  { font-size: 11px; color: #6f7f93; margin: 2px 0 0; }
.tx-right { display: flex; flex-direction: column; align-items: flex-end; gap: 4px; }
.tx-amount { font-size: 15px; font-weight: 900; margin: 0; }
.tx-amount.paid   { color: #16a34a; }
.tx-amount.failed { color: #e53935; }
.tx-amount.refund { color: #3b82f6; }
.tx-badge {
  font-size: 10px;
  font-weight: 700;
  padding: 2px 8px;
  border-radius: 20px;
}
.tx-badge.paid   { background: #f0fdf4; color: #16a34a; }
.tx-badge.failed { background: #fff5f5; color: #e53935; }
.tx-badge.refund { background: #eff6ff; color: #3b82f6; }

.empty-state { text-align: center; color: #6f7f93; font-size: 14px; padding: 30px 0; }

/* TRANSITIONS */
.fade-enter-active, .fade-leave-active { transition: opacity .2s, transform .2s; }
.fade-enter-from, .fade-leave-to { opacity: 0; transform: translateY(-6px); }

/* RESPONSIVE */
@media (max-width: 992px) {
  .main-grid { grid-template-columns: 1fr; }
  .summary-grid { grid-template-columns: 1fr; }
}
@media (max-width: 576px) {
  .page-title { font-size: 32px; }
  .plan-banner { flex-direction: column; gap: 14px; align-items: flex-start; }
}
</style>