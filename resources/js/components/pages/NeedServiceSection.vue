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
                <div class="step-ico">📄</div>
                <div>
                  <div class="step-name">Décrivez votre besoin</div>
                  <div class="step-sub">Dites-nous ce qui doit être fait et pour quand.</div>
                </div>
              </div>

              <div class="step">
                <div class="step-ico">🕒</div>
                <div>
                  <div class="step-name">Recevez des devis</div>
                  <div class="step-sub">Obtenez des réponses de prestataires intéressés.</div>
                </div>
              </div>

              <div class="step">
                <div class="step-ico">✅</div>
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
// ✅ Use your tools image (best):
// Put it in: src/assets/tools.png
// then do:
// import toolsImg from "@/assets/tools.png"
// const bg = toolsImg

// TEMP: use any URL (replace with your hosted / assets)
import bg from "@/assets/a.png"


</script>

<style scoped>
.need-sec{
  background: #eef1f3;
}

/* main card */
.need-shell{
  border-radius: 16px;
  box-shadow: 0 18px 45px rgba(0,0,0,0.18);
  background: #fff;
  overflow: hidden;
}

/* ✅ Desktop exact layout: left flex + right fixed */
.need-row{
  display: flex;
  flex-direction: column; /* mobile stack */
}

/* LEFT */
.need-left{
  background: #fff;
  padding: 34px 30px;
}
@media (min-width: 992px){
  .need-row{
    flex-direction: row;               /* desktop 2 columns */
    gap: 30.15px;                      /* ✅ Figma gap */
    align-items: stretch;
  }

  .need-left{
    flex: 1;                           /* left takes remaining space */
    padding: 44px;
  }
}

.need-title{
  font-weight: 900;
  font-size: 22px;
  color: #111;
}
.need-desc{
  color: rgba(0,0,0,0.55);
  font-weight: 700;
  font-size: 13px;
  line-height: 1.7;
}

/* steps */
.step{
  display: flex;
  gap: 14px;
  align-items: flex-start;
}
.step-ico{
  width: 46px;
  height: 46px;
  border-radius: 12px;
  border: 1px solid rgba(255,90,23,0.35);
  display: grid;
  color: orange;
  place-items: center;
  font-size: 18px;
}
.step-name{
  font-weight: 900;
  color: rgba(0,0,0,0.78);
  font-size: 14px;
}
.step-sub{
  margin-top: 2px;
  color: rgba(0,0,0,0.55);
  font-weight: 700;
  font-size: 12px;
  line-height: 1.5;
}

/* CTA */
.need-cta{
  height: 44px;
  padding: 0 22px;
  border-radius: 10px;
  border: none;
  background: #ff5a17;
  color: #fff;
  font-weight: 900;
  box-shadow: 0 10px 22px rgba(255,90,23,0.25);
}
.need-cta:hover{ background: #ff4a05; }

/* RIGHT panel */
.need-right{
  position: relative;
  background-size: cover;
  background-position: center;
  color: #fff;
  min-height: 260px; /* mobile */
}

/* ✅ EXACT figma dimensions on desktop */
@media (min-width: 992px){
  .need-right{
    width: 571.924560546875px;         /* ✅ Figma width */
    height: 490.8940734863281px;       /* ✅ Figma height */
    flex: 0 0 auto;
  }
}

/* overlay */
.right-overlay{
  position: absolute;
  inset: 0;
  background: rgba(0,0,0,0.55);
}

/* content padding */
.right-content{
  position: relative;
  z-index: 1;
  padding: 34px 26px;
}
@media (min-width: 992px){
  .right-content{
    padding-top: 44px;
    padding-bottom: 44px;
    padding-right: 44px;
    padding-left: 45.23px;             /* ✅ Figma padding-left */
  }
}

.right-pill{
  display: inline-block;
  background: #ff5a17;
  color: #fff;
  font-weight: 900;
  padding: 10px 16px;
  border-radius: 999px;
  font-size: 13px;
}

.checks{ display: grid; gap: 14px; }

.check-item{
  position: relative;
  padding-left: 28px;
  color: rgba(255,255,255,0.9);
  font-weight: 800;
  font-size: 13px;
  line-height: 1.5;
}
.check-item::before{
  content: "✓";
  position: absolute;
  left: 0;
  top: 0;
  width: 18px;
  height: 18px;
  border-radius: 999px;
  border: 2px solid rgba(255,255,255,0.9);
  display: grid;
  place-items: center;
  font-size: 12px;
}
</style>
