<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
	<link rel="stylesheet" href="css/superadmin_style.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<title>PUP Queue</title>
</head>
<body>

	<!-- SIDEBAR -->
	<section id="sidebar">
		<a href="superadmin_index.php" class="brand"><i class='bx bxs-smile icon'></i>PUP Queue</a>
		<ul class="side-menu">
			<li><a href="superadmin_index.php" class="active"><i class='bx bxs-dashboard icon' ></i> Dashboard</a></li>
			<li class="divider" data-text="main">Main</li>
			<li>
				<a href="#"><i class='bx bxs-inbox icon' ></i> Control <i class='bx bx-chevron-right icon-right' ></i></a>
				<ul class="side-dropdown">
					<li><a href="operation.php">Operation</a></li>
					<li><a href="s_history.php">Report</a></li>
					<li><a href="superadmin_monitoring.php">Client Monitoring</a></li>
					<li><a href="superadmin_announcement.php">Announcement</a></li>
					<li><a href="s_pending.php">Pending Clients</a></li>
				</ul>
			</li>
		</ul>
	</section>
	<!-- SIDEBAR -->

	<!-- NAVBAR -->
	<section id="content">
		<!-- NAVBAR -->
		<nav>
			<i class='bx bx-menu toggle-sidebar' ></i>
			<form action="#">
				<div class="form-group">
					<input type="text" placeholder="Search...">
					<i class='bx bx-search icon' ></i>
				</div>
			</form>
			<a href="#" class="nav-link">
				<i class='bx bxs-bell icon' ></i>
				<span class="badge">5</span>
			</a>
			<span class="divider"></span>
			<div class="profile">
				<img src="https://images.unsplash.com/photo-1517841905240-472988babdf9?ixid=MnwxMjA3fDB8MHxzZWFyY2h8NHx8cGVvcGxlfGVufDB8fDB8fA%3D%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" alt="">
				<ul class="profile-link">
					<li><a href="#"><i class='bx bxs-user-circle icon' ></i> Profile</a></li>
					<li><a href="#"><i class='bx bxs-cog' ></i> Settings</a></li>
					<li><a href="#"><i class='bx bxs-log-out-circle' ></i> Logout</a></li>
				</ul>
			</div>
		</nav>
		<!-- NAVBAR -->

		<!-- MAIN -->
		<main>
			<h1 class="title">Dashboard</h1>
			<ul class="breadcrumbs">
				<li><a href="#">Home</a></li>
				<li class="divider">/</li>
				<li><a href="#" class="active">Dashboard</a></li>
			</ul>
			<div class="info-data" id="office-data-container">
			    <?php include "online_offices.php"; ?>
			</div>
			<div class="data">
				
				<div class="content-data">
					<div class="head">
						<a href="superadmin_monitoring.php"><i class="fa-solid fa-expand"></i></a>
						<h3>Client Monitoring</h3>
						<div class="menu">
							<i class='bx bx-dots-horizontal-rounded icon'></i>
							<ul class="menu-link">
								<li><a href="superadmin_announcement.php"><i class="fa-solid fa-upload"></i> Upload</a></li>
								<li><a href="superadmin_announcement.php"><i class="fa-solid fa-trash"></i> Remove</a></li>
							</ul>
						</div>
					</div>
					<div>
						<!-- <p class="day"><span>Today</span></p> -->
						
						<!-- now serving monitor -->

						<div style="width: 100%; height: 30%;">
							<?php include 's_monitor.php'?>
						</div>
					</div>
					<!-- <form action="#">
						<div class="form-group">
							<input type="text" placeholder="Type...">
							<button type="submit" class="btn-send"><i class='bx bxs-send' ></i></button>
						</div>
					</form> -->
				</div>
			</div>

		</main>
		<!-- MAIN -->
	</section>
	<!-- NAVBAR -->

	<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
	<script src="js/superadmin_script.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

	<script>

		// fetching online offices and its data
		// Function to fetch and update data from PHP script
        function updateData() {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("office-data-container").innerHTML = this.responseText;
                }
            };
            xmlhttp.open("GET", "online_offices.php", true);
            xmlhttp.send();
        }

        // Call the updateData function every 1 second
        setInterval(updateData, 1000);

	</script>


</body>
</html>