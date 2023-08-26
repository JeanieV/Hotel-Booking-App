<?php
session_start();
require '../functions.php';


?>

<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Edit Staff</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous"></script>
    <link rel='stylesheet' type='text/css' media='screen' href='../../static/css/staff.css'>
</head>

<body>

    <!-- Return Home Button -->
    <form method="POST">
        <button type="submit" name="returnStaffView" class="tranBack"><img class="homeButtonAdmin mx-3 mt-3"
                src="../../static/img/home1.gif" alt="Back to Home Page" title="Back to Home Page"
                attribution="https://www.flaticon.com/free-animated-icons/home"></button>
    </form>

    <!-- New User -->
    <div class="container d-flex justify-content-center align-items-center">
        <div class="mt-5 mb-5 mx-5">


            <!-- If the button is clicked, the information will be updated and the message will show -->
            <?php if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                adminEditStaff();
            }
            ?>

            <!-- Register New User -->
            <div class="container d-flex justify-content-center align-items-center">
                <div class="mt-5 mb-5 mx-5">

                    <form method="POST" name="signUpForm" class="adminView p-5">
                        <h2> Edit the Staff Profile: </h2>

                        <div class="d-flex justify-content-center align-items-center my-4">
                            <table>
                                <!-- Fullname -->
                                <tr>
                                    <td class="p-4"><label for="editEmployeeFullname" class="labelStyle"> Full Name:
                                        </label></td>
                                    <td class="p-4"><input type="text" name="editEmployeeFullname"
                                            class="inputAdminStyle"></td>
                                </tr>

                                <!-- Employee Number -->
                                <tr>
                                    <td class="p-4"><label for="editEmployee_number" class="labelStyle"> Employee
                                            Number:
                                        </label>
                                    </td>
                                    <td class="p-4"><input type="text" name="editEmployee_number"
                                            class="inputAdminStyle"></td>
                                </tr>

                                <!-- Role -->
                                <tr>
                                    <td class="p-4"><label for="editEmployee-role" class="labelStyle">Role:</label></td>
                                    <td class="p-4">
                                        <select name="editEmployee-role" class="inputAdminStyle">
                                            <option selected></option>
                                            <option value="Employee">Employee</option>
                                            <option value="Admin">Admin</option>
                                            <option value="Manager">Manager</option>
                                            <option value="Supervisor">Supervisor</option>
                                        </select>
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <!-- Log In Button -->
                        <div class="container d-flex justify-content-center align-items-center">
                            <div class="mx-5 mt-3 mb-5">
                                <button name="adminEditStaffFinal" type="submit" class="infoButtons p-2">Edit</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
</body>

</html>