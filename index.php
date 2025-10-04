<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Printopia - Web Percetakan</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
  <link href="styl.css" rel="stylesheet">
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-gradient-pink fixed-top">
  <div class="container">
    <a class="navbar-brand fw-bold" href="#"><i class="bi bi-printer"></i> Printopia</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="#produk">Produk</a></li>
        <li class="nav-item"><a class="nav-link" href="#kontak">Kontak</a></li>
        <li class="nav-item"><a class="nav-link" href="#" id="open-cart"><i class="bi bi-cart"></i> Keranjang (<span id="cart-count">0</span>)</a></li>
      </ul>
    </div>
  </div>
</nav>

<!-- Hero -->
<header class="bg-light text-center py-5 mt-5">
  <div class="container">
    <h1 class="fw-bold text-pink">Selamat Datang di Printopia</h1>
    <p class="lead">Solusi percetakan cepat, murah, dan berkualitas.</p>
    <a href="#produk" class="btn btn-pink btn-lg"><i class="bi bi-bag"></i> Pesan Sekarang</a>
  </div>
</header>

<!-- Banner -->
<section class="container my-4">
  <div class="banner rounded shadow overflow-hidden">
    <img src="banner.jpg" alt="Promo Printopia" class="w-100 d-block">
  </div>
</section>

<!-- Produk -->
<section id="produk" class="py-5 bg-light">
  <div class="container">
    <h2 class="fw-bold text-pink text-center mb-4"><i class="bi bi-grid"></i> Katalog Produk Cetak</h2>
    <div class="row" id="product-list"></div>
  </div>
</section>

<!-- Kontak -->
<section id="kontak" class="py-5">
  <div class="container text-center">
    <h2 class="fw-bold text-pink mb-3"><i class="bi bi-telephone"></i> Kontak Kami</h2>
    <p>Email: info@printopia.com | Telp: 0812-3456-7890</p>
  </div>
</section>

<!-- Footer -->
<footer class="bg-gradient-pink text-white text-center py-3">
  <small>&copy; 2025 Printopia. All rights reserved.</small>
</footer>

<!-- Modal Produk -->
<div class="modal fade" id="productModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header"><h5 class="modal-title">Pesan Produk</h5></div>
      <div class="modal-body">
        <img id="modal-img" class="w-100 mb-3 rounded" alt="">
        <h5 id="modal-title"></h5>
        <p id="modal-desc"></p>
        <div class="mb-3">
          <label class="form-label">Jumlah</label>
          <input type="number" id="modal-qty" value="1" min="1" class="form-control">
        </div>
        <p><strong>Harga: <span id="modal-price"></span></strong></p>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button class="btn btn-pink" id="add-to-cart"><i class="bi bi-cart-plus"></i> Tambah ke Keranjang</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Keranjang -->
<div class="modal fade" id="cartModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header"><h5 class="modal-title"><i class="bi bi-cart"></i> Keranjang Belanja</h5></div>
      <div class="modal-body" id="cart-items"></div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
        <button class="btn btn-pink" id="checkout-btn"><i class="bi bi-credit-card"></i> Checkout</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Checkout -->
<div class="modal fade" id="checkoutModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header"><h5 class="modal-title">Checkout & Pembayaran</h5></div>
      <div class="modal-body">
        <form id="checkout-form">
          <div class="mb-3">
            <label class="form-label">Nama</label>
            <input type="text" id="nama" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Alamat</label>
            <textarea id="alamat" class="form-control" required></textarea>
          </div>
          <div class="mb-3">
            <label class="form-label">No. WhatsApp</label>
            <input type="text" id="whatsapp" class="form-control" required>
          </div>
        </form>
        <hr>
        <p class="text-center">Scan QRIS untuk pembayaran:</p>
        <div class="text-center">
          <img src="https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=Printopia%20Payment" class="img-fluid mb-3">
        </div>
        <div id="payment-status" class="text-center">Menunggu pembayaran...</div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-pink" id="confirm-payment"><i class="bi bi-check-circle"></i> Konfirmasi Pembayaran</button>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
const PRODUCTS = [
  {id:1,title:"Cetak Amplop caustom",desc:"Cetak Amplop caustom",price:30000,img:"produk5.jpeg"},
  {id:2,title:"Cetak Stiker foto + nama custom",desc:"Cetak Stiker foto + nama custom",price:7000,img:"produk3.jpeg"},
  {id:3,title:"Cetak stiket custom nama hologram",desc:"stiket custom nama hologram.",price:7000,img:"produk1.jpeg"},
  {id:4,title:"Cetak foto polaroid",desc:"Cetak foto polaroid",price:1500,img:"produk2.jpeg"},
  {id:5,title:"gantungan kunci akrilik",desc:"gantungan kunci akrilik",price:5000,img:"produk6.jpeg"},
  {id:6,title:"jasa/print, print online ",desc:"jasa/print, print online (per lembar)",price:1000,img:"produk4.jpeg"}
];
const CART_KEY = 'cart-printopia';
let cart = JSON.parse(localStorage.getItem(CART_KEY)) || [];
const rupiah = n => "Rp " + n.toLocaleString("id-ID");

