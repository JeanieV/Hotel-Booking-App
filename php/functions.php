<?php
session_start();
require './classes.php';

// Sign Up a new user
if (isset($_POST['newUserButton'])) {
    header("Location: ./signUp.php");
}

// Logout
if (isset($_POST['logOutButton'])) {
    session_unset();
    session_destroy();

    header("Location: ./index.php");
    exit();
}

// Return to homepage
if (isset($_POST['returnHome'])) {
    header("Location: ./index.php");
}

// Return to Hotel Page after clicking on viewing a Hotel
if (isset($_POST['returntoHotelPage'])) {
    header("Location: ./hotel.php");
}

// Edit Profile Button
if (isset($_POST['editProfileButton'])) {
    header("Location: ./viewAllInfo.php");
}

// View Marbella Elix
if (isset($_POST['marbellaElixButton'])) {
    header("Location: ./marbellaElix.php");
}

// View Royal Senses
if (isset($_POST['royalSensesButton'])) {
    header("Location: ./royalSenses.php");
}

// View The View
if (isset($_POST['theViewButton'])) {
    header("Location: ./theView.php");
}

// View Angsana Corfu
if (isset($_POST['angsanaButton'])) {
    header("Location: ./angsanaCorfu.php");
}

// View The Rooster
if (isset($_POST['theRoosterButton'])) {
    header("Location: ./theRooster.php");
}

// View The Rooster
if (isset($_POST['destinoButton'])) {
    header("Location: ./destinoPacha.php");
}

// Return to the editProfile.php
if (isset($_POST['returnToViewAllInfo'])) {
    header("Location: ./viewAllInfo.php");
}

// Go to edit Page
if (isset($_POST['goToEditPage'])) {
    header("Location: ./editProfile.php");
}

// // Go to confirmBooking.php
if (isset($_POST['bookingsButton'])) {
    header("Location: ./viewBookings.php");
}



// Database connection
function db_connect()
{
    $user = 'root';
    $password = 'root';
    $db = 'greece_bookings';
    $host = 'localhost';
    $port = 3306;

    $mysqli = mysqli_init();
    $success = mysqli_real_connect(
        $mysqli,
        $host,
        $user,
        $password,
        $db,
        $port
    );

    if (!$success) {
        echo "Error connecting to the database: " . mysqli_connect_error();
        return null;
    }
    return $mysqli;
}

// ---------------------------------------------------------
// Register and Login Functions
// ---------------------------------------------------------

// Function to create a new user and check whether the email already exists
function register()
{
    if (isset($_POST['newUsername']) && isset($_POST['newFullName']) && isset($_POST['newAddress']) && isset($_POST['newPassword']) && isset($_POST['newEmail']) && isset($_POST['newPhoneNumber'])) {

        // Get the user data from the POST request
        $_SESSION['username'] = $_POST['newUsername'];
        $username = $_SESSION['username'];
        $_SESSION['fullname'] = $_POST['newFullName'];
        $fullName = $_SESSION['fullname'];
        $address = $_POST['newAddress'];
        $password = $_POST['newPassword'];
        $email = $_POST['newEmail'];
        $phoneNumber = $_POST['newPhoneNumber'];

        // Connect to the database
        $mysqli = db_connect();
        if (!$mysqli) {
            return;
        }

        // Check if the email and phoneNumber already exists in the database 
        $query = "SELECT * FROM users WHERE email = ? OR phoneNumber = ?";
        $stmt = mysqli_prepare($mysqli, $query);

        // Prepare the statement to bind the parameters (email)
        mysqli_stmt_bind_param($stmt, "ss", $email, $phoneNumber);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        // If there is information in the table that matches the input value
        if (mysqli_stmt_num_rows($stmt) > 0) {
            echo '<h2 class="p-3">Email or Phone Number already exists.</h2>';
            mysqli_stmt_close($stmt);
            mysqli_close($mysqli);
            return;
        }

        // SQL Statement
        $query = "INSERT INTO users (`username`, `fullname`, `address`, `password`, `email`, `phoneNumber`) VALUES (?, ?, ?, ?, ?, ?)";

        // Prepare the statement
        $stmt = mysqli_prepare($mysqli, $query);

        // Bind the parameters to the statement (username, fullname, address, password and email)
        mysqli_stmt_bind_param($stmt, "ssssss", $username, $fullName, $address, $password, $email, $phoneNumber);

        // If the user has successfully been added to the database
        if (mysqli_stmt_execute($stmt)) {

            // Getting the user_id from the table
            $user_id = mysqli_insert_id($mysqli);

            $_SESSION['user_id'] = $user_id;
            $_SESSION['username'] = $username;
            $_SESSION['fullname'] = $fullName;

            echo '<h2 class="p-3">Success: User created successfully! <br> Head back to Home Page for Login</h2>';
            exit();
        } else {
            echo 'Error creating user: ' . mysqli_error($mysqli);
        }

        // Close the statement and the database connection
        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
    }
}

