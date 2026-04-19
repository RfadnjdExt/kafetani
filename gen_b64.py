# gen_b64.py
# Convert gambar WebP → PNG → base64 untuk Figma Scripter
# Requires: pip install Pillow
#
# Usage: python gen_b64.py

import base64
import io
import os
from PIL import Image

BASE = r"c:\dev\kafetani\assets\img"
OUT  = r"c:\dev\kafetani\figma_images.js"

images = {
    # products
    "kopi_susu_gula_aren":   os.path.join(BASE, "products", "kopi_susu_gula_aren.webp"),
    "croissant_butter":      os.path.join(BASE, "products", "croissant_butter.webp"),
    "biji_kopi_arabica_gayo":os.path.join(BASE, "products", "biji_kopi_arabica_gayo.webp"),
    "kopi_lokal":            os.path.join(BASE, "products", "kopi_lokal.webp"),
    "arabica_gayo":          os.path.join(BASE, "products", "arabica_gayo.webp"),
    "gula_aren":             os.path.join(BASE, "products", "gula_aren.webp"),
    "bakeri_segar":          os.path.join(BASE, "products", "bakeri_segar.webp"),
    # about
    "about_bahan_segar":     os.path.join(BASE, "about", "bahan_segar.webp"),
    "about_petani_lokal":    os.path.join(BASE, "about", "petani_lokal.webp"),
    "about_pesan_online":    os.path.join(BASE, "about", "pesan_online.webp"),
    "about_bawa_pulang":     os.path.join(BASE, "about", "bawa_pulang.webp"),
}

lines = [
    "// AUTO-GENERATED — gambar WebP→PNG→base64 untuk Figma Scripter",
    "// Format: PNG (didukung Figma createImageAsync)",
    "const IMAGES = {",
]

for key, path in images.items():
    if not os.path.exists(path):
        print(f"SKIP (not found): {path}")
        continue

    # Buka WebP, convert ke PNG di memory
    img = Image.open(path).convert("RGBA")  # RGBA agar transparansi terjaga
    buf = io.BytesIO()
    img.save(buf, format="PNG", optimize=True)
    buf.seek(0)

    b64 = base64.b64encode(buf.read()).decode("ascii")
    data_uri = f"data:image/png;base64,{b64}"
    lines.append(f'  "{key}": "{data_uri}",')
    print(f"OK  {key}  ({len(b64)//1024} KB base64)")

lines.append("};")

with open(OUT, "w", encoding="utf-8") as f:
    f.write("\n".join(lines))

print(f"\nSelesai → {OUT}")
print(f"Total size: {os.path.getsize(OUT)//1024} KB")
