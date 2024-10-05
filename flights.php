
<?php 
include 'admin/db_connect.php'; 
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    foreach ($_POST as $k => $v) {
        $$k = $v;
    }
}

$aname = [];

// Populate the aname array with airport names
$airport = $conn->query("SELECT * FROM airport_list ORDER BY airport ASC");
while ($row = $airport->fetch_assoc()) {
    $aname[$row['id']] = ucwords($row['airport'].', '.$row['location']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Your Flight</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f0f4f8;
            color: #333;
        }
        .masthead {
            background: url('assets/img/hero-bg.jpg') no-repeat center center;
            background-size: cover;
            height: 70vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: #fff;
            position: relative;
            border-bottom: 5px solid #ff6b81;
        }
        .masthead h1 {
            font-size: 3rem;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 6px rgba(0, 0, 0, 0.8);
        }
        .divider {
            width: 80px;
            height: 4px;
            background-color: #ff6b81;
            margin: 1rem auto;
        }
        .page-section {
            padding: 4rem 0;
        }
        .card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            padding: 2rem;
            margin-bottom: 2rem;
            transition: transform 0.3s;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .form-control {
            margin-bottom: 1rem;
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 10px;
            transition: border-color 0.3s;
        }
        .form-control:focus {
            border-color: #ff6b81;
            box-shadow: 0 0 5px rgba(255, 107, 129, 0.5);
        }
        #flight img {
            max-height: 250px;
            max-width: 200px;
            border-radius: 10px;
        }
        .book_flight {
            background-color: #ff6b81;
            border: none;
            color: #fff;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.3s;
        }
        .book_flight:hover {
            background-color: #e05566;
            transform: scale(1.05);
        }
        .result-title {
            text-align: center;
            font-size: 2rem;
            color: #333;
            margin-bottom: 1rem;
        }
        .no-result {
            text-align: center;
            font-size: 1.5rem;
            color: #888;
        }
    </style>
