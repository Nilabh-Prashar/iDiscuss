<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <style>
        #result {
            min-height: 37vmax;
        }
    </style>
    <title>iForum</title>
</head>

<body>
    <?php
    require "partials/_dbconnect.php";
    require "partials/_header.php";
    ?>



    <!-- Fetching Search results -->
    <div class="container my-3" id="result">
        <h1>Search results for <em>"<?php echo $_GET['query']; ?>" </em></h1>
        <div class="result">
            <?php
            $search = $_GET['query'];
            $sql = "SELECT * FROM `threads` WHERE MATCH (thread_tittle, thread_description) AGAINST ('$search');";
            $result = mysqli_query($conn, $sql);
            while ($row = mysqli_fetch_assoc($result)) {
                $url = "thread.php?threadid=". $row['thread_id'];
                echo '<h3> <a href="' . $url .'" class="text-dark">' . $row['thread_tittle'] . '</a></h3>';
                echo '<p>' . $row['thread_description'] . '</p>';
            }

            ?>
        </div>
    </div>
    <!-- <h3> <a href="#" class="text-dark">Cannot install node js</a></h3>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Dicta id molestiae soluta ut velit modi fugit quis, suscipit ducimus animi minus incidunt, consectetur iste earum esse et exercitationem, sed nobis officia veniam voluptas? Esse labore quia aspernatur doloribus earum
                accusantium cumque recusandae veritatis id sint neque quisquam eligendi ea beatae optio praesentium doloremque, dolore enim possimus, delectus repellat aliquam molestiae fugiat nihil! Totam saepe vitae odio molestias consequatur doloremque cupiditate in optio doloribus voluptates sapiente, laudantium eveniet repellat odit quasi minus nostrum aliquid et unde dolor quis asperiores omnis!
            </p> -->

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