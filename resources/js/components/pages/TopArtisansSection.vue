<template>
  <section class="best-sec py-5">
    <div class="container-xxl app-shell px-3 px-md-5 text-center">

      <h2 class="best-title mb-2">Nos artisans les mieux notés</h2>
      <p class="best-sub mb-4">
        Des professionnels bien notés, prêts à vous aider dans vos projets.
      </p>

      <div class="position-relative">

        <!-- arrows -->
        <button class="navA left d-none d-lg-grid" type="button" aria-label="Prev" @click="scroll(-1)">‹</button>
        <button class="navA right d-none d-lg-grid" type="button" aria-label="Next" @click="scroll(1)">›</button>

        <!-- track -->
        <div ref="track" class="track">
          <div class="row flex-nowrap g-4 m-0">
            <div class="col-11 col-sm-7 col-lg-4 p-0" v-for="a in artisans" :key="a.name">
              <article class="aCard h-100">

                <!-- header -->
                <div class="aTop d-flex gap-3">
                  <div class="aAvatar"></div>

                  <div class="aMeta text-start">
                    <div class="d-flex align-items-center gap-2">
                      <div class="aName">{{ a.name }}</div>
                      <span class="verify">✓</span>
                    </div>

                    <div class="aSpec">{{ a.spec }}</div>

                    <div class="aLoc d-flex align-items-center gap-2">
                      <span class="pin">⦿</span>
                      <span>{{ a.city }}</span>
                    </div>

                    <div class="aRate d-flex align-items-center gap-2">
                      <span class="star">★</span>
                      <span class="rateTxt">{{ a.rating }}</span>
                      <span class="rateSmall">({{ a.reviews }} avis)</span>
                    </div>
                  </div>
                </div>

                <!-- body (fixed height like screenshot) -->
                <div class="aBody text-start">
                  <div class="aAbout">À propos</div>
                  <p class="aDesc">
                    {{ a.about }}
                  </p>

                  <div class="aLast">
                    <div class="aLastTitle">Dernier avis de Michael 5/5</div>
                    <div class="aLastTime">Mardi à 14h</div>
                    <div class="aLastGood">Excellent travail</div>
                  </div>
                </div>

                <!-- buttons pinned bottom -->
                <div class="aBtns d-flex gap-2">
                  <button class="btnP ghost flex-fill" type="button">Voir le profil</button>
                  <button class="btnP solid flex-fill" type="button">Contacter</button>
                </div>

              </article>
            </div>
          </div>
        </div>

        <!-- dots -->
        <div class="dots mt-4 d-flex justify-content-center gap-2">
          <span v-for="i in 5" :key="i" class="dot" :class="{ active: i === 2 }"></span>
        </div>

      </div>
    </div>
  </section>
</template>

<script setup>
import { ref } from "vue"
const track = ref(null)

const artisans = [
  {
    name: "Max Johnson",
    spec: "Spécialiste en Rénovation de Maison",
    city: "Casablanca",
    rating: "4.8/5",
    reviews: 89,
    about:
      "J’offre des services professionnels de rénovation pour vous accompagner dans tous vos projets d’amélioration de l’habitat, des petites réparations aux rénovations complètes. Un travail de qualité, garanti avec une grande attention aux détails.",
  },
  {
    name: "Max Johnson",
    spec: "Spécialiste en Rénovation de Maison",
    city: "Casablanca",
    rating: "4.8/5",
    reviews: 89,
    about:
      "J’offre des services professionnels de rénovation pour vous accompagner dans tous vos projets d’amélioration de l’habitat, des petites réparations aux rénovations complètes. Un travail de qualité, garanti avec une grande attention aux détails.",
  },
  {
    name: "Max Johnson",
    spec: "Spécialiste en Rénovation de Maison",
    city: "Casablanca",
    rating: "4.8/5",
    reviews: 89,
    about:
      "J’offre des services professionnels de rénovation pour vous accompagner dans tous vos projets d’amélioration de l’habitat, des petites réparations aux rénovations complètes. Un travail de qualité, garanti avec une grande attention aux détails.",
  },
]

function scroll(dir) {
  if (!track.value) return
  track.value.scrollBy({ left: dir * 380, behavior: "smooth" })
}
</script>

