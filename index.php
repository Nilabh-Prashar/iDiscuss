<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">

  <title>iForum</title>
</head>

<body>
  <?php
  require "partials/_dbconnect.php";
  require "partials/_header.php";

  ?>
  <?php
  $showError = false;
  if (isset($_GET['passwordMatch'])) {
    $showError = "Please enter same password";
    echo '<div class="alert alert-Danger alert-dismissible fade show" role="alert">
    <strong>Error !</strong> ' . $showError . ' 
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>';
  } elseif (isset($_GET['userExist'])) {
    $showError = "User already exist please login";
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
          <strong>Error !</strong> ' . $showError . ' 
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
  } elseif (isset($_GET['signupSuccess'])) {
    if ($_GET['signupSuccess'] == 'false') {
      echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
      <strong>Error in Signup!</strong> Sorry for inconveineice. 
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
    }
    echo '<div class="alert alert-Success alert-dismissible fade show" role="alert">
    <strong>Signup Success !</strong> Congrats Signup Success 
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>';
  }elseif (isset($_GET['loginPassword'])) {
    $showError = "Please enter correct password to login";
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
          <strong>Error !</strong> ' . $showError . ' 
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
  }elseif (isset($_GET['loginUser'])) {
    $showError = "User do not exist please signup";
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
          <strong>Error !</strong> ' . $showError . ' 
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
  }
  ?>
  <!-- Courosel start -->
  <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-indicators">
      <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
      <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
      <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
    </div>
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img src="img/slider-1.png" class="d-block w-100" alt="...">
      </div>
      <div class="carousel-item">
        <img src="img/slider-2.png" class="d-block w-100" alt="...">
      </div>
      <div class="carousel-item">
        <img src="img/slider-3.png" class="d-block w-100" alt="...">
      </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>
  </div>
  <!-- couresel ends -->
  <div class="container">
    <h2 class="text-center my-4">iDiscuus Categories</h2>
    <div class="row">
      <?php
      $sql = "SELECT * FROM `categories`";
      $result = mysqli_query($conn, $sql);
      while ($row = mysqli_fetch_assoc($result)) {
        $cat = $row['category_name'];
        $id = $row['category_id'];
        $desc = $row['category_description'];
        echo ' <div class="col-md-4">
      <div class="card mt-3 mb-3" style="width: 18rem;">
        <img src="img/' . $cat . '.png".png" class="card-img-top" alt="...">
        <div class="card-body">
          <h5 class="card-title"><a href="threadlist.php?catid=' . $id . '">' . $cat . '</a></h5>
          <p class="card-text">' . substr($desc, 0, 90) . '...</p>
          <a href="threadlist.php?catid=' . $id . '" class="btn btn-primary">View ' . $cat . '</a>
        </div>
      </div>
    </div>';
      }

      ?>

    </div>
  </div>
  <?php require "partials/_footer.php"; ?>
  <!-- Optional JavaScript; choose one of the two! -->

  <!-- Option 1: Bootstrap Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>

  <!-- Option 2: Separate Popper and Bootstrap JS -->
  <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js" integrity="sha384-SR1sx49pcuLnqZUnnPwx6FCym0wLsk5JZuNx2bPPENzswTNFaQU1RDvt3wT4gWFG" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js" integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc" crossorigin="anonymous"></script>
    -->
</body>

</html>