<?php

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Start a session here if needed
    session_start();

    // Include the functions file
    require __DIR__ . '/php/index.php';

    $response = array(
        'message' => 'Hello, World'
    );

    echo json_encode($response);
} else {
    http_response_code(405);
    echo json_encode(array('error' => 'Method Not Allowed'));
}

?>
