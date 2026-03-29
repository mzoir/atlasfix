<template>
  <div class="policy-page">
    <div class="container py-5">

      <div class="page-header mt-3">
        <div class="page-icon" style="background: rgba(255,90,23,0.12);">
          <i class="fa-solid fa-file-lines" style="color:#fc5a15;font-size:22px;"></i>
        </div>
        <div>
          <h1 class="page-title">Conditions Générales d'Utilisation</h1>
          <p class="page-date">Dernière mise à jour : 18 décembre 2025</p>
        </div>
      </div>

      <!-- Summary -->
      <div class="summary-box mt-4">
        <div class="summary-item" v-for="item in summaryItems" :key="item">
          <i class="fa-solid fa-check" style="color:#fc5a15;"></i>
          <span>{{ item }}</span>
        </div>
      </div>

      <!-- Sections -->
      <div class="prose-section mt-5" v-for="s in sections" :key="s.title">
        <h2 class="prose-title">{{ s.title }}</h2>
        <p class="prose-text" v-if="s.text">{{ s.text }}</p>
        <ul class="prose-list" v-if="s.items">
          <li v-for="item in s.items" :key="item">{{ item }}</li>
        </ul>
      </div>

    </div>
  </div>
</template>

<script setup>
const summaryItems = [
  "Inscription gratuite pour les clients, compte obligatoire pour les prestataires",
  "Réservations et paiements uniquement via la plateforme",
  "Suivi clair des commandes : en attente → approuvée → en cours → terminée",
  "Commission de 20 % + frais de transaction, abonnements et options promotionnelles disponibles",
  "Environnement sécurisé : signalement, vérification des prestataires, badges de confiance",
  "Avis clients basés sur des expériences réelles",
  "Annulation possible jusqu'à 24h avant le service",
  "Données personnelles protégées et non partagées",
  "Plateforme intermédiaire – responsabilité partagée entre clients et prestataires",
  "Règles régies par la loi marocaine (juridiction : Rabat)",
]

const sections = [
  {
    title: "1. Inscription",
    text: "Les clients peuvent créer un compte gratuitement sur [Nom de la Plateforme] afin de parcourir les services, consulter les profils des prestataires et effectuer des réservations. Les prestataires doivent obligatoirement créer et maintenir un compte actif pour proposer leurs services. Cette exigence garantit la transparence et la responsabilité de chaque prestataire.",
  },
  {
    title: "2. Utilisation de la Plateforme",
    text: "Atlas Fix agit exclusivement en qualité d'intermédiaire mettant en relation des prestataires de services indépendants et des clients. À ce titre, la Plateforme ne fournit aucun service elle-même et n'intervient en aucun cas dans la fourniture, l'exécution, la supervision ou le contrôle des prestations proposées ou réalisées par les prestataires.",
  },
  {
    title: "3. Gestion des Commandes",
    text: "[Nom de la Plateforme] permet un suivi en temps réel des réservations, avec des étapes claires : en attente, approuvée, en cours et terminée. Ce système assure la transparence et réduit les malentendus entre clients et prestataires.",
  },
  {
    title: "4. Paiements et Frais",
    items: [
      "Commission : 20 % prélevés automatiquement sur chaque transaction pour financer la maintenance, le support et les mesures de confiance.",
      "Abonnements : Plans optionnels pour les prestataires afin de bénéficier de fonctionnalités avancées : Pro : 30 MAD / mois, Premium : 75 MAD / mois, Business : 150 MAD / mois",
      "Boosts : Outil promotionnel à 50 MAD, valable 30 jours, permettant d'augmenter la visibilité du prestataire.",
      "Frais de service : 3 % par réservation (plafonné à 20 MAD) ou forfait fixe de 5 MAD.",
      "Remboursements : En cas de trop-perçu, le surplus est remboursé sous 7 jours ouvrables.",
    ],
  },
  {
    title: "5. Sécurité & Protection",
    items: [
      "Les prestataires doivent agir avec professionnalisme et fournir leurs services avec soin.",
      "Les clients doivent traiter les prestataires équitablement et éviter tout harcèlement, discrimination ou demande dangereuse.",
      "Tout comportement abusif, frauduleux ou risqué peut entraîner la suspension ou la suppression du compte.",
      'Un bouton "Signaler" est disponible sur les profils, tableaux de bord et chats pour signaler immédiatement un problème.',
      "Les signalements sont examinés sous 48 heures.",
      "Les badges de vérification et les scores de confiance aident les clients à choisir des prestataires fiables.",
    ],
  },
  {
    title: "6. Qualité de Service & Conduite Professionnelle",
    items: [
      "Les prestataires doivent fournir leurs services honnêtement, dans les délais et conformément aux compétences annoncées.",
      "Les clients doivent fournir des informations exactes sur le service demandé et respecter les horaires convenus.",
      "Les manquements répétés aux standards de qualité peuvent entraîner la suspension du compte.",
      "Les prestations sont fournies directement et exclusivement par les prestataires, lesquels agissent en leur nom propre et sous leur seule responsabilité, tant sur le plan professionnel, contractuel que légal.",
    ],
  },
  {
    title: "7. Vérification & Confiance",
    items: [
      "Les prestataires sont invités à soumettre une pièce d'identité ou une licence professionnelle pour obtenir un badge de vérification.",
      "Les prestataires vérifiés sont mis en avant afin d'aider les clients à faire un choix éclairé.",
      "Toute fraude ou fausse information entraîne la suppression du badge et peut mener à la suspension du compte.",
    ],
  },
  {
    title: "8. Avis & Notations",
    items: [
      "Les clients peuvent laisser une note et un avis écrit après chaque réservation.",
      "Les avis doivent être honnêtes et basés sur une expérience réelle.",
      "Les avis faux, abusifs ou tronqués sont interdits et peuvent être supprimés par [Nom de la Plateforme].",
    ],
  },
  {
    title: "9. Annulations & Absences",
    items: [
      "Les clients peuvent annuler jusqu'à 24 heures avant le service sans pénalité.",
      "Les prestataires doivent honorer les réservations confirmées.",
      "[Nom de la Plateforme] peut proposer un autre prestataire au client en cas d'annulation.",
    ],
  },
  {
    title: "10. Confidentialité",
    text: "[Nom de la Plateforme] respecte la vie privée des utilisateurs. Les données personnelles sont collectées uniquement pour faciliter les réservations et améliorer les services. [Nom de la Plateforme] ne vend ni ne partage ces données avec des tiers.",
  },
  {
    title: "11. Limitation de Responsabilité",
    text: "Atlas Fix agit exclusivement en tant qu'intermédiaire de mise en relation entre les clients et les prestataires de services indépendants. La Plateforme n'intervient pas dans la fourniture, l'exécution, la supervision, le contrôle ni la validation des services proposés ou réalisés par les prestataires.",
  },
  {
    title: "12. Application des Règles",
    text: "[Nom de la Plateforme] se réserve le droit de suspendre ou de supprimer les comptes qui enfreignent les présentes CGU, notamment en cas de paiements hors plateforme, fraude, harcèlements, comportements dangereux ou annulations répétées.",
  },
  {
    title: "13. Juridiction",
    text: "Toutes les activités sur [Nom de la Plateforme] sont régies par la loi marocaine. En cas de litige, la juridiction compétente est celle des tribunaux de Rabat.",
  },
]
</script>