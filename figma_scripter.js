// ============================================================
// KAFETANI — Figma Scripter (v6)
// Font: Cormorant Garamond (display) + DM Sans (body)
// Gambar: embedded dari assets/img via figma_images.js
//
// CARA PAKAI:
//   1. Jalankan bun run gen_b64.ts untuk membuat figma_images.js
//   2. Paste figma_images.js ke Scripter, lalu paste script ini.
// ============================================================

// ── SVG LOGO: logo_v3.svg (navbar) ──────────────────────────
const LOGO_NAV_SVG = `<svg width="680" height="105" viewBox="0 135 680 105" xmlns="http://www.w3.org/2000/svg">
  <g transform="translate(92, 235)">
    <path d="M 0 0 C 10 -30 18 -58 25 -85" fill="none" stroke="#2D5016" stroke-width="1.3" stroke-linecap="round"/>
    <path transform="translate(3,-17) rotate(-58)" d="M 0 0 C -4.5 -8 -4.5 -16 0 -20 C 4.5 -16 4.5 -8 0 0 Z" fill="#4A7C23"/>
    <path transform="translate(7,-19) rotate(28)" d="M 0 0 C -4.5 -8 -4.5 -16 0 -20 C 4.5 -16 4.5 -8 0 0 Z" fill="#2D5016"/>
    <path transform="translate(11,-43) rotate(-65)" d="M 0 0 C -4 -7 -4 -15 0 -18 C 4 -15 4 -7 0 0 Z" fill="#2D5016"/>
    <path transform="translate(17,-46) rotate(20)" d="M 0 0 C -4 -7 -4 -15 0 -18 C 4 -15 4 -7 0 0 Z" fill="#4A7C23"/>
    <path transform="translate(21,-67) rotate(-72)" d="M 0 0 C -3.5 -6 -3.5 -13 0 -16 C 3.5 -13 3.5 -6 0 0 Z" fill="#7BAD45"/>
    <circle cx="25" cy="-85" r="4.5" fill="#C8883A"/>
    <circle cx="29" cy="-79" r="3" fill="#C8883A" opacity="0.65"/>
    <circle cx="20" cy="-80" r="2.5" fill="#C8883A" opacity="0.5"/>
  </g>
  <g transform="translate(588, 235) scale(-1, 1)">
    <path d="M 0 0 C 10 -30 18 -58 25 -85" fill="none" stroke="#2D5016" stroke-width="1.3" stroke-linecap="round"/>
    <path transform="translate(3,-17) rotate(-58)" d="M 0 0 C -4.5 -8 -4.5 -16 0 -20 C 4.5 -16 4.5 -8 0 0 Z" fill="#4A7C23"/>
    <path transform="translate(7,-19) rotate(28)" d="M 0 0 C -4.5 -8 -4.5 -16 0 -20 C 4.5 -16 4.5 -8 0 0 Z" fill="#2D5016"/>
    <path transform="translate(11,-43) rotate(-65)" d="M 0 0 C -4 -7 -4 -15 0 -18 C 4 -15 4 -7 0 0 Z" fill="#2D5016"/>
    <path transform="translate(17,-46) rotate(20)" d="M 0 0 C -4 -7 -4 -15 0 -18 C 4 -15 4 -7 0 0 Z" fill="#4A7C23"/>
    <path transform="translate(21,-67) rotate(-72)" d="M 0 0 C -3.5 -6 -3.5 -13 0 -16 C 3.5 -13 3.5 -6 0 0 Z" fill="#7BAD45"/>
    <circle cx="25" cy="-85" r="4.5" fill="#C8883A"/>
    <circle cx="29" cy="-79" r="3" fill="#C8883A" opacity="0.65"/>
    <circle cx="20" cy="-80" r="2.5" fill="#C8883A" opacity="0.5"/>
  </g>
  <line x1="158" y1="150" x2="308" y2="150" stroke="#6B4C30" stroke-width="0.6"/>
  <path d="M 340 136 C 333 142 331 148 340 151 C 349 148 347 142 340 136 Z" fill="#2D5016"/>
  <path d="M 340 151 C 333 154 331 160 340 163 C 349 160 347 154 340 151 Z" fill="#4A7C23"/>
  <circle cx="340" cy="149" r="2.8" fill="#C8883A"/>
  <line x1="372" y1="150" x2="522" y2="150" stroke="#6B4C30" stroke-width="0.6"/>
  <text x="340" y="210" text-anchor="middle" font-family="Georgia" font-size="65" font-weight="300" fill="#2D5016" letter-spacing="4">KAFETANI</text>
  <line x1="158" y1="228" x2="310" y2="228" stroke="#6B4C30" stroke-width="0.6"/>
  <polygon points="340,222 347,228 340,234 333,228" fill="#C8883A"/>
  <line x1="370" y1="228" x2="522" y2="228" stroke="#6B4C30" stroke-width="0.6"/>
</svg>`;

