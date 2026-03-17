<template>
    <section class="services-sec py-5">

<img :src="decor" class="services-decor" alt="">

    <div class="container-xxl app-shell px-3 px-md-5">

      <div class="text-center mb-4">
        <h2 class="sec-title mb-2">Services disponibles</h2>
        <p class="sec-sub mb-0">Des artisans qualifiés pour tous vos besoins du quotidien.</p>
      </div>

      <div class="position-relative">

        <!-- arrows (desktop) -->
        <button
          class="nav-arrow start d-none d-lg-grid"
          type="button"
          aria-label="Prev"
          @click="scroll(-1)"
        >
          ‹
        </button>

        <button
          class="nav-arrow end d-none d-lg-grid"
          type="button"
          aria-label="Next"
          @click="scroll(1)"
        >
          ›
        </button>

        <!-- slider row -->
        <div ref="track" class="services-track">
          <div class="row g-4 flex-nowrap m-0">
            <div
              v-for="s in services"
              :key="s.title"
              class="col-10 col-sm-6 col-lg-3 p-0"
            >
              <article class="service-card text-center h-100">
                <div class="img-wrap">
                  <img class="w-100" :src="s.img" :alt="s.title" />
                  <div class="badge-bubble">
                  <img :src="s.icon" class="badge-ico" alt="">
                  </div>
                </div>

                <div class="service-name">{{ s.title }}</div>

                <button class="btn btn-outline-orange btn-sm-pill" type="button">
                  Voir détails
                </button>
              </article>
            </div>
          </div>
        </div>

      </div>

    </div>
  </section>
</template>

<script setup>
import { ref } from "vue"
import img from "@/assets/dr.jpg"
import img1 from "@/assets/plmobe.png"
import img2 from  "@/assets/electr.jpg"
import img3 from  "@/assets/rep.png"
import decor from "@/assets/cp.png"
import icon from "@/assets/icon.png"

import icon1 from "@/assets/Icon1.png"

import icon2 from "@/assets/Icon2.png"

import icon3 from "@/assets/Icon4.png"

const track = ref(null)

const services = [
  {
    title: "Plomberie",
    icon: icon,
    img: img,
  },
  {
    title: "Électricité",
    icon: icon1,
    img: img1,
  },
  {
    title: "Peinture",
    icon: icon2,
    img: img2,
  },
  {
    title: "Réparations générales",
    icon: icon3,
    img: img3,
  },
  
  {
    title: "Réparations générales",
    icon: icon3,
    img: img3,
  },
]

function scroll(dir) {
  if (!track.value) return
  const step = 320 // distance per click
  track.value.scrollBy({ left: dir * step, behavior: "smooth" })
}
</script>

<style scoped>
/* ✅ IMPORTANT: no extra gap with previous section */

.services-sec{
  background: #fff;
  margin: 0;
  padding-bottom: 0 !important;
  position: relative;
}

.services-decor{
  position: absolute;
  top: 60px;
  left: 0;
   width: clamp(360px, 18vw, 500px); /* responsive size */
  opacity: 0.6;
  pointer-events: none;
    z-index: 0;
}
/* Title style same vibe */
.sec-title{
  font-weight: 900;
  color: #111;
  font-size: 22px;
}
.sec-sub{
  color: rgba(0,0,0,0.55);
  font-weight: 700;
  font-size: 13px;
}

/* horizontal scroll track */
.services-track{
  overflow-x: auto;
  overflow-y: hidden;
  scroll-behavior: smooth;
  padding: 6px 2px 10px;
  -webkit-overflow-scrolling: touch;
  scrollbar-width: none;
}
.services-track::-webkit-scrollbar{ display: none; }

/* card look */
.service-card{
  background: transparent;
  border-radius: 0;
  box-shadow: none;
  padding: 14px 14px 16px;
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 10px;
  min-height: 220px;
}
/* image */
.img-wrap{
  width: 100%;
  height : 155.52713012695312;
  position: relative;
}
.img-wrap img{
  height: 150px;
  object-fit: cover;
  border-radius: 10px;
}

/* bubble badge */
/* container for the icon */
.badge-bubble {
  position: absolute;
  top : 130px;
  bottom: 10px;               /* align to bottom of image */
  left: 50%;               /* center horizontally */
  transform: translateX(-50%);
  background: transparent; /* remove white circle */
  box-shadow: none;
  width: auto;
  height: auto;
  padding: 0;
  display: flex;
  align-items: center;
  justify-content: center ;
  z-index: 1;              /* make sure it's above the image */
}

/* the icon image itself */


.badge-bubble img {
  width: 130px;               /* size of your icon */
  height: 130px;
  object-fit: contain;
  opacity: 0.9;         /* make it semi-transparent */
  transition: opacity 0.3s ease;   
               /* fully visible */
}

/* name */
.service-name{
  margin-top: 16px;
  font-weight: 900;
  color: rgba(0,0,0,0.78);
  font-size: 13px;
}

/* button (bootstrap but same style) */
.btn-outline-orange{
  border: 1px solid rgba(255,90,23,0.55);
  color: #ff5a17;
  font-weight: 900;
  background: #fff;
}
.btn-outline-orange:hover{
  border-color: #ff5a17;
  color: #ff5a17;
  background: rgba(255,90,23,0.06);
}
.btn-sm-pill{
  border-radius: 999px;
  padding: 6px 16px;
  font-size: 12px;
}

/* arrows */
.nav-arrow{
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  width: 44px;
  height: 44px;
  border-radius: 999px;
  border: 1px solid rgba(0,0,0,0.10);
  background: rgba(255,255,255,0.9);
  box-shadow: 0 10px 20px rgba(0,0,0,0.06);
  cursor: pointer;
  font-size: 28px;
  line-height: 0;
  place-items: center;
  color: rgba(0,0,0,0.55);
  z-index: 2;
}
.nav-arrow:hover{
  color: #ff5a17;
  border-color: rgba(255,90,23,0.35);
}
.nav-arrow.start{ left: -10px; }
.nav-arrow.end{ right: -10px; }
.services-sec {
  background: #fff;
  margin: 0;
  padding-bottom: 0 !important;  /* ✅ add this */
}



</style>
