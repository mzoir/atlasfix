<template>
  <div class="about-page">

    <!-- ═══════════════════════════════════════════
         HERO / BANNER
    ════════════════════════════════════════════ -->
    <section class="hero-about atlas-section pattern-lr brick-bg"  :style="{ backgroundImage: `url(${funfact})` }">
      <div class="hero-overlay"></div>
      <div class="container hero-container text-center">
          <div class="section-badge">
        <span class="section-badged">À propos d'AtlasFix</span>
          </div>
        <h1 class="hero-title mt-3">
          AtlasFix, votre partenaire de confiance<br class="d-none d-md-block">
          pour les services du quotidien
        </h1>
        <p class="hero-subtitle mx-auto mt-3">
          AtlasFix est une marketplace de services locaux qui connecte les ménages et les entreprises
          marocaines avec des artisans et prestataires de services fiables, qualifiés et de confiance.
          Notre mission est simple : <strong  class="subtitle2">vous aider à trouver rapidement le bon professionnel,
          au bon endroit, en toute sérénité.</strong>
        </p>
      </div>
    </section>

    <!-- ═══════════════════════════════════════════
         NOTRE VISION
    ════════════════════════════════════════════ -->
    <section class="vision-section atlas-section pattern-lr py-5"  :style="{ backgroundImage: `url(${funfact1})` }">
      <div class="container py-4">
        <div class="text-center mb-5">
          <h2 class="section-title">Notre Vision</h2>
          <p class="section-sub mx-auto">
            Nous croyons que la confiance est la base de toute relation de service réussie.
            AtlasFix a été créée pour répondre à deux besoins essentiels :
          </p>
        </div>

        <div class="row g-4 justify-content-center">
          <!-- Card clients -->
          <div class="col-12 col-md-6 col-lg-5">
            <div class="vision-card h-100">
              <div class="vision-icon">
                <svg width="28" height="28" fill="none" viewBox="0 0 24 24"><circle cx="9" cy="7" r="4" stroke="#fc5a15" stroke-width="1.8"/><path d="M3 21c0-4 3-7 6-7h0" stroke="#fc5a15" stroke-width="1.8" stroke-linecap="round"/><circle cx="17" cy="9" r="3" stroke="#fc5a15" stroke-width="1.8"/><path d="M14 21c0-3 1.5-5 3-5s3 2 3 5" stroke="#fc5a15" stroke-width="1.8" stroke-linecap="round"/></svg>
              </div>
              <h4 class="vision-card-title">Pour les clients</h4>
              <p class="vision-card-text">
                Faciliter la vie des clients en leur offrant un moyen simple et fiable
                de trouver des services de qualité.
              </p>
            </div>
          </div>

          <!-- Card artisans -->
          <div class="col-12 col-md-6 col-lg-5">
            <div class="vision-card vision-card--orange h-100">
              <div class="vision-icon vision-icon--orange">
                <svg width="28" height="28" fill="none" viewBox="0 0 24 24"><rect x="3" y="7" width="18" height="13" rx="2" stroke="#fc5a15" stroke-width="1.8"/><path d="M8 7V5a4 4 0 0 1 8 0v2" stroke="#fc5a15" stroke-width="1.8"/></svg>
              </div>
              <h4 class="vision-card-title">Pour les artisans</h4>
              <p class="vision-card-text">
                Donner de la visibilité et des opportunités aux artisans et professionnels locaux.
              </p>
            </div>
          </div>
        </div>

        <p class="vision-footer text-center mx-auto mt-5">
          Ancrée dans les valeurs marocaines de proximité, de respect et de solidarité, AtlasFix
          est une plateforme moderne, pensée pour évoluer et s'ouvrir à d'autres marchés à l'avenir.
        </p>
      </div>
    </section>

    <!-- ═══════════════════════════════════════════
         POURQUOI CHOISIR ATLASFIX
    ════════════════════════════════════════════ -->
    <section class="why-section atlas-section1 brick-bg py-5" :style="{ backgroundImage: `url(${funfact3})` }">
      <div class="container py-4">
        <div class="text-center mb-5">
          <h2 class="section-title">Pourquoi choisir AtlasFix ?</h2>
          <p class="section-sub mx-auto">
            AtlasFix se distingue par une approche centrée sur l'humain et la transparence :
          </p>
        </div>

        <div class="row g-4 justify-content-center">
          <div class="col-12 col-sm-6 col-lg-4" v-for="feat in features" :key="feat.title">
            <div class="feat-card h-100">
              <div class="feat-icon-wrap" :style="{ background: feat.bg }">
                <span v-html="feat.icon"></span>
              </div>
              <h5 class="feat-title">{{ feat.title }}</h5>
              <p class="feat-text">{{ feat.desc }}</p>
            </div>
          </div>
        </div>
      </div>
    </section>

