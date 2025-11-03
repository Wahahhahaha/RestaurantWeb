
  <title><?= $baby == 'input' ? 'Add New Menu' : 'Edit Menu' ?></title>

  <style>

    body {
      font-family: 'Inter', sans-serif;
      background: var(--beige);
      color: var(--brown);
      line-height: 1.6;
      padding-top: 30px;
      padding-bottom: 60px;
    }

    .main-container {
      max-width: 720px;
      margin: 0 auto;
      padding: 0 20px;
    }

    /* Tombol Kembali */
    .btn-back {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      color: var(--brown);
      text-decoration: none;
      font-weight: 500;
      padding: 10px 20px;
      border-radius: 16px;
      background: var(--sand);
      transition: all 0.25s ease;
      width: fit-content;
      margin-bottom: 28px;
    }

    .btn-back:hover {
      background: var(--warm-beige);
      color: white;
      transform: translateX(-4px);
      box-shadow: 0 4px 10px rgba(232, 213, 196, 0.3);
    }

    /* Form Card */
    .menu-form-card {
      background: white;
      border-radius: 24px;
      padding: 48px;
      box-shadow: 0 12px 40px rgba(122, 94, 75, 0.12);
      position: relative;
      overflow: hidden;
    }

    .menu-form-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 5px;
      background: linear-gradient(90deg, var(--warm-beige), #d9bfa5);
    }

    .form-title {
      font-family: 'Playfair Display', serif;
      font-size: 26px;
      font-weight: 700;
      color: var(--brown);
      text-align: center;
      margin-bottom: 36px;
      letter-spacing: -0.3px;
    }

    .form-group {
      margin-bottom: 24px;
    }

    .form-label {
      display: block;
      font-size: 14px;
      font-weight: 600;
      color: var(--brown);
      margin-bottom: 10px;
    }

    .form-hint {
      font-size: 13px;
      color: var(--light-brown);
      margin-top: 6px;
    }

    /* Input & File */
    .form-input,
    .form-file-input {
      width: 100%;
      padding: 16px 20px;
      font-size: 16px;
      font-family: 'Inter', sans-serif;
      background: var(--sand);
      border: 1px solid #e9d7c7;
      border-radius: 16px;
      color: var(--brown);
      transition: all 0.25s ease;
    }

    .form-input:focus,
    .form-file-input:focus {
      outline: none;
      border-color: var(--warm-beige);
      background: white;
      box-shadow: 0 0 0 3px rgba(217, 191, 165, 0.25);
    }

    /* Preview Gambar */
    .image-preview {
      display: block;
      margin: 0 auto 16px;
      max-height: 220px;
      object-fit: cover;
      border-radius: 16px;
      border: 1px solid #e9d7c7;
      box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }

    .image-preview-label {
      text-align: center;
      font-size: 14px;
      color: var(--light-brown);
      margin-top: 8px;
    }

    /* Tombol Submit */
    .btn-submit {
      width: 100%;
      padding: 16px;
      font-size: 18px;
      font-weight: 600;
      font-family: 'Inter', sans-serif;
      color: var(--brown);
      background: var(--warm-beige);
      border: none;
      border-radius: 16px;
      cursor: pointer;
      transition: all 0.25s ease;
      box-shadow: 0 4px 14px rgba(232, 213, 196, 0.35);
      letter-spacing: 0.5px;
    }

    .btn-submit:hover {
      background: #d9bfa5;
      transform: translateY(-3px);
      box-shadow: 0 6px 20px rgba(232, 213, 196, 0.45);
    }

    @media (max-width: 576px) {
      .menu-form-card {
        padding: 36px 24px;
      }
      .form-title {
        font-size: 24px;
      }
    }
  </style>
</head>
<body>

<div class="main-container">
  <a href="/menu" class="btn-back">
    <i class="bi bi-arrow-left"></i> Back to Menu
  </a>

  <div class="menu-form-card">
    <h1 class="form-title">
      <?= $baby == 'input' ? 'Add New Menu' : 'Edit Menu' ?>
    </h1>

    <form action="/savemenu/<?= $baby == 'input' ? 0 : $menu->menuid ?>" method="post" enctype="multipart/form-data" class="was-validated">
      @csrf

      <!-- Preview Gambar (hanya saat edit) -->
      <?php if ($baby !== 'input' && !empty($menu->picture)): ?>
        <div class="form-group text-center">
          <img src="<?= asset('storage/'.$menu->picture) ?>" 
               alt="Menu Preview" 
               class="image-preview">
          <p class="image-preview-label">Current image</p>
        </div>
      <?php endif; ?>

      <!-- Input Gambar -->
      <div class="form-group">
        <label class="form-label">Picture</label>
        <input type="file" class="form-file-input" name="pic" accept="image/*">
        <div class="form-hint">Format: JPG, PNG (max 2MB)</div>
      </div>

      <!-- Nama Menu -->
      <div class="form-group">
        <label class="form-label">Menu Name</label>
        <input type="text" class="form-input" name="n" required
               value="<?= $baby == 'input' ? '' : htmlspecialchars($menu->menuname) ?>">
      </div>

      <!-- Harga -->
      <div class="form-group">
        <label class="form-label">Price</label>
        <input type="text" class="form-input" name="p" required
               value="<?= $baby == 'input' ? '' : htmlspecialchars($menu->price) ?>">
      </div>

      <!-- Detail -->
      <div class="form-group">
        <label class="form-label">Description</label>
        <input type="text" class="form-input" name="d" required
               value="<?= $baby == 'input' ? '' : htmlspecialchars($menu->detail) ?>">
      </div>

      <!-- Tombol Submit -->
      <div class="d-grid mt-4">
        <button type="submit" class="btn-submit">
          <?= $baby == 'input' ? 'Save New Menu' : 'Save Changes' ?>
        </button>
      </div>
    </form>
  </div>
</div>

</body>
</html>