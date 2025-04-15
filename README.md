# 🎯 Event Booking App – Test Technique PSIE (Avril 2025)

Ce projet est la base pour le test technique des candidats PSIE.  
Il contient un backend en PHP et un frontend Vue.js déjà généré.

---

## 📁 Structure du projet

- `backend/` : API PHP REST minimaliste
- `frontend/` : Projet frontend déjà généré avec Vue.js + Tailwind CSS
- `events.json` : Fichier contenant les événements simulés

---

## ✅ Étapes à suivre après avoir cloné le projet

### 🔧 1. Backend – PHP

#### ▶️ Lancer le serveur PHP :

Ouvrir un terminal dans le dossier `backend/` puis exécuter :

```bash
php -S localhost:8080 -d error_reporting=E_ALL
```

Cela démarre le serveur sur [http://localhost:8080](http://localhost:8080)

#### 🌐 Routes disponibles :

- `GET /events` → Liste des événements
- `POST /events` → Ajouter un événement
- `PUT /events/:id` → Modifier un événement
- `DELETE /events/:id` → Supprimer un événement
- `GET /reservations` → Liste des réservations
- `POST /reserve` → Réserver une place
- `GET /reservations?email=...` → Voir les réservations par email
- `DELETE /reservation/:id/email/:email` → Annuler une réservation

---

### 🌐 2. Frontend – Vue.js

Le projet est déjà généré dans `frontend/`.

#### ▶️ Installer les dépendances :

```bash
cd frontend
npm install
```

#### ▶️ Démarrer le projet :

```bash
npm run dev
```

L’application sera accessible sur [http://localhost:5173](http://localhost:5173)

---

## 🧪 Objectif du test

Créer une application de **réservation d'événements** :

- Interaction avec l’API PHP
- Gérer des événements (Liste, Ajoute, Modification, Suppression)
- Model d'événement ( comme dans le fichier `events.json`)
- Formulaire d'événement (nom, date, lieu)
- Gérer des réservations (Liste, Ajoute, Modification, Suppression)
- Formulaire de réservation (nom, email)
- Model de réservation (comme dans le ficheir `reservations.json`)

---

## 📦 Livrables attendus

- Code complet dans un dossier Git
- README personnalisé si besoin
- Screenshots ou vidéo du résultat (optionnel mais apprécié)
- Commit Git clair avec historique structuré

---

Bonne chance ! 🚀
