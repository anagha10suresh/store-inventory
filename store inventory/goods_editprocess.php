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
$sl_no = $supplier_name = $supplier_address = $po_number = $date_of_po = $item_description = $qty_record = $bin_card_no = $stock_ledger_no = $remarks = "";

// Check if sl_no is provided in the URL
if(isset($_GET['sl_no'])) {
    $sl_no = $_GET['sl_no'];
    // Fetch existing data from the database based on sl_no
    $sql = "SELECT * FROM goods_inward_register WHERE Sl_No='$sl_no'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {

        $row = $result->fetch_assoc();
  
        $supplier_name = $row['Supplier_Name'];
        $supplier_address = $row['Supplier_Address'];
        $po_number = $row['PO_Number'];
        $date_of_po = $row['Date_of_PO'];
        $item_description = $row['Item_Description'];
        $qty_record = $row['Qty_Record'];
        $bin_card_no = $row['Bin_Card_No'];
        $stock_ledger_no = $row['Stock_Ledger_No'];
        $remarks = $row['Remarks'];
        // Fetch other data similarly
    } else {
        echo "No data found";
    }
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $sl_no = $_POST['sl_no'];
    $supplier_name = $_POST['supplier_name'];
    $supplier_address = $_POST['supplier_address'];
    $po_number = $_POST['po_number'];
    $date_of_po = $_POST['date_of_po'];
    $item_description = $_POST['item_description'];
    $qty_record = $_POST['qty_record'];
    $bin_card_no = $_POST['bin_card_no'];
    $stock_ledger_no = $_POST['stock_ledger_no'];
    $remarks = $_POST['remarks'];
    // Retrieve other form fields similarly

    // Update the record in the database
    $sql = "UPDATE goods_inward_register SET Supplier_Name='$supplier_name', Supplier_Address='$supplier_address', PO_Number='$po_number', Date_of_PO='$date_of_po', Item_Description='$item_description', Qty_Record='$qty_record', Bin_Card_No='$bin_card_no', Stock_Ledger_No='$stock_ledger_no', Remarks='$remarks' WHERE Sl_No='$sl_no'";

    if ($conn->query($sql) === TRUE) {
        // Redirect to goods_inward.php after successful update
        header("Location: goods_inward.php");
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
    <title>Edit Goods Inward Register</title>
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
    <h1>Edit Goods Inward Register</h1>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <input type="hidden" name="sl_no" value="<?php echo $sl_no; ?>">
        
        <label for="supplier_name">Supplier Name:</label><br>
        <input type="text" id="supplier_name" name="supplier_name" value="<?php echo $supplier_name; ?>"><br>
        <label for="supplier_address">Supplier Address:</label><br>
        <input type="text" id="supplier_address" name="supplier_address" value="<?php echo $supplier_address; ?>"><br>
        <label for="po_number">PO Number:</label><br>
        <input type="text" id="po_number" name="po_number" value="<?php echo $po_number; ?>"><br>
        <label for="date_of_po">Date of PO:</label><br>
        <input type="date" id="date_of_po" name="date_of_po" value="<?php echo $date_of_po; ?>"><br>
        <label for="item_description">Item Description:</label><br>
        <input type="text" id="item_description" name="item_description" value="<?php echo $item_description; ?>"><br>
        <label for="qty_record">Qty Record:</label><br>
        <input type="text" id="qty_record" name="qty_record" value="<?php echo $qty_record; ?>"><br>
        <label for="bin_card_no">Bin Card No:</label><br>
        <input type="text" id="bin_card_no" name="bin_card_no" value="<?php echo $bin_card_no; ?>"><br>
        <label for="stock_ledger_no">Stock Ledger No:</label><br>
        <input type="text" id="stock_ledger_no" name="stock_ledger_no" value="<?php echo $stock_ledger_no; ?>"><br>
        <label for="remarks">Remarks:</label><br>
        <input type="text" id="remarks" name="remarks" value="<?php echo $remarks; ?>"><br>
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
