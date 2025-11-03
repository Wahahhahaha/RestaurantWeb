
  <title>Order History</title>

  <style>

    .hero {
      background: linear-gradient(rgba(122, 94, 75, 0.8), rgba(122, 94, 75, 0.8)), 
                  url('https://images.unsplash.com/photo-1555396273-367ea4eb4db5?auto=format&fit=crop&w=1600') center/cover no-repeat;
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


    .page-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
      gap: 16px;
      margin-bottom: 28px;
    }

    .page-title {
      font-family: 'Playfair Display', serif;
      font-size: 26px;
      font-weight: 700;
      color: var(--brown);
    }
    /* Tombol Detail */
    .btn-detail {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 6px;
      background: #f0e6d2;
      color: #8b6b45;
      font-weight: 600;
      font-size: 14px;
      padding: 8px 16px;
      border-radius: 14px;
      text-decoration: none;
      transition: all 0.25s ease;
      border: none;
      box-shadow: 0 2px 6px rgba(220, 200, 180, 0.15);
    }

    .btn-detail:hover {
      background: #e8d5c4;
      transform: translateY(-2px);
      box-shadow: 0 4px 10px rgba(220, 200, 180, 0.2);
    }

    /* Pagination */
    .soft-pagination {
      display: flex;
      list-style: none;
      padding: 0;
      margin: 32px 0 0;
      gap: 8px;
      justify-content: center;
      flex-wrap: wrap;
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

    .soft-pagination .page-item.disabled .page-link {
      color: #c5b8a8;
      pointer-events: none;
      opacity: 0.6;
    }


  </style>
</head>
<body>

<!-- Hero Section -->
<section class="hero">
  <h1>Order History</h1>
</section>

<div class="main-container">
  <div class="page-header">
    <h2 class="page-title">Your Orders</h2>
  </div>

  <!-- Filter Form -->
  <form action="/historytransaction" method="GET" class="filter-form">
    <input type="date" name="date_from" value="<?= htmlspecialchars(request('date_from') ?? '') ?>">
    <input type="date" name="date_to" value="<?= htmlspecialchars(request('date_to') ?? '') ?>">
    <button type="submit" class="btn-filter">
      <i class="bi bi-funnel"></i> Filter
    </button>
    <a href="/historytransaction" class="btn-reset">
      <i class="bi bi-arrow-clockwise"></i> Reset
    </a>
  </form>

  <!-- Table -->
  <div class="history-table-container">
    <table class="history-table">
      <thead>
        <tr>
          <th>No</th>
          <th>Order ID</th>
          <th>Order Date</th>
          <th>Address</th>
          <th>Total</th>
          <th>Status</th>
          <th>Detail</th>
        </tr>
      </thead>
      <tbody>
        <?php 
        $no = 1;
        foreach ($data as $key) { ?>
          <tr>
            <td><?= $no++ ?></td>
            <td><?= htmlspecialchars($key->orderid) ?></td>
            <td><?= htmlspecialchars($key->orderdate) ?></td>
            <td><?= htmlspecialchars($key->address) ?></td>
            <td>Rp <?= number_format($key->total, 0, ',', '.') ?></td>
            <td><?= htmlspecialchars($key->status) ?></td>
            <td>
              <a href="/detailhistory/<?= $key->orderid ?>" class="btn-detail">
                <i class="bi bi-eye"></i> View
              </a>
            </td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>

  <!-- Pagination -->
  <?php if (isset($data) && $data->hasPages()) { ?>
    <ul class="soft-pagination">
      <?php if ($data->onFirstPage()) { ?>
        <li class="page-item disabled">
          <a class="page-link" href="#" aria-label="Previous">
            <i class="bi bi-chevron-left"></i> <span>Previous</span>
          </a>
        </li>
      <?php } else { ?>
        <li class="page-item">
          <a class="page-link" href="<?= $data->previousPageUrl() ?>" aria-label="Previous">
            <i class="bi bi-chevron-left"></i> <span>Previous</span>
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