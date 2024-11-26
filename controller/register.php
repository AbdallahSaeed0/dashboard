<?php
include_once "../core/config.php";
include_once "../core/functions.php";

if(isset($_POST['send'])){

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $hash_password = password_hash($password, PASSWORD_DEFAULT);
    $select = "SELECT * FROM users WHERE email = '$email'";
    $s= mysqli_query($connect, $select);
    $num_rows = mysqli_num_rows($s);
    
    if($num_rows > 0){
       $_SESSION['message'] = "this email already being used";
       redirect('pages/register.php');
    }else{
        if (empty($_FILES['image']['name'])){
            $image_name="def.jpg";
        }else{
            $image_name= time() . $_FILES['image']['name'];
            $tmp_name= $_FILES['image']['tmp_name'];
            $location= "../app/users/upload/$image_name";
            move_uploaded_file($tmp_name,$location);
            
        }
        $insert= "INSERT INTO users (name, email, password, image) VALUES ('$name','$email','$hash_password','$image_name')";
        $i = mysqli_query($connect,$insert);
        redirect('pages/login.php');
    }
    
    
    
}

?>
