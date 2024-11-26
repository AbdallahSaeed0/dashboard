<?php
include_once "../../shared/head.php";
include_once "../../shared/header.php";
include_once "../../shared/aside.php";
include_once "../../core/config.php";
auth(2,3);

$select = "SELECT * FROM users";
$data= mysqli_query($connect, $select);

if(isset($_GET['delete'])){
  $id = $_GET['delete'];
  $delete = "DELETE FROM users where id = $id";
  $data= mysqli_query($connect, $delete);
  $_SESSION['message'] = "deleted succssfully";
  redirect('app/users/');
}
?>


<main id="main" class="main">

<div class="pagetitle">
      <h1>User Table
      <a href="<?= url("app/users/create.php") ?>" class="btn btn-primary float-end"> Add New</a>
      </h1>   
      
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item">Tables</li>
          <li class="breadcrumb-item active">Users</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Users</h5>
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

              <!-- Table with stripped rows -->
              <table class="table datatable">
                <thead>
                  <tr>
                    <th>
                      id
                    </th>
                    <th>Name</th>
                    <th>Email</th>
                    <th colspan="2">Action</th>
                  </tr>
                </thead>
                <tbody>
                    <?php foreach ($data as $item): ?>
                  <tr>
                    <td><?= $item['id'] ?></td>
                    <td><?= $item['name'] ?></td>
                    <td><?= $item['email'] ?></td>
                    <td><a href="./view.php?view=<?=$item['id'] ?>">view</a></td>
                    <td><a href="<?php url("app/users/")?>?delete=<?= $item['id']?>">delete</a></td>
                  </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
              <!-- End Table with stripped rows -->

            </div>
          </div>

        </div>
      </div>
    </section>

</main><!-- End #main -->



<?php
include_once "../../shared/footer.php";
include_once "../../shared/script.php";
?>