<!-- ═══════════════════════════════════════════
     COMMUNAUTÉ (image + texte)
════════════════════════════════════════════ -->
<section class="community-section py-5">
  <div class="container py-4">
    <div class="community-card">
      <div class="row g-0 align-items-center">
        <div class="col-12 col-lg-6 p-4 p-lg-5">
          <h2 class="community-title">Une plateforme au service<br>de la communauté</h2>
          <p class="community-text mt-3">
            AtlasFix ne se limite pas à la mise en relation. Nous accompagnons les artisans dans
            leur développement digital et valorisons le savoir-faire local. Chaque service réservé
            contribue à soutenir l'économie locale et à renforcer un écosystème basé sur la
            confiance et l'équité.
          </p>
          <ul class="community-list mt-4">
            <li v-for="item in communityItems" :key="item.text">
              <div class="community-list-ico">
                <span v-html="item.icon"></span>
              </div>
              <span>{{ item.text }}</span>
            </li>
          </ul>
        </div>
        <div class="col-12 col-lg-6">
          <div class="community-img-wrap">
            <img
              :src="artisan"
              alt="Artisan au travail"
              class="community-img"
            />
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

    <!-- ═══════════════════════════════════════════
         TRADITION & MODERNITÉ
    ════════════════════════════════════════════ -->
    <section class="tradition-section py-5 "  :style="{ backgroundImage: `url(${funfact3})` }">
      <div class="container py-4">
        <h2 class="trad-heading text-center mb-5">
          AtlasFix, entre <span class="trad-accent-orange">tradition</span> et
          <span class="trad-accent-orange">modernité</span>
        </h2>

        <div class="row g-4 align-items-center">
          <div class="col-12 col-lg-5">
            <div class="trad-img-wrap  ">
              <img
                src="@/assets/aga.jpg"
                alt="Artisans marocains"
                class="trad-img"
              />
            </div>
          </div>
          <div class="col-12 col-lg-7">
            <h3 class="trad-subtitle">AtlasFix, entre tradition et modernité</h3>
            <div class="trad-divider"></div>
            <p class="trad-text mt-3">
              AtlasFix est bien plus qu'un simple site de services. C'est un
              <strong class="trad-accent-orange1">pont entre tradition et modernité</strong>,
              entre le savoir-faire des artisans marocains et les attentes des familles et des
              entreprises d'aujourd'hui.
            </p>
            <p class="trad-text mt-3">
              Notre ambition est de devenir une référence des services de proximité, d'abord au
              Maroc, puis à l'international, tout en restant fidèles à nos valeurs :
              <strong class="trad-accent-orange1">
                confiance, transparence et esprit communautaire.
              </strong>
            </p>
          </div>
        </div>
      </div>
    </section>

  </div>
</template>

<script setup>

import funfact from "@/assets/had.png"


import artisan from "@/assets/ard.jpg"
import funfact3 from "@/assets/iiko.jpg"
import funfact1 from "@/assets/cp.png"