// This is to make sure that the person is directed to the other pages if they are on the database
function login()
{
    if (isset($_POST['email']) && isset($_POST['password'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Connect to the database
        $mysqli = db_connect();
        if (!$mysqli) {
            return;
        }

        // Check if the email and password match in the database
        $query = "SELECT * FROM users WHERE email = ? AND password = ?";

        // Prepare the statement to bind the parameters (email and password)
        $stmt = mysqli_prepare($mysqli, $query);
        mysqli_stmt_bind_param($stmt, "ss", $email, $password);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        // If there is information in the table, find the username that match
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            // Make sure that the user_id, username and fullname is known
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['fullname'] = $row['fullname'];
            $_SESSION['username'] = $row['username'];

            mysqli_stmt_close($stmt);
            mysqli_close($mysqli);
            header("Location: ./hotel.php");
            exit();
        } else {
            // User does not exist or wrong password, redirect to signUp.php
            mysqli_stmt_close($stmt);
            mysqli_close($mysqli);
            header("Location: ./signUp.php");
            exit();
        }
    }
}

// ---------------------------------------------------------
// Hotel Information
// ---------------------------------------------------------



// Function to show the information inside the hotel table.
function showInformation()
{
    if (isset($_SESSION['hotel_id'])) {
        $hotelId = $_SESSION['hotel_id'];

        // Connect to the database
        $mysqli = db_connect();
        if (!$mysqli) {
            echo 'Database connection error.';
            exit;
        }

        // Create an instance of the Hotel class
        $hotel = new Hotel($mysqli, $hotelId);

        // Fetch hotel information using the provided hotel ID
        $targetHotelData = $hotel->viewHotelsById();

        if ($targetHotelData) {

            $information = <<<DELIMETER
            <div class="container d-flex justify-content-center align-items-center mt-5">
            <table class="informationTable">
                <tr>
                    <td class="p-4"> <h3> Price per night: </h3> </td>
                    <td class="p-3"> <p> R {$targetHotelData['pricePerNight']} </p> </td>
                </tr>
                <tr>
                    <td class="p-4"> <h3> Features: </h3> </td>
                    <td class="features p-3"> <p> {$targetHotelData['features']} </p> </td>
                </tr>
                <tr>
                    <td class="p-4 text-center"> <img class="sleeps p-2"
                    src="../static/img/bed.png" alt="Sleeps" title="Sleeps"
                    attribution="https://www.flaticon.com/free-icons/bed"> </td>
                    <td class="features p-3"> <p> {$targetHotelData['beds']} people </p> </td>
                </tr>
                <tr>
                <td class="p-4 text-center"> <img class="sleeps p-2"
                src="../static/img/hotel.png" alt="Type" title="Type"
                attribution="https://www.flaticon.com/free-icons/hotel"> </td>
                    <td class="features p-3"> <p> {$targetHotelData['type']} </p> </td>
                </tr>
                <tr>
                <td class="p-4 text-center"> <img class="sleeps p-2"
                src="../static/img/star.png" alt="Rating" title="Rating"
                attribution="https://www.flaticon.com/free-icons/star"> </td>
                    <td class="features p-3"> <p> {$targetHotelData['rating']} star</p> </td>
                </tr>
                
            </table>
            </div>
            DELIMETER;
            echo $information;

        } else {
            echo 'Hotel not found.';
        }

        mysqli_close($mysqli);
    } else {
        echo 'Invalid request.';
    }
}

// Function to compare similar hotels based on the price per night using cards
function cardComparedHotels()
{
    if (isset($_GET['hotel_id'])) {
        $hotelId = $_GET['hotel_id'];

        // Connect to the database
        $mysqli = db_connect();
        if (!$mysqli) {
            return;
        }

        // Create an instance of the Hotel class
        $hotel = new Hotel($mysqli, $hotelId);

        // Fetch hotel information using the provided hotel ID
        $relatedHotels = $hotel->getRelatedHotels(5000);

        $targetHotelData = $hotel->viewHotelsById();

        $start = <<<DELIMETER
        <div class="row">
        DELIMETER;
        echo $start;

        // A card for each hotel where the price per night difference is more or less than R 3000
        foreach ($relatedHotels as $relatedHotel) {

            // Getting the price per night for 2 variables
            $relatedHotelCost = $relatedHotel->calculateCost();

            // Calculating the price difference between the hotels
            $priceDifference = abs($relatedHotelCost['pricePerNight'] - $targetHotelData['pricePerNight']);

            if ($priceDifference < 5000) {
                $thumbnail = $relatedHotel->viewHotelsById()['thumbnail'];
                $name = $relatedHotel->viewHotelsById()['name'];
                $price = $relatedHotel->viewHotelsById()['pricePerNight'];
                $hotelId = $relatedHotel->viewHotelsById()['hotel_id'];

                // Determine the correct file path based on hotel ID
                $phpFile = determinePhpFile($hotelId);

                $compare = <<<DELIMETER
                <div class="col-sm-6">
                    <div class="card mt-3 mb-5">
                        <img class="card-img-top hotelImage" src="../static/img/{$thumbnail}" alt="Hotel image">
                        
                            <div class="card-img-overlay">
                                <div class="d-flex justify-content-center align-items-center">
                                    <div class="background">
                                        <h5 class="card-title p-2"> {$name} </h5>
                                        <h5 class="card-title p-2"> R {$price} per night </h5>
                                    </div>
                                </div>
                            <div class="d-flex justify-content-center align-items-center">
                                <form method="GET" action="{$phpFile}">
                                    <input type="hidden" name="hotel_id" value="{$hotelId}">
                                    <button type="submit" class="viewMoreButton p-2 mt-3" name="compareShowHotel"> View More </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                DELIMETER;
                echo $compare;
            }
        }

        $end = <<<DELIMETER
        </div>
        DELIMETER;
        echo $end;
    }
}

// Creating an array to find the correct php file based on the Hotel Id
function determinePhpFile($hotelId)
{

    $hotelPhpFiles = array(
        '1' => 'marbellaElix.php',
        '2' => 'royalSenses.php',
        '3' => 'theView.php',
        '4' => 'angsanaCorfu.php',
        '5' => 'theRooster.php',
        '6' => 'destinoPacha.php',

    );

    if (array_key_exists($hotelId, $hotelPhpFiles)) {
        return $hotelPhpFiles[$hotelId];
    } else {
        return 'hotel.php';
    }
}


// ---------------------------------------------------------
// CRUD Operations
// ---------------------------------------------------------

// If the user clicks on the editButton, the updating will take place
function editUserInformation()
{

    if (isset($_POST['editButton'])) {

        // Capture user_id from the form
        $userId = $_POST['user_id'];
        $username = $_POST['editUsername'];
        $fullname = $_POST['editFullName'];
        $address = $_POST['editAddress'];
        $email = $_POST['editEmail'];
        $phoneNumber = $_POST['editPhoneNumber'];

        // Connect to the database
        $mysqli = db_connect();
        if (!$mysqli) {
            echo 'Database connection error.';
            exit;
        }

        // Create an instance of the User class
        $user = new User($mysqli);

        // Retrieve existing user data from the database
        $existingUserData = $user->getUserData($userId);

        // Update only the fields that the user has interacted with
        if (empty($username)) {
            $username = $existingUserData['username'];
        }
        if (empty($fullname)) {
            $fullname = $existingUserData['fullname'];
        }
        if (empty($address)) {
            $address = $existingUserData['address'];
        }
        if (empty($email)) {
            $email = $existingUserData['email'];
        }
        if (empty($phoneNumber)) {
            $phoneNumber = $existingUserData['phoneNumber'];
        }

        // Pass user_id along with other fields to the editUser method
        $userUpdated = $user->editUser($userId, $username, $fullname, $address, $email, $phoneNumber);

        if ($userUpdated) {
            $_SESSION['username'] = $username;
            $_SESSION['fullname'] = $fullname;

            echo '<h2 class="p-3">Success: User information updated successfully! <br> Head back to the Information Page</h2>';
            mysqli_close($mysqli);
            exit();
        } else {
            echo 'User not updated.';

        }
    }
}

function viewUserInformation()
{

    if (isset($_GET['viewInfo'])) {
        // Retrieve the user_id from the session
        $userId = $_SESSION['user_id'];

        // Connect to the database
        $mysqli = db_connect();
        if (!$mysqli) {
            echo 'Database connection error.';
            exit;
        }

        $query = "SELECT * FROM users WHERE user_id = ?";
        $stmt = mysqli_prepare($mysqli, $query);
        mysqli_stmt_bind_param($stmt, "i", $userId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);

            $information = <<<DELIMETER
        <div class="container d-flex justify-content-center align-items-center">
            <form method="POST">

            <h2> This is your information: </h2>

                <div class="d-flex justify-content-center align-items-center my-5">

                    <table class="informationTable">
                        <tr>
                            <td class="p-4"> <h3> Username: </h3> </td>
                            <td class="p-4"> <p> {$row['username']} </p> </td>
                        </tr>
                
                        <tr>
                            <td class="p-4"> <h3> Full Name: </h3> </td>
                            <td class="p-4"> <p> {$row['fullname']} </p> </td>
                        </tr>
                
                        <tr>
                            <td class="p-4"> <h3> Address: </h3> </td>
                            <td class="p-4"> <p> {$row['address']} </p> </td>
                        </tr>
                
                        <tr>
                            <td class="p-4"> <h3> Password: </h3> </td>
                            <td class="p-4"> <p> {$row['password']} </p> </td>
                        </tr>

                        <tr>
                            <td class="p-4"> <h3> Email: </h3> </td>
                            <td class="p-4"> <p> {$row['email']} </p> </td>
                        </tr>

                        <tr>
                            <td class="p-4"> <h3> Phone Number: </h3> </td>
                            <td class="p-4"> <p> {$row['phoneNumber']} </p> </td>
                        </tr>
                
                    </table>
                </div>
            </form>
        </div>

        DELIMETER;
            echo $information;
        } else {
            echo 'User not found.';
        }
    }
    mysqli_free_result($result);
    mysqli_close($mysqli);
}



