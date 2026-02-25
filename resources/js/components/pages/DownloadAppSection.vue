<template>
  <section class="app-sec py-5">
    <div class="container-xxl app-shell px-3 px-md-5">
      <div class="row align-items-center g-4 g-lg-5">

        <!-- LEFT: HAND + PHONE IMAGE -->
        <div class="col-12 col-lg-5">
          <div class="phone-wrap">
            <!-- put your own image in /src/assets and import it (see script) -->
            <img class="phone-img" :src="handPhoneImg" alt="AtlasFix app on phone" />
          </div>
        </div>

        <!-- RIGHT: TEXT -->
        <div class="col-12 col-lg-7">
          <div class="content">
            <h2 class="app-title mb-3">
              Téléchargez<br class="d-none d-md-block" />
              l’application AtlasFix
            </h2>

            <p class="app-sub mb-4">
              Trouvez le bon artisan au bon moment, directement depuis votre smartphone.
            </p>

            <div class="stores d-flex flex-wrap gap-3">
              <!-- badges -->
              <a class="store-badge" href="#" aria-label="Google Play">
                <img :src="googleBadge" alt="Get it on Google Play" />
              </a>

              <a class="store-badge" href="#" aria-label="App Store">
                <img :src="appleBadge" alt="Download on the App Store" />
              </a>
            </div>
          </div>
        </div>

      </div>
    </div>
  </section>
</template>

<script setup>
// ✅ BEST: put your screenshot image in: src/assets/hand-phone.png
// then uncomment the import below and use it.
// import handPhoneImg from "@/assets/hand-phone.png"

// TEMP (works now): use any hand+phone image URL or your own hosted asset
import  handPhoneImg from  "@/assets/iphone-mockup.png"

// Official-like badges (replace with your own assets if you want)
const googleBadge =
  "https://upload.wikimedia.org/wikipedia/commons/7/78/Google_Play_Store_badge_EN.svg"
const appleBadge =
  "https://developer.apple.com/assets/elements/badges/download-on-the-app-store.svg"
</script>

<style scoped>
.app-sec{
  background: #fff;
}

/* left image wrapper */
.phone-wrap{
  position: relative;
  border-radius: 18px;
  overflow: hidden;
}

/* make image look like screenshot: big, clean, no stretching */
.phone-img{
  width: 100%;
  height: auto;
  display: block;
  border-radius: 18px;
  filter: drop-shadow(0 22px 45px rgba(0,0,0,0.18));
}

/* right text */
.app-title{
  font-weight: 900;
  color: #111;
  font-size: clamp(30px, 3.4vw, 52px);
  line-height: 1.08;
}

.app-sub{
  color: rgba(0,0,0,0.55);
  font-weight: 800;
  font-size: 16px;
  max-width: 560px;
}

/* store badges */
.store-badge{
  display: inline-flex;
  align-items: center;
  justify-content: center;
  border-radius: 12px;
  overflow: hidden;
}
.store-badge img{
  height: 46px;
  width: auto;
  display: block;
}

/* mobile spacing like screenshot */
@media (max-width: 991.98px){
  .phone-wrap{
    max-width: 520px;
    margin: 0 auto;
  }
  .content{
    text-align: center;
  }
  .stores{
    justify-content: center;
  }
}
</style>
