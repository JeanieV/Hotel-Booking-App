<?php
session_start();
require '../functions.php';

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
    <link rel='stylesheet' type='text/css' media='screen' href='../../static/css/editProfile.css'>
</head>

<body>

    <?php
    // Display error message if set
    if (isset($_SESSION['deletedAccount'])) {
        echo '<div class="container d-flex justify-content-center align-items-center">';
        echo '<p class="text-danger">' . $_SESSION['deletedAccount'] . '</p>';
        echo '</div>';
        unset($_SESSION['deletedAccount']);
    }
    ?>

    <div class="d-flex justify-content-center align-items-center">
        <!-- Return Home Button -->
        <form method="POST">
            <button type="submit" name="logOutButton" class="tranBack"><img class="logOutStyle mt-3"
                    src="../../static/img/logout.png" alt="Log Out" title="Log Out"
                    attribution="https://www.flaticon.com/free-icons/logout"></button>
        </form>
    </div>

</body>

</html>