// Function using the delete method
function deleteUserFinal()
{

    if (isset($_GET['deleteUserButton'])) {
        $userId = $_GET['user_id'];

        // Connect to the database
        $mysqli = db_connect();
        if (!$mysqli) {
            return;
        }

        // Create a new instance of the User class
        $user = new User($mysqli);

        // Call the method from the User class
        $result = $user->deleteUser($userId);

        if ($result) {
            header("Location: deletedPage.php");
            $_SESSION['deletedAccount'] = '<h2 class="p-3">Your Account has been deleted</h2>';

            mysqli_close($mysqli);
            exit();
        } else {
            // Redirect back to the same page or display an error message
            header("Location: viewAllInfo.php");
            exit();
        }
    }
}


// ---------------------------------------------------------
// Bookings
// ---------------------------------------------------------

function addBooking()
{
    // Connect to the database
    $mysqli = db_connect();
    if (!$mysqli) {
        return;
    }

    if (isset($_POST['bookButton'])) {
        // Making sure that checkIn and checkOut dates are not empty
        if (empty($_POST['checkIn']) || empty($_POST['checkOut'])) {
            $_SESSION['dateMessage'] = 'Please select both Check-In and Check-Out dates.';

        } else {
            // Making sure that the variables are stored
            $userId = $_SESSION['user_id'];
            $hotelId = $_SESSION['hotel_id'];
            $checkInDate = $_POST['checkIn'];
            $checkOutDate = $_POST['checkOut'];

            // Validate the interval of days
            if (strtotime($checkInDate) >= strtotime($checkOutDate)) {
                $_SESSION['dateMessage'] = 'Check-In date must be before Check-Out date.';

            } else {

                if (anotherBooking($userId, $checkInDate, $checkOutDate)) {
                    $_SESSION['dateMessage'] = 'You already have a booking for the selected dates.';
                } else {
                    // Check if the selected hotel is available for the selected dates
                    if (hotelIsAvailable($hotelId, $checkInDate, $checkOutDate)) {

                        $hotelInstance = new Hotel($mysqli, $hotelId);
                        $pricePerNightData = $hotelInstance->calculateCost();
                        $pricePerNight = $pricePerNightData['pricePerNight'];

                        // Calculate the number of days
                        $startDateTime = new DateTime($checkInDate);
                        $endDateTime = new DateTime($checkOutDate);
                        $interval = $startDateTime->diff($endDateTime);
                        $numberOfDays = $interval->days;

                        // Calculate total cost
                        $totalCost = $numberOfDays * $pricePerNight;

                        // Check if the checkInDate is the same as the current date
                        $currentDate = new DateTime();
                        $checkInDateTime = new DateTime($checkInDate);

                        if ($checkInDateTime->format('Y-m-d') <= $currentDate->format('Y-m-d')) {
                            $bookingInstance = new Booking($mysqli);
                            $bookingInstance->completedBooking(mysqli_insert_id($mysqli));
                        }

                        // Store the booking information in session variables
                        $_SESSION['bookingInfo'] = array(
                            'userId' => $userId,
                            'hotelId' => $hotelId,
                            'checkInDate' => $checkInDate,
                            'checkOutDate' => $checkOutDate,
                            'totalCost' => $totalCost,
                        );

                        header("Location: ./confirmBooking.php");
                        exit();

                    } else {
                        $_SESSION['dateMessage'] = 'The hotel is unavailable on those dates.';
                    }
                }
            }
        }
    }

    // Close the database connection
    mysqli_close($mysqli);
}



