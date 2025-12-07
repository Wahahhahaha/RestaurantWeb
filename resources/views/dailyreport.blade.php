<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Daily Report</title>

<style>
  body {
    font-family: Arial, sans-serif;
    margin: 40px;
    color: #333;
  }

  h2, h3 {
    margin-bottom: 6px;
    color: #444;
  }

  .summary p {
    margin: 4px 0;
    font-size: 16px;
  }

  hr {
    margin: 20px 0;
    border: none;
    border-top: 1px solid #bbb;
  }

  table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 12px;
    margin-bottom: 25px;
  }

  table th {
    background: #f2f2f2;
    padding: 10px;
    text-align: left;
    border-bottom: 2px solid #ccc;
  }

  table td {
    padding: 10px;
    border-bottom: 1px solid #e2e2e2;
  }

  .text-right {
    text-align: right;
  }

  .empty-row td {
    text-align: center;
    font-style: italic;
    color: #777;
  }

  /* Print Optimization */
  @media print {
    body {
      margin: 0;
      padding: 20px;
    }
    hr {
      border-color: #777;
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

  <!-- MENU SOLD TABLE -->
  <h3>Menu Sold</h3>
  <table>
    <thead>
      <tr>
        <th>Menu / Promotion</th>
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

  <!-- EXPENSE TABLE -->
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
