<?php
session_start();
require __DIR__ . '/functions.php';

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Register New User</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous"></script>
    <link rel='stylesheet' type='text/css' media='screen' href='../../static/css/signUp.css'>
</head>

<body>

    <!-- Return Home Button -->
    <form method="POST">
        <button type="submit" name="returnAdminUser" class="tranBack"><img class="homeButton mx-3 mt-3" src="../../static/img/home1.gif"
                alt="Back to Home Page" title="Back to Home Page"
                attribution="https://www.flaticon.com/free-animated-icons/home"></button>
    </form>

    <!-- New User -->
    <div class="container d-flex justify-content-center align-items-center">
        <div class="mt-5 mb-5 mx-5">

        <div class="container d-flex justify-content-center align-items-center">
        <!-- Create a user and add it to the database -->
        <?php registerNewUser(); ?>
    </div>

    <!-- Register New User -->
    <div class="container d-flex justify-content-center align-items-center">
        <div class="mt-5 mb-5 mx-5">

            <form method="POST" name="signUpForm" class="signUpForm p-5">
                <h1> Register new user: </h1>

                <div class="d-flex justify-content-center align-items-center my-4">
                    <table>
                        <!-- Username -->
                        <tr>
                            <td class="p-4"><label for="username" class="labelStyle"> Username: </label></td>
                            <td class="p-4"><input type="text" name="newUsername" class="inputStyle" required></td>
                        </tr>

                        <!-- Full Name -->
                        <tr>
                            <td class="p-4"><label for="fullname" class="labelStyle"> Full Name: </label></td>
                            <td class="p-4"><input type="text" name="newFullName" class="inputStyle" required></td>
                        </tr>

                        <!-- Address -->
                        <tr>
                            <td class="p-4"><label for="address" class="labelStyle"> Address: </label></td>
                            <td class="p-4"><input type="text" name="newAddress" class="inputStyle" required></td>
                        </tr>

                        <!-- Password -->
                        <tr>
                            <td class="p-4"><label for="password" class="labelStyle"> Password: </label></td>
                            <td class="p-4"><input type="password" name="newPassword" class="inputStyle" required></td>
                        </tr>

                        <!-- Email -->
                        <tr>
                            <td class="p-4"><label for="email" class="labelStyle"> Email: </label></td>
                            <td class="p-4"><input type="email" name="newEmail" class="inputStyle" required></td>
                        </tr>

                        <!-- Phone Number -->
                        <tr>
                            <td class="p-4"><label for="newPhoneNumber" class="labelStyle"> Phone Number: <br> (xxx-xxx-xxxx) </label></td>
                            <td class="p-4"><input type="tel" name="newPhoneNumber" class="inputStyle" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" required></td>
                        </tr>

                    </table>
                </div>

                <!-- Log In Button -->
                <div class="container d-flex justify-content-center align-items-center">
                    <div class="mx-5 mt-3 mb-5">
                        <button name="signUpButton" type="submit" class="logInButton p-2">Register</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</body>

</html>