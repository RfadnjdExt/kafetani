// gen_b64.ts — Bun script
// Convert WebP → PNG → base64 untuk Figma Scripter
// Usage: bun run gen_b64.ts
// Requires: bun add sharp

import sharp from "sharp";
import { join } from "path";

const BASE = String.raw`c:\dev\kafetani\assets\img`;
const OUT  = String.raw`c:\dev\kafetani\figma_images.js`;

const images: Record<string, string> = {
  // Products
  kopi_susu_gula_aren:    join(BASE, "products", "kopi_susu_gula_aren.webp"),
  croissant_butter:       join(BASE, "products", "croissant_butter.webp"),
  biji_kopi_arabica_gayo: join(BASE, "products", "biji_kopi_arabica_gayo.webp"),
  kopi_lokal:             join(BASE, "products", "kopi_lokal.webp"),
  arabica_gayo:           join(BASE, "products", "arabica_gayo.webp"),
  gula_aren:              join(BASE, "products", "gula_aren.webp"),
  bakeri_segar:           join(BASE, "products", "bakeri_segar.webp"),
  // About
  about_bahan_segar:      join(BASE, "about", "bahan_segar.webp"),
  about_petani_lokal:     join(BASE, "about", "petani_lokal.webp"),
  about_pesan_online:     join(BASE, "about", "pesan_online.webp"),
  about_bawa_pulang:      join(BASE, "about", "bawa_pulang.webp"),
};

const lines: string[] = [
  "// AUTO-GENERATED — WebP→PNG→base64 untuk Figma Scripter",
  "// Format: PNG (Figma hanya mendukung JPEG & PNG di createImageAsync)",
  "const IMAGES = {",
];

for (const [key, path] of Object.entries(images)) {
  const file = Bun.file(path);
  if (!(await file.exists())) {
    console.warn(`SKIP (not found): ${path}`);
    continue;
  }

  // Baca WebP lalu convert ke JPEG pakai sharp (resize ke max 800px)
  const jpegBuf = await sharp(await file.arrayBuffer())
    .resize(800, 800, { fit: "inside", withoutEnlargement: true })
    .jpeg({ quality: 80 })
    .toBuffer();

  const b64 = jpegBuf.toString("base64");
  lines.push(`  "${key}": "data:image/jpeg;base64,${b64}",`);
  console.log(`OK  ${key}  (${Math.round(b64.length / 1024)} KB)`);
}

lines.push("};");

await Bun.write(OUT, lines.join("\n"));
console.log(`\nSelesai → ${OUT}`);
console.log(`Total: ${Math.round((await Bun.file(OUT).size) / 1024)} KB`);
