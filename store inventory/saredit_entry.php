<?php
// Step 1: Check if the login form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Step 2: Verify the entered username and password
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check the credentials (replace these with your actual credentials)
    $valid_username = "admin";
    $valid_password = "admin123";

    if ($username === $valid_username && $password === $valid_password) {
        // If credentials are correct, continue with the SAR Entry process
        session_start();
        $_SESSION['loggedin'] = true;
        // Redirect to SAR Entry Form if Sl_No is available, otherwise, redirect to a default page
        if(isset($_GET['Sl_No'])) {
            header("Location: sarprocess.php?Sl_No=" . $_GET['Sl_No']);
        } else {
            header("Location: default_page.php");
        }
        exit();
    } else {
        // If credentials are incorrect, display an error message
        echo "<script>alert('Invalid username or password. Please try again.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Login</title>
   <style>

      
        body {
    font-family: cambria;
    background-color: #1F305E;
    margin: 0;
    padding: 0;
}

h1 {
    text-align: center;
    margin-top: 50px;
    color: white;
}
p{
    text-align: center;
    color: yellow;
    font-size: 20px;
}

form {
    width: 300px;
    margin: 0 auto;
    background-color: #1F305E;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    border: 2px solid white;
}

label {
    display: block;
    margin-bottom: 10px;
    color: white; /* Text color for labels */
}

input[type="text"],
input[type="password"] {
    width: calc(100% - 20px);
    padding: 10px;
    margin-bottom: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 16px; /* Font size for input fields */
    background-color: #1F305E;
    color: white;
}

input[type="submit"] {
    width: 100%;
    background-color: #007bff;
    color: #fff;
    border: none;
    padding: 10px;
    border-radius: 3px;
    cursor: pointer;
    font-size: 16px; /* Font size for submit button */
    transition: background-color 0.3s ease; /* Smooth transition for hover effect */
    
}

input[type="submit"]:hover {
    background-color: #0056b3;
    
}
.sidenav {
    height: 100%;
    width: 0;
    position: fixed;
    z-index: 1;
    top: 0;
    left: 0;
    background-color: #0056b3;
    overflow-x: hidden;
    transition: 0.5s;
    padding-top: 60px;
}

.sidenav a {
    padding: 10px 15px;
    text-decoration: none;
    font-size: 18px;
    color: #818181;
    display: block;
    transition: 0.3s;
}

.sidenav a:hover {
    font-size: 20px;
    background-color:black;
}

.toggle-btn {
    position: fixed;
    top: 20px;
    left: 20px;
    z-index: 2;
    cursor: pointer;
    background-color: white;
    padding: 10px;
    border-radius: 50px;
    box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.2);
    text-decoration: none;
    height: 30px;
}

.toggle-btn:hover {
    background-color: #f0f0f0;
}

/* Style the toggle button active state */
.toggle-btn.active {
    background-color: #d1c8c8;
}

/* Style the toggle icon */
.toggle-icon {
    color: #333;
    font-size: 24px;
}
#link{
    color: white;
}
.imgg{
    width:35px;
    height:35px;
}
    </style>
</head>
<body>
<a href="javascript:void(0);" class="icon toggle-btn" onclick="toggleNav()">
    <img class ="imgg" src="toggle.png" alt="Toggle Icon" class="toggle-icon">
</a>

    <div id="mySidenav" class="sidenav">
        <br>
        <br>
    <a href="dashboard.php" id="link">Dashboard</a>
    <a href="sar_entry.php" id="link">Stock Arrival Register</a>
    <a href="goods_inward.php" id="link">Goods Inward Register</a>
    <a href="issueregister.php" id="link">Issue Register</a>
    <a href="condemned.php" id="link">Items Condemened</a>
    <a href="consumables.php.php" id="link">Consumables(DSR-M)</a>
    <a href="machinery.php" id="link">Machinery & Equipments (DSR-A)</a>
    <a href="furniture.php" id="link">Furniture (DSR-FA)</a>
    <a href="strive.php" id="link">Strive (DSR-S)</a>
    <a href="hostel.php" id="link">Hostel (DSR-H)</a>
    
</div>
    <h1>Login</h1>
    <p>Only Admin Can Edit The Details!</p>
    <form action="" method="post">
        <label for="username">Username:</label><br>
        <input type="text" id="username" name="username" required><br>
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br>
        <input type="submit" value="Login">
    </form>
    <script>
var navbarOpen = false; // Track the state of the navbar

function toggleNav() {
    var nav = document.getElementById("mySidenav");
    var toggleBtn = document.querySelector(".toggle-btn");

    // Toggle the state of the navbar
    navbarOpen = !navbarOpen;

    // Set the width of the navbar based on the state
    nav.style.width = navbarOpen ? "250px" : "0";

    // Toggle the "active" class for styling the button
    toggleBtn.classList.toggle("active");
}
</script>
</body>
</html>

