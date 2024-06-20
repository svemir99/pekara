<?php

class Product{
    protected $conn;
    
    public function __construct(){

        global $conn;

        $this->conn = $conn;

    }

    public function fetch_all(){
        $sql = "SELECT * FROM products";

        $result = $this->conn->query($sql);

        return $result->fetch_all(MYSQLI_ASSOC);
    }



    public function create($name, $price, $image){

        $query = "INSERT INTO products (name, price,image) VALUES (?,?,?)";

        $stmt = $this->conn->prepare($query);

        $stmt->bind_param('sss', $name, $price, $image);

        $stmt->execute();

    }








    public function read($product_id){
        $stmt = $this->conn->prepare("SELECT * FROM products WHERE product_id=?");
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();


    }




    public function update($product_id, $name, $price,$image){

        $query = "UPDATE products SET name= ?, price = ?, image = ? WHERE product_id = ?";

        $stmt = $this->conn->prepare($query);

        $stmt->bind_param('sssi', $name, $price, $image, $product_id);

        $stmt->execute();



    }



    public function delete($product_id){

        $query = "DELETE FROM products WHERE product_id = ?";

        $stmt = $this->conn->prepare($query);

        $stmt->bind_param('i',  $product_id);

        $stmt->execute();

    }
}