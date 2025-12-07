
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

  <section class="hero">
    <div class="hero-content">
      <h1>Our Menu</h1>
    </div>
  </section>

  <div class="main-container">
    <div class="action-bar">
      <div class="search-form">
        <div class="search-input-wrapper">
          <i class="bi bi-search search-icon"></i>

          <input type="text" id="menuSearch" 
          class="search-input" 
          placeholder="Search menu...">
        </div>

        <button id="btnSearch" class="search-btn">Search</button>
              <button id="btnReset" class="search-btn">Reset</button>

      </div>

      <div>
        <?php if (session('roleid') == 1) { ?>
          <button type="submit" class="btn-admin-add" onclick="openAddMenu()">
            <i class="bi bi-plus-circle"></i> Add New Menu
          </button>
        <?php } ?>
      </div>
    </div>

    <div class="menu-grid" id="menuGrid">
      <?php foreach ($data as $key) { ?>
       <div class="menu-card" id="menuCard_${res.data.menuid}">

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


            <?php if (session('roleid') == 1) { ?>
              <div class="admin-actions">
                <button type="button" class="btn-edit"
                onclick="openDetailMenu('<?= $key->menuid ?>', '<?= htmlspecialchars($key->menuname) ?>', '<?= $key->price ?>', '<?= htmlspecialchars($key->detail) ?>')">
                Detail
              </button>

            </div>
          <?php } ?>
        </div>
      </div>
    <?php } ?>
  </div>

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

<div class="modal fade" id="addMenu" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-lg mx-auto">
    <div class="modal-content" style="border-radius: 24px; background: white; padding: 20px; max-width: 500px; width: 90%; margin: 0 auto;">
      <div class="modal-header">
        <h5 class="modal-title" style="font-family:'Playfair Display', serif; font-size:22px; font-weight:700;">
          Add Menu
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">

        <form id="addMenuForm" action="/savemenu/0" method="POST" enctype="multipart/form-data">
          @csrf

          <div class="form-group ">
            <label class="form-label">Picture</label>
            <input type="file" name="pic" class="form-file-input" accept="image/*">
          </div>

          <div class="form-group">
            <label class="form-label">Menu Name</label>
            <input type="text" name="menuname" class="form-input" required>
          </div>

          <div class="form-group">
            <label class="form-label">Price</label>
            <input type="text" name="price" class="form-input" required>
          </div>

          <div class="form-group">
            <label class="form-label">Description</label>
            <input type="text" name="detail" class="form-input" required>
          </div>

          <button class="btn-edit-profile" type="submit">
            Save New Menu
          </button>
        </form>
      </div>
    </div>
  </div>
</div>

<div id="DetailMenu" class="modal fade">
  <div class="modal-dialog modal-dialog-centered modal-lg mx-auto">
    <div class="modal-content" style="border-radius: 24px; background: white; padding: 20px; max-width: 500px; width: 90%; margin: 0 auto;">
      <div class="modal-header">
       <h5 class="modal-title" style="font-family:'Playfair Display', serif; font-size:22px; font-weight:700;">
        Detail
      </h5>
      <button type="button" class="btn-close" data-bs-dismiss="modal" id="btnClose"></button>
    </div>

<div class="modal-body">
    <form id="editMenu" method="POST" enctype="multipart/form-data">
      @csrf
      <input type="hidden" name="menuid" id="modalMenuId">
      
      <div class="form-group">
        <label class="form-label">Picture</label>
        <input type="file" id="modalPic" name="pic" accept="image/*" class="form-file-input">
      </div>

      <div class="form-group">
        <label for="modalName" class="form-label" >Menu Name</label>
        <input type="text" id="modalName" name="menuname" required class="form-input">
      </div>

      <div class="form-group">  
        <label for="modalPrice" class="form-label">Price</label>
        <input type="number" id="modalPrice" name="price" required  class="form-input">
      </div>

      <div class="form-group">
        <label for="modalDetail" class="form-label">Description</label>
        <input type ="text" id="modalDetail" name="detail" required class="form-input">
      </div>

      <div class="admin-actions">
        <button type="button" id="btnEdit" class="btn-edit">Save</button>
        <button type="button" id="btnDelete" class="btn-delete">Delete</button>
      
    </form>
  </div>
</div>
</div>
</div>

<script>
    const USER_ROLE = <?= session('roleid') ?>;
    const USER_LEVEL = <?= session('levelid') ?>;
</script>

<script>
  closeAddMenu();
  closeDetailMenu();
  reload();
  updateCartUI();
</script>
@stack('scripts')


