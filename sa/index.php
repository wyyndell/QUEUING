<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PUP Kiosk</title>
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/main-style.css">
</head>
<body>
    <div class="header">
        <div class="img-container">
            <img src="img/Header.jpg" alt="header-image">
        </div>
            <div class="header-nav">
                <h1 class="company-name">Polytechnic University of the Philippines <br>Unisan Campus</h1>
                <div class="datetime">
                    <div class="date-time">
                        <span class="date"></span>
                        <span class="year"></span>
                    </div>
                    <div class="time-day">
                        <span class="time"></span>
                        <span class="day"></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Welcome Section-->

        <div class="welcome" id="command">
            <h1>Welcome to Unisan Campus</h1>
            <p>To start click <span style="color: var(--blck); font-weight: 500;">'Continue'</span> below</p>
            <div class="btn">
                <a href="client_form.php"><button id="proceedButton">Continue</button></a>
            </div>
        </div>
    </div>
    <script src="js/client.js"></script>
</body>
</html>
