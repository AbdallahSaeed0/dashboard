<?php
include_once "../../shared/head.php";
include_once "../../shared/header.php";
include_once "../../shared/aside.php";
include_once "../../core/functions.php";
include_once "../../core/config.php";
auth();

$select ="SELECT * FROM rules";
$rules = mysqli_query($connect, $select);

$profile_id = $_SESSION['admin']['id'];
$validtion_error= [];
if(isset($_POST['send'])){
  $name = filtervalidtion($_POST['name']);
  $email = filtervalidtion($_POST['email']);
  $rule = filtervalidtion($_POST['rule_id']);
  $password = "12345678";

  if(stringvalidtion($name)){
    $validtion_error[]= "validtion error min is 3 and max is 20";
  }

  $hash_password = password_hash($password, PASSWORD_DEFAULT);
  $select = "SELECT * FROM users WHERE email = '$email'";
  $s= mysqli_query($connect, $select);
  $num_rows = mysqli_num_rows($s);
  
  if($num_rows > 0){
     $_SESSION['message'] = "this email already being used";
     redirect('app/users/create.php');
     exit();
  }else{
        if (empty($_FILES['image']['name'])){
          $image_name="def.jpg";
      }else{
          $image_name= time() . $_FILES['image']['name'];
          $tmp_name= $_FILES['image']['tmp_name'];
          $location= "../app/users/upload/$image_name";
          move_uploaded_file($tmp_name,$location);
          
      }

      if(empty($validtion_error)){
        $insert= "INSERT INTO users VALUES (null ,'$name','$email','$hash_password','$image_name', $profile_id, $rule)";
        $_SESSION['message'] = "Emaill added";
        $i = mysqli_query($connect,$insert);
        redirect('app/users/create.php');
        exit();
      }


  }
}

?>


<main id="main" class="main">

<div class="card">

            <div class="card-body">
              <h5 class="card-title">Create Admin</h5>
              <?php if(isset($_SESSION['message'])): ?>

              <div id="alert_message" class="alert alert-danger alert-dismissible fade show" role="alert">
              <?= $_SESSION['message']?>
              <form method="post" action="<?php url('core/functions.php') ?>">
              <input type="hidden" name="old_path" value="<?='http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] ?>">
              <button type="submit" class="btn-close" name="delete_message" aria-label="Close"></button>
              </form>
              </div>
              <?php unset($_SESSION['message']); ?>
              <?php endif; ?>
              <?php if(!empty($validtion_error)):?>
                <div class="alert alert-danger">
                  <?php foreach($validtion_error as $eror): ?>
                    <h3><?= $eror ?></h3>
                    <?php endforeach; ?>
                </div>
              <?php endif; ?>
              <!-- Vertical Form -->
              <form class="row g-3" method="post" enctype="multipart/form-data">
                <div class="col-12">
                  <label for="inputNanme4" class="form-label">Your Name</label>
                  <input type="text" class="form-control" name="name" id="inputNanme4">
                </div>
                <div class="col-12">
                  <label for="inputEmail4" class="form-label">Email</label>
                  <input type="email" class="form-control" name="email" id="inputEmail4">
                </div>
                <div class="col-12">
                      <label for="yourUsername" class="form-label">Image</label>
                      <div class="input-group has-validation">
                        <input type="file" name="image" class=" btn btn-info form-control" accept="image/*">
                      </div>
                    </div>
                <div class="col-12">
                  <select name="rule_id" class="form-control">
                    <option selected disabled value=""> -- Select rule --</option>
                    <?php foreach($rules as $item): ?>
                    <option value="<?php echo $item['id'];?>"><?php echo $item['description'];?></option>
                    <?php endforeach;?>
                  </select>
                </div>
                <div class="text-center">
                  <button type="submit" name="send" class="btn btn-primary">Submit</button>
                  <button type="reset" class="btn btn-secondary">Reset</button>
                </div>
              </form><!-- Vertical Form -->

            </div>
          </div>

</main><!-- End #main -->



<?php
include_once "../../shared/footer.php";
include_once "../../shared/script.php";
?>