<?php
$cart_items = [];

if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $product_id => $item) {
        if (is_array($item)) {
            $quantity = $item['quantity'];
            $unit     = $item['unit'];
        } else {
            $quantity = $item;
            $unit     = 'ue';
        }

        $product = PostData::getById($product_id);
        if ($product) {
            $cart_items[] = [
                'id'       => $product->id,
                'code'     => $product->code,
                'name'     => $product->name,
                'quantity' => $quantity,
                'unit'     => $unit,
            ];
        }
    }
}
?>

<h2>Shopping Cart</h2>

<?php if (!empty($cart_items)): ?>
    <table class="table">
        <thead>
            <tr>
                <th>Part code</th>
                <th>Name</th>
                <th>Quantity</th>
                <th>Measure type</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($cart_items as $item): ?>
            <tr>
                <td><?php echo htmlspecialchars($item['code']); ?></td>
                <td><?php echo htmlspecialchars($item['name']); ?></td>
                <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                <td><?php echo htmlspecialchars($item['unit']); ?></td>
                <td>
                    <a href="api/legacy/cart-remove.php?id=<?php echo $item['id']; ?>" class="btn btn-danger btn-xs">
                        Delete
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <a href="api/legacy/cart-export.php?format=csv" class="btn btn-info" target="_blank">
        Export to CSV
    </a>
    <a href="api/legacy/cart-export.php?format=pdf" class="btn btn-warning" target="_blank">
        Export to PDF
    </a>
    <a href="api/legacy/cart-export.php?format=excel" class="btn btn-success" target="_blank">
        Export to Excel
    </a>

    <form action="api/legacy/cart-checkout.php" method="POST" style="display:inline;">
        <button type="submit" class="btn btn-primary">End shop</button>
    </form>
<?php else: ?>
    <div class="alert alert-warning">Your cart is empty.</div>
<?php endif; ?>
