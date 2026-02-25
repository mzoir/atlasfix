<template>

  <HeaderBar class="header"/>
  <main class="app-main">


    <RouterView />
  </main>

  <FooterBar />
</template>


<script setup>
import { onMounted } from "vue"
import { useRoute, useRouter } from "vue-router"
import axios from "axios"

import HeaderBar from "./header.vue"
import FooterBar from "./FooterBar.vue"

const route = useRoute()
const router = useRouter()

onMounted(() => {
  const params = new URLSearchParams(window.location.search)
  const token = params.get("token")

  if (token) {
    // save token
    localStorage.setItem("token", token)

    // remove token from URL (clean)
    window.history.replaceState({}, document.title, "/")

    // optional redirect
    window.location.reload()
  }
})




</script>




<style scoped>
/* fixed header height */
.header {

position: fixed;

  }

/* figma width */
:global(.app-shell){
  max-width: 1440px;
  margin: 0 auto;
}
</style>
