
  <title>Menu — Resto Admin</title>

  <style>

    .hero {
      background: linear-gradient(rgba(122, 94, 75, 0.85), rgba(122, 94, 75, 0.85)), url('https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?auto=format&fit=crop&w=1200') center/cover no-repeat;
      height: 60vh;
      display: flex;
      align-items: center;
      justify-content: center;
      text-align: center;
      color: white;
      padding: 0 20px;
    }
    .hero h1 {
      font-family: 'Playfair Display', serif;
      font-size: 3.5rem;
      font-weight: 700;
      margin-bottom: 20px;
      text-shadow: 0 2px 4px rgba(0,0,0,0.3);
    }

  

    /* Section Title */
    .section-title {
      font-family: 'Playfair Display', serif;
      font-size: 2.2rem;
      text-align: center;
      margin: 0 0 30px;
      position: relative;
      color: var(--brown);
    }

    .section-title::after {
      content: '';
      position: absolute;
      bottom: -12px;
      left: 50%;
      transform: translateX(-50%);
      width: 70px;
      height: 3px;
      background: var(--warm-beige);
    }

  </style>
</head>
<body>

<!-- Hero Section -->
<section class="hero">
  <div class="hero-content">
    <h1>Our Menu</h1>
  </div>
</section>

<div class="main-container">
  <!-- Action Bar: Search + Add Button -->
  <div class="action-bar">
    <div class="search-form">
      <div class="search-input-wrapper">
        <i class="bi bi-search search-icon"></i>
        <form action="/menu" method="GET" style="display: contents;">
          <input type="text" name="search" class="search-input" 
                 placeholder="Search menu..." 
                 value="<?= htmlspecialchars(request('search') ?? '') ?>">
        </form>
      </div>
      <button type="submit" class="search-btn">Search</button>
    </div>

    <div>
      <?php if (session('roleid') == 1) { ?>
        <a href="/insertmenu" class="btn-admin-add">
          <i class="bi bi-plus-circle"></i> Add New Menu
        </a>
      <?php } ?>
      <a href="/menu" class="reset-link">Reset</a>
    </div>
  </div>

  <!-- Menu Grid -->
  <div class="menu-grid">
    <?php foreach ($data as $key) { ?>
      <div class="menu-card">
        <div class="menu-img-wrapper">
          <img src="<?= asset('storage/' . $key->picture) ?>" class="menu-img" alt="<?= htmlspecialchars($key->menuname) ?>">
        </div>
        <div class="menu-body">
          <h3 class="menu-title"><?= htmlspecialchars($key->menuname) ?></h3>
          <p class="menu-desc"><?= htmlspecialchars($key->detail) ?></p>
          <div class="menu-price">Rp <?= number_format($key->price, 0, ',', '.') ?></div>

          <?php if (session('levelid') == 2) { ?>
            <form action="/addcart" method="post">
              @csrf
              <input type="hidden" name="menuid" value="<?= $key->menuid ?>">
              <input type="hidden" name="menuname" value="<?= htmlspecialchars($key->menuname) ?>">
              <input type="hidden" name="price" value="<?= $key->price ?>">
              <button type="submit" class="btn-add-cart">
                <i class="bi bi-cart-plus"></i> Add to Cart
              </button>
            </form>
          <?php } ?>

          <?php if (session('roleid') == 1) { ?>
            <div class="admin-actions">
              <a href="/editmenu/<?= $key->menuid ?>" class="btn-edit">
                <i class="bi bi-pencil-square"></i> Edit
              </a>
              <a href="/deletemenu/<?= $key->menuid ?>" class="btn-delete">
                <i class="bi bi-trash"></i> Delete
              </a>
            </div>
          <?php } ?>
        </div>
      </div>
    <?php } ?>
  </div>

  <!-- Pagination -->
  <?php if (isset($data) && $data->hasPages()) { ?>
    <ul class="soft-pagination">
      <?php if ($data->onFirstPage()) { ?>
        <li class="page-item disabled">
          <a class="page-link" href="#" aria-label="Previous">
            <i class="bi bi-chevron-left"></i> Previous
          </a>
        </li>
      <?php } else { ?>
        <li class="page-item">
          <a class="page-link" href="<?= $data->previousPageUrl() ?>" aria-label="Previous">
            <i class="bi bi-chevron-left"></i> Previous
          </a>
        </li>
      <?php } ?>

      <?php foreach ($data->getUrlRange(1, $data->lastPage()) as $page => $url) { ?>
        <li class="page-item <?= $data->currentPage() == $page ? 'active' : '' ?>">
          <a class="page-link" href="<?= $url ?>"><?= $page ?></a>
        </li>
      <?php } ?>

      <?php if ($data->hasMorePages()) { ?>
        <li class="page-item">
          <a class="page-link" href="<?= $data->nextPageUrl() ?>" aria-label="Next">
            Next <i class="bi bi-chevron-right"></i>
          </a>
        </li>
      <?php } else { ?>
        <li class="page-item disabled">
          <a class="page-link" href="#" aria-label="Next">
            Next <i class="bi bi-chevron-right"></i>
          </a>
        </li>
      <?php } ?>
    </ul>
  <?php } ?>


</div>