<style scoped>
.best-sec{
  background: #fff;
}

/* title */
.best-title{
  font-weight: 900;
  font-size: clamp(28px, 3vw, 44px);
  color: #111;
}
.best-sub{
  color: rgba(0,0,0,0.55);
  font-weight: 700;
}

/* track */
.track{
  overflow-x: auto;
  overflow-y: hidden;
  scroll-behavior: smooth;
  -webkit-overflow-scrolling: touch;
  padding: 10px 4px;
  scrollbar-width: none;
}
.track::-webkit-scrollbar{ display:none; }

/* card = fixed height like screenshot */
.aCard{
  background: #fff;
  border-radius: 16px;
  box-shadow: 0 14px 30px rgba(0,0,0,0.12);
  padding: 18px;
  display: flex;
  flex-direction: column;
  min-height: 430px;        /* ✅ key: same height */
}

/* header */
.aAvatar{
  width: 92px;
  height: 92px;
  border-radius: 999px;
  background: #f2f2f2;
  border: 2px solid rgba(255,90,23,0.55);
  flex: 0 0 auto;
}
.aMeta{ flex: 1; }

.aName{
  font-weight: 900;
  color: #1f2a44;
}
.verify{
  width: 18px;
  height: 18px;
  border-radius: 999px;
  background: rgba(0, 120, 255, 0.12);
  color: #1a73e8;
  display: grid;
  place-items: center;
  font-size: 12px;
  font-weight: 900;
}

.aSpec{
  margin-top: 2px;
  font-size: 12px;
  color: rgba(31,42,68,0.55);
  font-weight: 800;
}
.aLoc{
  margin-top: 6px;
  font-size: 13px;
  color: rgba(31,42,68,0.75);
  font-weight: 800;
}
.pin{ font-size: 12px; opacity: .7; }

.aRate{
  margin-top: 6px;
  font-size: 13px;
  font-weight: 900;
}
.star{ color: #ff5a17; }
.rateTxt{ color: rgba(31,42,68,0.85); }
.rateSmall{ color: rgba(31,42,68,0.55); font-weight: 800; }

/* BODY fixed height */
.aBody{
  margin-top: 14px;
  flex: 1;                 /* ✅ takes remaining space */
  display: flex;
  flex-direction: column;
}
.aAbout{
  font-weight: 900;
  color: rgba(31,42,68,0.9);
  margin-bottom: 8px;
}
.aDesc{
  color: rgba(31,42,68,0.62);
  font-weight: 700;
  font-size: 12px;
  line-height: 1.6;

  /* ✅ this makes the text area same height like screenshot */
  height: 130px;
  overflow: hidden;
}

/* last review pinned under text */
.aLast{
  margin-top: 10px;
  font-size: 12px;
}
.aLastTitle{
  color: rgba(31,42,68,0.85);
  font-weight: 900;
}
.aLastTime{
  margin-top: 4px;
  color: rgba(31,42,68,0.55);
  font-weight: 800;
}
.aLastGood{
  margin-top: 4px;
  color: #0a8f2a;
  font-weight: 900;
}

/* buttons pinned bottom */
.aBtns{
  margin-top: 14px;
}

/* buttons */
.btnP{
  height: 38px;
  border-radius: 999px;
  font-weight: 900;
  font-size: 13px;
  border: 1px solid rgba(0,0,0,0.10);
  background: #fff;
  cursor: pointer;
}
.btnP.ghost{
  background: #f0f0f0;
  border-color: transparent;
  color: rgba(31,42,68,0.9);
}
.btnP.solid{
  background: #ff5a17;
  border: 0;
  color: #fff;
}
.btnP.solid:hover{ background: #ff4a05; }

/* arrows */
.navA{
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
.navA.left{ left: -10px; }
.navA.right{ right: -10px; }
.navA:hover{
  color: #ff5a17;
  border-color: rgba(255,90,23,0.35);
}

/* dots */
.dot{
  width: 8px;
  height: 8px;
  border-radius: 999px;
  background: rgba(0,0,0,0.18);
}
.dot.active{
  background: #ff5a17;
  width: 10px;
  height: 10px;
}
</style>
