// Halaman Admin Kasir POS — resources/views/admin/kasir.blade.php
let cart = [];
let activeCat = 'Semua';

function addItem(id, name, price, img) {
  const existing = cart.find(i => i.id === id);
  if (existing) { existing.qty++; }
  else { cart.push({ id, name, price, img, qty: 1 }); }
  renderOrder();
  // ripple
  event.currentTarget.insertAdjacentHTML('beforeend', '<div class="add-ripple"></div>');
  setTimeout(() => { event.currentTarget.querySelector('.add-ripple')?.remove(); }, 280);
}

function changeQty(id, delta) {
  const item = cart.find(i => i.id === id);
  if (!item) return;
  item.qty += delta;
  if (item.qty <= 0) cart = cart.filter(i => i.id !== id);
  renderOrder();
}

function removeItem(id) {
  cart = cart.filter(i => i.id !== id);
  renderOrder();
}

function clearOrder() {
  if (cart.length && !confirm('Kosongkan pesanan?')) return;
  cart = [];
  renderOrder();
}

function renderOrder() {
  const container = document.getElementById('order-items');
  const emptyEl   = document.getElementById('order-empty');
  const countEl   = document.getElementById('item-count');
  const subtotalEl = document.getElementById('subtotal-val');
  const totalEl   = document.getElementById('total-val');
  const placeBtn  = document.getElementById('place-btn');

  // Hapus item lama
  container.querySelectorAll('.order-item').forEach(el => el.remove());

  let subtotal = 0;
  cart.forEach(item => {
    subtotal += item.price * item.qty;
    const div = document.createElement('div');
    div.className = 'order-item';
    div.innerHTML = `
      <div class="order-item-name">
        ${item.name}
        <div class="order-item-price">Rp ${fmt(item.price)}</div>
      </div>
      <div class="order-qty">
        <button class="qty-btn" onclick="changeQty(${item.id}, -1)">−</button>
        <span class="qty-num">${item.qty}</span>
        <button class="qty-btn" onclick="changeQty(${item.id}, +1)">+</button>
        <button class="remove-item" onclick="removeItem(${item.id})" title="Hapus">✕</button>
      </div>`;
    container.appendChild(div);
  });

  const total = subtotal;
  const totalItems = cart.reduce((s, i) => s + i.qty, 0);

  emptyEl.style.display  = cart.length ? 'none' : 'block';
  countEl.textContent    = totalItems + ' item';
  subtotalEl.textContent = 'Rp ' + fmt(subtotal);
  totalEl.textContent    = 'Rp ' + fmt(total);
  placeBtn.disabled      = cart.length === 0;
}

function fmt(n) {
  return n.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
}

// Form submit
document.getElementById('kasir-form').addEventListener('submit', function(e) {
  document.getElementById('f-items').value         = JSON.stringify(cart.map(i => ({ id: i.id, qty: i.qty })));
  document.getElementById('f-order-type').value    = document.getElementById('order-type').value;
  document.getElementById('f-customer-name').value = document.getElementById('customer-name').value;
});

// Filter kategori
function setCat(btn) {
  activeCat = btn.dataset.cat;
  document.querySelectorAll('.menu-cat-btn').forEach(b => b.classList.remove('active'));
  btn.classList.add('active');
  filterMenu();
}

function filterMenu() {
  const q = document.getElementById('menu-search').value.toLowerCase();
  document.querySelectorAll('.menu-item:not(.no-stok)').forEach(el => {
    const matchCat  = activeCat === 'Semua' || el.dataset.cat === activeCat;
    const matchName = !q || el.dataset.name.includes(q);
    el.style.display = matchCat && matchName ? '' : 'none';
  });
}

function closeReceipt() {
  document.getElementById('receipt-modal').classList.remove('open');
  document.getElementById('receipt-modal').style.display = 'none';
}

renderOrder();
