<?php
include_once "../core/functions.php";
include_once "../core/config.php";

$profile_id = $_SESSION['admin']['id'];
$id= $_SESSION['admin']['id'];
$select = "SELECT * FROM users WHERE id = $profile_id";
$s= mysqli_query($connect, $select);
$data= mysqli_fetch_assoc($s);
$num_rows = 0; 
if(isset($_POST['update'])){
    $name= $_POST['fullName'];
    $email = $_POST['email'];

    if($data['email'] !=$email){
        $select = "SELECT * FROM users WHERE email = '$email'";
        $s= mysqli_query($connect, $select);
        $num_rows = mysqli_num_rows($s);
    }
  
    if($num_rows > 0){
       $_SESSION['message'] = "this email already being used";
       redirect('pages/profile.php');
    }else{
        if (empty($_FILES['image']['name'])){
            $image_name=$data ['image'];
        }else{
            $old_image = $data['image'];
    
            if($old_image != 'def.jpg'){
                unlink("../app/users/upload/$old_image");
            }
            $image_name= time() . $_FILES['image']['name'];
            $_SESSION['admin']['image'] = $image_name;
            $tmp_name= $_FILES['image']['tmp_name'];
            $location= "../app/users/upload/$image_name";
            move_uploaded_file($tmp_name,$location);
        }
        $_SESSION['admin']['name']= $name;
        $update= "UPDATE users Set name = '$name',email ='$email', image= '$image_name'  where id =$profile_id";
        $u = mysqli_query($connect, $update);
          redirect("pages/profile.php");
    }


}

if(isset($_POST["change_password"])){
    
$current_password = $_POST["password"];
    $new_password = $_POST["newpassword"];
    $confirm_password = $_POST["renewpassword"];
    $database_password = $data['password'];
    $istrue = password_verify($current_password,$database_password);
    
    if($istrue){

        if($new_password == $confirm_password){
            $new_hash_password = password_hash($new_password, PASSWORD_DEFAULT);
            $update= "UPDATE users Set password = '$new_hash_password'  where id =$profile_id";
            $u = mysqli_query($connect, $update);
            $_SESSION['message'] = "Password changed";
            redirect("pages/profile.php");
        }else{
            $_SESSION['message'] = "Wrong confirm password";
            redirect("pages/profile.php");
        }
    }else{
        $_SESSION['message'] = "Wrong current password";
        redirect("pages/profile.php");
    }
}

?>