<template>
  <div class="page">
    <!-- HERO: photo background behind header+hero -->
    <section class="sec sec-hero atlas-sec" :style="heroStyle">
      <HeroSection />
    </section>

    <!-- Services: mosaic pattern -->
    <section class="sec sec-pattern atlas-sec" :style="patternStyle">
      <ServicesSection />
    </section>

    <!-- Need service: keep white (or pattern if you want) -->
    <section class="sec atlas-sec">
      <NeedServiceSection />
    </section>

    <!-- Why choose: white / light -->
    <section class="sec atlas-sec">
      <WhyChooseSection />
    </section>

    <!-- How it works: brick background -->
    <section class="sec sec-brick atlas-sec" :style="brickStyle">
      <HowItWorksSection />
    </section>

    <!-- Testimonials + Top artisans: mosaic pattern -->
    <section class="sec sec-pattern atlas-sec" :style="patternStyle">
      <TestimonialsSection />
      <TopArtisansSection />
    </section>

    <!-- Download app: mosaic (or white) -->
    <section class="sec sec-pattern atlas-sec" :style="patternStyle">
      <DownloadAppSection />
    </section>
  </div>
</template>

<script setup>
import HeroSection from "../pages/HeroSection.vue";
import ServicesSection from "../pages/ServicesSection.vue";
import NeedServiceSection from "../pages/NeedServiceSection.vue";
import WhyChooseSection from "./WhyChooseSection.vue";
import HowItWorksSection from "./HowItWorks.vue";
import TestimonialsSection from "./TestimonialsSection.vue";
import TopArtisansSection from "./TopArtisansSection.vue";
import DownloadAppSection from "./DownloadAppSection.vue";

/* ✅ Use Vite-safe URLs (no broken path) */
const heroBg  = new URL("../common/hero-bg.png", import.meta.url).href
const pattern = new URL("../common/pattern.png", import.meta.url).href
const brick   = new URL("../common/brick.png", import.meta.url).href

const heroStyle    = { '--hero-bg': `url(${heroBg})` }
const patternStyle = { '--pattern-bg': `url(${pattern})` }
const brickStyle   = { '--brick-bg': `url(${brick})` }
</script>

<style scoped>
.page{
  width: 100%;
  overflow-x: hidden;
}

.sec{
  width: 100%;
  background: transparent;
}


.sec-white{
  background: #ffffff;
}

/* Important so backgrounds work */
.atlas-sec{
  position: relative;
  overflow: hidden;
}
.atlas-sec > *{
  position: relative;
  z-index: 2; /* content above backgrounds */
}

/* HERO background */

.sec-hero::after{
  content:"";
  position:absolute;
  inset:0;
  background: linear-gradient(
    180deg,
    rgba(255,255,255,0.10) 0%,
    rgba(255,255,255,0.35) 55%,
    rgba(255,255,255,0.85) 100%
  );
  z-index: 1;
}

/* Mosaic pattern (left + right) */
.sec-pattern::before,
.sec-pattern::after{
  content:"";
  position:absolute;
  width: 440px;
  height: 440px;
  background-image: var(--pattern-bg);
  background-repeat: no-repeat;
  background-size: contain;
  opacity: .75;
  z-index: 0;
  pointer-events:none;
}
.sec-pattern::before{
  left: -140px;
  top: 40px;
}
.sec-pattern::after{
  right: -160px;
  bottom: 40px;
}

/* Brick texture */
.sec-brick::before{
  content:"";
  position:absolute;
  inset:0;
  background-image: var(--brick-bg);
  background-repeat: repeat;
  background-size: 900px auto;
  opacity: .18;
  z-index: 0;
  pointer-events:none;
}
</style>
