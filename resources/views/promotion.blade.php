
<title>Promotion</title>

<style>

  body {
    font-family: 'Inter', sans-serif;
    background: var(--beige);
    color: var(--brown);
    line-height: 1.6;
  }

  /* Hero Section */
  .hero {
    background: linear-gradient(rgba(122, 94, 75, 0.75), rgba(122, 94, 75, 0.75)), 
    url('https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?auto=format&fit=crop&w=1600') center/cover no-repeat;
    height: 40vh;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    color: white;
    padding: 0 20px;
    position: relative;
    z-index: 1;
  }

  .hero h1 {
    font-family: 'Playfair Display', serif;
    font-size: 3rem;
    font-weight: 700;
    margin-bottom: 20px;
    text-shadow: 0 2px 6px rgba(0,0,0,0.4);
  }


  .page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 16px;
    margin-bottom: 32px;
  }

  .page-title {
    font-family: 'Playfair Display', serif;
    font-size: 28px;
    font-weight: 700;
    color: var(--warm-beige);
  }

  .btn-admin-add {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background: var(--warm-beige);
    color: var(--brown);
    font-weight: 600;
    font-size: 17px;
    padding: 14px 32px;
    border-radius: 50px;
    text-decoration: none;
    box-shadow: 0 6px 18px rgba(232, 213, 196, 0.35);
    transition: all 0.25s ease;
    border: none;
    font-family: 'Inter', sans-serif;
  }

  .btn-admin-add:hover {
    background: #d9bfa5;
    transform: translateY(-3px);
    box-shadow: 0 8px 24px rgba(232, 213, 196, 0.45);
  }

  .btn-add-cart,
  .btn-edit,
  .btn-delete {
    flex: 1;
    min-width: 120px;
    padding: 12px 16px;
    font-size: 15px;
    font-weight: 600;
    font-family: 'Inter', sans-serif;
    border: none;
    border-radius: 14px;
    cursor: pointer;
    text-align: center;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    transition: all 0.25s ease;
  }
  .modal-content {
    background: #fff;
    padding: 20px 25px;
    border-radius: 8px;
    width: 380px;
    max-width: 90%;
    box-shadow: 0 5px 20px rgba(0,0,0,0.3);
  }
  .modal-title {
    text-align: center;
    margin-bottom: 15px;
    font-weight: bold;
    color: #7A5E4B;
  }
