<template>
  <section class="how-sec py-5" :style="{ backgroundImage: `url(${funfact})` }">
    <div class="container-xxl px-3 px-md-5">
      <h2 class="text-center fw-black mb-5">Comment ça marche ?</h2>

      <div class="steps-row">

        <!-- STEP 1 -->
        <div class="step-item">
          <div class="icon-wrap">
            <div class="step-badge">1</div>
            <img :src="search" class="step-img" />
          </div>
          <div class="step-title">Cherchez un service</div>
          <div class="step-desc">Filtrez selon votre besoin.</div>
        </div>

        <div class="connector"></div>

        <!-- STEP 2 -->
        <div class="step-item">
          <div class="icon-wrap">
            <div class="step-badge">2</div>
            <img :src="artisan" class="step-img" />
          </div>
          <div class="step-title">Choisissez un artisan vérifié</div>
          <div class="step-desc">Consultez les profils et avis.</div>
        </div>

        <div class="connector"></div>

        <!-- STEP 3 -->
        <div class="step-item">
          <div class="icon-wrap">
            <div class="step-badge">3</div>
            <img :src="reserve" class="step-img" />
          </div>
          <div class="step-title">Réservez &amp; payez</div>
          <div class="step-desc">Processus simple et sécurisé.</div>
        </div>

        <div class="connector"></div>

        <!-- STEP 4 -->
        <div class="step-item">
          <div class="icon-wrap">
            <div class="step-badge">4</div>
            <img :src="evaluate" class="step-img" />
          </div>
          <div class="step-title">Évaluez le service</div>
          <div class="step-desc">Aidez la communauté à faire les bons choix.</div>
        </div>

      </div>
    </div>
  </section>
</template>

<script setup>
import funfact   from "@/assets/Funfact.png"
import search    from "@/assets/Container (15).png"
import artisan   from "@/assets/Container (16).png"
import reserve   from "@/assets/Container (17).png"
import evaluate  from "@/assets/Container (18).png"
</script>

<style scoped>
.fw-black { font-weight: 900; }

.how-sec {
  background-color: #fff;
  background-repeat: no-repeat;
  background-position: bottom center;
  background-size: cover;
}

h2 {
  font-size: clamp(26px, 3vw, 38px);
  color: #111;
}

/* ── horizontal row ── */
.steps-row {
  display: flex;
  align-items: flex-start;
  justify-content: center;
  gap: 0;
}

/* connector line between steps */
.connector {
  flex: 1;
  height: 2px;
  background: #d1d5db;
  margin-top: 36px;   /* aligns with center of icon */
  max-width: 120px;
}

/* each step */
.step-item {
  display: flex;
  flex-direction: column;
  align-items: center;
  text-align: center;
  width: 160px;
  flex-shrink: 0;
}

/* icon circle + badge wrapper */


/* orange circle background */

.step-img {

  position: relative;
  z-index: 1;
  width: 90px;
  height: 90px;
  object-fit: contain;
  padding: 14px;
}

/* numbered badge top-right */
.step-badge {
  position: absolute;
  top: -4px;
  right: -4px;
  z-index: 2;
  width: 2px;
  height: 2px;
  border-radius: 999px;
  background: #ff5a17;
  border: 2px solid #fff;
  color: #fff;
  font-size: 11px;
  font-weight: 900;
  display: grid;
  place-items: center;
}

.step-title {
  font-weight: 900;
  font-size: 13px;
  color: rgba(0, 0, 0, 0.45);
  margin-bottom: 6px;
}

.step-desc {
  font-size: 13px;
  font-weight: 700;
  color: #111;
  line-height: 1.5;
}

/* mobile: stack vertically */
@media (max-width: 767px) {
  .steps-row {
    flex-direction: column;
    align-items: center;
    gap: 24px;
  }
  .connector {
    width: 2px;
    height: 32px;
    margin-top: 0;
    flex: none;
  }
}
</style>