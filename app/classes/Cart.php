<?php

class Cart{ protected $conn;
    
    public function __construct(){

        global $conn;

        $this->conn = $conn;

    }



    public function add_to_cart($product_id, $user_id, $quantity){


        $stmt = $this->conn->prepare("INSERT INTO cart (user_id, product_id,quantity) VALUES (?,?,?)");

        $stmt->bind_param("iis", $user_id, $product_id, $quantity);

        $stmt->execute();



    }




    public function get_cart_items($user_id) {
        $stmt = $this->conn->prepare("SELECT p.product_id, p.name, p.price, p.image, c.quantity FROM cart c INNER JOIN products p ON c.product_id = p.product_id WHERE c.user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $cart_items = [];
        while ($row = $result->fetch_assoc()) {
            $cart_items[] = $row;
        }

        $stmt->close();
        return $cart_items;
    }

    public function removeFromCart($product_id,$user_id) {
        $stmt = $this->conn->prepare("DELETE FROM cart WHERE product_id = ? AND user_id = ?");
        $stmt->bind_param("ii", $product_id, $user_id);
        $result = $stmt->execute();
        $stmt->close();

        return $result;
    }






    public function destroy_cart($user_id) {
        $stmt = $this->conn->prepare("DELETE FROM cart WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        // Dodajte dodatnu logiku ako je potrebno
    }


}