<template>
  <section class="services-page">

    <!-- ── Hero area with background image ── -->
    <div class="services-hero" :style="{ backgroundImage: `url(${funfact3})` }">

      <!-- blobs corners -->
      

      <div class="container-xxl app-shell px-3 px-md-5">

        <!-- STATS -->
        <div class="stats-sec text-center">
          <h1 class="page-title mb-2">Nos Services</h1>
          <p class="page-sub mb-4">
            Des artisans qualifiés et vérifiés pour tous vos travaux et dépannages à domicile
          </p>
          <div class="row g-3 g-md-4 justify-content-center">
            <div class="col-6 col-sm-6 col-lg-3" v-for="s in stats" :key="s.label">
              <div class="stat-card h-100">
                <div class="stat-ico">
                  <img :src="s.icon" :alt="s.label" class="stat-ico-img" />
                </div>
                <div class="stat-num">{{ s.value }}</div>
                <div class="stat-lbl">{{ s.label }}</div>
              </div>
            </div>
          </div>
        </div>

        <!-- SEARCH BAR -->
         

      </div>
    </div>

    <!-- ── Cards area: plain bg ── -->
    <div class="cards-area" >
        

<div class="cards-blob-right" :style="{ backgroundImage: `url(${right})` }"></div>
    
       <div class="search-bar  ">
            <span class="s-ico">🔍</span>
            <input
              v-model="q"
              class="s-inp"
              type="text"
              placeholder="Rechercher un service (plomberie, électricité, beauté...)"
            />
        </div>
      <div class="container-xxl app-shell px-3 px-md-5">
        <div class="grid-sec">
          <div class="row g-3 justify-content-center">
            <div
              class="col-6 col-sm-6 col-lg-3 d-flex justify-content-center"
              v-for="c in filtered"
              :key="c.title"
            >
              <article class="svc-card">
                <div class="svc-img">
                  <img :src="c.img" :alt="c.title" />
                  <div class="svc-badge">
                    <i :class="c.badgeIcon + ' badge-icon'"></i>
                  </div>
                </div>
                <div class="svc-body">
                  <h3 class="svc-title">{{ c.title }}</h3>
                  <ul class="svc-list">
                    <li v-for="(x, idx) in c.items" :key="idx">
                      <span class="svc-dot"></span>
                      <span>{{ x }}</span>
                    </li>
                  </ul>
                  <button class="svc-btn" type="button">
                    Voir les artisans <span class="arr">→</span>
                  </button>
                </div>
              </article>
            </div>
          </div>
        </div>

        <HowItWorks />

      </div>
    </div>

  </section>
</template>

<script setup>
import { computed, ref } from "vue"
import HowItWorks from "./pages/HowItWorks.vue"
import '@fortawesome/fontawesome-free/css/all.min.css'

import right       from "@/assets/righ.png"
import funfact3    from "@/assets/iiko.jpg"
import iconProfile from "@/assets/Icon01.png"
import iconStart   from "@/assets/Icon (1).png"
import iconTime    from "@/assets/Icon (2).png"
import iconSecure  from "@/assets/Icon6.png"

const q = ref("")

const stats = [
  { icon: iconProfile, value: "500+",  label: "Artisans"      },
  { icon: iconStart,   value: "4.8/5", label: "Satisfaction"  },
  { icon: iconTime,    value: "24/7",  label: "Disponibilité" },
  { icon: iconSecure,  value: "100%",  label: "Sécurisé"      },
]

