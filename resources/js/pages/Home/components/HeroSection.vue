<template>
  <section class="hero">
    <div class="overlay"></div>

    <div class="frame content">
      <h1 class="title">
        La <span>confiance</span> au coeur de<br />
        chaque <span>service</span>
      </h1>

      <p class="desc">
        Réparation, ménage, plomberie, électricité, bricolage... Trouvez et réservez les services
        dont vous avez besoin en quelques clics, facilement et en toute garantie.
      </p>

      <div class="searchRow">
        <div class="input">
          <span class="ico">🔍</span>
          <input placeholder="Quel service recherchez-vous ?" />
          <span class="caret">▾</span>
        </div>

        <div class="input">
          <span class="ico">📍</span>
          <input placeholder="Localisation" />
        </div>

        <button class="cta">Demandez votre service</button>
      </div>

      <div class="kpis">
        <div class="kpi">
          <div class="kpiIco">🛡️</div>
          <div class="kpiTxt">Prestataires vérifiés</div>
        </div>
        <div class="kpi">
          <div class="kpiIco">🔒</div>
          <div class="kpiTxt">Paiements sécurisés</div>
        </div>
        <div class="kpi">
          <div class="kpiIco">⚙️</div>
          <div class="kpiTxt">Garantie de continuité</div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import heroBg from "../../../assets/images/hero.jpg" // mets ton image ici
</script>

<style scoped>
.hero{
  position: relative;
  height: 565px; /* comme ton figma */
  background:  rgba(255,255,255,0.75);
}
.overlay{
  position:absolute; inset:0;
  background: rgba(255,255,255,0.75);
}
.frame{
  width: 1440px;
  margin: 0 auto;
  padding: 0 97px;
}
.content{
  position: relative;
  z-index: 1;
  padding-top: 120px;
}
.title{
  font-size: 44px;
  line-height: 1.1;
  text-align:center;
  margin: 0;
  color: #111;
  font-weight: 700;
}
.title span{ color: var(--orange); }
.desc{
  width: 760px;
  margin: 14px auto 0;
  text-align:center;
  color:#555;
  font-size: 13px;
  line-height: 1.6;
}

.searchRow{
  width: 900px;
  margin: 24px auto 0;
  background: rgba(255,255,255,0.85);
  border-radius: 12px;
  border: 1px solid #eee;
  padding: 10px;
  display:flex;
  gap: 10px;
  align-items:center;
}
.input{
  flex: 1;
  height: 44px;
  border-radius: 10px;
  border: 1px solid #eee;
  background: #fff;
  display:flex;
  align-items:center;
  gap: 8px;
  padding: 0 12px;
}
.input input{
  border: none;
  outline:none;
  flex:1;
  font-size: 13px;
}
.ico{ opacity:.7; }
.caret{ opacity:.6; }

.cta{
  height: 44px;
  padding: 0 18px;
  border-radius: 10px;
  border:none;
  background: var(--orange);
  color:#fff;
  font-weight: 600;
  cursor:pointer;
}

.kpis{
  margin-top: 30px;
  display:flex;
  justify-content:center;
  gap: 60px;
}
.kpi{
  display:flex;
  flex-direction:column;
  align-items:center;
  gap: 6px;
}
.kpiIco{
  width: 34px;
  height: 34px;
  display:flex;
  align-items:center;
  justify-content:center;
  border-radius: 10px;
  background: rgba(255,106,0,0.12);
}
.kpiTxt{
  font-size: 12px;
  color:#444;
}
</style>
