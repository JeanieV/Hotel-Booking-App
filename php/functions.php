<?php

session_start();


// ---------------------------------------------------------
// Classes and Methods
// ---------------------------------------------------------

// Hotel class
class Hotel
{
    private $hotelId;
    private $mysqli;

    public function __construct($mysqli, $hotelId)
    {
        $this->mysqli = $mysqli;
        $this->hotelId = $hotelId;
    }

    // Calculate the total cost by fetching the pricePerNight
    public function calculateCost()
    {
        $query = "SELECT pricePerNight FROM hotels WHERE hotel_id=?";
        $stmt = mysqli_prepare($this->mysqli, $query);
        mysqli_stmt_bind_param($stmt, "i", $this->hotelId);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        $hotelData = mysqli_fetch_assoc($result);

        mysqli_stmt_close($stmt);

        return $hotelData;
    }


    // Method to select everything from the hotels table
    public function viewHotelsById()
    {

        $query = "SELECT * FROM hotels WHERE hotel_id=?";
        $stmt = mysqli_prepare($this->mysqli, $query);
        mysqli_stmt_bind_param($stmt, "i", $this->hotelId);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        $hotelData = mysqli_fetch_assoc($result);

        mysqli_stmt_close($stmt);

        return $hotelData;
    }

    // Compare the one hotel with another
    public static function compareHotels(Hotel $hotel1, Hotel $hotel2)
    {
        $hotel1Cost = $hotel1->calculateCost();
        $hotel2Cost = $hotel2->calculateCost();

        if ($hotel1Cost < $hotel2Cost) {
            return $hotel1;
        } else {
            return $hotel2;
        }
    }

    // If the hotels relate based on specific price difference
    public function getRelatedHotels($priceDifference)
    {
        // Fetch the current hotel's information
        $currentHotel = $this->viewHotelsById();

        // Calculate the price range within which related hotels should fall
        $minPrice = $currentHotel['pricePerNight'] - $priceDifference;
        $maxPrice = $currentHotel['pricePerNight'] + $priceDifference;

        $relatedHotels = array();

        // Query for related hotels within the specified price range
        $query = "SELECT * FROM hotels WHERE pricePerNight >= ? AND pricePerNight <= ? AND hotel_id != ?";
        $stmt = mysqli_prepare($this->mysqli, $query);
        mysqli_stmt_bind_param($stmt, "iii", $minPrice, $maxPrice, $this->hotelId);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        while ($row = mysqli_fetch_assoc($result)) {
            $relatedHotel = new Hotel($this->mysqli, $row['hotel_id']);
            $relatedHotels[] = $relatedHotel;
        }

        mysqli_stmt_close($stmt);

        return $relatedHotels;
    }

    // Method to add hotel to system from ADMIN
    public function addHotel($name, $pricePerNight, $thumbnail, $features, $type, $beds, $rating, $address)
    {
        $query = "INSERT INTO hotels (name, pricePerNight, thumbnail, features, type, beds, rating, address ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($this->mysqli, $query);
        mysqli_stmt_bind_param($stmt, "sibssiis", $name, $pricePerNight, $thumbnail, $features, $type, $beds, $rating, $address);
        $result = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        return $result;
    }

    // Method to update the hotel information from ADMIN
    public function adminHotelEdit($hotelId, $name, $pricePerNight, $features, $type, $beds, $rating, $address)
    {
        $query = "UPDATE hotels SET name = ?, pricePerNight = ?, features = ?, type = ?, beds = ?, rating = ?, address = ? WHERE hotel_id = ?";
        $stmt = mysqli_prepare($this->mysqli, $query);
        mysqli_stmt_bind_param($stmt, "sissiisi", $name, $pricePerNight, $features, $type, $beds, $rating, $address, $hotelId);
        $result = mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
        return $result;
    }

    // Method to delete the clicked on hotel
    public function deleteHotel($hotelId)
    {
        $query = "DELETE FROM hotels WHERE hotel_id=?";
        $stmt = mysqli_prepare($this->mysqli, $query);
        mysqli_stmt_bind_param($stmt, "i", $hotelId);
        $result = mysqli_stmt_execute($stmt);


        mysqli_stmt_close($stmt);
        return $result;
    }

}

// User Class
class User
{
    private $mysqli;

    public function __construct($mysqli)
    {
        $this->mysqli = $mysqli;
    }

    // Method to update the user information
    public function editUser($userId, $username, $fullname, $address, $email, $phoneNumber)
    {
        $query = "UPDATE users SET username = ?, fullname = ?, address = ?, email = ?, phoneNumber = ? WHERE user_id = ?";

        $stmt = mysqli_prepare($this->mysqli, $query);
        mysqli_stmt_bind_param($stmt, "sssssi", $username, $fullname, $address, $email, $phoneNumber, $userId);
        $result = mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
        return $result;
    }

    // Method to edit the user information from ADMIN
    public function adminUserEdit($userId, $username, $fullname, $address, $password, $email, $phoneNumber)
    {
        $query = "UPDATE users SET username = ?, fullname = ?, address = ?, password = ?, email = ?, phoneNumber = ? WHERE user_id = ?";

        $stmt = mysqli_prepare($this->mysqli, $query);
        mysqli_stmt_bind_param($stmt, "ssssssi", $username, $fullname, $address, $password, $email, $phoneNumber, $userId);
        $result = mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
        return $result;
    }

    // Method to make sure that only the information is changed that the user interacted with.
    public function getUserData($userId)
    {
        $query = "SELECT * FROM users WHERE user_id = ?";

        $stmt = mysqli_prepare($this->mysqli, $query);
        mysqli_stmt_bind_param($stmt, "i", $userId);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        $userData = mysqli_fetch_assoc($result);

        mysqli_stmt_close($stmt);

        return $userData;
    }

    // Method to delete the clicked on user
    public function deleteUser($userId)
    {
        $query = "DELETE FROM users WHERE user_id=?";
        $stmt = mysqli_prepare($this->mysqli, $query);
        mysqli_stmt_bind_param($stmt, "i", $userId);
        $result = mysqli_stmt_execute($stmt);


        mysqli_stmt_close($stmt);
        return $result;
    }

}

class Booking
{

    private $mysqli;

    public function __construct($mysqli)
    {
        $this->mysqli = $mysqli;
    }

    // Method to add a booking for the user
    public function addBooking($userId, $hotelId, $checkInDate, $checkOutDate, $totalCost, $cancelled, $completed)
    {
        $query = "INSERT INTO booking (user_id, hotel_id, checkInDate, checkOutDate, totalCost, cancelled, completed) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($this->mysqli, $query);
        mysqli_stmt_bind_param($stmt, "iiddiii", $userId, $hotelId, $checkInDate, $checkOutDate, $totalCost, $cancelled, $completed);
        $result = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        return $result;
    }

