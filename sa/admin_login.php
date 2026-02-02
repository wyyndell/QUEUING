<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-image: url('img/bgcover.png');
            background-size: cover; /* Ensures the background image covers the entire viewport */
            background-repeat: no-repeat; /* Prevents the background image from repeating */
            overflow: hidden;
        }

        .login-container {
            display: none; /* Initially hide the login container */
            flex-direction: column;
            justify-content: center;
            align-items: center;
            width: 390px;
            margin-left: auto;
            padding: 20px;
            background-color: #f8f9fa;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            transition: transform 1s; /* Slow transition duration for transform property */
            transform: translateX(100%); /* Initially move the container out of the viewport to the right */
            overflow: hidden;
            color: #000;
        }

        a {
            text-decoration: none;
            color: #000;
        }

        .a.link {
            margin-top: 30px;
            
        }

        .login-container.show {
            display: flex; /* Show the container */
            transform: translateX(0); /* Move the container to its original position */
        }


        .login-container h2 {
            text-align: center;
        }

        .login-form input {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .login-form button {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 4px;
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
        }

        img {
            height: 100px;
            width: 100px;
        }

        .headings {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background-color: none;
            margin-top: 9rem;
            width: 50%;
            margin-right: auto;
            margin-left: auto;
            text-align: center;
        }

        button {
            margin-top: 30px;
        }

        .fa-solid.fa-user-tie {
            font-size: 60px;
        }
        footer {
            text-align: center;
            margin-top: 11rem;
            font-size: 10px;
        }

        @media screen and (min-width: 768px) {
            .login-container {
                margin-right: auto;
                min-height: 100%;
                padding: 20px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            }

        } 

    </style>
</head>
<body>
    <div class="headings">
        <img src="img/puplogo.png">
        <h1>Polytechnic University of the Philippies Unisan Campus</h1>
        <button onclick="showLogin()">Log-in</button> <!-- Call showLogin() function on button click -->
        <footer>
            <p>Design and Develop by iTPrenuer</p>
        </footer>
    </div>
    <div class="login-container" id="login-container"> <!-- Add id to the login container -->
        <i class="fa-solid fa-user-tie"></i>
        <h2>Admin Login</h2>
        <form class="login-form" action="login.php" method="post">
            <div>
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div>
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Log In</button>
        </form>
        <div class="a link">
            <a href="#">Forgotten Password |</a>
            <a href="#"> Sign Up</a>
        </div>
    </div>

    <script>
        function showLogin() {
            var loginContainer = document.getElementById("login-container");
            loginContainer.classList.add("show"); // Add the "show" class to display the login container with animation
        }
    </script>
</body>
</html>
