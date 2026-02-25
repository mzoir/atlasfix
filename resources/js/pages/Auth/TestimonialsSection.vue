<template>
  <section class="wrap">
    <h2>Témoignages</h2>

    <div class="row">
      <div class="tcard" v-for="i in 3" :key="i">
        <div class="name">Guy Hawkins</div>
        <div class="role">Lorem ipsum</div>
        <div class="text">
          Un phare qui a su me guider. Très bon service, intervention rapide,
          et professionnel très respectueux.
        </div>
      </div>
    </div>
  </section>
</template>

<style scoped>
.wrap{
  width: 1440px;
  margin: 0 auto;
  padding: 40px 97px 0;
}
h2{
  margin:0;
  text-align:center;
  font-size: 26px;
  font-weight: 900;
}
.row{
  margin-top: 26px;
  display:grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 18px;
}
.tcard{
  border-radius: 16px;
  background: #fff;
  box-shadow: 0 12px 28px rgba(0,0,0,0.08);
  padding: 18px;
  min-height: 150px;
}
.name{ font-weight: 900; }
.role{ color: rgba(0,0,0,0.45); font-weight: 800; font-size: 12px; margin-top: 2px; }
.text{ margin-top: 12px; color: rgba(0,0,0,0.55); font-weight: 700; font-size: 12px; line-height: 1.6; }
</style>
