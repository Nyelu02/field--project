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
					<span class="text">All reports</span>
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
					<h1>Location</h1>
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
		</main>
		<iframe src="https://www.google.com/maps/d/u/0/embed?mid=1j9cm9MJd3oYANBbGtitLGJKO4gTOICM&ehbc=2E312F&noprof=1" style= "height: 500px; width: 990px;  padding: 2px 2px 2px 2px;"></iframe>
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