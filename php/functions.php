<?php
session_start();
require './classes.php';


// Sign Up a new user
if (isset($_POST['existButton'])) {
    header("Location: ./signUp.php");
}

// Redirect to landing page after sign up
if (isset($_POST['signUpButton'])) {
    header("Location: ./index.php");
}

// Return to Home Page
if(isset($_POST['returnHome'])){
    header("Location: ./index.php");
}

if(isset($_POST['logInButton'])){
    header("Location: ./hotel.php");
}

// Return to Hotel Page after clicking on viewing a Hotel
if(isset($_POST['returntoHotelPage'])){
    header("Location: ./hotel.php");
}

// View Marbella Elix
if(isset($_POST['marbellaElixButton'])){
    header("Location: ./marbellaElix.php");
}

// View Royal Senses
if(isset($_POST['royalSensesButton'])){
    header("Location: ./royalSenses.php");
}

// View The View
if(isset($_POST['theViewButton'])){
    header("Location: ./theView.php");
}

// View Angsana Corfu
if(isset($_POST['angsanaButton'])){
    header("Location: ./angsanaCorfu.php");
}

// View The Rooster
if(isset($_POST['theRoosterButton'])){
    header("Location: ./theRooster.php");
}

// View The Rooster
if(isset($_POST['destinoButton'])){
    header("Location: ./destinoPacha.php");
}

// Using JSON while figuring out SQL

function createUser()
{
    if (isset($_POST['signUpButton']) && isset($_POST['newUsername']) && isset($_POST['newFullName']) && isset($_POST['newAddress']) && isset($_POST['newPassword']) && isset($_POST['newEmail'])) {
        $newUser = new stdClass();
        $newUser->id = generateID();
        $newUser->username = $_POST['newUsername'];
        $newUser->fullname = $_POST['newFullName'];
        $newUser->address = $_POST['newAddress'];
        $newUser->password = $_POST['newPassword'];
        $newUser->email = $_POST['newEmail'];

        // Read the existing users from the file
        $file = '../json/users.json';
        $json = file_get_contents($file);
        $users = json_decode($json)->users;

        // Add the new User to the array
        $users[] = $newUser;

        // Convert the array back to JSON
        $updatedData = json_encode(['users' => $users]);

        // Write the updated JSON data to the file
        if (file_put_contents($file, $updatedData)) {
            echo "User added successfully to JSON file";
        } else {
            echo "Oops! Error adding user to JSON file";
        }
        header("Location: ./index.php");
    }
}

// This is where the users gets pushed into the UsersArray

$_SESSION['jsonFileUsers'] = '../json/users.json';

function populateUsersArray($jsonFileUsers)
{
    $jsonU = file_get_contents($jsonFileUsers);
    $users = json_decode($jsonU)->users;
    $usersArray = array();
    foreach ($users as $user) {
        array_push($usersArray, new User($user->id, $user->username, $user->fullname, $user->address, $user->password, $user->email));
    }
    return $usersArray;
}

$_SESSION['usersArray'] = populateUsersArray($_SESSION['jsonFileUsers']);

// Generate unique ID
function generateID()
{
    $unId = uniqid();

    return $unId;
}


?>