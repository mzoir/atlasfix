<template>
  <footer class="footer">
    <div class="frame">
      <div class="col">
        <div class="brand">Atlas<span>Fix</span></div>
        <p>
          Une plateforme complète pour trouver, réserver et évaluer vos interventions.
        </p>
      </div>

      <div class="col">
        <h4>Liens</h4>
        <a href="#">A propos</a>
        <a href="#">Services</a>
        <a href="#">Contact</a>
        <a href="#">FAQ’s</a>
      </div>

      <div class="col">
        <h4>Légal</h4>
        <a href="#">Politique de confidentialité</a>
        <a href="#">Conditions d’utilisation</a>
      </div>
    </div>

    <div class="bottom">
      © 2026 AtlasFix. All rights reserved.
    </div>
  </footer>
</template>

<style scoped>
.footer{
  margin-top: 40px;
  background: #121212;
  color: #ddd;
}
.frame{
  width: 1440px;
  margin: 0 auto;
  padding: 40px 97px;
  display:grid;
  grid-template-columns: 1.4fr 1fr 1fr;
  gap: 30px;
}
.brand{
  font-size: 28px;
  font-weight: 800;
}
.brand span{
  color: var(--orange);
}
p{ color:#aaa; font-size: 12px; line-height: 1.7; max-width: 380px; }

h4{ margin:0 0 12px; font-size: 14px; color:#fff; }
a{
  display:block;
  color:#bbb;
  text-decoration:none;
  margin: 8px 0;
  font-size: 12px;
}
a:hover{ color:#fff; }

.bottom{
  border-top: 1px solid rgba(255,255,255,0.08);
  padding: 14px 0;
  text-align:center;
  color:#999;
  font-size: 12px;
}
</style>
