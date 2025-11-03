<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>User Data</title>
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
    }

    /* Hero Section */
    .hero {
      background: linear-gradient(rgba(122, 94, 75, 0.8), rgba(122, 94, 75, 0.8)), 
                  url('https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?auto=format&fit=crop&w=1600') center/cover no-repeat;
      height: 40vh;
      display: flex;
      align-items: center;
      justify-content: center;
      text-align: center;
      color: white;
      padding: 0 20px;
    }

    .hero h1 {
      font-family: 'Playfair Display', serif;
      font-size: 3rem;
      font-weight: 700;
      margin-bottom: 16px;
      text-shadow: 0 2px 6px rgba(0,0,0,0.4);
    }

    .main-container {
      max-width: 1200px;
      margin: -40px auto 60px;
      padding: 0 20px;
      position: relative;
      z-index: 2;
    }

    /* Controls */
    .controls-container {
      background: white;
      border-radius: 20px;
      padding: 24px;
      box-shadow: 0 6px 20px rgba(122, 94, 75, 0.08);
      margin-bottom: 32px;
    }

    .search-form {
      display: flex;
      gap: 14px;
      flex-wrap: wrap;
      align-items: center;
      margin-bottom: 20px;
    }

    .search-input {
      padding: 12px 20px;
      border-radius: 16px;
      border: 1px solid #e9d7c7;
      background: var(--sand);
      color: var(--brown);
      font-family: 'Inter', sans-serif;
      font-size: 15px;
      width: 260px;
      max-width: 100%;
    }

    .search-input:focus {
      outline: none;
      border-color: var(--warm-beige);
      box-shadow: 0 0 0 3px rgba(217, 191, 165, 0.2);
    }

    .search-btn,
    .reset-btn {
      padding: 12px 24px;
      border-radius: 16px;
      font-weight: 600;
      font-size: 15px;
      cursor: pointer;
      border: none;
      transition: all 0.25s ease;
      font-family: 'Inter', sans-serif;
    }

    .search-btn {
      background: var(--warm-beige);
      color: var(--brown);
      box-shadow: 0 4px 12px rgba(232, 213, 196, 0.3);
    }

    .search-btn:hover {
      background: #d9bfa5;
      transform: translateY(-2px);
      box-shadow: 0 6px 16px rgba(232, 213, 196, 0.4);
    }

    .reset-btn {
      background: #f0e6d2;
      color: #8b6b45;
      box-shadow: 0 4px 10px rgba(220, 200, 180, 0.2);
    }

    .reset-btn:hover {
      background: #e8d5c4;
      transform: translateY(-2px);
      box-shadow: 0 6px 14px rgba(220, 200, 180, 0.25);
    }

    .sort-buttons {
      display: flex;
      gap: 12px;
      flex-wrap: wrap;
      justify-content: center;
    }

    .sort-btn {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      padding: 10px 18px;
      border-radius: 14px;
      font-size: 14px;
      font-weight: 600;
      color: var(--brown);
      text-decoration: none;
      background: var(--sand);
      border: 1px solid #e9d7c7;
      transition: all 0.2s ease;
    }

    .sort-btn:hover {
      background: var(--warm-beige);
      color: white;
      border-color: var(--warm-beige);
      transform: translateY(-2px);
    }

    /* User Grid */
    .user-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
      gap: 32px;
    }

    .user-card {
      background: white;
      border-radius: 22px;
      box-shadow: 0 10px 35px rgba(122, 94, 75, 0.1);
      overflow: hidden;
      transition: transform 0.3s ease;
      position: relative;
    }

    .user-card:hover {
      transform: translateY(-6px);
    }

    .user-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 5px;
      background: linear-gradient(90deg, var(--warm-beige), #d9bfa5);
    }

    .user-card-header {
      background: var(--warm-beige);
      color: var(--brown);
      font-weight: 700;
      padding: 18px 24px;
      font-size: 19px;
      letter-spacing: -0.3px;
      text-align: center;
    }

    .user-card-body {
      padding: 28px;
    }

    .info-group {
      margin-bottom: 20px;
    }

    .info-label {
      font-size: 12px;
      font-weight: 600;
      color: var(--light-brown);
      text-transform: uppercase;
      letter-spacing: 1px;
      margin-bottom: 6px;
    }

    .info-value {
      font-size: 16px;
      color: var(--brown);
      font-weight: 500;
    }

    .user-actions {
      display: flex;
      gap: 12px;
      flex-wrap: wrap;
      padding-top: 20px;
      margin-top: 20px;
      border-top: 1px solid #f0e8e0;
    }

    .btn-reset,
    .btn-delete {
      flex: 1;
      min-width: 130px;
      padding: 12px 16px;
      font-size: 14px;
      font-weight: 600;
      border-radius: 14px;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      transition: all 0.25s ease;
      border: none;
      cursor: pointer;
      text-align: center;
    }

    .btn-reset {
      background: #f0e6d2;
      color: #8b6b45;
      box-shadow: 0 4px 10px rgba(220, 200, 180, 0.2);
    }

    .btn-reset:hover {
      background: #e8d5c4;
      transform: translateY(-2px);
      box-shadow: 0 6px 14px rgba(220, 200, 180, 0.25);
    }

    .btn-delete {
      background: #f8f0e8;
      color: #a66a55;
      box-shadow: 0 4px 10px rgba(220, 200, 180, 0.2);
    }

    .btn-delete:hover {
      background: #f0e0d0;
      color: #9a5a45;
      transform: translateY(-2px);
      box-shadow: 0 6px 14px rgba(220, 200, 180, 0.25);
    }

    /* Pagination */
    .soft-pagination {
      display: flex;
      list-style: none;
      padding: 0;
      margin: 48px auto 0;
      gap: 10px;
      justify-content: center;
      flex-wrap: wrap;
    }

    .soft-pagination .page-link {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 6px;
      font-size: 14px;
      font-weight: 500;
      color: var(--brown);
      text-decoration: none;
      background: white;
      border: 1px solid #e9d7c7;
      border-radius: 14px;
      padding: 10px 16px;
      transition: all 0.2s ease;
      min-width: 40px;
      text-align: center;
    }

    .soft-pagination .page-link:hover:not(.disabled) {
      background: var(--sand);
      border-color: var(--warm-beige);
      color: var(--warm-beige);
      transform: translateY(-2px);
    }

    .soft-pagination .page-item.active .page-link {
      background: var(--warm-beige);
      color: white;
      border-color: var(--warm-beige);
      box-shadow: 0 4px 10px rgba(220, 200, 180, 0.2);
    }

    @media (max-width: 768px) {
      .hero { height: 30vh; }
      .hero h1 { font-size: 2.2rem; }
      .search-form {
        flex-direction: column;
        align-items: stretch;
      }
      .user-grid {
        grid-template-columns: 1fr;
        gap: 24px;
      }
      .user-actions {
        flex-direction: column;
      }
      .btn-reset,
      .btn-delete {
        width: 100%;
      }
    }
  </style>
