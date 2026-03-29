<template>
  <div class="policy-page">
    <div class="container py-5">

      <div class="page-header mt-3">
        <div class="page-icon" style="background: rgba(255,90,23,0.12);">
          <i class="fa-solid fa-circle-question" style="color:#fc5a15;font-size:22px;"></i>
        </div>
        <div>
          <h1 class="page-title">Conseils Pratiques</h1>
          <p class="page-date">Guide pour clients et artisans</p>
        </div>
      </div>

      <!-- Clients -->
      <div class="section-card mt-5">
        <div class="section-card-header">
          <i class="fa-solid fa-user-group" style="color:#1a73e8;font-size:20px;"></i>
          <h2 class="section-card-title">Conseils pour les Clients</h2>
        </div>

        <div class="objectif-box blue-objectif mt-3">
          <strong>Objectif</strong>
          <p class="mb-0">Aider les clients à naviguer sur AtlasFix, à choisir les bons prestataires et à se protéger.</p>
        </div>

        <div class="tip-list mt-3">
          <div class="tip-item" v-for="tip in clientTips" :key="tip.title">
            <div class="tip-title">{{ tip.num }}. {{ tip.title }}</div>
            <div class="tip-desc">{{ tip.desc }}</div>
          </div>
        </div>
      </div>

      <!-- Artisans -->
      <div class="section-card mt-5">
        <div class="section-card-header">
          <i class="fa-solid fa-briefcase" style="color:#fc5a15;font-size:20px;"></i>
          <h2 class="section-card-title">Conseils pour les Artisans</h2>
        </div>

        <div class="objectif-box orange-objectif mt-3">
          <strong>Objectif</strong>
          <p class="mb-0">Aider les prestataires à optimiser leur visibilité, gérer leurs commandes et se protéger.</p>
        </div>

        <div class="tip-list mt-3">
          <div class="tip-item" v-for="tip in artisanTips" :key="tip.title">
            <div class="tip-title">{{ tip.num }}. {{ tip.title }}</div>
            <div class="tip-desc">{{ tip.desc }}</div>
          </div>
        </div>
      </div>

      <!-- CTA -->
      <div class="cta-box mt-5">
        <h3 class="cta-title">Besoin d'aide ?</h3>
        <p class="cta-desc">Si vous avez des questions ou besoin d'assistance, notre équipe support est là pour vous aider. Consultez notre FAQ ou contactez-nous directement.</p>
        <div class="d-flex gap-3 flex-wrap justify-content-center mt-3">
          <button class="btn-primary">Contacter le Support</button>
          <button class="btn-ghost">Consulter la FAQ</button>
        </div>
      </div>

    </div>
  </div>
</template>

<script setup>
const clientTips = [
  { num: 1, title: "Vérifiez les badges", desc: 'Privilégiez les prestataires avec badge "Vérifié" (identité et licence validées).' },
  { num: 2, title: "Comparez les avis", desc: "Lisez les évaluations et commentaires avant de réserver." },
  { num: 3, title: "Utilisez la messagerie intégrée", desc: "Ne partagez pas vos coordonnées personnelles en dehors de l'application." },
  { num: 4, title: "Respectez les paiements via AtlasFix", desc: "Cela garantit la sécurité et la continuité du service." },
  { num: 5, title: "Soyez précis dans vos demandes", desc: "Décrivez clairement le service attendu (date, lieu, durée)." },
  { num: 6, title: "Consultez le contrat automatique", desc: "Vérifiez les conditions (prix, délais, annulation)." },
  { num: 7, title: "Signalez les problèmes", desc: "Utilisez le support AtlasFix en cas de litige ou de comportement suspect." },
]

const artisanTips = [
  { num: 1, title: "Complétez votre profil", desc: "Ajoutez photo, certifications, description claire de vos services." },
  { num: 2, title: "Maintenez une bonne réputation", desc: "Respectez les délais, soyez ponctuel et professionnel." },
  { num: 3, title: "Utilisez la messagerie AtlasFix", desc: "Ne communiquez pas en dehors de l'application pour protéger vos revenus." },
  { num: 4, title: "Respectez les paiements via AtlasFix", desc: "Évitez les paiements cash ou hors plateforme (risque de suspension)." },
  { num: 5, title: "Boostez vos services", desc: 'Utilisez l\'option "Boost" pour apparaître en tête des recherches.' },
  { num: 6, title: "Surveillez vos évaluations", desc: "Répondez poliment aux avis et améliorez vos prestations." },
  { num: 7, title: "Protégez vos droits", desc: "Appuyez-vous sur le contrat automatique pour clarifier les conditions avec le client." },
  { num: 8, title: "Profitez des abonnements", desc: "Choisissez le plan adapté (Pro, Premium, Business) pour maximiser votre visibilité." },
  { num: 9, title: "Finalisez vos demandes en cours avant d'en accepter de nouvelles,", desc: "Afin de garantir la qualité du service et le respect des engagements envers les clients." },
]
</script>