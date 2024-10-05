<?php
session_start();
ob_start();
include('header.php');
include('admin/db_connect.php');

$query = $conn->query("SELECT * FROM system_settings limit 1")->fetch_assoc();
if ($query) {
    foreach ($query as $key => $value) {
        if (!is_numeric($key)) {
            $_SESSION['setting_'.$key] = $value;
        }
    }
}

ob_end_flush();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Flight Booking</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
            color: #333;
        }

        .masthead {
            background: url('assets/img/<?php echo isset($_SESSION['setting_cover_img']) ? $_SESSION['setting_cover_img'] : 'default.jpg'; ?>') no-repeat center center;
            background-size: cover;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            text-align: center;
            position: relative;
        }

        .masthead::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
        }

        .masthead .container {
            position: relative;
            z-index: 2;
        }

        .masthead h1 {
            font-size: 3rem;
            margin-bottom: 1rem;
        }

        .masthead .divider {
            width: 60px;
            height: 4px;
            background-color: #ff5f57;
            margin: 1.5rem auto;
        }

        .page-section {
            padding: 4rem 0;
        }

        .page-section .container {
            background: #fff;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .page-section h2 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            text-align: center;
            color: #333;
        }

        .page-section p {
            font-size: 1.1rem;
            line-height: 1.8;
            color: #555;
            text-align: justify;
        }

        .highlight {
            color: #ff5f57;
            font-weight: 600;
        }

        @media (max-width: 768px) {
            .masthead h1 {
                font-size: 2rem;
            }

            .page-section h2 {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>

    <!-- Masthead-->
    <header class="masthead">
        <div class="container h-100">
            <div class="row h-100 align-items-center justify-content-center text-center">
                <div class="col-lg-10 align-self-end mb-4" style="background: #0000002e; padding: 20px; border-radius: 10px;">
                    <h1 class="text-uppercase font-weight-bold">About Us</h1>
                    <div class="divider my-4"></div>
                </div>
            </div>
        </div>
    </header>

    <section class="page-section">
        <div class="container">
            <h2>Welcome to FlightBooker</h2>
            <p>At <span class="highlight">FlightBooker</span>, we are dedicated to providing you with the best flight booking experience. Whether you\'re traveling for business or leisure, we have a wide range of options to suit your needs.</p>
            <p>Our mission is to make flight booking easy, convenient, and affordable. With our user-friendly platform, you can search, compare, and book flights from various airlines in just a few clicks.</p>
            <p>We believe in transparency, so you can always count on us to provide clear and accurate information about flight prices, schedules, and more.</p>
            <h3>Our Values</h3>
            <ul>
                <li><span class="highlight">Customer Satisfaction:</span> We prioritize your needs and strive to exceed your expectations.</li>
                <li><span class="highlight">Integrity:</span> We operate with honesty and transparency in all our dealings.</li>
                <li><span class="highlight">Innovation:</span> We continuously improve our services to provide you with the best experience.</li>
            </ul>
            <p>Thank you for choosing <span class="highlight">FlightBooker</span>. We look forward to serving you!</p>
        </div>
    </section>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php $conn->close(); ?>



<!-- Masthead
        <header class="masthead">
            <div class="container h-100">
                <div class="row h-100 align-items-center justify-content-center text-center">
                    <div class="col-lg-10 align-self-end mb-4" style="background: #0000002e;">
                    	 <h1 class="text-uppercase text-white font-weight-bold">About Us</h1>
                        <hr class="divider my-4" />
                    </div>
                    
                </div>
            </div>
        </header>

    <section class="page-section">
        <div class="container">
    <?php echo html_entity_decode($_SESSION['setting_about_content']) ?>        
            
        </div>
        </section> -->