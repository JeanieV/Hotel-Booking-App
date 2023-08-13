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

        // Check if the email already exists in the database 
        $query = "SELECT * FROM users WHERE email = ?";
        $stmt = mysqli_prepare($mysqli, $query);

        // Prepare the statement to bind the parameters (email)
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        // If there is information in the table that matches the input value
        if (mysqli_stmt_num_rows($stmt) > 0) {
            echo '<h2 class="p-3">Email already exists. Please use a different email address.</h2>';
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
            // Make sure that the username and fullname is known
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
    if (isset($_GET['hotel_id'])) {
        $hotelId = $_GET['hotel_id'];

        // Connect to the database
        $mysqli = db_connect();
        if (!$mysqli) {
            echo 'Database connection error.';
            exit;
        }

        // Create an instance of the Hotel class
        $hotel = new Hotel($mysqli);

        // Fetch hotel information using the provided hotel ID
        $hotelData = $hotel->viewHotelsById($hotelId);

        if ($hotelData) {

            $information = <<<DELIMETER
            <div class="container d-flex justify-content-center align-items-center">
            <table class="informationTable">
                <tr>
                    <td class="p-4"> <h3> Price per night: </h3> </td>
                </tr>
                <tr>
                    <td class="p-3"> <p> R {$hotelData['pricePerNight']} </p> </td>
                </tr>
                <tr>
                    <td class="p-4"> <h3> Features: </h3> </td>
                </tr>
                <tr>
                    <td class="features p-3"> <p> {$hotelData['features']} </p> </td>
                </tr>
                <tr>
                    <td class="p-4"> <h3> Sleeps: </h3> </td>
                </tr>
                <tr>
                    <td class="features p-3"> <p> {$hotelData['beds']} people </p> </td>
                </tr>
                <tr>
                    <td class="p-4"> <h3> Type: </h3> </td>
                </tr>
                <tr>
                    <td class="features p-3"> <p> {$hotelData['type']} </p> </td>
                </tr>
                <tr>
                    <td class="p-4"> <h3> Rating: </h3> </td>
                </tr>
                <tr>
                    <td class="features p-3"> <p> {$hotelData['rating']} star</p> </td>
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


// ---------------------------------------------------------
// Date Selectors
// ---------------------------------------------------------

// The date selectors on the Hotel Page
$formSubmitted = false;

function confirmDateHotelPage()
{
    global $formSubmitted;

    if (isset($_POST['dateConfirmHotelPage'])) {

        // Getting the answer from the user
        $startDate = $_POST['checkIn'];
        $endDate = $_POST['checkOut'];

        // Setting it to a DateTime 
        $startDateTime = new DateTime($startDate);
        $endDateTime = new DateTime($endDate);

        // Doing the calculation for difference in time
        $interval = $startDateTime->diff($endDateTime);

        // Making a table for the output if the startDate > endDate
        $output1 = <<<DELIMETER
        <div class="container d-flex justify-content-center align-items-center">
            <div class="output p-4">
                <h2>You cannot Check-Out before you Check-In </h2>
                <br> 
                <h2>Kindly choose again</h2>
                <br>
            </div>
        </div>
        DELIMETER;

        // Making a table for the output if the startDate < endDate
        $output2 = <<<DELIMETER
        <div class="container d-flex justify-content-center align-items-center">
            <div class="output p-4">
                <h2>You chose to stay for {$interval->days} days. </h2>
                <br>
        
            <table>
                <tr>
                    <td class="p-4"><h2><label for="checkIn"> Check-In Date: </label></h2></td>
                    <td class="p-4"><h2>$startDate</h2></td>
                </tr>
                <tr>
                    <td class="p-4"><h2><label for="checkOut"> Check-Out Date:</label></h2></td>
                    <td class="p-4"><h2>$endDate</h2></td>
                </tr>
            </table>
            </div>
        </div>
        DELIMETER;

        // Making a table for the output if the startDate = endDate
        $output3 = <<<DELIMETER
        <div class="container d-flex justify-content-center align-items-center">
            <div class="output p-4">
                <h2>You cannot stay for less than one day </h2>
                <br> 
                <h2>Kindly choose again</h2>
                <br>
            </div>
        </div>
        DELIMETER;


        $_SESSION['days'] = $interval->days;

        if ($startDate > $endDate) {
            $_SESSION['daysOutput'] = $output1;

        } elseif ($startDate < $endDate) {
            $_SESSION['daysOutput'] = $output2;

        } elseif ($startDate == $endDate) {
            $_SESSION['daysOutput'] = $output3;
        }

        $formSubmitted = true;
    }
}

// Display the Check-in and Check-out dates
function displayDate()
{
    global $formSubmitted;

    // Check In & Out
    $checkDates = <<<DELIMETER
     <div class="container d-flex justify-content-center align-items-center">
         <table>
             <tr>
                 <td class="p-4"><label for="checkIn" class="labelStyle"> Check-In Date: </label>
                 </td>
                 <td class="p-4"><input type="date" name="checkIn" class="inputStyle"></td>
             </tr>
             <tr>
                 <td class="p-4"><label for="checkOut" class="labelStyle"> Check-Out Date:
                     </label>
                 </td>
                 <td class="p-4"><input type="date" name="checkOut" class="inputStyle"></td>
             </tr>
         </table>
     </div>
 
     <div class="container d-flex justify-content-center align-items-center">
         <button type="submit" name="dateConfirmHotelPage" class="dateConfirmHotelPage p-2 mt-3 mb-5">
             Confirm Date </button>
     </div>
    DELIMETER;
    echo $checkDates;

    if ($formSubmitted && isset($_SESSION['daysOutput']) && !empty($_SESSION['daysOutput'])) {
        echo "{$_SESSION['daysOutput']}";

        $clearButton = <<<DELIMETER
        <div class="container d-flex justify-content-center align-items-center">
            <form method="POST">
                <button type="submit" name="clearDateHotelPage" class="dateConfirmHotelPage p-2 my-3">Clear</button>
            </form>
        </div>
        DELIMETER;
        echo $clearButton;
    }

    if (isset($_POST['clearDateHotelPage'])) {
        unset($_SESSION['daysOutput']);
    }
}

// Calling the Calculation function to prevent the user from clicking clear button twice before it is cleared
confirmDateHotelPage();


// ---------------------------------------------------------
// CRUD Operations
// ---------------------------------------------------------

// Function to show the edit fields in a form format
function viewEditForm()
{

    // Connect to the database
    $mysqli = db_connect();
    if (!$mysqli) {
        return;
    }

    // If there is something in the users table
    $query = "SELECT * FROM users";
    $result = mysqli_query($mysqli, $query);

    if (mysqli_num_rows($result) > 0) {

        while ($row = mysqli_fetch_assoc($result)) {

            $userId = $row['user_id'];

            $rowHTML = <<<DELIMITER
            <form method="POST" class="editForm">
                <h1 class="py-5"> Edit your profile: </h1>
                <h4> Please note that Password can't be updated! </h4>
                <div class="d-flex justify-content-center align-items-center my-4">
                    <table>
                        <tr>
                            <td class="p-4"><label for="editUsername" class="labelStyle"> Edit Username: </label></td>
                            <td class="p-4"><input type="text" name="editUsername" class="inputStyle"></td>
                        </tr>

                        <tr>
                            <td class="p-4"><label for="editFullName" class="labelStyle"> Edit Full Name: </label></td>
                            <td class="p-4"><input type="text" name="editFullName" class="inputStyle"></td>
                        </tr>

                        <tr>
                            <td class="p-4"><label for="editAddress" class="labelStyle"> Edit Address: </label></td>
                            <td class="p-4"><input type="text" name="editAddress" class="inputStyle"></td>
                        </tr>

                        <tr>
                            <td class="p-4"><label for="editEmail" class="labelStyle"> Edit Email: </label></td>
                            <td class="p-4"><input type="email" name="editEmail" class="inputStyle"></td>
                        </tr>

                        <tr>
                            <td class="p-4"><label for="editPhoneNumber" class="labelStyle"> Edit Phone Number: <br>
                            (xxx-xxx-xxxx) </label></td>
                            <td class="p-4"><input type="tel" name="editPhoneNumber" class="inputStyle"
                            pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}"></td>
                        </tr>

                    </table>
                </div>

                <div class="container d-flex justify-content-center align-items-center">
                    <div class="mx-5 mt-3 mb-5">
                        <input type="hidden" name="user_id" value="$userId">
                        <button name="editButton" type="submit" class="editButton p-2">Edit</button>
                    </div>
                </div>
            </form>
            DELIMITER;
            echo $rowHTML;
        }

    } else {
        echo 'No users found.';
    }

    mysqli_free_result($result);
    mysqli_close($mysqli);
}

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

            echo '<h2 class="p-3">Success: User information updated successfully! <br> Head back to the Hotel Page</h2>';
            mysqli_close($mysqli);
            exit();
        } else {
            echo 'User not updated.';

        }
    }
}


