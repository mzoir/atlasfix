<template>
  <div class="container-xxl app-shell px-3 px-md-5" style="padding-top:120px;">
    <div class="alert alert-info">
      Connexion Google en cours...
    </div>
  </div>
</template>

<script setup>
import { onMounted } from "vue"
import { useRoute, useRouter } from "vue-router"
import axios from "axios"

const route = useRoute()
const router = useRouter()

onMounted(() => {
  const token = route.query.token

  if (!token) {
    router.replace("/login")
    return
  }

  localStorage.setItem("token", token)
  axios.defaults.headers.common.Authorization = `Bearer ${token}`

  router.replace("/about") // or wherever you want
})
</script>
