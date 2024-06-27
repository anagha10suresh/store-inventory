<?php
// Check if user is logged in
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit();
}

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

// Initialize variables to store existing data
$GIRNo = $Date = $SupplierName = $SlNo = $Description = $Quantity = $EachRupees = $TotalRupees = $IndentSlNo = $IndentNo = $IndentDate = $IndentingOfficialName = $LabSection = $Received = $Issued = $Balance = "";

// Check if GIRNo is provided in the URL
if(isset($_GET['GIRNo'])) {
    $GIRNo = $_GET['GIRNo'];
    // Fetch existing data from the database based on GIRNo
    $sql = "SELECT * FROM strive WHERE GIRNo='$GIRNo'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $Date = $row['Date'];
        $SupplierName = $row['SupplierName'];
        $SlNo = $row['SlNo'];
        $Description = $row['Description'];
        $Quantity = $row['Quantity'];
        $EachRupees = $row['EachRupees'];
        $TotalRupees = $row['TotalRupees'];
        $IndentSlNo = $row['IndentSlNo'];
        $IndentNo = $row['IndentNo'];
        $IndentDate = $row['IndentDate'];
        $IndentingOfficialName = $row['IndentingOfficialName'];
        $LabSection = $row['LabSection'];
        $Received = $row['Received'];
        $Issued = $row['Issued'];
        $Balance = $row['Balance'];
        // Fetch other data similarly
    } else {
        echo "No data found";
    }
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $GIRNo = $_POST['GIRNo'];
    $Date = $_POST['Date'];
    $SupplierName = $_POST['SupplierName'];
    $SlNo = $_POST['SlNo'];
    $Description = $_POST['Description'];
    $Quantity = $_POST['Quantity'];
    $EachRupees = $_POST['EachRupees'];
    $TotalRupees = $_POST['TotalRupees'];
    $IndentSlNo = $_POST['IndentSlNo'];
    $IndentNo = $_POST['IndentNo'];
    $IndentDate = $_POST['IndentDate'];
    $IndentingOfficialName = $_POST['IndentingOfficialName'];
    $LabSection = $_POST['LabSection'];
    $Received = $_POST['Received'];
    $Issued = $_POST['Issued'];
    $Balance = $_POST['Balance'];
    // Retrieve other form fields similarly

    // Update the record in the database
    $sql = "UPDATE strive SET Date='$Date', SupplierName='$SupplierName', SlNo='$SlNo', Description='$Description', Quantity='$Quantity', EachRupees='$EachRupees', TotalRupees='$TotalRupees', IndentSlNo='$IndentSlNo', IndentNo='$IndentNo', IndentDate='$IndentDate', IndentingOfficialName='$IndentingOfficialName', LabSection='$LabSection', Received='$Received', Issued='$Issued', Balance='$Balance' WHERE GIRNo='$GIRNo'";

    if ($conn->query($sql) === TRUE) {
        // Redirect to strive.php after successful update
        header("Location: strive.php");
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Strive Entry</title>
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
    filter: invert(100%); }
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
    <h1>Edit Strive Entry</h1>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <input type="hidden" name="GIRNo" value="<?php echo $GIRNo; ?>">
        <label for="Date">Date:</label><br>
        <input type="date" id="Date" name="Date" value="<?php echo $Date; ?>"><br>
        <label for="SupplierName">Name of Supplier:</label><br>
        <input type="text" id="SupplierName" name="SupplierName" value="<?php echo $SupplierName; ?>"><br>
        <label for="SlNo">Sl. No.:</label><br>
        <input type="text" id="SlNo" name="SlNo" value="<?php echo $SlNo; ?>"><br>
        <label for="Description">Description of Stores:</label><br>
        <input type="text" id="Description" name="Description" value="<?php echo $Description; ?>"><br>
        <label for="Quantity">Quantity:</label><br>
        <input type="text" id="Quantity" name="Quantity" value="<?php echo $Quantity; ?>"><br>
        <label for="EachRupees">Each Rupees:</label><br>
        <input type="text" id="EachRupees" name="EachRupees" value="<?php echo $EachRupees; ?>"><br>
        <label for="TotalRupees">Total Rupees:</label><br>
        <input type="text" id="TotalRupees" name="TotalRupees" value="<?php echo $TotalRupees; ?>"><br>
        <label for="IndentSlNo">Indent SlNo.:</label><br>
        <input type="text" id="IndentSlNo" name="IndentSlNo" value="<?php echo $IndentSlNo; ?>"><br>
        <label for="IndentNo">Indent No.:</label><br>
        <input type="text" id="IndentNo" name="IndentNo" value="<?php echo $IndentNo; ?>"><br>
        <label for="IndentDate">Indent Date:</label><br>
        <input type="date" id="IndentDate" name="IndentDate" value="<?php echo $IndentDate; ?>"><br>
        <label for="IndentingOfficialName">Name of Indenting Official:</label><br>
        <input type="text" id="IndentingOfficialName" name="IndentingOfficialName" value="<?php echo $IndentingOfficialName; ?>"><br>
        <label for="LabSection">Lab Section:</label><br>
        <input type="text" id="LabSection" name="LabSection" value="<?php echo $LabSection; ?>"><br>
        <label for="Received">Received:</label><br>
        <input type="text" id="Received" name="Received" value="<?php echo $Received; ?>"><br>
        <label for="Issued">Issued:</label><br>
        <input type="text" id="Issued" name="Issued" value="<?php echo $Issued; ?>"><br>
        <label for="Balance">Balance:</label><br>
        <input type="text" id="Balance" name="Balance" value="<?php echo $Balance; ?>"><br>
       

        <!-- Add other input fields for remaining columns -->
        <input type="submit" value="Submit">
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
