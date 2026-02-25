<template>
  <section class="contact-sec py-5">
    <div class="container-xxl app-shell px-3 px-md-5">

      <!-- Title -->
      <div class="text-center mb-4">
        <h1 class="c-title mb-1">Contactez-nous</h1>
        <p class="c-sub m-0">Une question ? Un problème ? Notre équipe est là pour vous aider</p>
      </div>

      <!-- Main grid -->
      <div class="row g-4 align-items-start">

        <!-- LEFT -->
        <div class="col-12 col-lg-4">
          <!-- Info card -->
          <div class="cardx p-4">
            <div class="cardx-title mb-3">Informations de contact</div>

            <div class="info-item d-flex gap-3">
              <div class="info-ico">📞</div>
              <div>
                <div class="info-name">Téléphone</div>
                <div class="info-val">+33 1 23 45 67 89</div>
                <div class="info-sub">Lun-Ven : 9h-18h</div>
              </div>
            </div>

            <div class="info-item d-flex gap-3 mt-3">
              <div class="info-ico">✉️</div>
              <div>
                <div class="info-name">Email</div>
                <div class="info-val">contact@atlasfix.fr</div>
                <div class="info-sub">Réponse sous 24h</div>
              </div>
            </div>

            <div class="info-item d-flex gap-3 mt-3">
              <div class="info-ico">📍</div>
              <div>
                <div class="info-name">Adresse</div>
                <div class="info-val">123 Avenue des Artisans</div>
                <div class="info-sub">75001 Paris, France</div>
              </div>
            </div>

            <div class="info-item d-flex gap-3 mt-3">
              <div class="info-ico">🕒</div>
              <div>
                <div class="info-name">Horaires</div>
                <div class="info-sub">Lun-Ven : 09h00-18h00</div>
                <div class="info-sub">Sam : 10h00-16h00</div>
                <div class="info-sub">Dim : Fermé</div>
              </div>
            </div>
          </div>

          <!-- FAQ orange card -->
          <div class="faq-card mt-4 p-4">
            <div class="faq-title d-flex align-items-center gap-2">
              <span class="qico">?</span> Questions fréquentes
            </div>
            <div class="faq-desc mt-2">
              Consultez notre FAQ pour trouver des réponses rapides aux questions les plus courantes.
            </div>
            <button class="btn faq-btn mt-3" type="button">Voir la FAQ</button>
          </div>
        </div>

        <!-- RIGHT -->
        <div class="col-12 col-lg-8">
          <div class="cardx p-4 p-md-5">
            <div class="d-flex align-items-start gap-3 mb-3">
              <div class="msg-ico">✉️</div>
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
                <label class="lbl">Sujet</label>
                <input v-model="form.sujet" class="inp form-control" type="text" placeholder="" />
              </div>

              <div class="col-12">
                <label class="lbl">Message <span class="req">*</span></label>
                <textarea v-model="form.message" class="inp form-control area" rows="5"
                  placeholder="Décrivez votre demande en détail..."></textarea>
              </div>

              <div class="col-12">
                <button class="send-btn w-100" type="submit">
                  <span class="plane">✈</span> Envoyer le message
                </button>
              </div>
            </form>
          </div>

          <!-- Bottom mini cards -->
          <div class="row g-3 mt-3">
            <div class="col-12 col-md-4">
              <div class="mini cardx p-3 text-center">
                <div class="mini-ico green">✓</div>
                <div class="mini-t">Réponse rapide</div>
                <div class="mini-d">Sous 24h</div>
              </div>
            </div>

            <div class="col-12 col-md-4">
              <div class="mini cardx p-3 text-center">
                <div class="mini-ico blue">💬</div>
                <div class="mini-t">Support dédié</div>
                <div class="mini-d">À votre écoute</div>
              </div>
            </div>

            <div class="col-12 col-md-4">
              <div class="mini cardx p-3 text-center">
                <div class="mini-ico purple">📞</div>
                <div class="mini-t">Assistance téléphonique</div>
                <div class="mini-d">Lun-Ven : 9h-18h</div>
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

const form = reactive({
  prenom: "",
  nom: "",
  email: "",
  phone: "",
  sujet: "",
  message: "",
})

function submit() {
  // connect to your API later
  console.log("Send contact form", { ...form })
}
</script>

<style scoped>
/* page background + subtle pattern corner like screenshot */
.contact-sec{
  background: #f5f7fb;
  position: relative;
  overflow: hidden;
}
.contact-sec::after{
  content:"";
  position:absolute;
  top:-40px;
  right:-40px;
  width: 280px;
  height: 280px;
  opacity: .35;
  background:
    radial-gradient(circle at 20% 20%, rgba(255,90,23,.35) 0 22%, transparent 23%),
    radial-gradient(circle at 70% 30%, rgba(0,180,255,.25) 0 22%, transparent 23%),
    radial-gradient(circle at 40% 70%, rgba(0,200,120,.25) 0 22%, transparent 23%),
    radial-gradient(circle at 80% 80%, rgba(255,200,0,.22) 0 22%, transparent 23%);
  filter: blur(0px);
  pointer-events: none;
}
.contact-sec > .container-xxl{ position: relative; z-index: 1; }

