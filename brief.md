# ITThink Dashboard - Phase 2

## 🕹️ Contexte

Cette deuxième étape du projet **ITThink** vise à développer un **dashboard interactif** et une interface utilisateur conviviale pour la gestion des :
- Utilisateurs
- Projets
- Freelances
- Catégories
- Sous-catégories
- Offres
- Témoignages

L’implémentation se fera en **PHP procédural** avec une connexion à une base de données **MySQL** via **PDO** ou **MySQLi**, garantissant une **bonne sécurité** et une **performance optimale**.

---

## 🔢 Structure du Dashboard

### 🔐 Page de Connexion (Login / Register)
- Formulaire pour saisir l’**email** et le **mot de passe**.
- Validation **côté client** et **serveur**.
- Gestion de session PHP pour les utilisateurs authentifiés.

### 🏠 Page d’Accueil du Dashboard

Statistiques clés affichées sous forme de cartes ou widgets :

- Nombre total d’utilisateurs
- Nombre de projets publiés
- Nombre de freelances inscrits
- Offres en cours

Graphiques ou tableaux récapitulatifs (optionnel).

## 🔄 Gestion des Entités

- **Utilisateurs** : Ajouter, modifier, supprimer et afficher les détails.
- **Catégories et Sous-Catégories** : Interface pour gérer la hiérarchie des catégories.
- **Projets** : CRUD (Create, Read, Update, Delete) pour les projets liés à des utilisateurs.
- **Freelances** :
  - Gestion des freelances inscrits et de leurs compétences.
  - Possibilité de créer un compte freelance.
  - Soumission d’offres pour les projets déjà créés par les utilisateurs.
- **Offres** : Validation ou suppression des offres soumises.
- **Témoignages** : Modération et publication.

---

## 🛠️ Technologies Utilisées

### 🌐 Front-end
- **HTML5 / CSS3** pour la structure et le style de l’interface.
- **Framework CSS (Bootstrap / Tailwind)** pour un design responsive.

### 🔧 Back-end
- **PHP (procédural)** pour la logique serveur.
- **MySQL** pour le stockage des données.
- Utilisation de **PDO** ou **MySQLi** pour la connexion à la base de données.

---

## 🎨 Fonctionnalités Principales

### 🔐 Connexion et Sécurité
- Hachage des mots de passe avec **password_hash**.
- Vérification des identifiants via requêtes SQL préparées.
- Gestion des sessions et système de déconnexion.

### 🔄 CRUD pour les Entités
- **Ajouter** : Formulaires avec validation.
- **Lire** : Tableaux récapitulatifs avec pagination.
- **Modifier** : Pré-remplissage des formulaires.
- **Supprimer** : Confirmation avant suppression.

### 🔎 Filtrage et Recherche
- Moteur de recherche pour les projets, freelances, et offres.
- Filtrage par catégorie, statut ou date.

### 📊 Graphiques Statistiques (optionnel)
- Intégration de bibliothèques comme **Chart.js** pour afficher les données sous forme visuelle.

### ⚖️ Gestion des Permissions
- **Rôles** : Administrateurs vs utilisateurs standard.
- Accès restreint à certaines fonctionnalités selon les rôles.

---

# 🗞️ User Stories pour l’Interface Utilisateur

- **En tant qu’administrateur**, je peux consulter un tableau des projets pour voir leur statut et les modifier.
- **En tant qu’utilisateur**, je peux ajouter un nouveau projet et lui associer une catégorie et un freelance.
- **En tant qu’administrateur**, je peux gérer les témoignages publiés sur la plateforme.
- **En tant qu’utilisateur**, je peux soumettre une offre pour un projet spécifique.
- **En tant que freelance**, je peux :
  - Créer un compte freelance.
  - Consulter les projets disponibles.
  - Soumettre des offres pour les projets déjà créés par les utilisateurs.
- **En tant qu’administrateur**, je peux créer, modifier et supprimer des catégories et sous-catégories.
- **En tant qu’utilisateur**, je peux écrire un témoignage sur un projet réalisé.
- **En tant qu’administrateur**, je peux visualiser les statistiques globales (nombre d’utilisateurs, projets, freelances, etc.).
eur**, je peux visualiser les statistiques globales (nombre d’utilisateurs, projets, freelances, etc.).