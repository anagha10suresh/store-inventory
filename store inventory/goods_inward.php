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
    <title>Goods Inward</title>
    <style>
        body {
   
   margin: 25px ;
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
   
    <center><h2>WELCOME TO GOODS INWARD REGISTER</h2>
    <a href="add_entry.php"><button>Add Goods Details</button></a></center>
    <br>
    <br>
    <table id="goodsTable"> <!-- Added id attribute -->
        <tr>
            <th>Sl_No</th>
            <th>Supplier Name</th>
            <th>Supplier Address</th>
            <th>PO Number</th>
            <th>Date of PO</th>
            <th>Item Description</th>
            <th>Qty Record</th>
            <th>Bin Card No</th>
            <th>Stock Ledger No</th>
            <th>Remarks</th>
            <th>Action</th>
          
        </tr>
        
        <!-- PHP code to fetch and display existing entries -->
        <?php
        
        $conn = mysqli_connect("localhost", "root", "", "store");

        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $sql = "SELECT * FROM goods_inward_register";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row["Sl_No"] . "</td>";
                echo "<td>" . $row["Supplier_Name"] . "</td>";
                echo "<td>" . $row["Supplier_Address"] . "</td>";
                echo "<td>" . $row["PO_Number"] . "</td>";
                echo "<td>" . $row["Date_of_PO"] . "</td>";
                echo "<td>" . $row["Item_Description"] . "</td>";
                echo "<td>" . $row["Qty_Record"] . "</td>";
                echo "<td>" . $row["Bin_Card_No"] . "</td>";
                echo "<td>" . $row["Stock_Ledger_No"] . "</td>";
                echo "<td>" . $row["Remarks"] . "</td>";
                echo "<td><a class='edit' href='goods_editentry.php?sl_no=".$row["Sl_No"]."'>Edit</a></td></tr>";
                echo "</tr>";
            }
        } else {
            echo "0 results";
        }

        mysqli_close($conn);
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
