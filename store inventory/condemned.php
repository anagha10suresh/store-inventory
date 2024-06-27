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
    <style>
        
    body {
   
    margin: 0;
    padding: 15px;
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

thead {
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
    height: 26px; /* Set height to 20px (adjust as needed) */
    width: 43px;/* Set width to 40px (adjust as needed) */
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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Condemned Items</title>
</head>
<body>
<body>
<a href="javascript:void(0);" class="icon toggle-btn" onclick="toggleNav()">
    <img class ="imgg" src="toggle.png" alt="Toggle Icon" class="toggle-icon">
</a>

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
    <Center><h2>WELCOME TO CONDEMNED REGISTER</h2>
    <!-- Add a button to navigate to the form for adding new condemned items -->
    <a href="condemnedform.php"><button>Add Condemned Items</button></a></center>
    <br>

    <table border="1">
        <thead>
            <tr>
                <th>Sl. No.</th>
                <th>Date</th>
                <th>Item Name</th>
                <th>Item Condemned</th>
                <th>Date of Purchase</th>
                <th>DSR No.</th>
                <th>Action</th> <!-- Add a table header for the Edit button -->
            </tr>
        </thead>
        <tbody>
            <?php
            // Establish connection to MySQL database
            $servername = "localhost";
            $username = "root"; // Change to your MySQL username
            $password = ""; // Change to your MySQL password
            $database = "store"; // Change to your database name

            $conn = new mysqli($servername, $username, $password, $database);

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Fetch data from MySQL table and display it in the table rows
            $sql = "SELECT * FROM condemned";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>".$row["SlNo"]."</td>";
                    echo "<td>".$row["Date"]."</td>";
                    echo "<td>".$row["ItemName"]."</td>";
                    echo "<td>".$row["ItemCondemned"]."</td>";
                    echo "<td>".$row["DateOfPurchase"]."</td>";
                    echo "<td>".$row["DSRNo"]."</td>";
                    // Add an Edit button for each row, linking to edit_condemned.php and passing the SlNo as a parameter
                    echo "<td><a href='condemned_entry.php?SlNo=".$row["SlNo"]."'class='edit'>Edit</a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7'>No condemned items records found</td></tr>";
            }
            $conn->close();
            ?>
        </tbody>
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
