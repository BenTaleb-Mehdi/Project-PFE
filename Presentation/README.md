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
  <div class="sommaire-item"><div class="sommaire-num">1</div><div class="sommaire-text">Méthodologie de travail</div></div>
  <div class="sommaire-item"><div class="sommaire-num">2</div><div class="sommaire-text">Branche Fonctionnelle</div></div>
  <div class="sommaire-item"><div class="sommaire-num">3</div><div class="sommaire-text">Branche Technique</div></div>
  <div class="sommaire-item"><div class="sommaire-num">4</div><div class="sommaire-text">Conception</div></div>
  <div class="sommaire-item"><div class="sommaire-num">5</div><div class="sommaire-text">Conclusion</div></div>
</div>

---

## Méthodologie : Design Thinking

<div class="img-container">
  <img src="images/designThinking.png" class="img-methodo" alt="Design Thinking">
</div>

---

## Méthodologie : Scrum (Agile)

<div class="img-container">
  <img src="images/scrum.jpg" class="img-methodo" alt="Scrum">
</div>

---


## Branche Fonctionnelle : DÉFINITION

<div class="dt-card" style="border-top-color: #f39c12;">
  <h4>Cadrage du problème</h4>
  <blockquote style="font-style: italic; background: white; padding: 15px; border-radius: 8px;">
    "Ses tâches sont réalisées manuellement via des outils dispersés comme WhatsApp et Excel, ce qui entraîne une perte de temps, un manque d’efficacité et une image professionnelle qui ne reflète pas son véritable niveau d’expertise."
  </blockquote>
</div>

---

## Branche Fonctionnelle : Cas d'utilisation


### Global Use Case Parte Client
<div class="img-container">
  <img src="images/global-usecase-client.png" class="img-usecase" alt="Global Use Case">
</div>

---

### Global Use Case Parte Staff
<div class="img-container">
  <img src="images/usecase-global-staff.png" class="img-usecase" alt="Global Use Case">
</div>

---

### Global Use Case Parte Admin
<div class="img-container">
  <img src="images/global-usecase-admin.png" class="img-usecase" alt="Global Use Case">
</div>

---

## Branche Fonctionnelle : Cas d'utilisation

### Sprint 1 : Gestion de Base
<div class="img-container">
  <img src="images/sprint1-usecase.png" class="img-usecase" alt="Sprint 1 Use Case">
</div>

---

## Branche Fonctionnelle : Cas d'utilisation

### Sprint 2 : Nutrition
<div class="img-container">
  <img src="images/sprint2-usecase.png" class="img-usecase" alt="Sprint 2 Use Case">
</div>

---

## Branche Fonctionnelle : Maquettes (UI/UX) web

<div class="img-container">
  <img src="images/maquette.png" class="img-methodo" alt="Maquettes UI">
</div>

---

## Branche Fonctionnelle : Maquettes (UI/UX) Mobile

<div class="img-container">
  <img src="images/mobile.png" class="img-methodo" alt="Maquettes UI">
</div>

---

## Branche Technique : Tech Stack

<div class="sommaire-grid">
  
  <div class="dt-card" style="margin-top:0; border-top-color: #029fcaff;">
    <h4 style="text-align: center; border-bottom: 2px solid #029fcaff; padding-bottom: 8px;">Back-end & Architecture</h4>
    <div style="text-align: center; margin: 30px 0;">
        <p style="font-size: 1.2em; font-weight: bold; color: #444; letter-spacing: 1px;">
            PHP <span style="color: #029fcaff;">•</span> Laravel <span style="color: #029fcaff;">•</span> MySQL
        </p>
    </div>
    <ul style="list-style: none; padding: 15px 0 0 0; font-size: 0.9em; border-top: 1px solid #eee;">
      <li><strong>Architecture :</strong> N-Tiers (Service Layer)</li>
      <li><strong>Spatie :</strong> Rôles & Permissions</li>
      <li><strong>Moteur :</strong> Eloquent ORM</li>
    </ul>
  </div>

  <div class="dt-card" style="margin-top:0; border-top-color: #27ae60;">
    <h4 style="text-align: center; border-bottom: 2px solid #27ae60; padding-bottom: 8px;">Front-end & Outils</h4> 
    <div style="text-align: center; margin: 30px 0;">
        <p style="font-size: 1.2em; font-weight: bold; color: #444; letter-spacing: 1px;">
            Tailwind CSS <span style="color: #27ae60;">•</span> Alpine.js <span style="color: #27ae60;">•</span> Vite
        </p>
    </div>
    <ul style="list-style: none; padding: 15px 0 0 0; font-size: 0.9em; border-top: 1px solid #eee;">
      <li><strong>UI :</strong> Preline UI & Lucide Icons</li>
      <li><strong>Communication :</strong> AJAX / Axios</li>
      <li><strong>Assets :</strong> Vite Bundler</li>
    </ul>
  </div>

</div>

---
## Conception : MLD

<h3>Modélisation des données</h3>
<div class="img-container">
  <img src="images/diagramme-class.png" class="img-usecase" alt="MLD Diagram">
</div>

---

## Conclusion

### Merci pour votre attention !
**Questions ?**