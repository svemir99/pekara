<?php  require_once 'inc/header.php';


    require_once 'app/classes/User.php';


    if($user->is_logged()) {

        header("Location: index.php");
        exit();


    }






    if ($_SERVER["REQUEST_METHOD"] == "POST"){



        $username = $_POST['username'];


        $password = $_POST['password'];







        $result = $user->login( $username, $password);




        if (!$result){

          $_SESSION['message']['type'] = "danger";

            $_SESSION['message']['text'] = "Netacan username ili sifra ";

            header("Location: login.php");
            exit();

        }


        header("Location: index.php");
        exit();

        

    }









?> 



<div class="row justify-content-center">

    <div class="col-lg-5">

        <h3 class="text-center py-5">Prijavi se</h3>

        <form action="" method="POST">

            <div class="mb-3">

                <label for="username" class="form-label">Username</label>

                <input type="username" name="username" class="form-control" id="username">



            </div>

            <div class="mb-3">


              <label for="password" class="form-label">Password</label>

               <input type="password" name="password" class="form-control" id="password"> 

                
            </div>



            <button type="submit" class="btn btn-primary">Prijavi se</button>



        </form>

        <a href="register.php">Registruj se</a>



    </div>




</div>








<?php  require_once 'inc/footer.php';  ?> 