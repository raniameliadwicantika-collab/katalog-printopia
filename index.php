<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Printopia - Dunia Cetak Tanpa Batas</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .bg-gradient-pink { background: linear-gradient(135deg,#ff6ec4,#7873f5); }
    .text-pink { color:#ff6ec4; }
    .btn-pink { background:#ff6ec4; color:#fff; border:none; }
    .btn-pink:hover { background:#e055ad; }
    .product-img { height:160px; object-fit:cover; }
    .qris-box { max-width:320px; margin:0 auto; }
  </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-gradient-pink">
  <div class="container">
    <a class="navbar-brand fw-bold" href="#">Printopia</a>
    <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#nav">☰</button>
    <div class="collapse navbar-collapse" id="nav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="#produk">Produk</a></li>
        <li class="nav-item"><a class="nav-link" href="#kontak">Kontak</a></li>
        <li class="nav-item"><a class="nav-link" href="#" id="open-cart">Keranjang (<span id="cart-count">0</span>)</a></li>
      </ul>
    </div>
  </div>
</nav>

<!-- Produk -->
<section id="produk" class="py-5 bg-light">
  <div class="container">
    <h2 class="fw-bold text-pink text-center mb-4">Katalog Produk Cetak</h2>
    <div class="row" id="product-list">
      <!-- Produk akan dirender lewat JS -->
    </div>
  </div>
</section>

<!-- Modal: Product Quick Order -->
<div class="modal fade" id="productModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form id="quick-order-form">
      <div class="modal-header">
        <h5 class="modal-title" id="pm-title">Produk</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="row g-3">
          <div class="col-md-5">
            <img id="pm-img" src="" class="img-fluid product-img" alt="produk">
          </div>
          <div class="col-md-7">
            <p id="pm-desc"></p>
            <div class="mb-2">
              <label class="form-label">Ukuran</label>
              <select class="form-select" id="opt-size"></select>
            </div>
            <div class="mb-2">
              <label class="form-label">Bahan</label>
              <select class="form-select" id="opt-material"></select>
            </div>
            <div class="mb-2">
              <label class="form-label">Finishing</label>
              <select class="form-select" id="opt-finishing"></select>
            </div>
            <div class="mb-2">
              <label class="form-label">Jumlah</label>
              <input type="number" id="opt-qty" class="form-control" min="1" value="1">
            </div>

            <div class="mb-2">
              <label class="form-label">Upload Desain (PDF/PNG/JPG/PSD/AI)</label>
              <input type="file" id="opt-file" class="form-control" accept=".pdf,.png,.jpg,.jpeg,.psd,.ai">
              <div class="form-text">Opsional: upload file desain. Max 10MB.</div>
            </div>

            <hr>
            <h5>Estimasi Harga: <span id="price-est">Rp 0</span></h5>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-pink">Tambah ke Keranjang</button>
      </div>
      </form>
    </div>
  </div>
</div>

<!-- Keranjang & Checkout Modal -->
<div class="modal fade" id="cartModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Keranjang</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div id="cart-items"></div>
        <hr>
        <h5>Total: <span id="cart-total">Rp 0</span></h5>

        <div id="checkout-section" class="mt-3">
          <h6>Data Pengiriman & Pembayaran</h6>
          <form id="checkout-form">
            <div class="row g-2">
              <div class="col-md-6"><input class="form-control" id="cust-name" placeholder="Nama" required></div>
              <div class="col-md-6"><input class="form-control" id="cust-phone" placeholder="No. WhatsApp" required></div>
            </div>
            <div class="mt-2">
              <textarea class="form-control" id="cust-address" rows="2" placeholder="Alamat (opsional)"></textarea>
            </div>
            <div class="mt-3">
              <button type="submit" class="btn btn-pink w-100">Checkout & Bayar (QRIS)</button>
            </div>
          </form>
        </div>

        <div id="payment-section" class="d-none text-center">
          <h6>Scan QRIS untuk membayar</h6>
          <div class="qris-box my-3">
            <img id="qris-img" src="https://via.placeholder.com/300x300?text=QRIS+Placeholder" class="img-fluid" alt="qris">
          </div>
          <p id="payment-status">Menunggu pembayaran...</p>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

<!-- Footer -->
<footer class="bg-gradient-pink text-light text-center py-3">
  <div class="container">
    <small>&copy; 2025 Printopia</small>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<script>
/* ---------- Data produk (contoh) ---------- */
const PRODUCTS = [
  {
    id: 'brosur-a4',
    title: 'Brosur A4',
    desc: 'Brosur full-color A4, kertas art paper 150gsm.',
    img: 'https://via.placeholder.com/400x300?text=Brosur+A4',
    basePrice: 1500, // per pcs base for qty bracket (illustrative)
    options: {
      sizes: [{k:'A4', mul:1},{k:'A5', mul:0.7}],
      materials: [{k:'Art Paper 150gsm', mul:1},{k:'Art Paper 200gsm', mul:1.2}],
      finishings: [{k:'No finishing', mul:1},{k:'Gloss laminating', mul:1.3},{k:'Matte laminating', mul:1.3}]
    }
  },
  {
    id: 'kartu-nama',
    title: 'Kartu Nama (Gloss)',
    desc: 'Kartu nama 90x55mm, cetak dua sisi, bahan art cart 310gsm.',
    img: 'https://via.placeholder.com/400x300?text=Kartu+Nama',
    basePrice: 800,
    options: {
      sizes: [{k:'Standard', mul:1}],
      materials: [{k:'310gsm', mul:1}],
      finishings: [{k:'Rounded corner', mul:1.1},{k:'Spot UV', mul:1.2},{k:'No finishing', mul:1}]
    }
  },
  {
    id: 'undangan',
    title: 'Undangan Elegan',
    desc: 'Undangan A5, cetak full color, kertas ivory 260gsm.',
    img: 'https://via.placeholder.com/400x300?text=Undangan',
    basePrice: 3000,
    options: {
      sizes: [{k:'A5', mul:1}],
      materials: [{k:'Ivory 260gsm', mul:1}],
      finishings: [{k:'Emboss', mul:1.5},{k:'Gold foil', mul:1.7},{k:'No finishing', mul:1}]
    }
  },
  {
    id: 'merch-tshirt',
    title: 'T-Shirt Sablon',
    desc: 'Kaos cotton combed + sablon DTG/Screenprint.',
    img: 'https://via.placeholder.com/400x300?text=T-Shirt',
    basePrice: 50000,
    options: {
      sizes: [{k:'S', mul:1},{k:'M', mul:1},{k:'L', mul:1},{k:'XL', mul:1.1}],
      materials: [{k:'Cotton 24s', mul:1}],
      finishings: [{k:'Sablon 1 warna', mul:1},{k:'Full color', mul:1.4}]
    }
  }
];

/* ---------- Utilities ---------- */
const rupiah = (n) => {
  return 'Rp ' + n.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

/* ---------- Render product list ---------- */
const productListEl = document.getElementById('product-list');
PRODUCTS.forEach(p => {
  const col = document.createElement('div');
  col.className = 'col-md-3 mb-4';
  col.innerHTML = `
    <div class="card h-100 shadow">
      <img src="${p.img}" class="card-img-top product-img" alt="${p.title}">
      <div class="card-body d-flex flex-column">
        <h6 class="card-title">${p.title}</h6>
        <p class="card-text small">${p.desc}</p>
        <div class="mt-auto d-flex justify-content-between align-items-center">
          <strong>${rupiah(p.basePrice)}</strong>
          <button class="btn btn-sm btn-pink" data-id="${p.id}">Pesan</button>
        </div>
      </div>
    </div>`;
  productListEl.appendChild(col);
});

/* ---------- Quick order modal logic ---------- */
let selectedProduct = null;
const pm = new bootstrap.Modal(document.getElementById('productModal'));
document.querySelectorAll('[data-id]').forEach(btn => {
  btn.addEventListener('click', (e)=>{
    const id = e.currentTarget.dataset.id;
    openProductModal(id);
  });
});

function openProductModal(id){
  selectedProduct = PRODUCTS.find(x=>x.id===id);
  document.getElementById('pm-title').innerText = selectedProduct.title;
  document.getElementById('pm-img').src = selectedProduct.img;
  document.getElementById('pm-desc').innerText = selectedProduct.desc;

  // populate selects
  const sizeEl = document.getElementById('opt-size');
  const matEl = document.getElementById('opt-material');
  const finEl = document.getElementById('opt-finishing');
  sizeEl.innerHTML = ''; matEl.innerHTML=''; finEl.innerHTML='';

  selectedProduct.options.sizes.forEach(o => sizeEl.add(new Option(o.k,o.mul)));
  selectedProduct.options.materials.forEach(o => matEl.add(new Option(o.k,o.mul)));
  selectedProduct.options.finishings.forEach(o => finEl.add(new Option(o.k,o.mul)));

  document.getElementById('opt-qty').value = 1;
  calculatePrice();
  pm.show();
}

/* ---------- Price calculation ---------- */
function calculatePrice(){
  const qty = parseInt(document.getElementById('opt-qty').value) || 1;
  const sizeMul = parseFloat(document.getElementById('opt-size').value);
  const matMul = parseFloat(document.getElementById('opt-material').value);
  const finMul = parseFloat(document.getElementById('opt-finishing').value);
  // example price formula: basePrice * mults * qty * discount bracket
  let unit = Math.round(selectedProduct.basePrice * sizeMul * matMul * finMul);
  // discount: qty > 100 => 20% off, >50 => 10% off
  let discount = 1;
  if(qty > 100) discount = 0.8;
  else if(qty > 50) discount = 0.9;
  const total = Math.round(unit * qty * discount);
  document.getElementById('price-est').innerText = rupiah(total);
  return total;
}

['opt-size','opt-material','opt-finishing','opt-qty'].forEach(id=>{
  document.getElementById(id).addEventListener('change', calculatePrice);
});

/* ---------- Cart (localStorage) ---------- */
const CART_KEY = 'printopia_cart';
function getCart(){ return JSON.parse(localStorage.getItem(CART_KEY) || '[]'); }
function setCart(c){ localStorage.setItem(CART_KEY, JSON.stringify(c)); updateCartCount(); }
function updateCartCount(){ document.getElementById('cart-count').innerText = getCart().length; }

document.getElementById('quick-order-form').addEventListener('submit', (ev)=>{
  ev.preventDefault();
  const qty = parseInt(document.getElementById('opt-qty').value) || 1;
  const size = document.getElementById('opt-size').selectedOptions[0].text;
  const material = document.getElementById('opt-material').selectedOptions[0].text;
  const finishing = document.getElementById('opt-finishing').selectedOptions[0].text;
  const fileInput = document.getElementById('opt-file');
  const price = calculatePrice();

  const cart = getCart();
  cart.push({
    id: selectedProduct.id,
    title: selectedProduct.title,
    qty, size, material, finishing,
    price,
    img: selectedProduct.img,
    // Note: actual file upload must go to backend; here we only store filename if chosen
    filename: fileInput.files[0] ? fileInput.files[0].name : null
  });
  setCart(cart);
  pm.hide();
  alert('Produk ditambahkan ke keranjang');
});

/* ---------- Show cart modal ---------- */
const cm = new bootstrap.Modal(document.getElementById('cartModal'));
document.getElementById('open-cart').addEventListener('click',(e)=>{
  e.preventDefault();
  renderCartItems();
  cm.show();
});

function renderCartItems(){
  const itemsEl = document.getElementById('cart-items');
  const cart = getCart();
  if(cart.length===0){
    itemsEl.innerHTML = '<p class="text-center">Keranjang kosong.</p>';
    document.getElementById('checkout-section').classList.add('d-none');
    document.getElementById('payment-section').classList.add('d-none');
    document.getElementById('cart-total').innerText = rupiah(0);
    return;
  }
  document.getElementById('checkout-section').classList.remove('d-none');
  let html = '<div class="list-group">';
  let total=0;
  cart.forEach((it,idx)=>{
    html += `
      <div class="list-group-item d-flex align-items-center">
        <img src="${it.img}" style="width:80px;height:60px;object-fit:cover;margin-right:10px">
        <div class="flex-grow-1">
          <strong>${it.title}</strong><br>
          <small>${it.size} • ${it.material} • ${it.finishing}</small>
        </div>
        <div class="text-end">
          <div>${rupiah(it.price)}</div>
          <div class="small">x ${it.qty}</div>
          <button class="btn btn-sm btn-outline-danger mt-2" data-remove="${idx}">Hapus</button>
        </div>
      </div>`;
    total += it.price;
  });
  html += '</div>';
  itemsEl.innerHTML = html;
  document.getElementById('cart-total').innerText = rupiah(total);
  // attach remove handlers
  itemsEl.querySelectorAll('[data-remove]').forEach(b=>{
    b.addEventListener('click',()=>{
      const idx = parseInt(b.dataset.remove);
      const cart = getCart();
      cart.splice(idx,1);
      setCart(cart);
      renderCartItems();
    });
  });
}

/* ---------- Checkout (simulasi) ---------- */
document.getElementById('checkout-form').addEventListener('submit', async (ev)=>{
  ev.preventDefault();
  const name = document.getElementById('cust-name').value.trim();
  const phone = document.getElementById('cust-phone').value.trim();
  if(!name || !phone) return alert('Isi nama dan nomor WA.');

  // In real app: POST /api/orders -> backend create order, upload files, call Xendit/Midtrans to create QRIS and return image & payment_id
  // Here: kita mock behavior: generate random qris image url (placeholder) and simulate polling
  document.getElementById('checkout-section').classList.add('d-none');
  document.getElementById('payment-section').classList.remove('d-none');
  document.getElementById('qris-img').src = 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=PAY-'+Date.now();
  document.getElementById('payment-status').innerText = 'Menunggu pembayaran via QRIS...';

  // Simulate polling status (in real life, webhook akan update db and notify)
  let tries = 0;
  const poll = setInterval(()=>{
    tries++;
    if(tries>=6){ // after ~30s mark as paid for demo
      clearInterval(poll);
      document.getElementById('payment-status').innerText = 'Pembayaran terdeteksi. Pesanan diproses.';
      // clear cart
      setCart([]);
      updateCartCount();
    } else {
      document.getElementById('payment-status').innerText = 'Menunggu pembayaran... (' + tries + ')';
    }
  },5000);
});

/* ---------- init ---------- */
updateCartCount();

</script>
</body>
</html>