    // Cancel booking if the user clicks on the delete button (change the cancel column to 1)
    public function cancelBooking($bookingId)
    {
        // Find out if the cancellation is more than 2 days away
        $query = "SELECT checkInDate FROM booking WHERE bookingNo = ?";

        $stmt = mysqli_prepare($this->mysqli, $query);
        mysqli_stmt_bind_param($stmt, "i", $bookingId);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $checkInDate);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);

        // Calculate the difference between check-in date and current date
        $currentDate = new DateTime();
        $checkInDateTime = new DateTime($checkInDate);
        $interval = $currentDate->diff($checkInDateTime);

        // Check if the difference is more than 2 days (48 hours)
        if ($interval->days > 2 || ($interval->days === 2 && $interval->h >= 0)) {
            // The booking can be canceled
            $updateQuery = "UPDATE booking SET cancelled = 1 WHERE bookingNo = ?";

            $updateStmt = mysqli_prepare($this->mysqli, $updateQuery);
            mysqli_stmt_bind_param($updateStmt, "i", $bookingId);
            $result = mysqli_stmt_execute($updateStmt);
            mysqli_stmt_close($updateStmt);

            return $result;
        } else {
            // The booking cannot be canceled
            return false;
        }
    }

    // Set the cancelled column to 1 if the checkInDate is the same as current date
    public function completedBooking($bookingId)
    {
        // Fetch the checkInDate from the database
        $query = "SELECT checkInDate FROM booking WHERE bookingNo = ?";
        $stmt = mysqli_prepare($this->mysqli, $query);
        mysqli_stmt_bind_param($stmt, "i", $bookingId);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $checkInDate);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);

        // Convert the checkInDate to a DateTime object
        $checkInDateTime = new DateTime($checkInDate);
        $currentDateTime = new DateTime();

        // Compare the checkInDate with the current date
        if ($checkInDateTime <= $currentDateTime) {
            // The booking is completed
            $updateQuery = "UPDATE booking SET completed = 1 WHERE bookingNo = ?";

            $updateStmt = mysqli_prepare($this->mysqli, $updateQuery);
            mysqli_stmt_bind_param($updateStmt, "i", $bookingId);
            $result = mysqli_stmt_execute($updateStmt);
            mysqli_stmt_close($updateStmt);

            return $result;
        } else {
            return false;
        }
    }

    // Delete booking if clicked on
    public function deleteBooking($bookingNo)
    {
        $query = "DELETE FROM booking WHERE bookingNo=?";
        $stmt = mysqli_prepare($this->mysqli, $query);
        mysqli_stmt_bind_param($stmt, "i", $bookingNo);
        $result = mysqli_stmt_execute($stmt);


        mysqli_stmt_close($stmt);
        return $result;
    }

    // Edit the clicked booking from ADMIN
    public function adminBookingEdit($bookingNo, $checkInDate, $checkOutDate)
    {
        // When the dates are changed, the total cost needs to update as well
        $newTotalCost = $this->calculateUpdatedTotalCost($bookingNo, $checkInDate, $checkOutDate);

        // Update the checkInDate, checkOutDate, and totalCost
        $query = "UPDATE booking SET checkInDate = ?, checkOutDate = ?, totalCost = ? WHERE bookingNo = ?";
        $stmt = mysqli_prepare($this->mysqli, $query);
        mysqli_stmt_bind_param($stmt, "ssdi", $checkInDate, $checkOutDate, $newTotalCost, $bookingNo);
        $result = mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
        return $result;
    }

    // If the dates change, then the total cost needs to update as well
    private function calculateUpdatedTotalCost($bookingNo, $checkInDate, $checkOutDate)
    {
        // Calculate the difference in days between checkInDate and checkOutDate
        $checkInDateTime = new DateTime($checkInDate);
        $checkOutDateTime = new DateTime($checkOutDate);
        $interval = $checkInDateTime->diff($checkOutDateTime);
        $numOfDays = $interval->days;

        // Querying the pricePerNight from Hotel table(needs to join)
        $query = "SELECT h.pricePerNight FROM booking b
              INNER JOIN hotels h ON b.hotel_id = h.hotel_id
              WHERE b.bookingNo = ?";

        $stmt = mysqli_prepare($this->mysqli, $query);
        mysqli_stmt_bind_param($stmt, "i", $bookingNo);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $pricePerNight);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);

        // Calculate the new totalCost that will update as the dates update
        $newTotalCost = $numOfDays * $pricePerNight;

        return $newTotalCost;
    }

    // Get all the information from the booking table
    public function getBookingData($bookingNo)
    {
        $query = "SELECT * FROM booking WHERE bookingNo = ?";

        $stmt = mysqli_prepare($this->mysqli, $query);
        mysqli_stmt_bind_param($stmt, "i", $bookingNo);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        $userData = mysqli_fetch_assoc($result);

        mysqli_stmt_close($stmt);

        return $userData;
    }
}

// Staff class
class Staff
{
    private $mysqli;

    public function __construct($mysqli)
    {
        $this->mysqli = $mysqli;
    }

    // Method to update the user information
    public function addStaff($employee_number, $role, $fullname)
    {
        $query = "INSERT INTO staff (employee_number, role, fullname) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($this->mysqli, $query);
        mysqli_stmt_bind_param($stmt, "sss", $employee_number, $role, $fullname);
        $result = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        return $result;
    }

    // Admin can make edits to the staff
    public function adminEditStaffmember($staffId, $employee_number, $fullname, $role)
    {
        $query = "UPDATE staff SET employee_number = ?, fullname = ?, role = ? WHERE staff_id = ?";

        $stmt = mysqli_prepare($this->mysqli, $query);
        mysqli_stmt_bind_param($stmt, "sssi", $employee_number, $fullname, $role, $staffId);
        $result = mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
        return $result;
    }

    // Method to make sure that only the information is changed that the user interacted with.
    public function getUserStaff($staffId)
    {
        $query = "SELECT * FROM staff WHERE staff_id = ?";

        $stmt = mysqli_prepare($this->mysqli, $query);
        mysqli_stmt_bind_param($stmt, "i", $staffId);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        $userData = mysqli_fetch_assoc($result);

        mysqli_stmt_close($stmt);

        return $userData;
    }

    // Method to delete the clicked on user
    public function deleteStaff($staffId)
    {
        $query = "DELETE FROM staff WHERE staff_id=?";
        $stmt = mysqli_prepare($this->mysqli, $query);
        mysqli_stmt_bind_param($stmt, "i", $staffId);
        $result = mysqli_stmt_execute($stmt);


        mysqli_stmt_close($stmt);
        return $result;
    }
}


// ---------------------------------------------------------
// Buttons and Redirects
// ---------------------------------------------------------

// Sign Up a new user
if (isset($_POST['newUserButton'])) {
    header("Location: ./users/signUserUp.php");
}

// Logout
if (isset($_POST['logOutButton'])) {
    session_unset();
    session_destroy();

    header("Location: ../index.php");
    exit();
}

// Final LogoutButton
if (isset($_POST['logOutButtonFinal'])) {
    unset($_SESSION['bookingInfo']);
    session_unset();
    session_destroy();

    header("Location: ./index.php");
    exit();
}

// Return to homepage
if (isset($_POST['returnHome'])) {
    header("Location: ../index.php");
}

// Return home for staff members
if (isset($_POST['staffReturnHome'])) {
    header("Location: ../index.php");
}

// Admin, return to user page
if (isset($_POST['returnAdminUser'])) {
    header("Location: ../staff/viewUser.php");
}

// Admin, return to hotel page
if (isset($_POST['returnAdminHotel'])) {
    header("Location: ../staff/viewHotel.php");
}

// Admin, return to booking page
if (isset($_POST['returnAdminBooking'])) {
    header("Location: ../staff/viewBooking.php");
}

// Return to staff page
if (isset($_POST['returnStaffHome'])) {
    header("Location: ../staff/staff.php");
}

// Return Admin back to staff view page
if(isset($_POST['returnStaffView'])){
    header("Location: ../staff/viewStaff.php");
}

// Return to Hotel Page after clicking on viewing a Hotel
if (isset($_POST['returntoHotelPage'])) {
    header("Location: ../hotels/hotel.php");
}

// Edit Profile Button
if (isset($_POST['editProfileButton'])) {
    header("Location: ../users/viewAllInfo.php");
}

// View Marbella Elix
if (isset($_POST['marbellaElixButton'])) {
    header("Location: ../hotels/marbellaElix.php");
}

// View Royal Senses
if (isset($_POST['royalSensesButton'])) {
    header("Location: ./hotels/royalSenses.php");
}

// View The View
if (isset($_POST['theViewButton'])) {
    header("Location: ./hotels/theView.php");
}

// View Angsana Corfu
if (isset($_POST['angsanaButton'])) {
    header("Location: ./hotels/angsanaCorfu.php");
}

// View The Rooster
if (isset($_POST['theRoosterButton'])) {
    header("Location: ./hotels/theRooster.php");
}

