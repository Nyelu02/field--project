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
		
.issued{
	        background-color: grey;
			color: white;
			border-radius: 10px;
			padding: 10px;
			text-align: center;
			text-decoration: none;
			display: inline-block;
			font-size: 16px;
			margin: 4px 2px;
			cursor: pointer;
			border: none;
}
.issued:hover{
	background: green;
}

.not-issued{
	        background-color: grey;
			color: white;
			border-radius: 10px;
			padding: 10px;
			text-align: center;
			text-decoration: none;
			display: inline-block;
			font-size: 16px;
			margin: 4px 2px;
			cursor: pointer;
			border: none;
}
.not-issued:hover{
	background: orange;
}

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
					<h1>Dashboard</h1>
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
						<h3>Recent reports</h3>
					</div>
					<table>
    <thead>
        <tr>
            <th>incident</th>
            <th>image</th>
            <th>location</th>
            <th>Reported date</th>
            <th>Status</th>
            <th>Action</th> <!-- New column for buttons -->
        </tr>
    </thead>
    <tbody>
        <?php
        include("dbconnection.php");
        $con = dbconnection();

        $sql = "SELECT id, incident_type, image_path, location, reported_date, status FROM report";

        $result = mysqli_query($con, $sql);

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['incident_type'] . "</td>";
            echo "<td><img src='" . $row['image_path'] . "' alt='Image' style='width: 100px; height: 100px; border-radius: 5%; object-fit: cover;'></td>";
            echo "<td>" . $row['location'] . "</td>";
            echo "<td>" . $row['reported_date'] . "</td>";
            echo "<td><span id=\"status_{$row['id']}\" class='status'>" . $row['status'] . "</span></td>";


            // Add action buttons with onclick events
            echo "<td>";
            echo "<button class='issued' onclick=\"setStatus('Reviewed', " . $row['id'] . ")\" >Addressed</button>";
            echo "<button class='not-issued'onclick=\"setStatus('In progress', " . $row['id'] . ")\">Not Addressed</button>";
            echo "</td>";

            echo "</tr>";
        }

        mysqli_close($con);
        ?>

						        
							
							<!-- <tr>
                                <td>bushfiring</td>
                                <td>image</td>
                                <td>makongo</td>
								<td>01-10-2021</td>
								<td><span class="status pending">Pending</span></td>
							</tr> -->
						</tbody>
					</table>
				</div>
			</div>
		</main>
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

	function setStatus(action, reportId) {
    const statusElement = document.querySelector(`#status_${reportId}`);

    if (action === 'Reviewed') {
        statusElement.innerText = 'issued';
    } else if (action === 'In progress') {
        statusElement.innerText = 'not_issued';
    }

    // Send an AJAX request to update the status in the database
    fetch('update_status.php', {
        method: 'POST',
        body: JSON.stringify({ action, reportId }),
        headers: {
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            console.log('Status updated successfully');
        } else {
            console.error('Error updating status:', data.error);
        }
    })
    .catch(error => console.error('Error:', error));
}

</script>


</body>
</html>