
<?php
//GOODS INWARD ENTRY //
session_start();
// Check if user is not logged in or not authenticated
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // Redirect to the login page
    header("Location: login.php");
    exit();
}
?>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = mysqli_connect("localhost", "root", "", "store");

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    $Sl_No = $_POST['Sl_No'];
    $supplierName = $_POST['supplierName'];
    $supplierAddress = $_POST['supplierAddress'];
    $poNumber = $_POST['poNumber'];
    $dateOfPO = $_POST['dateOfPO'];
    $itemDescription = $_POST['itemDescription'];
    $qtyRecord = $_POST['qtyRecord'];
    $binCardNo = $_POST['binCardNo'];
    $stockLedgerNo = $_POST['stockLedgerNo'];
    $remarks = $_POST['remarks'];

    $sql = "INSERT INTO goods_inward_register (Sl_No, Supplier_Name, Supplier_Address, PO_Number, Date_of_PO,
    Item_Description, Qty_Record, Bin_Card_No, Stock_Ledger_No, Remarks)
VALUES ('$Sl_No', '$supplierName', '$supplierAddress', '$poNumber', '$dateOfPO',
    '$itemDescription', '$qtyRecord', '$binCardNo', '$stockLedgerNo', '$remarks')";

    if (mysqli_query($conn, $sql)) {
        mysqli_close($conn);
        header("Location: goods_inward.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Goods Entry</title>
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
form input[type="number"],
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
    <div class="container">
        <h1>Goods Inward Entry Form</h1>
        
        <div class="go-back">
            <a href="goods_inward.php">Go Back</a>
        </div>

        <!-- Form to add new entry -->
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <label for="Sl_No">Sl_No:</label>
            <input type="number" id="Sl_No" name="Sl_No" required>
            
            <label for="supplierName">Supplier Name:</label>
            <input type="text" id="supplierName" name="supplierName" required>
            
            <label for="supplierAddress">Supplier Address:</label>
            <input type="text" id="supplierAddress" name="supplierAddress" required>
            
            <label for="poNumber">PO Number:</label>
            <input type="text" id="poNumber" name="poNumber" required>
            
            <label for="dateOfPO">Date of PO:</label>
            <input type="date" id="dateOfPO" name="dateOfPO" required>
            
            <label for="itemDescription">Item Description:</label>
            <input type="text" id="itemDescription" name="itemDescription" required>
            
            <label for="qtyRecord">Quantity Record:</label>
            <input type="number" id="qtyRecord" name="qtyRecord" required>
            
            <label for="binCardNo">Bin Card No:</label>
            <input type="text" id="binCardNo" name="binCardNo" required>
            
            <label for="stockLedgerNo">Stock Ledger No:</label>
            <input type="text" id="stockLedgerNo" name="stockLedgerNo" required>
            
            <label for="remarks">Remarks:</label>
            <input type="text" id="remarks" name="remarks" required >
            
            <input type="submit" value="submit">
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
