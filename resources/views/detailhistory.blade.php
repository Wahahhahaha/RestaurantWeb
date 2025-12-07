<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Order #{{ $order->orderid }}</title>

</head>

    <h2 style="text-align: center;">Order Invoice</h2>
    <h4 style="text-align: center;">Order ID: <?= $order->orderid ?></h4>

<table class="invoice-table">
        <tr><td><strong>Buyer:</strong></td><td><?= $order->buyer_name ?></td></tr>
        <tr><td><strong>Courier:</strong></td><td><?= $order->courier_name ?? '-' ?></td></tr>
        <tr><td><strong>Order date:</strong></td><td><?= $order->orderdate ?></td></tr>
        <tr><td><strong>Address:</strong></td><td><?= $order->address ?></td></tr>
    </table>

    <br>
<table class="invoice-table">
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
