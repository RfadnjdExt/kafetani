<?php
session_start();
include 'includes/header.php';
include 'includes/navbar.php';
?>

<div class="page" id="page-about">
  <div class="page-header" style="background:var(--green)">
    <div class="page-header-label">Kafetani · Cerita Kami</div>
    <h1 class="page-header-title">Tentang Kami</h1>
    <p class="page-header-sub">Menghubungkan lumbung desa dengan cangkir di kota</p>
  </div>

  <div style="max-width:800px; margin:4rem auto; padding:0 1.5rem;">
    <section style="margin-bottom:4rem;">
      <h2 style="font-family:var(--ff-display); font-size:2.3rem; color:var(--brown); margin-bottom:1.5rem; line-height:1.2;">Misi Kami: Keadilan di Setiap Tegukan</h2>
      <div style="line-height:1.8; color:var(--text-mid); font-size:1.05rem;">
        <p>Kafetani lahir dari sebuah kegelisahan sederhana: mengapa hasil tani yang luar biasa dari pelosok Indonesia seringkali dihargai rendah, sementara penikmat di kota membayar harga yang mahal?</p>
        <p style="margin-top:1.2rem;">Kami hadir untuk memotong rantai distribusi yang panjang dan tidak efisien. Di Kafetani, kami tidak hanya menjual kopi dan pangan; kami membangun jembatan digital yang menghubungkan lumbung petani mitra kami langsung ke meja Anda.</p>
      </div>
    </section>

    <div style="display:grid; grid-template-columns:1fr 1fr; gap:2rem; margin-bottom:4rem;">
      <div style="background:var(--cream); padding:2rem;">
        <h3 style="font-family:var(--ff-display); font-size:1.5rem; color:var(--green); margin-bottom:1rem;">Farm to Table</h3>
        <p style="font-size:0.9rem; line-height:1.6; color:var(--text-mid);">Setiap bahan baku yang kami gunakan di kafe maupun yang tersedia di marketplace dipastikan kesegarannya karena dikirim langsung dari petani mitra.</p>
      </div>
      <div style="background:var(--cream); padding:2rem;">
        <h3 style="font-family:var(--ff-display); font-size:1.5rem; color:var(--green); margin-bottom:1rem;">Pemberdayaan</h3>
        <p style="font-size:0.9rem; line-height:1.6; color:var(--text-mid);">Kami memberikan pendampingan dan harga beli yang jauh lebih adil kepada petani, membantu mereka meningkatkan taraf hidup dan kualitas hasil tanam.</p>
      </div>
    </div>

    <section style="margin-bottom:4rem;">
      <h2 style="font-family:var(--ff-display); font-size:2rem; color:var(--brown); margin-bottom:1.5rem;">Mengapa Kafetani?</h2>
      <div style="line-height:1.8; color:var(--text-mid);">
        <p>Nama <strong>Kafetani</strong> adalah gabungan dari <em>Kafe</em> dan <em>Petani</em>. Kami percaya bahwa kualitas rasa yang Anda nikmati di setiap cangkir kopi kami adalah buah dari kerja keras dan dedikasi para petani kami. Dengan memilih Kafetani, Anda telah menjadi bagian dari pergerakan ekonomi mikro yang mendukung ketahanan pangan lokal Indonesia.</p>
      </div>
    </section>

    <div style="text-align:center; padding:4rem 0; border-top:1px solid var(--border);">
      <h3 style="font-family:var(--ff-display); font-size:1.8rem; color:var(--brown); margin-bottom:1rem;">Mari Menjadi Bagian dari Cerita Kami</h3>
      <a href="marketplace.php" class="btn-primary" style="text-decoration:none; display:inline-block; margin-top:1rem;">Kunjungi Marketplace Petani</a>
    </div>
  </div>
</div>

<?php include 'includes/footer.php'; ?>
