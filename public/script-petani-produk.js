// Halaman Petani - resources/views/petani/produk/index.blade.php
function openModal(data) {
  const modal = document.getElementById('product-modal');
  if (data) {
    document.getElementById('modal-title').textContent = 'Edit Produk';
    document.getElementById('f-id').value          = data.id;
    document.getElementById('f-nama').value        = data.nama_produk;
    document.getElementById('f-harga').value       = data.harga;
    document.getElementById('f-stok').value        = data.stok;
    document.getElementById('f-desc').value        = data.deskripsi ?? '';
    document.getElementById('f-cat').value         = data.category_id ?? '';
    document.getElementById('f-gambar-lama').value = data.gambar ?? '';
    const prev = document.getElementById('img-preview');
    if (data.gambar) {
      prev.src = '/products/' + data.gambar;
      prev.style.display = 'block';
    } else {
      prev.style.display = 'none';
    }
  } else {
    document.getElementById('modal-title').textContent = 'Daftarkan Produk';
    document.getElementById('f-id').value = '';
    document.querySelector('#product-modal form').reset();
    document.getElementById('img-preview').style.display = 'none';
  }
  modal.classList.add('open');
}
function closeModal() {
  document.getElementById('product-modal').classList.remove('open');
}
function previewImg(input) {
  if (!input.files[0]) return;
  const reader = new FileReader();
  reader.onload = e => {
    const img = document.getElementById('img-preview');
    img.src = e.target.result;
    img.style.display = 'block';
  };
  reader.readAsDataURL(input.files[0]);
}
// Tutup modal klik luar
document.getElementById('product-modal').addEventListener('click', function(e) {
  if (e.target === this) closeModal();
});
