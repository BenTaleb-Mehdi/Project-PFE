# 🛰️ AntiGravity V3.0 | Agent Graphic Rules

This document defines the behavioral and visual protocols for the AI Graphic Agent. It ensures that every chart, graph, and data visualization generated for the **Admin** and **Client** interfaces adheres to the system's industrial, monospaced design language.

---

## 🛠️ Global Visual Standards
All graphics must strictly follow these "Atomic" constraints:
- **Typography:** `JetBrains Mono` or `Courier New` (Monospace).
- **Text Transform:** All labels must be `UPPERCASE`.
- **Geometry:** `Tension: 0`. No bezier curves. Use straight line paths only.
- **Palette:** 
  - Primary: `#0891B2` (Cyan_600)
  - Secondary: `#71717A` (Zinc_400)
  - Background: `#FFFFFF` (White)
  - Border: `#E4E4E7` (Zinc_200)

---

## 👑 Role: Admin_Engine_Agent
**Context:** Diagnostic dashboard for `Master_Admin`.
**Objective:** High data density, system control, and performance logging.

### Graphic Rules:
1. **Complexity:** Show multiple datasets (overlays) simultaneously.
2. **Grid System:** Full grid visibility using `#F4F4F5` (Zinc_100).
3. **Data Naming:** Use technical suffixes (e.g., `_LOG`, `_FREQ`, `_DB`).
4. **Specific Molecule:** `admin-bar-chart`.

---

## 👤 Role: Client_Progress_Agent
**Context:** Personal dashboard for end users.
**Objective:** Clarity, motivation, and milestone tracking.

### Graphic Rules:
1. **Complexity:** Single dataset focus. Simplified views.
2. **Grid System:** Remove Y-axis grid lines; keep X-axis only for time progression.
3. **Aesthetic:** Use `fill: true` with a `0.05` opacity Cyan gradient.
4. **Specific Molecule:** `client-progress-line`.

---

## 📊 Technical Implementation (Chart.js Configuration)

| Parameter | Admin Setting | Client Setting |
| :--- | :--- | :--- |
| `tension` | `0` (Strict) | `0` (Strict) |
| `pointRadius` | `2` (Small) | `5` (Large/Visible) |
| `borderDash` | `[0]` (Solid) | `[5, 5]` (Dashed for targets) |
| `grid.display` | `true` | `false` |
| `plugins.legend` | `top` (Small text) | `hidden` |

---

## 🚀 Usage Instructions
When initiating a chart generation, specify the target:
`"Using the AGENT_RULES.md, generate a graphic for the [ADMIN/CLIENT] profile."`