const categories = [
  {
    title: "Plomberie", badgeIcon: "fa-solid fa-droplet",
    img: "https://tse3.mm.bing.net/th/id/OIP.AHKsCgEeLPXWWA34zZfqgQHaE8?rs=1&pid=ImgDetMain&o=7&rm=3",
    items: ["Réparation de fuite", "Installation sanitaire", "Réparation de toilette", "Débouchage"],
  },
  {
    title: "Électricité", badgeIcon: "fa-solid fa-bolt",
    img: "https://images.unsplash.com/photo-1581092160562-40aa08e78837?w=400&q=80",
    items: ["Installation de luminaires", "Réparation prises & interrupteurs", "Installation ventilateur de plafond"],
  },
  {
    title: "Peinture", badgeIcon: "fa-solid fa-paintbrush",
    img: "https://images.unsplash.com/photo-1588854337236-6889d631faa8?w=400&q=80",
    items: ["Travaux de peinture intérieure"],
  },
  {
    title: "Réparations générales", badgeIcon: "fa-solid fa-screwdriver-wrench",
    img: "https://images.unsplash.com/photo-1585128792020-803d29415281?w=400&q=80",
    items: ["Montage TV, étagères, tringles", "Réparation portes & serrures", "Petites menuiseries", "Joints & silicone"],
  },
  {
    title: "Déménagement", badgeIcon: "fa-solid fa-box",
    img: "https://images.unsplash.com/photo-1600585154340-be6161a56a0c?w=400&q=80",
    items: ["Déménagement local", "Emballage & déballage", "Transport de meubles"],
  },
  {
    title: "Électroménager", badgeIcon: "fa-solid fa-blender",
    img: "https://images.unsplash.com/photo-1581578731548-c64695cc6952?w=400&q=80",
    items: ["Réparation lave-linge / sèche-linge", "Réparation réfrigérateur", "Réparation four / cuisinière"],
  },
  {
    title: "Nettoyage", badgeIcon: "fa-solid fa-broom",
    img: "https://images.unsplash.com/photo-1585421514738-01798e348b17?w=400&q=80",
    items: ["Nettoyage standard", "Nettoyage en profondeur", "Nettoyage après déménagement"],
  },
  {
    title: "Chauffage, Ventilation et Climatisation", badgeIcon: "fa-solid fa-snowflake",
    img: "https://tse2.mm.bing.net/th/id/OIP.APWxqts7TcuAdidgh4hYigHaFG?rs=1&pid=ImgDetMain&o=7&rm=3",
    items: ["Entretien climatisation", "Réparation climatisation", "Entretien chauffage"],
  },
  {
    title: "Mécanicien Mobile", badgeIcon: "fa-solid fa-car",
    img: "https://images.unsplash.com/photo-1619642751034-765dfdf7c58e?w=400&q=80",
    items: ["Diagnostic de base", "Remplacement plaquettes de frein", "Remplacement batterie", "Vérification alternateur"],
  },
  {
    title: "Vidange Mobile", badgeIcon: "fa-solid fa-oil-can",
    img: "https://images.unsplash.com/photo-1625047509248-ec889cbff17f?w=400&q=80",
    items: ["Vidange standard", "Vidange fluide synthétique"],
  },
  {
    title: "Assistance Routière", badgeIcon: "fa-solid fa-triangle-exclamation",
    img: "https://images.unsplash.com/photo-1549317661-bd32c8ce0db2?w=400&q=80",
    items: ["Démarrage batterie", "Changement de pneu", "Ouverture de porte (lockout)"],
  },
  {
    title: "Organisation d'événements", badgeIcon: "fa-solid fa-calendar-days",
    img: "https://images.unsplash.com/photo-1527529482837-4698179dc6ce?w=400&q=80",
    items: ["Planification complète", "Coordination le jour"],
  },
  {
    title: "Photographie", badgeIcon: "fa-solid fa-camera",
    img: "https://images.unsplash.com/photo-1516035069371-29a1b244cc32?w=400&q=80",
    items: ["Photographie d'événements", "Portraits", "Photographie de produits"],
  },
  {
    title: "Vidéographie", badgeIcon: "fa-solid fa-video",
    img: "https://barkingsquirrelmedia.com/wp-content/uploads/2023/04/kushagra-kevat-9ESAufvpgjI-unsplash.jpg",
    items: ["Vidéos d'événements", "Drone", "Vidéos promotionnelles"],
  },
  {
    title: "Musique & Animation", badgeIcon: "fa-solid fa-headphones",
    img: "https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?w=400&q=80",
    items: ["DJ", "Groupes de musique", "Musiciens solo"],
  },
  {
    title: "Beauté & Style", badgeIcon: "fa-solid fa-spa",
    img: "https://images.unsplash.com/photo-1522337360788-8b13dee7a37e?w=400&q=80",
    items: ["Maquillage", "Coiffure", "Forfaits mariage"],
  },
  {
    title: "Services de Restauration", badgeIcon: "fa-solid fa-utensils",
    img: "https://images.unsplash.com/photo-1555244162-803834f70033?w=400&q=80",
    items: ["Aide au service", "Serveurs"],
  },
  {
    title: "Décoration d'Événements", badgeIcon: "fa-solid fa-wand-magic-sparkles",
    img: "https://images.unsplash.com/photo-1478146059778-26028b07395a?w=400&q=80",
    items: ["Décoration de salle", "Ballons & arches", "Centres de table"],
  },
  {
    title: "Location de Matériel", badgeIcon: "fa-solid fa-chair",
    img: "https://images.unsplash.com/photo-1566737236500-c8ac43014a67?w=400&q=80",
    items: ["Chaises & tables", "Vaisselle", "Tentes & chapiteaux"],
  },
  {
    title: "Réparation Ordinateurs", badgeIcon: "fa-solid fa-laptop",
    img: "https://images.unsplash.com/photo-1518779578993-ec3579fee39f?w=400&q=80",
    items: ["Réparation ordinateur portable", "Suppression de virus", "Récupération de données"],
  },
  {
    title: "Réseau & WiFi", badgeIcon: "fa-solid fa-wifi",
    img: "https://images.unsplash.com/photo-1558494949-ef010cbdcc31?w=400&q=80",
    items: ["Installation routeur", "Optimisation WiFi", "Installation réseau maison"],
  },
  {
    title: "Maison Connectée", badgeIcon: "fa-solid fa-house",
    img: "https://images.unsplash.com/photo-1558002038-1055907df827?w=400&q=80",
    items: ["Installation caméras", "Serrures intelligentes", "Éclairage intelligent"],
  },
  {
    title: "Support Technique", badgeIcon: "fa-solid fa-screwdriver",
    img: "https://images.unsplash.com/photo-1486312338219-ce68d2c6f44d?w=400&q=80",
    items: ["Configuration d'appareils", "Assistance logicielle", "Support email & comptes"],
  },
  {
    title: "Réparation Téléphones & Tablettes", badgeIcon: "fa-solid fa-mobile-screen",
    img: "https://images.unsplash.com/photo-1512054502232-10a0a035d672?w=400&q=80",
    items: ["Remplacement d'écran", "Remplacement batterie", "Réparation port de charge"],
  },
  {
    title: "Lavage auto à domicile", badgeIcon: "fa-solid fa-car-side",
    img: "https://images.unsplash.com/photo-1507136566006-cfc505b114fc?w=400&q=80",
    items: ["Nettoyage extérieur", "Nettoyage intérieur", "Lavage complet (Service à domicile uniquement)"],
  },
  {
    title: "Car Detailing", badgeIcon: "fa-solid fa-spray-can-sparkles",
    img:"https://wallpaperaccess.com/full/8857411.jpg",
    items: ["Detailing intérieur", "Detailing extérieur", "Detailing complet (Service à domicile uniquement)"],
  },
  {
    title: "Diagnostic OBD mobile", badgeIcon: "fa-solid fa-mobile-screen",
    img: "https://images.unsplash.com/photo-1580273916550-e323be2ae537?w=400&q=80",
    items: ["Diagnostic électronique", "Lecture des codes défaut", "Rapport de diagnostic (Service à domicile uniquement)"],
  },
]