// View all the bookings of the user
function viewBookings($userId)
{
    // Connect to the database
    $mysqli = db_connect();
    if (!$mysqli) {
        return;
    }

    // Use the SQL JOIN to fetch booking information along with associated user and hotel details
    $query = "SELECT b.*, u.fullname, h.name, h.thumbnail, h.address
              FROM booking b
              INNER JOIN users u ON b.user_id = u.user_id
              INNER JOIN hotels h ON b.hotel_id = h.hotel_id
              WHERE b.user_id = ? AND b.cancelled = 0";

    $stmt = mysqli_prepare($mysqli, $query);
    mysqli_stmt_bind_param($stmt, "i", $userId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        $heading = <<<DELIMITER
            <table>
            <tr>
                <th> </th>
                <th> Hotel Name </th>
                <th> User Full Name </th>
                <th> Check In Date </th>
                <th> Check Out Date </th>
                <th> Total Cost </th>
            </tr>
        DELIMITER;
        $rows = '';

        while ($row = mysqli_fetch_assoc($result)) {

            $userId = $_SESSION['user_id'];
            $bookingId = $row['bookingNo'];

            $booking = [
                'bookingNo' => $bookingId,
                'hotelName' => $row['name'],
                'userFullName' => $row['fullname'],
                'checkInStartDate' => $row['checkInDate'],
                'checkOutEndDate' => $row['checkOutDate'],
                'totalCost' => $row['totalCost']
            ];

            $_SESSION['bookings'][$bookingId] = $booking; // Store each booking in the array

            $rowHTML = <<<DELIMITER
                <tr>
                    <td class="p-3"><img src="../static/img/{$row['thumbnail']}" alt="Book Thumbnail" class="bookCover"></td>
                    <td class="name p-3"> <h4> {$booking['hotelName']} </h4></td>
                    <td class="name p-3"> <h4> {$booking['userFullName']} </h4></td>
                    <td class="name p-2"> <h4> {$booking['checkInStartDate']} </h4></td>
                    <td class="name p-2"> <h4> {$booking['checkOutEndDate']} </h4></td>
                    <td class="name p-3"> <h4> R {$booking['totalCost']} </h4></td>
                    <form method="POST">
                    <input type="hidden" name="bookingNo" value="$bookingId">
                            <td class="p-2"><button type="submit" name="clearBookingButton" class="tranBack"><img class="homeButton"
                                src="../static/img/bin.gif" alt="Delete Booking" title="Delete Booking"
                                attribution="https://www.flaticon.com/free-animated-icons/document"></button></td>
                            <td class="p-2"><button type="submit" name="receiptButton" class="tranBack"><img class="homeButton"
                                src="../static/img/receipt.gif" alt="Receipt" title="Receipt"
                                attribution="https://www.flaticon.com/free-animated-icons/invoice"></button></td>
                    </form>
                </tr>
            DELIMITER;
            $rows .= $rowHTML;
        }

        $table = <<<DELIMITER
            {$heading}
            {$rows}
            </table>
        DELIMITER;
        echo $table;
    } else {
        echo '<h4> No booking found. </h4>';
    }

    mysqli_free_result($result);
    mysqli_close($mysqli);

}