function viewCurrentInformation()
{
    // Connect to the database
    $mysqli = db_connect();
    if (!$mysqli) {
        return;
    }

    // If there is something in the users table
    $query = "SELECT * FROM users";
    $result = mysqli_query($mysqli, $query);

    if (mysqli_num_rows($result) > 0) {

        while ($row = mysqli_fetch_assoc($result)) {

            $userId = $row['user_id'];

            $rowHTML = <<<DELIMITER
            <form method="GET" action="viewUserInfo.php">
                    <input type="hidden" name="user_id" value="$userId">
                    <button name="viewInfo" type="submit" class="viewAllInfoButtons p-3">View Your Information </button>
            </form>
            DELIMITER;
            echo $rowHTML;
        }

    } else {
        echo 'No users found.';
    }
    mysqli_free_result($result);
    mysqli_close($mysqli);
}


function viewUserInformation()
{

    if (isset($_GET['viewInfo'])) {
        $userId = $_GET['user_id'];

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

// Delete User button inside the viewAllInfo.php
function deleteUser()
{
    // Connect to the database
    $mysqli = db_connect();
    if (!$mysqli) {
        return;
    }

    // If there is something in the users table
    $query = "SELECT * FROM users";
    $result = mysqli_query($mysqli, $query);

    if (mysqli_num_rows($result) > 0) {

        while ($row = mysqli_fetch_assoc($result)) {

            $userId = $row['user_id'];

            $rowHTML = <<<DELIMITER
        <form method="GET" action="index.php">
                <input type="hidden" name="user_id" value="$userId">
                <button type="submit" name="deleteUserButton" class="viewAllInfoButtons p-3"> Delete Your
                Account</button>
        </form>
        DELIMITER;
            echo $rowHTML;
        }

    }
    mysqli_free_result($result);
    mysqli_close($mysqli);

}

// Function using the delete method

function deleteUserFinal() {
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
            echo '<h2 class="p-3">Success: Book Deleted successfully! <br> Head back to Library Page </h2>';

            mysqli_close($mysqli);
            exit();
        } else {
            // Redirect back to the same page or display an error message
            header("Location: index.php");
            exit();
        }
    }
}

?>