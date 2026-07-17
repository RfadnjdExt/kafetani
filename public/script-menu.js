// Halaman Menu Kafe - resources/views/public/menu.blade.php
document.addEventListener('DOMContentLoaded', function () {
  const tabs  = document.querySelectorAll('.filter-tab');
  const cards = document.querySelectorAll('.product-card[data-cat]');

  tabs.forEach(tab => {
    tab.addEventListener('click', function () {
      tabs.forEach(t => t.classList.remove('active'));
      this.classList.add('active');
      const cat = this.dataset.cat;
      cards.forEach(card => {
        card.style.display = (cat === 'Semua' || card.dataset.cat === cat) ? '' : 'none';
      });
    });
  });
});
