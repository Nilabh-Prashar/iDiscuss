<?php
session_start();
if (isset($_SESSION['loggedin']) && ($_SESSION['loggedin'] == true)) {
  $loggedin = true;
} else {
  $loggedin = false;
}
echo '<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
<div class="container-fluid">
  <a class="navbar-brand" href="/iforum">iDiscuss</a>
  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
      <li class="nav-item">
        <a class="nav-link active" aria-current="page" href="/iforum">Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="about.php">About</a>
      </li><li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        Top Categories
      </a>
      <ul class="dropdown-menu" aria-labelledby="navbarDropdown">';

$sql = "select category_name, category_id from `categories` LIMIT 3";
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($result)) {
  echo '
 <li><a class="dropdown-item" href="threadlist.php?catid=' . $row['category_id'] . '">' . $row['category_name'] . '</a></li>
';
}

echo '</ul>
      </li><li class="nav-item">
        <a class="nav-link" href="contact.php"  >Contact</a>
      </li>
    </ul>
    <form class="d-flex mx-2" action="search.php" method="get" >
      <input class="form-control me-2" name="query" type="search" placeholder="Search" aria-label="Search">
      <button class="btn btn-outline-success" type="submit">Search</button>
    </form>
    <ul class="navbar-nav mb-2 mb-lg-0 ml-2">';
if ($loggedin != true) {
  echo '<li class="nav-item ml-2">
      <button class="btn btn-primary ml-2" data-bs-toggle="modal" data-bs-target="#loginModal">Login</button>
    </li>
    <li class="nav-item">
    <button class="btn btn-primary mx-2" data-bs-toggle="modal" data-bs-target="#signupModal">SignUp</button>
    </li>';
}

if ($loggedin) {
  echo '<li class="nav-item dropdown">
  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
    ' . $_SESSION['user_name'] . '
  </a>
  <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
    <li><a class="dropdown-item" href="partials/_logout.php">Logout</a></li>
    </ul>
    </li>';
}
echo '
    </ul>
  </div>
</div>
</nav>';
include "partials/loging_modal.php";
include "partials/signup_modal.php";