const filtered = computed(() => {
  const s = q.value.trim().toLowerCase()
  if (!s) return categories
  return categories.filter((c) => {
    const hay = (c.title + " " + c.items.join(" ")).toLowerCase()
    return hay.includes(s)
  })
})
</script>

<style scoped>
/* ===== page ===== */

/* ── Hero with background image ── */
.services-hero {
  position: relative; 
  background: #f5f6fa;
  padding: 110px 0 50px;
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
  overflow: hidden;
}

/* white overlay */
.services-hero::before {
  content: "";
  position: absolute;
  inset: 0;
  background: linear-gradient(
    180deg,
    rgba(255,255,255,0.82) 0%,
    rgba(255,255,255,0.95) 100%
  );
  z-index: 0;
  pointer-events: none;
}

.services-hero > * {
  position: relative;
  z-index: 1;
}

/* ── blobs: exact position matching screenshot ── */
.hero-blobs-right {
  position: absolute;
  top: 50;
  bottom: -200px;
  right: 0;
  width: 400px;
  height: 400px;
  background-size: cover;
  background-position: top right;
  background-repeat: no-repeat;
  pointer-events: none;
  z-index: 2;
}

.hero-blobs-left {
  position: absolute;
  top: 0;
  left: 0;
  width: 280px;
  height: 220px;
  background-size: contain;
  background-position: top left;
  background-repeat: no-repeat;
  pointer-events: none;
  z-index: 2;
  transform: scaleX(-1);
}

