<?php
session_start();
require './functions.php';


?>

<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>View Bookings </title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel='stylesheet' type='text/css' media='screen' href='../static/css/bookings.css'>
</head>

<body>

    <!-- Return Home Button -->
    <form method="POST">
        <button type="submit" name="returntoHotelPage" class="tranBack"><img class="homeButton mx-3 mt-3"
                src="../static/img/home.png" alt="Back to Home Page" title="Back to Home Page"
                attribution="https://www.flaticon.com/free-icons/home"></button>
    </form>

    <div class="container d-flex justify-content-center align-items-center">
        <div class="mt-5 mb-5 mx-5">

            <form method="POST" class="bookView p-5">

                <div class="d-flex justify-content-center align-items-center">
                        <?php
                        $userId = $_SESSION['user_id'];
                        viewBookings($userId);
                        deleteBookingforUser();

                        ?>
                </div>
            </form>
        </div>
    </div>
</body>

</html>


<!-- $filename = "order.csv"; // Name of the output file
    $data = [
        $_SESSION['order']->get_user()->get_name() . " is ordering:",
        "A pizza with " . $_SESSION['order']->get_ingredient()->get_name() . " as the 1 ingredient",
        "R" . $_SESSION['order']->get_ingredient()->get_price(),
        "Start Date:",
        "R" . $_SESSION['order']->get_deliveryStartDay(),
        "End Date:",
        "R" . $_SESSION['order']->get_deliveryEndDay(),
    ];
// Create the file and write the content
    $file = fopen($filename, 'w'); // Open the file for writing

    // Write each string to the file
    foreach ($data as $string) {
        fwrite($file, $string . PHP_EOL); // Append a new line after each string
    }

    fclose($file); // Close the file

    // Set headers to trigger the file download
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Content-Length: ' . filesize($filename));

    // Flush the output buffer
    ob_flush();
    flush();
// Read and output the file contents
    readfile($filename);

    // Clean up
    unlink($filename); // Delete the temporary file
    session_destroy();

    exit(); -->