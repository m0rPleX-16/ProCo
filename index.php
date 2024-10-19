<?php
session_start();
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="x-icon" href="images/pcLogo2.png">
    <title>Profile Connect</title>
    <!-- lineicons -->
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            /* Remove default margin */
            padding: 0;
            /* Remove default padding */
            background-color: #0C3B2E;
            /* Set body background color to transparent */
            overflow-x: hidden;
            /* Hide horizontal scrollbar */
            color: #0C3B2E;
            scroll-behavior: smooth;
        }

        
        .content {
            background-image: url("images/mainBackground-01.png");
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            padding-top: 60px;
            height: calc(100vh - 56px);
        }

        .navbar {
            z-index: 1;
            background-color: #FDF8F3;
        }

        #home {
            font-weight: 700;
        }

        .navbar-nav a {
            color: #66873C;
            text-decoration: none;
            transition: transform 0.2s;
        }

        .navbar-nav a:hover {
            color: #BB8A52;
            transform: scale(1.1);
        }

        .nav-item a:active {
            color: #6D9773;
        }


        #logoText {
            font-family: 'Poppins', sans-serif;
            color: #BB8A52;
            font-size: 1.4rem;
            font-weight: 700;
        }

        #getStartedButton {
            font-weight: 600;
            background-color: #FFBA00;
            color: #0C3B2E;
            font-size: 1rem;
            border-radius: 20px;
        }

        #getStartedButton:hover {
            background-color: #0C3B2E;
            color: #EFE9E1;
        }
        #startBtn {
            color: #0C3B2E;
            text-decoration: none;
        }
        #startBtn:hover {
            color: #EFE9E1;
        }

        #logInButton {
            font-weight: 600;
            background-color: transparent;
            color: #0C3B2E;
            font-size: 1rem;
            border-radius: 20px;
            text-decoration: none;
        }

        #logInButton:hover {
            color: #FFBA00;
        }

        .text {
            max-width: 800px;
            margin: auto;
            margin-top: 1rem;
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .text h3 {
            font-weight: 700;
            color: #BB8A52;
        }

        .text h1 {
            color: #0C3B2E;
            font-weight: 700;
            font-size: 3rem;
            margin-bottom: 1.4rem;
        }

        .text p {
            font-size: 0.8rem;
        }

        .text button.btn {
            font-weight: 600;
            background-color: #FFBA00;
            color: #0C3B2E;
            font-size: 1.4rem;
            border-radius: 20px;
            transition: transform 0.4s;
        }

        .text button.btn:hover {
            background-color: #0C3B2E;
            color: #EFE9E1;
            transform: scale(1.2);
        }

        .custom-container {
            width: 50%;
            /* Set the desired width */
            margin: 0 auto;
            /* Center the container horizontally */
        }

        .custom-container2 {
            background-color: #EFE9E1;
            
            /* Set the desired width */
            margin: 0 auto;
            /* Center the container horizontally */
            background-color: #EFE9E1;
        }

        

        .about-us h1 {
            color: #EFE9E1;
            font-weight: 700;
            font-size: 3rem;
        }

        #contact-us {
            height: 600px;
        }

        .contact-us h1 {
            color: #0C3B2E;
            font-weight: 700;
            font-size: 3rem;
        }

        .contact-us h5 {
            color: #BB8A52;
            font-size: 1.2rem;
        }

        .contact-us p {
            color: #BB8A52;
            margin-bottom: 1.4rem;
            font-size: 0.9rem;
        }

        .contact-us h6 {
            color: #0C3B2E;
            line-height: 40px;
            font-size: 1rem;
        }

        hr {
            color: #BB8A52;
            border-width: 3px;
        }

        .row h6 i {
            vertical-align: text-top;
            margin-right: 10px;
            /* Add some spacing between the icon and the text */
        }

        .slider-wrapper {
            position: relative;
            max-width: 48rem;
            margin: 0 auto;
        }

        .slider {
            display: flex;
            aspect-ratio: 16/9;
            overflow-x: auto;
            scroll-snap-type: x mandatory;
            /* snaps to x and mandatory will always snap */
            scroll-behavior: smooth;
            box-shadow: 0 1.5rem 3rem -0.75rem hsla(0, 0%, 0%, 0.25);
            border-radius: 0.5rem;
        }

        .slider img {
            flex: 1 0 100%;
            scroll-snap-align: start;
            object-fit: cover;
        }

        .slider-nav {
            display: flex;
            column-gap: 1rem;
            position: absolute;
            bottom: 1.25rem;
            left: 50%;
            transform: translateX(-50%);
            z-index: 1;
        }

        .about-us p {
            color: #EFE9E1;
            font-size: 1.3rem;
        }

        #logoTextFooter {
            font-family: 'Poppins', sans-serif;
            color: #EFE9E1;
            font-size: 1.4rem;
            font-weight: 700;
        }

        .footer {
            background-color: #152722;
        }

        #footerContent {
            font-size: 0.8rem;
            color: gray;
        }

        @media only screen and (max-width:576px){
            .text h1 {
                font-size: 2.4rem;
            }
        }
        
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light navbar-custom">
        <div class="container-fluid">
            <img src="images/pcLogo2.png" alt="Logo" height="50">
            <span id="logoText">Profile Connect</span>

            <div class="collapse navbar-collapse justify-content-center" id="home">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="#home">HOME</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about-us">ABOUT US</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact-us">CONTACT US</a>
                    </li>
                </ul>
            </div>
            <div class="d-flex align-items-center">
                <button class="btn me-2" type="button" id="logInButton">
                    <a href="login.php" id="logInButton">Log In</a></button>
                <button class="btn d-flex align-items-center" type="button" id="getStartedButton">
                    <a href="signin.php" id="startBtn" >Get Started</a>
                    <i class="lni lni-arrow-right-circle ms-2"></i>
                </button>

            </div>
        </div>
    </nav>

    <div class="content">
        <div class="text hero justify-content-center align-items-center">
            <h3> <i>We can help you</i></h3>
            <h1>Efficiently manage your <i>Barangay's</i> profiling data</h1>
            <p>
                <i>"Lorem ipsum lorem ipsun lorem ipsum lorem ipsum lorem ipsum"</i>
            </p>
            <div style="height:10px;"></div>
            <button class="btn d-flex align-items-center" type="button">
                <a href="signin.php" id="startBtn">Get Started</a>
                <i class="lni lni-arrow-right-circle ms-2"></i>
            </button>
        </div>
        <div style="height: 14rem;"></div>
        <div class="custom-container about-us" id="about-us">
            <div style="height: 5rem;"></div>
            <div class="row text-center">
                <h1>About Us</h1>
            </div>
            <div style="height: 10px;"></div>
            <section class="container">
                <div class="slider-wrapper">
                    <div class="slider">
                        <img id="slide-1" src="images/lpImage1.png" alt="System screenshots">
                        <img id="slide-2" src="images/lpImage2.png" alt="System screenshots">
                        <img id="slide-3" src="images/lpImage3.png" alt="System screenshots">
                    </div>
                    <div class="slider-nav">
                        <a href="#slide-1"></a>
                        <a href="#slide-2"></a>
                        <a href="#slide-3"></a>
                    </div>
                </div>
            </section>
            <div style="height: 2rem;"></div>
            <p>
                Perferendis voluptatum rerum eaque expedita deleniti et ea quas. Aut autem necessitatibus suscipit voluptatem pariatur quia. <br> <br>
                Sapiente eligendi tenetur quam ad rem rerum. Assumenda recusandae laboriosam dolor ad.
            </p>
        </div>

        <div style="height: 3rem;"></div>
        <div class="custom-container2 contact-us" id="contact-us">
            
                <div style="height: 4rem;"></div>
                <div class="row text-center">
                    <h1>Get in Touch</h1>
                </div>
                <div class="row text-center justify-content-center">
                    <div class="col-9">
                        <h5>Send us a message</h5>
                        <hr>
                    </div>
                </div>
                 
                <div style="height: 10px;"></div>
                <div class="row justify-content-center">
                    <div class="col-9">
                        <p>Please don't hesitate to contact us with any more questions or inquiries you may have. We look forward to hearing from you.</p>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-9">
                        <h6> <i class="lni lni-envelope mt-1"></i> profileconnect@gmail.com <br>
                            <i class="lni lni-phone-set mt-1"></i> +639 1234 1234 <br>
                            <i class="lni lni-map-marker mt-1"></i> Davao City 8000, Davao del Sur, Philippines <br>
                            <i class="lni lni-hourglass mt-1"></i> 9:00 AM - 5:00 PM <br>
                        </h6>
                        <hr>
                    </div>
                    

                </div>
           
        </div>
        <div style="height: 7rem;"></div>
        <div class="footer mt-5 p-4 text-center" id="footerContent">
            Copyright © 2024, All Rights Reserved. Profile Connect
        </div>
    </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-xBfIYhGz1PqMB3KirCk8p4ZcOTG9j0JJgbnZ7F1LIlvVp/d0RPeiJ5A+h+Ihlb0K" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            // Add smooth scrolling to all links
            $("a").on('click', function(event) {

                // Make sure this.hash has a value before overriding default behavior
                if (this.hash !== "") {
                    // Prevent default anchor click behavior
                    event.preventDefault();

                    // Store hash
                    var hash = this.hash;

                    // Using jQuery's animate() method to add smooth page scroll
                    // The optional number (800) specifies the number of milliseconds it takes to scroll to the specified area
                    $('html, body').animate({
                        scrollTop: $(hash).offset().top
                    }, 300, function() {

                        // Add hash (#) to URL when done scrolling (default click behavior)
                        window.location.hash = hash;
                    });
                } // End if
            });
        });
    </script>
</body>

</html>