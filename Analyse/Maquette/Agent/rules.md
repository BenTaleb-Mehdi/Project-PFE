# 📜 ANTI-GRAVITY UI RULES (REACTBIT LIGHT V3.0)

## 🎨 VISUAL IDENTITY (THE LIGHT SPEC)
- **Backgrounds:** Pure White `#FFFFFF` / Zinc-50 `#FAFAFA`.
- **Borders:** Strict 1px solid `#E4E4E7` (Zinc-200). **No Rounded Corners** (`rounded-none`).
- **Accents:** Primary Cyan-600 `#0891B2` / Success Emerald-600 `#059669`.
- **Typography:** - Labels/Prose: `font-sans` (Zinc-900).
  - Metrics/Macros/IDs: `font-mono` (Cyan-700) - JetBrains Mono.

## 💧 ADVANCED DROPDOWNS (THE PORTAL SPEC)
- **Architecture:** Must use a **Portal pattern** (Radix UI / Headless UI) to bypass parent containers.
- **Surface:** - `bg-white`, `border-1px`, `border-zinc-200`, `rounded-none`.
  - **Shadow:** Hard Elevation — `shadow-[4px_4px_0px_0px_rgba(0,0,0,0.05)]`.
- **Items:**
  - **Interaction:** `hover:bg-zinc-50` / `hover:text-cyan-600`. **Instant** feedback (0ms).
  - **Active State:** Left-side 2px solid accent `border-l-cyan-600` on hover/focus.
  - **Context:** Leading icons in `zinc-400` (size: 14px).
  - **Hotkeys:** Trailing shortcuts using `font-mono text-[10px] uppercase text-zinc-400`.
- **Logic:** 100ms Linear Fade-in on Open. Instant Hidden on Close.

## 📱 MOBILE & RESPONSIVE
- **Behavior:** 100% Fluid. Sidebar becomes a Mobile Drawer (Hamburger Menu).
- **Touch-Friendly:** Buttons & Inputs min-height 44px.
- **Grids:** `grid-cols-1` (Mobile) -> `grid-cols-2` (Tablet) -> `grid-cols-3+` (Desktop).

## 🔐 ACCESS CONTROL
- **ADMIN (COACH):** Full Dashboard + Team + Finance.
- **STAFF (CO-COACH):** Client Folders + Nutrition Engine. No Finance.
- **CLIENT:** Personal Tracker + Program View.

## ✍️ RICH TEXT ENGINE (THE EDITOR SPEC)
- **Toolbar:** - `sticky top-0`, `bg-white`, `border-b-1px`, `border-zinc-200`.
  - **Buttons:** `rounded-none`, `h-10`, `w-10`, `hover:bg-zinc-50`.
  - **Active State:** `bg-cyan-50`, `text-cyan-700`, `border-b-2 border-cyan-600`.
- **Content Area:** - `prose prose-zinc`, `max-w-none`, `p-6`, `focus:outline-none`.
  - Headers (`h1`, `h2`): `font-sans font-bold tracking-tight text-zinc-900`.
  - Code Blocks: `font-mono bg-zinc-900 text-zinc-50 p-4`.
- **Included Options:** - Text: Bold, Italic, Underline, Strike.
  - Structure: H1, H2, H3, Bullet List, Ordered List, Quote.
  - Advanced: Link, Image Upload, Code Block, Horizontal Rule, Table Support.