const features = [
  {
    title: "Des prestataires sélectionnés et évalués",
    desc: "pour garantir la qualité des services.",
    icon: `<svg width="22" height="22" fill="none" viewBox="0 0 24 24"><path d="M12 2l2.09 6.26H21l-5.47 3.97 2.09 6.26L12 14.52l-5.62 3.97 2.09-6.26L3 8.26h6.91z" stroke="#6c63ff" stroke-width="1.8" stroke-linejoin="round"/></svg>`,
    bg: "rgba(108,99,255,0.10)",
  },
  {
    title: "Des avis clients authentiques",
    desc: "pour vous aider à faire le bon choix.",
    icon: `<svg width="22" height="22" fill="none" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" stroke="#f5a623" stroke-width="1.8" stroke-linejoin="round"/></svg>`,
    bg: "rgba(245,166,35,0.10)",
  },
  {
    title: "Une réservation simple et rapide",
    desc: "sans démarches compliquées.",
    icon: `<svg width="22" height="22" fill="none" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="17" rx="2" stroke="#e040fb" stroke-width="1.8"/><path d="M16 2v4M8 2v4M3 9h18" stroke="#e040fb" stroke-width="1.8" stroke-linecap="round"/></svg>`,
    bg: "rgba(224,64,251,0.10)",
  },
  {
    title: "Des conditions claires,",
    desc: "sans frais cachés.",
    icon: `<svg width="22" height="22" fill="none" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9" stroke="#00bfa5" stroke-width="1.8"/><path d="M9 12l2 2 4-4" stroke="#00bfa5" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>`,
    bg: "rgba(0,191,165,0.10)",
  },
  {
    title: "Une plateforme multilingue",
    desc: "accessible à tous.",
    icon: `<svg width="22" height="22" fill="none" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9" stroke="#29b6f6" stroke-width="1.8"/><path d="M3 12h18M12 3a15 15 0 0 1 0 18M12 3a15 15 0 0 0 0 18" stroke="#29b6f6" stroke-width="1.8"/></svg>`,
    bg: "rgba(41,182,246,0.10)",
  },
]
const communityItems = [
  {
    text: "Soutien à l'économie locale",
    icon: `<svg width="18" height="18" fill="none" viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z" stroke="#fc5a15" stroke-width="1.5"/></svg>`,
  },
  {
    text: "Valorisation du savoir-faire marocain",
    icon: `<svg width="18" height="18" fill="none" viewBox="0 0 24 24"><path d="M12 2l2.09 6.26H21l-5.47 3.97 2.09 6.26L12 14.52l-5.62 3.97 2.09-6.26L3 8.26h6.91z" stroke="#fc5a15" stroke-width="1.5" stroke-linejoin="round"/></svg>`,
  },
  {
    text: "Formation et accompagnement digital",
    icon: `<svg width="18" height="18" fill="none" viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12" stroke="#fc5a15" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>`,
  },
  {
    text: "Écosystème équitable et transparent",
    icon: `<svg width="18" height="18" fill="none" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" stroke="#fc5a15" stroke-width="1.5" stroke-linejoin="round"/></svg>`,
  },
]
</script>

