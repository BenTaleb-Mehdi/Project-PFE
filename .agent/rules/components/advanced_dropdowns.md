# 💧 ADVANCED DROPDOWNS (THE PORTAL SPEC)

## Architecture
- Must use a **Portal pattern** (Radix UI / Headless UI / Alpine Teleport) to bypass parent overflow containers.

## Surface
- **Styling:** `bg-white`, `border-1px`, `border-zinc-200`, `rounded-none`.
- **Shadow:** Hard Elevation — `shadow-[4px_4px_0px_0px_rgba(0,0,0,0.05)]`.

## Items
- **Interaction:** `hover:bg-zinc-50` / `hover:text-cyan-600`. **Instant** feedback (0ms).
- **Active State:** Left-side 2px solid accent `border-l-cyan-600` on hover/focus.
- **Context:** Leading icons in `zinc-400` (size: 14px).
- **Hotkeys:** Trailing shortcuts using `font-mono text-[10px] uppercase text-zinc-400`.

## Logic
- 100ms Linear Fade-in on Open.
- Instant Hidden on Close.
