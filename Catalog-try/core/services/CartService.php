<?php
class CartService {
    public static function ensureCart(): void {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
    }

    public static function addItem(int $productId, int $quantity, string $unit): void {
        self::ensureCart();
        if (!isset($_SESSION['cart'][$productId])) {
            $_SESSION['cart'][$productId] = [
                'quantity' => $quantity,
                'unit' => $unit,
            ];
            return;
        }
        $_SESSION['cart'][$productId]['quantity'] += $quantity;
        $_SESSION['cart'][$productId]['unit'] = $unit;
    }

    public static function removeItem(int $productId): void {
        if (isset($_SESSION['cart'][$productId])) {
            unset($_SESSION['cart'][$productId]);
        }
        if (empty($_SESSION['cart'])) {
            unset($_SESSION['cart']);
        }
    }

    public static function clear(): void {
        unset($_SESSION['cart']);
    }
}
?>
