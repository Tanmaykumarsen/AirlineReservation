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
    <title><?php echo isset($_SESSION['setting_name']) ? $_SESSION['setting_name'] : 'Website Title'; ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f0f0f0;
            color: #333;
            margin: 0;
            padding: 0;
        }

        header.masthead {
            background: url(assets/img/<?php echo isset($_SESSION['setting_cover_img']) ? $_SESSION['setting_cover_img'] : 'default.jpg'; ?>) no-repeat center center;
            background-size: cover;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            text-align: center;
            position: relative;
        }

        header.masthead::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
        }

        header.masthead .container {
            position: relative;
            z-index: 2;
        }

        header.masthead h1 {
            font-size: 3rem;
            margin-bottom: 1rem;
        }

        header.masthead p {
            font-size: 1.5rem;
            margin-bottom: 2rem;
        }

        .btn-primary {
            background-color: #ff5f57;
            border: none;
            padding: 10px 20px;
            color: #fff;
            font-size: 1rem;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #ff2e1f;
        }

        nav.navbar {
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        nav.navbar .navbar-brand {
            font-size: 1.5rem;
            font-weight: 600;
            color: #333;
        }

        nav.navbar .nav-link {
            color: #333;
            font-weight: 500;
            margin-right: 1rem;
        }

        .footer {
            background-color: #333;
            color: #fff;
            padding: 2rem 0;
            text-align: center;
        }

        .footer .container a {
            color: #ff5f57;
            text-decoration: none;
        }

        .footer .container a:hover {
            text-decoration: underline;
        }

        .section {
            padding: 4rem 0;
        }

        .section h2 {
            font-size: 2rem;
            margin-bottom: 1rem;
            text-align: center;
        }

        .section p {
            font-size: 1.2rem;
            text-align: center;
            max-width: 600px;
            margin: 0 auto;
            color: #666;
        }

        .modal-content {
            border-radius: 10px;
        }

        .modal-header, .modal-footer {
            border: none;
        }

        .toast {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
        }
        html{
            scroll-behavior: smooth;
        }
    </style>
</head>

<body id="page-top">


    
    <div class="toast" id="alert_toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-body text-white"></div>
    </div>

    <nav class="navbar navbar-expand-lg navbar-light fixed-top py-3" id="mainNav">
        <div class="container">
            <a class="navbar-brand js-scroll-trigger" href="./"><?php echo isset($_SESSION['setting_name']) ? $_SESSION['setting_name'] : 'Website Name'; ?></a>
            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto my-2 my-lg-0">
                    <li class="nav-item"><a class="nav-link js-scroll-trigger" href="book_flight.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link js-scroll-trigger" href="flights.php">Flight List</a></li>
                    <li class="nav-item"><a class="nav-link js-scroll-trigger" href="about.php">About</a></li>
                    <li class="nav-item"><a class="nav-link js-scroll-trigger" href="index.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <header class="masthead">
        <div class="container">
            <h1>Book Your Next Adventure</h1>
            <p>Find the best flights at the best prices</p>
            <a href="#bookNow" class="btn btn-primary">Book Now</a>
        </div>
    </header>

    <section class="section" id="services">
        <div class="container">
            <h2>Our Services</h2>
            <p>We provide the best flight booking services to make your journey comfortable and affordable.</p>
        </div>
    </section>

    <div id="bookNow">

        <?php
        $page = isset($_GET['page']) ? $_GET['page'] : "home";
        include $page . '.php';
        ?>
    </div>

    <div class="modal fade" id="confirm_modal" role="dialog">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirmation</h5>
                </div>
                <div class="modal-body">
                    <div id="delete_content"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id='confirm'>Continue</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="uni_modal" role="dialog">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                </div>
                <div class="modal-body"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id='submit' onclick="$('#uni_modal form').submit()">Save</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="uni_modal_right" role="dialog">
        <div class="modal-dialog modal-full-height modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span class="fa fa-arrow-right"></span>
                    </button>
                </div>
                <div class="modal-body"></div>
            </div>
        </div>
    </div>

    <div id="preloader"></div>

    <footer class="footer">
        <div class="container">
            <h2>Contact us</h2>
            <div class="row">
                <div class="col-lg-4 ml-auto text-center mb-5 mb-lg-0">
                    <i class="fas fa-phone fa-3x mb-3 text-muted"></i>
                    <div><?php echo isset($_SESSION['setting_contact']) ? $_SESSION['setting_contact'] : 'Contact Number'; ?></div>
                   
                </div>
                <div class="col-lg-4 mr-auto text-center">
                    <i class="fas fa-envelope fa-3x mb-3 text-muted"></i>
                    <a class="d-block" href="mailto:<?php echo isset($_SESSION['setting_email']) ? $_SESSION['setting_email'] : 'email@example.com'; ?>"><?php echo isset($_SESSION['setting_email']) ? $_SESSION['setting_email'] : 'email@example.com'; ?></a>
                </div>
            </div>
            <br>
        </div>
    </footer>

    <?php include('footer.php'); ?>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
</body>

</html>
<!-- 
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($_SESSION['setting_name']) ? $_SESSION['setting_name'] : 'Website Title'; ?></title>
    <style>
        header.masthead {
            background: url(assets/img/<?php echo isset($_SESSION['setting_cover_img']) ? $_SESSION['setting_cover_img'] : 'default.jpg'; ?>);
            background-repeat: no-repeat;
            background-size: cover;
        }
    </style>
</head>

<body id="page-top">

    <div class="toast" id="alert_toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-body text-white">
        </div>
    </div>

    <nav class="navbar navbar-expand-lg navbar-light fixed-top py-3" id="mainNav">
        <div class="container">
            <a class="navbar-brand js-scroll-trigger" href="./"><?php echo isset($_SESSION['setting_name']) ? $_SESSION['setting_name'] : 'Website Name'; ?></a>
            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto my-2 my-lg-0">
                    <li class="nav-item"><a class="nav-link js-scroll-trigger" href="book_flight.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link js-scroll-trigger" href="flights.php">Flight List</a></li>
                    <li class="nav-item"><a class="nav-link js-scroll-trigger" href="about.php">About</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <?php
    $page = isset($_GET['page']) ? $_GET['page'] : "home";
    include $page . '.php';
    ?>

    <div class="modal fade" id="confirm_modal" role='dialog'>
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirmation</h5>
                </div>
                <div class="modal-body">
                    <div id="delete_content"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id='confirm'>Continue</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="uni_modal" role='dialog'>
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                </div>
                <div class="modal-body">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id='submit' onclick="$('#uni_modal form').submit()">Save</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="uni_modal_right" role='dialog'>
        <div class="modal-dialog modal-full-height  modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span class="fa fa-arrow-right"></span>
                    </button>
                </div>
                <div class="modal-body">
                </div>
            </div>
        </div>
    </div>

    <div id="preloader"></div>

    <footer class="bg-light py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <h2 class="mt-0">Contact us</h2>
                    <hr class="divider my-4" />
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 ml-auto text-center mb-5 mb-lg-0">
                    <i class="fas fa-phone fa-3x mb-3 text-muted"></i>
                    <div><?php echo isset($_SESSION['setting_contact']) ? $_SESSION['setting_contact'] : 'Contact Number'; ?></div>
                </div>
                <div class="col-lg-4 mr-auto text-center">
                    <i class="fas fa-envelope fa-3x mb-3 text-muted"></i>
                    <a class="d-block" href="mailto:<?php echo isset($_SESSION['setting_email']) ? $_SESSION['setting_email'] : 'email@example.com'; ?>"><?php echo isset($_SESSION['setting_email']) ? $_SESSION['setting_email'] : 'email@example.com'; ?></a>
                </div>
            </div>
        </div>
        <br>
        <div class="container">
            <div class="small text-center text-muted"><?php echo isset($_SESSION['setting_name']) ? $_SESSION['setting_name'] : 'Website Name'; ?> | <a href="https://www.campcodes.com" target="_blank">CampCodes</a></div>
        </div>
    </footer>

    <?php include('footer.php'); ?>

</body>

</html> -->

<?php $conn->close(); ?>
