<template>
  <section class="about-sec py-5">
    <div class="container-xxl app-shell px-3 px-md-5">
      <div class="row align-items-center g-4 g-lg-5">

        <!-- LEFT IMAGE -->
        <div class="col-12 col-lg-6">
          <div
            class="img-box"
            :style="{ backgroundImage: `url(${imgUrl})` }"
          >
            <div class="count-badge">
              <div class="num">
                128 <span class="plus">+</span>
              </div>
              <div class="txt">des artisans</div>
            </div>
          </div>
        </div>

        <!-- RIGHT TEXT -->
        <div class="col-12 col-lg-6 pt-0 pb-0">
          <div class="ps-lg-2  pt-0 ">
            <div class="small-line d-flex  pt-0 gap-2 mb-2 ">
              <span class="mini-bar"></span>
              <span class="small-txt">Pourquoi choisir AtlasFix ?</span>
            </div>

            <h2 class="big-title mb-4">
              La confiance, au cœur de<br class="d-none d-md-block" />
              notre plateforme
            </h2>

            <div class="d-grid gap-3">

              <div class="feat d-flex align-items-start gap-3">
                <div class="feat-ico">🛡️</div>
                <div>
                  <div class="feat-title">Artisans vérifiés</div>
                  <div class="feat-desc">Documents, certifications et contrôles manuels.</div>
                </div>
              </div>

              <div class="feat d-flex align-items-start gap-3">
                <div class="feat-ico">⚡</div>
                <div>
                  <div class="feat-title">Réservation simple et rapide</div>
                  <div class="feat-desc">Planifiez votre service en quelques minutes.</div>
                </div>
              </div>

              <div class="feat d-flex align-items-start gap-3">
                <div class="feat-ico">🔒</div>
                <div>
                  <div class="feat-title">Paiements sécurisés</div>
                  <div class="feat-desc">En ligne ou à la livraison.</div>
                </div>
              </div>

              <div class="feat d-flex align-items-start gap-3">
                <div class="feat-ico">⭐</div>
                <div>
                  <div class="feat-title">Évaluations transparentes</div>
                  <div class="feat-desc">Avis authentiques de clients réels.</div>
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
import  imgUrl  from "@/assets/ReplaceThis.jpg"
</script>

<style scoped>
.about-sec{
  background: #fff;
}
/* left image card */
.img-box{
  position: relative;
  height: 640px;
  width: 619px;
  border-radius: 18px;
  background-size: cover;
  background-position: center top;
  box-shadow: 0 16px 40px rgba(0,0,0,0.12);
  overflow: hidden;
  
}

/* badge top-right */
.count-badge{
  position: absolute;
  top: 18px;
  right: 18px;
  padding: 14px 18px;
  border-radius: 14px;
  background: rgba(255,255,255,0.92);
  box-shadow: 0 12px 24px rgba(0,0,0,0.12);
  text-align: center;
  font-weight: 900;
  min-width: 140px;
}
.num{
  font-size: 34px;
  line-height: 1;
  color: #111;
}
.plus{
  color: #ff5a17;
  margin-left: 4px;
}
.txt{
  margin-top: 6px;
  font-size: 13px;
  color: rgba(0,0,0,0.55);
  font-weight: 800;
}

/* small heading line */
.small-txt{
  color: rgba(0,0,0,0.45);
  font-weight: 900;
  font-size: 14px;
}
.mini-bar{
  width: 2px;
  height: 16px;
  background: rgba(0,0,0,0.20);
  border-radius: 999px;
}

/* big title */
.big-title{
  font-weight: 900;
  color: #111;
  font-size: clamp(28px, 3.2vw, 44px);
  line-height: 1.08;
}

/* feature rows */
.feat-ico{
  width: 44px;
  height: 44px;
  border-radius: 12px;
  background: rgba(255,90,23,0.10);
  border: 1px solid rgba(255,90,23,0.25);
  display: grid;
  place-items: center;
  font-size: 18px;
  flex: 0 0 auto;
}

.feat-title{
  font-weight: 900;
  color: rgba(0,0,0,0.84);
  font-size: 16px;
}
.feat-desc{
  margin-top: 4px;
  color: rgba(0,0,0,0.55);
  font-weight: 700;
  font-size: 14px;
  line-height: 1.5;
}

</style>
