<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Financial Report</title>
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

    .report-card {
      background: white;
      border-radius: 24px;
      box-shadow: 0 12px 40px rgba(122, 94, 75, 0.12);
      overflow: hidden;
      position: relative;
    }

    .report-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 5px;
      background: linear-gradient(90deg, var(--warm-beige), #d9bfa5);
    }

    .report-header {
      padding: 32px 32px 24px;
      border-bottom: 1px solid #f5f0ec;
    }

    .report-header h2 {
      font-family: 'Playfair Display', serif;
      font-size: 26px;
      font-weight: 700;
      color: var(--brown);
    }

    /* Filter Form */
    .filter-form {
      display: flex;
      gap: 14px;
      flex-wrap: wrap;
      align-items: center;
      padding: 0 32px 28px;
      border-bottom: 1px solid #f5f0ec;
    }

    .date-input {
      padding: 12px 18px;
      border-radius: 16px;
      border: 1px solid #e9d7c7;
      background: var(--sand);
      color: var(--brown);
      font-family: 'Inter', sans-serif;
      font-size: 15px;
      width: 170px;
    }

    .date-input:focus {
      outline: none;
      border-color: var(--warm-beige);
      box-shadow: 0 0 0 3px rgba(217, 191, 165, 0.2);
    }

    .btn-filter,
    .btn-reset,
    .btn-sort {
      padding: 12px 24px;
      border-radius: 16px;
      font-weight: 600;
      font-size: 15px;
      cursor: pointer;
      border: none;
      transition: all 0.25s ease;
      font-family: 'Inter', sans-serif;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      text-decoration: none;
    }

    .btn-filter {
      background: var(--warm-beige);
      color: var(--brown);
      box-shadow: 0 4px 12px rgba(232, 213, 196, 0.3);
    }

    .btn-filter:hover {
      background: #d9bfa5;
      transform: translateY(-2px);
      box-shadow: 0 6px 16px rgba(232, 213, 196, 0.4);
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

    .btn-sort {
      background: #e6f4f1;
      color: #2d7d70;
      box-shadow: 0 4px 10px rgba(45, 125, 112, 0.2);
    }

    .btn-sort:hover {
      background: #d0eae3;
      transform: translateY(-2px);
      box-shadow: 0 6px 14px rgba(45, 125, 112, 0.25);
    }

    /* Report Table */
    .report-table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 16px;
    }

    .report-table th {
      text-align: center;
      padding: 16px 12px;
      font-weight: 600;
      font-size: 13px;
      text-transform: uppercase;
      letter-spacing: 0.8px;
      color: var(--light-brown);
      background: var(--sand);
    }

    .report-table td {
      padding: 18px 12px;
      text-align: center;
      font-size: 15px;
      border-bottom: 1px solid #f5f0ec;
      vertical-align: middle;
    }

    .report-table tbody tr:last-child td {
      border-bottom: none;
    }

    /* Action Buttons */
    .action-cell {
      display: flex;
      gap: 12px;
      justify-content: center;
      flex-wrap: wrap;
    }

    .btn-action {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      font-weight: 600;
      font-size: 14px;
      padding: 10px 18px;
      border-radius: 14px;
      text-decoration: none;
      transition: all 0.25s ease;
      white-space: nowrap;
      border: none;
      min-width: 90px;
      cursor: pointer;
    }

    .btn-print {
      background: #e6f4f1;
      color: #2d7d70;
      box-shadow: 0 3px 8px rgba(45, 125, 112, 0.15);
    }

    .btn-print:hover {
      background: #d0eae3;
      transform: translateY(-2px);
      box-shadow: 0 5px 12px rgba(45, 125, 112, 0.2);
    }

    .btn-pdf {
      background: #fdf2f0;
      color: #c25a4a;
      box-shadow: 0 3px 8px rgba(194, 90, 74, 0.15);
    }

    .btn-pdf:hover {
      background: #f8e0dc;
      transform: translateY(-2px);
      box-shadow: 0 5px 12px rgba(194, 90, 74, 0.2);
    }

    .btn-excel {
      background: #f0f7ed;
      color: #5a8a4a;
      box-shadow: 0 3px 8px rgba(90, 138, 74, 0.15);
    }

    .btn-excel:hover {
      background: #e4ecd8;
      transform: translateY(-2px);
      box-shadow: 0 5px 12px rgba(90, 138, 74, 0.2);
    }

    @media (max-width: 768px) {
      .hero { height: 30vh; }
      .hero h1 { font-size: 2.2rem; }
      .filter-form {
        flex-direction: column;
        align-items: stretch;
        padding: 0 24px 24px;
      }
      .date-input {
        width: 100%;
      }
      .action-cell {
        flex-direction: column;
        align-items: center;
      }
      .btn-action {
        width: 100%;
        justify-content: center;
      }
    }
  </style>
</head>
<body>

<!-- Hero Section -->
<section class="hero">
  <h1>Financial Report</h1>
</section>

<div class="main-container">
  <div class="report-card">
    <div class="report-header">
      <h2>Monthly Reports</h2>
    </div>

<form id="filterForm" action="/report" method="GET" class="filter-form">
    <input type="date" name="date_from" class="date-input" 
           value="<?= htmlspecialchars(request('date_from') ?? '') ?>">

    <input type="date" name="date_to" class="date-input" 
           value="<?= htmlspecialchars(request('date_to') ?? '') ?>">

    <button type="submit" class="btn-filter">Filter</button>

    <a href="/report" class="btn-reset" type="button">Reset</a>

    <a href="#" id="sortBtn" class="btn-sort" data-sort="<?= $sort === 'asc' ? 'desc' : 'asc' ?>">
        <?= $sort === 'asc' ? 'Order ↓' : 'Order ↑' ?>
    </a>
</form>

    <div style="padding: 0 32px 32px;" id="report-table">
      <table class="report-table">
        <thead>
          <tr>
            <th>No</th>
            <th>Month</th>
            <th>Year</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php $no = 1; ?>
          <?php foreach ($bulanTahun as $bt): ?>
            <tr>
              <td><?= $no++ ?></td>
              <td><?= date("F", mktime(0, 0, 0, $bt->bulan, 1)) ?></td>
              <td><?= htmlspecialchars($bt->tahun) ?></td>
              <td class="action-cell">
                <form action="/printmonthlyreport/" method="get" target="_blank" style="display:inline;">
                  <input type="hidden" name="bulan" value="<?= htmlspecialchars($bt->bulan) ?>">
                  <input type="hidden" name="tahun" value="<?= htmlspecialchars($bt->tahun) ?>">
                  <button type="submit" class="btn-action btn-print">
                    <i class="bi bi-printe
                    r"></i> Print
                  </button>
                </form>

                <form action="/pdfmonthlyreport/" method="get" target="_blank" style="display:inline;">
                  <input type="hidden" name="bulan" value="<?= htmlspecialchars($bt->bulan) ?>">
                  <input type="hidden" name="tahun" value="<?= htmlspecialchars($bt->tahun) ?>">
                  <button type="submit" class="btn-action btn-pdf">
                    <i class="bi bi-file-earmark-pdf"></i> PDF
                  </button>
                </form>

                <form action="/excelmonthlyreport/" method="get" target="_blank" style="display:inline;">
                  <input type="hidden" name="bulan" value="<?= htmlspecialchars($bt->bulan) ?>">
                  <input type="hidden" name="tahun" value="<?= htmlspecialchars($bt->tahun) ?>">
                  <button type="submit" class="btn-action btn-excel">
                    <i class="bi bi-file-earmark-spreadsheet"></i> Excel
                  </button>
                </form>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

</body>
</html>