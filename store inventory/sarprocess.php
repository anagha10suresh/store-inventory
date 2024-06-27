<?php
// Check if user is logged in
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: saredit_entry.php");
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
$Sl_No = $Date = $Seller_Details = $Item_Description = $Quantity = $Invoice_Details = $Store_Arrival_Date = $Trade = $Remarks = "";

// Check if sl_no is provided in the URL
if(isset($_GET['Sl_No'])) {
    $Sl_No = $_GET['Sl_No'];
    // Fetch existing data from the database based on sl_no
    $sql = "SELECT * FROM sar_entry WHERE Sl_No='$Sl_No'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $Date = $row['Date'];
        $Seller_Details = $row['Seller_Details'];
        $Item_Description = $row['Item_Description'];
        $Quantity = $row['Quantity'];
        $Invoice_Details = $row['Invoice_Details'];
        $Store_Arrival_Date = $row['Store_Arrival_Date'];
        $Trade = $row['Trade'];
        $Remarks = $row['Remarks'];
        // Fetch other data similarly
    } else {
        echo "No data found";
    }
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $Sl_No = $_POST['sl_no'];
    $Date = $_POST['date'];
    $Seller_Details = $_POST['seller_details'];
    $Item_Description = $_POST['item_description'];
    $Quantity = $_POST['quantity'];
    $Invoice_Details = $_POST['invoice_details'];
    $Store_Arrival_Date = $_POST['store_arrival_date'];
    $Trade = $_POST['trade'];
    $Remarks = $_POST['remarks'];
    // Retrieve other form fields similarly

    // Update the record in the database
    $sql = "UPDATE sar_entry SET Date='$Date', Seller_Details='$Seller_Details', Item_Description='$Item_Description', Quantity='$Quantity', Invoice_Details='$Invoice_Details', Store_Arrival_Date='$Store_Arrival_Date', Trade='$Trade', Remarks='$Remarks' WHERE Sl_No='$Sl_No'";

    if ($conn->query($sql) === TRUE) {
        // Redirect to sar_entry.php after successful update
        header("Location: sar_entry.php");
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
    <title>Edit Stock Arrival</title>
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
    <h1>Edit Stock Arrival Details</h1>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <input type="hidden" name="sl_no" value="<?php echo $Sl_No; ?>">
        <label for="date">Date:</label><br>
        <input type="date" id="date" name="date" value="<?php echo $Date; ?>"><br>
        <label for="seller_details">Seller Details:</label><br>
        <input type="text" id="seller_details" name="seller_details" value="<?php echo $Seller_Details; ?>"><br>
        <label for="item_description">Item Description:</label><br>
        <input type="text" id="item_description" name="item_description" value="<?php echo $Item_Description; ?>"><br>
        <label for="quantity">Quantity:</label><br>
        <input type="text" id="quantity" name="quantity" value="<?php echo $Quantity; ?>"><br>
        <label for="invoice_details">Invoice Details:</label><br>
        <input type="text" id="invoice_details" name="invoice_details" value="<?php echo $Invoice_Details; ?>"><br>
        <label for="store_arrival_date">Store Arrival Date:</label><br>
        <input type="date" id="store_arrival_date" name="store_arrival_date" value="<?php echo $Store_Arrival_Date; ?>"><br>
        <label for="trade">Trade:</label><br>
        <input type="text" id="trade" name="trade" value="<?php echo $Trade; ?>"><br>
        <label for="remarks">Remarks:</label><br>
        <input type="text" id="remarks" name="remarks" value="<?php echo $Remarks; ?>"><br>
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
