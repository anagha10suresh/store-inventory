<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit();
}

// Include the file upload function
function uploadFile($file) {
    $targetDirectory = "uploads/"; // Directory where uploaded files will be stored
    $targetFile = $targetDirectory . basename($file["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    if(isset($_POST["submit"])) {
        $check = getimagesize($file["tmp_name"]);
        if($check !== false) {
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
    }

    // Check file size
    if ($file["size"] > 5000000) { // Adjust size as needed
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($file["tmp_name"], $targetFile)) {
            return $targetFile; // Return the path of the uploaded file
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle file upload and get the file path
    $uploadedFilePath = uploadFile($_FILES["fileToUpload"]);
    if (!$uploadedFilePath) {
        // Handle file upload error
        echo "File upload failed.";
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

    // Process form data
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
    $Received = implode(",", $_POST['Received']); // Convert array to comma-separated string
    $Issued = implode(",", $_POST['Issued']); // Convert array to comma-separated string
    $Balance = implode(",", $_POST['Balance']); // Convert array to comma-separated string

    // Insert data into the database
    $sql = "INSERT INTO hostel (GIRNo, Date, SupplierName, SlNo, Description, Quantity, EachRupees, TotalRupees, IndentSlNo, IndentNo, IndentDate, IndentingOfficialName, LabSection, Received, Issued, Balance, ImageFilePath) 
            VALUES ('$GIRNo', '$Date', '$SupplierName', '$SlNo', '$Description', '$Quantity', '$EachRupees', '$TotalRupees', '$IndentSlNo', '$IndentNo', '$IndentDate', '$IndentingOfficialName', '$LabSection', '$Received', '$Issued', '$Balance', '$uploadedFilePath')";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
        // Redirect to strive.php
        header("Location: hostel.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
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
    <title>Add hostel</title>
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
    <h1>Add hostel</h1>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
        <!-- Add form fields for each column in the hostel table -->
        <label for="GIRNo">GIR No.:</label>
        <input type="text" id="GIRNo" name="GIRNo" required><br><br>
        
        <label for="Date">Date:</label>
        <input type="date" id="Date" name="Date" required><br><br>
        
        <label for="SupplierName">Name of Supplier:</label>
        <input type="text" id="SupplierName" name="SupplierName" required><br><br>
        
        <label for="SlNo">Sl. No.:</label>
        <input type="text" id="SlNo" name="SlNo" required><br><br>
        
        <label for="Description">Description of Stores:</label>
        <input type="text" id="Description" name="Description" required><br><br>
        
        <label for="Quantity">Quantity:</label>
        <input type="number" id="Quantity" name="Quantity" required><br><br>
        
        <label for="EachRupees">Each Rupees:</label>
        <input type="number" id="EachRupees" name="EachRupees" required><br><br>
        
        <label for="TotalRupees">Total Rupees:</label>
        <input type="number" id="TotalRupees" name="TotalRupees" required><br><br>

        <label for="IndentSlNo">Indent SlNo.:</label>
        <input type="text" id="IndentSlNo" name="IndentSlNo" required><br><br>
        
        <label for="IndentNo">Indent No.:</label>
        <input type="text" id="IndentNo" name="IndentNo" required><br><br>
        
        <label for="IndentDate">Indent Date:</label>
        <input type="date" id="IndentDate" name="IndentDate" required><br><br>
        
        <label for="IndentingOfficialName">Name of Indenting Official:</label>
        <input type="text" id="IndentingOfficialName" name="IndentingOfficialName" required><br><br>
        
        <label for="LabSection">Lab Section:</label>
        <input type="text" id="LabSection" name="LabSection" required><br><br>
        <label for="Received">Received</label>
        <input type="text" id="Received" name="Received[]" multiple><br>

        <label for="Issued">Issued</label>
        <input type="text" id="Issued" name="Issued[]" multiple><br>

        <label for="Balance">Balance</label>
        <input type="text" id="Balance" name="Balance[]" multiple><br>
        <label for="fileToUpload">Upload Image:</label><br>
        <input type="file" name="fileToUpload" id="fileToUpload"><br>
        
        <input type="submit" name="submit" value="Submit">
    </form>
    <?php
    // Check if the form is submitted
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

        // Process form data
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
        $Received = implode(",", $_POST['Received']); // Convert array to comma-separated string
        $Issued = implode(",", $_POST['Issued']); // Convert array to comma-separated string
        $Balance = implode(",", $_POST['Balance']); // Convert array to comma-separated string


        // Insert data into the database
        $sql = "INSERT INTO hostel (GIRNo, Date, SupplierName, SlNo, Description, Quantity, EachRupees, TotalRupees, IndentSlNo, IndentNo, IndentDate, IndentingOfficialName, LabSection, Received, Issued, Balance,ImageFilePath) 
                VALUES ('$GIRNo', '$Date', '$SupplierName', '$SlNo', '$Description', '$Quantity', '$EachRupees', '$TotalRupees', '$IndentSlNo', '$IndentNo', '$IndentDate', '$IndentingOfficialName', '$LabSection', '$Received', '$Issued', '$Balance','$uploadedFilePath')";


        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
            // Redirect to hostel.php
            header("Location: hostel.php");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
        // Close connection
        $conn->close();
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
