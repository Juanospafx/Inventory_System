<?php
if (!Session::issetUID()) {
    header('Location: login.php');
    exit;
}

if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "<script>alert('El carrito esta vacio.'); window.location='index.php?view=cart';</script>";
    exit;
}
?>

<div class="container">
    <div class="row">
        <div class="col-md-6 offset-md-3 text-center mt-5">
            <h2 class="mb-4">Confirmar Compra</h2>
            <p>Esta seguro de que deseas finalizar la compra?</p>

            <form action="api/legacy/cart-checkout.php" method="POST">
                <button type="submit" class="btn btn-success btn-lg">Si, finalizar compra</button>
            </form>

            <a href="index.php?view=cart" class="btn btn-secondary mt-3">Volver al carrito</a>
        </div>
    </div>
</div>