<style scoped>
/* ── Shared utilities ── */
.atlas-section { position: relative; overflow: hidden; 
  background-size: contain;
  background-position: left;
  background-repeat: no-repeat; 

  background:
    linear-gradient(180deg, rgba(255, 255, 255, 0.6) 80.57%, #FFFFFF 100%),}
.atlas-section > * { position: relative; z-index: 2; }

.atlas-section1 {
  position: relative;
  overflow: hidden;
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
}

.atlas-section1::before {
  content: "";
  position: absolute;
  inset: 0;
  background:
    linear-gradient(180deg, rgba(255, 255, 255, 0.75) 17.02%, rgba(255, 255, 255, 0) 64.16%),
    linear-gradient(269.47deg, rgba(255, 255, 255, 0) 77.68%, #FFFFFF 99.17%);
  z-index: 1;
  pointer-events: none;
}

.atlas-section1 > * {
  position: relative;
  z-index: 2;
}
.pattern-lr::before,
.pattern-lr::after {
  content: "";
  position: absolute;
  width: 340px;
  height: 340px;
  background-size: contain;
  background-repeat: no-repeat;
  z-index: 0;
  pointer-events: none;
}
.pattern-lr::before { left: -80px; top: 30px; }
.pattern-lr::after  { right: -80px; bottom: 30px; }

.brick-bg::before {
  content: "";
  position: absolute;
  inset: 0;
  background-image: url("data:image/svg+xml,%3Csvg width='60' height='30' viewBox='0 0 60 30' xmlns='http://www.w3.org/2000/svg'%3E%3Crect x='0' y='0' width='58' height='28' rx='2' fill='none' stroke='%23ddd' stroke-width='0.5'/%3E%3C/svg%3E");
  background-repeat: repeat;
  opacity: 0.15;
  z-index: 0;
  pointer-events: none;
}

/* ── HERO ── */
.hero-about {
  
  background: 
    linear-gradient(180deg, rgba(243, 240, 240, 0.9) 44.57%, #FFFFFF 100%),
    linear-gradient(165deg, rgba(234, 235, 237, 0.98) 0%, rgba(192, 112, 37, 0.5) 100%);
  
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
  padding: 80px 0 60px;
}
.hero-overlay {
  position: absolute; inset: 0;
  background: linear-gradient(180deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0.6) 100%);
}
.hero-container { position: relative; z-index: 2; }
.section-badge {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  width: 502px;
  height: 100.4px;
  border-radius: 20px;
  border: 1.56px solid #fc5a15;
  box-shadow: 0 0 0 1px rgba(0,0,0,0.15);
  background:  transparent;
  padding: 21.79px 12.45px;
  gap: 7.78px;
  opacity: 4;
}

.section-badged {
  font-family: 'Poppins', sans-serif;
  font-weight: 500;
  font-size: 42.81px;
  line-height: 28.02px;
  letter-spacing: 0.31px;
  text-align: center;
  vertical-align: middle;
  color: #fc5a15;
  border: none;
  padding: 0;
  display: inline-block;
}
.subtitle2 {

  font-family: "poppins";
font-weight: 600;
font-style: "SemiBold";
font-size: 18px;
line-height: 29.25px;
letter-spacing: -0.44px;
text-align: center;

 } 
.hero-title {
  font-family: "poppins";
font-weight: 400;
font-style: normal;
font-size: 35px;
line-height: 53px;
letter-spacing: 0.4px;
text-align: center;
vertical-align: middle;

  color:#314158;
  line-height: 1.15;
  letter-spacing: -0.4px;
}

.hero-subtitle {
  font-family: "poppins";
font-weight: 400;
font-style: normal;
font-size: 18px;
line-height: 29.25px;
letter-spacing: -0.44px;
text-align: center;

  font-size: 15px;
  line-height: 1.75;
  color: rgba(0,0,0,0.55);
  max-width: 760px;
}

/* ── SECTION COMMON ── */
.section-title {
   font-family: "inter", sans-serif;
  font-size: clamp(22px, 3vw, 34px);
  font-weight: 400;
  color: #0b0b0b;
  letter-spacing: -0.3px;
}
.section-sub {
  font-size: 15px;
  line-height: 1.7;
  color: rgba(0,0,0,0.5);
  max-width: 600px;
}

/* ── VISION CARDS ── */
.vision-card {
  background: #fff;
  border: 1.5px solid rgba(0,0,0,0.07);
  border-radius: 18px;
  padding: 28px 28px 24px;
  box-shadow: 0 6px 24px rgba(0,0,0,0.06);
  transition: transform .25s, box-shadow .25s;
}
.vision-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 14px 36px rgba(0,0,0,0.10);
}
.vision-card--orange {
  border-color: rgba(252,90,21,0.18);
  background: linear-gradient(135deg, #fff8f5 0%, #fff 100%);
}

.vision-icon {
  width: 50px; height: 50px;
  border-radius: 14px;
  background: rgba(252,90,21,0.08);
  display: flex; align-items: center; justify-content: center;
  margin-bottom: 16px;
}
.vision-icon--orange { background: rgba(252,90,21,0.13); }

.vision-card-title {
  font-size: 17px;
  font-weight: 700;
  color: #0b0b0b;
  margin-bottom: 10px;
}
.vision-card-text {
  font-size: 14px;
  color: rgba(0,0,0,0.5);
  line-height: 1.65;
  margin: 0;
}

.vision-footer {
  font-size: 15px;
  line-height: 1.75;
  color: rgba(0,0,0,0.55);
  max-width: 680px;
  font-style: italic;
}

/* ── WHY / FEATURES ── */

.feat-card {
  background: #fff;
  border: 1.5px solid rgba(0,0,0,0.06);
  border-radius: 16px;
  padding: 28px 24px;
  box-shadow: 0 4px 18px rgba(0,0,0,0.05);
  transition: transform .25s, box-shadow .25s;
}
.feat-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 12px 32px rgba(0,0,0,0.09);
}

.feat-icon-wrap {
  width: 48px; height: 48px;
  border-radius: 12px;
  display: flex; align-items: center; justify-content: center;
  margin-bottom: 16px;
}

.feat-title {
  font-size: 15px;
  font-weight: 700;
  color: #0b0b0b;
  margin-bottom: 6px;
}
.feat-text {
  font-size: 13px;
  color: rgba(0,0,0,0.45);
  line-height: 1.6;
  margin: 0;
}

/* ── COMMUNITY ── */
.community-section { background: #fff;  height: 100%; min-height: 600px; }

.community-card {
 
  border-radius: 24px;
  overflow: hidden;
   background: #fff; 
  box-shadow: 0 20px 60px rgba(0,0,0,0.15);
}
.community-title {
  font-family: "poppins";
font-weight: 500;
font-style: Medium;
font-size: 40px;
line-height: 53px;
letter-spacing: 0px;
color:rgba(49, 65, 88, 1);
  line-height: 1.2;
}
.community-text {
  font-family: "poppins";
font-weight: 400;
font-style:normal ;
font-size: 18px;
line-height: 29.25px;
letter-spacing: -0.44px;

  color: rgba(98, 116, 142, 1);
  line-height: 1.75;
}
.community-list-ico {
  flex-shrink: 0;
  width: 40px;
  height: 40px;
  border-radius: 14px;
  background: rgba(252, 90, 21, 0.08);
    border: 1px solid rgba(252,90,21,0.18);
  display: flex;
  align-items: center;
  justify-content: center;
}
.community-list {
  list-style: none;
  padding: 0; margin: 0;
  display: flex; flex-direction: column; gap: 10px;
}
.community-list li {
  font-family: "poppins";
font-weight: 400;
font-style: normal;
font-size: 16px;
line-height: 24px;
letter-spacing: -0.31px;

  display: flex;
  align-items: center;
  gap: 10px;
  color: rgba(49, 65, 88, 1);
}
.bullet {
  width: 8px; height: 8px;
  border-radius: 50%;
  background: #fc5a15;
  flex-shrink: 0;
}
.community-img-wrap {
  height: 100%;
  min-height: 280px;
  overflow: hidden;
  border-radius: 0 24px 24px 0;
}
.community-img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  display: block;
  filter: brightness(0.85);
}
.community-section { 
  padding: 30px 0 !important;
}

.community-card .col-12.col-lg-6.p-4 {
  padding: 28px !important;
}



/* ── TRADITION ── */
.tradition-section {
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
  position: relative;
  overflow: hidden;
}

.tradition-section::before {
  content: "";
  position: absolute;
  inset: 0;
  background:
    linear-gradient(180deg, rgba(255, 255, 255, 0.85) 17.02%, rgba(255, 255, 255, 0) 64.16%),
    linear-gradient(269.47deg, rgba(255, 255, 255, 0.5) 77.68%, rgba(255, 255, 255, 0.9) 99%);
  z-index: 1;
  pointer-events: none;
}

.tradition-section > * {
  position: relative;
  z-index: 2;
}

.trad-heading {
font-family: "Poppins";
font-weight: 550;
font-style: Medium;
font-size: 40px;
line-height: 60px;
letter-spacing: -0.44px;
text-align: center;
vertical-align: middle;
color : rgba(0, 0, 0, 1)

}
.trad-accent-dark   {  font-family: "Poppins";
font-weight: 400;
font-style: edium;
font-size: 40px;;
 color: rgba(252, 90, 21, 1);
text-align: center;
vertical-align: middle;
 }
.trad-accent-orange { color: rgba(252, 90, 21, 1);font-family: "Poppins";
font-weight: 400;
font-style: "Regular";
font-size: 40px;
line-height: 28px;
letter-spacing: -0.45px;
 }
 
.trad-accent-orange1 {
 font-family: "Poppins";
 color: rgba(252, 90, 21, 1);
font-weight: 400;
font-style: "Regular";
font-size: 20px;
line-height: 28px;
letter-spacing: -0.45px;
 }

.trad-img-wrap {
  border-radius: 20px;
  overflow: hidden;
  box-shadow: 0 14px 40px rgba(0,0,0,0.12);
}
.trad-img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  display: block;
  min-height: 280px;
}

.trad-subtitle {
   font-family: "Poppinsr", sans-serif;
  
font-weight: 400;
font-style: Regular;
font-size: 30px;
line-height: 60px;
letter-spacing: -0.44px;
vertical-align: middle;

  color: #0b0b0b;
}
.trad-divider {
  width: 48px; height: 3px;
  background: #fc5a15;
  border-radius: 2px;
  margin-top: 10px;
}
.trad-text {
  font-family: "Poppins";
font-weight: 400;
font-style: "Regular";
font-size: 20px;
line-height: 28px;
letter-spacing: -0.45px;

  color:rgba(98, 116, 142, 1);
}

/* ── Responsive tweaks ── */
@media (max-width: 767px) {
  .hero-about { padding: 60px 0 40px; }
  .community-img-wrap { min-height: 220px; }
}
.vision-section {
  background-size: contain;
  background-position: left;
  background-repeat: no-repeat;
  position: relative;
}

.vision-section::before {
  content: "";
  position: absolute;
  inset: 0;
  background: linear-gradient(
    180deg,
    rgba(255, 255, 255, 0.99) 0%,
    rgba(255, 255, 255, 0.75) 50%,
    rgba(255, 255, 255, 0.92) 100%
  );
  z-index: 1;
  pointer-events: none;
}

.vision-section > * {
  position: relative;
  z-index: 2;
}
.why-section {
   height: 662.25;
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
  position: relative;
  overflow: hidden;
}

.why-section::after {
  content: "";
  position: absolute;
  inset: 0;
  background:
    linear-gradient(180deg, rgba(255, 255, 255, 0.75) 17.02%, rgba(255, 255, 255, 0) 64.16%),
    linear-gradient(269.47deg, rgba(255, 255, 255, 0.8) 77.68%, #FFFFFF 99.17%);
  z-index: 1;
  pointer-events: none;
}

.why-section > * {
  position: relative;
  z-index: 2;
}
</style>