/* ── Cards area ── */

.cards-area {
  padding-bottom: 70px;
  position: relative;   /* ← required */
  overflow: hidden;     /* ← required */
}

.cards-blob-right {
  position: absolute;
  top: 0;
  right: 0;

  width: 420px;
  height: 340px;
  background-size: contain;
  background-position: top right;
  background-repeat: no-repeat;
  pointer-events: none;
  z-index: 0;
}

.cards-blob-left {
  position: absolute;
  top: 0;
  left: 0;
  width: 280px;
  height: 220px;
  background-size: contain;
  background-position: top left;
  background-repeat: no-repeat;
  pointer-events: none;
  z-index: 0;
  transform: scaleX(-1);
}

/* make sure grid sits above blobs */
.grid-sec {
  position: relative;
  z-index: 1;
  margin-top: 24px;
}

/* ===== stats ===== */
.stats-sec { padding-top: 10px; }

.page-title {
  font-family: "Poppins", sans-serif;
  font-weight: 400;
  font-size: 48px;
  line-height: 48px;
  letter-spacing: 0.35px;
  color: #314158;
  margin: 0;
}
.page-sub {
  font-family: "Poppins", sans-serif;
  font-weight: 400;
  font-size: 20px;
  line-height: 28px;
  letter-spacing: -0.45px;
  color: #62748E;
  margin: 0 auto;
  max-width: 620px;
}

.stat-card {
  background: #fff;
  border-radius: 16px;
  border: 1px solid rgba(255,90,23,0.30);
  box-shadow: 0 6px 20px rgba(0,0,0,0.07);
  padding: 22px 14px;
  text-align: center;
}
.stat-ico {
  width: 54px;
  height: 54px;
  border-radius: 999px;
  background: #ff5a17;
  display: grid;
  place-items: center;
  margin: 0 auto 12px;
  overflow: hidden;
}
.stat-ico-img {
  width: 28px;
  height: 28px;
  object-fit: contain;
  filter: brightness(0) invert(1);
}
.stat-num {
  font-family: Inter, sans-serif;
  font-weight: 400;
  font-size: 30px;
  color: #314158;
  line-height: 36px;
  letter-spacing: 0.4px;
}
.stat-lbl {
  margin-top: 6px;
  font-family: Inter, sans-serif;
  color: rgba(31,42,68,0.55);
  font-weight: 700;
  font-size: 13px;
}

/* ===== search ===== */
.search-wrap { 

}
.search-bar {
  background: #fff;
  border-radius: 10px;
  margin-left: 50px;
  
  margin-right: 45px;
  border: 1px solid rgba(0,0,0,0.10);
  padding: 10px 16px;
  display: flex;
  align-items: center;
  gap: 10px;
  box-shadow: 0 4px 14px rgba(0,0,0,0.06);
}
.s-ico { opacity: .55; font-size: 15px; }
.s-inp {
  border: none;
  outline: none;
  width: 100%;
  font-family: Inter, sans-serif;
  font-weight: 400;
  font-size: 14px;
  line-height: 20px;
  letter-spacing: -0.15px;
  color: rgba(31,42,68,0.85);
  background: transparent;
}

