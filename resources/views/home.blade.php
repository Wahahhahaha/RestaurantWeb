<section class="hero">
  <div class="hero-content">
    <h1>Chick Chi</h1>
    <p>Fresh • Tasty • Homemade — crafted with love for your perfect meal.</p>
    <a href="#menu" class="btn-hero">Explore Our Menu</a>
  </div>
</section>

<section class="section" id="menu">
  <h2 class="section-title">Our Menu</h2>
  <div class="menu-grid">
    <?php foreach ($menu as $key) { ?>
      <div class="menu-card">
        <div class="menu-img-wrapper">
          <img src="<?= asset('storage/' . $key->picture) ?>" class="menu-img" alt="<?= htmlspecialchars($key->menuname) ?>">
        </div>
        <div class="menu-body">
          <h3 class="menu-title"><?= htmlspecialchars($key->menuname) ?></h3>
          <p class="menu-desc"><?= htmlspecialchars($key->detail) ?></p>
          <div class="menu-price">Rp <?= number_format($key->price, 0, ',', '.') ?></div>
          <?php if (session('levelid') == 2) { ?>
            <form class="addcart-form" action="/addcart" method="post">
              @csrf
              <input type="hidden" name="menuid" value="<?= $key->menuid ?>">
              <input type="hidden" name="menuname" value="<?= htmlspecialchars($key->menuname) ?>">
              <input type="hidden" name="price" value="<?= $key->price ?>">
              <button type="submit" class="btn-add-cart">
                <i class="bi bi-cart-plus me-1"></i> Add to Cart
              </button>
            </form>
          <?php } ?>
        </div>
      </div>
    <?php } ?>
  </div>
</section>

<section class="section">
  <div class="testimonials">
    <div class="testimonial">
      <p>"The best fried chicken I've ever tasted! Crispy outside, juicy inside. Highly recommended!"</p>
      <div class="client">— Sarah W., Regular Customer</div>
    </div>
  </div>
</section>

<script>
  //reload();
  updateCartUI();
</script>
@stack('scripts')

