# ⏳ PROTOCOL_TIMELINE_BUILDER (THE TIMELINE SPEC)

## Architecture
- Vertical line (`bg-zinc-100`) connecting central nodes.
- Layout: Nodes are primary vertical anchors; Cards are connected horizontally.

## Nodes
- **Styling:** `h-12 w-12`, `bg-white`, `ag-border`.
- **Active State:** `text-cyan-700` and `Cyan-50` background.
- **Micro-interaction:** Subtle scale on hover.

## Cards
- **Styling:** `ag-card`, `p-5`.
- **States:** Hover state triggers `border-cyan-100` and subtle elevation.
- **Gap:** `space-x-6` standard gap between Node and Card.

## Draft_Mode
- Items in `Draft_Mode` must use a **dashed border** (`border-dashed`).
- Labeling: Must include a high-contrast badge: `[DRAFT_MODE]`.
