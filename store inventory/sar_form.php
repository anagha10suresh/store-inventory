<?php

session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit();
}
?>
<?php
// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Connect to the database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "store";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Retrieve form data
    $Sl_No = $_POST['Sl_No'];
    $Date = $_POST['Date'];
    $Seller_Details = $_POST['Seller_Details'];
    $Item_Description = $_POST['Item_Description'];
    $Quantity = $_POST['Quantity'];
    $Invoice_Details = $_POST['Invoice_Details'];
    $Store_Arrival_Date = $_POST['Store_Arrival_Date'];
    $Trade = $_POST['Trade'];
    $Remarks = $_POST['Remarks'];

    // Insert data into sar_entry table
    $sql = "INSERT INTO sar_entry (Sl_No, Date, Seller_Details, Item_Description, Quantity, Invoice_Details, Store_Arrival_Date, Trade, Remarks) 
            VALUES ($Sl_No, '$Date', '$Seller_Details', '$Item_Description', $Quantity, '$Invoice_Details', '$Store_Arrival_Date', '$Trade', '$Remarks')";

    if ($conn->query($sql) === TRUE) {
        // Redirect to sar_entry.php
        header("Location: sar_entry.php");
        exit();
    } else {
        // Store the error message in a variable
        $error_message = "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock Arrival Form</title>
    <style>
        /* General Styling */
        body {
            font-family: cambria;
            background-color: #1F305E;
            color: white;
        }

        h1 {
            color: white;
            text-align: center;
        }

        /* Form Styling */
        form {
            max-width: 500px;
            margin: 0 auto;
            padding: 10px;
            border: 3px solid white;
            border-radius: 10px;
            color: white;
        }

        form label {
            display: block;
            margin-bottom: 3px;
            color: white;
        }

        form input[type="text"],
        form input[type="date"],
        form input[type="number"],
        form input[type="file"] {
            width: calc(100% - 22px);
            padding: 8px;
            margin-bottom: 5px;
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
            font-family: cambria;
        }

        form input[type="file"]::file-selector-button {
            font-family: Cambria;
            color: white;
            background-color: #1F305E;
            border-radius: 10px;
            border: 1px solid white;
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

        #link {
            color: white;
        }

        .imgg {
            width: 35px;
            height: 35px;
        }
    </style>
</head>
<body>
    <a href="javascript:void(0);" class="icon toggle-btn" onclick="toggleNav()">
        <img class="imgg" src="toggle.png" alt="Toggle Icon" class="toggle-icon">
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

    <h1>SAR Entry Form</h1>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="Sl_No">Sl_No:</label><br>
        <input type="number" id="Sl_No" name="Sl_No" required><br>
        <label for="Date">Date:</label><br>
        <input type="date" id="Date" name="Date" required><br>
        <label for="Seller_Details">Seller Details:</label><br>
        <input type="text" id="Seller_Details" name="Seller_Details" required><br>
        <label for="Item_Description">Item Description:</label><br>
        <input type="text" id="Item_Description" name="Item_Description" required><br>
        <label for="Quantity">Quantity:</label><br>
        <input type="number" id="Quantity" name="Quantity" required><br>
        <label for="Invoice_Details">Invoice Details:</label><br>
        <input type="text" id="Invoice_Details" name="Invoice_Details" required><br>
        <label for="Store_Arrival_Date">Store Arrival Date:</label><br>
        <input type="date" id="Store_Arrival_Date" name="Store_Arrival_Date" required><br>
        <label for="Trade">Trade:</label><br>
        <input type="text" id="Trade" name="Trade" required><br>
        <label for="Remarks">Remarks:</label><br>
        <input type="text" id="Remarks" name="Remarks" required><br>
        <input type="submit" value="Submit">
    </form>

    <?php
    // Display error message if any
    if (isset($error_message)) {
        echo "<p>Error: $error_message</p>";
    }
    ?>

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
