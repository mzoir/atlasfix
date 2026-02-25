<template>
  <header class="header">
    <div class="frame">
      <div class="left">
        <img class="logo" :src="logo" alt="AtlasFix" />
      </div>

      <nav class="nav">
        <a href="#">A propos</a>
        <a href="#">Services</a>
        <a href="#">Contact</a>
        <a href="#">FAQ’s</a>
      </nav>

      <div class="right">
        <button class="iconBtn" aria-label="notifications">
          🔔
        </button>
        <button class="btn ghost">Log in</button>
        <button class="btn primary">Sign up</button>
        <div class="lang">🇫🇷</div>
      </div>
    </div>
  </header>
</template>

<script setup>
import logo from "../../assets/images/logo.png" // mets ton logo ici
</script>

<style scoped>
.header{
  height: 102px;
  display:flex;
  align-items:center;
}
.frame{
  width: 1440px;
  margin: 0 auto;
  padding: 25px 97px;
  display:flex;
  align-items:center;
  justify-content:space-between;
  gap: 10px;
}
.logo{ height: 28px; object-fit:contain; }

.nav{
  display:flex;
  gap: 18px;
  background: rgba(255,255,255,0.85);
  border: 1px solid #eaeaea;
  padding: 10px 18px;
  border-radius: 10px;
}
.nav a{
  font-size: 13px;
  color:#333;
  text-decoration:none;
}
.right{ display:flex; align-items:center; gap: 10px; }

.iconBtn{
  width: 34px;
  height: 34px;
  border-radius: 10px;
  border: 1px solid #eaeaea;
  background: #fff;
  cursor:pointer;
}

.btn{
  height: 34px;
  padding: 0 14px;
  border-radius: 10px;
  border: 1px solid transparent;
  cursor:pointer;
  font-size: 13px;
}
.btn.ghost{
  background:#fff;
  border-color:#eaeaea;
}
.btn.primary{
  background: var(--orange);
  color:#fff;
}

.lang{
  width: 34px;
  height: 34px;
  border-radius: 10px;
  border: 1px solid #eaeaea;
  display:flex;
  align-items:center;
  justify-content:center;
  background:#fff;
}
</style>
