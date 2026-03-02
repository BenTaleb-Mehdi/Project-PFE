# 🗺️ ANTIGRAVITY PAGES MAP (V3.2)

## 📂 FOLDER: `/admin/` (Full Authority)
- **`dashboard.html`**: 
  - Central KPIs (Active Clients, Revenue, Macro-Compliance).
  - Staff activity feed.
- **`categories.html`** `[NEW]`: 
  - **Category Management Center**: Full CRUD for meal/program categories.
  - **Inline Editor**: Quick-edit names and Slugs (`font-mono`).
  - **Color Sync**: Assign Cyan/Emerald/Zinc accents to specific categories.
- **`nutrition.html`**: 
  - The Full Engine: Global Meal Database + Program Builder.
  - Integration with **Rich Text Engine** for professional instructions.
- **`clients.html`**: 
  - Client CRM: List view, status tracking, and Program Assignment tools.
- **`style.css`**: 
  - Global Design System variables (Zinc-200 borders, `rounded-none`, Cyan-600 accents).

---

## 📂 FOLDER: `/client/` (Focus & Data)
- **`portal.html`**: 
  - Dashboard: "Today's Macros" vs "Target Macros" (JetBrains Mono).
- **`tracker.html`**: 
  - Progress logging: Weight, Body-fat %, and Photo uploads.
- **`program-view.html`**: 
  - Assigned Meal Plans: Read-only view of the coach's instructions.
  **`evolution.html`** `[NEW]`: 
  - **Monthly Progress Gallery**: 1-click upload for monthly check-ins.
  - **Comparison Engine**: Side-by-side visual analysis.
  - **Metadata**: Automatic `font-mono` timestamping and Weight sync.

---

## 📂 FOLDER: `/components/` (Architectural Building Blocks)
- **`Sidebar.html`**: 
  - Logic: Responsive Drawer (Alpine.js) with Role-Based Access Control (RBAC).
- **`CategoryManager.html`**: 
  - Feature: Portal-based dropdowns for "Move Meals," "Delete," and "Archive."
- **`RichTextEditor.html`**: 
  - Feature: Full **Tiptap** toolbar implementation for meal recipes/notes.
- **`Modal.html`**: 
  - Visual: `rounded-none`, Hard-shadow (`shadow-[4px_4px_0px_0px]`).
- **`MacroCard.html`**: 
  - Visual: High-contrast `font-mono` metrics for P/C/F/Kcal data.

---

## ⚙️ SYSTEM LOGIC RULES
1. **Category Protection**: A category cannot be deleted if it contains active meals (Logic: Move or Delete meals first).
2. **Slug Auto-Gen**: Input "Breakfast Meals" → Output `BREAKFAST_MEALS` (`font-mono text-cyan-700`).
3. **Admin vs Staff**: Staff can edit `nutrition.html` and `clients.html` but are locked out of `categories.html` settings and Finance KPIs.