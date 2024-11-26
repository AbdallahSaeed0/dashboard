<?php
session_start();

define("BASE_URL","http://localhost/admin-dashboard/");

function url($var = null) {
    return BASE_URL . $var;
};

function redirect($var = null) {
    echo"<script>
    window.location.replace('http://localhost/admin-dashboard/$var')
    </script>";
    
};

function filtervalidtion($input){
$input = ltrim($input);
$input = rtrim($input);
$input = strip_tags($input);
$input = stripcslashes($input);
$input = htmlspecialchars($input);
return $input;
};
function stringvalidtion($input, $max_len= 20, $min_len = 20){
    $is_empty = empty($input);
    $is_max_eror = strlen($input) > $max_len;
    $is_min_eror = strlen($input) < $max_len;
    if($is_empty || $is_max_eror || $is_min_eror){
        return true;
    }else{
return false;
    }
}

function auth($rule2 = null, $rule3 = null) {
        if (!isset($_SESSION['admin'])) {
            redirect('pages/login.php');
            exit();
        }
        $rule = $_SESSION['admin']['rule_id'];
        if ($rule == 1 || $rule == $rule2 || $rule == $rule3) {
            return; 
        }
        redirect('pages/error404.php');
        exit();
}
    

    

if(isset($_POST['delete_message'])){
    $old_path =$_POST["old_path"];
    unset($_SESSION['message']);
    echo"<script>
    window.location.replace('$old_path')
    </script>";
}



if(isset($_GET['logout'])){
    setcookie("isAdmin", "anyvalue", time() - 360, '/');
    session_unset();
    session_destroy();
    redirect("pages/login.php");
}

?>

