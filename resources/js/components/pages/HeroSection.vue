<!-- HeroSection.vue (FULL FILE) -->
<template>
  <section class="hero-test-sec">
    <div class="hero1440-frame" :style="{ backgroundImage: `url(${heroBg})` }">
      <!-- overlay (warm like your screenshot) -->
      <div class="hero-overlay"></div>

      <!-- content -->
      <div class="hero1440-content container-xxl app-shell px-3 px-md-5 text-center">
        <h1 class="hero-title">
          La <span class="accent">confiance</span> au cœur de<br />
          chaque <span class="accent">service</span>
        </h1>

        <p class="hero-subtitle">
          <div> Réparation, ménage, plomberie, électricité, bricolage..Trouvez et réservez les services </div>
        <div>  dont vous avez besoin en quelques clics, facilement et en toute garantie.</div>  
        </p>

        <!-- SEARCH BAR -->
        <div class="search-wrap mx-auto">
          <div class="search-left">
            <span class="sicon" aria-hidden="true">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                <path
                  d="M10.5 19a8.5 8.5 0 1 1 0-17 8.5 8.5 0 0 1 0 17Z"
                  stroke="currentColor"
                  stroke-width="2"
                />
                <path
                  d="M16.5 16.5 21 21"
                  stroke="currentColor"
                  stroke-width="2"
                  stroke-linecap="round"
                />
              </svg>
            </span>

            <span class="splaceholder">Quel service recherchez-vous ?</span>

            <span class="sdown" aria-hidden="true">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                <path
                  d="M6 9l6 6 6-6"
                  stroke="currentColor"
                  stroke-width="2"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                />
              </svg>
            </span>
          </div>

          <div class="sdiv d-none d-md-block"></div>

          <div class="search-mid d-none d-md-flex">
            <span class="splaceholder">localisation</span>
          </div>

          <button class="search-btn" type="button">Demandez votre service</button>
        </div>

        <!-- TRUST ICONS (orange like screenshot) -->
   <div class="trust-row">

  <!-- VERIFIED -->
  <div class="trust-item">
    <svg class="trust-icon" viewBox="0 0 24 24">
      <path
        d="M12 2 4 5v6c0 5 3.5 9.5 8 11 4.5-1.5 8-6 8-11V5l-8-3Z"
        fill="#FC5A15"
      />
      <path
        d="M9 12l2 2 4-4"
        stroke="#ffffff"
        stroke-width="2"
        stroke-linecap="round"
      />
    </svg>

    <div class="trust-text">Prestataires vérifiés</div>
  </div>

  <!-- PAYMENTS -->
  <div class="trust-item">
    <svg class="trust-icon" viewBox="0 0 24 24">
      <rect
        x="5"
        y="10"
        width="14"
        height="10"
        rx="2"
        fill="#FC5A15"
      />
      <path
        d="M8 10V7a4 4 0 0 1 8 0v3"
        stroke="#FC5A15"
        stroke-width="2"
        fill="none"
      />
    </svg>

    <div class="trust-text">Paiements sécurisés</div>
  </div>

  <!-- GUARANTEE -->
  <div class="trust-item">
    <svg class="trust-icon" viewBox="0 0 24 24">
      <path
        d="M12 3 4 7v6c0 4.5 3.5 8.5 8 10 4.5-1.5 8-5.5 8-10V7l-8-4Z"
        fill="#FC5A15"
      />
      <circle cx="12" cy="12" r="2.2" fill="#ffffff"/>
    </svg>

    <div class="trust-text">garantie de continuité</div>
  </div>

</div>


      </div>
    </div>
  </section>
</template>

<script setup>
import heroBg from "@/assets/hero-bg.png"
</script>

<style scoped>
/* section centers the 1440 frame */
.hero-test-sec {
  width: 100%;
  display: flex;
  justify-content: center;
}

/* hero background frame */
.hero1440-frame {
  width: min(1440px, 100%);
  height: 726px;
  position: relative;
  overflow: hidden;

  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
}

/* warm overlay (same tone as your screenshot) */
.hero-overlay {
  position: absolute;
  inset: 0;
  z-index: 1;
  background: linear-gradient(
    180deg,
    rgba(255, 244, 235, 0.35) 0%,
    rgba(255, 235, 220, 0.55) 40%,
    rgba(255, 225, 205, 0.75) 70%,
    rgba(255, 215, 190, 0.92) 90%,
    rgba(255, 210, 185, 1) 100%
  );
}

/* content above overlay */
.hero1440-content {
  position: relative;
  z-index: 2;
  padding-top: 150px;
}

/* title/subtitle */
.hero-title {
  margin: 0;
  font-size: clamp(36px, 4.2vw, 58px);
  font-weight: 600;
  line-height: 1.08;
  color: #0b0b0b;
  text-shadow: 0 3px 0 rgba(0, 0, 0, 0.08);
}
.accent {
  color: #ff5a17;
}

.hero-subtitle {
  margin: 18px auto 0;
  max-width: 980px;
  font-size: 16px;
  line-height: 1.7;
  color: rgba(0, 0, 0, 0.55);
  font-weight: 500;
}

/* search bar */
.search-wrap {
  margin-top: 26px;
  width: min(920px, 100%);
  min-height: 72px;
  border-radius: 12px;
  background: rgba(255, 255, 255, 0.92);
  box-shadow: 0 14px 30px rgba(0, 0, 0, 0.12);
  display: flex;
  align-items: center;
  padding: 10px 14px;
  gap: 12px;
  flex-wrap: wrap;
}

.search-left {
  display: flex;
  align-items: center;
  gap: 12px;
  flex: 1 1 320px;
  min-width: 0;
  color: rgba(0, 0, 0, 0.55);
}
.search-mid {
  flex: 0 0 180px;
  align-items: center;
  color: rgba(0, 0, 0, 0.55);
}

.splaceholder {
  font-weight: 600;
  font-size: 14px;
  color: rgba(0, 0, 0, 0.45);
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

.sdiv {
  width: 1px;
  height: 38px;
  background: rgba(0, 0, 0, 0.18);
}
.sdown {
  opacity: 0.7;
  display: flex;
  align-items: center;
}

.search-btn {
  height: 52px;
  padding: 0 26px;
  border-radius: 12px;
  border: none;
  background: #ff5a17;
  color: #fff;
  font-weight: 800;
  font-size: 15px;
  cursor: pointer;
  box-shadow: 0 10px 18px rgba(255, 90, 23, 0.35);
  flex: 0 0 auto;
}

@media (max-width: 767.98px) {
  .search-mid {
    display: none !important;
  }
  .search-btn {
    width: 100%;
  }
}

/* TRUST ROW */
.trust-row{
  margin: 42px auto 0;
  width: min(860px, 100%);
  display:flex;
  justify-content: space-between;
  align-items:center;
  gap: 18px;
  flex-wrap: wrap;
}

.trust-item{
  flex: 1 1 220px;
  display:flex;
  flex-direction: column;
  align-items:center;
  gap: 10px;
}

.trust-icon{
  width: 42px;
  height: 42px;
}

.trust-text{
  color: rgba(0,0,0,0.55);
  font-weight: 700;
}


.trust-text {
  color: rgba(0, 0, 0, 0.55);
  font-weight: 700;
}
</style>
