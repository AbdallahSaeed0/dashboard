<?php
include_once "../shared/head.php";
include_once "../core/config.php";

if(isset($_POST["login"])){
  $email = $_POST["email"];
  $password = $_POST["password"];

  $select = "SELECT * FROM users WHERE email = '$email'";
  $s= mysqli_query($connect, $select);
  $num_rows = mysqli_num_rows($s);
  if($num_rows == 1){
    $data= mysqli_fetch_assoc($s);
    $hash_password_from_database = $data["password"];
    $ifpasswordtrue = password_verify($password, $hash_password_from_database);
    if($ifpasswordtrue){
      setcookie("isAdmin", $email, time() + 86400 * 360, '/');
      $_SESSION['admin'] =[
        'id' => $data['id'],
        'email' => $email,
        'name' => $data['name'],
        'rule_id' => $data['rule_id'],
        'image' => $data['image']
      ];
      redirect('');
      
      
    }else{
      $_SESSION['message'] = "wrong password";
      redirect('pages/login.php');
      exit();
    }
  }else{
    $_SESSION['message'] = "wrong email";
    redirect('pages/login.php');
    exit();
  }

}

?>


<main>
    <div class="container">

      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

              <div class="d-flex justify-content-center py-4">
                <a href="index.html" class="logo d-flex align-items-center w-auto">
                  <img src="assets/img/logo.png" alt="">
                  <span class="d-none d-lg-block">NiceAdmin</span>
                </a>
              </div><!-- End Logo -->
              

              <div class="card mb-3">

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

                <div class="card-body">

                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Login to Your Account</h5>
                    <p class="text-center small">Enter your email & password to login</p>
                  </div>

                  <form class="row g-3 needs-validation" method="post">

                    <div class="col-12">
                      <label class="form-label">Email</label>
                      <div class="input-group has-validation">
                        <span class="input-group-text" id="inputGroupPrepend">@</span>
                        <input type="text" name="email" class="form-control" required>
                        <div class="invalid-feedback">Please enter your username.</div>
                      </div>
                    </div>

                    <div class="col-12">
                      <label for="yourPassword" class="form-label">Password</label>
                      <input type="password" name="password" class="form-control" id="yourPassword" required>
                      <div class="invalid-feedback">Please enter your password!</div>
                    </div>

                    <div class="col-12">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" value="true" id="rememberMe">
                        <label class="form-check-label" for="rememberMe">Remember me</label>
                      </div>
                    </div>
                    <div class="col-12">
                      <button class="btn btn-primary w-100" name="login" type="submit">Login</button>
                    </div>
                    <div class="col-12">
                      <p class="small mb-0">Don't have account? <a href="<?= url("/pages/register.php")?>">Create an account</a></p>
                    </div>
                  </form>

                </div>
              </div>


            </div>
          </div>
        </div>

      </section>

    </div>
  </main><!-- End #main -->


<?php
include_once "../shared/script.php";
?>