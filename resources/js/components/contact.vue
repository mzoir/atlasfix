<template>
  <section class="contact-sec">

    <!-- ── Hero: brick wall background ── -->
    <div class="hero-area" :style="{ backgroundImage: `linear-gradient(rgba(255,255,255,0.75), rgba(255,255,255,0.75)), url(${funfact})` ,}">
      <div class="hero-blobs" :style="{ backgroundImage: `url(${funfact1})` }"></div>
      <div class="container-xxl app-shell px-3 px-md-5">
        <div class="text-center hero-text">
          <h1 class="c-title mb-2">Contactez-nous</h1>
          <p class="c-sub m-0">Une question ? Un problème ? Notre équipe est là pour vous aider</p>
        </div>
      </div>
    </div>

    <!-- ── Cards area ── -->
    <div class="cards-area"  :style="{ backgroundImage: `linear-gradient(rgba(255,255,255,0.75), rgba(255,255,255,0.98)),url(${funfact})` }">
      <div class="container-xxl app-shell px-3 px-md-5">
        <div class="row g-4 align-items-start">

          <!-- LEFT -->
          <div class="col-12 col-lg-4">

            <div class="cardx p-4" >
              <div class="cardx-title mb-4">Informations de contact</div>

              <div class="info-item d-flex gap-3">
                <div class="info-ico"><i class="fa-solid fa-phone"></i></div>
                <div>
                  <div class="info-name">Téléphone</div>
                  <div class="info-val">+33 1 23 45 67 89</div>
                  <div class="info-sub">Lun-Ven : 9h-18h</div>
                </div>
              </div>

              <div class="info-item d-flex gap-3 mt-4">
                <div class="info-ico"><i class="fa-solid fa-envelope"></i></div>
                <div>
                  <div class="info-name">Email</div>
                  <div class="info-val">contact@atlasfix.fr</div>
                  <div class="info-sub info-sub--orange">Réponse sous 24h</div>
                </div>
              </div>

              <div class="info-item d-flex gap-3 mt-4">
                <div class="info-ico"><i class="fa-solid fa-location-dot"></i></div>
                <div>
                  <div class="info-name">Adresse</div>
                  <div class="info-val">123 Avenue des Artisans</div>
                  <div class="info-sub">75001 Paris, France</div>
                </div>
              </div>

              <div class="info-item d-flex gap-3 mt-4">
                <div class="info-ico"><i class="fa-regular fa-clock"></i></div>
                <div>
                  <div class="info-name">Horaires</div>
                  <div class="info-sub">Lun-Ven : 09h00 - 18h00</div>
                  <div class="info-sub">Sam : 10h00 - 16h00</div>
                  <div class="info-sub">Dim : Fermé</div>
                </div>
              </div>
            </div>

            <div class="faq-card mt-4 p-4">
              <div class="faq-title d-flex align-items-center gap-2">
                <span class="qico">?</span> Questions fréquentes
              </div>
              <div class="faq-desc mt-2">
                Consultez notre FAQ pour trouver des réponses rapides aux questions les plus courantes.
              </div>
              <button class="faq-btn mt-3 w-100" type="button">Voir la FAQ</button>
            </div>

          </div>

          <!-- RIGHT -->
          <div class="col-12 col-lg-8">
            <div class="cardx p-4 p-md-5">

              <div class="d-flex align-items-center gap-3 mb-4">
                <div class="msg-ico">
                  <i class="fa-regular fa-comment-dots"></i>
                </div>
                <div>
                  <div class="msg-title">Envoyez-nous un message</div>
                  <div class="msg-sub">Remplissez le formulaire ci-dessous</div>
                </div>
              </div>

              <form class="row g-3" @submit.prevent="submit">
                <div class="col-12 col-md-6">
                  <label class="lbl">Prénom <span class="req">*</span></label>
                  <input v-model="form.prenom" class="inp form-control" type="text" placeholder="Jean" />
                </div>
                <div class="col-12 col-md-6">
                  <label class="lbl">Nom <span class="req">*</span></label>
                  <input v-model="form.nom" class="inp form-control" type="text" placeholder="Dupont" />
                </div>
                <div class="col-12 col-md-6">
                  <label class="lbl">Email <span class="req">*</span></label>
                  <input v-model="form.email" class="inp form-control" type="email" placeholder="jean.dupont@exemple.fr" />
                </div>
                <div class="col-12 col-md-6">
                  <label class="lbl">Téléphone</label>
                  <input v-model="form.phone" class="inp form-control" type="text" placeholder="06 12 34 56 78" />
                </div>
                <div class="col-12">
                  <label class="lbl">Sujet <span class="req">*</span></label>
                  <input v-model="form.sujet" class="inp form-control" type="text" placeholder="" />
                </div>
                <div class="col-12">
                  <label class="lbl">Message <span class="req">*</span></label>
                  <textarea v-model="form.message" class="inp form-control area" rows="6"
                    placeholder="Décrivez votre demande en détail..."></textarea>
                </div>
                <div class="col-12">
                  <button class="send-btn w-100" type="submit">
                    <i class="fa-solid fa-paper-plane me-2"></i> Envoyer le message
                  </button>
                </div>
              </form>
            </div>

            <!-- Bottom mini cards -->
            <div class="row g-3 mt-2">
              <div class="col-12 col-md-4">
                <div class="mini cardx p-3 text-center">
                  <div class="mini-ico green"><i class="fa-solid fa-circle-check"></i></div>
                  <div class="mini-t">Réponse rapide</div>
                  <div class="mini-d">Sous 24h</div>
                </div>
              </div>
              <div class="col-12 col-md-4">
                <div class="mini cardx p-3 text-center">
                  <div class="mini-ico blue"><i class="fa-regular fa-comment"></i></div>
                  <div class="mini-t">Support dédié</div>
                  <div class="mini-d">À votre écoute</div>
                </div>
              </div>
              <div class="col-12 col-md-4">
                <div class="mini cardx p-3 text-center">
                  <div class="mini-ico purple"><i class="fa-solid fa-phone"></i></div>
                  <div class="mini-t">Assistance téléphonique</div>
                  <div class="mini-d">Lun-Ven : 9h-18h</div>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>

  </section>
