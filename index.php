<?php  require_once 'inc/header.php' ;

   require_once 'app/classes/Product.php';

  




  $products = new Product();

  $products = $products->fetch_all();



?>


    



<h1>Tu smo za vas</h1>
<h2>Pekara Noc i Dan se ponosi višedecenijskim iskustvom u izradi hlebova, peciva, kolača i torti. Trudimo se da idemo u korak sa vremenom i željama naših potrošača, ali i da zadržimo tradicionalne vrednosti srpskog pekarstva.

           
          
           

    Svi hlebovi i peciva iz pekare Noc i dan  dobijeni su po jedinstvenoj, tradicionalnoj recepturi i od kvalitetnih mlinsko-pekarskih sirovina.
    Naša peciva se odlikuju visokim standardima u proizvodnji i ne sadrže konzervanse i aditive.
</h2>
<img src="Nagrade.jpg" class="card-img" alt="...">
    
          
   
        

        
        
          
        




   


       




 



<div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="hleba.jpg" class="d-block w-100" alt="...">
        </div>
        <div class="carousel-item">
            <img src="Kolaci3.jpg" class="d-block w-100" alt="...">
        </div>
        <div class="carousel-item">
            <img src="makarone.jpg" class="d-block w-100" alt="...">
        </div>
        <div class="carousel-item">
            <img src="hleba.jpg" class="d-block w-100" alt="...">
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>











<div class="row">

    <?php foreach ($products as $product)  :  ?>

        <div class="col-md-3">

            <div class="card">
                <img src="public/product_image/<?php echo $product['image']; ?>" class="card-img-top" alt="<?php echo $product['name']; ?>">


                <div class="card-body">

                   
                  <h5 class="card-title"><?php echo $product['name'] ?></h5>
                    

                    <p class="card-text">Cena: <?php echo $product['price'] ?></p>


                    <a href="proizvodi.php?product_id= <?php echo $product['product_id']  ?>" class="btn btn-primary ">View Product</a>

            
            
                </div>


            </div>
        </div>

    <?php endforeach; ?>





</div>






      
       




     















<div class="card-group">
    <div class="card">
        <img src="kucevo.jpg" class="card-img-top" alt="...">
       <div class="card-body">
            <h5 class="card-title">Kučevo: Svetog Save 140</h5>
            <p>Radno Vreme</p>
            <p>Ponedeljak-Petak:   06-20</p>
            <p>Subota:   06-17</>
            <p>Nedelja:  07-15</p>
            
        </div>
          
    </div>
    <div class="card">
        <img src="kosovska.jpg" class="card-img-top" alt="...">
      <div class="card-body">
            <h5 class="card-title"> Požarevac: Kosovska 75</h5>
            <p>Radno Vreme</p>
            <p>Ponedeljak-Petak: 06-20</p>
            <p>Subota:  06-16</p>
            <p>Nedelja: Zatvoreno</p>
          
        </div>
          
    </div>
    <div class="card">
        <img src="Lucicki put.jpg" class="card-img-top" alt="...">
       <div class="card-body">
            <h5 class="card-title"> Požarevac, Lučički put 27. aprila broj 18</h5>
            <p>Radno Vreme</p>
            <p>Ponedeljak-Petak: 05:30-20</p>
            <p>Subota:   05:30-18</p>
            <p>Nedelja: 05:30-16</p>
                
            
        </div>
         
     </div>
</div>















      














<?php require_once 'inc/footer.php'; ?>