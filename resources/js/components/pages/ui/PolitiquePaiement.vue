<template>
  <div class="policy-page">
    <div class="container py-5">

      <div class="page-header mt-3">
        <div class="page-icon" style="background: rgba(255,90,23,0.12);">
          <i class="fa-solid fa-credit-card" style="color:#fc5a15;font-size:22px;"></i>
        </div>
        <div>
          <h1 class="page-title">Politique de Paiement</h1>
          <p class="page-date">Dernière mise à jour : 23 décembre 2024</p>
        </div>
      </div>

      <div class="intro-box mt-4">
        <i class="fa-regular fa-circle-dot" style="color:#fc5a15;"></i>
        <p>Chez <strong>AtlasFix</strong> nous nous engageons à garantir des paiements simples, sécurisés et transparents pour tous nos clients et prestataires. Cette page détaille les règles de paiement, les frais appliqués et la gestion des situations particulières.</p>
      </div>

      <!-- Section 1 -->
      <div class="section-block mt-5">
        <div class="section-num">1</div>
        <h2 class="section-title">Paiement complet et réservation</h2>
        <div class="alert-box green mt-3">
          <i class="fa-solid fa-circle-check" style="color:#0a8f2a;"></i>
          <span>Pour qu'une réservation soit confirmée, le paiement doit être intégral.</span>
        </div>
        <div class="alert-box yellow mt-2">
          <i class="fa-solid fa-circle-info" style="color:#f5a623;"></i>
          <span>Si le paiement est incomplet, la réservation sera bloquée et restera en attente jusqu'au règlement complet.</span>
        </div>
        <div class="info-box grey mt-2">
          Cette mesure permet de garantir que vos services ou rendez-vous soient réservés de manière fiable.
        </div>
      </div>

      <!-- Section 2 -->
      <div class="section-block mt-5">
        <div class="section-num">2</div>
        <h2 class="section-title">Paiement en trop</h2>
        <div class="alert-box purple mt-3">
          <i class="fa-solid fa-rotate" style="color:#8a2be2;"></i>
          <div>
            <p class="mb-1">Si vous payez plus que le montant convenu, l'excédent sera remboursé sous <strong>7 jours.</strong></p>
            <p class="mb-0 text-muted" style="font-size:13px;">La commission de la plateforme sera toujours calculée uniquement sur le prix convenu pour le service.</p>
          </div>
        </div>
      </div>

      <!-- Section 3 -->
      <div class="section-block mt-5">
        <div class="section-num">3</div>
        <h2 class="section-title">Frais de transaction (charge halal de service)</h2>
        <p class="section-sub">Afin de couvrir les coûts liés à la plateforme et aux paiements, nous appliquons des frais de service transparents :</p>

        <div class="row g-3 mt-3">
          <div class="col-12 col-md-6">
            <div class="option-card orange-option">
              <div class="option-num orange-num">1</div>
              <div class="option-label">Option 1</div>
              <div class="option-value">3%</div>
              <div class="option-desc">du montant par réservation</div>
              <div class="option-tag orange-tag">Plafonné à 20 MAD maximum</div>
            </div>
          </div>
          <div class="col-12 col-md-6">
            <div class="option-card blue-option">
              <div class="option-num blue-num">2</div>
              <div class="option-label">Option 2</div>
              <div class="option-value blue-val">5 MAD</div>
              <div class="option-desc">par réservation</div>
              <div class="option-tag blue-tag">Forfait fixe</div>
            </div>
          </div>
        </div>

        <div class="alert-box green mt-3">
          <i class="fa-solid fa-circle-check" style="color:#0a8f2a;"></i>
          <div>
            <p class="mb-1"><strong>Ces frais sont une charge de service et ne constituent pas un intérêt (riba).</strong></p>
            <p class="mb-0 text-muted" style="font-size:13px;">Ils sont affichés clairement à chaque réservation pour garantir la transparence totale.</p>
          </div>
        </div>
      </div>

      <!-- Section 4 -->
      <div class="section-block mt-5">
        <div class="section-num">4</div>
        <h2 class="section-title">Sécurité et transparence</h2>

        <div class="feature-row mt-3">
          <div class="feature-ico blue-ico-s"><i class="fa-solid fa-lock"></i></div>
          <div>
            <div class="feature-title">Paiements sécurisés</div>
            <div class="feature-desc">Tous les paiements sur <strong>AtlasFix</strong> sont sécurisés grâce à nos partenaires de paiement certifiés.</div>
          </div>
        </div>
        <div class="feature-row mt-3">
          <div class="feature-ico green-ico-s"><i class="fa-solid fa-circle-check"></i></div>
          <div>
            <div class="feature-title">Aucun frais caché</div>
            <div class="feature-desc">Vous savez exactement ce que vous payez, et quand.</div>
          </div>
        </div>
        <div class="feature-row mt-3">
          <div class="feature-ico purple-ico-s"><i class="fa-solid fa-rotate"></i></div>
          <div>
            <div class="feature-title">Remboursements rapides</div>
            <div class="feature-desc">Les remboursements sont traités rapidement et en toute sécurité, pour votre tranquillité d'esprit.</div>
          </div>
        </div>
      </div>

      <!-- CTA -->
      <div class="cta-box mt-5">
        <h3 class="cta-title">Questions sur les Paiements ?</h3>
        <p class="cta-desc">Notre équipe est disponible pour répondre à toutes vos questions concernant les paiements, les frais ou les remboursements.</p>
        <div class="d-flex gap-3 flex-wrap justify-content-center mt-3">
          <button class="btn-primary">Contacter le Support</button>
          <button class="btn-ghost">FAQ Paiements</button>
        </div>
      </div>

    </div>
  </div>
</template>

<script setup></script>