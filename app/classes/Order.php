<?php

require_once 'app/classes/Cart.php';

class Order extends Cart {
    protected $conn;
    
    public function __construct(){
        global $conn;
        $this->conn = $conn;
    }

    public function create($delivery_address) {
        try {
            $this->conn->begin_transaction();

            // Insert into orders table
            $stmt = $this->conn->prepare("INSERT INTO orders (user_id, delivery_address) VALUES (?, ?)");
            $user_id = $_SESSION['user_id']; // Pretpostavka da je user_id dostupan u sesiji
            $stmt->bind_param("is", $user_id, $delivery_address);
            $stmt->execute();
            $order_id = $this->conn->insert_id;

            // Insert into order_items table
            $cart = new Cart();
            $cart_items = $cart->get_cart_items($user_id);
            $stmt = $this->conn->prepare("INSERT INTO order_items (order_id, product_id, quantity) VALUES (?, ?, ?)");

            foreach ($cart_items as $item) {
                $product_id = $item['product_id'];
                $quantity = $item['quantity'];
                $stmt->bind_param("iii", $order_id, $product_id, $quantity);
                $stmt->execute();
            }

            // Clear the cart after creating the order
            $cart->destroy_cart($user_id);

            $stmt->close();

            $this->conn->commit();

            return $order_id;
        } catch (Exception $e) {
            $this->conn->rollback();
            error_log("Error creating order: " . $e->getMessage());
            return false;
        }
    }

    public function get_orders(){
        $user_id = $_SESSION['user_id'];

        $sql = " SELECT
            orders.order_id,
            orders.delivery_address,
            orders.created_at,
            order_items.quantity,
            proizvodi.name,
            proizvodi.image,
            proizvodi.price
           FROM orders
           INNER JOIN order_items ON orders.order_id = order_items.order_id
           INNER JOIN proizvodi ON order_items.product_id = proizvodi.product_id
          WHERE orders.user_id = ?
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();

        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function delete($order_id){
        try {
            $stmt = $this->conn->prepare("DELETE FROM orders WHERE order_id = ?");
            $stmt->bind_param('i',  $order_id);
            $stmt->execute();
            $stmt->close();
            return true;
        } catch (Exception $e) {
            error_log("Error deleting order: " . $e->getMessage());
            return false;
        }
    }

    public function sendOrderToSupplier($delivery_address, $products) {
        $product_list = '';
        foreach ($products as $product) {
            $product_list .= $product['name'] . " - " . $product['quantity'] . " kom, ";
        }
        $product_list = rtrim($product_list, ', ');

        $to = "ssasasaska@gmail.com"; // Email adresa dobavljača
        $subject = "Nova narudžbina";
        $message = "Adresa dostave: $delivery_address\nProizvodi:\n$product_list";
        $headers = "From: patofnak@gmail.com"; // Vaša email adresa

        // Slanje emaila
        if (mail($to, $subject, $message, $headers)) {
            return true;
        } else {
            return false;
        }
    }
}

?>