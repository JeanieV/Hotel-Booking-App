<?php
session_start();
require __DIR__ . '/functions.php';



?>

<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Admin Edit Profile</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel='stylesheet' type='text/css' media='screen' href='../../static/css/editProfile.css'>
</head>

<body>

    <form method="POST">
        <!-- Return Home Button -->
        <button type="submit" name="returnAdminUser" class="tranBack"><img class="homeButton mx-3 mt-3"
                src="../../static/img/home.png" alt="Back to Home Page" title="Back to Home Page"
                attribution="https://www.flaticon.com/free-icons/home"></button>
    </form>

    <div class="container d-flex justify-content-center align-items-center">
        <div class="mt-5 mb-5 mx-5">

            <!-- If the button is clicked, the information will be updated and the message will show -->
            <?php if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                adminEditUser();
            }
            ?>

            <form method="POST" class="editForm">
                <h1 class="py-5"> Edit user profile: </h1>
        
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
                            <td class="p-4"><label for="editPassword" class="labelStyle"> Edit Password: </label></td>
                            <td class="p-4"><input type="text" name="editPassword" class="inputStyle"></td>
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
                        <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id'] ?>">
                        <button name="adminEditFinalButton" type="submit" class="editButton p-2">Edit</button>
                    </div>
                </div>
            </form>

        </div>
    </div>

</body>

</html>