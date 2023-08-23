<?php
session_start();

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

    public function getRelatedHotels($priceDifferenceThreshold)
{
    // Fetch the current hotel's information
    $currentHotel = $this->viewHotelsById();

    // Calculate the price range within which related hotels should fall
    $minPrice = $currentHotel['pricePerNight'] - $priceDifferenceThreshold;
    $maxPrice = $currentHotel['pricePerNight'] + $priceDifferenceThreshold;

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

    public function addBooking($userId, $hotelId, $checkInDate, $checkOutDate, $totalCost, $cancelled, $completed)
    {
        $query = "INSERT INTO booking (user_id, hotel_id, checkInDate, checkOutDate, totalCost, cancelled, completed) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($this->mysqli, $query);
        mysqli_stmt_bind_param($stmt, "iiddiii", $userId, $hotelId, $checkInDate, $checkOutDate, $totalCost, $cancelled, $completed);
        $result = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        return $result;
    }


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
            // The booking is not yet completed
            return false;
        }
    }
}



?>