</head>
<body>

    <header class="masthead">
        <div class="container">
            <h1>Find Your Perfect Flight</h1>
            <div class="divider"></div>
            <p>Your adventure begins here! Search for flights and book your journey.</p>
        </div>
    </header>

    <section class="page-section" id="flight">
        <div class="container">
            <div class="card">
                <form id="manage-filter" action="index.php?page=flights" method="POST">
                    <div class="row form-group">
                        <div class="col-sm-3">
                            <label for="departure_location" class="control-label">From</label>
                            <select name="departure_airport_id" id="departure_location" class="form-control">
                                <option value=""></option>
                                <?php
                                $airport = $conn->query("SELECT * FROM airport_list ORDER BY airport ASC");
                                while ($row = $airport->fetch_assoc()):
                                ?>
                                    <option value="<?php echo $row['id']; ?>" <?php echo isset($departure_airport_id) && $departure_airport_id == $row['id'] ? "selected" : ''; ?>>
                                        <?php echo $row['location'].", ".$row['airport']; ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="col-sm-3">
                            <label for="arrival_airport_id" class="control-label">To</label>
                            <select name="arrival_airport_id" id="arrival_airport_id" class="form-control">
                                <option value=""></option>
                                <?php
                                $airport = $conn->query("SELECT * FROM airport_list ORDER BY airport ASC");
                                while ($row = $airport->fetch_assoc()):
                                ?>
                                    <option value="<?php echo $row['id']; ?>" <?php echo isset($arrival_airport_id) && $arrival_airport_id == $row['id'] ? "selected" : ''; ?>>
                                        <?php echo $row['location'].", ".$row['airport']; ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="col-sm-3">
                            <label for="date" class="control-label">Departure Date</label>
                            <input type="date" class="form-control" name="date" value="<?php echo isset($date) ? date("Y-m-d", strtotime($date)) : ''; ?>">
                        </div>
                        <div class="col-sm-3" id="rdate" <?php echo isset($trip) && $trip == 1 ? 'style="display: none;"' : ''; ?>>
                            <label for="date_return" class="control-label">Return Date</label>
                            <input type="date" class="form-control" name="date_return" value="<?php echo isset($date_return) ? date("Y-m-d", strtotime($date_return)) : ''; ?>">
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-sm-2 text-center">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="trip" id="oneway" value="1" <?php echo isset($trip) && $trip == 1 ? "checked" : ""; ?>>
                                <label class="form-check-label" for="oneway">One-way</label>
                            </div>
                        </div>
                        <div class="col-sm-2 text-center">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="trip" id="roundtrip" value="2" <?php echo isset($trip) && $trip == 2 ? "checked" : ""; ?>>
                                <label class="form-check-label" for="roundtrip">Round Trip</label>
                            </div>
                        </div>
                        <div class="col-sm-3 offset-sm-5">
                            <button type="submit" class="btn btn-block book_flight"><i class="fa fa-plane-departure"></i> Search Flights</button>
                        </div>
                    </div>
                </form>

                <div class="results">
					<h2 class="result-title"><?php echo isset($trip) && $trip == 2 ? "Departure Flight Results" : "Available Flights"; ?></h2>
					<hr class="divider">
					<?php 
					$where = "WHERE DATE(f.departure_datetime) > '".date("Y-m-d")."' ";
					if ($_SERVER['REQUEST_METHOD'] == "POST") {
						$where .= " AND f.departure_airport_id = '$departure_airport_id' AND f.arrival_airport_id = '$arrival_airport_id' AND DATE(f.departure_datetime) = '".date('Y-m-d', strtotime($date))."' ";
					}
					$flight = $conn->query("SELECT f.*, a.airlines, a.logo_path FROM flight_list f INNER JOIN airlines_list a ON f.airline_id = a.id $where ORDER BY RAND()");
					
					if ($flight->num_rows > 0) {
						while ($row = $flight->fetch_assoc()) {
							$booked = $conn->query("SELECT * FROM booked_flight WHERE flight_id = ".$row['id'])->num_rows;
							?>
							<div class="row align-items-center">
								<div class="col-md-3">
									<img src="assets/img/<?php echo $row['logo_path']; ?>" alt="">
								</div>
								<div class="col-md-6">
									<p><b><?php echo $aname[$row['departure_airport_id']].' - '.$aname[$row['arrival_airport_id']]; ?></b></p>
									<p><small>Airline: <b><?php echo $row['airlines']; ?></b></small></p>
									<p><small>Departure: <b><?php echo date('h:i A', strtotime($row['departure_datetime'])); ?></b></small></p>
									<p><small>Arrival: <b><?php echo (date('M d,Y', strtotime($row['departure_datetime'])) == date('M d,Y', strtotime($row['arrival_datetime']))) ? date('h:i A', strtotime($row['arrival_datetime'])) : date('M d,Y h:i A', strtotime($row['arrival_datetime'])); ?></b></small></p>
									<p>Available Seats: <b><?php echo $row['seats'] - $booked; ?></b></p>
								</div>
								<div class="col-md-3 text-center">
									<h4><b><?php echo number_format($row['price'], 2); ?></b></h4>
									<button class="book_flight" type="button" data-id="<?php echo $row['id']; ?>" data-name="<?php echo $aname[$row['departure_airport_id']].' - '.$aname[$row['arrival_airport_id']]; ?>" data-max="<?php echo $row['seats'] - $booked; ?>">Book Now</button>
								</div>
							</div>
							<hr class="divider">
							<?php
						}
					} else {
						echo '<h5 class="no-result"><b>No results found.</b></h5>';
					}
					?>
				</div>
            </div>
        </div>
    </section>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $('.book_flight').click(function() {
            if ($(this).data('max') <= 0) {
                alert("There are no available seats for the selected flight.");
                return false;
            }
            uni_modal($(this).data('name'), "book_flight.php?id=" + $(this).data('id') + "&max=" + $(this).data('max'), 'mid-large');
        });

        $('[name="trip"]').on("change", function() {
            if ($(this).val() == 1) {
                $('#rdate').hide();
            } else {
                $('#rdate').show();
            }
        });
    </script>
</body>
</html>




























