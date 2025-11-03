<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Financial Report <?= $bulan ?> <?= $tahun ?></title>
  <style>
    /* Font formal untuk dokumen cetak */
    body {
      font-family: "Times New Roman", Times, serif;
      font-size: 14px;
      line-height: 1.4;
      color: #000; /* Hitam pekat — jangan abu-abu! */
      max-width: 800px;
      margin: 0 auto;
      padding: 20px;
    }

    /* Judul */
    h2, h3 {
      text-align: center;
      margin: 10px 0;
      color: #000; /* Pastikan hitam */
    }

    h2 {
      font-size: 22px;
      font-weight: bold;
    }

    h3 {
      font-size: 18px;
      font-weight: bold;
    }

    /* Tabel */
    table {
      width: 100%;
      border-collapse: collapse;
      margin: 20px 0;
    }

    /* Section Header (INCOME / EXPENSES) */
    .section-title {
      text-align: left;
      padding: 8px 0;
      font-weight: bold;
      font-size: 16px;
      border-bottom: 2px solid #000; /* Garis tebal */
      margin-top: 15px;
      color: #000; /* Jangan abu-abu */
    }

    td {
      padding: 6px 0;
      color: #000; /* Pastikan semua teks hitam */
    }

    .right {
      text-align: right;
      padding-left: 20px;
    }

    /* Subtotal */
    .subtotal td {
      padding-top: 10px;
      font-weight: bold;
      border-top: 1px solid #000; /* Garis tipis */
    }

    /* Total akhir */
    .total td {
      padding: 8px 0;
      font-weight: bold;
      color: #000;
    }

    .total:first-child td {
      border-top: 2px double #000; /* Garis ganda tebal */
    }

    .total:last-child td {
      border-bottom: 2px double #000; /* Garis ganda tebal */
    }

    /* Net profit warna (tetap hitam — hemat tinta) */
    .positive {
      color: #000;
    }

    .negative {
      color: #000;
      font-weight: bold;
    }

    /* Print date */
    p {
      font-size: 13px;
      margin-top: 30px;
      text-align: right;
      color: #000; /* Hitam */
    }

    /* Pastikan saat print, semuanya hitam */
    @media print {
      body {
        background: white !important;
        color: black !important;
      }
      * {
        -webkit-print-color-adjust: exact !important;
        color-adjust: exact !important;
      }
      .section-title,
      .subtotal,
      .total {
        color: #000 !important;
        border-color: #000 !important;
      }
    }
  </style>
</head>
<body onload="window.print()">
  <h2>Chick Chi</h2>
  <h3>Monthly Profit & Loss Report</h3>
  <h3><?= strtoupper(date('F', mktime(0, 0, 0, $bulan, 1))) ?> <?= $tahun ?></h3>

  <table>
    <tr><th colspan="2" class="section-title">INCOME</th></tr>
    <tr>
      <td>Food & Beverage Sales</td>
      <td class="right">Rp <?= number_format($pemasukan, 0, ',', '.') ?></td>
    </tr>
    <tr class="subtotal">
      <td>Total Income</td>
      <td class="right">Rp <?= number_format($pemasukan, 0, ',', '.') ?></td>
    </tr>
  </table>

  <table>
    <tr><th colspan="2" class="section-title">EXPENSES</th></tr>
    <?php foreach($detailPengeluaran as $e) { ?>
      <tr>
        <td><?= $e->expensename ?></td>
        <td class="right">Rp <?= number_format($e->total, 0, ',', '.') ?></td>
      </tr>
    <?php } ?>
    <tr class="subtotal">
      <td>Total Expenses</td>
      <td class="right">Rp <?= number_format($pengeluaran, 0, ',', '.') ?></td>
    </tr>
  </table>

  <?php
    $pajak = $pemasukan > 0 ? $pemasukan * 0.005 : 0;
    $labaSetelahPajak = $laba - $pajak;
  ?>

  <table>
    <tr class="total">
      <td>Profit before Tax</td>
      <td class="right">Rp <?= number_format($laba, 0, ',', '.') ?></td>
    </tr>
    <tr class="total">
      <td>Income Tax (0.5%)</td>
      <td class="right">Rp <?= number_format($pajak, 0, ',', '.') ?></td>
    </tr>
    <tr class="total">
      <td>Net profit</td>
      <td class="right <?= $labaSetelahPajak >= 0 ? 'positive' : 'negative' ?>">
        Rp <?= number_format($labaSetelahPajak, 0, ',', '.') ?>
      </td>
    </tr>
  </table>

  <br>
  <p>Print date: <?= date('d-m-Y H:i') ?></p>
</body>
</html>