// View The Rooster
if (isset($_POST['destinoButton'])) {
    header("Location: ./hotels/destinoPacha.php");
}

// Return to the editProfile.php
if (isset($_POST['returnToViewAllInfo'])) {
    header("Location: ../users/viewAllInfo.php");
}

// Go to edit Page
if (isset($_POST['goToEditPage'])) {
    header("Location: ../users/editProfile.php");
}

// // Go to confirmBooking.php
if (isset($_POST['bookingsButton'])) {
    header("Location: ../users/viewBookings.php");
}

// Go to viewBooking
if (isset($_POST['staffBookingView'])) {
    header("Location: ../staff/viewBooking.php");
}

// Go to viewHotel
if (isset($_POST['staffViewHotels'])) {
    header("Location: ../staff/viewHotel.php");
}

// Go to viewUser
if (isset($_POST['staffViewInfo'])) {
    header("Location: ../staff/viewUser.php");
}

// Admin, go back to viewUser.php
if (isset($_POST['adminReturnUser'])) {
    header("Location: ../staff/viewUser.php");
}

// Admin, add new hotel
if (isset($_POST['adminNewHotel'])) {
    header("Location: ../admin/addHotel.php");
}

// ---------------------------------------------------------
// Database Connection
// ---------------------------------------------------------

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
            header("Location: ./hotels/hotel.php");
            exit();
        } else {
            // User does not exist or wrong password, redirect to signUp.php
            mysqli_stmt_close($stmt);
            mysqli_close($mysqli);
            header("Location: ./users/signUserUp.php");
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
                    src="../../static/img/bed.png" alt="Sleeps" title="Sleeps"
                    attribution="https://www.flaticon.com/free-icons/bed"> </td>
                    <td class="features p-3"> <p> {$targetHotelData['beds']} people </p> </td>
                </tr>
                <tr>
                <td class="p-4 text-center"> <img class="sleeps p-2"
                src="../../static/img/hotel.png" alt="Type" title="Type"
                attribution="https://www.flaticon.com/free-icons/hotel"> </td>
                    <td class="features p-3"> <p> {$targetHotelData['type']} </p> </td>
                </tr>
                <tr>
                <td class="p-4 text-center"> <img class="sleeps p-2"
                src="../../static/img/star.png" alt="Rating" title="Rating"
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
    // Get the hotel_id from the button
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

        // A card for each hotel where the price per night difference is more or less than R 5000
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

                // Compare the price per night using the compareHotels method from Hotel Class
                $betterPrice = Hotel::compareHotels($hotel, $relatedHotel);

                // Compare ratings
                $targetRating = $hotel->viewHotelsById()['rating'];
                $relatedRating = $relatedHotel->viewHotelsById()['rating'];

                // Conditional Styling
                $priceClass = '';
                $ratingClass = '';

                if ($betterPrice === $hotel) {
                    $priceClass = 'expensive-price'; // Apply a class for more expensive price
                    $priceImage = '<img src="../../static/img/expensive.png" class="corner-image" alt="Hotel image" attribution="https://www.flaticon.com/free-icons/expensive">';
                } else {
                    $priceClass = 'cheaper-price'; // Apply a class for cheaper price
                    $priceImage = '<img src="../../static/img/best-price.png" class="corner-image" alt="Hotel image" attribution="https://www.flaticon.com/free-icons/best-price">';
                }

                if ($relatedRating > $targetRating) {
                    $ratingClass = 'better-rating'; // Apply a class for better rating
                    $ratingImage = '<img src="../../static/img/best-rating.png" class="corner-image" alt="Hotel image" attribution="https://www.flaticon.com/free-icons/expertise">';
                } elseif ($relatedRating < $targetRating) {
                    $ratingClass = 'worse-rating'; // Apply a class for worse rating
                    $ratingImage = '<img src="../../static/img/bad-rating.png" class="corner-image" alt="Hotel image" attribution="https://www.flaticon.com/free-icons/thumbs-down">';
                }

                $compare = <<<DELIMETER
                <div class="col-sm-6">
                    <div class="container mt-3 mb-5">
                        <div class="card img-fluid">
                            <img class="card-img-top hotelImage" src="../../static/img/{$thumbnail}" alt="Hotel image">
                            
                            <div class="card-img-overlay">
                                <div class="corner-background p-1 mb-3">
                                    $priceImage
                                    $ratingImage
                                </div>
                                
                                <div class="d-flex justify-content-center align-items-center">
                                    <div class="background {$priceClass} {$ratingClass}">
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
        '1' => '../hotels/marbellaElix.php',
        '2' => '../hotels/royalSenses.php',
        '3' => '../hotels/theView.php',
        '4' => '../hotels/angsanaCorfu.php',
        '5' => '../hotels/theRooster.php',
        '6' => '../hotels/destinoPacha.php',

    );

    if (array_key_exists($hotelId, $hotelPhpFiles)) {
        return $hotelPhpFiles[$hotelId];
    } else {
        return '../hotels/hotel.php';
    }
}


// ---------------------------------------------------------
// CRUD Operations (USER SIDE)
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
            header("Location: ./deletedPage.php");
            $_SESSION['deletedAccount'] = '<h2 class="p-3">Your Account has been deleted</h2>';

            mysqli_close($mysqli);
            exit();
        } else {
            // Redirect back to the same page or display an error message
            header("Location: ./viewAllInfo.php");
            exit();
        }
    }
}


// ---------------------------------------------------------
// Bookings
// ---------------------------------------------------------

// Make sure that the info the user selected is known
function addTemporaryBooking()
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

                        // Store the booking information in session variables
                        $_SESSION['bookingInfo'] = array(
                            'userId' => $userId,
                            'hotelId' => $hotelId,
                            'checkInDate' => $checkInDate,
                            'checkOutDate' => $checkOutDate,
                            'totalCost' => $totalCost,
                        );

                        header("Location: ../users/confirmBooking.php");
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
                    <td class="p-3"><img src="../../static/img/{$row['thumbnail']}" alt="Book Thumbnail" class="bookCover"></td>
                    <td class="name p-3"> <h4> {$booking['hotelName']} </h4></td>
                    <td class="name p-3"> <h4> {$booking['userFullName']} </h4></td>
                    <td class="name p-2"> <h4> {$booking['checkInStartDate']} </h4></td>
                    <td class="name p-2"> <h4> {$booking['checkOutEndDate']} </h4></td>
                    <td class="name p-3"> <h4> R {$booking['totalCost']} </h4></td>
                    <form method="POST">
                    <input type="hidden" name="bookingNo" value="$bookingId">
                            <td class="p-2"><button type="submit" name="clearBookingButton" class="tranBack"><img class="homeButton"
                                src="../../static/img/bin.gif" alt="Delete Booking" title="Delete Booking"
                                attribution="https://www.flaticon.com/free-animated-icons/document"></button></td>
                            <td class="p-2"><button type="submit" name="receiptButton" class="tranBack"><img class="homeButton"
                                src="../../static/img/receipt.gif" alt="Receipt" title="Receipt"
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
            header("Location: ./viewBookings.php");

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

            $_SESSION['name'] = $targetHotelData['name'];

            $information = <<<DELIMETER
        <h2 class="mb-5"> Your Booking Summary </h2>
        <img src='../../static/img/{$targetHotelData['thumbnail']}' alt='Book Thumbnail' class='hotelImage'>
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


