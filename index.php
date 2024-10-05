<?php session_start(); ?>
<?php
include('header.php');
include('admin/db_connect.php');

$query = $conn->query("SELECT * FROM system_settings limit 1")->fetch_array();
foreach ($query as $key => $value) {
    if(!is_numeric($key)) {
        $_SESSION['setting_'.$key] = $value;
    }
}
ob_end_flush();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Airline Reservations</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <!-- Your custom styles -->
    <style>
        body {
            margin: 0;
            font-family: 'Arial', sans-serif;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: url('assets/img/hero-bg.jpg') no-repeat center center;
            background-size: cover;
        }

        .navbar {
            z-index: 1000; /* Ensure the navbar is on top */
        }

        .navbar-light {
            background-color: rgba(255, 255, 255, 0.5) !important; /* Transparent background */
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
        }

        .navbar-nav .nav-link {
            color: #fff !important; /* White text color */
        }

        .navbar-nav .nav-link:hover {
            color: #ddd !important; /* Light grey text color on hover */
        }

        .background {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle at 30% 107%, rgba(255, 255, 255, 0.15), rgba(255, 255, 255, 0.05));
            z-index: -1;
        }

        .background::before {
            content: '';
            position: absolute;
            width: 500px;
            height: 500px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            top: -150px;
            left: -200px;
            animation: move 20s infinite linear;
        }

        .background::after {
            content: '';
            position: absolute;
            width: 600px;
            height: 600px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            top: 100px;
            right: -250px;
            animation: move 25s infinite linear;
        }

        @keyframes move {
            0% { transform: translate(0, 0); }
            50% { transform: translate(50px, 50px); }
            100% { transform: translate(0, 0); }
        }

        .login-container {
            max-width: 400px;
            width: 100%;
            text-align: center;
            padding: 40px;
            border-radius: 30px;
            background: rgba(255, 255, 255, 0.95);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3);
        }

        .login-form h2 {
            margin-bottom: 15px;
            font-size: 28px;
            color: #333;
        }

        .login-form p {
            margin-bottom: 20px;
            color: #555;
            font-size: 16px;
        }

        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }

        .form-group label {
            font-weight: bold;
            color: #333;
        }

        .form-control {
            border: 2px solid #ccc;
            border-radius: 15px;
            padding: 12px;
            width: 100%;
            box-sizing: border-box;
            transition: border-color 0.3s;
        }

        .form-control:focus {
            border-color: #00c6ff;
            outline: none;
        }

        .form-group small a {
            color: #00c6ff;
            text-decoration: none;
            float: right;
        }

        .btn {
            background: #00c6ff;
            color: white;
            border: none;
            border-radius: 15px;
            padding: 15px;
            cursor: pointer;
            width: 100%;
            transition: background 0.3s, transform 0.3s;
            font-size: 16px;
        }

        .btn:hover {
            background: #0072ff;
            transform: scale(1.05);
        }

        .footer {
            margin-top: 15px;
            font-size: 14px;
        }

        .footer a {
            color: #00c6ff;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <!-- Transparent Navb -->
    <nav class="navbar navbar-expand-lg navbar-light bg-transparent fixed-top">
        <a class="navbar-brand" href="#">Airline Reservations</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
              
                <li class="nav-item">
                    <a class="nav-link" href="http://localhost/AP/admin/login.php
">Login</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="background"></div>
    <div class="login-container">
        <div class="login-form">
            <form action="" id="login-frm">
                <h2>Welcome Back to Airline Reservations!</h2>
                <p>Log in to manage your flights and bookings.</p>
                <div class="form-group">
                    <label for="email" class="control-label">Email Address</label>
                    <input type="email" name="email" id="email" required class="form-control">
                </div>
                <div class="form-group">
                    <label for="password" class="control-label">Password</label>
                    <input type="password" name="password" id="password" required class="form-control">
                    <small><a href="signup.php" id="new_account">Create New Account</a></small>
                </div>
                <button class="btn">Login</button>
            </form>
        </div>
        <div class="footer">
            <p>Forgot your password? <a href="reset_password.php">Reset it here</a>.</p>
        </div>
    </div>

    <!-- jQuery and Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
    <script>
        $('#new_account').click(function(){
            uni_modal("Create an Account", 'signup.php?redirect=index.php?page=checkout');
        });

        $('#login-frm').submit(function(e){
            e.preventDefault();
            $('#login-frm button[type="submit"]').attr('disabled', true).html('Logging in...');

            if ($(this).find('.alert-danger').length > 0) {
                $(this).find('.alert-danger').remove();
            }

            $.ajax({
                url: 'admin/ajax.php?action=login2',
                method: 'POST',
                data: $(this).serialize(),
                error: err => {
                    console.log(err);
                    $('#login-frm button[type="submit"]').removeAttr('disabled').html('Login');
                },
                success: function(resp) {
                    if (resp == 1) {
                        location.href = '<?php echo isset($_GET['redirect']) ? $_GET['redirect'] : 'book_flight.php' ?>';
                    } else {
                        $('#login-frm').prepend('<div class="alert alert-danger">Email or password is incorrect.</div>');
                        $('#login-frm button[type="submit"]').removeAttr('disabled').html('Login');
                    }
                }
            });
        });
    </script>
</body>
</html>
