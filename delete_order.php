<?php
session_start();
require_once 'app/config/config.php';
require_once 'app/classes/Cart.php';

$response = ['success' => false];

// Provera konekcije sa bazom podataka
if ($conn->connect_error) {
    $response['error'] = "Connection failed: " . $conn->connect_error;
    echo json_encode($response);
    exit;
}

// Provera postojanja product_id i user_id
$product_id = isset($_POST['product_id']) ? $_POST['product_id'] : null;
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

if (!$product_id || !$user_id) {
    $response['error'] = "Nedostaje product_id ili user_id u zahtevu.";
    echo json_encode($response);
    exit;
}

// Uklanjanje proizvoda iz korpe
$cart = new Cart();
$result = $cart->removeFromCart($product_id, $user_id);

if ($result) {
    $response['success'] = true;

    // Uklonite stavku iz $_SESSION['cart_items']
    if (isset($_SESSION['cart_items'])) {
        foreach ($_SESSION['cart_items'] as $key => $item) {
            if ($item['product_id'] == $product_id) {
                unset($_SESSION['cart_items'][$key]);
                break; // Prekinite petlju nakon brisanja prvog podudaranja
            }
        }
    }

    // Vratite ažuriranu listu stavki korpe
    $cart_items = $cart->get_cart_items($user_id); // Ažurirana lista

    $response['cart_items'] = $cart_items; // Dodajte ažuriranu listu u odgovor
} else {
    $response['error'] = "Greška prilikom brisanja proizvoda iz baze podataka.";
}

echo json_encode($response);
exit;
?>