function confirmFinalBooking()
{
    if (isset($_POST['confirmFinalBooking'])) {
        $bookingInfo = $_SESSION['bookingInfo'];

        // Connect to the database
        $mysqli = db_connect();
        if (!$mysqli) {
            return;
        }

        $cancelled = 0;
        $completed = 0;

        // Compare the checkInDate with the current date
        $checkInDateTime = new DateTime($bookingInfo['checkInDate']);
        $currentDateTime = new DateTime();

        if ($checkInDateTime <= $currentDateTime) {
            $bookingInstance = new Booking($mysqli);
            $completed = $bookingInstance->completedBooking(mysqli_insert_id($mysqli));
        }

        // Insert the booking information into the booking table
        $query = "INSERT INTO booking (user_id, hotel_id, checkInDate, checkOutDate, totalCost, cancelled, completed) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($mysqli, $query);
        mysqli_stmt_bind_param($stmt, "iissiii", $bookingInfo['userId'], $bookingInfo['hotelId'], $bookingInfo['checkInDate'], $bookingInfo['checkOutDate'], $bookingInfo['totalCost'], $cancelled, $completed);

        if (mysqli_stmt_execute($stmt)) {
            // Clear the booking information from session

            header("Location: ../payment.php");
            exit();
        } else {
            echo 'Error creating booking: ' . mysqli_error($mysqli);
        }

        // Close the statement and database connection
        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
    }
}

// After the booking has been confirmed
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
        "We hope you enjoy your stay at " . $_SESSION['name'] . "!"
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


// ---------------------------------------------------------
// CMS Employee Section
// ---------------------------------------------------------


function employeeLogin()
{
    if (isset($_POST['id'])) {
        $id = $_POST['id'];

        // Connect to the database
        $mysqli = db_connect();
        if (!$mysqli) {
            return;
        }

        // Check if the email and password match in the database
        $query = "SELECT * FROM staff WHERE employee_number = ?";

        // Prepare the statement to bind the parameters (email and password)
        $stmt = mysqli_prepare($mysqli, $query);
        mysqli_stmt_bind_param($stmt, "s", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        // If there is information in the table, find the username that match
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            // Make sure that the user_id, username and fullname is known
            $_SESSION['staff_id'] = $row['staff_id'];
            $_SESSION['staffFullName'] = $row['fullname'];
            $_SESSION['role'] = $row['role'];

            mysqli_stmt_close($stmt);
            mysqli_close($mysqli);
            header("Location: ./staff/staff.php");
            exit();
        } else {
            // User does not exist or wrong password, redirect to signUp.php
            mysqli_stmt_close($stmt);
            mysqli_close($mysqli);
            header("Location: ./index.php");
            exit();
        }
    }
}

// Add new employee to the system
function addNewEmployee()
{
    // If the sign-up button is clicked
    if (isset($_POST['employeeSignUpButton'])) {

        // Store the input fields as variables
        $employee_number = $_POST['employee_number'];
        $fullname = $_POST['employeeFullname'];
        $role = $_POST['employee-role'];

        // Connect to the database
        $mysqli = db_connect();
        if (!$mysqli) {
            return;
        }

        // Check if employee with the same number already exists
        $checkQuery = "SELECT employee_number FROM staff WHERE employee_number = ?";
        $checkStmt = mysqli_prepare($mysqli, $checkQuery);
        mysqli_stmt_bind_param($checkStmt, "s", $employee_number);
        mysqli_stmt_execute($checkStmt);
        mysqli_stmt_store_result($checkStmt);

        // If an employee with the same number exists
        if (mysqli_stmt_num_rows($checkStmt) > 0) {
            $_SESSION['addEmployee'] = "Employee_number already exists.";
            header("Location: ./staff/signUp.php");
            mysqli_stmt_close($checkStmt);
            mysqli_close($mysqli);
            exit();
        }

        // Close the check statement
        mysqli_stmt_close($checkStmt);

        // Create a new instance of the Staff class
        $staff = new Staff($mysqli);

        // Call the method from the Staff class to add employee
        $result = $staff->addStaff($employee_number, $role, $fullname);

        // If the new employee has been added
        if ($result) {
            echo '<h2 class="p-3">Success: Employee added successfully! <br> Head back to Staff Page </h2>';
            mysqli_close($mysqli);
            exit();
        } else {
            // Failed to add employee
            $_SESSION['addEmployee'] = "New Employee has not been added";
            header("Location: ./staff/signUp.php");
            mysqli_close($mysqli);
            exit();
        }
    }
}

