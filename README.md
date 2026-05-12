# Obsequium QHSE — Site vitrine

Site vitrine du cabinet conseil & formation QHSE, construit avec Laravel 13, Filament v5 et Livewire v4.

---

## Stack technique

| Couche | Technologie |
|---|---|
| Backend | PHP 8.4 · Laravel 13 |
| Admin | Filament v5 |
| Frontend interactif | Livewire v4 · Alpine.js |
| CSS | Tailwind CSS v4 |
| Build | Vite 8 |
| Tests | PHPUnit 12 |
| Formatage | Laravel Pint |
| PDF | barryvdh/laravel-dompdf |
| Permissions | spatie/laravel-permission |

---

## Prérequis

- PHP >= 8.4
- Composer
- Node.js >= 22 · npm >= 10
- Base de données (SQLite en dev, MySQL/PostgreSQL en prod)

---

## Installation

```bash
# 1. Cloner et installer les dépendances
composer install
npm install

# 2. Configurer l'environnement
cp .env.example .env
php artisan key:generate

# 3. Base de données
php artisan migrate --seed

# 4. Compiler les assets
npm run build

# 5. Lancer le serveur (dev)
composer run dev
```

---

## Variables d'environnement clés

```env
APP_NAME="Cabinet QHSE"
APP_URL=https://votre-domaine.fr

# Base de données
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_DATABASE=obsequium
DB_USERNAME=...
DB_PASSWORD=...

# Mail
MAIL_MAILER=smtp
MAIL_HOST=...
MAIL_FROM_ADDRESS=contact@votre-domaine.fr

# reCAPTCHA v3 (optionnel — formulaire de devis)
# Clés sur https://www.google.com/recaptcha/admin
RECAPTCHA_SITE_KEY=
RECAPTCHA_SECRET_KEY=
RECAPTCHA_THRESHOLD=0.5
```

---

## Espace d'administration

Accessible sur `/admin`. Créer un compte admin :

```bash
php artisan make:filament-user
```

### Modules back-office

| Module | Description |
|---|---|
| Contacts | Demandes de contact, assignation, statut lu/non lu |
| Devis | Demandes de devis multi-étapes |
| Rendez-vous | Réservations en ligne |
| Services | Services proposés par le cabinet |
| Formations | Catalogue formations + sessions + inscriptions |
| Blog | Articles, catégories, tags |
| Équipe | Membres de l'équipe |
| Références | Clients et références |
| Témoignages | Avis clients |
| Newsletter | Abonnés |
| Utilisateurs | Comptes admin |
| Paramètres du site | Configuration générale, maintenance |
| Historique maintenance | Audit des périodes de maintenance |

---

## Pages publiques

| Route | Description |
|---|---|
| `/` | Accueil |
| `/a-propos` | Présentation du cabinet |
| `/services` | Liste des services |
| `/formations` | Catalogue formations |
| `/references` | Références clients |
| `/blog` | Articles & actualités |
| `/contact` | Formulaire de contact |
| `/devis` | Demande de devis (multi-étapes, reCAPTCHA v3) |
| `/rendez-vous` | Prise de rendez-vous |
| `/mentions-legales` | Mentions légales |
| `/confidentialite` | Politique de confidentialité |

---

## Mode maintenance

Le mode maintenance se gère depuis **Admin → Paramètres du site**. Chaque activation/désactivation est tracée dans le modèle `MaintenanceLog` (Admin → Historique maintenance).

Options disponibles :
- Message personnalisé affiché aux visiteurs
- Liste d'IP autorisées à bypasser
- Token de bypass URL (`?bypass=TOKEN`)

L'espace admin reste accessible en permanence.

---

## Pages d'erreur personnalisées

Pages Blade autonomes (CSS inline, sans dépendance Vite) pour : `403`, `404`, `419`, `429`, `500`, `503`.

---

## Commandes utiles

```bash
# Lancer le serveur de développement complet (PHP + queue + logs + Vite)
composer run dev

# Tests
php artisan test --compact

# Formater le code
vendor/bin/pint

# Vider les caches
php artisan optimize:clear

# Lister les routes
php artisan route:list --except-vendor
```

---

## Déploiement

Le projet est compatible [Laravel Cloud](https://cloud.laravel.com/).

```bash
composer install --no-dev --optimize-autoloader
npm run build
php artisan migrate --force
php artisan optimize
```
