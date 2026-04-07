<!-- ══ CART PANEL ══ -->
<div class="cart-overlay" id="cart-overlay" onclick="closeCart()"></div>
<div class="cart-panel" id="cart-panel">
  <div class="cart-top">
    <h2>Keranjang</h2>
    <button class="cart-close" onclick="closeCart()">✕</button>
  </div>
  <div class="cart-items" id="cart-items"></div>
  <div class="cart-bottom" id="cart-bottom" style="display:none">
    <div class="cart-row"><span>Subtotal</span><span id="cart-sub">Rp 0</span></div>
    <div class="cart-row"><span>Layanan</span><span>Rp 2.000</span></div>
    <div class="cart-total"><span>Total</span><span id="cart-total">Rp 0</span></div>
    <button class="checkout-btn" onclick="checkout()">Konfirmasi Pesanan →</button>
  </div>
</div>

<!-- SUCCESS MODAL -->
<div class="order-success" id="order-success">
  <div class="success-box">
    <div class="success-icon">✅</div>
    <h2 class="success-title">Pesanan Diterima!</h2>
    <p class="success-text">Pesananmu sedang diproses. Kamu bisa pickup atau tunggu konfirmasi dari barista kami. Terima kasih sudah pilih Kafetani! ☕</p>
    <button class="success-close" onclick="closeSuccess()">Kembali Belanja</button>
  </div>
</div>

<div class="toast" id="toast"></div>

<footer>
    <p>&copy; 2026 Kafetani. Semua Hak Dilindungi.</p>
</footer>

<script src="assets/js/app.js"></script>
</body>
</html>
