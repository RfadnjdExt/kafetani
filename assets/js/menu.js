// File: menu.js — hanya mengurus filter tab kategori.
// Logik keranjang ditangani oleh assets/js/app.js

document.addEventListener("DOMContentLoaded", function () {
  const tabs  = document.querySelectorAll(".tabs button");
  const items = document.querySelectorAll(".menu-items .item-card");

  // Filter item berdasarkan tab kategori yang diklik
  tabs.forEach(tab => {
    tab.addEventListener("click", function () {
      tabs.forEach(t => t.classList.remove("active"));
      this.classList.add("active");

      const category = this.textContent.trim();

      items.forEach(item => {
        if (category === "Semua") {
          item.style.display = "block";
        } else {
          item.style.display = item.classList.contains(category) ? "block" : "none";
        }
      });
    });
  });
});
