<template>
  <section class="services-page">
    <div class="container-xxl app-shell px-3 px-md-5">

      <!-- ====== STATS (Nos Services) ====== -->
      <div class="stats-sec text-center">
        <h1 class="page-title mb-2">Nos Services</h1>
        <p class="page-sub mb-4">
          Des artisans qualifiés et vérifiés pour tous vos travaux et dépannages à domicile
        </p>

        <div class="row g-3 g-md-4 justify-content-center">
          <div class="col-12 col-sm-6 col-lg-3" v-for="s in stats" :key="s.label">
            <div class="stat-card h-100">
              <div class="stat-ico">{{ s.icon }}</div>
              <div class="stat-num">{{ s.value }}</div>
              <div class="stat-lbl">{{ s.label }}</div>
            </div>
          </div>
        </div>
      </div>

      <!-- ====== SEARCH BAR ====== -->
      <div class="search-wrap mt-4 mt-md-5">
        <div class="search-bar">
          <span class="s-ico">🔎</span>
          <input
            v-model="q"
            class="s-inp"
            type="text"
            placeholder="Rechercher un service (plomberie, électricité, beauté...)"
          />
        </div>
      </div>

      <!-- ====== SERVICES GRID ====== -->
      <div class="grid-sec mt-4">
        <div class="row g-4">
          <div
            class="col-12 col-sm-6 col-lg-3"
            v-for="c in filtered"
            :key="c.title"
          >
            <article class="svc-card h-100">
              <div class="svc-img">
                <img :src="c.img" :alt="c.title" />
                <div class="svc-badge">{{ c.badgeIcon }}</div>
              </div>

              <div class="svc-body">
                <h3 class="svc-title">{{ c.title }}</h3>

                <ul class="svc-list">
                  <li v-for="(x, idx) in c.items" :key="idx">
                    <span class="dot"></span>
                    <span>{{ x }}</span>
                  </li>
                </ul>

                <button class="svc-btn mt-auto" type="button">
                  Voir les artisans <span class="arr">→</span>
                </button>
              </div>
            </article>
          </div>
          <HowItWorks  />
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { computed, ref } from "vue"
import HowItWorks from "./pages/HowItWorks.vue"
const q = ref("")

const stats = [
  { icon: "👥", value: "500+", label: "Artisans" },
  { icon: "⭐", value: "4.8/5", label: "Satisfaction" },
  { icon: "🕒", value: "24/7", label: "Disponibilité" },
  { icon: "🛡️", value: "100%", label: "Sécurisé" },
]

