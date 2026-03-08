# 🏋️‍♂️ Coach Personnalisé | Écosystème de Gestion Sportive

[![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel)](https://laravel.com)
[![TailwindCSS](https://img.shields.io/badge/Tailwind_CSS-3.x-38B2AC?style=for-the-badge&logo=tailwind-css)](https://tailwindcss.com)
[![Alpine.js](https://img.shields.io/badge/Alpine.js-3.x-8BC0D0?style=for-the-badge&logo=alpine.js)](https://alpinejs.dev)
[![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql)](https://www.mysql.com)

## 📋 Présentation du Projet
**Coach Personnalisé** est une plateforme Web développée pour digitaliser l'activité des coachs sportifs. L'objectif est de centraliser la gestion des clients, le suivi nutritionnel et le branding professionnel au sein d'une interface unique, remplaçant les flux de travail fragmentés (WhatsApp, Excel, etc.).

> **Projet de Fin de Formation (PFE)** - Solicode Tangier.
> **Réalisé par :** Mehdi Bentaleb
> **Encadré par :** M. ESSARRAJ Fouad

---

## ✨ Fonctionnalités Principales

### 🔐 Gestion des Accès (RBAC)
- Utilisation de **Spatie Laravel Permission** pour gérer 3 types d'utilisateurs :
    - **Admin :** Gestion globale du système et des coachs.
    - **Staff (Coach) :** Gestion de son propre portefeuille clients et programmes.
    - **Client :** Consultation de son programme personnalisé et suivi de progression.

### 🥗 Unified Nutrition Engine
- Création dynamique de plans alimentaires.
- Attribution de repas spécifiques par jour.
- Bibliothèque d'aliments et de recettes.

### 📱 Interface & Expérience Utilisateur
- Design **Minimaliste & Pro** basé sur **Preline UI**.
- Approche **Mobile-First** pour permettre aux clients de consulter leurs programmes à la salle de sport.
- Utilisation de **Lucide Icons** pour une navigation intuitive.

---

## 🛠️ Stack Technique

- **Framework :** Laravel 11 (PHP 8.2+)
- **Architecture :** Pattern **Service Layer** (N-Tiers) pour isoler la logique métier.
- **Frontend :** Blade Templates + Tailwind CSS + Alpine.js.
- **Base de données :** MySQL avec Eloquent ORM.
- **Outils :** Vite (Asset Bundler), Git/GitHub.

---

## 🏗️ Méthodologie de Développement

Le projet a été mené selon une approche hybride :
1. **Design Thinking :** Phase d'empathie et définition du problème pour cibler les besoins réels des coachs.
2. **UML :** Conception rigoureuse via des diagrammes de cas d'utilisation (Use Case) et MLD.
3. **Agile (Scrum) :** Développement itératif divisé en Sprints (Base, Nutrition, Suivi).

---

## 🚀 Installation & Configuration

1. **Cloner le repository :**
   ```bash
   git clone [https://github.com/BenTaleb-Mehdi/Project-PFE.git](https://github.com/BenTaleb-Mehdi/Project-PFE.git)
   cd Project-PFE


Installer les dépendances PHP :

```bash
composer install
```
Installer les dépendances Frontend :

```bash
npm install
npm run dev
```
Configuration de l'environnement :

```bash
cp .env.example .env
php artisan key:generate
```
Migration de la base de données :



```bash
php artisan migrate --seed
```
Lancer le projet :
```bash
php artisan serve
```