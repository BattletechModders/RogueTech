## Nomo 2020
Replaces Unity MonoBleedingEdge (MBE) based on Unity 2020.3.38f1. Incorporates fixes from U6000, and mimalloc for improved allocation performance.

# CAUTION - EXPERIMENTAL: BACK UP YOUR DATA!

## Installation
- Backup MonoBleedingEdge/EmbedRuntime if restore required
- Drop into UnityGame defined by compatibility below

## Compatibility
Note, compatibility not guaranteed
- Unity 2018, 2019, 2020 built with mono-bdwgc against MonoBleedingEdge
- Windows Only, Linux once fixes staged

## Nomo 001
**Backports**
- Improve memove upwards/downwards, cooperative condition signal safety on linux for NTPL
- Increase Windows thread stack size to 10MB
- String, container and encoding fixes
- Remove quadratic expansion of `strconcat`
- Fix utf8 offset error
- Assembly fixes
- System Math simplification

**Optimization**
- Add Nomo optimization stubs for eglib
- Note string pooling and internal variables from backport

## Attributions

**Testers**
BattleTech Test:
- 4ier, Pappystein, BloodyDoves, Halberd

Rimworld Test:
- Bradson, SicluvatireSubUmbras, FireproofJeans

KSP Test:
- Pappystein, Gotmachine

**Integration**
- Jamie: Integration into BattleTech Launcher

**Development**
- CptMoore: Conceptual support, support & Linux Testing
- Ziggy: Compilation of mono, backports, mimalloc integration and string pooling