// Function so that the employees can view the users on the system
function staffViewUsers()
{
    if ($_SESSION['role'] != 'Admin') {
        // Connect to the database
        $mysqli = db_connect();
        if (!$mysqli) {
            return;
        }

        // When the user clicks on the sort button or the search button
        if (isset($_POST['sortUserButton']) || isset($_POST['search'])) {
            // Store the input value or choice
            $sortOption = $_POST['sortUsers'];
            $searching = $_POST['search'];

            // If statements where the sorting and searching takes place
            if ($sortOption === 'sortUsersA-Username') {
                $query = "SELECT * FROM users WHERE fullname LIKE '%$searching%' ORDER BY username";

            } elseif ($sortOption === 'sortUsersA-Number') {
                $query = "SELECT * FROM users WHERE fullname LIKE '%$searching%' ORDER BY user_id";

            } elseif ($sortOption === 'sortUsersA-NumberD') {
                $query = "SELECT * FROM users WHERE fullname LIKE '%$searching%' ORDER BY user_id DESC";

            } else {
                $query = "SELECT * FROM users WHERE fullname LIKE '%$searching%' 
            OR email LIKE '%$searching%' 
            OR username LIKE '%$searching%'
            OR address LIKE '%$searching%'
            OR password LIKE '%$searching%'
            OR phoneNumber LIKE '%$searching%'";

            }
        } elseif (isset($_POST['clearFilterButton'])) {
            $query = "SELECT * FROM users";
        } else {
            $query = "SELECT * FROM users";
        }

        $result = mysqli_query($mysqli, $query);

        if (mysqli_num_rows($result) > 0) {
            $heading = <<<DELIMITER
            <table>
            <h2 class="mb-5"> User Information </h2>
            <tr>
                <th> Username </th>
                <th> Full Name </th>
                <th> Address </th>
                <th> Password </th>
                <th> Email </th>
                <th> Phone Number </th>
            </tr>
        DELIMITER;
            $rows = '';

            while ($row = mysqli_fetch_assoc($result)) {
                $rowHTML = <<<DELIMITER
                <tr>
                    <td class="name p-4"> <p> {$row['username']} </p> </td>
                    <td class="name p-4"> <p> {$row['fullname']} </p> </td> 
                    <td class="name p-4"> <p> {$row['address']} </p> </td>
                    <td class="name p-4"> <p> {$row['password']} </p> </td>
                    <td class="name p-4"> <p> {$row['email']} </p> </td>
                    <td class="name p-4"> <p> {$row['phoneNumber']} </p> </td>
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
            echo 'No users found.';
        }

        mysqli_free_result($result);
        mysqli_close($mysqli);
    }
}


// Function so that the employees can view the hotels on the system
function staffViewHotels()
{

    // Connect to the database
    $mysqli = db_connect();
    if (!$mysqli) {
        return;
    }

    // When the user clicks on the sort button or the search button
    if (isset($_POST['sortUserButton']) || isset($_POST['search'])) {
        // Store the input value or choice
        $sortOption = $_POST['sortUsers'];
        $searching = $_POST['search'];


        // If statements where the sorting and searching takes place
        if ($sortOption === 'sortUsersA-name') {

            $query = "SELECT * FROM hotels WHERE name LIKE '%$searching%' ORDER BY name";

        } elseif ($sortOption === 'sortUsersA-priceA') {

            $query = "SELECT * FROM hotels WHERE pricePerNight LIKE '%$searching%' ORDER BY pricePerNight";

        } elseif ($sortOption === 'sortUsersA-priceD') {

            $query = "SELECT * FROM hotels WHERE pricePerNight LIKE '%$searching%' ORDER BY pricePerNight DESC";

        } elseif ($sortOption === 'sortUsersA-rating') {

            $query = "SELECT * FROM hotels WHERE rating LIKE '%$searching%' ORDER BY rating DESC";

        } elseif ($sortOption === 'sortUsersA-ratingPoor') {

            $query = "SELECT * FROM hotels WHERE rating LIKE '%$searching%' ORDER BY rating";

        } else {

            $query = "SELECT * FROM hotels WHERE name LIKE '%$searching%' 
            OR pricePerNight LIKE '%$searching%' 
            OR features LIKE '%$searching%'
            OR type LIKE '%$searching%'
            OR beds LIKE '%$searching%'
            OR rating LIKE '%$searching%'
            OR address LIKE '%$searching%'";

        }
    } elseif (isset($_POST['clearFilterButton'])) {
        $query = "SELECT * FROM hotels";
    } else {
        $query = "SELECT * FROM hotels";
    }

    $result = mysqli_query($mysqli, $query);

    if (mysqli_num_rows($result) > 0) {
        $heading = <<<DELIMITER
                            <table>
                            <h2 class="my-5"> Hotel Information </h2>
                            <tr>
                            <th> </th>
                            <th class="heading"> Hotel Name </th>
                            <th class="heading"> Price Per Night </th>
                            <th class="heading"> Features </th>
                            <th class="heading"> Type </th>
                            <th class="heading"> Beds </th>
                            <th class="heading"> Rating </th>
                            <th class="heading"> Address </th>
                            </tr>
                        DELIMITER;
        $rows = '';

        while ($row = mysqli_fetch_assoc($result)) {

            $rowHTML = <<<DELIMITER
                            <tr>
                                <td class="p-3"><img src="../../static/img/{$row['thumbnail']}" alt="Book Thumbnail" class="bookCoverHotel"></td>
                                <td class="p-2"> <h4> {$row['name']} </h4> </td>
                                <td class="p-2"> <h4> R {$row['pricePerNight']} </h4> </td> 
                                <td class="name p-2"> <h4> {$row['features']} </h4> </td>
                                <td class="p-2"> <h4> {$row['type']} </h4> </td>
                                <td class="p-2"> <h4> {$row['beds']} </h4> </td>
                                <td class="p-2"> <h4> {$row['rating']} </h4> </td>
                                <td class="p-2"> <h4> {$row['address']} </h4> </td>
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
        echo 'No users found.';
    }

    mysqli_free_result($result);
    mysqli_close($mysqli);
}

function staffViewBookings()
{
    // Connect to the database
    $mysqli = db_connect();
    if (!$mysqli) {
        return;
    }

    // When the user clicks on the sort button or the search button
    if (isset($_POST['sortUserButton']) || isset($_POST['search'])) {
        // Store the input value or choice
        $sortOption = $_POST['sortUsers'];
        $searching = $_POST['search'];

        // If statements where the sorting and searching takes place
        if ($sortOption === 'sortUsersA-daysA') {

            $query = "SELECT b.*, u.fullname, h.name, h.thumbnail, h.address
            FROM booking b
            INNER JOIN users u ON b.user_id = u.user_id
            INNER JOIN hotels h ON b.hotel_id = h.hotel_id
            ORDER BY DATEDIFF(checkOutDate, checkInDate) DESC";

        } elseif ($sortOption === 'sortUsersA-daysD') {

            $query = "SELECT b.*, u.fullname, h.name, h.thumbnail, h.address
            FROM booking b
            INNER JOIN users u ON b.user_id = u.user_id
            INNER JOIN hotels h ON b.hotel_id = h.hotel_id
            ORDER BY DATEDIFF(checkOutDate, checkInDate)";

        } elseif ($sortOption === 'sortUsersA-totalCostA') {

            $query = "SELECT b.*, u.fullname, h.name, h.thumbnail, h.address
            FROM booking b
            INNER JOIN users u ON b.user_id = u.user_id
            INNER JOIN hotels h ON b.hotel_id = h.hotel_id
            ORDER BY totalCost";

        } elseif ($sortOption === 'sortUsersA-totalCostD') {

            $query = "SELECT b.*, u.fullname, h.name, h.thumbnail, h.address
            FROM booking b
            INNER JOIN users u ON b.user_id = u.user_id
            INNER JOIN hotels h ON b.hotel_id = h.hotel_id
            ORDER BY totalCost DESC";

        } elseif ($sortOption === 'sortUsersA-bookingsD') {

            $query = "SELECT b.*, u.fullname, h.name, h.thumbnail, h.address
            FROM booking b
            INNER JOIN users u ON b.user_id = u.user_id
            INNER JOIN hotels h ON b.hotel_id = h.hotel_id
            ORDER BY bookingNo DESC";

        } elseif ($sortOption === 'sortUsersA-bookings') {

            $query = "SELECT b.*, u.fullname, h.name, h.thumbnail, h.address
            FROM booking b
            INNER JOIN users u ON b.user_id = u.user_id
            INNER JOIN hotels h ON b.hotel_id = h.hotel_id
            ORDER BY bookingNo";

        } else {

            $query = "SELECT b.*, u.fullname, h.name, h.thumbnail, h.address
            FROM booking b
            INNER JOIN users u ON b.user_id = u.user_id
            INNER JOIN hotels h ON b.hotel_id = h.hotel_id 
            WHERE h.name LIKE '%$searching%' 
            OR u.fullname LIKE '%$searching%' 
            OR b.checkInDate LIKE '%$searching%'
            OR b.checkOutDate LIKE '%$searching%'
            OR b.totalCost LIKE '%$searching%'
            OR b.bookingNo LIKE '%$searching%'";
        }
    } elseif (isset($_POST['clearFilterButton'])) {
        $query = "SELECT * FROM hotels";
    } else {

        $query = "SELECT b.*, u.fullname, h.name, h.thumbnail, h.address
        FROM booking b
        INNER JOIN users u ON b.user_id = u.user_id
        INNER JOIN hotels h ON b.hotel_id = h.hotel_id";
    }

    // Execute the query and display the results
    $result = mysqli_query($mysqli, $query);

    if (mysqli_num_rows($result) > 0) {
        $heading = <<<DELIMITER
                            <table>
                            <h2 class="mb-5"> Booking Information </h2>
                            <tr>
                            <th> </th>
                            <th> Hotel Name </th>
                            <th> User </th>
                            <th> Check In Date </th>
                            <th> Check Out Date </th>
                            <th> Total Cost</th>
                            </tr>
                        DELIMITER;
        $rows = '';

        while ($row = mysqli_fetch_assoc($result)) {

            $rowHTML = <<<DELIMITER
                            <tr>
                                <td class="p-3"><img src="../../static/img/{$row['thumbnail']}" alt="Hotel Image" class="bookCover"></td>
                                <td class="p-3"> <p> {$row['name']} </p> </td>
                                <td class="p-3"> <p> {$row['fullname']} </p> </td> 
                                <td class="p-3"> <p> {$row['checkInDate']} </p> </td>
                                <td class="p-3"> <p> {$row['checkOutDate']} </p> </td>
                                <td class="p-3"> <p> R {$row['totalCost']} </p> </td>
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
        echo 'No users found.';
    }

    mysqli_free_result($result);
    mysqli_close($mysqli);
}

function registerNewUser()
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

// Admin to view users
function adminViewUsers()
{
    if ($_SESSION['role'] == 'Admin') {

        // Connect to the database
        $mysqli = db_connect();
        if (!$mysqli) {
            return;
        }

        // Admin can add new user
        if (isset($_POST['adminNewUser'])) {
            header("Location: ../admin/registerNewUser.php");
        }

        // When the user clicks on the sort button or the search button
        if (isset($_POST['sortUserButton']) || isset($_POST['search'])) {
            // Store the input value or choice
            $sortOption = $_POST['sortUsers'];
            $searching = $_POST['search'];

            // If statements where the sorting and searching takes place
            if ($sortOption === 'sortUsersA-Username') {
                $query = "SELECT * FROM users WHERE fullname LIKE '%$searching%' ORDER BY username";

            } elseif ($sortOption === 'sortUsersA-Number') {
                $query = "SELECT * FROM users WHERE fullname LIKE '%$searching%' ORDER BY user_id";

            } elseif ($sortOption === 'sortUsersA-NumberD') {
                $query = "SELECT * FROM users WHERE fullname LIKE '%$searching%' ORDER BY user_id DESC";

            } else {
                $query = "SELECT * FROM users WHERE fullname LIKE '%$searching%' 
            OR email LIKE '%$searching%' 
            OR username LIKE '%$searching%'
            OR address LIKE '%$searching%'
            OR password LIKE '%$searching%'
            OR phoneNumber LIKE '%$searching%'";

            }
        } elseif (isset($_POST['clearFilterButton'])) {
            $query = "SELECT * FROM users";
        } else {
            $query = "SELECT * FROM users";
        }

        $result = mysqli_query($mysqli, $query);

        if (mysqli_num_rows($result) > 0) {

            $heading = <<<DELIMITER
            <table>
            <h2 class="mb-5"> User Information </h2>
            <tr>
                <th> Username </th>
                <th> Full Name </th>
                <th> Address </th>
                <th> Password </th>
                <th> Email </th>
                <th> Phone Number </th>
            </tr>
        DELIMITER;
            $rows = '';

            while ($row = mysqli_fetch_assoc($result)) {


                $rowHTML = <<<DELIMITER
                <tr>
                    <td class="name p-4"> <p> {$row['username']} </p> </td>
                    <td class="name p-4"> <p> {$row['fullname']} </p> </td> 
                    <td class="name p-4"> <p> {$row['address']} </p> </td>
                    <td class="name p-4"> <p> {$row['password']} </p> </td>
                    <td class="name p-4"> <p> {$row['email']} </p> </td>
                    <td class="name p-4"> <p> {$row['phoneNumber']} </p> </td>
                    <td class="p-4"><a href="../admin/editUser.php?user_id={$row['user_id']}"><img class="homeButtonAdmin"
                                    src="../../static/img/edit.gif" alt="Edit" title="Edit"></a></td>    
                    <td class="p-4"><a href="../staff/viewUser.php?user_id={$row['user_id']}"><img class="homeButtonAdmin"
                                    src="../../static/img/bin.gif" alt="Delete Booking" title="Delete Booking"
                                    attribution="https://www.flaticon.com/free-animated-icons/document"></a</td>       
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
            echo 'No users found.';
        }

        mysqli_free_result($result);
        mysqli_close($mysqli);
    }
}

// This is where the admin can edit the user information
function adminEditUser()
{

    if (isset($_POST['adminEditFinalButton'])) {

        if (isset($_GET['user_id'])) {

            $userId = $_GET['user_id'];

            $username = $_POST['editUsername'];
            $fullname = $_POST['editFullName'];
            $address = $_POST['editAddress'];
            $password = $_POST['editPassword'];
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
            if (empty($password)) {
                $password = $existingUserData['password'];
            }
            if (empty($email)) {
                $email = $existingUserData['email'];
            }
            if (empty($phoneNumber)) {
                $phoneNumber = $existingUserData['phoneNumber'];
            }

            // Pass user_id along with other fields to the editUser method
            $userUpdated = $user->adminUserEdit($userId, $username, $fullname, $address, $password, $email, $phoneNumber);

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
}

// This is where the admin can delete a user
function adminDeleteUser()
{

    if (isset($_GET['user_id'])) {

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
            header("Location: ../admin/deleteUser.php");
        } else {
            echo '<h3 class="p-3">You cannot delete this account since they have an active booking </h3>';
        }
    }
}

// Admin side of the Hotels
function adminViewHotels()
{

    // Connect to the database
    $mysqli = db_connect();
    if (!$mysqli) {
        return;
    }

    // When the user clicks on the sort button or the search button
    if (isset($_POST['sortUserButton']) || isset($_POST['search'])) {
        // Store the input value or choice
        $sortOption = $_POST['sortUsers'];
        $searching = $_POST['search'];


        // If statements where the sorting and searching takes place
        if ($sortOption === 'sortUsersA-name') {

            $query = "SELECT * FROM hotels WHERE name LIKE '%$searching%' ORDER BY name";

        } elseif ($sortOption === 'sortUsersA-priceA') {

            $query = "SELECT * FROM hotels WHERE pricePerNight LIKE '%$searching%' ORDER BY pricePerNight";

        } elseif ($sortOption === 'sortUsersA-priceD') {

            $query = "SELECT * FROM hotels WHERE pricePerNight LIKE '%$searching%' ORDER BY pricePerNight DESC";

        } elseif ($sortOption === 'sortUsersA-rating') {

            $query = "SELECT * FROM hotels WHERE rating LIKE '%$searching%' ORDER BY rating DESC";

        } elseif ($sortOption === 'sortUsersA-ratingPoor') {

            $query = "SELECT * FROM hotels WHERE rating LIKE '%$searching%' ORDER BY rating";

        } else {

            $query = "SELECT * FROM hotels WHERE name LIKE '%$searching%' 
            OR pricePerNight LIKE '%$searching%' 
            OR features LIKE '%$searching%'
            OR type LIKE '%$searching%'
            OR beds LIKE '%$searching%'
            OR rating LIKE '%$searching%'
            OR address LIKE '%$searching%'";

        }
    } elseif (isset($_POST['clearFilterButton'])) {
        $query = "SELECT * FROM hotels";
    } else {
        $query = "SELECT * FROM hotels";
    }

    $result = mysqli_query($mysqli, $query);

    if (mysqli_num_rows($result) > 0) {
        $heading = <<<DELIMITER
                            <table>
                            <h2 class="my-5"> Hotel Information </h2>
                            <tr>
                            <th> </th>
                            <th class="heading"> Hotel Name </th>
                            <th class="heading"> Price Per Night </th>
                            <th class="heading"> Features </th>
                            <th class="heading"> Type </th>
                            <th class="heading"> Beds </th>
                            <th class="heading"> Rating </th>
                            <th class="heading"> Address </th>
                            </tr>
                        DELIMITER;
        $rows = '';

        while ($row = mysqli_fetch_assoc($result)) {

            $rowHTML = <<<DELIMITER
                            <tr>
                                <td class="p-3"><img src="../../static/img/{$row['thumbnail']}" alt="Hotel Thumbnail" class="bookCoverHotel"></td>
                                <td class="p-2"> <h5> {$row['name']} </h5> </td>
                                <td class="p-2"> <h5> R {$row['pricePerNight']} </h5> </td> 
                                <td class="feature p-2"> <h6> {$row['features']} </h6> </td>
                                <td class="p-2"> <h5> {$row['type']} </h5> </td>
                                <td class="p-2"> <h5> {$row['beds']} </h5> </td>
                                <td class="p-2"> <h5> {$row['rating']} </h5> </td>
                                <td class="address p-2"> <h5> {$row['address']} </h5> </td>
                                <td class="p-2"><a href="../admin/editHotel.php?hotel_id={$row['hotel_id']}"><img class="homeButtonHotel"
                                    src="../../static/img/edit.gif" alt="Edit" title="Edit"></a></td>    
                                <td class="p-2"><a href="../staff/viewHotel.php?hotel_id={$row['hotel_id']}"><img class="homeButtonHotel"
                                    src="../../static/img/bin.gif" alt="Delete" title="Delete"
                                    attribution="https://www.flaticon.com/free-animated-icons/document"></a</td>  
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
        echo 'No users found.';
    }

    mysqli_free_result($result);
    mysqli_close($mysqli);
}



function adminDeleteHotel()
{

    if (isset($_GET['hotel_id'])) {

        $hotelId = $_GET['hotel_id'];

        // Connect to the database
        $mysqli = db_connect();
        if (!$mysqli) {
            return;
        }

        // Create a new instance of the User class
        $hotel = new Hotel($mysqli, $hotelId);

        // Call the method from the User class
        $result = $hotel->deleteHotel($hotelId);

        if ($result) {
            header("Location: ../admin/deleteHotel.php");
        } else {
            echo '<h3 class="p-3">You cannot delete this hotel since it has an active booking </h3>';
        }
    }
}

function adminAddHotel()
{

    if (isset($_POST['addAdminHotel'])) {

        if (isset($_POST['hotel_id'])) {

            $hotelId = $_POST['hotel_id'];
        }

        $name = $_POST['hotelName'];
        $pricePerNight = $_POST['hotelPricePerNight'];
        $thumbnail = "star.png";
        $features = $_POST['hotelFeatures'];
        $type = $_POST['hotelType'];
        $beds = $_POST['hotelBeds'];
        $rating = $_POST['hotelRating'];
        $address = $_POST['hotelAddress'];

        // Connect to the database
        $mysqli = db_connect();
        if (!$mysqli) {
            echo 'Database connection error.';
            exit;
        }

        // Create an instance of the User class
        $hotel = new Hotel($mysqli, $hotelId);

        // Pass user_id along with other fields to the editUser method
        $hotelAdd = $hotel->addHotel($name, $pricePerNight, $thumbnail, $features, $type, $beds, $rating, $address);

        if ($hotelAdd) {
            echo '<h2 class="p-3">Success: Hotel added successfully! <br> Head back to the Information Page</h2>';
            mysqli_close($mysqli);
            exit();
        } else {
            echo 'Hotel not added.';

        }
    }
}

// Admin can edit a specific hotel
function adminEditHotel()
{

    if (isset($_POST['adminEditHotelFinal'])) {

        if (isset($_GET['hotel_id'])) {

            $hotelId = $_GET['hotel_id'];

            $name = $_POST['editHotelName'];
            $pricePerNight = $_POST['editHotelPrice'];
            $features = $_POST['editHotelFeatures'];
            $type = $_POST['editHotelType'];
            $beds = $_POST['editHotelBeds'];
            $rating = $_POST['editHotelRating'];
            $address = $_POST['editHotelAddress'];

            // Connect to the database
            $mysqli = db_connect();
            if (!$mysqli) {
                echo 'Database connection error.';
                exit;
            }

            // Create an instance of the User class
            $hotel = new Hotel($mysqli, $hotelId);

            // Retrieve existing user data from the database
            $existingHotelData = $hotel->viewHotelsById();

            // Update only the fields that the user has interacted with
            if (empty($name)) {
                $name = $existingHotelData['name'];
            }
            if (empty($pricePerNight)) {
                $pricePerNight = $existingHotelData['pricePerNight'];
            }
            if (empty($features)) {
                $features = $existingHotelData['features'];
            }
            if (empty($type)) {
                $type = $existingHotelData['type'];
            }
            if (empty($beds)) {
                $beds = $existingHotelData['beds'];
            }
            if (empty($rating)) {
                $rating = $existingHotelData['rating'];
            }
            if (empty($address)) {
                $address = $existingHotelData['address'];
            }

            // Pass user_id along with other fields to the editUser method
            $hotelUpdated = $hotel->adminHotelEdit($hotelId, $name, $pricePerNight, $features, $type, $beds, $rating, $address);

            if ($hotelUpdated) {
                echo '<div class="adminView p-3">';
                echo '<h3 class="p-3">Success: Hotel information updated successfully! <br> Head back to the Information Page</h3>';
                echo '</div>';
                mysqli_close($mysqli);
                exit();
            } else {
                echo 'Hotel not updated.';

            }
        }
    }
}


function adminViewBookings()
{
    // Connect to the database
    $mysqli = db_connect();
    if (!$mysqli) {
        return;
    }

    // When the user clicks on the sort button or the search button
    if (isset($_POST['sortUserButton']) || isset($_POST['search'])) {
        // Store the input value or choice
        $sortOption = $_POST['sortUsers'];
        $searching = $_POST['search'];

        // If statements where the sorting and searching takes place
        if ($sortOption === 'sortUsersA-daysA') {

            $query = "SELECT b.*, u.fullname, h.name, h.thumbnail, h.address
            FROM booking b
            INNER JOIN users u ON b.user_id = u.user_id
            INNER JOIN hotels h ON b.hotel_id = h.hotel_id
            ORDER BY DATEDIFF(checkOutDate, checkInDate) DESC";

        } elseif ($sortOption === 'sortUsersA-daysD') {

            $query = "SELECT b.*, u.fullname, h.name, h.thumbnail, h.address
            FROM booking b
            INNER JOIN users u ON b.user_id = u.user_id
            INNER JOIN hotels h ON b.hotel_id = h.hotel_id
            ORDER BY DATEDIFF(checkOutDate, checkInDate)";

        } elseif ($sortOption === 'sortUsersA-totalCostA') {

            $query = "SELECT b.*, u.fullname, h.name, h.thumbnail, h.address
            FROM booking b
            INNER JOIN users u ON b.user_id = u.user_id
            INNER JOIN hotels h ON b.hotel_id = h.hotel_id
            ORDER BY totalCost";

        } elseif ($sortOption === 'sortUsersA-totalCostD') {

            $query = "SELECT b.*, u.fullname, h.name, h.thumbnail, h.address
            FROM booking b
            INNER JOIN users u ON b.user_id = u.user_id
            INNER JOIN hotels h ON b.hotel_id = h.hotel_id
            ORDER BY totalCost DESC";

        } elseif ($sortOption === 'sortUsersA-bookingsD') {

            $query = "SELECT b.*, u.fullname, h.name, h.thumbnail, h.address
            FROM booking b
            INNER JOIN users u ON b.user_id = u.user_id
            INNER JOIN hotels h ON b.hotel_id = h.hotel_id
            ORDER BY bookingNo DESC";

        } elseif ($sortOption === 'sortUsersA-bookings') {

            $query = "SELECT b.*, u.fullname, h.name, h.thumbnail, h.address
            FROM booking b
            INNER JOIN users u ON b.user_id = u.user_id
            INNER JOIN hotels h ON b.hotel_id = h.hotel_id
            ORDER BY bookingNo";

        } else {

            $query = "SELECT b.*, u.fullname, h.name, h.thumbnail, h.address
            FROM booking b
            INNER JOIN users u ON b.user_id = u.user_id
            INNER JOIN hotels h ON b.hotel_id = h.hotel_id 
            WHERE h.name LIKE '%$searching%' 
            OR u.fullname LIKE '%$searching%' 
            OR b.checkInDate LIKE '%$searching%'
            OR b.checkOutDate LIKE '%$searching%'
            OR b.totalCost LIKE '%$searching%'
            OR b.bookingNo LIKE '%$searching%'";
        }
    } elseif (isset($_POST['clearFilterButton'])) {
        $query = "SELECT * FROM hotels";
    } else {

        $query = "SELECT b.*, u.fullname, h.name, h.thumbnail, h.address
        FROM booking b
        INNER JOIN users u ON b.user_id = u.user_id
        INNER JOIN hotels h ON b.hotel_id = h.hotel_id";
    }

    // Execute the query and display the results
    $result = mysqli_query($mysqli, $query);

    if (mysqli_num_rows($result) > 0) {
        $heading = <<<DELIMITER
                            <table>
                            <h2 class="mb-5"> Booking Information </h2>
                            <tr>
                            <th> </th>
                            <th> Hotel Name </th>
                            <th> User </th>
                            <th> Check In Date </th>
                            <th> Check Out Date </th>
                            <th> Total Cost</th>
                            </tr>
                        DELIMITER;
        $rows = '';

        while ($row = mysqli_fetch_assoc($result)) {

            $rowHTML = <<<DELIMITER
                            <tr>
                                <td class="p-3"><img src="../../static/img/{$row['thumbnail']}" alt="Hotel Image" class="bookCover"></td>
                                <td class="p-3"> <p> {$row['name']} </p> </td>
                                <td class="p-3"> <p> {$row['fullname']} </p> </td> 
                                <td class="p-3"> <p> {$row['checkInDate']} </p> </td>
                                <td class="p-3"> <p> {$row['checkOutDate']} </p> </td>
                                <td class="p-3"> <p> R {$row['totalCost']} </p> </td>
                                <td class="p-2"><a href="../admin/editBooking.php?bookingNo={$row['bookingNo']}"><img class="homeButtonAdmin"
                                    src="../../static/img/edit.gif" alt="Edit" title="Edit"></a></td>    
                                <td class="p-2"><a href="../staff/viewBooking.php?bookingNo={$row['bookingNo']}"><img class="homeButtonAdmin"
                                    src="../../static/img/bin.gif" alt="Delete" title="Delete"
                                    attribution="https://www.flaticon.com/free-animated-icons/document"></a</td> 
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
        echo 'No booking found.';
    }

    mysqli_free_result($result);
    mysqli_close($mysqli);
}

function adminDeleteBooking()
{

    if (isset($_GET['bookingNo'])) {

        $bookingNo = $_GET['bookingNo'];

        // Connect to the database
        $mysqli = db_connect();
        if (!$mysqli) {
            return;
        }

        // Create a new instance of the User class
        $booking = new Booking($mysqli);

        // Call the method from the User class
        $result = $booking->deleteBooking($bookingNo);

        if ($result) {
            header("Location: ../admin/deleteBooking.php");
        } else {
            echo '<h3 class="p-3">You cannot delete this booking since it has an active booking </h3>';
        }
    }
}


function adminEditBooking()
{

    if (isset($_POST['adminEditBookingFinal'])) {

        if (isset($_GET['bookingNo'])) {

            $bookingNo = $_GET['bookingNo'];

            $checkInDate = $_POST['editCheckInDate'];
            $checkOutDate = $_POST['editCheckOutDate'];


            // Connect to the database
            $mysqli = db_connect();
            if (!$mysqli) {
                echo 'Database connection error.';
                exit;
            }

            // Create an instance of the User class
            $booking = new Booking($mysqli);

            // Retrieve existing user data from the database
            $existingBookingData = $booking->getBookingData($bookingNo);

            // Update only the fields that the user has interacted with
            if (empty($checkInDate)) {
                $checkInDate = $existingBookingData['checkInDate'];
            }
            if (empty($checkOutDate)) {
                $checkOutDate = $existingBookingData['checkOutDate'];
            }

            // Pass user_id along with other fields to the editUser method
            $BookingUpdated = $booking->adminBookingEdit($bookingNo, $checkInDate, $checkOutDate);

            if ($BookingUpdated) {
                echo '<div class="adminView p-3">';
                echo '<h3 class="p-3">Success: Booking information updated successfully! <br> Head back to the Information Page</h3>';
                echo '</div>';
                mysqli_close($mysqli);
                exit();
            } else {
                echo 'Booking not updated.';

            }
        }
    }
}

// Admin can view staff members
function adminViewStaff()
{
    if ($_SESSION['role'] == 'Admin') {

        // Connect to the database
        $mysqli = db_connect();
        if (!$mysqli) {
            return;
        }

        // When the user clicks on the sort button or the search button
        if (isset($_POST['sortUserButton']) || isset($_POST['search'])) {
            // Store the input value or choice
            $sortOption = $_POST['sortUsers'];
            $searching = $_POST['search'];

            // If statements where the sorting and searching takes place
            if ($sortOption === 'sortUsersA-Username') {
                $query = "SELECT * FROM staff WHERE fullname LIKE '%$searching%' ORDER BY fullname";

            } elseif ($sortOption === 'sortUsersA-Number') {
                $query = "SELECT * FROM staff WHERE fullname LIKE '%$searching%' ORDER BY staff_id";

            } elseif ($sortOption === 'sortUsersA-NumberD') {
                $query = "SELECT * FROM staff WHERE fullname LIKE '%$searching%' ORDER BY staff_id DESC";

            } else {
                $query = "SELECT * FROM staff WHERE fullname LIKE '%$searching%' 
            OR employee_number LIKE '%$searching%' 
            OR role LIKE '%$searching%'";

            }
        } elseif (isset($_POST['clearFilterButton'])) {
            $query = "SELECT * FROM staff";
        } else {
            $query = "SELECT * FROM staff";
        }

        $result = mysqli_query($mysqli, $query);

        if (mysqli_num_rows($result) > 0) {

            $heading = <<<DELIMITER
            <table>
            <h2 class="mb-5"> Staff Information </h2>
            <tr>
                <th> Employee Number </th>
                <th> Full Name </th>
                <th> Role </th>
                
            </tr>
        DELIMITER;
            $rows = '';

            while ($row = mysqli_fetch_assoc($result)) {


                $rowHTML = <<<DELIMITER
                <tr>
                    <td class="name p-4"> <p> {$row['employee_number']} </p> </td>
                    <td class="name p-4"> <p> {$row['fullname']} </p> </td> 
                    <td class="name p-4"> <p> {$row['role']} </p> </td>
                    <td class="p-4"><a href="../admin/editStaff.php?staff_id={$row['staff_id']}"><img class="homeButtonAdmin"
                                    src="../../static/img/edit.gif" alt="Edit" title="Edit"></a></td>    
                    <td class="p-4"><a href="../staff/viewStaff.php?staff_id={$row['staff_id']}"><img class="homeButtonAdmin"
                                    src="../../static/img/bin.gif" alt="Delete Booking" title="Delete Booking"
                                    attribution="https://www.flaticon.com/free-animated-icons/document"></a</td>       
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
            echo 'No staff found.';
        }

        mysqli_free_result($result);
        mysqli_close($mysqli);
    }
}

// Admin is able to delete staff members
function adminDeleteStaff()
{

    if (isset($_GET['staff_id'])) {

        $staffId = $_GET['staff_id'];

        // Connect to the database
        $mysqli = db_connect();
        if (!$mysqli) {
            return;
        }

        // Create a new instance of the User class
        $staff = new Staff($mysqli);

        // Call the method from the User class
        $result = $staff->deleteStaff($staffId);

        if ($result) {
            header("Location: ../admin/deleteStaff.php");
        } else {
            echo '<h3 class="p-3">You cannot delete this employee </h3>';
        }
    }
}

// Admin is able to edit staff profiles
function adminEditStaff()
{

    if (isset($_POST['adminEditStaffFinal'])) {

        if (isset($_GET['staff_id'])) {

            $staffId = $_GET['staff_id'];

            $fullname = $_POST['editEmployeeFullname'];
            $employee_number = $_POST['editEmployee_number'];
            $role = $_POST['editEmployee-role'];


            // Connect to the database
            $mysqli = db_connect();
            if (!$mysqli) {
                echo 'Database connection error.';
                exit;
            }

            // Create an instance of the User class
            $staff = new Staff($mysqli);

            // Retrieve existing user data from the database
            $existingStaffData = $staff->getUserStaff($staffId);

            // Update only the fields that the user has interacted with
            if (empty($fullname)) {
                $fullname = $existingStaffData['fullname'];
            }
            if (empty($employee_number)) {
                $employee_number = $existingStaffData['employee_number'];
            }
            if (empty($role)) {
                $role = $existingStaffData['role'];
            }

            // Pass user_id along with other fields to the editUser method
            $StaffUpdated = $staff->adminEditStaffmember($staffId, $employee_number, $fullname, $role);

            if ($StaffUpdated) {
                echo '<div class="adminView p-3">';
                echo '<h3 class="p-3">Success: Booking information updated successfully! <br> Head back to the Information Page</h3>';
                echo '</div>';
                mysqli_close($mysqli);
                exit();
            } else {
                echo 'Booking not updated.';

            }
        }
    }
}
?>