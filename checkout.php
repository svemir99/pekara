<?php 

   require_once 'inc/header.php';

    require_once 'app/classes/Cart.php';


    require_once 'app/classes/Order.php';



    if(!$user->is_logged()){
       header('Location: login.php');

       exit();
    }










    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $delivery_address = $_POST['country'] .", " . $_POST['city'] .", " . $_POST['zip'] .", ". $_POST['address'];


        $order = new Order();
    
        $order= $order->create($delivery_address);
    
    
        

        $_SESSION['message']['type'] = "success";

        $_SESSION['message']['text'] = "Naruceno ";

        header("Location: orders.php");
        exit();

        
    
    
        
    
        
  
    



    


   
    }




?>





<form method="post" action="">
    <div class="form-group mb-3">
        <label for="country">Drzava</label>
        <input type="text" class="form-control" id="country" name="country" required >

    </div>

    <div class="form-group mb-3">
        <label for="city">Grad</label>
        <input type="text" class="form-control" id="city" name="city" required >

    </div>

    <div class="form-group mb-3">
        <label for="zip">Postanski broj</label>
        <input type="text" class="form-control" id="zip" name="zip" required >

    </div>

    <div class="form-group mb-3">
        <label for="address">Adresa</label>
        <input type="text" class="form-control" id="address" name="address" required >

    </div>

    <button type="submit"  class="btn btn-primary">Naruci</button>


</form>


<?php  require_once 'inc/footer.php'; ?>