<template>
  <section class="testi-sec py-5">
    <!-- right decorative hexagon image -->
    <img :src="rightBg" class="right-bg" />

    <div class="container-xxl app-shell px-3 px-md-5">
      <h2 class="sec-title text-center mb-5">Témoignages</h2>

      <div class="row g-4">
        <div class="col-12 col-md-6 col-lg-4" v-for="i in 3" :key="i">
          <article class="tcard h-100">
            <div class="t-top d-flex align-items-start justify-content-between">
              <div>
                <div class="name">Guy Hawkins</div>
                <div class="role">Lorem ipsum</div>
              </div>
              <div class="quote">"</div>
            </div>

            <p class="text mb-0">
              Ut pharetra ipsum nec leo blandit, sit amet tincidunt eros pharetra.
              Nam sed imperdiet turpis. In hac habitasse platea dictumst.
              Praesent nulla massa, hendrerit vestibulum gravida in, feugiat auctor felis.
            </p>
          </article>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import rightBg from "@/assets/righ.png"
</script>

<style scoped>
.testi-sec {
  background: #fff;
  position: relative;
  overflow: hidden;
}

/* ✅ hexagon image pinned to right, vertically centered */
.right-bg {
  position: absolute;
  top: 50%;
  right: 0;
  transform: translateY(-50%);
  width: 320px;       /* adjust to match how much shows in screenshot */
  pointer-events: none;
  user-select: none;
  z-index: 0;
}

/* push content above the bg image */
.container-xxl {
  position: relative;
  z-index: 1;
}

.sec-title {
  font-family: Poppins;
font-weight: 500;
font-style: Medium;
font-size: 40px;
line-height: 30px;
letter-spacing: -0.45px;
text-align: center;
vertical-align: middle;
  color: #0A0A0A;
}

.tcard {
  border-radius: 16px;
  background: #fff;
  Width :358.91px;


Height : 240.28px;
  box-shadow: 0 12px 28px rgba(0, 0, 0, 0.08);
  padding: 22px;
}

.name {
  font-family: Poppins;
font-weight: 600;
font-style: bold;
font-size: 21px;
line-height: 27.45px;
letter-spacing: 0.2%;
vertical-align: bottom;

  color: #0A0A0A;
}

.role {
  color: rgba(0, 0, 0, 0.45);
  font-family: Public Sans;
font-weight: 400;
font-style: Regular;
font-size: 13.73px;
line-height: 20.59px;
letter-spacing: 0%;
vertical-align: bottom;

  font-weight: 800;
  font-size: 12px;
  margin-top: 2px;
}

.text {
  margin-top: 16px;
  color: rgba(0, 0, 0, 0.55);
  font-weight: 700;
  font-size: 12px;
  line-height: 1.7;
}

/* orange quote mark — matching screenshot style */
.quote {
  color: #ff5a17;
  font-size: 48px;
  font-weight: 900;
  line-height: 1;
  flex-shrink: 0;
}
</style>