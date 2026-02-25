<template>
  <main class="app-main">
    <RouterView />
  </main>

</template>

<script setup>
import HeaderBar from "./header.vue"
import FooterBar from "./FooterBar.vue"
</script>

<style scoped>
/* Fixed header height = 102px (your design) */


/* keep page max width like figma */
:global(.app-shell){
  max-width: 1440px;
  margin: 0 auto;
}
</style>
