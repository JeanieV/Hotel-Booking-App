<?php
require_once 'connection.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!mysqli_query($_SESSION['mysqli'], $query)) {
    echo 'Error: ' . mysqli_error($_SESSION['mysqli']);
}



function getUsers()
{
    $query = mysqli_query($_SESSION['mysqli'], 'SELECT * FROM users');

    if (!$query) {
        echo 'Error executing query: ' . mysqli_error($_SESSION['mysqli']);
    }

    if (mysqli_num_rows($query) === 0) {
        echo 'No records found for users.';
    }

    while ($row = mysqli_fetch_array($query)) {
        $report = <<<DELIMETER
            <h4>{$row['id']}</h4>
            <p>{$row['username']}</p>
            <p>{$row['fullname']}</p>
            <p>{$row['address']}</p>
            <p>{$row['password']}</p>
            <p>{$row['email']}</p>
            DELIMETER;
        echo $report;
    }
}