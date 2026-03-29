<template>
  <div class="policy-page">
    <!-- Header -->
    <div class="container py-5">
      <router-link to="/" class="back-link">← Retour</router-link>

      <div class="page-header mt-3">
        <div class="page-icon" style="background: rgba(255,90,23,0.12);">
          <i class="fa-solid fa-shield-halved" style="color:#fc5a15;font-size:22px;"></i>
        </div>
        <div>
          <h1 class="page-title">Politique de Confiance & Sécurité</h1>
          <p class="page-date">Dernière mise à jour : 23 décembre 2024</p>
        </div>
      </div>

      <!-- Intro -->
      <div class="intro-box mt-4">
        <i class="fa-regular fa-circle-dot" style="color:#fc5a15;"></i>
        <p>Chez <strong>AtlasFix</strong> la sécurité, la confiance et la transparence sont au cœur de notre plateforme. Cette page détaille les mesures mises en place pour protéger les clients et les prestataires et garantir des transactions fiables.</p>
      </div>

      <!-- Section 1 -->
      <div class="section-block mt-5">
        <div class="section-num">1</div>
        <h2 class="section-title">Signalement</h2>
        <div class="alert-box red mt-3">
          <i class="fa-solid fa-triangle-exclamation" style="color:#e53935;"></i>
          <span>Chaque profil, tableau de bord et conversation dispose d'un bouton <strong>"Signaler"</strong>.</span>
        </div>
        <div class="info-box grey mt-2">
          Il permet aux utilisateurs de rapporter tout comportement ou situation suspects.
        </div>
      </div>

      <!-- Section 2 -->
      <div class="section-block mt-5">
        <div class="section-num">2</div>
        <h2 class="section-title">Processus de signalement</h2>
        <p class="section-sub">Pour signaler un problème, il suffit de :</p>

        <div class="step-box blue mt-3">
          <i class="fa-regular fa-square-check" style="color:#1a73e8;"></i>
          <span>Sélectionner la raison du signalement :</span>
        </div>

        <div class="list-items mt-2">
          <div class="list-item">
            <span class="bullet orange"></span> Paiement hors plateforme
          </div>
          <div class="list-item">
            <span class="bullet orange"></span> Faux profil
          </div>
          <div class="list-item">
            <span class="bullet orange"></span> Harcèlement ou comportement inapproprié
          </div>
        </div>

        <div class="step-box purple mt-3">
          <i class="fa-regular fa-circle" style="color:#8a2be2;"></i>
          <span>Ajouter des détails et éventuellement des captures d'écran pour aider l'équipe à analyser la situation.</span>
        </div>
      </div>

      <!-- Section 3 -->
      <div class="section-block mt-5">
        <div class="section-num">3</div>
        <h2 class="section-title">Action d'AtlasFix</h2>

        <div class="alert-box green mt-3">
          <i class="fa-solid fa-circle-check" style="color:#0a8f2a;"></i>
          <span>Chaque signalement est révisé sous <strong>48 heures</strong> par notre équipe.</span>
        </div>

        <div class="info-box yellow mt-3">
          <p class="mb-2">Des sanctions peuvent être appliquées, selon la gravité :</p>
          <div class="sanction-item">
            <span class="sanction-dot yellow-dot"></span> Avertissement
          </div>
          <div class="sanction-item">
            <span class="sanction-dot orange-dot"></span> Suspension temporaire
          </div>
          <div class="sanction-item">
            <span class="sanction-dot red-dot"></span> Suppression du compte
          </div>
        </div>
      </div>

      <!-- Section 4 -->
      <div class="section-block mt-5">
        <div class="section-num">4</div>
        <h2 class="section-title">Indice de confiance</h2>

        <div class="trust-score-box mt-3">
          <div class="trust-score-header">
            <i class="fa-solid fa-star" style="color:#fc5a15;"></i>
            <span class="trust-label">Score de confiance</span>
          </div>
          <div class="trust-value">0–100</div>
          <p class="trust-desc">Chaque artisan possède un score de confiance dynamique (0-100). Il reflète la fiabilité et le comportement sur la plateforme, basé sur :</p>
        </div>

        <div class="row g-3 mt-3">
          <div class="col-12 col-md-4">
            <div class="trust-card green-card">
              <i class="fa-solid fa-star" style="color:#0a8f2a;font-size:20px;"></i>
              <div class="trust-card-title">Avis clients reçus</div>
              <div class="trust-card-desc">La moyenne des notes attribuées par les utilisateurs</div>
            </div>
          </div>
          <div class="col-12 col-md-4">
            <div class="trust-card blue-card">
              <i class="fa-solid fa-circle-check" style="color:#1a73e8;font-size:20px;"></i>
              <div class="trust-card-title">Demandes traitées</div>
              <div class="trust-card-desc">Nombre de services complétés avec succès</div>
            </div>
          </div>
          <div class="col-12 col-md-4">
            <div class="trust-card purple-card">
              <i class="fa-solid fa-bolt" style="color:#8a2be2;font-size:20px;"></i>
              <div class="trust-card-title">Réactivité</div>
              <div class="trust-card-desc">Vitesse de réponse aux demandes et messages</div>
            </div>
          </div>
        </div>
      </div>

      <!-- Section 5 -->
      <div class="section-block mt-5">
        <div class="section-num">5</div>
        <h2 class="section-title">Badges de confiance</h2>
        <p class="section-sub">Pour identifier rapidement les prestataires fiables, <strong>AtlasFix</strong> attribue des badges spéciaux :</p>

        <div class="row g-3 mt-3">
          <div class="col-12 col-md-4">
            <div class="badge-card green-border">
              <div class="badge-ico green-ico">
                <i class="fa-solid fa-circle-check"></i>
              </div>
              <div class="badge-title">ID vérifié</div>
              <div class="badge-desc">Identité confirmée</div>
            </div>
          </div>
          <div class="col-12 col-md-4">
            <div class="badge-card blue-border">
              <div class="badge-ico blue-ico">
                <i class="fa-solid fa-id-badge"></i>
              </div>
              <div class="badge-title">Pro licencié</div>
              <div class="badge-desc">Prestataire vérifié et expérimenté</div>
            </div>
          </div>
          <div class="col-12 col-md-4">
            <div class="badge-card orange-border">
              <div class="badge-ico orange-ico">
                <i class="fa-solid fa-bolt"></i>
              </div>
              <div class="badge-title">Réponse rapide</div>
              <div class="badge-desc">Taux de réponse élevé aux demandes</div>
            </div>
          </div>
        </div>
      </div>

      <!-- Section 6 -->
      <div class="section-block mt-5">
        <div class="section-num">6</div>
        <h2 class="section-title">Engagement des prestataires</h2>
        <div class="alert-box teal mt-3">
          <i class="fa-solid fa-user-check" style="color:#00897b;font-size:20px;"></i>
          <div>
            <p class="mb-1">Chaque artisan est tenu d'honorer personnellement les prestations qu'il accepte via la Plateforme.</p>
            <p class="mb-0">Cet engagement garantit la qualité du service, la transparence et la confiance entre les utilisateurs.</p>
          </div>
        </div>
      </div>

      <!-- Section 7 -->
      <div class="section-block mt-5">
        <div class="section-num">7</div>
        <h2 class="section-title">Garantie de continuité</h2>
        <div class="alert-box teal mt-3">
          <i class="fa-solid fa-user-check" style="color:#00897b;font-size:20px;"></i>
          <div>
            <p class="mb-0">Si un prestataire annule une réservation, <strong>AtlasFix</strong> propose un <strong>rematch automatique</strong>, avec un autre prestataire disponible, pour assurer la continuité du service.</p>
          </div>
        </div>
      </div>

      <!-- Section 8 -->
      <div class="section-block mt-5">
        <div class="section-num">8</div>
        <h2 class="section-title">Tolérance zéro</h2>
        <div class="alert-box red mt-3">
          <i class="fa-solid fa-ban" style="color:#e53935;font-size:20px;"></i>
          <div>
            <p class="mb-1"><strong>Toute sollicitation hors plateforme est strictement interdite.</strong></p>
            <p class="mb-0">Cette règle vise à protéger nos utilisateurs et maintenir la sécurité des transactions et des échanges.</p>
          </div>
        </div>
      </div>

      <!-- CTA -->
      <div class="cta-box mt-5">
        <h3 class="cta-title">Besoin d'Aide ou Questions ?</h3>
        <p class="cta-desc">Notre équipe de confiance et de sécurité est disponible pour répondre à toutes vos questions et traiter vos préoccupations rapidement.</p>
        <div class="d-flex gap-3 flex-wrap justify-content-center mt-3">
          <button class="btn-primary">Contacter l'Équipe Sécurité</button>
          <button class="btn-ghost">Centre de Sécurité</button>
          <button class="btn-outline-orange">Signaler un Problème</button>
        </div>
      </div>

    </div>
  </div>
</template>

<script setup></script>