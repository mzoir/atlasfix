<template>
  <section class="py-5 bg-white">
    <div class="container-xxl px-3 px-md-5">
      <h2 class="text-center fw-black mb-4">Comment ça marche ?</h2>

      <div class="row g-4">
        <!-- STEP 1 -->
        <div class="col-12 col-sm-6 col-lg-3">
          <div class="step-card h-100 text-center p-4">
            <div class="step-dot mb-3">1</div>
            <div class="fw-black">Cherchez un service</div>
            <div class="text-muted small fw-semibold mt-2">Décrivez votre besoin.</div>
          </div>
        </div>

        <!-- STEP 2 -->
        <div class="col-12 col-sm-6 col-lg-3">
          <div class="step-card h-100 text-center p-4">
            <div class="step-dot mb-3">2</div>
            <div class="fw-black">Choisissez un artisan vérifié</div>
            <div class="text-muted small fw-semibold mt-2">Consultez les profils et avis.</div>
          </div>
        </div>

        <!-- STEP 3 -->
        <div class="col-12 col-sm-6 col-lg-3">
          <div class="step-card h-100 text-center p-4">
            <div class="step-dot mb-3">3</div>
            <div class="fw-black">Réservez &amp; payez</div>
            <div class="text-muted small fw-semibold mt-2">Processus simple et sécurisé.</div>
          </div>
        </div>

        <!-- STEP 4 -->
        <div class="col-12 col-sm-6 col-lg-3">
          <div class="step-card h-100 text-center p-4">
            <div class="step-dot mb-3">4</div>
            <div class="fw-black">Évaluez le service</div>
            <div class="text-muted small fw-semibold mt-2">Aidez la communauté.</div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<style scoped>
/* Bootstrap-first: only custom parts */
.fw-black { font-weight: 900; }

.step-card{
  border-radius: 16px;
  background: #fff;
  box-shadow: 0 12px 28px rgba(0,0,0,0.08);
}

.step-dot{
  width: 46px;
  height: 46px;
  border-radius: 999px;
  background: #ff5a17;
  color: #fff;
  display: grid;
  place-items: center;
  font-weight: 900;
  margin-inline: auto;
}
</style>
