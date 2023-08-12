<?php
session_start();

// Hotel class
class Hotel
{
    private $mysqli;

    public function __construct($mysqli)
    {
        $this->mysqli = $mysqli;
    }

    // Method to select everything from the hotels table
    public function viewHotelsById($hotelId) {

        $query = "SELECT * FROM hotels WHERE hotel_id=?";
        $stmt = mysqli_prepare($this->mysqli, $query);
        mysqli_stmt_bind_param($stmt, "i", $hotelId); 
        mysqli_stmt_execute($stmt);
        
        $result = mysqli_stmt_get_result($stmt);
        $hotelData = mysqli_fetch_assoc($result);

        mysqli_stmt_close($stmt);

        return $hotelData;
    }
}

class User
{
    private $mysqli;

    public function __construct($mysqli)
    {
        $this->mysqli = $mysqli;
    }

    // Method to update the user information
    public function editUser($userId, $username, $fullname, $address, $email, $phoneNumber) {
        $query = "UPDATE users SET username = ?, fullname = ?, address = ?, email = ?, phoneNumber = ? WHERE user_id = ?";
        
        $stmt = mysqli_prepare($this->mysqli, $query);
        mysqli_stmt_bind_param($stmt, "sssssi", $username, $fullname, $address, $email, $phoneNumber, $userId);
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

    // function viewUsers($userId){
    //     $query = "SELECT * FROM users WHERE user_id = ?";
        
    //     $stmt = mysqli_prepare($this->mysqli, $query);
    //     mysqli_stmt_bind_param($stmt, "i", $userId);
    //     mysqli_stmt_execute($stmt);

    //     $result = mysqli_stmt_get_result($stmt);
    //     $userData = mysqli_fetch_assoc($result);

    //     mysqli_stmt_close($stmt);

    //     return $userData;
    // }
}



?>