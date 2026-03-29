<template>
  <footer class="footer-glass">
    <div class="container-xxl app-shell px-3 px-md-5 py-4 py-md-5">
      <div class="row g-4 align-items-start">

        <!-- Left brand -->
        <div class="col-12 col-lg-4">
       
        <!-- LEFT : LOGO -->
        <RouterLink class="logo d-inline-flex align-items-center" to="/">
          <img class="logo-img" src="../assets/Exclude1.svg" alt="AtlasFix" />
        </RouterLink>

          <p class="brand-text mb-0">
            Une plateforme complète pour trouver,<br />
            réserver et suivre vos interventions, avec des<br />
            professionnels vérifiés et un service client<br />
            toujours à votre écoute.
          </p>
        </div>

        <!-- Center -->
        <div class="col-12 col-lg-8">

          <!-- mini search -->
          <div class="footer-search w-100">
            <div class="footer-search-left">
              <span class="sicon">🔎</span>
              <span class="splaceholder">Quel service recherchez-vous ?</span>
              <span class="sdown">▾</span>
            </div>
            <div class="sdiv d-none d-md-block"></div>
            <div class="footer-search-mid d-none d-md-flex">
              <span class="splaceholder">localisation</span>
            </div>
            <button class="footer-search-btn w-20 w-md-auto">
              Demander votre service
            </button>
          </div>

          <!-- links -->
          <div class="row g-4 mt-3 mt-md-4">
            <div class="col-12 col-md-4">
              <div class="col-links">
                <RouterLink to="/about">À propos</RouterLink>
                <RouterLink to="/services">Services</RouterLink>
                <RouterLink to="/contact">Contact</RouterLink>
                <RouterLink to="/faq">FAQ's</RouterLink>
              </div>
            </div>

            <div class="col-12 col-md-4">
              <div class="col-links">
                <RouterLink to="/politique-confidentialite">Politique de Confidentialité</RouterLink>
                <RouterLink to="/conditions-generales">Conditions Générales d'Utilisation</RouterLink>
                <RouterLink to="/conseils">Page Conseils</RouterLink>
                <RouterLink to="/paiements-abonnements">Paiements & Abonnements</RouterLink>
                <RouterLink to="/resolution-litiges">Résolution des litiges</RouterLink>
              </div>
            </div>

            <div class="col-12 col-md-4">
              <div class="col-links">
                <RouterLink to="/politique-paiement">Politique de paiement</RouterLink>
                <RouterLink to="/politique-confiance">Politique de confiance et sécurité</RouterLink>
                <RouterLink to="/politique-remboursement">Politique de remboursement</RouterLink>
                <RouterLink to="/carriere">Carrière</RouterLink>
              </div>
            </div>
          </div>

        </div>
      </div>

      <hr class="footer-line my-4" />

      <div class="d-flex flex-column flex-md-row justify-content-between gap-2 footer-bottom">
        <div>© 2025 Atlas fix. All rights reserved.</div>
        <div>powered by majjane</div>
      </div>
    </div>
  </footer>
</template>

<script setup>
import { RouterLink } from "vue-router"
</script>

<style scoped>
.footer-glass {
  color: rgba(255,255,255,0.85);
  background-image:
    linear-gradient(rgba(0,0,0,0.80), rgba(0,0,0,0.80)),
    url("../assets/footer.jpg");
  backdrop-filter: blur(10px);
  background-size: cover;
  background-position: center bottom;
  background-repeat: no-repeat;
}

.brand-title {
  font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
  font-size: clamp(34px, 3.6vw, 56px);
  font-weight: 900;
  letter-spacing: -0.5px;
  color: #fff;
}
.brand-fix {
  display: inline-block;
  font-size: clamp(18px, 2vw, 32px);
  font-weight: 800;
  margin-left: 8px;
  padding: 6px 10px;
  border-radius: 12px;
  background: rgba(255,255,255,0.92);
  color: #111;
}
.brand-text {
  margin-top: 14px;
  line-height: 1.7;
  color: rgba(255,255,255,0.65);
}

.footer-search {
  min-height: 58px;
  border-radius: 12px;
  background: rgba(255,255,255,0.14);
  border: 1px solid rgba(255,255,255,0.22);
  display: flex;
  align-items: center;
  padding: 8px 10px;
  gap: 2px;
  flex-wrap: wrap;
}
.footer-search-left {
  flex: 1 1 260px;
  display: flex;
  align-items: center;
  gap: 10px;
  padding-left: 10px;
  min-width: 0;
}
.footer-search-mid {
  flex: 0 0 300px;
  align-items: center;
  padding-left: 8px;
}
.splaceholder {
  color: rgba(255,255,255,0.65);
  font-weight: 600;
  font-size: 13px;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}
.sdiv {
  width: 1px;
  height: 26px;
  background: rgba(255,255,255,0.25);
}
.footer-search-btn {
  height: 42px;
  padding: 0 18px;
  border-radius: 10px;
  border: none;
  background: #fc5a15;
  color: #fff;
  font-weight: 800;
  cursor: pointer;
  transition: background 0.2s;
}
.footer-search-btn:hover { background: #e84e0e; }

.w-md-auto { width: auto; }
@media (max-width: 767.98px) {
  .w-md-auto { width: 100%; }
}

.col-links {
  display: flex;
  flex-direction: column;
  gap: 14px;
}
.col-links a {
  text-decoration: none;
  color: rgba(255,255,255,0.75);
  font-weight: 600;
  font-size: 14px;
  transition: color 0.18s;
}
.col-links a:hover,
.col-links a.router-link-active {
  color: #fc5a15;
}

.footer-line {
  border-color: rgba(255,255,255,0.25);
  opacity: 1;
}
.footer-bottom {
  color: rgba(255,255,255,0.75);
  font-weight: 600;
  font-size: 13px;
}
</style>