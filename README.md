# 🏋️‍♂️ Coach Personnalisé | Écosystème de Gestion Sportive Dual-App

[![Laravel](https://img.shields.io/badge/Laravel-12.x/13.x-FF2D20?style=for-the-badge&logo=laravel)](https://laravel.com)
[![NativePHP](https://img.shields.io/badge/NativePHP-3.x-8280FF?style=for-the-badge&logo=php)](https://nativephp.com)
[![TailwindCSS](https://img.shields.io/badge/Tailwind_CSS-4.x-38B2AC?style=for-the-badge&logo=tailwind-css)](https://tailwindcss.com)
[![Alpine.js](https://img.shields.io/badge/Alpine.js-3.x-8BC0D0?style=for-the-badge&logo=alpine.js)](https://alpinejs.dev)
[![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql)](https://www.mysql.com)

## 📋 Présentation du Projet
**Coach Personnalisé** est une suite logicielle complète ("Dual-App Ecosystem") développée pour digitaliser l'activité des coachs sportifs. L'objectif est de centraliser la gestion des clients, le suivi nutritionnel et l'engagement des clients au sein d'une solution unifiée, éliminant les flux de travail fragmentés (WhatsApp, Excel, etc.).

> **Projet de Fin de Formation (PFE)** - Solicode Tangier.
> **Réalisé par :** Mehdi Bentaleb
> **Encadré par :** M. ESSARRAJ Fouad

---

## 🏛️ Architecture & Écosystème (Dual-App)

Le projet s'articule autour de deux applications distinctes communiquant via des bases de connaissances communes :

### 1. 🏢 Web Management Platform (`PFE-Project`)
Le tableau de bord central destiné aux administrateurs et au staff (coachs). 
- **Stack :** Laravel 12 (PHP 8.2+), Tailwind CSS, Alpine.js.
- **Fonctionnalités :** Gestion globale, création de programmes, suivi des performances clients, attribution de repas ("Unified Nutrition Engine").
- **Accès :** RBAC via *Spatie Laravel Permission*.

### 2. 📱 Client Mobile App (`App-mobile`)
L'application dédiée aux clients pour consulter leurs programmes et interagir avec la plateforme.
- **Stack :** NativePHP (Laravel 13, PHP 8.4+), Tailwind CSS 4, Alpine.js.
- **Fonctionnalités :** Approche "Mobile-First", consultation du plan nutritionnel, navigation intuitive (Lucide Icons), expérience utilisateur fluide.

---

## ✨ Fonctionnalités Principales

### 🥗 Unified Nutrition Engine
- **Service Layer Architecture :** Isolement de la logique métier dans `PFE-Project/app/Services`.
- **Mécanismes :**
  - Création dynamique de plans alimentaires personnalisés.
  - Attribution de repas spécifiques par jour.
  - Gestion d'une bibliothèque complète d'aliments et de recettes.

### 🔐 Gestion des Accès & Sécurité
- Utilisation de **Spatie Laravel Permission** pour gérer la hiérarchie :
    - **Admin :** Gestion globale du système et supervision des coachs.
    - **Staff (Coach) :** Gestion indépendante de son propre portefeuille clients et de ses programmes.
    - **Client :** Interface dédiée via l'application mobile.

### 🎨 Expérience Visuelle Premium
- Design **Minimaliste & Pro** basé sur **Preline UI**.
- Interface moderne, réactive et optimisée pour un usage quotidien (Salle de sport ou bureau).

---

## 🏗️ Conception & Méthodologie

Le projet a été pensé en suivant une approche hybride, documentée dans le dossier `Presentation/` :
1. **Design Thinking :** Phase d'empathie, cartographie des besoins réels (Voir `Presentation/images/designThinking.png`).
2. **UML :** Conception basée sur l'utilisateur avec Modèle Logique de Données (MLD) et diagrammes de cas d'utilisation (Voir `Presentation/images/diagramme-class.png`).
3. **Agile (Scrum) :** Développement par itérations.

*Aperçu des architectures :*
![Diagramme de Classe](Presentation/images/diagramme-class.png)

---

## 🚀 Installation & Configuration

### 1. Préparation Initiale
```bash
git clone https://github.com/BenTaleb-Mehdi/Project-PFE.git
cd Project-PFE
```

### 2. Configuration Plateforme Web (`PFE-Project`)
```bash
cd PFE-Project
# Installer les dépendances
composer install
npm install

# Build des assets
npm run build

# Environnement et base de données
cp .env.example .env
php artisan key:generate
php artisan migrate --seed

# Lancer le serveur (Port 8000 par défaut)
php artisan serve
```

### 3. Configuration Client Mobile (`App-mobile`)
```bash
# Depuis la racine du dépôt
cd App-mobile

# Installer les dépendances
composer install
npm install

# Build des assets
npm run build

# Environnement et base de données locale mobile (si nécessaire)
cp .env.example .env
php artisan key:generate
php artisan migrate # Si SQLite configuré pour le dev local

# Lancer l'environnement de développement NativePHP ou Serveur de Test
npm run dev
php artisan serve --port=9000
# Ou pour build natif: php artisan native:run
```