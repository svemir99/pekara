<?php
require_once '../app/config/config.php';

require_once '../app/classes/User.php';

require_once '../app/classes/Product.php';


$user = new User();

if($user->is_logged() &&  $user->is_admin()) :

    $products = new Product();
    $products = $products->fetch_all();




?>





<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>

  <div class="container">
    <a href="add_product.php" class="btn btn-success">Dodaj proizvod</a>


    <table class="table table-striped">
            <thead>
               <tr>
                   <th scope="col">Product ID</th>
                    <th scope="col">Name</th>
                   <th scope="col">Price</th>
                   
                   <th scope="col">Image</th>
                   <th scope="col">Created</th>
                   <th scope="col">Actions</th>


                </tr>



            </thead>
           <tbody>
                <?php foreach($products as $product) :?>
                   <tr>
                       <th scope="row"><?php echo $product['product_id'];  ?></th>
                       <td><?php echo $product['name']; ?></td>
                       <td><?php echo $product['price']; ?></td>
                        
                        <td><?php echo $product['image']; ?></td>
                      <td><?php echo $product['created_at']; ?></td>
                        <td>
                           
                            <a href="delete_product.php?id=<?php echo $product['product_id'];  ?>" class="btn btn-danger">Izbrisi</a>


                        </td>
                  
                    </tr>
                <?php endforeach;?>




            </tbody>





        </table>






    </div>
















   
 <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html> 

<?php endif; ?>