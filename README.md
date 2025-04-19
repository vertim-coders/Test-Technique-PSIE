# 🎯 Event Booking App – Test Technique PSIE

Bienvenue dans le projet **Event Booking App**, développé dans le cadre du test technique PSIE.

---

## 🧱 Structure du projet

```
📁 Test-Technique-PSIE
├── backend/              # API REST minimaliste en PHP
│   ├── events.json       # Données des événements simulés
│   ├── reservations.json # Données des réservations simulées
│   ├── index.php         # Routeur principal PHP
│   └── router_helper.php # Helper de routage
└── frontend/             # Application Vue.js avec Tailwind CSS
```

---

## 🚀 Lancement du projet

### 📌 Backend (PHP)
```bash
cd backend
php -S localhost:8080 -d error_reporting=E_ALL
```
🔗 Accès : [http://localhost:8080](http://localhost:8080)

### 📌 Frontend (Vue.js)
```bash
cd frontend
npm install
npm run dev
```
🔗 Accès : [http://localhost:5173](http://localhost:5173)

---

## 🔁 API – Endpoints disponibles

### 🎫 Événements
- `GET /events` → Liste des événements
- `POST /events/add` → Ajouter un événement
- `PUT /events/:id` → Modifier un événement
- `DELETE /events/:id` → Supprimer un événement

### 🧍 Réservations
- `GET /reservations` → Liste des réservations
- `POST /reserves/add` → Réserver une place
- `GET /reservations?email=...` → Voir les réservations d’un utilisateur
- `DELETE /reservation/:id/email/:email` → Annuler une réservation

---

## 🧠 Étapes clés du développement

### 1. 🎯 Initialisation du projet
- Création de deux dossiers : `backend/` et `frontend/`
- Objectif : créer une API simple avec PHP et une interface moderne avec Vue.js + Tailwind CSS

### 2. 🔧 Développement de l'API Backend en PHP
#### ➕ Routage minimaliste :
- Utilisation d’un fichier `index.php` avec une logique de mini-routeur
- Routes différenciées selon méthode HTTP (`GET`, `POST`, `PUT`, `DELETE`)
- Inclusion d’un `router_helper.php` pour les fonctions utilitaires (`readJson`, `writeJson`, etc.)

#### 📁 Gestion des données simulées :
- `events.json` pour stocker les événements
- `reservations.json` pour stocker les réservations

#### 📌 Endpoints principaux :
- `GET /events` : retourne tous les événements
- `POST /events/add` : ajoute un événement
- `PUT /events/:id` : met à jour un événement
- `DELETE /events/:id` : supprime un événement
- `GET /reservations` : retourne toutes les réservations
- `POST /reserves/add` : ajoute une réservation
- `DELETE /reservation/:id/email/:email` : supprime une réservation par ID et email

### 3. 🎨 Création du frontend en Vue.js + Tailwind CSS
#### 📦 Mise en place :
- Initialisation avec `npm init vue@latest`
- Ajout de Tailwind CSS pour le style rapide et réactif

#### 🔄 Connexion à l’API :
- Création d’un fichier `@/api/index.js` pour les appels HTTP
- Utilisation de `axios` pour faire les requêtes vers l’API

#### 🧩 Composants :
- `EventList.vue` : Affiche la liste des événements avec bouton de réservation
- `EventForm.vue` : Formulaire pour ajouter ou modifier un événement
- `UserReservations.vue` : Liste les réservations d’un utilisateur

### 4. 🔄 Interaction backend ↔ frontend
- Test en local sur deux ports : `8080` (backend) et `5173` (frontend)
- CORS gérés via entête dans `index.php`
- Chaque action du frontend (ajout, édition, suppression) déclenche une requête HTTP

### 5. ✅ Fonctionnalités finalisées
- Interface fonctionnelle : consultation et réservation d'événements
- API REST complète : CRUD complet pour événements + gestion des réservations
- Synchronisation des données après chaque action (refresh auto)

---

## 🧪 Fonctionnalités développées
- ✅ Lecture, ajout, modification, suppression d'événements
- ✅ Réservation d'événements avec nom & email
- ✅ Suppression de réservations par ID & email
- ✅ Interaction fluide entre frontend & backend

---

## 🙌 Auteurs

**Nom du candidat** : _Bernado ADIKPETO_  
**Branche Git** : `feat/Bernado_ADIKPETO`

---

## 📝 Notes
> Ce projet est fourni à des fins de test technique uniquement. Merci de ne pas plagier ni redistribuer ce contenu.

---

Merci et bonne lecture ! 🚀

