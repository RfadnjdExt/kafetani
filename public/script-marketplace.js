// Halaman Marketplace Publik - resources/views/public/marketplace.blade.php
document.addEventListener('DOMContentLoaded', function () {
  const farmerCards = document.querySelectorAll('.farmer-card');
  const prodCards   = document.querySelectorAll('.product-card[data-farmer-id]');

  farmerCards.forEach(fc => {
    fc.addEventListener('click', function () {
      farmerCards.forEach(f => f.classList.remove('active'));
      this.classList.add('active');
      const target = this.dataset.farmer;
      prodCards.forEach(card => {
        card.style.display = (target === 'all' || card.dataset.farmerId === target)
          ? '' : 'none';
      });
    });
  });
});
