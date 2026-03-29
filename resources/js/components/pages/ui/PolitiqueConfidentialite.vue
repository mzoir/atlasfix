<template>
  <div class="policy-page">
    <div class="container py-5">

      <div class="page-header mt-3">
        <div class="page-icon" style="background: rgba(255,90,23,0.12);">
          <i class="fa-solid fa-file-shield" style="color:#fc5a15;font-size:22px;"></i>
        </div>
        <div>
          <h1 class="page-title">Politique de Confidentialité</h1>
          <p class="page-date">Dernière mise à jour : 18 décembre 2025</p>
        </div>
      </div>

      <!-- Summary box -->
      <div class="summary-box mt-4">
        <div class="summary-item" v-for="item in summaryItems" :key="item">
          <i class="fa-solid fa-check" style="color:#fc5a15;"></i>
          <span>{{ item }}</span>
        </div>
      </div>

      <!-- Sections -->
      <div class="prose-section mt-5" v-for="s in sections" :key="s.title">
        <h2 class="prose-title">{{ s.title }}</h2>
        <p class="prose-text">{{ s.text }}</p>
      </div>

    </div>
  </div>
</template>

<script setup>
const summaryItems = [
  "Collecte limitée aux données strictement nécessaires (profils, réservations et paiements)",
  "Données sensibles demandées uniquement en cas de vérification indispensable",
  "Utilisation des données exclusivement pour l'amélioration des services et la sécurisation des paiements",
  "Aucune vente ni location des données personnelles à des tiers",
  "Transparence totale des frais avant confirmation de toute réservation",
  "Aucun frais caché appliqué aux utilisateurs",
  "Conformité à la législation marocaine sur la protection des données",
  "Données stockées de manière sécurisée et protégées contre tout accès non autorisé",
]

const sections = [
  {
    title: "1. Collecte des données",
    text: "[Nom de la Plateforme] collecte uniquement les données nécessaires : profils utilisateurs, détails des réservations et enregistrements de paiement. Les données sensibles ne sont demandées que lorsqu'elles sont indispensables à la vérification.",
  },
  {
    title: "2. Utilisation des données",
    text: "Les données collectées sont utilisées exclusivement pour améliorer les services [Nom de la Plateforme], optimiser les résultats de recherche, sécuriser les paiements et fournir un meilleur support client. [Nom de la Plateforme] ne vend ni ne loue les données des utilisateurs.",
  },
  {
    title: "3. Transparence",
    text: "[Nom de la Plateforme] s'engage à une transparence totale. Tous les frais — commission, abonnements, Boosts et frais de transaction — sont clairement affichés avant la confirmation d'une réservation. Aucun frais caché n'est appliqué.",
  },
  {
    title: "4. Conformité",
    text: "[Nom de la Plateforme] respecte la législation marocaine sur la protection des données. Les informations personnelles sont stockées de manière sécurisée, traitées de façon responsable et protégées contre tout accès non autorisé.",
  },
]
</script>