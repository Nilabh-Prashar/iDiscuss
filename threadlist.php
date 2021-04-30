<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <style>
        #ques {
            min-height: 533px;
        }
    </style>
    <title>iForum</title>
</head>

<body>
    <?php
    require "partials/_dbconnect.php";
    require "partials/_header.php";

    ?>
    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $showAlert = false;
        // $user_email = $_SESSION['user_email'];
        $th_tittle = $_POST['tittle'];
        // Replacing javaScript tag from insertion in database saving from potential XSS attack
        $th_tittle = str_replace("<", "&lt", $th_tittle);
        $th_tittle = str_replace(">", "&gt", $th_tittle);

        $th_desc = $_POST['desc'];
        // Replacing javaScript tag from insertion in database saving from potential XSS attack
        $th_desc = str_replace("<", "&lt", $th_desc);
        $th_desc = str_replace(">", "&gt", $th_desc);

        $thread_category_id = $_GET['catid'];
        $usr_email = $_SESSION['user_email'];
        $usr_name = $_SESSION['user_name'];
        if (isset($_SESSION['loggedin']) && ($_SESSION['loggedin'] == true)) {
            // insert into database
            $sql = "INSERT INTO `threads` (`thread_id`, `thread_tittle`, `thread_description`, `thread_category_id`, `thread_user_email`, `user_name`, `asked_date`)
             VALUES ('', '$th_tittle', '$th_desc', '$thread_category_id', '$usr_email', '$usr_name', current_timestamp())";
            $result = mysqli_query($conn, $sql);
            if ($result)
                $showAlert = true;
            //  show alert after inserting question in database 
            if ($showAlert) {
                echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success !</strong> Your query has been added succesfully wait someone will answer your query.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>';
            }
        }
    }

    ?>


    <div class="container mt-4" id="ques">
        <div class="bg-light p-5 rounded-lg m-3">
            <?php
            $id = $_GET['catid'];
            $sql = "SELECT * FROM `categories` where category_id = $id";
            $result = mysqli_query($conn, $sql);
            while ($row = mysqli_fetch_assoc($result)) {
                $cat = $row['category_name'];
                $db_id = $row['category_id'];
                $desc = $row['category_description'];
                echo '
                    <h1 class="display-4">' . $cat . ' </h1>
                    <p class="lead">' . $desc . '</p>
                    <hr class="my-4">
                    <p>No Spam / Advertising / Self-promote in the forums<br>
                    Do not post copyright-infringing material<br>
                    Do not cross post questions</p>
                    <a class="btn btn-success btn-lg" href="#" role="button">Learn more</a>
                    ';
            }
            ?>
        </div>
        <?php
        if (isset($_SESSION['loggedin']) && ($_SESSION['loggedin'] == true)) {
            echo ' <div class="container">
            <h1>Ask Question </h1>
            <form class="mb-3" action="' . $_SERVER['REQUEST_URI'] . '" method="POST">
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Question Tittle</label>
                    <input type="text" class="form-control" id="thread_tittle" name="tittle" aria-describedby="emailHelp">
                    <div id="emailHelp" class="form-text">Try to make tittle as short and crisp as u can</div>
                </div>
                <div class="mb-3">
                    <textarea class="form-control" placeholder="Elaborate your problem" id="floatingTextarea2" name="desc" style="height: 100px"></textarea>
                    <label for="floatingTextarea2">th$th_descs</label>
                </div>
                <button type="submit" class="btn btn-success"> Ask </button>
            </form>
        </div>';
        } else {
            echo '<div class="container">
                        <h1>Start Discussion</h1>
                        <p class="lead">You are not loggedin please logn to start  discussion.</p>
                  </div>';
        }
        ?>

        <div class="container">

            <h1>Browse Questions</h1>

            <?php
            $id = $_GET['catid'];
            $sql_thread = "SELECT * FROM `threads` where thread_category_id = $id";
            $result = mysqli_query($conn, $sql_thread);
            $noResult = true;
            while ($row = mysqli_fetch_assoc($result)) {
                $noResult = false;
                $thread_tittle = $row['thread_tittle'];
                $desc = $row['thread_description'];
                $threadid = $row['thread_id'];
                $time = $row['asked_date'];
                $user = $row['user_name']; // getting user name from thread table
                echo '<div class="d-flex align-items-center">
                <div class="flex-shrink-0">
                    <img src="img/user_default.png" width="64px" height="64px" alt="...">
                </div>
                <div class="flex-grow-1 ms-3">
                <p class="fw-bold my-0">' . $user . ' asked  ' . $time . '</p>
                <h5 class="mt-0 my-0"><a class="text-dark" href="thread.php?threadid=' . $threadid . '">' . $thread_tittle . '</a> </h5>
                <p>' . $desc . '</p>
                </div>
            </div>';
            }
            if ($noResult) {
                echo '<div class="jumbotron jumbotron-fluid">
                        <div class="container">
                          <h4>No Question asked</h4>
                          <p class="lead">Be the first to ask.</p>
                        </div>
                      </div>';
            }
            ?>

            <!-- <h5 class="mt-0"><a class="text-dark" href="thread.php?threadid=' . $threadid . '">' . $thread_tittle . '</a> </h5> -->
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