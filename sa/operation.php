<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
	<link rel="stylesheet" href="css/superadmin_style.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<title>Operation</title>

</head>
<body>

<style>
    .content-data.hidden, .content-data.hidden1, .content-data.hidden2, .content-data.hidden3, .content-data.chat {
        display: none;
    }
</style>

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
					<li><a href="superadmin_history.php">Report</a></li>
					<li><a href="monitor.php">Client Monitoring</a></li>
					<li><a href="superadmin_announcement.php">Announcement</a></li>
					<li><a href="superadmin_pending_clients_monitor.php">Pending Clients</a></li>
			</li>
			<!-- <li><a href="#"><i class='bx bxs-chart icon' ></i> Charts</a></li>
			<li><a href="#"><i class='bx bxs-widget icon' ></i> Widgets</a></li>
			<li class="divider" data-text="table and forms">Table and forms</li>
			<li><a href="#"><i class='bx bx-table icon' ></i> Tables</a></li>
			<li>
				<a href="#"><i class='bx bxs-notepad icon' ></i> Forms <i class='bx bx-chevron-right icon-right' ></i></a>
				<ul class="side-dropdown">
					<li><a href="#">Basic</a></li>
					<li><a href="#">Select</a></li>
					<li><a href="#">Checkbox</a></li>
					<li><a href="#">Radio</a></li>
				</ul>
			</li> -->
		</ul>
		<!-- <div class="ads">
			<div class="wrapper">
				<a href="#" class="btn-upgrade">Upgrade</a>
				<p>Become a <span>PRO</span> member and enjoy <span>All Features</span></p>
			</div>
		</div> -->
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
			<a href="#" id="chatButton" class="nav-link">
				<i class='bx bxs-message-square-dots icon' ></i>
				<span class="badge">8</span>
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
			<h1 class="title">Operation</h1>
			<ul class="breadcrumbs">
				<li><a href="superadmin_index.php">Home</a></li>
				<li class="divider">/</li>
				<li><a href="#" class="active">Operation</a></li>
			</ul>
			<div class="info-data">
                <button id="offices_toggle" style="border: none;">
                    <div class="card">
                        <div class="head">
                            <div>
                                <h2>Add Office</h2>
                                <p>Here you can create office account</p>
                            </div>
                            <i class="fa-solid fa-user-tie"></i>
                        </div>
                        <i class="fa-solid fa-circle-plus" style="font-size: 25px; color: #007bff;"></i>
                    </div>
				</button>

				<button id="services_toggle" style="border: none;">
                    <div class="card">
                        <div class="head">
                            <div>
                                <h2>Add Services</h2>
                                <p>Here you can add a services for specific office</p>
                            </div>
                            <i class="fa-brands fa-buffer"></i>
                        </div>
                        <i class="fa-solid fa-circle-plus" style="font-size: 25px; color: #007bff;"></i>
                    </div>
                </button>


                <button id="view_toggle" style="border: none;">
                    <div class="card">
                        <div class="head">
                            <div>
                                <h2>View Offices</h2>
                                <p>Here you can view offices and update their services</p>
                            </div>
                            <i class="fa-solid fa-book-open-reader"></i>
                        </div>
                        <i class="fa-regular fa-eye" style="font-size: 25px; color: #007bff;"></i>
                    </div>
				</button>

				<button id="delete_toggle" style="border: none;">
                    <div class="card">
                        <div class="head">
                            <div>
                                <h2>Delete Office</h2>
                                <p>Here you can manage offices accounts accessiblity</p>
                            </div>
                            <i class="fa-solid fa-user-xmark"></i>
                        </div>
                        <i class="fa-solid fa-trash" style="font-size: 25px; color: #007bff;"></i>
                    </div>
				</button>
			</div>

			<div class="data ">
			    <div class="content-data hidden">
                    <div class="services_container hidden">
                        <div class="col-md-12">
                            <h1>Adding Services</h1>
                            <form action="add_services.php" method="post" enctype="multipart/form-data">
                                <div class="form-row p-1">
                                    <div class="col">
                                        <select name="admin_username" class="form-control"> <!-- Added name attribute and class -->
                                            <option>Select Office</option>
                                            <?php include_once "add_services.php"; ?>
                                        </select>
                                    </div>
                                </div>
                                <div id="servicesContainer"> <!-- Container for dynamically added input fields -->
                                    <div class="form-row p-1">
                                        <div class="col">
                                            <input class="form-control" type="text" name="services[]" placeholder="Service">
                                            <input type="hidden" name="office[]" value="" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row p-1">
                                    <div class="col">
                                        <button type="button" class="control" id="addServiceButton">
                                            <i class="fa-solid fa-circle-plus" style="font-size: 25px; color: #007bff;"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="form-row p-1">
                                    <div class="col">
                                        <input class="btn btn-primary" type="submit" value="Save" name="submit">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="content-data hidden1">
                    <div class="offices_container hidden">
                        <div class="col-md-12">
                            <h1>Adding Office</h1>

                            <form action="add_office.php" method="post" enctype="multipart/form-data">
                                <div class="form-row p-1">
                                    <div class="col"><input class="form-control" type="text" name="username" placeholder="Username"></div>
                                    <div class="col"><input class="form-control" type="text" name="password" placeholder="Password"></div>
                                </div>
                                <div class="form-row p-1">
                                    <div class="col"><input class="form-control" type="text" name="fname" placeholder="First Name"></div>
                                    <div class="col"><input class="form-control" type="text" name="lname" placeholder="Last Name"></div>
                                    <div class="col"><input class="form-control" type="text" name="office" placeholder="Office"></div>
                                </div>
                                <div class="form-row p-1">
                                    <div class="col">
                                        <input class="btn btn-primary" type="submit" value="Register" name="submit">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="content-data hidden2">
                    <div class="view_container hidden">
                        <div class="row">
                            <div class="col-md-12">
                            	<h1>Viewing Office</h1>
                                <div class="form-row p-1">
                                    <div class="col">
                                    <label for="admin_office">Office</label>
                                        <select name="admin_office" id="admin_office" class="form-control">
                                            <option value="">Select Office</option>
                                            <?php
                                            // Include database connection
                                            $db = new PDO('mysql:host=localhost; dbname=queuewee', 'root', '');

                                            // Fetch all office names from the database
                                            $query = "SELECT DISTINCT office FROM admin WHERE accessibility != 'disable'";
                                            $stmt = $db->prepare($query);
                                            $stmt->execute();
                                            $offices = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                            // Output options for select dropdown
                                            foreach ($offices as $office) {
                                                echo '<option value="' . $office['office'] . '">' . $office['office'] . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div id="records_table">
                                    <!-- Records table will be loaded here -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="content-data hidden3">
				    <div class="office_delete_container hidden">
				        <h2>Enabled Office(s)</h2>
				        <table>
				            <thead>
				                <tr>
				                    <th>First Name</th>
				                    <th>Last Name</th>
				                    <th>Office</th>
				                    <th></th>
				                </tr>
				            </thead>
				            <tbody>
				                <?php
				                // Database connection
				                $db = new PDO('mysql:host=localhost; dbname=queuewee', 'root', '');

				                // Fetch all office data from the database
				                $query = "SELECT fname, lname, office FROM admin WHERE accessibility != 'disable'";
				                $stmt = $db->prepare($query);
				                $stmt->execute();
				                $offices = $stmt->fetchAll(PDO::FETCH_ASSOC);

				                // Output table rows with office data
				                foreach ($offices as $office) {
				                    echo '<tr>';
				                    echo '<td>' . $office['fname'] . '</td>';
				                    echo '<td>' . $office['lname'] . '</td>';
				                    echo '<td>' . $office['office'] . '</td>';
				                    echo '<td>
				                            <form action="delete_office_services.php" method="post" onsubmit="return confirmDelete(\'' . $office['office'] . '\')">
				                                <input type="hidden" name="office" value="' . $office['office'] . '">
				                                <input type="submit" value="Delete" name="submit">
				                            </form>
				                        </td>';
				                    echo '<td>
				                            <form action="disable_office.php" method="post" onsubmit="return confirmUpdate(\'' . $office['office'] . '\')">
				                                <input type="hidden" name="office" value="' . $office['office'] . '">
				                                <input type="submit" value="Disable" name="disable">
				                            </form>
				                        </td>';
				                    echo '</tr>';
				                }
				                ?>
				            </tbody>
				        </table>
				    </div>

				    <?php include 'enable_office.php' ?>
				</div>


                <div class="content-data chat">
					<div class="head">
						<h3>Announcement</h3>
						<div class="menu">
							<i class='bx bx-dots-horizontal-rounded icon'></i>
							<ul class="menu-link">
								<li><a href="#">Edit</a></li>
								<li><a href="#">Save</a></li>
								<li><a href="#">Remove</a></li>
								<li><a href="#" id="closeButton">Close</a></li>
							</ul>
						</div>
					</div>
					<div class="chat-box">
						<p class="day"><span>Today</span></p>
						<div class="msg">
							<img src="https://images.unsplash.com/photo-1517841905240-472988babdf9?ixid=MnwxMjA3fDB8MHxzZWFyY2h8NHx8cGVvcGxlfGVufDB8fDB8fA%3D%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" alt="">
							<div class="chat">
								<div class="profile">
									<span class="username">Alan</span>
									<span class="time">18:30</span>
								</div>
								<p>Hello</p>
							</div>
						</div>
						<div class="msg me">
							<div class="chat">
								<div class="profile">
									<span class="time">18:30</span>
								</div>
								<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Eaque voluptatum eos quam dolores eligendi exercitationem animi nobis reprehenderit laborum! Nulla.</p>
							</div>
						</div>

					</div>
					<form action="#">
						<div class="form-group">
							<input type="text" placeholder="Type...">
							<button type="submit" class="btn-send"><i class='bx bxs-send' ></i></button>
						</div>
					</form>
				</div>
			</div>
		</main>
		<!-- MAIN -->
	</section>
	<!-- NAVBAR -->

	<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
	<script src="js/superadmin_script.js"></script>

	<!-- Bootstrap JS na HINDI P'WEDENG TANGGALIN-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- JavaScript to add input field na HINDI P'WEDENG TANGGALIN-->
    <script src=js/appending_input_field.js></script>


    <script>
    	// Wait for the document to be fully loaded
        document.addEventListener('DOMContentLoaded', function() {
            // Get the button element
            var toggleButton = document.getElementById('delete_toggle');

            // Get the content-data element
            var contentData = document.querySelector('.content-data.hidden3');

            // Add click event listener to the button
            toggleButton.addEventListener('click', function() {

                // Toggle the visibility of the content-data element
                contentData.classList.toggle('hidden3');
            });
        });


        function confirmDelete(office) {
            var confirmMsg = "Are you sure you want to delete the '" + office + "' office? This action cannot be undone.";
            return confirm(confirmMsg);
        }

    </script>

</body>
</html>