.c-title{
  font-weight: 900;
  color: #1f2a44;
  font-size: clamp(28px, 3.5vw, 44px);
}
.c-sub{
  color: rgba(31,42,68,0.60);
  font-weight: 800;
  font-size: 13px;
}

/* shared card style like your site */
.cardx{
  background: #fff;
  border-radius: 16px;
  box-shadow: 0 14px 30px rgba(0,0,0,0.10);
  border: 1px solid rgba(0,0,0,0.06);
}
.cardx-title{
  font-weight: 900;
  color: rgba(31,42,68,0.90);
}

/* info list */
.info-item{ padding: 4px 0; }
.info-ico{
  width: 40px;
  height: 40px;
  border-radius: 12px;

  /* NEW STYLE */
  background: rgba(255,90,23,0.12);   /* soft orange bg */
  border: 1px solid rgba(255,90,23,0.28);
  color: #f75211;                     /* icon color same as button */

  display: grid;
  place-items: center;
  font-size: 16px;
}

.info-name{ font-weight: 900; color: rgba(31,42,68,0.88); font-size: 13px; }
.info-val{ font-weight: 800; color: rgba(31,42,68,0.72); font-size: 12px; margin-top: 2px; }
.info-sub{ font-weight: 800; color: rgba(31,42,68,0.55); font-size: 11px; margin-top: 2px; }

/* FAQ orange card */
.faq-card{
  border-radius: 16px;
  background: #ff5a17;
  color: #fff;
  box-shadow: 0 14px 30px rgba(255,90,23,0.25);
}
.faq-title{ font-weight: 900; }
.qico{
  width: 26px; height: 26px; border-radius: 999px;
  background: rgba(255,255,255,0.18);
  display: grid; place-items: center;
  font-weight: 900;
}
.faq-desc{ color: rgba(255,255,255,0.85); font-weight: 700; font-size: 12px; line-height: 1.6; }
.faq-btn{
  height: 40px;
  border-radius: 12px;
  background: #fff;
  color: #ff5a17;
  font-weight: 900;
  border: 0;
}

/* Right header */
.msg-ico{
  width: 40px; height: 40px; border-radius: 12px;
  background: rgba(255,90,23,0.12);
  border: 1px solid rgba(255,90,23,0.25);
  display: grid; place-items: center;
}
.msg-title{ font-weight: 900; color: rgba(31,42,68,0.90); }
.msg-sub{ font-weight: 800; color: rgba(31,42,68,0.55); font-size: 12px; margin-top: 2px; }

/* form */
.lbl{
  display: inline-block;
  font-weight: 900;
  color: rgba(31,42,68,0.78);
  font-size: 12px;
  margin-bottom: 6px;
}
.req{ color: #ff5a17; }

.inp{
  border-radius: 10px;
  border: 1px solid rgba(0,0,0,0.10);
  font-weight: 700;
  font-size: 13px;
}
.inp:focus{
  border-color: rgba(255,90,23,0.55);
  box-shadow: 0 0 0 4px rgba(255,90,23,0.10);
}
.area{ resize: none; }

.send-btn{
  height: 44px;
  border-radius: 12px;
  border: 0;
  background: #ff5a17;
  color: #fff;
  font-weight: 900;
  box-shadow: 0 12px 24px rgba(255,90,23,0.25);
}
.plane{ margin-right: 8px; }

/* bottom mini */
.mini{ border: 1px solid rgba(255,90,23,0.25); }
.mini-ico{
  width: 34px; height: 34px; border-radius: 999px;
  display: grid; place-items: center;
  font-weight: 900;
  margin: 0 auto 8px;
  font-size: 14px;
}
.mini-ico.green{ background: rgba(0,200,120,0.12); color: #0a8f2a; border: 1px solid rgba(0,200,120,0.25); }
.mini-ico.blue{ background: rgba(0,140,255,0.12); color: #1a73e8; border: 1px solid rgba(0,140,255,0.25); }
.mini-ico.purple{ background: rgba(160,90,255,0.12); color: #8a2be2; border: 1px solid rgba(160,90,255,0.25); }

.mini-t{ font-weight: 900; color: rgba(31,42,68,0.90); font-size: 12px; }
.mini-d{ font-weight: 800; color: rgba(31,42,68,0.55); font-size: 11px; margin-top: 2px; }
</style>
