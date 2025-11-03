<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>My Orders</title>
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

    .main-container {
      max-width: 1000px;
      margin: -40px auto 60px;
      padding: 0 20px;
      position: relative;
      z-index: 2;
    }

    .orders-card {
      background: white;
      border-radius: 24px;
      box-shadow: 0 12px 40px rgba(122, 94, 75, 0.12);
      overflow: hidden;
      position: relative;
    }

    .orders-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 5px;
      background: linear-gradient(90deg, var(--warm-beige), #d9bfa5);
    }

    .orders-header {
      padding: 32px 32px 24px;
      border-bottom: 1px solid #f5f0ec;
    }

    .orders-header h2 {
      font-family: 'Playfair Display', serif;
      font-size: 26px;
      font-weight: 700;
      color: var(--brown);
    }

    .alert-success {
      background: #e6f4f1;
      color: #2d7d70;
      border: 1px solid #d0eae3;
      border-radius: 14px;
      padding: 14px 20px;
      margin-bottom: 28px;
      font-weight: 500;
      text-align: center;
    }

    /* Orders Table */
    .orders-table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 16px;
    }

    .orders-table th {
      text-align: center;
      padding: 16px 12px;
      font-weight: 600;
      font-size: 13px;
      text-transform: uppercase;
      letter-spacing: 0.8px;
      color: var(--light-brown);
      background: var(--sand);
    }

    .orders-table td {
      padding: 18px 12px;
      text-align: center;
      font-size: 15px;
      border-bottom: 1px solid #f5f0ec;
      vertical-align: middle;
    }

    .orders-table tbody tr:last-child td {
      border-bottom: none;
    }

    .orders-table tbody tr td[colspan] {
      color: var(--light-brown);
      font-style: italic;
      padding: 32px 0;
    }

    /* Status Badge */
    .status-badge {
      display: inline-block;
      padding: 8px 18px;
      border-radius: 50px;
      font-weight: 600;
      font-size: 13px;
      text-transform: capitalize;
      min-width: 110px;
    }

    .status-badge.pending,
    .status-badge.pickup_assigned {
      background: #f0e6d2;
      color: #8b6b45;
    }

    .status-badge.on_delivery {
      background: #e6f4f1;
      color: #2d7d70;
    }

    .status-badge.delivered {
      background: #f0f7ed;
      color: #5a8a4a;
    }

    /* Update Form */
    .update-form {
      display: flex;
      gap: 12px;
      justify-content: center;
      align-items: center;
      flex-wrap: wrap;
    }

    .status-select {
      padding: 10px 16px;
      border-radius: 14px;
      border: 1px solid #e9d7c7;
      background: white;
      color: var(--brown);
      font-size: 14px;
      font-family: 'Inter', sans-serif;
      width: 170px;
      appearance: none;
      background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%237a5e4b' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e");
      background-repeat: no-repeat;
      background-position: right 12px center;
      background-size: 16px;
      padding-right: 40px;
    }

    .btn-update {
      background: var(--warm-beige);
      color: var(--brown);
      border: none;
      border-radius: 14px;
      padding: 10px 20px;
      font-weight: 600;
      font-size: 14px;
      cursor: pointer;
      transition: all 0.25s ease;
      box-shadow: 0 4px 10px rgba(232, 213, 196, 0.3);
      min-width: 90px;
    }

    .btn-update:hover {
      background: #d9bfa5;
      transform: translateY(-2px);
      box-shadow: 0 6px 14px rgba(232, 213, 196, 0.4);
    }

    /* Pagination */
    .soft-pagination {
      display: flex;
      list-style: none;
      padding: 0;
      margin: 40px auto 0;
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
      .orders-card {
        border-radius: 22px;
      }
      .orders-header {
        padding: 28px 24px 20px;
      }
      .update-form {
        flex-direction: column;
        align-items: stretch;
      }
      .status-select {
        width: 100%;
        padding-right: 40px;
      }
      .btn-update {
        width: 100%;
      }
    }
  </style>
</head>
<body>

<!-- Hero Section -->
<section class="hero">
  <h1>My Orders</h1>
</section>

<div class="main-container">
  <div class="orders-card">
    <div class="orders-header">
      <h2>Order Management</h2>
    </div>

    <div style="padding: 0 32px 32px;">
      <?php if (session('success')) { ?>
        <div class="alert alert-success"><?= htmlspecialchars(session('success')) ?></div>
      <?php } ?>

      <table class="orders-table">
        <thead>
          <tr>
            <th>No</th>
            <th>Order ID</th>
            <th>Total</th>
            <th>Status</th>
            <th>Update Status</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($orders)): ?>
            <tr>
              <td colspan="5">No assigned orders.</td>
            </tr>
          <?php else: ?>
            @foreach ($orders as $o)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>#<?= htmlspecialchars($o->orderid) ?></td>
                <td>Rp<?= number_format($o->total, 0, ',', '.') ?></td>
                <td>
                  <span class="status-badge <?= htmlspecialchars($o->status) ?>">
                    <?= ucfirst(htmlspecialchars($o->status)) ?>
                  </span>
                </td>
                <td>
                  <form action="/courier/status/<?= $o->orderid ?>" method="POST" class="update-form">
                    <?= csrf_field() ?>
                    <select name="status" class="status-select">
                      <option value="pickup_assigned" <?= $o->status == 'pickup_assigned' ? 'selected' : '' ?>>Ready to Pickup</option>
                      <option value="on_delivery" <?= $o->status == 'on_delivery' ? 'selected' : '' ?>>On Delivery</option>
                      <option value="delivered" <?= $o->status == 'delivered' ? 'selected' : '' ?>>Delivered</option>
                    </select>
                    <button type="submit" class="btn-update">Update</button>
                  </form>
                </td>
              </tr>
            @endforeach
          <?php endif; ?>
        </tbody>
      </table>

      <?php if (isset($orders) && $orders->hasPages()): ?>
        <ul class="soft-pagination">
          <?php if ($orders->onFirstPage()): ?>
            <li class="page-item disabled">
              <a class="page-link" href="#" aria-label="Previous">
                <i class="bi bi-chevron-left"></i> <span>Previous</span>
              </a>
            </li>
          <?php else: ?>
            <li class="page-item">
              <a class="page-link" href="<?= $orders->previousPageUrl() ?>" aria-label="Previous">
                <i class="bi bi-chevron-left"></i> <span>Previous</span>
              </a>
            </li>
          <?php endif; ?>

          <?php foreach ($orders->getUrlRange(1, $orders->lastPage()) as $page => $url): ?>
            <li class="page-item <?= $orders->currentPage() == $page ? 'active' : '' ?>">
              <a class="page-link" href="<?= $url ?>"><?= $page ?></a>
            </li>
          <?php endforeach; ?>

          <?php if ($orders->hasMorePages()): ?>
            <li class="page-item">
              <a class="page-link" href="<?= $orders->nextPageUrl() ?>" aria-label="Next">
                <span>Next</span> <i class="bi bi-chevron-right"></i>
              </a>
            </li>
          <?php else: ?>
            <li class="page-item disabled">
              <a class="page-link" href="#" aria-label="Next">
                <span>Next</span> <i class="bi bi-chevron-right"></i>
              </a>
            </li>
          <?php endif; ?>
        </ul>
      <?php endif; ?>
    </div>
  </div>
</div>

</body>
</html>