// Function for generating the receipt with the booking information
function generateReceipt()
{

    $filename = "receipt.txt";

    $bookingId = $_POST['bookingNo']; // Retrieve the booking number from the button click
    $booking = $_SESSION['bookings'][$bookingId]; // Retrieve the specific booking information

    $data = [
        "Thank you for booking, " . $_SESSION['fullname'],
        "",
        "Hotel Name: " . $booking['hotelName'],
        "User Full Name: " . $booking['userFullName'],
        "Check In Date: " . $booking['checkInStartDate'],
        "Check Out Date: " . $booking['checkOutEndDate'],
        "Total Cost: R " . $booking['totalCost'],
        "",
        "We hope you enjoy your stay at " . $booking['hotelName']
    ];

    $file = fopen($filename, 'w');

    foreach ($data as $string) {
        fwrite($file, $string . PHP_EOL);
    }

    fclose($file);

    // Set headres to trigger the file download
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Content-Length: ' . filesize($filename));

    // Flush the output buffer
    ob_flush();
    flush();

    // Read and output the file contents
    readfile($filename);

    // Clean up
    unlink($filename);

    exit();
}

function deleteBookingforUser()
{

    // If there is a rental_id present
    if (isset($_POST['clearBookingButton'])) {
        $_SESSION['bookingNumber'] = $_POST['bookingNo'];
        $bookingId = $_SESSION['bookingNumber'];


        // Connect to the database
        $mysqli = db_connect();
        if (!$mysqli) {
            return;
        }

        // Create a new instance of the User class
        $bookingInstance = new Booking($mysqli);

        // Call the method from the User class
        $result = $bookingInstance->cancelBooking($bookingId);

        if ($result) {
            header("Location: viewBookings.php");

            mysqli_close($mysqli);
            exit();
        } else {
            echo "<h6> You can't delete this booking, it's less than 2 days away! </h6>";
            exit();
        }
    }
}