</style>
</head>
<body>

  <!-- Hero Section -->
  <section class="hero">
    <div class="hero-content">
      <h1>Special Promotions</h1>
      <p>Enjoy curated combo deals with exclusive discounts for our loyal customers.</p>
    </div>
  </section>

  <div class="main-container">
    <div class="page-header">
      <h3 class="page-title">Today's Deals</h3>

      <?php if (session('levelid') == 1) { ?>
        <button class="btn-admin-add" onclick="openAddPromotion()">
          <i class="bi bi-plus-circle me-2"></i> Add Promotion
        </button>
      <?php } ?>

    </div>

    <div class="promo-grid" id="promoGrid">
      @foreach($promotions as $promo)
      <div class="promo-card"
     id="promoCard_{{ $promo['promotionid'] }}"
     data-promotionname="{{ $promo['promotionname'] }}">


        <h5 class="promo-title">{{ $promo['promotionname'] }}</h5>

        <ul class="menu-list">
          @foreach($promo['menus'] as $menu)
          <li class="menu-item">{{ $menu['name'] }} — Rp {{ number_format($menu['price'], 0, ',', '.') }}</li>
          @endforeach
        </ul>

        <div class="divider"></div>

        <div class="promo-total">
          <span>Total:</span>
          <span>Rp {{ number_format($promo['total'], 0, ',', '.') }}</span>
        </div>

        <?php if(session('levelid') == 2) { ?>
          <form action="/addcart" method="POST" class="promo-actions">
            @csrf
            <input type="hidden" name="menuid" value="{{ $promo['promotionid'] }}">
            <input type="hidden" name="menuname" value="{{ $promo['promotionname'] }}">
            <input type="hidden" name="promotionid" value="{{ $promo['promotionid'] }}">
            <input type="hidden" name="promotionname" value="{{ $promo['promotionname'] }}">
            <input type="hidden" name="price" value="{{ $promo['total'] }}">
            <button type="submit" class="btn-add-cart">Add to Cart</button>
          </form>
        <?php } ?>

        <?php if(session('levelid') == 1) { ?>
          <div class="promo-actions">
           <button
           class="btn-edit"
           onclick='openDetailPromotion(
            "<?= $promo['promotionid'] ?>",
            "<?= htmlspecialchars($promo['promotionname'], ENT_QUOTES) ?>",
            <?= json_encode($promo['prices'] ?? []) ?>)'>
            Detail
          </button>

        </div>
      <?php } ?>
    </div>
     @endforeach
   </div>
 </div>


 <!-- MODAL ADD PROMOTION -->
 <div id="AddPromotion" class="modal fade">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content" style="border-radius: 24px; background: white; padding: 20px; max-width: 800px; width: 90%; margin: 0 auto;">

      <div class="modal-header">
        <h5 class="modal-title" style="font-family:'Playfair Display', serif; font-size:22px; font-weight:700;">
        Add Promotion
      </h5>
      <button type="button" class="btn-close" data-bs-dismiss="modal" id="btnCloseAddPromo"></button>
    </div>

    <form id="addPromotionForm" action="/savepromotion" method="POST" class="was-validated">
      @csrf

      <div class="form-group">
        <div id="promotionGrid">
        <label class="form-label">Promotion Name</label>
        <input type="text" class="form-control" name="promotionname" required>
      </div>

      <div class="form-group">
        <label class="form-label">Menus & Prices</label>

        <div class="menu-card mt-2">

          <?php foreach ($ban as $key): ?>
            <div class="row">

              <div class="col" style="font-weight: 600;">
                <?= htmlspecialchars($key->menuname) ?>
              </div>

              <div class="col" style="width: 140px; color:#777;">
                Rp <?= number_format($key->price, 0, ',', '.') ?>
              </div>

              <div style="width: 150px;">
                <input type="number"
                name="prices[<?= $key->menuid ?>]"
                class="form-input"
                min="0"
                placeholder="Promo price">
              </div>

            </div>
          <?php endforeach; ?>

        </div>
      </div>

      <div class="modal-footer mt-3">
        <button type="submit" class="btn-edit">Save</button>
      </div>
    </div>
    </form>
  </div>
</div>
</div>

<!-- MODAL DETAIL PROMOTION -->
<div id="DetailPromotion" class="modal fade">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content" style="border-radius: 24px; background: white; padding: 20px; max-width: 800px; width: 90%; margin: 0 auto;">

      <div class="modal-header">
        <h5 class="modal-title"
        style="font-family:'Playfair Display', serif; font-size:22px; font-weight:700;">
        Detail Promotion
      </h5>
      <button type="button" class="btn-close" data-bs-dismiss="modal" id="btnClose"></button>
    </div>

    <form id="detailPromotionForm" method="POST" class="was-validated">
      @csrf

      <!-- Promotion Name -->
      <div class="form-group px-3 pt-3">
        <label class="form-label">Promotion Name</label>
        <input type="text" class="form-control" id="detailPromotionName" name="promotionname" required>
      </div>

      <!-- Menu List -->
      <div class="form-group px-3 mt-3">
        <label class="form-label">Menus & Prices</label>

        <div class="menu-card">

          <?php foreach ($ban as $key): ?>
            <div class="row">

              <div class="col" style="font-weight: 600;">
                <?= htmlspecialchars($key->menuname) ?>
              </div>

              <div class="col" style="width: 140px; color:#777;">
                Rp <?= number_format($key->price, 0, ',', '.') ?>
              </div>

              <div style="width: 150px;">
                <input style="width: 600px;" type="number"
                class="form-input"
                data-menuid="<?= $key->menuid ?>"
                name="prices[<?= $key->menuid ?>]"
                placeholder="Promo price">

              </div>

            </div>
          <?php endforeach; ?>

        </div>
      </div>

      <div class="modal-footer mt-3">
        <button type="submit" id="btnEditPromotion" class="btn-edit">Edit</button>
        <button type="button" id="btnDeletePromotion" class="btn-delete">Delete</button>
      </div>
    </form>

  </div>
</div>
</div>

<script>
    window.levelid = {{ session('levelid') }};
    window.csrf = "{{ csrf_token() }}";
</script>


<script>
  // closeDetailPromotion();
    updateCartUI();
  // reload();
</script>
@stack('scripts')