const productListEl = document.getElementById('product-list');
PRODUCTS.forEach(p=>{
  const col = document.createElement('div');
  col.className = 'col-md-3 mb-4';
  col.innerHTML = `
    <div class="card h-100 shadow">
      <img src="${p.img}" class="card-img-top" alt="${p.title}">
      <div class="card-body d-flex flex-column">
        <h6 class="card-title">${p.title}</h6>
        <p class="card-text small">${p.desc}</p>
        <div class="mt-auto d-flex justify-content-between align-items-center">
          <strong>${rupiah(p.price)}</strong>
          <button class="btn btn-sm btn-pink btn-order" data-id="${p.id}">
            <i class="bi bi-bag-plus"></i> Pesan
          </button>
        </div>
      </div>
    </div>`;
  productListEl.appendChild(col);
});

productListEl.addEventListener('click', e=>{
  if(e.target.closest('.btn-order')){
    const id = e.target.closest('.btn-order').dataset.id;
    openProductModal(id);
  }
});

const modal = new bootstrap.Modal('#productModal');
let selectedProduct = null;

function openProductModal(id){
  selectedProduct = PRODUCTS.find(p=>p.id==id);
  document.getElementById('modal-img').src = selectedProduct.img;
  document.getElementById('modal-title').textContent = selectedProduct.title;
  document.getElementById('modal-desc').textContent = selectedProduct.desc;
  document.getElementById('modal-price').textContent = rupiah(selectedProduct.price);
  document.getElementById('modal-qty').value = 1;
  modal.show();
}

document.getElementById('add-to-cart').addEventListener('click', ()=>{
  const qty = parseInt(document.getElementById('modal-qty').value);
  const item = {...selectedProduct, qty: qty};
  cart.push(item);
  localStorage.setItem(CART_KEY, JSON.stringify(cart));
  updateCartCount();
  modal.hide();
});

function updateCartCount(){ document.getElementById('cart-count').textContent = cart.length; }
updateCartCount();

document.getElementById('open-cart').addEventListener('click', ()=>{
  renderCartItems();
  new bootstrap.Modal('#cartModal').show();
});

function renderCartItems(){
  const container = document.getElementById('cart-items');
  if(cart.length===0){
    container.innerHTML = "<p class='text-center'>Keranjang kosong.</p>";
    return;
  }
  let html = `<table class="table"><thead><tr><th>Produk</th><th>Qty</th><th>Harga</th><th>Total</th></tr></thead><tbody>`;
  let total = 0;
  cart.forEach((it)=>{
    const subtotal = it.price * it.qty;
    total += subtotal;
    html += `<tr><td>${it.title}</td><td>${it.qty}</td><td>${rupiah(it.price)}</td><td>${rupiah(subtotal)}</td></tr>`;
  });
  html += `</tbody></table><h5>Total: ${rupiah(total)}</h5>`;
  container.innerHTML = html;
}

document.getElementById('checkout-btn').addEventListener('click', ()=>{
  new bootstrap.Modal('#checkoutModal').show();
});

document.getElementById('confirm-payment').addEventListener('click', ()=>{
  const nama = document.getElementById('nama').value.trim();
  const alamat = document.getElementById('alamat').value.trim();
  const wa = document.getElementById('whatsapp').value.trim();
  if(!nama || !alamat || !wa){ alert("Isi semua data checkout!"); return; }

  document.getElementById('payment-status').innerHTML =
    '<span class="text-success"><i class="bi bi-check-circle"></i> Pembayaran terkonfirmasi!</span>';

  // buat pesan WhatsApp
  let pesan = `Halo Admin, saya ${nama}\nAlamat: ${alamat}\nNo. WA: ${wa}\n\nPesanan:\n`;
  let total = 0;
  cart.forEach(it=>{
    const subtotal = it.price * it.qty;
    total += subtotal;
    pesan += `- ${it.title} x${it.qty} = ${rupiah(subtotal)}\n`;
  });
  pesan += `\nTotal: ${rupiah(total)}`;

  const url = "https://wa.me/6281936211376?text=" + encodeURIComponent(pesan);
  setTimeout(()=>{ window.open(url,"_blank"); },1500);

  cart = [];
  localStorage.removeItem(CART_KEY);
  updateCartCount();
});
</script>
</body>
</html>
