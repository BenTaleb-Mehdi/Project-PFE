---
marp: true
theme: default
_class: lead
_paginate: false
paginate: true
backgroundColor: #ffffff
style: |
  section {
    font-size: 22px;
    color: #333;
    line-height: 1.6;
    padding: 60px 80px;
  }
  footer { width: 100%; text-align: right; font-size: 14px; color: #888; }
  .logo-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    position: absolute;
    top: 40px;   
    left: 60px;
    right: 60px;
  }
  .logo-header img { height: 140px; margin: 0; margin-left:10px; margin-right:10px }
  h1 { color: #029fcaff; font-size: 2.8em; margin-top: 100px; text-align: left; }
  h2 { color: #029fcaff; font-size: 2em; border-bottom: 2px solid #029fcaff; margin-bottom: 40px;}
  h3 { text-align: left; color: #029fcaff; margin-top: 0; }

  .sommaire-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    margin-top: 20px;
  }
  .sommaire-item {
    display: flex;
    align-items: center;
    background: #f2fafcff;
    border-radius: 12px;
    padding: 15px 20px;
    border-left: 5px solid #029fcaff;
  }
  .sommaire-num {
    background: #029fcaff;; color: white; width: 35px; height: 35px;
    display: flex; justify-content: center; align-items: center;
    border-radius: 50%; font-weight: bold; margin-right: 15px; flex-shrink: 0;
  }
  
  .img-container {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
    height: 420px; /* Fixed height to prevent overflow */
    margin-top: 10px;
    overflow: hidden;
  }

  .img-methodo {
    max-width: 85%;
    max-height: 100%;
    object-fit: contain;
    border-radius: 10px;
    box-shadow: 0 10px 20px rgba(0,0,0,0.1);
  }

  .img-usecase {
    width: auto;
    height: 100%;
    max-width: 100%;
    object-fit: contain;
    border-radius: 10px;
    background-color: #fff;
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
  }

  .dt-card {
    background: #f2fafcff;
    padding: 30px;
    border-radius: 10px;
    border-top: 6px solid #029fcaff;
    text-align: left;
    margin-top: 20px;
    width: 100%;
  }

  .tech-container {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-top: 20px;
  }
  .badge-simple {
    padding: 8px 18px;
    border-radius: 6px;
    font-weight: 600;
    background-color: #545353ff;
    color: #ffffff !important;
    font-size: 0.85em;
    border: 1px solid #222;
  }
  .maquette-grid {
    display: flex;
    gap: 15px;
    justify-content: center;
    align-items: center;
    height: 400px;
  }

---

<div class="logo-header">
  <img src="images/ofppt-logo.png" alt="Logo Left">
  <img src="images/logo-solicode.png" alt="Logo Right">
</div>

# Projet de Fin de Formation
### Digitalisation des Services de Coaching : Développement d’une Solution Web Intégrée de Gestion et de Branding

**Réalisé par :** <span class="highlight">Mehdi Bentaleb</span>  
**Encadré par :** <span class="highlight">M. ESSARRAJ Fouad</span>  
**Filière :** Développement Mobile et Web

---

## Sommaire

<div class="sommaire-grid">
  <div class="sommaire-item"><div class="sommaire-num">1</div><div class="sommaire-text">Contexte du projet</div></div>
  <div class="sommaire-item"><div class="sommaire-num">2</div><div class="sommaire-text">Méthodologie de travail</div></div>
  <div class="sommaire-item"><div class="sommaire-num">3</div><div class="sommaire-text">Branche Fonctionnelle</div></div>
  <div class="sommaire-item"><div class="sommaire-num">4</div><div class="sommaire-text">Branche Technique</div></div>
  <div class="sommaire-item"><div class="sommaire-num">5</div><div class="sommaire-text">Conception</div></div>
  <div class="sommaire-item"><div class="sommaire-num">6</div><div class="sommaire-text">Démonstration</div></div>
  <div class="sommaire-item"><div class="sommaire-num">7</div><div class="sommaire-text">Conclusion</div></div>
</div>

---
## 1. Contexte du projet
<div class="dt-card" style="border-top-color: #f39c12;">
  <h4>Contexte : </h4>
  <blockquote style="font-style: italic; background: white; padding: 15px; border-radius: 8px;">
    "Coach Achraf is an experienced fitness coach who helps clients achieve their physical goals through personalized training and nutrition plans.
    However, despite his strong expertise, he faces difficulties in managing administrative tasks such as organizing workout programs, tracking client progress, and handling payments. Most of his work is done manually, which consumes time and reduces efficiency."
  </blockquote>
</div>

> This project focuses on analyzing Coach Amin’s needs in order to propose solutions that improve his organization, optimize his workflow, and enhance his professional performance.

---

## 2. Méthodologie : Design Thinking

<div class="img-container">
  <img src="images/designThinking.png" class="img-methodo" alt="Design Thinking">
</div>

---

## Méthodologie : Scrum (Agile)

<div class="img-container">
  <img src="images/scrum.jpg" class="img-methodo" alt="Scrum">
</div>

---

## 3. Branche Fonctionnelle : Design Thinking
### Empathie

<div class="sommaire-grid">
  <div class="dt-card" style="margin-top:0; border-top-color: #f39c12;">
    <h4> Ce que le Coach ressent :</h4>
    <ul>
      <li><strong>Frustration :</strong> Perte de temps sur WhatsApp/Excel.</li>
      <li><strong>Confusion :</strong> Difficulté à retrouver "ce PDF".</li>
      <li><strong>Surcharge :</strong> Gestion manuelle des paiements.</li>
    </ul>
  </div>

  <div class="dt-card" style="margin-top:0; border-top-color: #3498db;">
    <h4> L'opportunité digitale :</h4>
    <blockquote style="font-style: italic; background: white; padding: 15px; border-radius: 8px; font-size: 0.9em;">
      "Passer d'une gestion artisanale à un <b>Moteur de Nutrition Unifié</b> pour libérer 95% du temps du coach."
    </blockquote>
  </div>
</div>

---

## Branche Fonctionnelle : Carte Empathie

<div class="img-container">
  <img src="images/image-carte-empatie.png" class="img-methodo" alt="Carte Empathie">
</div>

---

## Branche Fonctionnelle : 2. DÉFINITION

<div class="dt-card" style="border-top-color: #f39c12;">
  <h4>Cadrage du problème</h4>
  <blockquote style="font-style: italic; background: white; padding: 15px; border-radius: 8px;">
    "Ses tâches sont réalisées manuellement via des outils dispersés comme WhatsApp et Excel, ce qui entraîne une perte de temps, un manque d’efficacité et une image professionnelle qui ne reflète pas son véritable niveau d’expertise."
  </blockquote>
</div>

---

## Branche Fonctionnelle : 3. IDÉATION

<div class="dt-card" style="border-top-color: #f39c12;">
  <h4>Plateforme digitale centralisée :</h4>
  <p>• Gestion des clients & programmes nutrition</p>
  <p>• Suivi de progression & automatisation des paiements</p>
  <h4>Objectif de l’Idéation</h4>
  > Transformer une gestion manuelle en un système structuré et professionnel.
</div>

---

## Branche Fonctionnelle : Cas d'utilisation

### Global Use Case
<div class="img-container">
  <img src="images/usecase-global.png" class="img-usecase" alt="Global Use Case">
</div>

---

## Branche Fonctionnelle : Cas d'utilisation

### Sprint 1 : Gestion de Base
<div class="img-container">
  <img src="images/sprint1-usecase.png" class="img-usecase" alt="Sprint 1 Use Case">
</div>

---

## Branche Fonctionnelle : Cas d'utilisation

### Sprint 2 : Nutrition & Training
<div class="img-container">
  <img src="images/sprint2-usecase.png" class="img-usecase" alt="Sprint 2 Use Case">
</div>

---

## Branche Fonctionnelle : Maquettes (UI/UX)

<div class="img-container">
  <img src="images/maquette.png" class="img-methodo" alt="Maquettes UI">
</div>

---

## 4. Branche Technique : Tech Stack

<div class="sommaire-grid">
  <div class="dt-card" style="margin-top:0;">
    <h4>Back-end & Architecture</h4>
    <ul>
      <li><strong>DB :</strong> MySQL / <strong>Framework :</strong> Laravel 12</li>
      <li><strong>Architecture :</strong> N-Tiers (Service Layer)</li>
      <li><strong>Spatie :</strong> Rôles & Permissions</li>
    </ul>
  </div>
  <div class="dt-card" style="margin-top:0; border-top-color: #27ae60;">
    <h4>Front-end & Outils</h4>
    <ul>
      <li><strong>Styling :</strong> Tailwind CSS</li>
      <li><strong>Dynamic :</strong> Alpine.js & AJAX</li>
      <li><strong>Icons :</strong> Lucide / <strong>Build :</strong> Vite</li>
    </ul>
  </div>
</div>

---

## 5. Conception : MLD

<h3>Modélisation des données</h3>
<div class="img-container">
  <img src="images/diagramme-class.png" class="img-usecase" alt="MLD Diagram">
</div>

---

## 6. Démonstration : Outils

<div class="sommaire-grid">
  <div class="dt-card" style="margin-top:0;">
    <h4>Développement</h4>
    <ul>
      <li><strong>IDE :</strong> VS Code</li>
      <li><strong>DB :</strong> MySQL Workbench</li>
    </ul>
  </div>
  <div class="dt-card" style="margin-top:0; border-top-color: #27ae60;">
    <h4>Gestion & Versioning</h4>
    <ul>
      <li><strong>Git :</strong> GitHub</li>
      <li><strong>UML :</strong> Mermaid / PlantUML</li>
    </ul>
  </div>
</div>

---

## 7. Conclusion

### Merci pour votre attention !
**Questions ?**