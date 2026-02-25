<template>
  <section class="testi-sec py-5">
    <div class="container-xxl app-shell px-3 px-md-5">
      <h2 class="sec-title text-center mb-4">Témoignages</h2>

      <div class="row g-4">
        <div class="col-12 col-md-6 col-lg-4" v-for="i in 3" :key="i">
          <article class="tcard h-100">
            <div class="t-top d-flex align-items-start justify-content-between">
              <div>
                <div class="name">Guy Hawkins</div>
                <div class="role">Lorem ipsum</div>
              </div>
              <div class="quote">”</div>
            </div>

            <p class="text mb-0">
              Un phare qui a su me guider. Très bon service, intervention rapide,
              et professionnel très respectueux.
            </p>
          </article>
        </div>
      </div>
    </div>
  </section>
</template>

<style scoped>
.testi-sec{
  background: #fff;
}

.sec-title{
  margin: 0;
  font-size: 26px;
  font-weight: 900;
  color: #111;
}

.tcard{
  border-radius: 16px;
  background: #fff;
  box-shadow: 0 12px 28px rgba(0,0,0,0.08);
  padding: 18px;
}

.name{
  font-weight: 900;
  color: #111;
}

.role{
  color: rgba(0,0,0,0.45);
  font-weight: 800;
  font-size: 12px;
  margin-top: 2px;
}

.text{
  margin-top: 12px;
  color: rgba(0,0,0,0.55);
  font-weight: 700;
  font-size: 12px;
  line-height: 1.6;
}

.quote{
  width: 32px;
  height: 32px;
  border-radius: 10px;
  background: rgba(255,90,23,0.10);
  border: 1px solid rgba(255,90,23,0.25);
  display: grid;
  place-items: center;
  color: #ff5a17;
  font-weight: 900;
  font-size: 18px;
  line-height: 0;
}
</style>
