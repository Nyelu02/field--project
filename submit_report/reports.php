<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- Boxicons -->
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
	<!-- My CSS -->
	<link rel="stylesheet" href="dashboard.css">

	<title>greenscout</title>

    <style>

	.status{
	color: black;
	font-size: 18px;
   }
   
	</style>
</head>
<body>


	<!-- SIDEBAR -->
	<section id="sidebar">
		<a href="dashboard.php" class="brand">
           <!-- <img src="images/logo.png" alt="Logo"> -->
			<span class="text">Greenscout</span>
		</a>
		<ul class="side-menu top">
			<li id="dashboard">
				<a href="dashboard.php">
					<i class='bx bxs-dashboard' ></i>
					<span class="text">Dashboard</span>
				</a>
			</li>
			<li id="location">
				<a href="location.php">
                   <i class='bx bx-current-location'></i>
					<span class="text">Location</span>
				</a>
			</li>
			<li id="reports">
				<a href="reports.php">
					<i class='bx bxs-message-dots' ></i>
					<span class="text">All issued reports</span>
				</a>
			</li>
		</ul>
		<ul class="side-menu">
			<li>
				<a href="login.php" class="logout">
					<i class='bx bxs-log-out-circle' ></i>
					<span class="text">Logout</span>
				</a>
			</li>
		</ul>
	</section>
	<!-- SIDEBAR -->



	<!-- CONTENT -->
	<section id="content">
		<!-- NAVBAR -->
		<nav>
			<i class='bx bx-menu' ></i>
		</nav>
		<!-- NAVBAR -->

		<!-- MAIN -->
		<main>
			<div class="head-title">
				<div class="left">
					<h1>All issued reports</h1>
					<ul class="breadcrumb">
						<li>
							<a href="#">Dashboard</a>
						</li>
						<li><i class='bx bx-chevron-right' ></i></li>
						<li>
							<a class="active" href="dashboard.php">Home</a>
						</li>
					</ul>
				</div>
			</div>

            <div class="table-data">
				<div class="order">
					<div class="head">
						<h3>List of reports</h3>
					</div>
					<table>
                    <thead>
                        <tr>
                            <th>incident</th>
                            <th>image</th>
                            <th>location</th>
                            <th>Reported date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
					<?php
// Include your database connection file
include("dbconnection.php");

// Establish a connection to the database
$con = dbconnection();

// Fetch reports with status 'completed'
$sql = "SELECT incident_type, image_path, location, reported_date, status FROM report WHERE status = 'Reviewed'";
$result = mysqli_query($con, $sql);

// Loop through the results and display them in the table
while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td>" . $row['incident_type'] . "</td>";
    echo "<td><img src='" . $row['image_path'] . "' alt='Image' style='width: 100px; height: 100px; border-radius: 5%; object-fit: cover;'></td>";
    echo "<td>" . $row['location'] . "</td>";
    echo "<td>" . $row['reported_date'] . "</td>";
    echo "<td>" . $row['status'] . "</td>";
    echo "</tr>";
}

// Close the database connection
mysqli_close($con);
?>

                    </tbody>
                </table>
            </div>
        </div>
    </main>
    <!-- MAIN -->

    <!-- (Your existing JavaScript includes) -->

</body>
</html>
		<!-- MAIN -->
	</section>
	<!-- CONTENT -->
	

	<script src="dashboard.js"></script>

    <script>
    // Get all the list items in the sidebar with JavaScript
    const sidebarItems = document.querySelectorAll('.side-menu li');

    // Loop through each list item and add a click event listener
    sidebarItems.forEach(item => {
        item.addEventListener('click', () => {
            // Remove the 'active' class from all list items
            sidebarItems.forEach(i => i.classList.remove('active'));

            // Add the 'active' class to the clicked list item
            item.classList.add('active');
        });
    });
</script>
</body>
</html>