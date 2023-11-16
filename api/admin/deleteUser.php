<?php
session_start();
require __DIR__ . '/functions.php';


?>

<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Deleted Account </title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel='stylesheet' type='text/css' media='screen' href='../../static/css/staff.css'>
</head>

<body>

    <div class="d-flex justify-content-center align-items-center ">
        <div class="adminView my-5">
            <h2 class="p-3">This Account has been deleted</h2>
        </div>
    </div>


    <div class="d-flex justify-content-center align-items-center">
        <!-- Return Home Button -->
        <form method="POST">
            <button type="submit" name="returnAdminUser" class="tranBack"><img class="homeButtonAdmin mx-3 mt-3"
                    src="../../static/img/home1.gif" alt="Back to Home Page" title="Back to Home Page"
                    attribution="https://www.flaticon.com/free-animated-icons/home"></button>
        </form>
    </div>

</body>

</html>