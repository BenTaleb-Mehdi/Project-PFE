# 📊 CALIBRATED CHARTS (THE ANALYTICS SPEC)

## Core Aesthetics
- **Palette:** Strict **Monochrome-Cyan Scale** (Cyan-50 to Cyan-950).
- **Primary Stroke:** Cyan-600 `#0891B2` (2px weight).
- **Area Fill:** Linear Gradient. Start: `Cyan-600` at 10% opacity. End: `Transparent`.
- **Grid Lines:** Zinc-100 (1px solid, dashed: `4 4`). No vertical grids.

## Typography
- **Labels/Values:** `font-mono text-[10px] text-zinc-400 uppercase`.
- **Tooltips:** `bg-zinc-950 text-zinc-50 rounded-none p-2 text-[10px] font-mono shadow-md`.

## Interaction
- **Hover Pulse:** 4px Cyan-600 dot on data points.
- **Geometry:** Hard edges only (`rounded-none`).
- **Animation:** 300ms Linear Ease-in.

## Configuration (Chart.js)
- `tension`: `0` (Strict lines only).
- `pointRadius`: `2` (Admin) / `5` (Client).
- `borderDash`: `[0]` (Solid) for live data / `[5, 5]` (Dashed) for targets.
