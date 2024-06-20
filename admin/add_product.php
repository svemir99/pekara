<?php


require_once '../app/config/config.php';

require_once '../app/classes/User.php';

require_once '../app/classes/Product.php';


$user =new User();




if($user->is_logged() && $user->is_admin()) :


    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $product = new Product();


        $name = $_POST['name'];
        $price = $_POST['price'];
       
        $image = $_POST['photo_path'];


        $product->create($name, $price, $image);

        header("Location: index.php ");
    }




    





endif;

?>

<link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css"type="text/css"/>


<form action="" method="post">

    
    <input type="text" name="name" placeholder="Product Name">
    <input type="text" name="price" step="0,01" placeholder="Product Price">
  


    
    <input type="hidden" name="photo_path" id="photoPathInput">
    <div id="dropzone-upload" class="dropzone"></div>
    <input type="submit" value="Add Product">

</form>




<script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>


<script>

    Dropzone.options.dropzoneUpload = {
        url: "upload_photo.php",
        paramName: "photo",
        maxFilesize: 20,
        acceptedtFiles: "image/*",
        init: function () {
            this.on("success", function(file,response) {
                //Parse the JSON response
                const jsonResponse = JSON.parse(response);

                //Check if the file was uploaded successfully
                if(jsonResponse.success){
                    // Set the hidden input's value to the uploaded file's path
                    document.getElementById('photoPathInput').value =jsonResponse.photo_path;
                }

                else{
                    console.error(jsonResponse.error);
                }
                
            });
        }

    };



</script>