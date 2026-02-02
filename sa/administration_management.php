<!DOCTYPE html>
<!--=== Coding by CodingLab | www.codinglabweb.com === -->
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!----======== CSS ======== -->
    <link rel="stylesheet" href="css/administration_style.css">
     
    <!----===== Iconscout CSS ===== -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <title>PUP Queue</title>
</head>
<style>
        .gallery {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 10px;
            padding: 20px;
            position: relative; /* Position relative for z-index */
        }
        .gallery-item {
            position: relative;
        }
        .gallery-item img, .gallery-item video {
            max-width: 100%;
            height: auto;
            display: block;
            border-radius: 5px;
        }
        .delete-button {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: red;
            color: white;
            border: none;
            border-radius: 50%;
            padding: 5px;
            cursor: pointer;
        }

        /* Style for modal */
        .modal {
            display: none;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%); /* Center the modal */
            z-index: 1000; /* Ensure modal is displayed in front */
            background-color: rgba(0, 0, 0, 0.9);
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5); /* Add shadow */
        }

        .modal-content {
            display: block;
            max-width: 100%;
            max-height: 80vh; /* Limit height */
            margin: auto;
        }

        .close {
            color: #fff;
            font-size: 2rem;
            position: absolute;
            top: 20px;
            right: 20px;
            cursor: pointer;
        }
    </style>
<body>
    <nav>
        <div class="logo-name">
            <div class="logo-image">
                <img src="images/logo.png" alt="">
            </div>

            <span class="logo_name">CodingLab</span>
        </div>

        <div class="menu-items">
            <ul class="nav-links">
                <li><a href="administration_index.php">
                    <i class="uil uil-estate"></i>
                    <span class="link-name">Dahsboard</span>
                </a></li>
                <li><a href="administration_management.php">
                    <i class="uil uil-files-landscapes"></i>
                    <span class="link-name">Management</span>
                </a></li>
                <li><a href="#">
                    <i class="uil uil-chart"></i>
                    <span class="link-name">Report</span>
                </a></li>
                <li><a href="administration_monitoring.php">
                    <i class="uil uil-thumbs-up"></i>
                    <span class="link-name">Monitoring</span>
                </a></li>
            </ul>
            
            <ul class="logout-mode">
                <li><a href="#">
                    <i class="uil uil-signout"></i>
                    <span class="link-name">Logout</span>
                </a></li>

                <li class="mode">
                    <a href="#">
                        <i class="uil uil-moon"></i>
                    <span class="link-name">Dark Mode</span>
                </a>

                <div class="mode-toggle">
                  <span class="switch"></span>
                </div>
            </li>
            </ul>
        </div>
    </nav>

    <section class="dashboard">
        <div class="top">
            <i class="uil uil-bars sidebar-toggle"></i>

            <div class="search-box">
                <i class="uil uil-search"></i>
                <input type="text" placeholder="Search here...">
            </div>
            
            <img src="images/profile.jpg" alt="">
        </div>

        <div class="dash-content">
            <div class="overview">
                <div class="title">
                    <i class="uil uil-tachometer-fast-alt"></i>
                    <span class="text">Offices Management</span>
                </div>

                <div class="boxes">
                    
<!-- 
                    <div class="box box1" style="margin: 7px;">
                        <div class="head">
                            
                        </div>
                    </div>

 -->
                </div>
            </div>
        </div>

        <hr style="margin: 20px;">

        <div>
            <h1>Adding Office</h1>

            <form action="administration_add_office.php" method="post" enctype="multipart/form-data">
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

        <hr style="margin: 20px;">

        <div class="col-md-12">
            <h1>Adding Services</h1>
            <form action="add_services.php" method="post" enctype="multipart/form-data">
                <div class="form-row p-1">
                    <div class="col">
                        <select name="admin_username" class="form-control"> <!-- Added name attribute and class -->
                            <option>Select Office</option>
                            <?php include_once "administration_add_services.php"; ?>
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

        <hr style="margin: 20px;">

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

        <hr style="margin: 20px;">

        <div>
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
                                    <form action="administration_delete_office_services.php" method="post" onsubmit="return confirmDelete(\'' . $office['office'] . '\')">
                                        <input type="hidden" name="office" value="' . $office['office'] . '">
                                        <input type="submit" value="Delete" name="submit">
                                    </form>
                                </td>';
                            echo '<td>
                                    <form action="administration_disable_office.php" method="post" onsubmit="return confirmUpdate(\'' . $office['office'] . '\')">
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

            <!-- <?php include 'enable_office.php' ?> -->
        </div>

        <hr style="margin: 20px;">



    </section>


    <script src="js/administration_script.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script>
        $(document).ready(function(){
            // Add input field with animation when the button is clicked
            $('#addServiceButton').click(function(){
                var selectedOffice = $('select[name="admin_username"]').val();
                var newInputField = $('<div class="form-row p-1" style="display: none;"><div class="col"><input class="form-control" type="text" name="services[]" placeholder="Service"><input type="hidden" name="offices[]" value="' + selectedOffice + '"></div></div>');
                $('#servicesContainer').append(newInputField);
                newInputField.slideDown(); // Slide down animation
            });
        });
    </script>
   
</body>
</html>