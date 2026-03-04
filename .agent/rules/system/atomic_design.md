# ⚛️ ATOMIC DESIGN PRINCIPLES

## 1. Atoms
- Smallest building block.
- Examples: `Button`, `Input`, `Badge`.
- Dependency: None.

## 2. Molecules
- Group of atoms.
- Examples: `FormGroup`, `TimelineNode`.
- Dependency: Must use Atoms.

## 3. Organisms (Components)
- Autonomous functional units.
- Examples: `Sidebar`, `NutritionTable`.
- Dependency: Uses Molecules and Atoms.

## Manifest Registration
- Every newly created component must be registered in the corresponding `ui-kit/` manifest.
