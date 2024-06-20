<?php
require_once 'app/config/config.php';  


  require_once 'app/classes/User.php';


  $user = new User();
?>



<!DOCTYPE html>
<html>
    <head>

        <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">




      <link rel="stylesheet" href="public/css/style.css">

      <title>Pekara</title>

      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">


    </head>
<body>


    <div class="container">


        <nav class="navbar navbar-expand-sm  navbar-dark" id="meni">


            <?php if(isset($_SESSION['message']))  : ?>



                <div class= "alert alert-<?php echo $_SESSION['message']['type']; ?> alert-dismissible fade show " role="alert">

                    <?php

                       echo $_SESSION['message']['text'];

                        unset($_SESSION['message']);

                    ?>

 



                </div>


            <?php endif; ?>
            <div class="container-fluid">

                <ul class="navbar-nav">
                  <li class="nav-item ">
                      <img src="logo.jpg" alt="logo">
                  </li>
                   
                     
                    <li class="nav-item meni">
                        <a class="nav-link active " href="index.php" id="tekstmeni">Naslovna</a>

                    </li>
                      
                   

                    <li class="nav-item meni">
                        <a class="nav-link active " href="onama.php" id="tekstmeni">O nama</a>
                        
                    </li> 


                    <?php if(!$user->is_logged()) :   ?>


                        <li class="nav-item meni">
                            <a class="nav-link  active" href="register.php" id="tekstmeni">Registruj se</a>
                        
                        </li> 

                        <li class="nav-item meni">
                            <a class="nav-link active " href="login.php" id="tekstmeni">Prijavi se</a>
                        
                        </li> 


                    <?php else : ?>


                        <li class="nav-item meni">

                            <a class="nav-link active" href="cart.php" id="tekstmeni">

                              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart" viewBox="0 0 16 16">

                              <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M3.102 4l1.313 7h8.17l1.313-7zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>

                                <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M3.102 4l1.313 7h8.17l1.313-7zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>

                                </svg>Plati



                            </a>


                        </li>




                        <li class="nav-item meni">

                            <a class="nav-link active" href="orders.php" id="tekstmeni">Moja narudzbina</a>


                        </li>

                        <li class="nav-item meni">

                          <a class="nav-link active" href="logout.php" id="tekstmeni">Odjava</a>

                        </li>



                    <?php endif; ?> 



                     

      
                </ul>
          </div>
       </nav>