APPLICATION RÉGIME ALIMENTAIRE
│
├── 1. FRONT OFFICE
│   │
│   ├── Authentification utilisateur
│   │   ├── Inscription - page 1
│   │   │   ├── Nom
│   │   │   ├── Email
│   │   │   ├── Mot de passe
│   │   │   └── Genre
│   │   │
│   │   ├── Inscription - page 2
│   │   │   ├── Taille
│   │   │   └── Poids
│   │   │   
│   │   │
│   │   └── Login
│   │
│   ├── Profil utilisateur
│   │   ├── Informations personnelles
│   │   ├── Informations santé
│   │   ├── IMC actuel
│   │   └── Complétion / modification du profil
│   │
│   ├── Objectifs
│   │   ├── Augmenter son poids
│   │   ├── Réduire son poids
│   │   └── Atteindre son IMC idéal
│   │
│   ├── Suggestion automatique
│   │   ├── Régime conseillé
│   │   ├── Activité sportive conseillée
│   │   ├── Durée recommandée
│   │   ├── Prix du régime
│   │   └── Résultat attendu
│   │
│   ├── Achat / paiement
│   │   ├── Portefeuille utilisateur
│   │   ├── Recharge avec code
│   │   ├── Achat d’un régime
│   │   └── Réduction Gold - 15%
│   │
│   ├── Option Gold
│   │   ├── Achat en une seule fois
│   │   ├── Activation du statut Gold
│   │   └── Remise sur tous les régimes
│   │
│   └── Export PDF
│       ├── Régime choisi
│       ├── Activité sportive
│       ├── Objectif
│       ├── Durée
│       └── Prix final
│
├── 2. BACK OFFICE
│   │
│   ├── Authentification admin
│   │   └── Page de login au démarrage
│   │
│   ├── Tableau de bord
│   │   ├── Nombre d’utilisateurs
│   │   ├── Nombre de régimes achetés
│   │   ├── Total des recharges
│   │   ├── Total des ventes
│   │   ├── Objectifs les plus choisis
│   │   ├── Régimes les plus populaires
│   │   └── Graphes / statistiques
│   │
│   ├── Gestion des régimes
│   │   ├── Ajouter régime
│   │   ├── Modifier régime
│   │   ├── Supprimer régime
│   │   ├── Voir liste des régimes
│   │   ├── Définir variation de poids
│   │   ├── Définir durée
│   │   ├── Définir prix selon durée
│   │   └── Définir composition
│   │       ├── % viande
│   │       ├── % poisson
│   │       └── % volaille
│   │
│   ├── Gestion des activités sportives
│   │   ├── Ajouter activité
│   │   ├── Modifier activité
│   │   ├── Supprimer activité
│   │   ├── Voir liste des activités
│   │   ├── Intensité
│   │   ├── Calories brûlées
│   │   └── Durée recommandée
│   │
│   ├── Gestion des codes portefeuille
│   │   ├── Créer des codes
│   │   ├── Voir les codes disponibles
│   │   ├── Voir les codes utilisés
│   │   ├── Valider les codes
│   │   └── Suivre les recharges
│   │
│   └── Gestion des paramètres
│       ├── Prix Gold
│       ├── Pourcentage remise Gold
│       ├── IMC idéal minimum
│       ├── IMC idéal maximum
│       └── Autres paramètres système
│
├── 3. BASE DE DONNÉES
│   │
│   ├── Utilisateurs
│   │   ├── users
│   │   ├── health_profiles
│   │   └── user_objectives
│   │
│   ├── Objectifs
│   │   └── objectives
│   │
│   ├── Régimes
│   │   ├── regimes
│   │   ├── regime_compositions
│   │   └── regime_prices
│   │
│   ├── Activités sportives
│   │   ├── sport_activities
│   │   └── activity_recommendations
│   │
│   ├── Suggestions
│   │   ├── recommendation_plans
│   │   └── plan_exports
│   │
│   ├── Paiement / portefeuille
│   │   ├── wallets
│   │   ├── recharge_codes
│   │   ├── wallet_transactions
│   │   └── regime_orders
│   │
│   ├── Option Gold
│   │   └── gold_subscriptions
│   │
│   └── Paramètres
│       └── parameters
│
├── 4. RÔLES
│   │
│   ├── Utilisateur simple
│   │   ├── Créer un compte
│   │   ├── Compléter son profil
│   │   ├── Choisir un objectif
│   │   ├── Voir les suggestions
│   │   ├── Acheter un régime
│   │   ├── Recharger son portefeuille
│   │   ├── Acheter l’option Gold
│   │   └── Exporter en PDF
│   │
│   └── Administrateur
│       ├── Se connecter au back office
│       ├── Gérer les régimes
│       ├── Gérer les activités
│       ├── Gérer les codes
│       ├── Gérer les paramètres
│       └── Voir les statistiques
│
└── 5. TECHNOLOGIES
    │
    ├── Backend
    │   ├── PHP
    │   └── CodeIgniter
    │
    ├── Frontend
    │   ├── HTML
    │   ├── CSS
    │   ├── JavaScript
    │   └── AJAX
    │
    ├── Base de données
    │   ├── MySQL
    │   └── PostgreSQL possible
    │
    └── Livraison
        ├── Lien GitHub / GitLab
        ├── Script SQL
        ├── Google Sheet suivi des tâches
        ├── Liste des membres
        └── Merge final dans main