
  <title>Cart — Chick Chi</title>

  <style>

    body {
      font-family: 'Inter', sans-serif;
      background-color: var(--beige);
      color: var(--brown);
      line-height: 1.6;
      padding-top: 80px; 
    }

    .main-container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 20px 60px;
    }

    .btn-delete {
      background: none;
      border: none;
      color: #a65a5a;
      font-size: 14px;
      font-weight: 600;
      cursor: pointer;
      padding: 6px 12px;
      border-radius: 8px;
      transition: all 0.2s;
    }

    .btn-delete:hover {
      background: #fff0ed;
      color: #9a4a4a;
    }

    }
  </style>
</head>
<body>

<div class="main-container">
  <div class="page-header">
    <h1 class="page-title">Your Cart</h1>
    <a href="/home" class="btn-back">
      <i class="bi bi-arrow-left"></i> Back to Menu
    </a>
  </div>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  @if(count($cart) > 0)
    <div class="cart-card">
      <form action="/checkout" method="post">
        @csrf

        <table class="cart-table">
          <thead>
            <tr>
              <th>
                <input type="checkbox" id="selectAll" class="table-checkbox">
              </th>
              <th>Menu</th>
              <th>Price</th>
              <th>Qty</th>
              <th>Total</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @php $grandtotal = 0; @endphp
            @foreach($cart as $id => $item)
              @php $total = $item['price'] * $item['quantity']; @endphp
              <tr>
                <td data-label="Select">
                  <input type="checkbox" name="selected[]" value="{{ $id }}" class="itemCheckbox table-checkbox" checked>
                </td>
                <td data-label="Menu">
                  <div class="menu-name">{{ htmlspecialchars($item['menuname']) }}</div>
                </td>
                <td data-label="Price" class="price">Rp {{ number_format($item['price'], 0, ',', '.') }}</td>
                <td data-label="Qty" class="qty">{{ $item['quantity'] }}</td>
                <td data-label="Total" class="total">Rp {{ number_format($total, 0, ',', '.') }}</td>
                <td data-label="Action">
                  <a href="/removecart/{{ $id }}" class="btn-delete" title="Remove">
                    <i class="bi bi-trash"></i> Remove
                  </a>
                </td>
              </tr>
              @php $grandtotal += $total; @endphp
            @endforeach
          </tbody>
        </table>

        <div class="cart-summary">
          <div class="summary-text">
            Total: <strong>Rp {{ number_format($grandtotal, 0, ',', '.') }}</strong>
          </div>
          <button type="submit" class="btn-checkout">
            Proceed to Checkout
          </button>
        </div>
      </form>
    </div>
  @else
    <div class="cart-card">
      <div class="alert alert-info">
        Your cart is empty. <a href="/menu" style="color: var(--warm-beige); text-decoration: underline;">Browse our menu</a>
      </div>
    </div>
  @endif
</div>

<script>
document.getElementById('selectAll').addEventListener('change', function() {
  const checked = this.checked;
  document.querySelectorAll('.itemCheckbox').forEach(cb => cb.checked = checked);
});
</script>
