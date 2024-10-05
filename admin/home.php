<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Airline Reservation System</title>
    <link rel="stylesheet" href="path/to/bootstrap.css">
    <style>
        /* Add your custom styles here */
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <!-- Header or additional content can go here -->
        </div>
    </div>

    <div class="row mt-3 ml-3 mr-3">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <?php
                 // Ensure the session is started

                    // Safely access session variables
                    $loginType = isset($_SESSION['login_type']) ? $_SESSION['login_type'] : null;
                    $loginName = isset($_SESSION['login_name']) ? $_SESSION['login_name'] : 'Guest';
                    $loginNamePref = isset($_SESSION['login_name_pref']) ? $_SESSION['login_name_pref'] : '';

                    echo "Welcome back " . ($loginType == 3 
                        ? "Dr. " . $loginName . ($loginNamePref ? ',' . $loginNamePref : '') 
                        : $loginName) . "!";
                    ?>
                </div>
                <hr>
                <div class="row">
                    <!-- Additional content can go here -->
                </div>
            </div>
        </div>
    </div>
</div>

<script src="path/to/jquery.js"></script>
<script src="path/to/bootstrap.js"></script>
<script>
    // Add your custom scripts here
</script>
</body>
</html>


<!-- <style>
   
</style>

<div class="containe-fluid">

	<div class="row">
		<div class="col-lg-12">
			
		</div>
	</div>

	<div class="row mt-3 ml-3 mr-3">
			<div class="col-lg-12">
			<div class="card">
				<div class="card-body">
				<?php echo "Welcome back ".($_SESSION['login_type'] == 3 ? "Dr. ".$_SESSION['login_name'].','.$_SESSION['login_name_pref'] : $_SESSION['login_name'])."!"  ?>
									
				</div>
				<hr>
				<div class="row">
				
				</div>
			</div>
			
		</div>
		</div>
	</div>

</div>
<script>
	
</script> -->