<template>
  <section class="need-sec py-5">
    <div class="container-xxl app-shell px-3 px-md-5">
      <div class="need-shell">
        <div class="need-row">

          <!-- LEFT (flex) -->
          <div class="need-left">
            <h3 class="need-title mb-2">
              Vous ne trouvez pas le service qu'il vous faut ?
            </h3>

            <p class="need-desc mb-4">
              Publiez votre besoin de service et recevez les propositions de professionnels qualifiés.
              Comparez plusieurs devis et choisissez celui qui correspond le mieux à votre projet.
            </p>

            <div class="d-grid gap-3 mb-4">
              <div class="step">
                <img :src="icon1" class="step-ico" />
                <div>
                  <div class="step-name">Décrivez votre besoin</div>
                  <div class="step-sub">Dites-nous ce qui doit être fait et pour quand.</div>
                </div>
              </div>

              <div class="step">
                <img :src="icon2" class="step-ico" />
                <div>
                  <div class="step-name">Recevez des devis</div>
                  <div class="step-sub">Obtenez des réponses de prestataires intéressés.</div>
                </div>
              </div>

              <div class="step">
                <img :src="icon3" class="step-ico" />
                <div>
                  <div class="step-name">Choisissez et réservez</div>
                  <div class="step-sub">Comparez les devis et engagez le professionnel le plus adapté.</div>
                </div>
              </div>
            </div>

            <button class="btn need-cta" type="button">
              Publier mon besoin
            </button>
          </div>

          <!-- RIGHT (fixed size like Figma) -->
          <div
            class="need-right"
            :style="{ backgroundImage: `url(${bg})` }"
          >
            <div class="right-overlay"></div>

            <div class="right-content">
              <div class="right-pill">Pourquoi Publier Votre Besoin ?</div>

              <ul class="checks list-unstyled m-0 mt-3">
                <li class="check-item">Aucun engagement requis avant l'embauche</li>
                <li class="check-item">Comparez plusieurs devis côte à côte</li>
                <li class="check-item">Tous les prestataires sont vérifiés et notés</li>
                <li class="check-item">Paiement garanti et sécurité</li>
              </ul>
            </div>
          </div>

        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import bg from "@/assets/a.png"
import icon1 from "@/assets/Container0.png"
import icon2 from "@/assets/Container4.png"
import icon3 from "@/assets/Container1.png"
</script>

<style scoped>
.need-sec {
  background: #fff;
}

/* main card */
.need-shell {
  border-radius: 16px;
  box-shadow: 0 18px 45px rgba(0, 0, 0, 0.18);
  background: #fff;
  overflow: hidden;
}

/* ── Row layout ── */
.need-row {
  display: flex;
  flex-direction: column;
}

@media (min-width: 992px) {
  .need-row {
    flex-direction: row;
    align-items: stretch;
    gap: 0; /* no gap — panels are flush */
  }
}

/* ── LEFT ── */
.need-left {
  background: #fff;
  padding: 34px 30px;
}

@media (min-width: 992px) {
  .need-left {
    flex: 1;
    padding: 44px;
    display: flex;
    flex-direction: column;
    justify-content: center;
  }
}

.need-title {
  font-family: Poppins;
font-weight: 600;
font-style: Medium;
font-size: 22.61px;
line-height: 22.61px;
letter-spacing: -0.29px;
  color : #030302;
}

.need-desc {
  font-family: Poppins;
font-weight: 400;
font-style: Regular;
font-size: 15.08px;
line-height: 22.61px;
letter-spacing: -0.29px;
  color: #4A5565;
  line-height: 1.7;
}

/* steps */
.step {
  display: flex;
  gap: 14px;
  align-items: flex-start;
}

.step-ico {
  width: 46px;
  height: 46px;
  border-radius: 12px;
  border: 1px solid rgba(255, 90, 23, 0.35);
  flex-shrink: 0;
  object-fit: contain;
}

.step-name {
  font-weight: 900;
  color: rgba(0, 0, 0, 0.78);
  font-size: 14px;
}

.step-sub {
  margin-top: 2px;
  color: rgba(0, 0, 0, 0.55);
  font-weight: 700;
  font-size: 12px;
  line-height: 1.5;
}

/* CTA */
.need-cta {
  height: 44px;
  padding: 0 22px;
  border-radius: 10px;
  border: none;
  background: #ff5a17;
  color: #fff;
  font-weight: 900;
  font-size: 14px;
  box-shadow: 0 10px 22px rgba(255, 90, 23, 0.25);
  width: fit-content;
}

.need-cta:hover {
  background: #ff4a05;
}

/* ── RIGHT panel ── */
.need-right {
  position: relative;           /* required for overlay + content positioning */
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
  min-height: 300px;            /* mobile fallback height */
}

@media (min-width: 992px) {
  .need-right {
    flex: 0 0 42%;
    max-width: 572px;
    min-height: 491px;
  }
}

/* dark overlay on top of the background image */
.right-overlay {
  position: absolute;
  inset: 0;
  background: rgba(0, 0, 0, 0.58);  /* matches screenshot darkness */
  border-radius: 0;
}

/* content sits above overlay */
.right-content {
  position: relative;
  z-index: 1;
  padding: 34px 26px;
  height: 100%;
  display: flex;
  flex-direction: column;
  justify-content: flex-start;
}

@media (min-width: 992px) {
  .right-content {
    padding: 100px 44px 44px 45px;
  }
}

.right-pill {
  display: inline-block;
  background: #ff5a17;
  color: #fff;
  font-weight: 900;
  padding: 10px 18px;
  border-radius: 999px;
  font-size: 13px;
  width: fit-content;
}

/* checklist */
.checks {
  display: grid;
  gap: 16px;
}

.check-item {
  position: relative;
  padding-left: 32px;
  color: rgba(255, 255, 255, 0.92);
  font-weight: 800;
  font-size: 13px;
  line-height: 1.5;
}

.check-item::before {
  content: "✓";
  position: absolute;
  left: 0;
  top: 0;
  width: 20px;
  height: 20px;
  border-radius: 999px;
  border: 2px solid rgba(255, 255, 255, 0.85);
  display: grid;
  place-items: center;
  font-size: 11px;
  font-weight: 900;
  color: #fff;
}
</style>