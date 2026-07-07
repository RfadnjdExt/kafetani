# API untuk Aplikasi Android Kafetani

File ini mendokumentasikan endpoint di `routes/api.php` yang ditambahkan khusus
untuk aplikasi Android native. Tampilan web (Blade) & alur Midtrans yang sudah
ada tidak diubah — hanya ditambahkan lapisan token auth + endpoint pendukung
di atasnya.

## Autentikasi

Sanctum belum ter-install di project ini, jadi auth API dibuat manual: tabel
`api_tokens` menyimpan **hash** token, dikirim balik ke klien sebagai
plain-text sekali saat login/register. Sertakan di tiap request:

```
Authorization: Bearer <token>
```

## Endpoint

| Method | Endpoint                          | Auth           | Keterangan                          |
|--------|-----------------------------------|----------------|--------------------------------------|
| POST   | `/api/register`                   | -              | Daftar akun baru (role: user)        |
| POST   | `/api/login`                      | -              | Login, dapat token                   |
| POST   | `/api/logout`                     | token          | Hapus token device ini saja          |
| GET    | `/api/me`                         | token          | Data user yang sedang login          |
| GET    | `/api/menu`                       | -              | Daftar menu kafe + kategori          |
| GET    | `/api/marketplace`                | -              | Daftar produk tani + petani          |
| GET    | `/api/categories`                 | -              | Semua kategori                       |
| GET    | `/api/farmers`                    | -              | Semua data petani                    |
| GET    | `/api/products/{id}`              | -              | Detail 1 produk                      |
| POST   | `/api/orders`                     | token          | Checkout → buat order + **Snap token Midtrans** |
| GET    | `/api/orders`                     | token          | Riwayat pesanan milik user login     |
| GET    | `/api/orders/{id}`                | token          | Detail 1 pesanan (termasuk `payment_status`) |
| GET    | `/api/admin/dashboard`            | token + admin  | Statistik dashboard                  |
| GET/POST/DELETE | `/api/admin/products[/{id}]` | token + admin  | CRUD produk                    |
| GET/POST/DELETE | `/api/admin/farmers[/{id}]`  | token + admin  | CRUD petani                    |
| GET    | `/api/admin/orders`               | token + admin  | Semua pesanan (bisa filter status)   |
| POST   | `/api/admin/orders/{id}/status`   | token + admin  | Update status fulfillment pesanan    |
| GET    | `/api/kasir/products`             | token + admin/kasir | Produk kafe untuk POS           |
| POST   | `/api/kasir/orders`                | token + admin/kasir | Buat pesanan tunai (langsung `payment_status: paid`) |

## ⚠️ Tentang integrasi Midtrans & aplikasi Android

Project ini sudah punya integrasi **Midtrans Snap** di alur checkout online
(`POST /api/orders`): order dibuat dengan status `pending_payment`, lalu
backend minta `snap_token` ke Midtrans dan mengembalikannya ke klien.
Pembayaran baru dianggap selesai setelah Midtrans memanggil webhook
`POST /midtrans/notification` (`MidtransController`), yang baru saat itu
meng-update `payment_status`, `status`, `paid_at`, `transaction_id`.

**Status saat ini: API sudah mengembalikan `snap_token`, tapi app Android yang
sudah dibuat sebelumnya BELUM punya layar untuk memprosesnya.** Kalau checkout
dari app Android dipakai apa adanya sekarang, pesanan akan berhasil dibuat tapi
nyangkut selamanya di status `pending_payment` (karena tidak ada yang membuka
halaman pembayaran Midtrans-nya). Supaya checkout di app benar-benar berfungsi,
app Android perlu ditambah:
1. Setelah dapat `snap_token` dari response checkout, buka halaman pembayaran
   Midtrans — cara termudah: WebView ke
   `https://app.sandbox.midtrans.com/snap/v3/redirection/{snap_token}`
   (ganti ke domain production kalau `is_production` sudah `true`).
2. Setelah WebView selesai/ditutup, panggil `GET /api/orders/{id}` untuk cek
   `payment_status` terbaru (update-nya async lewat webhook, jadi mungkin
   perlu polling beberapa detik).

Ini belum dikerjakan di update kali ini (fokusnya baru nyamain backend +
struktur data) — bilang aja kalau mau lanjut ke bagian ini.

Pesanan dari **kasir** (`/api/kasir/orders`) sengaja TIDAK lewat Midtrans —
langsung `payment_status: paid`, `payment_type: cash`, karena itu transaksi
tunai di tempat.

## Catatan lain

- Field `petani` pada produk marketplace tetap teks bebas (bukan relasi ke
  tabel `farmers`), mengikuti data aslinya.
- URL gambar (`gambar_url`, `avatar_url`) dibuat dinamis dari host request
  yang masuk, otomatis benar di emulator/HP fisik/production tanpa setting
  tambahan.
