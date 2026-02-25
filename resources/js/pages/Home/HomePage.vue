<template>
  <div class="home">
    <HeroSection />
    <ServicesSection />
    <NeedHelpSection />
    <WhyChooseSection />
    <HowItWorksSection />
    <TestimonialsSection />
    <TopArtisansSection />
    <DownloadAppSection />
  </div>
</template>

<script setup>
import HeroSection from "./components/HeroSection.vue"
import ServicesSection from "./components/ServicesSection.vue"
import NeedHelpSection from "./components/NeedHelpSection.vue"
import WhyChooseSection from "./components/WhyChooseSection.vue"
import HowItWorksSection from "./components/HowItWorksSection.vue"
import TestimonialsSection from "./components/TestimonialsSection.vue"
import TopArtisansSection from "./components/TopArtisansSection.vue"
import DownloadAppSection from "./components/DownloadAppSection.vue"
</script>

<style scoped>
.home{
  background: #fff;
}
</style>