</head>
<body>

<!-- Hero Section -->
<section class="hero">
  <h1>User Management</h1>
</section>

<div class="main-container">
  <!-- Controls -->
  <div class="controls-container">
    <form action="/userdata" method="GET" class="search-form">
      <input type="text" name="search" class="search-input" 
             placeholder="Search by username..." 
             value="<?= htmlspecialchars(request('search') ?? '') ?>">
      <button type="submit" class="search-btn">Search</button>
      <a href="/userdata" class="reset-btn">Reset</a>
    </form>

    <div class="sort-buttons">
      <a href="?order_by=user.username&sort=asc" class="sort-btn">Username ↑</a>
      <a href="?order_by=user.username&sort=desc" class="sort-btn">Username ↓</a>
    </div>
  </div>

  <!-- User Grid -->
  <div class="user-grid">
    <?php foreach($lope as $key) { ?>
      <div class="user-card">
        <div class="user-card-header">
          <?= htmlspecialchars($key->levelname) ?>
        </div>
        <div class="user-card-body">
          <div class="info-group">
            <div class="info-label">Username</div>
            <div class="info-value"><?= htmlspecialchars($key->username) ?></div>
          </div>
          <?php if (session('levelid') == 1) { ?>
            <div class="info-group">
              <div class="info-label">Role</div>
              <div class="info-value"><?= htmlspecialchars($key->rolename) ?></div>
            </div>
          <?php } ?>
          <div class="info-group">
            <div class="info-label">Email</div>
            <div class="info-value"><?= htmlspecialchars($key->email) ?></div>
          </div>
          <div class="info-group">
            <div class="info-label">Phone Number</div>
            <div class="info-value"><?= htmlspecialchars($key->phonenumber) ?></div>
          </div>
          <div class="user-actions">
            <form action="/resetpassword/<?= $key->userid ?>" method="post" class="d-inline" style="flex:1; min-width:130px;">
              @csrf
              <button type="submit" class="btn-reset">
                Reset Password
              </button>
            </form>
            <a href="/deleteuser/<?= $key->userid ?>" class="btn-delete" style="flex:1; min-width:130px;">
              Delete User
            </a>
          </div>
        </div>
      </div>
    <?php } ?>
  </div>

  <!-- Pagination -->
  <?php if (isset($lope) && $lope->hasPages()) { ?>
    <ul class="soft-pagination">
      <?php if ($lope->onFirstPage()) { ?>
        <li class="page-item disabled">
          <a class="page-link" href="#" aria-label="Previous">
            <i class="bi bi-chevron-left"></i> <span>Previous</span>
          </a>
        </li>
      <?php } else { ?>
        <li class="page-item">
          <a class="page-link" href="<?= $lope->previousPageUrl() ?>" aria-label="Previous">
            <i class="bi bi-chevron-left"></i> <span>Previous</span>
          </a>
        </li>
      <?php } ?>

      <?php foreach ($lope->getUrlRange(1, $lope->lastPage()) as $page => $url) { ?>
        <li class="page-item <?= $lope->currentPage() == $page ? 'active' : '' ?>">
          <a class="page-link" href="<?= $url ?>"><?= $page ?></a>
        </li>
      <?php } ?>

      <?php if ($lope->hasMorePages()) { ?>
        <li class="page-item">
          <a class="page-link" href="<?= $lope->nextPageUrl() ?>" aria-label="Next">
            <span>Next</span> <i class="bi bi-chevron-right"></i>
          </a>
        </li>
      <?php } else { ?>
        <li class="page-item disabled">
          <a class="page-link" href="#" aria-label="Next">
            <span>Next</span> <i class="bi bi-chevron-right"></i>
          </a>
        </li>
      <?php } ?>
    </ul>
  <?php } ?>
</div>

</body>
</html>