// ── SVG LOGO: footer (putih + tagline) ──────────────────────
const LOGO_FOOTER_SVG = `<svg width="680" height="140" viewBox="0 135 680 140" xmlns="http://www.w3.org/2000/svg">
  <g transform="translate(92, 235)">
    <path d="M 0 0 C 10 -30 18 -58 25 -85" fill="none" stroke="#fff" stroke-width="1.3" stroke-linecap="round"/>
    <path transform="translate(3,-17) rotate(-58)" d="M 0 0 C -4.5 -8 -4.5 -16 0 -20 C 4.5 -16 4.5 -8 0 0 Z" fill="rgba(255,255,255,0.8)"/>
    <path transform="translate(7,-19) rotate(28)" d="M 0 0 C -4.5 -8 -4.5 -16 0 -20 C 4.5 -16 4.5 -8 0 0 Z" fill="rgba(255,255,255,0.6)"/>
    <path transform="translate(11,-43) rotate(-65)" d="M 0 0 C -4 -7 -4 -15 0 -18 C 4 -15 4 -7 0 0 Z" fill="rgba(255,255,255,0.6)"/>
    <path transform="translate(17,-46) rotate(20)" d="M 0 0 C -4 -7 -4 -15 0 -18 C 4 -15 4 -7 0 0 Z" fill="rgba(255,255,255,0.8)"/>
    <path transform="translate(21,-67) rotate(-72)" d="M 0 0 C -3.5 -6 -3.5 -13 0 -16 C 3.5 -13 3.5 -6 0 0 Z" fill="#fff"/>
    <circle cx="25" cy="-85" r="4.5" fill="rgba(255,255,255,0.7)"/>
    <circle cx="29" cy="-79" r="3" fill="rgba(255,255,255,0.5)"/>
    <circle cx="20" cy="-80" r="2.5" fill="rgba(255,255,255,0.4)"/>
  </g>
  <g transform="translate(588, 235) scale(-1, 1)">
    <path d="M 0 0 C 10 -30 18 -58 25 -85" fill="none" stroke="#fff" stroke-width="1.3" stroke-linecap="round"/>
    <path transform="translate(3,-17) rotate(-58)" d="M 0 0 C -4.5 -8 -4.5 -16 0 -20 C 4.5 -16 4.5 -8 0 0 Z" fill="rgba(255,255,255,0.8)"/>
    <path transform="translate(7,-19) rotate(28)" d="M 0 0 C -4.5 -8 -4.5 -16 0 -20 C 4.5 -16 4.5 -8 0 0 Z" fill="rgba(255,255,255,0.6)"/>
    <path transform="translate(11,-43) rotate(-65)" d="M 0 0 C -4 -7 -4 -15 0 -18 C 4 -15 4 -7 0 0 Z" fill="rgba(255,255,255,0.6)"/>
    <path transform="translate(17,-46) rotate(20)" d="M 0 0 C -4 -7 -4 -15 0 -18 C 4 -15 4 -7 0 0 Z" fill="rgba(255,255,255,0.8)"/>
    <path transform="translate(21,-67) rotate(-72)" d="M 0 0 C -3.5 -6 -3.5 -13 0 -16 C 3.5 -13 3.5 -6 0 0 Z" fill="#fff"/>
    <circle cx="25" cy="-85" r="4.5" fill="rgba(255,255,255,0.7)"/>
    <circle cx="29" cy="-79" r="3" fill="rgba(255,255,255,0.5)"/>
    <circle cx="20" cy="-80" r="2.5" fill="rgba(255,255,255,0.4)"/>
  </g>
  <line x1="158" y1="150" x2="308" y2="150" stroke="rgba(255,255,255,0.4)" stroke-width="0.6"/>
  <path d="M 340 136 C 333 142 331 148 340 151 C 349 148 347 142 340 136 Z" fill="rgba(255,255,255,0.8)"/>
  <path d="M 340 151 C 333 154 331 160 340 163 C 349 160 347 154 340 151 Z" fill="rgba(255,255,255,0.6)"/>
  <circle cx="340" cy="149" r="2.8" fill="rgba(255,255,255,0.6)"/>
  <line x1="372" y1="150" x2="522" y2="150" stroke="rgba(255,255,255,0.4)" stroke-width="0.6"/>
  <text x="340" y="210" text-anchor="middle" font-family="Georgia" font-size="65" font-weight="300" fill="#fff" letter-spacing="4">KAFETANI</text>
  <line x1="158" y1="228" x2="310" y2="228" stroke="rgba(255,255,255,0.4)" stroke-width="0.6"/>
  <polygon points="340,222 347,228 340,234 333,228" fill="rgba(255,255,255,0.5)"/>
  <line x1="370" y1="228" x2="522" y2="228" stroke="rgba(255,255,255,0.4)" stroke-width="0.6"/>
  <text x="340" y="254" text-anchor="middle" font-family="Arial" font-size="11" fill="rgba(255,255,255,0.5)" letter-spacing="3.8">FARM TO TABLE · CAFE &amp; MARKET</text>
</svg>`;

const HERO_PATTERN_SVG = `<svg width="500" height="600" viewBox="0 0 500 600" fill="none" xmlns="http://www.w3.org/2000/svg">
  <circle cx="250" cy="300" r="200" stroke="white" stroke-width="1" opacity="0.1"/>
  <circle cx="250" cy="300" r="150" stroke="white" stroke-width="0.5" opacity="0.1"/>
  <circle cx="250" cy="300" r="100" stroke="white" stroke-width="0.5" opacity="0.1"/>
  <line x1="50" y1="300" x2="450" y2="300" stroke="white" stroke-width="0.5" opacity="0.1"/>
  <line x1="250" y1="100" x2="250" y2="500" stroke="white" stroke-width="0.5" opacity="0.1"/>
  <line x1="109" y1="159" x2="391" y2="441" stroke="white" stroke-width="0.4" opacity="0.1"/>
  <line x1="391" y1="159" x2="109" y2="441" stroke="white" stroke-width="0.4" opacity="0.1"/>
</svg>`;

// ── SVG ICONS (menggantikan emoji) ──────────────────────────
// Icon keranjang belanja
const ICON_CART = `<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
  <path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
  <line x1="3" y1="6" x2="21" y2="6" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round"/>
  <path d="M16 10a4 4 0 01-8 0" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
</svg>`;