// If there is another booking at the time for the same user
function anotherBooking($userId, $checkInDate, $checkOutDate)
{
    // Connect to the database
    $mysqli = db_connect();
    if (!$mysqli) {
        return;
    }

    $query = "SELECT * FROM booking WHERE user_id = ? AND cancelled = 0 AND checkInDate <= ? AND checkOutDate >= ?";
    $stmt = mysqli_prepare($mysqli, $query);
    mysqli_stmt_bind_param($stmt, "iss", $userId, $checkOutDate, $checkInDate);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $alreadyABooking = mysqli_num_rows($result) > 0;

    mysqli_free_result($result);
    mysqli_close($mysqli);

    return $alreadyABooking;
}

// Check whether the hotel is available and show a message when the hotel is unavailable
function hotelIsAvailable($hotelId, $checkInDate, $checkOutDate)
{
    // Connect to the database
    $mysqli = db_connect();
    if (!$mysqli) {
        return;
    }

    $query = "SELECT * FROM booking WHERE hotel_id = ? AND cancelled = 0 AND checkInDate <= ? AND checkOutDate >= ?";
    $stmt = mysqli_prepare($mysqli, $query);
    mysqli_stmt_bind_param($stmt, "iss", $hotelId, $checkOutDate, $checkInDate);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $isAvailable = mysqli_num_rows($result) == 0;

    mysqli_free_result($result);
    mysqli_close($mysqli);

    return $isAvailable;
}

