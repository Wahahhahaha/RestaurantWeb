
  <style>


    body {
      font-family: 'Inter', sans-serif;
      background: var(--beige);
      color: var(--brown);
      line-height: 1.6;
      padding-top: 20px;
      padding-bottom: 60px;
    }

    .main-container {
      max-width: 840px;
      margin: 0 auto;
      padding: 0 20px;
    }


  </style>
</head>
<body>

<div class="main-container">
  <div class="payment-card">
    <h3 class="payment-title">
      <i class="bi bi-receipt"></i> Confirm Order
    </h3>

    <form action="/payment" method="POST">
      @csrf

      <div class="order-summary">
        <table class="payment-table">
          <thead>
            <tr>
              <th>No</th>
              <th>Menu</th>
              <th>Price</th>
              <th>Qty</th>
              <th>Total</th>
            </tr>
          </thead>
          <tbody>
            @php $total = 0; @endphp
            @foreach($items as $item)
              @php $subtotal = $item['price'] * $item['quantity']; @endphp
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item['menuname'] }}</td>
                <td>Rp {{ number_format($item['price'], 0, ',', '.') }}</td>
                <td>{{ $item['quantity'] }}</td>
                <td>Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
              </tr>
              @php $total += $subtotal; @endphp
            @endforeach
          </tbody>
          <tfoot>
            <tr>
              <td colspan="4" style="text-align: right; font-weight: 600;">Total:</td>
              <td><strong>Rp {{ number_format($total, 0, ',', '.') }}</strong></td>
            </tr>
          </tfoot>
        </table>
      </div>

      <div class="form-group">
        <label class="form-label">Delivery Address</label>
        <input type="text" name="a" class="form-input" required>
      </div>

      <div class="form-group">
        <label class="form-label">Order Note (Optional)</label>
        <input type="text" name="note" class="form-input">
      </div>

      <div class="form-group">
        <label class="form-label">Payment Method</label>
        <select name="method" class="form-select" required>
          <option value="Cash">Cash on Delivery</option>
          <option value="QRIS">QRIS (E-Wallet)</option>
          <option value="Card">Credit/Debit Card</option>
        </select>
      </div>

      <button type="submit" class="btn-pay">
        <i class="bi bi-check2-circle"></i> Place Order
      </button>
    </form>
  </div>
</div>

</body>
</html>