// Icon daun / bahan segar
const ICON_LEAF = `<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
  <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
</svg>`;

// Icon petani / orang
const ICON_FARMER = `<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
  <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
  <circle cx="9" cy="7" r="4" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
  <path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
</svg>`;

// Icon smartphone / pesan online
const ICON_PHONE = `<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
  <rect x="5" y="2" width="14" height="20" rx="2" ry="2" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
  <line x1="12" y1="18" x2="12.01" y2="18" stroke="#ffffff" stroke-width="2" stroke-linecap="round"/>
</svg>`;

// Icon rumah / bawa pulang
const ICON_HOME = `<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
  <path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
  <polyline points="9 22 9 12 15 12 15 22" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
</svg>`;

// ── WARNA ──────────────────────────────────────────────────
const C = {
  cream:      { r: 0.969, g: 0.953, b: 0.925 }, // #F7F3EC
  cream2:     { r: 0.937, g: 0.910, b: 0.851 }, // #EFE8D9
  brown:      { r: 0.231, g: 0.165, b: 0.102 }, // #3B2A1A
  brown2:     { r: 0.420, g: 0.298, b: 0.188 }, // #6B4C30
  green:      { r: 0.176, g: 0.314, b: 0.086 }, // #2D5016
  green2:     { r: 0.290, g: 0.486, b: 0.137 }, // #4A7C23
  greenLight: { r: 0.918, g: 0.941, b: 0.859 }, // #EAF0DC
  amber:      { r: 0.784, g: 0.533, b: 0.227 }, // #C8883A
  amberLight: { r: 0.961, g: 0.925, b: 0.847 }, // #F5ECD8
  textMid:    { r: 0.478, g: 0.396, b: 0.314 }, // #7A6550
  textLight:  { r: 0.663, g: 0.588, b: 0.494 }, // #A9967E
  border:     { r: 0.851, g: 0.808, b: 0.737 }, // #D9CEBC
  white:      { r: 1,     g: 1,     b: 1     },
  black:      { r: 0,     g: 0,     b: 0     },
};

// ── FONTS ──────────────────────────────────────────────────
// Display: Cormorant Garamond (serif untuk judul)
// Body:    DM Sans (sans-serif untuk teks)
const FF = {
  display: "Cormorant Garamond",
  body:    "DM Sans",
};
// Style yang tersedia:
// Cormorant Garamond: "Light", "Regular", "SemiBold", "Bold", "Light Italic", "Italic"
// DM Sans: "Light", "Regular", "Medium", "Bold"

// ── HELPERS ────────────────────────────────────────────────
function solid(color, opacity = 1) {
  return [{ type: "SOLID", color, opacity }];
}

function frame(name, w, h) {
  const f = figma.createFrame();
  f.name = name;
  f.resize(w, h);
  f.fills = [];
  f.clipsContent = false;
  return f;
}

function rect(name, w, h, color, x = 0, y = 0, radius = 0) {
  const r = figma.createRectangle();
  r.name = name;
  r.resize(w, h);
  r.x = x; r.y = y;
  r.fills = solid(color);
  r.cornerRadius = radius;
  return r;
}

// Buat text node: family = "display" | "body"
async function txt(content, size, color, family = "body", style = "Regular", opacity = 1) {
  const t = figma.createText();
  const ff = family === "display" ? FF.display : FF.body;
  await figma.loadFontAsync({ family: ff, style });
  t.fontName = { family: ff, style };
  t.characters = content;
  t.fontSize = size;
  t.fills = solid(color);
  t.opacity = opacity;
  return t;
}

// Buat SVG icon node dengan warna dan ukuran tertentu
function svgIcon(svgStr, size) {
  const node = figma.createNodeFromSvg(svgStr);
  node.rescale(size / 24); // viewBox 0 0 24 24
  return node;
}

// Buat gambar fill dari data URI base64
async function imageFill(dataUri) {
  const img = await figma.createImageAsync(dataUri);
  return [{ type: "IMAGE", scaleMode: "FILL", imageHash: img.hash }];
}

// Frame dengan gambar sebagai fill (cover/fill)
async function imgFrame(name, w, h, dataUri) {
  const f = frame(name, w, h);
  f.clipsContent = true;
  if (dataUri) {
    f.fills = await imageFill(dataUri);
  }
  return f;
}