</template>

<script setup>
import { reactive } from "vue"
import '@fortawesome/fontawesome-free/css/all.min.css'
import funfact from "@/assets/iiko.jpg"
import funfact1 from "@/assets/righ.png"

const form = reactive({
  prenom: "", nom: "", email: "",
  phone: "", sujet: "", message: "",
})

function submit() {
  console.log("Send contact form", { ...form })
}
</script>

<style scoped>
/* ===== section ===== */
.contact-sec {
  background: #ffffff;
}

/* ── HERO ── */
.hero-area {
  position: relative;
  padding: 120px ;
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
  overflow: hidden;
}

/* colorful blobs top-right — exactly as screenshot */
.hero-blobs {
  position: absolute;
  top: -50px;
  right: -2px;
  width: 469px;
  height: 469px;
  background-size: contain;
  background-position:  left;
  background-repeat: no-repeat;
  pointer-events: none;
  z-index: 0;
}

.hero-text {
  position: relative;
  z-index: 1;
}

/* ── CARDS AREA — plain bg, no image ── */
.cards-area {
  padding-bottom: 100px;
   min-height: 100px; 
   background-position: top ;
  background-repeat: no-repeat;
  pointer-events: none;
  background-size: contain;
  background-repeat: no-repeat;
}

/* ===== title ===== */
.c-title {
  font-family: Poppins, sans-serif;
  font-weight: 500;
  font-size: clamp(30px, 4vw, 48px);
  line-height: 1.1;
  letter-spacing: 0.2px;
  color: #1f2a44;
}
.c-sub {
  color: rgba(31,42,68,0.55);
  font-weight: 500;
  font-size: 15px;
}

/* ===== shared card ===== */
.cardx {
  background: #fff;
  border-radius: 16px;
  box-shadow: 0 8px 28px rgba(0,0,0,0.08);
  border: 1px solid rgba(0,0,0,0.05);
}
.cardx-title {
  font-weight: 800;
  font-size: 15px;
  color: #1f2a44;
}

/* ===== info items ===== */
.info-item { padding: 2px 0; }

.info-ico {
  flex-shrink: 0;
  width: 42px;
  height: 42px;
  border-radius: 12px;
  background: rgba(255,90,23,0.10);
  border: 1px solid rgba(255,90,23,0.20);
  color: #ff5a17;
  display: grid;
  place-items: center;
  font-size: 15px;
}

