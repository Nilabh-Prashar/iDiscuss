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
            min-height: 433px;
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
        $comment = $_POST['comment'];
        // Replacing javaScript tag from insertion in database saving from potential XSS attack   
        $comment = str_replace("<", "&lt", $comment);
        $comment = str_replace(">", "&gt", $comment);
        $th_id = $_GET['threadid'];
        $showAlert = false;
        $commentby = $_SESSION['user_name'];
        $usr_email = $_SESSION['user_email'];
        if (isset($_SESSION['loggedin']) && ($_SESSION['loggedin'] == true)) {
            $sql = "INSERT INTO `comments` (`comment_id`, `comment_content`, `thread_id`, `comment_by`, `user_email`, `comment_time`)
         VALUES ('', '$comment', '$th_id', '$commentby', '$usr_email', current_timestamp())";
            $result = mysqli_query($conn, $sql);
            if ($result)
                $showAlert = true;
            //  show alert after inserting question in database 
            if ($showAlert) {
                echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                     <strong> Success !</strong> Your comment is added succesfully.
                     <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                   </div>';
            }
        }
    }


    ?>



    <div class="container mt-4">
        <div class="bg-light p-5 rounded-lg m-3">

            <?php
            $id = $_GET['threadid'];
            $sql = "SELECT * FROM `threads` where thread_id = $id";
            $result = mysqli_query($conn, $sql);
            while ($row = mysqli_fetch_assoc($result)) {
                $thread_tittle = $row['thread_tittle'];
                $desc = $row['thread_description'];
                $usr_asked = $row['user_name'];
                echo '
                    <h1 class="display-4">' . $thread_tittle  . ' </h1>
                    <p class="lead">' . $desc . '</p>
                    <p class="lead">Posted by <b>' . $usr_asked .  '</b></p>
                    <hr class="my-4">
                    <p>No Spam / Advertising / Self-promote in the forums<br>
                    Do not post copyright-infringing material<br>
                    Do not cross post questions</p>
                    <a class="btn btn-success btn-lg" href="" role="button">Learn more</a>
                </div>';
            }
            ?>


        </div>
    </div>
    <?php
    if (isset($_SESSION['loggedin']) && ($_SESSION['loggedin'] == true)) {
        echo ' <div class="container">
            <form class="mb-3" action="' . $_SERVER['REQUEST_URI'] . '" method="POST">
                <h1>Post Comment</h1>    
                <div class="mb-3">
                    <textarea class="form-control" placeholder="Write your Comment" id="floatingTextarea2" name="comment" style="height: 100px"></textarea>
                </div>
                <button type="submit" class="btn btn-success">Post Comment </button>
            </form>
        </div>';
    } else {
        echo '<div class="container">
                        <h1>Post Comment</h1>
                        <p class="lead">You are not loggedin please logn to post your comment.</p>
                  </div>';
    }
    ?>
    <div class="container" id="ques">
        <h1> Discussions </h2>

            <?php
            $id = $_GET['threadid'];
            $sql_thread = "SELECT * FROM `comments` where thread_id = $id";
            $result = mysqli_query($conn, $sql_thread);
            $noResult = true;
            while ($row = mysqli_fetch_assoc($result)) {
                $noResult = false;
                $comment_content = $row['comment_content'];
                $commnet_by = $row['comment_by'];
                $time = $row['comment_time'];
                echo '<div class="d-flex align-items-center my-0">
                        <div class="flex-shrink-0">
                            <img src="img/user_default.png" width="64px" height="64px" alt="...">
                        </div>
                        <div class="flex-grow-1 ms-3">
                        <p class="fw-bold my-0">' . $commnet_by . ' answered ' . $time . '</p>
                        <p>' . $comment_content . '</p>
                        </div>
                    </div>';
            }
            if ($noResult) {
                echo '<div class="jumbotron jumbotron-fluid">
                                 <div class="container">
                                   <h4>No one Answered</h4>
                                   <p class="lead">Be the first to answer.</p>
                                 </div>
                               </div>';
            }
            ?>


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