<?php
session_start();
require __DIR__ . '/functions.php';


// Public username
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
}

if(isset($_POST['receiptButton'])){
    generateReceiptforIndividual();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You Page </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel='stylesheet' type='text/css' media='screen' href='../../static/css/bookings.css'>
</head>

<body>

    <div class="container d-flex justify-content-center align-items-center">
        <div class="mt-5 mb-5">

            <!-- This will make sure that the username is known throughout the website -->
            <?php login(); ?>

            <form method="POST" name="logOutView" class="logOutView p-5">
                <?php $book1 = <<<DELIMETER
                <h4 class="mb-5"> Thank you for using at Greece Bookings, $username! </h4>   
                <h5> Visit us again soon! </h5>
                DELIMETER;
                echo $book1;
                ?>

                <div class="d-flex justify-content-center align-items-center">
                    <button type="submit" name="receiptButton" class="editButton p-3 my-3 mx-5"> Generate Receipt
                    </button>
                </div>

                <!-- Go back to the index page -->
                <button type="submit" name="logOutButtonFinal" class="tranBack"><img class="logOutStyle mx-3 mt-3"
                        src="../../static/img/logout.png" alt="Log Out as User" title="Log Out as User"
                        attribution="https://www.flaticon.com/free-icons/logout"></button>
            </form>

        </div>
    </div>

</body>

</html>