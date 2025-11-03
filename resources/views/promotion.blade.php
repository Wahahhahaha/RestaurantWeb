
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
      <a href="/addpromotion" class="btn-admin-add">
        <i class="bi bi-plus-circle me-2"></i> Add Promotion
      </a>
    <?php } ?>
  </div>

  <div class="promo-grid">
    @foreach($promotions as $promo)
      <div class="promo-card">
        <h5>{{ $promo['promotionname'] }}</h5>

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
            <a href="/editpromotion/<?= $promo['promotionname'] ?>" class="btn-edit">Edit</a>
            <a href="/deletepromotion/<?= $promo['promotionname'] ?>" class="btn-delete">Delete</a>
          </div>
        <?php } ?>
      </div>
    @endforeach
  </div>
</div>

</body>
</html>