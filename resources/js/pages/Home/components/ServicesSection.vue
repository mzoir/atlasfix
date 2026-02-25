<template>
  <section class="sec">
    <div class="frame">
      <h2>Services disponibles</h2>
      <p class="sub">Des artisans qualifiés pour tous vos besoins du quotidien.</p>

      <div class="row">
        <button class="arrow left" @click="scroll(-1)">‹</button>

        <div class="list" ref="listRef">
          <div class="card" v-for="s in services" :key="s.title">
            <img class="img" :src="s.img" :alt="s.title" />
            <div class="name">{{ s.title }}</div>
            <button class="small">Voir détails</button>
          </div>
        </div>

        <button class="arrow right" @click="scroll(1)">›</button>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref } from "vue"

import s1 from "../../../assets/images/s1.jpg"
import s2 from "../../../assets/images/s2.jpg"
import s3 from "../../../assets/images/s3.jpg"
import s4 from "../../../assets/images/s4.jpg"

const services = [
  { title: "Plomberie", img: s1 },
  { title: "Électricité", img: s2 },
  { title: "Peinture", img: s3 },
  { title: "Réparations générales", img: s4 },
]

const listRef = ref(null)

function scroll(dir){
  const el = listRef.value
  if(!el) return
  el.scrollBy({ left: dir * 320, behavior: "smooth" })
}
</script>

<style scoped>
.sec{
  padding: 44px 0;
  background: #fff;
}
.frame{
  width: 1440px;
  margin: 0 auto;
  padding: 0 97px;
}
h2{
  text-align:center;
  margin:0;
  font-size: 22px;
}
.sub{
  text-align:center;
  margin: 6px 0 22px;
  color:#777;
  font-size: 12px;
}

.row{
  position: relative;
  display:flex;
  align-items:center;
  gap: 12px;
}
.list{
  flex:1;
  overflow:auto;
  display:flex;
  gap: 18px;
  scroll-snap-type: x mandatory;
  padding: 10px 6px;
}
.list::-webkit-scrollbar{ height: 6px; }
.list::-webkit-scrollbar-thumb{ background:#eee; border-radius:20px; }

.card{
  width: 250px;
  background:#fff;
  border: 1px solid #eee;
  border-radius: 16px;
  padding: 12px;
  box-shadow: 0 10px 25px rgba(0,0,0,0.05);
  scroll-snap-align: start;
}
.img{
  width:100%;
  height: 120px;
  border-radius: 12px;
  object-fit: cover;
}
.name{
  margin-top: 10px;
  text-align:center;
  font-weight: 600;
  font-size: 13px;
}
.small{
  margin: 10px auto 0;
  display:block;
  height: 28px;
  padding: 0 14px;
  border-radius: 10px;
  border: 1px solid var(--orange);
  background:#fff;
  color: var(--orange);
  cursor:pointer;
  font-size: 12px;
}

.arrow{
  width: 34px;
  height: 34px;
  border-radius: 12px;
  border: 1px solid #eee;
  background:#fff;
  cursor:pointer;
  box-shadow: 0 10px 25px rgba(0,0,0,0.05);
}
</style>