<!-- 
        <header class="masthead">
            <div class="container h-100">
                <div class="row h-100 align-items-center justify-content-center text-center">
                    <div class="col-lg-10 align-self-end mb-4 page-title" >
                    	<h3 class="text-white">Flights</h3>
                        <hr class="divider my-4" />
                        <div class="col-md-12 mb-2 text-left">
                        <div class="card">
                            <div class="card-body">
                                <form id="manage-filter"  action="index.php?page=flights" method="POST">
                                    <div class="row form-group">
                                        <div class="col-sm-3">
                                            <label for="" class="control-label">From</label>
                                            <select name="departure_airport_id" id="departure_location" class="custom-select browser-default select2">
                                                <option value=""></option>
                                            <?php
                                                $airport = $conn->query("SELECT * FROM airport_list order by airport asc");
                                            while($row = $airport->fetch_assoc()):
                                            ?>
                                                <option value="<?php echo $row['id'] ?>" <?php echo isset($departure_airport_id) && $departure_airport_id == $row['id'] ? "selected" : '' ?>><?php echo $row['location'].", ".$row['airport'] ?></option>
                                            <?php endwhile; ?>
                                            </select>
                                        </div>
                                        <div class="col-sm-3">
                                            <label for="" class="control-label">To</label>
                                            <select name="arrival_airport_id" id="arrival_airport_id" class="custom-select browser-default select2">

                                                <option value=""></option>

                                            <?php
                                                $airport = $conn->query("SELECT * FROM airport_list order by airport asc");
                                            while($row = $airport->fetch_assoc()):
                                            ?>
                                                <option value="<?php echo $row['id'] ?>" <?php echo isset($arrival_airport_id) && $arrival_airport_id == $row['id'] ? "selected" : '' ?>><?php echo $row['location'].", ".$row['airport'] ?></option>
                                            <?php endwhile; ?>
                                            </select>
                                        </div>
                                        <div class="col-sm-3">
                                            <label for="" class="control-label">Departure Date</label>
                                            <input type="date" class="form-control input-sm datetimepicker2" name="date" autocomplete="off" value="<?php echo isset($date) && !empty($date) ? date("Y-m-d",strtotime($date)) : "" ?>">
                                        </div>
                                        <div class="col-sm-3" id="rdate" <?php if(isset($trip) && $trip == 1): ?> style="display: none" <?php endif; ?>>
                                            <label for="" class="control-label">Return Date</label>
                                            <input type="date" class="form-control input-sm datetimepicker2" name="date_return" autocomplete="off" value="<?php echo isset($date_return) && !empty($date_return) ? date("Y-m-d",strtotime($date_return)) : "" ?>">
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-sm-2 text-center">
                                            <div class="form-check">
                                              <input class="form-check-input" type="radio" name="trip" id="onewway" value="1" <?php echo isset($trip) && $trip == 1 ? "checked" : "" ?> >
                                              <label class="form-check-label" for="onewway">
                                                One-way
                                              </label>
                                            </div>
                                        </div>
                                        <div class="col-sm-2 text-center">
                                            <div class="form-check">
                                              <input class="form-check-input" type="radio" name="trip" id="rtrip" value="2" <?php echo isset($trip) && $trip == 2 ? "checked" : "" ?>>
                                              <label class="form-check-label" for="rtrip">
                                               Round Trip
                                              </label>
                                            </div>
                                        </div>
                                        <div class="col-sm-3 offset-sm-5">
                                            <button class="btn btn-block btn-sm btn-primary"><i class="fa fa-plane-departure"></i> Find Flights</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>                        
                    </div>
                    </div>
                    
                </div>
            </div>
        </header>
	<section class="page-section" id="flight" >
        <div class="container">
        	<div class="card">
        		<div class="card-body">
        			<div class="col-lg-12">
						<div class="row">
							<div class="col-md-12 text-center">
								<h2><b><?php echo isset($trip) && $trip == 2 ? "Departure Searched Flight results..." : ( !isset($trip)? " Flights Available " :"Searched Flight results...")  ?></b></h2>
							</div>
						</div>
						<hr class="divider">
				<?php 
				$airport = $conn->query("SELECT * FROM airport_list ");
				while($row = $airport->fetch_assoc()){
					$aname[$row['id']] = ucwords($row['airport'].', '.$row['location']);
				}
				$where = " where date(f.departure_datetime) > '".date("Y-m-d")."' ";
				if($_SERVER['REQUEST_METHOD'] == "POST" )
				$where .= " and f.departure_airport_id ='$departure_airport_id' and f.arrival_airport_id = '$arrival_airport_id' and date(f.departure_datetime) = '".date('Y-m-d',strtotime($date))."'  ";
				$flight = $conn->query("SELECT f.*,a.airlines,a.logo_path FROM flight_list f inner join airlines_list a on f.airline_id = a.id $where order by rand()");
				if($flight->num_rows > 0):
				while($row=$flight->fetch_assoc()):
					$booked = $conn->query("SELECT * FROM booked_flight where flight_id = ".$row['id'])->num_rows;
				?>
				<div class="row align-items-center">
					<div class="col-md-3">
						<img src="assets/img/<?php echo $row['logo_path'] ?>" alt="">
					</div>
					<div class="col-md-6">
						 <p><b><?php echo $aname[$row['departure_airport_id']].' - '.$aname[$row['arrival_airport_id']] ?></b></p>
						 <p><small>Airline: <b><?php echo $row['airlines'] ?></b></small></p>
						 <p><small>Departure: <b><?php echo date('h:i A',strtotime($row['departure_datetime'])) ?></b></small></p>
						 <p><small>Arrival: <b><?php echo (date('M d,Y',strtotime($row['departure_datetime'])) == date('M d,Y',strtotime($row['arrival_datetime']))) ? date('h:i A',strtotime($row['arrival_datetime'])) : date('M d,Y h:i A',strtotime($row['arrival_datetime'])) ?></b></small></p>
						 <p>Available Seats : <b><h4><?php echo $row['seats'] - $booked ?></h4></b></p>
					</div>
					<div class="col-md-3 text-center align-self-end-sm">
						<h4 class="text-right"><b><?php echo number_format($row['price'],2) ?></b></h4>
						<button class="btn-outline-primary  btn  mb-4 book_flight" type="button" data-id="<?php echo $row['id'] ?>"  data-name="<?php echo $aname[$row['departure_airport_id']].' - '.$aname[$row['arrival_airport_id']] ?>" data-max="<?php echo $row['seats'] - $booked ?>">Book Now</button>
					</div>
				</div>
				<hr class="divider" style="max-width: 60vw">
				<?php endwhile; ?>
				<?php else: ?>
					<div class="row align-items-center">
						<h5 class="text-center"><b>No result.</b></h5>
					</div>
				<?php endif; ?>
					
				<?php if(isset($trip) && $trip ==2): ?>
					<hr>
					<div class="row">
						<div class="col-md-12 text-center">
							<h2><b><?php echo isset($trip) && $trip == 2 ? "Arrival Searched Flight results..." : ( !isset($trip)? " Flights Available " :"Searched Flight results...")  ?></b></h2>
						</div>
					</div>
						<hr class="divider">
				<?php 
				$airport = $conn->query("SELECT * FROM airport_list ");
				while($row = $airport->fetch_assoc()){
					$aname[$row['id']] = ucwords($row['airport'].', '.$row['location']);
				}
				$where = " where date(f.departure_datetime) > '".date("Y-m-d")."' ";
				if($_SERVER['REQUEST_METHOD'] == "POST" )
				$where .= " and f.departure_airport_id ='$arrival_airport_id' and f.arrival_airport_id = '$departure_airport_id' and date(f.departure_datetime) = '".date('Y-m-d',strtotime($date_return))."'  ";
				$flight = $conn->query("SELECT f.*,a.airlines,a.logo_path FROM flight_list f inner join airlines_list a on f.airline_id = a.id $where order by rand()");
				if($flight->num_rows > 0):
				while($row=$flight->fetch_assoc()):
					$booked = $conn->query("SELECT * FROM booked_flight where flight_id = ".$row['id'])->num_rows;

				?>
				<div class="row align-items-center">
					<div class="col-md-3">
						<img src="assets/img/<?php echo $row['logo_path'] ?>" alt="">
					</div>
					<div class="col-md-6">
						 <p><b><?php echo $aname[$row['departure_airport_id']].' - '.$aname[$row['arrival_airport_id']] ?></b></p>
						 <p><small>Airline: <b><?php echo $row['airlines'] ?></b></small></p>
						 <p><small>Departure: <b><?php echo date('h:i A',strtotime($row['departure_datetime'])) ?></b></small></p>
						 <p><small>Arrival: <b><?php echo (date('M d,Y',strtotime($row['departure_datetime'])) == date('M d,Y',strtotime($row['arrival_datetime']))) ? date('h:i A',strtotime($row['arrival_datetime'])) : date('M d,Y h:i A',strtotime($row['arrival_datetime'])) ?></b></small></p>
						 <p>Available Seats : <b><h4><?php echo $row['seats'] - $booked ?></h4></b></p>
					</div>
					<div class="col-md-3 text-center align-self-end-sm">
						<h4 class="text-right"><b><?php echo number_format($row['price'],2) ?></b></h4>
						<button class="btn-outline-primary  btn  mb-4 book_flight" type="button" data-id="<?php echo $row['id'] ?>"  data-name="<?php echo $aname[$row['departure_airport_id']].' - '.$aname[$row['arrival_airport_id']] ?>" data-max="<?php echo $row['seats'] - $booked ?>">Book Now</button>
					</div>
				</div>
				<hr class="divider" style="max-width: 60vw">
				<?php endwhile; ?>
				<?php else: ?>
					<div class="row align-items-center">
						<h5 class="text-center"><b>No result.</b></h5>
					</div>
				<?php endif; ?>
				<?php endif; ?>
				</div>
				</div>
        	</div>
        </div>
    </section>
    <style>
    	#flight img{
    		max-height: 300px;
    		max-width: 200px; 
    	}
    	#flight p{
    		margin: unset
      	}
    </style>
    <script>
        
       $('.view_schedule').click(function(){
			uni_modal($(this).attr('data-name')+" - Schedule","view_doctor_schedule.php?id="+$(this).attr('data-id'))
		})
       $('.book_flight').click(function(){
       	if($(this).attr('data-max') <= 0){
       		alert("There is no Available Seats for the selected flight");
       		return false;
       	}
			uni_modal($(this).attr('data-name'),"book_flight.php?id="+$(this).attr('data-id')+"&max="+$(this).attr('data-max'),'mid-large')
		})
        $('[name="trip"]').on("keypress change keyup",function(){
            if($(this).val() == 1){
                $('#rdate').hide()
            }else{
                $('#rdate').show()
            }
        })
    </script>  -->
	
