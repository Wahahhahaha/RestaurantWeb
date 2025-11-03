<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= $baby == 'input' ? 'Add Promotion' : 'Edit Promotion' ?></title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Inter:wght@300;400;500;600&display=swap');

    :root {
      --beige: #fdf9f5;
      --warm-beige: #e8d5c4;
      --brown: #7a5e4b;
      --light-brown: #9c8a7d;
      --sand: #f8f4f0;
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

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
    .promo-form-card {
      background: white;
      border-radius: 24px;
      padding: 48px;
      box-shadow: 0 12px 40px rgba(122, 94, 75, 0.12);
      position: relative;
      overflow: hidden;
    }

    .promo-form-card::before {
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
      margin-bottom: 28px;
    }

    .form-label {
      display: block;
      font-size: 15px;
      font-weight: 600;
      color: var(--brown);
      margin-bottom: 12px;
    }

    /* Input */
    .form-input {
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

    .form-input:focus {
      outline: none;
      border-color: var(--warm-beige);
      background: white;
      box-shadow: 0 0 0 3px rgba(217, 191, 165, 0.25);
    }

    /* Menu Card */
    .menu-card {
      background: var(--sand);
      border: 1px solid #e9d7c7;
      border-radius: 18px;
      padding: 24px;
    }

    .menu-row {
      display: flex;
      align-items: center;
      margin-bottom: 20px;
    }

    .menu-row:last-child {
      margin-bottom: 0;
    }

    .menu-label {
      flex: 0 0 45%;
      font-weight: 600;
      color: var(--brown);
      font-size: 16px;
    }

    .menu-input {
      flex: 1;
      padding: 12px 16px;
      border: 1px solid #e9d7c7;
      border-radius: 14px;
      background: white;
      color: var(--brown);
      font-size: 15px;
      transition: all 0.2s ease;
    }

    .menu-input:focus {
      outline: none;
      border-color: var(--warm-beige);
      box-shadow: 0 0 0 2px rgba(217, 191, 165, 0.2);
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

    /* Responsif */
    @media (max-width: 768px) {
      .promo-form-card {
        padding: 36px 24px;
      }
      .form-title {
        font-size: 24px;
      }
      .menu-row {
        flex-direction: column;
        align-items: flex-start;
      }
      .menu-label {
        margin-bottom: 12px;
        width: 100%;
      }
      .menu-input {
        width: 100%;
      }
    }
  </style>
</head>
<body>

<div class="main-container">
  <a href="/promotions" class="btn-back">
    <i class="bi bi-arrow-left"></i> Back to Promotions
  </a>

  <div class="promo-form-card">
    <h1 class="form-title">
      <?= $baby == 'input' ? 'Create New Promotion' : 'Edit Promotion' ?>
    </h1>

    <form action="/savepromotion/<?= $baby == 'input' ? 0 : $menu->promotionname ?>" method="post" class="was-validated">
      @csrf

      <!-- Promotion Name -->
      <div class="form-group">
        <label class="form-label">Promotion Name</label>
        <input type="text" 
               class="form-input" 
               name="promotionname" 
               required
               value="<?= $baby == 'input' ? '' : htmlspecialchars($menu->promotionname ?? '') ?>">
      </div>

      <!-- Menu List -->
      <div class="form-group">
        <label class="form-label">Menus & Promo Prices</label>
        <div class="menu-card">
          <?php foreach ($ban as $key): ?>
            <?php 
            $existingPrice = '';
            if (isset($promos) && is_array($promos)) {
              foreach ($promos as $promo) {
                if (is_object($promo) && (int)$promo->menuid === (int)$key->menuid) {
                  $existingPrice = $promo->prices;
                }
              }
            }
            if (isset($promos) && is_array($promos)) {
              foreach ($promos as $promo) {
                if (is_object($promo) && (int)$promo->menuid === (int)$key->menuid) {
                  $existingPrice = $promo->prices;
                }
              }
            }
            ?>
            <div class="menu-row">
              <div class="menu-label"><?= htmlspecialchars($key->menuname) ?></div>
              <input 
              type="number" 
                name="prices[<?= $key->menuid ?>]" 
                class="menu-input" 
                min="0"
                value="<?= $baby == 'input' ? '' : htmlspecialchars($existingPrice) ?>"
                placeholder="Enter promo price (optional)">
            </div>
          <?php endforeach; ?>
        </div>
      </div>

      <div class="d-grid mt-4">
        <button type="submit" class="btn-submit">
          <?= $baby == 'input' ? 'Create Promotion' : 'Save Changes' ?>
        </button>
      </div>
    </form>
  </div>
</div>

</body>
</html>