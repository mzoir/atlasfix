<template>
  <div class="welcome-page">
    <div class="container-xxl app-shell px-3 px-md-5">

      <div class="row justify-content-center">
        <div class="col-12 col-lg-10 col-xl-8">

          <div class="welcome-card text-center">

            <!-- Avatar -->
            <div class="avatar mx-auto">
              👋
            </div>

            <!-- Title -->
            <h1 class="title mt-3">Bienvenue</h1>

            <!-- Subtitle -->
            <p class="sub">
              Vous êtes connecté avec succès
            </p>

            <!-- Button -->
            <RouterLink to="/" class="btn primary-btn mt-3">
              Aller à l'accueil
            </RouterLink>

          </div>

        </div>
      </div>

    </div>
  </div>
</template>

<script setup>
import { RouterLink } from "vue-router"
</script>

<style scoped>

/* spacing under fixed header */
.welcome-page{
  padding-top: 102px;
  padding-bottom: 20px;
}

/* card */
.welcome-card{
  background: #fff;
  border-radius: 18px;
  box-shadow: 0 18px 50px rgba(0,0,0,0.12);
  padding: 50px 20px;
  margin-top: 40px;
}

@media (min-width: 768px){
  .welcome-card{
    padding: 70px 80px;
  }
}

/* avatar */
.avatar{
  width: 70px;
  height: 70px;
  border-radius: 18px;
  background: #fc5a15;
  color: #fff;
  font-size: 30px;
  font-weight: 900;
  display: flex;
  align-items: center;
  justify-content: center;
}

/* typography */
.title{
  margin: 0;
  font-size: clamp(34px, 4vw, 46px);
  color: #1f2a44;
  font-weight: 900;
}

.sub{
  margin-top: 10px;
  color: rgba(31,42,68,0.65);
  font-weight: 700;
  font-size: 18px;
}

/* button */
.primary-btn{
  height: 54px;
  padding: 0 28px;
  border-radius: 10px;
  border: 2px solid #fc5a15;
  background: #fff;
  color: #fc5a15;
  font-weight: 900;
  font-size: 17px;
  text-decoration: none;
  display: inline-flex;
  align-items: center;
  justify-content: center;
}

.primary-btn:hover{
  background: rgba(252,90,21,0.06);
}

</style>