.info-name {
  font-family: Inter, sans-serif;
  font-weight: 600;
  font-size: 14px;
  line-height: 22px;
  color: #1f2a44;
}
.info-val {
  font-weight: 500;
  color: rgba(31,42,68,0.65);
  font-size: 13px;
  margin-top: 2px;
}
.info-sub {
  font-weight: 500;
  color: rgba(31,42,68,0.48);
  font-size: 12px;
  margin-top: 1px;
}
.info-sub--orange {
  color: #ff5a17;
  font-weight: 600;
}

/* ===== FAQ card ===== */
.faq-card {
  border-radius: 16px;
  background: #ff5a17;
  color: #fff;
  box-shadow: 0 10px 28px rgba(255,90,23,0.30);
}
.faq-title {
  font-family: Inter, sans-serif;
  font-weight: 600;
  font-size: 18px;
  line-height: 28px;
}
.qico {
  width: 28px;
  height: 28px;
  border-radius: 999px;
  background: rgba(255,255,255,0.22);
  display: grid;
  place-items: center;
  font-weight: 900;
  font-size: 15px;
  flex-shrink: 0;
}
.faq-desc {
  font-family: Inter, sans-serif;
  font-weight: 400;
  font-size: 14px;
  line-height: 22px;
  color: rgba(255,255,255,0.88);
}
.faq-btn {
  height: 42px;
  border-radius: 12px;
  background: #fff;
  color: #ff5a17;
  font-weight: 800;
  font-size: 13px;
  border: 0;
  cursor: pointer;
  transition: opacity 0.2s;
}
.faq-btn:hover { opacity: 0.90; }

/* ===== message header ===== */
.msg-ico {
  flex-shrink: 0;
  width: 42px;
  height: 42px;
  border-radius: 12px;
  background: rgba(255,90,23,0.10);
  border: 1px solid rgba(255,90,23,0.20);
  color: #ff5a17;
  display: grid;
  place-items: center;
  font-size: 18px;
}
.msg-title {
  font-family: Inter, sans-serif;
  font-weight: 600;
  font-size: 20px;
  line-height: 28px;
  color: #314158;
}
.msg-sub {
  font-weight: 500;
  color: rgba(31,42,68,0.48);
  font-size: 12px;
  margin-top: 2px;
}

/* ===== form ===== */
.lbl {
  display: inline-block;
  font-weight: 700;
  color: rgba(31,42,68,0.75);
  font-size: 13px;
  margin-bottom: 6px;
}
.req { color: #ff5a17; }

.inp {
  border-radius: 10px;
  border: 1px solid rgba(0,0,0,0.10);
  font-weight: 500;
  font-size: 13px;
  color: #1f2a44;
  background: #fff;
  height: 42px;
}
.inp::placeholder { color: rgba(31,42,68,0.32); }
.inp:focus {
  border-color: rgba(255,90,23,0.50);
  box-shadow: 0 0 0 3px rgba(255,90,23,0.10);
  outline: none;
}
.area {
  resize: none;
  height: auto !important;
}

.send-btn {
  height: 46px;
  border-radius: 12px;
  border: 0;
  background: #ff5a17;
  color: #fff;
  font-weight: 800;
  font-size: 14px;
  cursor: pointer;
  box-shadow: 0 10px 24px rgba(255,90,23,0.28);
  transition: background 0.2s;
}
.send-btn:hover { background: #e84e0e; }

/* ===== mini cards ===== */
.mini {
  border: 1px solid rgba(0,0,0,0.06) !important;
  box-shadow: 0 4px 14px rgba(0,0,0,0.06) !important;
}
.mini-ico {
  width: 40px;
  height: 40px;
  border-radius: 999px;
  display: grid;
  place-items: center;
  font-size: 17px;
  margin: 0 auto 10px;
}
.mini-ico.green {
  background: rgba(0,200,120,0.10);
  color: #0a8f2a;
  border: 1px solid rgba(0,200,120,0.22);
}
.mini-ico.blue {
  background: rgba(0,140,255,0.10);
  color: #1a73e8;
  border: 1px solid rgba(0,140,255,0.22);
}
.mini-ico.purple {
  background: rgba(160,90,255,0.10);
  color: #8a2be2;
  border: 1px solid rgba(160,90,255,0.22);
}
.mini-t {
  font-weight: 700;
  color: #1f2a44;
  font-size: 13px;
}
.mini-d {
  font-weight: 500;
  color: rgba(31,42,68,0.48);
  font-size: 12px;
  margin-top: 3px;
}

/* ===== responsive ===== */
@media (max-width: 991px) {
  .hero-area { padding: 80px 0 60px; }
}
</style>