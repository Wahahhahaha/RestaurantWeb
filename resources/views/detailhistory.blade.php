<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Order #{{ $order->orderid }}</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        h2, h4 { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #333; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .no-border td { border: none; }
        }
    </style>
</head>

    <h2>Order Invoice</h2>
    <h4>Order ID: <?= $order->orderid ?></h4>

    <table class="no-border">
        <tr><td><strong>Buyer:</strong></td><td><?= $order->buyer_name ?></td></tr>
        <tr><td><strong>Courier:</strong></td><td><?= $order->courier_name ?? '-' ?></td></tr>
        <tr><td><strong>Order date:</strong></td><td><?= $order->orderdate ?></td></tr>
        <tr><td><strong>Address:</strong></td><td><?= $order->address ?></td></tr>
    </table>

    <br>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Menu name</th>
                <th>Qty</th>
                <th>Price</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php  $no = 1; $grandTotal = 0;
            foreach($details as $item) { ?>
                <?php
                    $total = $item->orderpcs * $item->pcsprice;
                    $grandTotal += $total;
                ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $item->menuname ?? $item->name ?? '-' ?></td>
                    <td><?= $item->orderpcs ?></td>
                    <td>Rp <?= number_format($item->pcsprice, 0, ',', '.') ?></td>
                    <td>Rp <?= number_format($total, 0, ',', '.') ?></td>
                </tr>
            <?php } ?>
            <tr>
                <th colspan="4" style="text-align:right;">Grand Total</th>
                <th>Rp <?= number_format($grandTotal, 0, ',', '.') ?></th>
            </tr>
        </tbody>
    </table>

</body>
</html>
