<?php
include_once "../../shared/head.php";
include_once "../../shared/header.php";
include_once "../../shared/aside.php";
include_once "../../core/functions.php";
include_once "../../core/config.php";
auth();

if(isset($_GET['view'])){
  $id = $_GET['view'];
  $select = "SELECT * FROM user_data where id = $id";
  $data= mysqli_query($connect, $select);
  $row=mysqli_fetch_assoc($data);
}

?>


<main id="main" class="main">

<div class="card">

            <div class="card-body">
              <h5 class="card-title">Profile Details</h5>
              <img src="<?= url("app/users/upload/").$row['image']?>" class="img-fluid" width="400px" alt="">
              <div class="row">
                
                <div class="col-lg-3 col-md-4 label ">Full Name</div>
                <div class="col-lg-9 col-md-8"><?= $row['user_name']?></div>
              </div>

              <div class="row">
                <div class="col-lg-3 col-md-4 label">Email</div>
                <div class="col-lg-9 col-md-8"><?= $row['email']?></div>
              </div>
              <?php if ($row['created_by_id'] != null):?>
              <div class="row">
                <div class="col-lg-3 col-md-4 label">Created by</div>
                <div class="col-lg-9 col-md-8"><a href="./view.php?view=<?= $row['created_by_id']?> "><?= $row['created_by']?></a> </div>
              </div>
              <?php else:?>
                <div class="row">
                <div class="col-lg-3 col-md-4 label">rule</div>
                <div class="col-lg-9 col-md-8 text-success">Super admin</div>
                </div>
                
                <?php endif; ?>
              <div class="row">
                <div class="col-lg-3 col-md-4 label">rule number</div>
                <div class="col-lg-9 col-md-8"><?= $row['rule_number']?></div>
              </div>
              <div class="row">
                <div class="col-lg-3 col-md-4 label">description</div>
                <div class="col-lg-9 col-md-8"><?= $row['description']?></div>
              </div>



            </div>
          </div>

</main><!-- End #main -->



<?php
include_once "../../shared/footer.php";
include_once "../../shared/script.php";
?>