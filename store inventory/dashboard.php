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
    <title>Store Management Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> <!-- Font Awesome for icons -->
    <style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #1F305E;
        }

    header {
        position: fixed;
        top: 0;
        width: 100%;
        background: linear-gradient(to right, #1F305E, #0CAFFF);
        color: white;
        padding: 20px;
        text-align: center;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        border-bottom: 2px solid #0CAFFF;
        z-index: 1000; /* Ensure the header is above other content */
        }
  
    header:hover {
        background: linear-gradient(to right, #0CAFFF, #1F305E);
        }
       
    nav {
        position: fixed;
        top: 60px; /* Start just after the header */
        left: 0;
        width: 200px;
        height: calc(100% - 60px); /* Adjusted height to fit remaining space */
        background-color: #1F305E;
        color: #fff;
        overflow-y: auto; /* Add scrollbar if content exceeds the height */
        padding-top: 20px;
        border-right: 2px solid #0CAFFF;
        z-index: 1000; /* Ensure the nav is above other content */
        margin-top:62px;
        }

    nav a {
        display: block;
        color: #fff; /* Text color */
        text-align: left;
        padding: 14px 16px;
        text-decoration: none;
        border-bottom: 1px solid #0CAFFF; /* Border at the bottom of each nav link */
        }

    nav a:hover {
        background-color: #f2f2f2;
        color: #0CAFFF; /* Hover background color */
        }

    .dropdown:hover .dropdown-content {
        display: block;
        }
    /* Dropdown styles */
    .dropdown-content {
        display: none;
        position: absolute;
        background-color: white; /* Dropdown background color */
        box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);
        padding: 8px;
        z-index: 1;
        width: auto;
        min-width: 200px;
        border-radius: 4px;
        border: 1px solid #ccc;
        color: black; /* Color for dropdown items */
        }

    .dropdown-content a {
        display: block;
        padding: 6px 12px;
        text-decoration: none;
        color: #333; /* Color for dropdown items */
        }

    .dropdown-content a:hover {
        background-color: white;
        color: #0CAFFF; /* Hover background color for dropdown items */
        }

    .dashboard-content {
        margin-left: 220px; /* Adjusted margin to accommodate the width of the navbar and border */
        padding: 20px;
        display: flex;
        flex-wrap: wrap;
        justify-content: space-around;
        margin-top: 100px;
        }

    .container {
        width: calc(45% - 20px); /* Adjusted width to accommodate for margin and border */
        margin-right: 20px; /* Added margin to separate containers */
        margin-bottom: 20px;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 8px;
        text-align: center;
        box-sizing: border-box;
        transition: background-color 0.3s;
        color: white;
        text-decoration:none;
        margin-top:30px;
        }

    .container:hover {
        background-color: #f2f2f2;
        color: #0CAFFF;
        }

    .container i {
        font-size: 48px;
        margin-bottom: 10px;
        }

    .value {
        display: block;
        border: 1px solid #ccc; 
        padding: 8px; 
        border-radius: 4px; 
        margin-bottom: 5px; 
        cursor: pointer; 
        text-decoration: none; 
        color: #333;
        }
    </style>
</head>
<body>
    <div class="navbar-header-container">
        <header>
            <h1>Store Management Dashboard</h1>
        </header>
        <nav>
            <a href="dashboard.php">Dashboard</a>
            <a href="sar_entry.php">Stock Arrival Register</a>
            <a href="goods_inward.php">Goods Inward Register</a>
            <a href="issueregister.php">Issue Register</a>
            <a href="condemned.php">Items Condemned</a>
            <div class="dropdown">
                <a href="#">Dead Stock Register</a>
                <div class="dropdown-content">
                    <a href="consumables.php">Consumables(DSR-M)</a>
                    <a href="machinery.php">Machinery & Equipments(DSR-A)</a>
                    <a href="furniture.php">Furniture(DSR-FA)</a>
                    <a href="strive.php">Strive(DSR-S)</a>
                    <a href="hostel.php">Hostel(DSR-H)</a>
                </div>
            </div>
        </nav>
    </div>
    <div class="dashboard-content">
        <a href="sar_entry.php" class="container" id="dashboard-link">
            <div id="stock-arrival">
                <i class="fas fa-clipboard"></i>
                <h2>Stock Arrival Register</h2>
            </div>
        </a>
        <a href="goods_inward.php" class="container" id="stock-arrival-link">
            <div id="goods-inward">
                <i class="fas fa-edit"></i>
                <h2>Goods Inward Register</h2>
            </div>
        </a>
        <a href="issueregister.php" class="container" id="goods-inward-link">
            <div id="issue-register">
                <i class="fas fa-box"></i>
                <h2>Issue Register</h2>
            </div>
        </a>
        <a href="condemned.php" class="container" id="issue-register-link">
            <div id="item-condemned">
                <i class="fas fa-ban"></i>
                <h2>Item Condemned</h2>
            </div>
        </a>
        <div class="container" id="deadstock">
            <i class="fas fa-truck"></i>
            <h2>Dead Stock Register</h2>
            <div id="values"></div>
        </div>
    </div>
    <script>
    var values = [
    {name: "Consumables(DSR-M)", link: "consumables.php"},
    {name: "Machinery & Equipments(DSR-A)", link: "machinery.php"},
    {name: "Furniture(DSR-FA)", link: "furniture.php"},
    {name: "Strive(DSR-S)", link: "strive.php"},
    {name: "Hostel(DSR-H)", link: "hostel.php"}
    ];
    function displayValues() {
    var valuesContainer = document.getElementById("values");
    valuesContainer.innerHTML = ''; // Clear previous values
    var index = 0;
    function addValue() {
        if (index < values.length) {
            var value = values[index];
            // Wrap each value in an anchor tag with its corresponding link
            valuesContainer.innerHTML += "<a href='" + value.link + "' class='value'>" + value.name + "</a>";
            index++;
            setTimeout(addValue, 200); // Add delay of 1 second between values
            }
        }
        addValue(); // Start adding values with delay
        // Remove the click event listener after displaying values once
        document.getElementById("deadstock").removeEventListener("click", displayValues);
    }
    // Add event listener to the Dead Stock Register container
    document.getElementById("deadstock").addEventListener("click", displayValues);
    // Add event listener to hide values when mouse leaves Dead Stock Register container
    document.getElementById("deadstock").addEventListener("mouseleave", function() {
        document.getElementById("values").innerHTML = ''; // Clear values when mouse leaves
        document.getElementById("deadstock").addEventListener("click", displayValues); // Re-add click event listener
    });
    </script>
</body>
</html>