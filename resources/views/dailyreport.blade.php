<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Daily Report {{ $tanggal }}</title>
  <style>
    /* Font formal untuk dokumen cetak */
    body {
      font-family: "Times New Roman", Times, serif;
      font-size: 14px;
      line-height: 1.4;
      color: #000;
      max-width: 800px;
      margin: 0 auto;
      padding: 20px;
    }

    h2, h3 {
      text-align: center;
      margin: 20px 0 15px;
      color: #000;
    }

    h2 {
      font-size: 20px;
      font-weight: bold;
    }

    h3 {
      font-size: 16px;
      font-weight: bold;
      margin-top: 25px;
    }

    /* Summary box */
    .summary {
      text-align: center;
      margin: 15px 0;
      padding: 10px 0;
    }

    .summary p {
      margin: 6px 0;
      font-weight: bold;
    }

    hr {
      border: 0;
      border-top: 1px solid #000;
      margin: 20px 0;
    }

    /* Tables */
    table {
      width: 100%;
      border-collapse: collapse;
      margin: 15px 0;
    }

    th {
      background: #fff;
      padding: 10px 8px;
      font-weight: bold;
      text-align: center;
      border: 1px solid #000;
      color: #000;
    }

    td {
      padding: 8px;
      text-align: center;
      border: 1px solid #000;
      color: #000;
    }

    /* Align numbers to right */
    .text-right {
      text-align: right !important;
      padding-right: 10px;
    }

    /* Empty row */
    .empty-row td {
      font-style: italic;
      color: #000;
    }

    /* Print optimization */
    @media print {
      body {
        background: white !important;
        color: black !important;
      }
      * {
        -webkit-print-color-adjust: exact !important;
        color-adjust: exact !important;
      }
    }
  </style>
</head>
<body onload="window.print()">
  <h2>Daily Report - {{ \Carbon\Carbon::parse($tanggal)->format('d M Y') }}</h2>

  <div class="summary">
    <p><strong>Total Income:</strong> Rp{{ number_format($pemasukan, 0, ',', '.') }}</p>
    <p><strong>Total Expenses:</strong> Rp{{ number_format($pengeluaran, 0, ',', '.') }}</p>
    <p><strong>Net Profit:</strong> Rp{{ number_format($laba, 0, ',', '.') }}</p>
  </div>

  <hr>

  <h3>Menu Sold</h3>
  <table>
    <thead>
      <tr>
        <th>Menu</th>
        <th>Quantity Sold</th>
        <th class="text-right">Total (Rp)</th>
      </tr>
    </thead>
    <tbody>
      @forelse ($detailMenu as $item)
        <tr>
          <td>{{ $item->menuname }}</td>
          <td>{{ $item->totalpcs }}</td>
          <td class="text-right">Rp{{ number_format($item->totaltotal, 0, ',', '.') }}</td>
        </tr>
      @empty
        <tr class="empty-row">
          <td colspan="3">No menu sold on this date</td>
        </tr>
      @endforelse
    </tbody>
  </table>

  <h3>Expense</h3>
  <table>
    <thead>
      <tr>
        <th>Date</th>
        <th>Expense Name</th>
        <th class="text-right">Daily Cost (Rp)</th>
      </tr>
    </thead>
    <tbody>
      @forelse ($detailPengeluaran as $e)
        <tr>
          <td>{{ \Carbon\Carbon::parse($e->date)->format('d M Y') }}</td>
          <td>{{ $e->expensename }}</td>
          <td class="text-right">Rp{{ number_format($e->total, 0, ',', '.') }}</td>
        </tr>
      @empty
        <tr class="empty-row">
          <td colspan="3">No expenses recorded</td>
        </tr>
      @endforelse
    </tbody>
  </table>
</body>
</html>