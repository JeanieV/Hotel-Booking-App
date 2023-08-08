<?php
session_start();
require './classes.php';


// Sign Up a new user
if (isset($_POST['newUserButton'])) {
    header("Location: ./signUp.php");
}

if (isset($_POST['logOutButton'])) {
    session_unset();
    session_destroy();

    header("Location: ./index.php");
    exit();
}



// Return to Hotel Page after clicking on viewing a Hotel
if (isset($_POST['returntoHotelPage'])) {
    header("Location: ./hotel.php");
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



?>