const categories = [
  {
    title: "Plomberie",
    badgeIcon: "💧",
    img: "https://images.unsplash.com/photo-1581579186898-0f1f5c85a4b2",
    items: ["Réparation fuite", "Installation sanitaire", "Débouchage"],
  },
  {
    title: "Électricité",
    badgeIcon: "⚡",
    img: "https://images.unsplash.com/photo-1581092160562-40aa08e78837",
    items: ["Prises & interrupteurs", "Luminaires", "Ventilateurs"],
  },
  {
    title: "Peinture",
    badgeIcon: "🧽",
    img: "https://images.unsplash.com/photo-1588854337236-6889d631faa8",
    items: ["Peinture intérieure", "Peinture extérieure"],
  },
  {
    title: "Réparations générales",
    badgeIcon: "🔧",
    img: "https://images.unsplash.com/photo-1585128792020-803d29415281",
    items: ["Montage TV", "Petites réparations"],
  },

  /* ADD MORE ↓ */

  {
    title: "Déménagement",
    badgeIcon: "📦",
    img: "https://images.unsplash.com/photo-1600585154340-be6161a56a0c",
    items: ["Transport meubles", "Emballage"],
  },
  {
    title: "Électroménager",
    badgeIcon: "🧺",
    img: "https://images.unsplash.com/photo-1581578731548-c64695cc6952",
    items: ["Lave-linge", "Réfrigérateur"],
  },
  {
    title: "Nettoyage",
    badgeIcon: "🧼",
    img: "https://images.unsplash.com/photo-1585421514738-01798e348b17",
    items: ["Standard", "Après déménagement"],
  },
  {
    title: "Climatisation",
    badgeIcon: "❄️",
    img: "https://images.unsplash.com/photo-1592928302668-2c5d1d2f0d9c",
    items: ["Installation", "Entretien"],
  },
  {
    title: "Mécanicien",
    badgeIcon: "🚗",
    img: "https://images.unsplash.com/photo-1619642751034-765dfdf7c58e",
    items: ["Diagnostic", "Freins"],
  },
  {
    title: "Photographie",
    badgeIcon: "📷",
    img: "https://images.unsplash.com/photo-1516035069371-29a1b244cc32",
    items: ["Portraits", "Événements"],
  },
  {
    title: "DJ & Animation",
    badgeIcon: "🎧",
    img: "https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4",
    items: ["DJ", "Groupes"],
  },
  {
    title: "Réparation PC",
    badgeIcon: "💻",
    img: "https://images.unsplash.com/photo-1518779578993-ec3579fee39f",
    items: ["Virus", "Hardware"],
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
/* page background like your screenshot (dark top + clean) */
.services-page{
  padding: 36px 0 70px;
}

/* ===== titles ===== */
.page-title{
  font-weight: 900;
  letter-spacing: -0.5px;
  font-size: clamp(38px, 4.5vw, 68px);
  color: rgba(255,255,255,0.95);
  margin: 0;
}
.page-sub{
  color: rgba(255,255,255,0.70);
  font-weight: 700;
  font-size: 16px;
  margin: 0 auto;
  max-width: 880px;
}

/* ===== stats cards ===== */
.stats-sec{
  padding-top: 10px;
}
.stat-card{
  background: #fff;
  border-radius: 18px;
  border: 2px solid rgba(255,90,23,0.55);
  box-shadow: 0 16px 36px rgba(0,0,0,0.35);
  padding: 26px 18px;
  text-align: center;
}
.stat-ico{
  width: 54px;
  height: 54px;
  border-radius: 999px;
  background: #ff5a17;
  color: #fff;
  display: grid;
  place-items: center;
  font-size: 20px;
  margin: 0 auto 12px;
}
.stat-num{
  font-weight: 900;
  color: #1f2a44;
  font-size: 34px;
  line-height: 1;
}
.stat-lbl{
  margin-top: 8px;
  color: rgba(31,42,68,0.60);
  font-weight: 800;
  font-size: 14px;
}

/* ===== search ===== */
.search-wrap{
  background: transparent;
}
.search-bar{
  background: #fff;
  border-radius: 12px;
  border: 1px solid rgba(0,0,0,0.12);
  padding: 10px 14px;
  display: flex;
  align-items: center;
  gap: 10px;
  box-shadow: 0 14px 30px rgba(0,0,0,0.18);
}
.s-ico{ opacity: .7; }
.s-inp{
  border: none;
  outline: none;
  width: 100%;
  font-weight: 700;
  font-size: 13px;
  color: rgba(31,42,68,0.90);
}

/* ===== grid section background becomes white like screenshot ===== */
.grid-sec{
  margin-top: 18px;
  background: #fff;
  border-radius: 18px;
  padding: 18px 16px;
}

/* cards */
.svc-card{
  border-radius: 16px;
  background: #fff;
  box-shadow: 0 12px 28px rgba(0,0,0,0.12);
  overflow: hidden;
  display: flex;
  flex-direction: column;
  height: 100%;
}
.svc-img{
  position: relative;
  height: 150px;
}
.svc-img img{
  width: 100%;
  height: 100%;
  object-fit: cover;
  display: block;
}
.svc-badge{
  position: absolute;
  top: 10px;
  left: 10px;
  width: 32px;
  height: 32px;
  border-radius: 10px;
  background: rgba(255,255,255,0.92);
  display: grid;
  place-items: center;
  box-shadow: 0 10px 18px rgba(0,0,0,0.18);
  font-size: 16px;
}

/* body with fixed spacing like screenshot */
.svc-body{
  padding: 14px 14px 16px;
  display: flex;
  flex-direction: column;
  gap: 10px;
  flex: 1;
}
.svc-title{
  margin: 0;
  font-weight: 900;
  color: rgba(31,42,68,0.90);
  font-size: 14px;
}

/* bullet list like orange dots */
.svc-list{
  list-style: none;
  padding: 0;
  margin: 0;
  display: grid;
  gap: 8px;
}
.svc-list li{
  display: flex;
  gap: 10px;
  align-items: flex-start;
  color: rgba(31,42,68,0.62);
  font-weight: 800;
  font-size: 12px;
  line-height: 1.4;
}
.dot{
  width: 10px;
  height: 10px;
  border-radius: 999px;
  border: 2px solid rgba(255,90,23,0.75);
  margin-top: 3px;
  flex: 0 0 auto;
}

/* bottom button */
.svc-btn{
  margin-top: 6px;
  height: 40px;
  border-radius: 10px;
  border: 0;
  background: #ff5a17;
  color: #fff;
  font-weight: 900;
  font-size: 12px;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  box-shadow: 0 12px 24px rgba(255,90,23,0.25);
}
.svc-btn .arr{ font-size: 14px; line-height: 0; }
.svc-btn:hover{ background: #ff4a05; }

/* responsive padding */
@media (max-width: 575.98px){
  .grid-sec{ padding: 14px 12px; }
  .svc-img{ height: 140px; }
}
</style>