/* ===== grid ===== */
.grid-sec { margin-top: 24px; }

/* ===== CARD ===== */
.svc-card {
  width: 294px;
  border-radius: 16px;
  border: 1px solid rgba(0,0,0,0.08);
  background: #fff;
  box-shadow: 0 4px 18px rgba(0,0,0,0.08);
  overflow: hidden;
  display: flex;
  flex-direction: column;
  font-family: Inter, sans-serif;
  transition: box-shadow 0.22s, transform 0.22s;
}

.svc-card:hover {
  box-shadow: 0 12px 32px rgba(255,90,23,0.16);
  transform: translateY(-3px);
}

.svc-img {
  position: relative;
  width: 100%;
  height: 175px;
  overflow: hidden;
  flex-shrink: 0;
}
.svc-img img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  display: block;
  transition: transform 0.3s;
}
.svc-card:hover .svc-img img {
  transform: scale(1.04);
}
.svc-badge {
  position: absolute;
  top: 12px;
  left: 12px;
  width: 36px;
  height: 36px;
  border-radius: 10px;
  background: rgba(255,255,255,0.95);
  display: grid;
  place-items: center;
  box-shadow: 0 3px 10px rgba(0,0,0,0.13);
}
.badge-icon {
  font-size: 15px;
  color: #FC5A15;
  line-height: 1;
}

.svc-body {
  padding: 14px;
  display: flex;
  flex: 1;
  flex-direction: column;
}
.svc-title {
  margin: 0 0 10px;
  font-family: Inter, sans-serif;
  font-weight: 700;
  font-size: 15px;
  line-height: 22px;
  letter-spacing: -0.2px;
  color: #1a2234;
}
.svc-list {
  list-style: none;
  padding: 0;
  margin: 0 0 14px;
  display: flex;
  flex-direction: column;
  gap: 8px;
  flex: 1;
}
.svc-list li {
  display: flex;
  align-items: center;
  gap: 8px;
  font-family: Inter, sans-serif;
  font-weight: 400;
  font-size: 13px;
  line-height: 19px;
  letter-spacing: -0.1px;
  color: #3d4a5c;
}
.svc-dot {
  flex-shrink: 0;
  width: 18px;
  height: 18px;
  border-radius: 999px;
  border: 1.5px solid #FC5A15;
  display: flex;
  align-items: center;
  justify-content: center;
}
.svc-dot::after {
  content: '✓';
  font-size: 10px;
  font-weight: 900;
  color: #FC5A15;
  line-height: 1;
}
.svc-btn {
  width: 100%;
  height: 40px;
  border-radius: 10px;
  border: 0;
  background: #FC5A15;
  color: #fff;
  font-family: Inter, sans-serif;
  font-weight: 600;
  font-size: 13px;
  line-height: 20px;
  letter-spacing: -0.1px;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  cursor: pointer;
  box-shadow: 0 6px 18px rgba(255,90,23,0.30);
  transition: background 0.2s;
  flex-shrink: 0;
}
.svc-btn:hover { background: #e84e0e; }
.arr { font-size: 15px; }

/* ===== responsive ===== */
@media (max-width: 1199px) {
  .svc-card { width: 100%; height: auto; min-height: 400px; }
  .services-hero { padding: 80px 0 40px; }
}
@media (max-width: 575.98px) {
  .svc-img     { height: 140px; }
  .svc-body    { padding: 12px; }
  .svc-title   { font-size: 13px; }
  .svc-list li { font-size: 12px; }
  .svc-btn     { height: 36px; font-size: 12px; }
  .hero-blobs-right,
  .hero-blobs-left { display: none; }
}
</style>