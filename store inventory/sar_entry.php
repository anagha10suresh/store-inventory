<?php

session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock Arrival Register</title>
    <style>
         body {
   
   margin: 16px ;
   padding: 0;
   background-color:#1F305E;
   color:white;
}

.container {
   max-width: 800px;
   margin: 20px auto;
   padding: 20px;
}

h1 {
   text-align: center;
}

table {
   width: 100%;
   border-collapse: collapse;
  
}

table, th, td {
   border: 2px solid #ccc;
   font-size:18px;

}

th, td {
   padding: 10px;
   text-align: left;
}

th {
   background-color: #0CAFFF;
   

}

a {
   text-decoration: none;
   color: white;}

.edit {
   text-decoration: none;
   color: white;
   border: 1px solid white; /* Set border to 10px solid with transparent color */
   display: inline-flex; /* Ensure the link behaves like a flex container */
   align-items: center; /* Align items vertically */
   justify-content: center; /* Align content horizontally */
   height: 25px; /* Set height to 20px (adjust as needed) */
   width: 45px; /* Set width to 40px (adjust as needed) */
   border-radius:10px;
  
}
.edit:hover {
   background-color: rgba(255, 255, 255, 0.4); /* White color with 40% transparency */
}

button {
   padding: 10px 20px;
   background: linear-gradient(to bottom, #33ccff 0%, #6666ff 100%) ;
   color: white;
   border: none;
   cursor: pointer;
   border-radius: 5px;
   font-size:18px;
   font-family:cambria;
}

button:hover {
   background: linear-gradient(to bottom, #ffccff 0%, #6666ff 100%);
   color:#1F305E;
}
.image{
   width:25px;
   height:25px;
   padding-left:35px;
    /* Vertically center */
    
   
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
    <center>
    <h1>Stock Arrival Register</h1>
    <a href="sar_form.php"><button>Add Stock</button></a></center>
    <br>
    <br>
    <table>
        <tr>
            <th>Sl. No</th>
            <th>Date</th>
            <th>Seller Details</th>
            <th>Item Description</th>
            <th>Quantity</th>
            <th>Invoice Details</th>
            <th>Store Arrival Date</th>
            <th>Trade</th>
            <th>Remarks</th>
            <th>Action</th>
        </tr>
        <?php
        // Establish database connection
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "store";

        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Fetch data from the database
        $sql = "SELECT * FROM sar_entry";
        $result = $conn->query($sql);

        // Check if there are any rows returned
        if ($result->num_rows > 0) {
            // Output data of each row
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["Sl_No"] . "</td>";
                echo "<td>" . $row["Date"] . "</td>";
                echo "<td>" . $row["Seller_Details"] . "</td>";
                echo "<td>" . $row["Item_Description"] . "</td>";
                echo "<td>" . $row["Quantity"] . "</td>";
                echo "<td>" . $row["Invoice_Details"] . "</td>";
                echo "<td>" . $row["Store_Arrival_Date"] . "</td>";
                echo "<td>" . $row["Trade"] . "</td>";
                echo "<td>" . $row["Remarks"] . "</td>";
                echo "<td><a class='edit' href='saredit_entry.php?Sl_No=" . $row["Sl_No"] . "'>Edit</a></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='9'>0 results</td></tr>";
        }
        // Close database connection
        $conn->close();
        ?>
    </table>
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
