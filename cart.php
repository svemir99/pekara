<?php
require_once 'inc/header.php';
require_once 'vendor/autoload.php'; // Uključite Composer autoload fajl
require_once 'app/classes/OrderMailer.php';
require_once 'app/config/config.php';
require_once 'app/classes/Cart.php';
require_once 'app/classes/Order.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (!$user->is_logged()) {
    header('Location: login.php');
    exit();
}

$user_id = $user->get_id(); // Koristi novu metodu get_id() iz User klase

// Proverite da li je $conn definisan
if (!isset($conn)) {
    die("Connection to the database failed.");
}

$cart = new Cart;
$cart_items = $cart->get_cart_items($user_id);

// Funkcija za izračunavanje ukupne cene
function calculateTotalPrice($cart_items) {
    $total_price = 0;

    foreach ($cart_items as $item) {
        $price = floatval($item['price']);
        $quantity = intval($item['quantity']);
        $total_price += $price * $quantity;
    }

    return $total_price;
}

$total_price = calculateTotalPrice($cart_items);

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Proverite da li ključ 'address' postoji u nizu $_POST pre nego što mu pristupite
    if (isset($_POST['country'], $_POST['city'], $_POST['zip'], $_POST['address'])) {
        $delivery_address = $_POST['country'] . ", " . $_POST['city'] . ", " . $_POST['zip'] . ", " . $_POST['address'];
    } else {
        // Rukujte greškom ako neki ključ ne postoji
        die("Sva polja za adresu moraju biti popunjena.");
    }

    $order = new Order;
    $order_id = $order->create($delivery_address); // Dodeljujemo vrednost $order_id koju dobijamo iz funkcije create()

    // Priprema detalja narudžbine
    $orderDetails = "Narudžbina ID: " . $order_id . "<br>Ukupna cena: " . $total_price . " Dinara<br>Adresa dostave: " . $delivery_address;

    // Slanje e-maila dobavljaču sa detaljima narudžbine
    $supplierEmail = 'ssasasaska@gmail.com'; // E-mail dobavljača
    $orderMailer = new OrderMailer();
    $result = $orderMailer->sendOrderEmail($supplierEmail, $orderDetails);

    if ($result) {
        $_SESSION['message']['type'] = "success";
        $_SESSION['message']['text'] = "Narudžbina uspešno poslata. E-mail je uspešno poslat dobavljaču.";
    } else {
        $_SESSION['message']['type'] = "error";
        $_SESSION['message']['text'] = "Narudžbina uspešno poslata. Došlo je do greške prilikom slanja e-maila.";
    }

    exit();
}
?>

<form method="post" action="">
    <table id="cart-table" class="table table-striped">
        <thead>
            <tr>
                <th scope="col">Naziv Proizvoda</th>
                <th scope="col">Cena</th>
                <th scope="col">Količina</th>
                <th scope="col">Slika</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($cart_items) && is_array($cart_items)): ?>
                <?php foreach ($cart_items as $item): ?>
                    <tr id="row-<?php echo htmlspecialchars($item['product_id']); ?>">
                        <td><?php echo htmlspecialchars($item['name']); ?></td>
                        <td class="price"><?php echo htmlspecialchars($item['price']); ?> </td>
                        <td class="quantity"><?php echo htmlspecialchars($item['quantity']); ?></td>
                        <td><img src="public/product_image/<?php echo htmlspecialchars($item['image']); ?>" height="50"></td>
                        <td>
                            <button type="button" onclick="deleteItem(<?php echo htmlspecialchars($item['product_id']); ?>)">Obriši</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">Korpa je prazna.</td>
                </tr>
            <?php endif; ?>
            <tr>
                <td colspan="4" align="right"><strong>Ukupna cena:</strong></td>
                <td><strong id="total-price"><?php echo number_format($total_price, 2); ?> Dinara</strong></td>
            </tr>
        </tbody>
    </table>

    <div class="form-group mb-3">
        <label for="country">Država</label>
        <input type="text" class="form-control" id="country" name="country" required>
    </div>
    <div class="form-group mb-3">
        <label for="city">Grad</label>
        <input type="text" class="form-control" id="city" name="city" required>
    </div>
    <div class="form-group mb-3">
        <label for="zip">Poštanski broj</label>
        <input type="text" class="form-control" id="zip" name="zip" required>
    </div>
    <div class="form-group mb-3">
        <label for="address">Adresa</label>
        <input type="text" class="form-control" id="address" name="address" required>
    </div>
    <button type="submit" class="btn btn-primary">Naruči</button>
</form>

<script>
function deleteItem(product_id) {
    if (confirm("Da li ste sigurni da želite da obrišete ovaj proizvod?")) {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "delete_order.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.onload = function() {
            if (xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);
                if (response.success) {
                    var cartItems = response.cart_items;

                    // Ažurirajte prikaz korpe na osnovu novih podataka
                    updateCartView(cartItems);

                    alert("Proizvod uspešno obrisan.");
                } else {
                    alert("Došlo je do greške prilikom brisanja proizvoda: " + response.error);
                }
            } else {
                alert("Došlo je do greške prilikom komunikacije sa serverom.");
            }
        };
        xhr.send("product_id=" + encodeURIComponent(product_id));
    }
}
</script>

<?php require_once 'inc/footer.php'; ?>