// ══════════════════════════════════════════════════════════
// BUILD KAFETANI HOMEPAGE
// ══════════════════════════════════════════════════════════
async function buildKafetani() {
  const W = 1440;

  const root = frame("Kafetani — Homepage", W, 100);
  root.fills = solid(C.cream);
  root.layoutMode = "VERTICAL";
  root.primaryAxisSizingMode = "AUTO";
  root.counterAxisSizingMode = "FIXED";
  root.clipsContent = false;

  // ────────────────────────────────────────────────────────
  // 1. NAVBAR
  // ────────────────────────────────────────────────────────
  {
    const nav = frame("Navbar", W, 60);
    nav.fills = solid(C.cream);
    nav.strokeAlign = "INSIDE";
    nav.strokes = solid(C.border);
    nav.strokeWeight = 1;
    nav.layoutMode = "HORIZONTAL";
    nav.primaryAxisSizingMode = "FIXED";
    nav.counterAxisSizingMode = "FIXED";
    nav.primaryAxisAlignItems = "SPACE_BETWEEN";
    nav.counterAxisAlignItems = "CENTER";
    nav.paddingLeft = 40;
    nav.paddingRight = 40;
    nav.itemSpacing = 0;

    // Logo SVG asli
    const logoNode = figma.createNodeFromSvg(LOGO_NAV_SVG);
    logoNode.name = "Logo";
    logoNode.rescale(28 / 105);
    nav.appendChild(logoNode);

    // Nav links (DM Sans Light)
    const linksGroup = frame("Nav Links", 1, 1);
    linksGroup.fills = [];
    linksGroup.layoutMode = "HORIZONTAL";
    linksGroup.primaryAxisSizingMode = "AUTO";
    linksGroup.counterAxisSizingMode = "AUTO";
    linksGroup.counterAxisAlignItems = "CENTER";
    linksGroup.itemSpacing = 32;

    for (const link of ["BERANDA", "MENU KAFE", "MARKETPLACE", "LOGIN"]) {
      const lnk = await txt(link, 11, C.textMid, "body", "Light");
      lnk.letterSpacing = { value: 4, unit: "PERCENT" };
      linksGroup.appendChild(lnk);
    }
    nav.appendChild(linksGroup);

    // Cart button
    const cartBtn = frame("Cart Button", 1, 1);
    cartBtn.fills = solid(C.green);
    cartBtn.layoutMode = "HORIZONTAL";
    cartBtn.primaryAxisSizingMode = "AUTO";
    cartBtn.counterAxisSizingMode = "AUTO";
    cartBtn.primaryAxisAlignItems = "CENTER";
    cartBtn.counterAxisAlignItems = "CENTER";
    cartBtn.paddingLeft = 16; cartBtn.paddingRight = 16;
    cartBtn.paddingTop = 10; cartBtn.paddingBottom = 10;
    cartBtn.itemSpacing = 8;

    const cartIcon = svgIcon(ICON_CART, 14);
    cartBtn.appendChild(cartIcon);
    const cartTxt = await txt("Keranjang", 12, C.white, "body", "Medium");
    cartBtn.appendChild(cartTxt);

    // Badge dengan angka (mengikuti web asli)
    const badge = frame("Badge", 18, 18);
    badge.fills = solid(C.amber);
    badge.cornerRadius = 9;
    badge.layoutMode = "HORIZONTAL";
    badge.primaryAxisAlignItems = "CENTER";
    badge.counterAxisAlignItems = "CENTER";
    const badgeTxt = await txt("3", 10, C.white, "body", "Bold");
    badge.appendChild(badgeTxt);
    cartBtn.appendChild(badge);

    nav.appendChild(cartBtn);
    root.appendChild(nav);
  }

  // ────────────────────────────────────────────────────────
  // 2. HERO
  // ────────────────────────────────────────────────────────
  {
    const hero = frame("Hero", W, 680);
    hero.layoutMode = "HORIZONTAL";
    hero.primaryAxisSizingMode = "FIXED";
    hero.counterAxisSizingMode = "FIXED";

    // Hero Kiri — cream
    const heroL = frame("Hero Left", W / 2, 680);
    heroL.fills = solid(C.cream);
    heroL.layoutMode = "VERTICAL";
    heroL.primaryAxisSizingMode = "FIXED";
    heroL.counterAxisSizingMode = "FIXED";
    heroL.primaryAxisAlignItems = "CENTER";
    heroL.paddingLeft = 56; heroL.paddingRight = 48;
    heroL.paddingTop = 80; heroL.paddingBottom = 64;
    heroL.itemSpacing = 0;

    // Tag line (DM Sans Light)
    const heroTag = await txt("— FARM TO TABLE  ·  SEJAK PANEN", 11, C.textLight, "body", "Light");
    heroTag.letterSpacing = { value: 18, unit: "PERCENT" };
    heroL.appendChild(heroTag);

    const gap1 = frame("gap", 1, 20); heroL.appendChild(gap1);

    // Judul (Cormorant Garamond Light)
    const titleFrame = frame("Title", 480, 1);
    titleFrame.layoutMode = "VERTICAL";
    titleFrame.primaryAxisSizingMode = "AUTO";
    titleFrame.counterAxisSizingMode = "FIXED";
    titleFrame.itemSpacing = 0;

    const t1 = await txt("Dari ", 60, C.brown, "display", "Light");
    const t1i = await txt("ladang", 60, C.green, "display", "Light Italic");
    const titleRow = frame("Title Row 1", 1, 1);
    titleRow.layoutMode = "HORIZONTAL";
    titleRow.primaryAxisSizingMode = "AUTO";
    titleRow.counterAxisSizingMode = "AUTO";
    titleRow.counterAxisAlignItems = "BASELINE";
    titleRow.itemSpacing = 0;
    titleRow.fills = [];
    titleRow.appendChild(t1);
    titleRow.appendChild(t1i);
    titleFrame.appendChild(titleRow);

    const t2 = await txt("ke cangkirmu", 60, C.brown, "display", "Light");
    titleFrame.appendChild(t2);
    heroL.appendChild(titleFrame);

    const gap2 = frame("gap", 1, 22); heroL.appendChild(gap2);

    const desc = await txt(
      "Kafetani menghubungkan petani lokal langsung ke meja kamu\n— kopi, bakeri, dan bahan segar pilihan tanpa perantara.",
      15, C.textMid, "body", "Light"
    );
    desc.lineHeight = { value: 180, unit: "PERCENT" };
    heroL.appendChild(desc);

    const gap3 = frame("gap", 1, 40); heroL.appendChild(gap3);

    // CTA buttons
    const btnRow = frame("CTA", 1, 1);
    btnRow.fills = []; btnRow.layoutMode = "HORIZONTAL";
    btnRow.primaryAxisSizingMode = "AUTO"; btnRow.counterAxisSizingMode = "AUTO";
    btnRow.counterAxisAlignItems = "CENTER"; btnRow.itemSpacing = 16;

    const bPrimary = frame("Pesan Sekarang", 1, 1);
    bPrimary.fills = solid(C.green); bPrimary.layoutMode = "HORIZONTAL";
    bPrimary.primaryAxisSizingMode = "AUTO"; bPrimary.counterAxisSizingMode = "AUTO";
    bPrimary.paddingLeft = 28; bPrimary.paddingRight = 28;
    bPrimary.paddingTop = 13; bPrimary.paddingBottom = 13;
    bPrimary.appendChild(await txt("Pesan Sekarang", 13, C.white, "body", "Medium"));
    btnRow.appendChild(bPrimary);

    const bOutline = frame("Lihat Marketplace", 1, 1);
    bOutline.fills = []; bOutline.strokes = solid(C.brown); bOutline.strokeWeight = 1;
    bOutline.layoutMode = "HORIZONTAL";
    bOutline.primaryAxisSizingMode = "AUTO"; bOutline.counterAxisSizingMode = "AUTO";
    bOutline.paddingLeft = 28; bOutline.paddingRight = 28;
    bOutline.paddingTop = 13; bOutline.paddingBottom = 13;
    bOutline.appendChild(await txt("Lihat Marketplace", 13, C.brown, "body", "Regular"));
    btnRow.appendChild(bOutline);

    heroL.appendChild(btnRow);
    hero.appendChild(heroL);

    // Hero Kanan — green + foto kopi
    const heroR = frame("Hero Right", W / 2, 680);
    heroR.fills = solid(C.green);
    heroR.layoutMode = "VERTICAL";
    heroR.primaryAxisSizingMode = "FIXED";
    heroR.counterAxisSizingMode = "FIXED";
    heroR.primaryAxisAlignItems = "CENTER";
    heroR.counterAxisAlignItems = "CENTER";
    heroR.itemSpacing = 24;
    heroR.paddingTop = 60; heroR.paddingBottom = 60;
    heroR.clipsContent = true;

    // Pattern background hero
    const patternNode = figma.createNodeFromSvg(HERO_PATTERN_SVG);
    patternNode.name = "Hero Pattern";
    patternNode.rescale(1);
    patternNode.x = (W / 2 - 500) / 2;
    patternNode.y = (680 - 600) / 2;
    heroR.appendChild(patternNode);

    // Foto kopi (lingkaran) - Sekarang menggunakan frame + auto layout untuk label di tengah
    const circleClip = frame("Kopi Lokal Circle", 260, 260);
    circleClip.clipsContent = true;
    circleClip.cornerRadius = 130;
    circleClip.layoutMode = "VERTICAL";
    circleClip.primaryAxisAlignItems = "CENTER";
    circleClip.counterAxisAlignItems = "CENTER";
    circleClip.strokes = solid(C.white, 0.15);
    circleClip.strokeWeight = 1;

    // Foto background circle
    if (typeof IMAGES !== "undefined" && IMAGES["kopi_lokal"]) {
      circleClip.fills = await imageFill(IMAGES["kopi_lokal"]);
    } else {
      circleClip.fills = solid(C.cream2);
    }

    // Label di TENGAH foto (mengikuti figma scripter & web asli)
    const labelBg = frame("Label Bg", 1, 1);
    labelBg.fills = solid({ r: 0.165, g: 0.122, b: 0.071 }, 0.6); // #2A1F12 60%
    labelBg.cornerRadius = 20;
    labelBg.paddingLeft = 24; labelBg.paddingRight = 24;
    labelBg.paddingTop = 4; labelBg.paddingBottom = 4;
    labelBg.layoutMode = "HORIZONTAL";
    labelBg.primaryAxisSizingMode = "AUTO";
    labelBg.counterAxisSizingMode = "AUTO";

    const kopiLabel = await txt("Kopi Lokal", 22, C.white, "display", "Light");
    labelBg.appendChild(kopiLabel);
    circleClip.appendChild(labelBg);

    heroR.appendChild(circleClip);

    // Pills
    const pillRow = frame("Herb Pills", 1, 1);
    pillRow.fills = []; pillRow.layoutMode = "HORIZONTAL";
    pillRow.primaryAxisSizingMode = "AUTO"; pillRow.counterAxisSizingMode = "AUTO";
    pillRow.itemSpacing = 10;

    const pillLabels = [
      { key: "arabica_gayo", text: "Arabica Gayo" },
      { key: "gula_aren",    text: "Gula Aren" },
      { key: "bakeri_segar", text: "Bakeri Segar" },
    ];
    for (const { key, text } of pillLabels) {
      const pill = frame(`Pill: ${text}`, 1, 72);
      pill.clipsContent = true;
      pill.layoutMode = "VERTICAL";
      pill.primaryAxisSizingMode = "FIXED";
      pill.counterAxisSizingMode = "AUTO";
      pill.paddingLeft = 0; pill.paddingRight = 0;
      pill.paddingTop = 0; pill.paddingBottom = 0;
      pill.cornerRadius = 4;
      pill.resize(100, 72);

      // Foto kecil sebagai background pill
      if (typeof IMAGES !== "undefined" && IMAGES[key]) {
        pill.fills = await imageFill(IMAGES[key]);
      } else {
        pill.fills = solid(C.white, 0.15);
      }

      // Overlay gelap + label
      const overlay = rect("Overlay", 100, 72, C.black);
      overlay.opacity = 0.35;
      pill.appendChild(overlay);

      const pillLabel = frame("Pill Label", 1, 1);
      pillLabel.fills = [];
      pillLabel.layoutMode = "VERTICAL";
      pillLabel.primaryAxisSizingMode = "AUTO";
      pillLabel.counterAxisSizingMode = "AUTO";
      pillLabel.primaryAxisAlignItems = "MAX"; // bottom
      pillLabel.paddingLeft = 8; pillLabel.paddingRight = 8;
      pillLabel.paddingBottom = 8; pillLabel.paddingTop = 8;

      const pillTxt = await txt(text, 11, C.white, "body", "Light");
      pillTxt.letterSpacing = { value: 2, unit: "PERCENT" };
      pillLabel.appendChild(pillTxt);
      pill.appendChild(pillLabel);
      pillRow.appendChild(pill);
    }
    heroR.appendChild(pillRow);
    hero.appendChild(heroR);
    root.appendChild(hero);
  }

  // ────────────────────────────────────────────────────────
  // 3. STATS BAR
  // ────────────────────────────────────────────────────────
  {
    const statsBar = frame("Stats Bar", W, 100);
    statsBar.fills = solid(C.cream);
    statsBar.strokeAlign = "INSIDE";
    statsBar.strokes = solid(C.border);
    statsBar.strokeWeight = 1;
    statsBar.layoutMode = "HORIZONTAL";
    statsBar.primaryAxisSizingMode = "FIXED";
    statsBar.counterAxisSizingMode = "FIXED";

    const stats = [
      { num: "12+",    label: "PETANI MITRA" },
      { num: "38",     label: "PRODUK TERSEDIA" },
      { num: "2 Kota", label: "JANGKAUAN PENGIRIMAN" },
    ];

    for (let i = 0; i < stats.length; i++) {
      const s = stats[i];
      const statBox = frame(`Stat: ${s.label}`, W / 3, 100);
      statBox.layoutMode = "VERTICAL";
      statBox.primaryAxisSizingMode = "FIXED";
      statBox.counterAxisSizingMode = "FIXED";
      statBox.primaryAxisAlignItems = "CENTER";
      statBox.counterAxisAlignItems = "CENTER";
      statBox.itemSpacing = 6;
      if (i < 2) {
        statBox.strokes = solid(C.border);
        statBox.strokeWeight = 1;
        statBox.strokeAlign = "INSIDE";
      }

      const num = await txt(s.num, 44, C.green, "display", "Light");
      const lbl = await txt(s.label, 11, C.textLight, "body", "Light");
      lbl.letterSpacing = { value: 8, unit: "PERCENT" };
      statBox.appendChild(num);
      statBox.appendChild(lbl);
      statsBar.appendChild(statBox);
    }
    root.appendChild(statsBar);
  }

  // ────────────────────────────────────────────────────────
  // 4. PILIHAN UNGGULAN
  // ────────────────────────────────────────────────────────
  {
    const section = frame("Pilihan Unggulan", W, 1);
    section.fills = solid(C.cream);
    section.layoutMode = "VERTICAL";
    section.primaryAxisSizingMode = "AUTO";
    section.counterAxisSizingMode = "FIXED";
    section.paddingLeft = 56; section.paddingRight = 56;
    section.paddingTop = 64; section.paddingBottom = 64;
    section.itemSpacing = 32;

    // Section header
    const secHeader = frame("Section Header", W - 112, 40);
    secHeader.fills = [];
    secHeader.layoutMode = "HORIZONTAL";
    secHeader.primaryAxisSizingMode = "FIXED";
    secHeader.counterAxisSizingMode = "AUTO";
    secHeader.primaryAxisAlignItems = "SPACE_BETWEEN";
    secHeader.counterAxisAlignItems = "CENTER";

    const secTitle = await txt("Pilihan Unggulan", 36, C.brown, "display", "Light");
    const secLink = await txt("Lihat semua menu →", 12, C.green, "body", "Regular");
    secHeader.appendChild(secTitle);
    secHeader.appendChild(secLink);
    section.appendChild(secHeader);

    // Cards grid
    const cardsRow = frame("Featured Cards", W - 112, 1);
    cardsRow.fills = [];
    cardsRow.layoutMode = "HORIZONTAL";
    cardsRow.primaryAxisSizingMode = "FIXED";
    cardsRow.counterAxisSizingMode = "AUTO";
    cardsRow.itemSpacing = 24;

    const featured = [
      { imgKey: "kopi_susu_gula_aren", tag: "MENU KAFE",     name: "Kopi Susu Gula Aren",    price: "Rp 28.000" },
      { imgKey: "croissant_butter",    tag: "BAKERI",         name: "Croissant Butter",        price: "Rp 22.000" },
      { imgKey: "biji_kopi_arabica_gayo", tag: "PRODUK PETANI", name: "Biji Kopi Arabica Gayo", price: "Rp 85.000 / 250g" },
    ];

    for (const item of featured) {
      const card = frame(`Card: ${item.name}`, 1, 1);
      card.fills = solid(C.white);
      card.strokes = solid(C.border); card.strokeWeight = 1;
      card.layoutMode = "VERTICAL";
      card.primaryAxisSizingMode = "AUTO";
      card.counterAxisSizingMode = "FIXED";
      card.layoutGrow = 1;
      card.itemSpacing = 0;

      // Thumbnail foto
      const thumb = frame(`Thumb: ${item.name}`, 1, 180);
      thumb.layoutGrow = 1; thumb.clipsContent = true;
      if (typeof IMAGES !== "undefined" && IMAGES[item.imgKey]) {
        thumb.fills = await imageFill(IMAGES[item.imgKey]);
      } else {
        thumb.fills = solid(C.amberLight);
      }
      card.appendChild(thumb);

      // Body teks
      const body = frame(`Body: ${item.name}`, 1, 1);
      body.fills = []; body.layoutMode = "VERTICAL";
      body.primaryAxisSizingMode = "AUTO"; body.counterAxisSizingMode = "FIXED";
      body.layoutGrow = 1;
      body.paddingLeft = 18; body.paddingRight = 18;
      body.paddingTop = 18; body.paddingBottom = 18;
      body.itemSpacing = 6;

      const tagTxt = await txt(item.tag, 10, C.textLight, "body", "Light");
      tagTxt.letterSpacing = { value: 10, unit: "PERCENT" };
      const nameTxt = await txt(item.name, 18, C.brown, "display", "Regular");
      const priceTxt = await txt(item.price, 14, C.green, "body", "Medium");

      body.appendChild(tagTxt);
      body.appendChild(nameTxt);
      body.appendChild(priceTxt);
      card.appendChild(body);
      cardsRow.appendChild(card);
    }

    section.appendChild(cardsRow);
    root.appendChild(section);
  }

  // ────────────────────────────────────────────────────────
  // 5. TENTANG KAFETANI (green section)
  // ────────────────────────────────────────────────────────
  {
    const aboutSec = frame("Tentang Kafetani", W, 1);
    aboutSec.fills = solid(C.green);
    aboutSec.layoutMode = "HORIZONTAL";
    aboutSec.primaryAxisSizingMode = "FIXED";
    aboutSec.counterAxisSizingMode = "AUTO";
    aboutSec.paddingLeft = 56; aboutSec.paddingRight = 56;
    aboutSec.paddingTop = 56; aboutSec.paddingBottom = 56;
    aboutSec.itemSpacing = 48;
    aboutSec.counterAxisAlignItems = "CENTER";

    // Teks kiri
    const aboutL = frame("About Left", 1, 1);
    aboutL.fills = []; aboutL.layoutMode = "VERTICAL";
    aboutL.primaryAxisSizingMode = "AUTO"; aboutL.counterAxisSizingMode = "AUTO";
    aboutL.layoutGrow = 1; aboutL.itemSpacing = 16;

    const aLabel = await txt("TENTANG KAFETANI", 11, C.white, "body", "Light", 0.55);
    aLabel.letterSpacing = { value: 18, unit: "PERCENT" };

    const aTitle = await txt("Kafe yang terhubung\nlangsung ke kebun", 36, C.white, "display", "Light");
    aTitle.lineHeight = { value: 120, unit: "PERCENT" };

    const aDesc = await txt(
      "Setiap biji kopi dan butiran gula aren yang kamu nikmati berasal dari petani\nlokal yang sudah kami kenal namanya. Kafetani bukan sekadar kafe — ini\nadalah etalase langsung dari ladang ke cangkir.",
      14, C.white, "body", "Light", 0.7
    );
    aDesc.lineHeight = { value: 180, unit: "PERCENT" };

    aboutL.appendChild(aLabel);
    aboutL.appendChild(aTitle);
    aboutL.appendChild(aDesc);
    aboutSec.appendChild(aboutL);

    // Grid foto 2×2 (kanan)
    const featGrid = frame("Feature Grid", 1, 1);
    featGrid.fills = []; featGrid.layoutMode = "VERTICAL";
    featGrid.primaryAxisSizingMode = "AUTO"; featGrid.counterAxisSizingMode = "AUTO";
    featGrid.layoutGrow = 1; featGrid.itemSpacing = 16;

    const featureTiles = [
      { key: "about_bahan_segar",   icon: ICON_LEAF,   title: "Bahan Segar",  desc: "Langsung dari petani mitra tanpa rantai distribusi panjang" },
      { key: "about_petani_lokal",  icon: ICON_FARMER, title: "Petani Lokal", desc: "Mendukung penghasilan petani Indonesia secara langsung" },
      { key: "about_pesan_online",  icon: ICON_PHONE,  title: "Pesan Online", desc: "Order dari web, pickup atau dine-in sesuai preferensi" },
      { key: "about_bawa_pulang",   icon: ICON_HOME,   title: "Bawa Pulang",  desc: "Beli bahan baku segar untuk diolah sendiri di rumah" },
    ];

    const fRow1 = frame("Feature Row 1", 1, 1);
    fRow1.fills = []; fRow1.layoutMode = "HORIZONTAL";
    fRow1.primaryAxisSizingMode = "AUTO"; fRow1.counterAxisSizingMode = "AUTO";
    fRow1.itemSpacing = 16;

    const fRow2 = frame("Feature Row 2", 1, 1);
    fRow2.fills = []; fRow2.layoutMode = "HORIZONTAL";
    fRow2.primaryAxisSizingMode = "AUTO"; fRow2.counterAxisSizingMode = "AUTO";
    fRow2.itemSpacing = 16;

    for (let i = 0; i < featureTiles.length; i++) {
      const { key, icon, title, desc } = featureTiles[i];

      const tile = frame(`Feature: ${title}`, 280, 180);
      tile.clipsContent = true;
      tile.cornerRadius = 0;

      // Foto background
      if (typeof IMAGES !== "undefined" && IMAGES[key]) {
        tile.fills = await imageFill(IMAGES[key]);
      } else {
        tile.fills = solid(C.white, 0.08);
      }

      // Overlay gelap semi transparan
      const ov = rect("Overlay", 280, 180, C.black);
      ov.opacity = 0.5;
      tile.appendChild(ov);

      // Konten di atas overlay
      const tileContent = frame(`Content: ${title}`, 280, 1);
      tileContent.fills = [];
      tileContent.layoutMode = "VERTICAL";
      tileContent.primaryAxisSizingMode = "AUTO";
      tileContent.counterAxisSizingMode = "FIXED";
      tileContent.paddingLeft = 20; tileContent.paddingRight = 20;
      tileContent.paddingTop = 20; tileContent.paddingBottom = 20;
      tileContent.itemSpacing = 8;

      // Icon SVG
      const iconNode = svgIcon(icon, 22);
      tileContent.appendChild(iconNode);

      const titleT = await txt(title, 16, C.white, "display", "Regular");
      const descT = await txt(desc, 11, C.white, "body", "Light", 0.75);
      descT.lineHeight = { value: 160, unit: "PERCENT" };

      tileContent.appendChild(titleT);
      tileContent.appendChild(descT);
      tile.appendChild(tileContent);

      if (i < 2) fRow1.appendChild(tile);
      else        fRow2.appendChild(tile);
    }

    featGrid.appendChild(fRow1);
    featGrid.appendChild(fRow2);
    aboutSec.appendChild(featGrid);
    root.appendChild(aboutSec);
  }

  // ────────────────────────────────────────────────────────
  // 6. FOOTER
  // ────────────────────────────────────────────────────────
  {
    const footer = frame("Footer", W, 1);
    footer.fills = solid(C.brown);
    footer.layoutMode = "VERTICAL";
    footer.primaryAxisSizingMode = "AUTO";
    footer.counterAxisSizingMode = "FIXED";
    footer.paddingLeft = 56; footer.paddingRight = 56;
    footer.paddingTop = 56; footer.paddingBottom = 40;
    footer.itemSpacing = 48;

    // Top row
    const footerTop = frame("Footer Top", W - 112, 220);
    footerTop.fills = [];
    footerTop.layoutMode = "HORIZONTAL";
    footerTop.primaryAxisSizingMode = "FIXED";
    footerTop.counterAxisSizingMode = "AUTO";
    footerTop.itemSpacing = 0;
    footerTop.primaryAxisAlignItems = "SPACE_BETWEEN";

    // Brand kolom
    const brand = frame("Brand", 260, 1);
    brand.fills = []; brand.layoutMode = "VERTICAL";
    brand.primaryAxisSizingMode = "AUTO"; brand.counterAxisSizingMode = "FIXED";
    brand.itemSpacing = 16;

    const footerLogoNode = figma.createNodeFromSvg(LOGO_FOOTER_SVG);
    footerLogoNode.name = "Logo Footer";
    footerLogoNode.rescale(44 / 140);

    const footerDesc = await txt(
      "Kafetani menjembatani kesenjangan ladang ke meja kamu.\nKualitas terbaik bagi pelanggan kopi.",
      12, C.white, "body", "Light", 0.55
    );
    footerDesc.lineHeight = { value: 170, unit: "PERCENT" };

    brand.appendChild(footerLogoNode);
    brand.appendChild(footerDesc);
    footerTop.appendChild(brand);

    // Nav columns
    const cols = [
      { title: "Navigasi",     items: ["Beranda", "Menu Kafe", "Marketplace", "Admin Panel"] },
      { title: "Bantuan",      items: ["Cara Pesan", "Tentang Kami", "Syarat & Ketentuan", "Kebijakan Privasi"] },
      { title: "Hubungi Kami", items: ["Jl. Ladang Hijau No. 10, Bandung", "+62 812 3456 7890", "halo@kafetani.com"] },
    ];

    for (const col of cols) {
      const colFrame = frame(`Col: ${col.title}`, 180, 1);
      colFrame.fills = []; colFrame.layoutMode = "VERTICAL";
      colFrame.primaryAxisSizingMode = "AUTO"; colFrame.counterAxisSizingMode = "FIXED";
      colFrame.itemSpacing = 12;

      const colTitle = await txt(col.title, 13, C.white, "body", "Medium");
      colFrame.appendChild(colTitle);

      const divGap = frame("gap", 1, 4); divGap.fills = [];
      colFrame.appendChild(divGap);

      for (const item of col.items) {
        const it = await txt(item, 12, C.white, "body", "Light", 0.55);
        colFrame.appendChild(it);
      }
      footerTop.appendChild(colFrame);
    }

    footer.appendChild(footerTop);

    // Divider
    const footDiv = rect("Footer Divider", W - 112, 1, C.white);
    footDiv.opacity = 0.12;
    footer.appendChild(footDiv);

    // Bottom bar
    const footerBottom = frame("Footer Bottom", W - 112, 30);
    footerBottom.fills = [];
    footerBottom.layoutMode = "HORIZONTAL";
    footerBottom.primaryAxisSizingMode = "FIXED";
    footerBottom.counterAxisSizingMode = "FIXED";
    footerBottom.primaryAxisAlignItems = "SPACE_BETWEEN";
    footerBottom.counterAxisAlignItems = "CENTER";

    const copy  = await txt("© 2026 Kafetani. Semua Hak Dilindungi.", 11, C.white, "body", "Light", 0.4);
    const madeBy = await txt("Dibuat dengan ♥ untuk Petani Indonesia", 11, C.white, "body", "Light", 0.4);
    footerBottom.appendChild(copy);
    footerBottom.appendChild(madeBy);
    footer.appendChild(footerBottom);
    root.appendChild(footer);
  }

  // ────────────────────────────────────────────────────────
  // SELESAI
  // ────────────────────────────────────────────────────────
  figma.currentPage.appendChild(root);
  figma.viewport.scrollAndZoomIntoView([root]);
  figma.notify("✅ Kafetani Homepage berhasil dibuat!", { timeout: 3000 });
}

buildKafetani().catch(err => {
  figma.notify("❌ Error: " + err.message, { error: true });
  console.error(err);
});
