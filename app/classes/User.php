<?php





class User {


    protected $conn;
    public function __construct(){

        global $conn;

        $this->conn = $conn;


    }

    public function create($name, $username, $email, $password){

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);


        $sql = "INSERT INTO users (name,username,email,password) VALUES  (?, ?, ?, ?)";

       $stmt = $this->conn->prepare($sql);


        $stmt->bind_param("ssss", $name, $username, $email, $hashed_password);


        $result = $stmt->execute();


        if($result){

            $_SESSION['user_id'] = $result->insert_id;

            return true;


        }

        else{

            return false;
        }



    }


    public function login($username, $password){

        $sql = "SELECT user_id,password FROM users WHERE username = ?";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param("s", $username);

        $stmt->execute();



        $results = $stmt->get_result();


        if($results->num_rows == 1){

            $user = $results->fetch_assoc();




            if(password_verify($password, $user['password'])){

                $_SESSION['user_id'] = $user['user_id'];


                return true;


            }

        }

        return false;

    }




    public function is_logged(){


        if(isset($_SESSION['user_id'])){

            return true;
        }


        return false;



    }



    










        





    public function get_id() {
        if ($this->is_logged()) {
            return $_SESSION['user_id'];
        }
        return null;
    }
















    public function is_admin(){
        $query= "SELECT * FROM users WHERE user_id = ? AND is_admin = 1";

        $stmt = $this->conn->prepare($query);

        $stmt->bind_param('i', $_SESSION['user_id']);

        $stmt->execute();

        $result = $stmt->get_result();


        if($result->num_rows > 0){
            return true;
        }
        return false;


    }






   

    
    







    public function logout(){

        unset($_SESSION['user_id']);
    }

    
}