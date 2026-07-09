// Halaman Form Petani (Tambah/Edit) — resources/views/admin/farmers/form.blade.php
function previewAvatar(input) {
  if (!input.files || !input.files[0]) return;
  const reader = new FileReader();
  reader.onload = e => {
    const img = document.getElementById('avatar-img');
    const fb  = document.getElementById('avatar-fallback');
    img.src = e.target.result;
    img.style.display = 'block';
    if (fb) fb.style.display = 'none';
  };
  reader.readAsDataURL(input.files[0]);
}
