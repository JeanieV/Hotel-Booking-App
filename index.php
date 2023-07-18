<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Page Title</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous"></script>
    <link rel='stylesheet' type='text/css' media='screen' href='./css/home.css'>
</head>

<body>

    <!-- Carousel -->
    <div id="carousel" class="carousel slide mb-5" data-bs-ride="carousel">

        <!-- Indicators on carousel -->
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carousel" data-bs-slide-to="0" class="active"></button>
            <button type="button" data-bs-target="#carousel" data-bs-slide-to="1"></button>
            <button type="button" data-bs-target="#carousel" data-bs-slide-to="2"></button>
        </div>

        <!-- Slideshow -->
        <div class="carousel-inner">
            <div class="carousel-item active">

                <video id="oceanView" autoplay muted loop>
                    <source src="./video/background-ocean.mp4" type="video/mp4"
                        attribution="Video by Dimitris Mourousiadis: https://www.pexels.com/video/aerial-view-of-beautiful-greek-beach-6460125/">
                </video>

                <div class="carousel-caption">
                    <h1>Welcome to Hotel Booking App! </h1>
                    <h4> Book your Hotel now and enjoy the gorgeous Greece! </h4>
                </div>
            </div>

            <div class="carousel-item">

                <video id="oceanView" autoplay muted loop>
                    <source src="./video/background-greece.mp4" type="video/mp4"
                        attribution="Video by Pat Whelen: https://www.pexels.com/video/acropolis-of-athens-5737310/">
                </video>

                <div class="carousel-caption">
                    <h1>Welcome to Hotel Booking App! </h1>
                    <h4> Book your Hotel now and enjoy the gorgeous Greece! </h4>
                </div>
            </div>

            <div class="carousel-item">

                <video id="oceanView" autoplay muted loop>
                    <source src="./video/background-houses.mp4" type="video/mp4"
                        attribution="Video by Dimitris Mourousiadis: https://www.pexels.com/video/aerial-shot-of-santorini-6192496/">
                </video>

                <div class="carousel-caption">
                    <h1>Welcome to Hotel Booking App! </h1>
                    <h4> Book your Hotel now and enjoy the gorgeous Greece! </h4>
                </div>
            </div>
        </div>

        <!-- Left and right controls -->
        <button class="carousel-control-prev" type="button" data-bs-target="#carousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carousel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>

    <div class="container d-flex justify-content-center align-items-center mt-5 mb-5 mx-5">
        <form method="GET" name="loginForm" class="loginForm ">
            <h2> Kindly log in to your profile: </h2>
            <input type="text" name="myEmail" required>
            <button name="myButton" type="submit" class="myButton">Log In</button>
        </form>
    </div>


    <form method="GET" name="myForm" class="form">
        <button name="existButton" type="submit" class="existButton">New User?</button>
    </form>




</body>

</html>