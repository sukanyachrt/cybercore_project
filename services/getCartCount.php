<?php
session_start();

// Check if cart session is set
if(isset($_SESSION['cart'])) {
    // Calculate total quantity of items in cart
    $cartCount = array_sum($_SESSION['cart']);
    echo $cartCount;
} else {
    echo '0';
}
?>
