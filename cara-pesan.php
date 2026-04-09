<?php
session_start();
include 'includes/header.php';
include 'includes/navbar.php';
?>

<div class="page" id="page-how-to-order">
  <div class="page-header" style="background:var(--brown)">
    <div class="page-header-label">Kafetani · Bantuan</div>
    <h1 class="page-header-title">Cara Pesan</h1>
    <p class="page-header-sub">Panduan mudah berbelanja di Kafe dan Marketplace Petani kami</p>
  </div>

  <div style="max-width:800px; margin:4rem auto; padding:0 1.5rem;">
    <section style="margin-bottom:4rem;">
      <h2 style="font-family:var(--ff-display); font-size:2rem; color:var(--brown); margin-bottom:1.5rem;">1. Menu Kafe (Dine-in / Pickup)</h2>
      <div style="line-height:1.8; color:var(--text-mid);">
        <p>Nikmati sajian kopi dan panganan lokal kami dengan sistem pemesanan online yang praktis:</p>
        <ul style="padding-left:1.5rem; margin-top:1rem;">
          <li style="margin-bottom:.8rem;">Buka halaman <strong>Menu Kafe</strong> melalui navigasi atas.</li>
          <li style="margin-bottom:.8rem;">Pilih menu favoritmu dan tekan tombol <strong>+</strong> untuk memasukkan ke keranjang.</li>
          <li style="margin-bottom:.8rem;">Klik tombol <strong>Keranjang</strong> di kanan atas untuk meninjau pesananmu.</li>
          <li style="margin-bottom:.8rem;">Tekan <strong>Konfirmasi Pesanan</strong>. Pastikan kamu sudah login untuk memproses transaksi.</li>
          <li>Kunjungi kedai kami, tunjukkan bukti pesanan, dan pesananmu siap dinikmati!</li>
        </ul>
      </div>
    </section>

    <section style="margin-bottom:4rem;">
      <h2 style="font-family:var(--ff-display); font-size:2rem; color:var(--brown); margin-bottom:1.5rem;">2. Marketplace Petani</h2>
      <div style="line-height:1.8; color:var(--text-mid);">
        <p>Beli bahan baku segar langsung dari tangan petani mitra kami:</p>
        <ul style="padding-left:1.5rem; margin-top:1rem;">
          <li style="margin-bottom:.8rem;">Masuk ke halaman <strong>Marketplace</strong>.</li>
          <li style="margin-bottom:.8rem;">Gunakan filter di sidebar sebelah kiri jika kamu ingin mencari produk dari petani spesifik.</li>
          <li style="margin-bottom:.8rem;">Pilih produk petani (seperti Biji Kopi Gayo atau Gula Aren) dan tambahkan ke keranjang.</li>
          <li style="margin-bottom:.8rem;">Lakukan checkout seperti biasa. Tim kami akan memverifikasi ketersediaan stok dari petani terkait.</li>
          <li>Pesanan akan dikirimkan ke alamatmu atau tersedia untuk diambil di kedai Kafetani terdekat.</li>
        </ul>
      </div>
    </section>

    <div style="background:var(--cream); padding:2rem; border-left:4px solid var(--green); margin-top:4rem;">
      <p style="font-style:italic; margin:0; color:var(--brown);">"Setiap pesananmu membantu menyejahterakan petani lokal secara langsung tanpa melalui rantai distribusi yang panjang."</p>
    </div>
  </div>
</div>

<?php include 'includes/footer.php'; ?>