function confirmFinalBooking()
{

    if (isset($_POST['confirmFinalBooking'])) {
        $bookingInfo = $_SESSION['bookingInfo'];

        // Connect to the database
        $mysqli = db_connect();
        if (!$mysqli) {
            return;
        }

        if (isset($_POST['confirmFinalBooking'])) {
            $bookingInfo = $_SESSION['bookingInfo'];

            // Connect to the database
            $mysqli = db_connect();
            if (!$mysqli) {
                return;
            }

            $cancelled = 0;
            $completed = 0;

            // Insert the booking information into the booking table
            $query = "INSERT INTO booking (user_id, hotel_id, checkInDate, checkOutDate, totalCost, cancelled, completed) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($mysqli, $query);
            mysqli_stmt_bind_param($stmt, "iissiii", $bookingInfo['userId'], $bookingInfo['hotelId'], $bookingInfo['checkInDate'], $bookingInfo['checkOutDate'], $bookingInfo['totalCost'], $cancelled, $completed);

            if (mysqli_stmt_execute($stmt)) {
                // Clear the booking information from session
                unset($_SESSION['bookingInfo']);
                header("Location: ./payment.php");
                exit();
            } else {
                echo 'Error creating booking: ' . mysqli_error($mysqli);
            }

            // Close the statement and database connection
            mysqli_stmt_close($stmt);
            mysqli_close($mysqli);
        }
    }
}



// This is where the user can still choose another hotel instead
function confirmBooking($userId, $hotelId)
{

    // Connect to the database
    $mysqli = db_connect();
    if (!$mysqli) {
        return;
    }

    if (isset($_SESSION['bookingInfo'])) {
        $bookingInfo = $_SESSION['bookingInfo'];
        $fullname = $_SESSION['fullname'];

        $hotel = new Hotel($mysqli, $hotelId);

        // Fetch hotel information using the provided hotel ID
        $targetHotelData = $hotel->viewHotelsById();

        if ($targetHotelData) {

            $_SESSION['name'] =  $targetHotelData['name'];

            $information = <<<DELIMETER
        <h2 class="mb-5"> Your Booking Summary </h2>
        <img src='../static/img/{$targetHotelData['thumbnail']}' alt='Book Thumbnail' class='hotelImage'>
        <div class="d-flex justify-content-center align-items-center my-5">
        <table class="summaryTable my-5 p-5">
            <tr>
                <td class="p-5"> <h4> Hotel Name: </h4> </td>
                <td class="p-5"> <h5> {$targetHotelData['name']} </h5> </td>
            </tr>
            <tr>
                <td class="p-5"> <h4> User Full Name: </h4></td>
                <td class="p-5"> <h5> {$fullname} </h5> </td>
            </tr>
            <tr>
                <td class="p-5"> <h4> Check In Date: </h4></td>
                <td class="p-5"> <h5> {$bookingInfo['checkInDate']} </h5> </td>
            </tr>
            <tr>
                <td class="p-5"> <h4> Check Out Date: </h4></td>
                <td class="p-5"> <h5> {$bookingInfo['checkOutDate']} </h5> </td>
            </tr>
            <tr>
                <td class="p-5"> <h4> Total Cost: </h4></td>
                <td class="p-5"> <h5> R {$bookingInfo['totalCost']} </h5> </td>
            </tr>
        </table>
        </div>
        <form method="POST">
            <div class="d-flex justify-content-center align-items-center">
                <button type="submit" name="confirmFinalBooking" class="editButton p-3 my-3 mx-5"> Confirm Booking </button>
                <button type="submit" name="receiptButton" class="editButton p-3 my-3 mx-5"> Generate Receipt </button>
            </div>
        </form>
        DELIMETER;

            echo $information;
        }
    } else {
        echo '<h4> Booking information not found. Please go back and book again. </h4>';
    }

    mysqli_close($mysqli);
}


function generateReceiptforIndividual()
{

    $filename = "receipt.txt";

    $data = [
        "Thank you for booking, " . $_SESSION['fullname'],
        "",
        "Hotel Name: " . $_SESSION['name'],
        "User Full Name: " . $_SESSION['fullname'],
        "Check In Date: " . $_SESSION['bookingInfo']['checkInDate'],
        "Check Out Date: " . $_SESSION['bookingInfo']['checkOutDate'],
        "Total Cost: R " . $_SESSION['bookingInfo']['totalCost'],
        "",
        "We hope you enjoy your stay at " . $_SESSION['name']
    ];

    $file = fopen($filename, 'w');

    foreach ($data as $string) {
        fwrite($file, $string . PHP_EOL);
    }

    fclose($file);

    // Set headres to trigger the file download
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Content-Length: ' . filesize($filename));

    // Flush the output buffer
    ob_flush();
    flush();

    // Read and output the file contents
    readfile($filename);

    // Clean up
    unlink($filename);
    exit();
}



?>