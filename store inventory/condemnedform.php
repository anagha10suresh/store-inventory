<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit();
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection parameters
    $servername = "localhost";
    $username = "root"; // Your MySQL username
    $password = ""; // Your MySQL password
    $dbname = "store"; // Your MySQL database name

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Retrieve form data
    $SlNo = $_POST['SlNo'];
    $Date = $_POST['Date'];
    $ItemName = $_POST['ItemName'];
    $ItemCondemned = $_POST['ItemCondemned'];
    $DateOfPurchase = $_POST['DateOfPurchase'];
    $DSRNo = $_POST['DSRNo'];

    // SQL to insert data into condemned_items table
    $sql = "INSERT INTO condemned (SlNo, Date, ItemName, ItemCondemned, DateOfPurchase, DSRNo) 
            VALUES ('$SlNo', '$Date', '$ItemName', '$ItemCondemned', '$DateOfPurchase', '$DSRNo')";

    if ($conn->query($sql) === TRUE) {
        // Close the connection
        $conn->close();

        // Redirect to condemned.php
        header("Location: condemned.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Condemned Items</title>
    <style>
        /* General Styling */
        body {
            font-family:cambria;
            background-color:#1F305E;
        }
        h1{
            color:white;
            text-align:center;
        }

        /* Form Styling */
        form {
            max-width: 500px;
            margin: 0 auto;
            padding: 10px; /* Reduced padding to minimize form height */
            border: 3px solid white; /* Border for the whole form */
            border-radius: 10px; /* Rounded corners */
            color: white;
        }

        form label {
            display: block;
            margin-bottom: 3px; /* Reduced margin to minimize form height */
            color: white;
        }

        form input[type="text"],
        form input[type="date"],
        form input[type="file"] {
            width: calc(100% - 22px); /* Adjusting width to account for padding */
            padding: 8px; /* Reduced padding to minimize form height */
            margin-bottom: 5px; /* Reduced margin to minimize form height */
            border: 1px solid white;
            border-radius: 5px;
            box-sizing: border-box;
            color: white;
            background-color: #1F305E;
            font-family: Cambria;
        }
        form input[type="date"]::-webkit-calendar-picker-indicator {
            filter: invert(100%);
        }
        form input[type="submit"] {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: #007bff;
            color: white;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
            font-family:cambria;
        }
        form input[type="file"]::file-selector-button {
            font-family: Cambria; /* Set font family to Cambria */
            color: white; /* Text color */
            background-color:#1F305E;
            border-radius:10px;
            border:1px solid white;
        }

        form input[type="submit"]:hover {
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
        <a href="condemned.php" id="link">Items Condemned</a>
        <a href="consumables.php.php" id="link">Consumables(DSR-M)</a>
    <a href="machinery.php" id="link">Machinery & Equipments (DSR-A)</a>
    <a href="furniture.php" id="link">Furniture (DSR-FA)</a>
    <a href="strive.php" id="link">Strive (DSR-S)</a>
    <a href="hostel.php" id="link">Hostel (DSR-H)</a>
    </div>

    <div class="container">
        <h1>Add Condemned Items</h1>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <!-- Add form fields for each column in the condemned_items table -->
            <label for="SlNo">Sl. No.:</label>
            <input type="text" id="SlNo" name="SlNo" required>
            
            <label for="Date">Date:</label>
            <input type="date" id="Date" name="Date" required>
            
            <label for="ItemName">Item Name:</label>
            <input type="text" id="ItemName" name="ItemName" required>
            
            <label for="ItemCondemned">Item Condemned:</label>
            <input type="text" id="ItemCondemned" name="ItemCondemned" required>
            
            <label for="DateOfPurchase">Date of Purchase:</label>
            <input type="date" id="DateOfPurchase" name="DateOfPurchase" required>
            
            <label for="DSRNo">DSR No.:</label>
            <input type="text" id="DSRNo" name="DSRNo" required>
            
            <input type="submit" name="submit" value="Submit">
        </form>
    </div>

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
