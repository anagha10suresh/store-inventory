
<?php
error_reporting(0);
include 'table_render.php';

// Database connection
$conn = new mysqli("localhost", "root", "", "tutorial");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $trade = $_POST['trade'];

    // Check user credentials
    $sql = "SELECT * FROM submit WHERE name = '$name' AND trade = 'COPA'";
    if ($conn->query($sql)->num_rows > 0) {
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Invalid email or password";
    }
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // Retrieve form data
    $Sl_No = $_POST['Sl_No'];
    $Date = $_POST['Date'];
    $Standard_tool_list = $_POST['Standard_tool_list'];
    $Item = $_POST['Item'];
    $Item_Description = $_POST['Item_Description'];
    $Quantity = $_POST['Quantity'];
    $Unit_price= $_POST['Unit_price'];
    $Gem_id = $_POST['Gem_id'];
    $Approximate_cost = $_POST['Approximate_cost'];
   

    // Convert the date to a numeric format
    $numericDate = date('Y-m-d', strtotime($Date));

    // Insert data into sar_entry table
    $sql = "INSERT INTO copa (Sl_No, Date, Standard_tool_list,Item, Item_Description, Quantity, Unit_price, Gem_id,Approximate_cost ) 
            VALUES ($Sl_No, '$numericDate', '$Standard_tool_list', '$Item','$Item_Description', $Quantity, '$Unit_price', '$Gem_id', 
            '$Approximate_cost')";

if ($conn->query($sql) === TRUE) {
    // Redirect the user to a different URL after successful submission
    header("Location: copa.php");
    exit(); // Ensure that no further code is executed after the redirect
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}


    
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COPA</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #007bff;
            color: white;
            padding: 10px;
            text-align: center;
        }
        button[type="submit"]:hover {
    background-color: #0056b3;
    text-decoration: none;
}
button[type="submit"] {
    display: block;
    width: 100%;
    padding: 10px;
    border: none;
    background-color: #007bff;
    color: #fff;
    cursor: pointer;
    border-radius: 5px;
    text-decoration: none;
}
        .dashboard-content {
            margin-left: 100px;
            padding: 20px;
            margin-right:100px;
        }

        #productForm {
            display: none;
            
        }

        /* Responsive design */
        @media (max-width: 600px) {
            nav {
                width: 100%;
            }

            .dashboard-content {
                margin-left: 0;
            }
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid black;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .action-buttons {
            white-space: nowrap;
        }
        .form-container {
        max-width: 500px;
        margin: 0 auto;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
        background-color: #f9f9f9;
    }

    /* Form labels */
    .form-container label {
        display: block;
        margin-bottom: 5px;
    }

    /* Form inputs */
    .form-container input[type="text"],
    .form-container input[type="number"],
    .form-container input[type="date"],
    .form-container input[type="submit"] {
        width: calc(100% - 10px);
        padding: 8px;
        margin-bottom: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
    }

    /* Submit button */
    .form-container input[type="submit"] {
        background-color: #4CAF50;
        color: white;
        cursor: pointer;
    }

    /* Submit button on hover */
    .form-container input[type="submit"]:hover {
        background-color: #45a049;
    }

    .search{
        display:flex;
    }
    .export {
        margin-left: 600px;
        
    }
    .export input[type="submit"] {
        background-color: #007bff;
    color: white;
    padding: 9px ;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
    transition: background-color 0.3s ease;
}
.export input[type="submit"]:hover {
    background-color: #0056b3;
}

#print {
  display: inline-block;
  padding: 9px 30px;
  font-size: 16px;
  cursor: pointer;
  border: none;
  border-radius: 5px;
  background-color: #4CAF50;
  color: #fff;
  text-align: center;
  text-decoration: none;
  transition: background-color 0.3s ease;
}

/* Button hover effect */
#print:hover {
  background-color: #45a049;
}

/* Button focus effect */
#print:focus {
  outline: none;
  box-shadow: 0 0 0 3px rgba(0, 0, 0, 0.2);
}

/* Button disabled state */
#print:disabled {
  background-color: #cccccc;
  cursor: not-allowed;
}

/* Button disabled state - hover */
#print:disabled:hover {
  background-color: #cccccc;
}
    

    </style>
  <script>
   function toggleForm() {
    var form = document.getElementById('productForm');
    var table = document.getElementById('productTable');
    var tableHeaderRow = table.querySelector('tr');
     var button = document.getElementById('addProduct');
     var searchDiv = document.getElementById('searchDiv');

    if (form.style.display === 'none') {
        form.style.display = 'block';
        table.style.display = 'none';
        button.style.display = 'none';
        tableHeaderRow.style.display = 'none'; 
        searchDiv.style.display = 'none'; // Hide the table header row
    } else {
        form.style.display = 'none';
        table.style.display = 'block';
        tableHeaderRow.style.display = 'table-row'; 
        searchDiv.style.display = 'flex';// Show the table header row
    }
}


function deleteRow(slNo) {
    if (confirm("Are you sure you want to delete this row permanently?")) {
        // Send a request to delete the row with the specified Sl_No
        let xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                // Display a popup message
                // alert("Row deleted successfully");
                console.log(this.responseText);
                // Refresh or update the UI as needed
                location.reload(); // For example, reload the page after deletion
            }
        };

        // Prepare data to send to the server
        let formData = new FormData();
        formData.append('Sl_No', slNo);

        // Open a POST request to the server
        xhttp.open("POST", "delete_row1.php", true);
        // Send the form data
        xhttp.send(formData);
    }
}

 
        function editRow(slNo) {
            // Get the button element that triggered the edit
            let button = event.target;

            // Access the row containing the button
            let row = button.parentNode.parentNode;

            // Get the cells within the row
            let Sl_NoCell = row.cells[0];
            let DateCell = row.cells[1];
           let Standard_tool_listCell=row.cells[2];
            let ItemDescriptionCell = row.cells[3];
            let ItemCell = row.cells[4];
            let QuantityCell = row.cells[5];
            let Unit_priceCell = row.cells[6];
            let Gem_idCell = row.cells[7];
            let Approximate_costCell = row.cells[8];
           

            // Prompt the user to enter updated values
            let Sl_NoInput = prompt("Enter the updated Sl_No:", Sl_NoCell.innerHTML);
            let DateInput = prompt("Enter the updated Date:", DateCell.innerHTML);
            let Standard_tool_listInput = prompt("Enter the updated Standard_tool_list:", Standard_tool_listCell.innerHTML);
            let ItemDescriptionInput = prompt("Enter the updated Item Description:", ItemDescriptionCell.innerHTML);
            let ItemInput = prompt("Enter the updated Item :", ItemCell.innerHTML);
            let QuantityInput = prompt("Enter the updated Quantity:", QuantityCell.innerHTML);
            let Unit_priceInput = prompt("Enter the updated Unit price:", Unit_priceCell.innerHTML);
            let Gem_idInput = prompt("Enter the updated Gem id :", Gem_idCell.innerHTML);
            let Approximate_costInput = prompt("Enter the updated Approximate cost:", Approximate_costCell.innerHTML);
            

            // Update the cells with the new values
            Sl_NoCell.innerHTML = Sl_NoInput;
            DateCell.innerHTML = DateInput;
            Standard_tool_listCell.innerHTML = Standard_tool_listInput;
            ItemDescriptionCell.innerHTML = ItemDescriptionInput;
            ItemCell.innerHTML = ItemInput;
            QuantityCell.innerHTML = QuantityInput;
            Unit_priceCell.innerHTML = Unit_priceInput;
            Gem_idCell.innerHTML = Gem_idInput;
            Approximate_costCell.innerHTML = Approximate_costInput;
          
        }

        function saveChanges() {
            // Collect data from the table and prepare it for sending to the server
            let tableData = [];
            let table = document.getElementById("productTable");

            // Iterate through the rows (skip header row)
            for (let i = 1; i < table.rows.length; i++) {
                let row = table.rows[i];
                let rowData = {
                    Sl_No: row.cells[0].innerHTML,
                    Date: row.cells[1].innerHTML,
                    Standard_tool_list: row.cells[2].innerHTML,
                    Item_Description: row.cells[3].innerHTML,
                    Item: row.cells[4].innerHTML,
                    Quantity: row.cells[5].innerHTML,
                    Unit_price: row.cells[6].innerHTML,
                    Gem_id: row.cells[7].innerHTML,
                    Approximate_cost: row.cells[8].innerHTML,
                   
                };
                tableData.push(rowData);
            }


            // Send the data to the server using AJAX
            let xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    // Log the server response (you can handle it as needed)
                    console.log(this.responseText);
                }
            };

            // Prepare data to send to the server
            let formData = new FormData();
            formData.append('tableData', JSON.stringify(tableData));

            // Open a POST request to the server
            xhttp.open("POST", "save_changes.php", true);
            // Send the form data
            xhttp.send(formData);
        }
    </script>

</head>
<body>

<header>
    <h1>COPA Purchase Management Dashboard</h1>
</header>



<div class="dashboard-content">
   
<div  id="searchDiv"  class="search">
        <button onclick="toggleForm()" id="addProduct">Add Product</button>
        <input type="text" name="search" onkeyup=myfunction() placeholder="Search..." id="searchin">
        <button type="submit" style="width:9%;height:10%" id="searchbtn">Search</button>
<div>
        <form method="post" action="export1.php" class="export">
     <input type="submit" name="export"  value="Export Data" />
    
     
    </form>
    </div>
    <button name='print' id="print" onclick='redirectToPage()'>Print</button>
    </div>
    <!-- Product Entry Form -->
 
    <form id="productForm" class="form-container" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" style="display: none;">


        <label>SL NO</label>
        <input type="number" name="Sl_No" required><br>

        <label>Date:</label>
        <input type="date" name="Date" required><br>

        <label>Standard_tool_list:</label>
        <input type="text" name="Standard_tool_list" required><br>

        <label>Item :</label>
        <input type="text" name="Item" required><br>

        <label>Item Description:</label>
        <input type="text" name="Item_Description" required><br>

        <label>Quantity:</label>
        <input type="number" name="Quantity" required><br>

        <label>Unit_price:</label>
        <input type="text" name="Unit_price" required><br>

        <label>Gem_id:</label>
        <input type="text" name="Gem_id" required><br>

        <label>Approximate_cost:</label>
        <input type="text" name="Approximate_cost" required><br>

        
        <input type="submit" name="submit" value="Submit" >
    </form>

    

    
   
    <!-- Display Entered Data in Table -->
    <?php

// if (isset($_POST['search']) && !empty($_POST['search'])) {
//     $search = $_POST['search'];
//     $sql = "SELECT * FROM copa WHERE Sl_No LIKE '%$search%' OR Date LIKE '%$search%' OR Standard_tool_list LIKE '%$search%' OR Item LIKE '%$search%' OR Item_Description LIKE '%$search%' OR Quantity LIKE '%$search%' OR Unit_price LIKE '%$search%' OR Gem_id LIKE '%$search%' OR Approximate_cost LIKE '%$search%'";
// } else {
//     $sql = "SELECT * FROM copa";
//  }





    // Display the SAR entry table
    $result = $conn->query("SELECT * FROM copa");

    if ($result->num_rows > 0) {
        echo "<table id='productTable'>";
        echo "<tr>
                <th>Sl.No</th>
                <th>Date</th>
                <th>Standard_tool_list</th>
                <th>Item</th>
                <th>Item Description</th>
                <th>Quantity</th>
                <th>Unit_price</th>
                <th>Gem_id</th>
                <th>Approximate_cost</th>
                <th>Action</th>
              </tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . $row["Sl_No"] . "</td>
                    <td>" . $row["Date"] . "</td>
                    <td>" . $row["Standard_tool_list"] . "</td>
                    <td>" . $row["Item"] . "</td>
                    <td>" . $row["Item_Description"] . "</td>
                    <td>" . $row["Quantity"] . "</td>
                    <td>" . $row["Unit_price"] . "</td>
                    <td>" . $row["Gem_id"] . "</td>
                    <td>" . $row["Approximate_cost"] . "</td>
                    
                    <td class='action-buttons'>
                        <button onclick='editRow(" . $row["Sl_No"] . ")'>Edit</button>
                        <button onclick='deleteRow(" . $row["Sl_No"] .")'>Delete</button>
                       

                    </td>
                  </tr>";
        }

        echo "</table>";
    } else {
        echo "No data available";
    }
    ?>
</div>
 <script type="text/javascript">
        function redirectToPage() {
            // Redirect to the desired page
            window.location.href = 'print.php';
        }
    </script>

<script>


function myfunction() {
  // Declare variables
  var input, filter, table, tr, td, th, i, j, txtValue;
  input = document.getElementById("searchin");
  filter = input.value.toUpperCase();
  table = document.getElementById("productTable");
  tr = table.getElementsByTagName("tr");

  // Loop through all table rows
  for (i = 1; i < tr.length; i++) { // Start from 1 to skip the header row
    var found = false;
    // Loop through all table cells
    for (j = 0; j < tr[i].cells.length; j++) {
      // Get the cell data
      td = tr[i].getElementsByTagName("td")[j];
      if (td) {
        txtValue = td.textContent || td.innerText;
        // Check if the cell data matches the search query
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
          found = true;
          break;
        }
      }
    }
    // Display or hide the row based on search result
    if (found) {
      tr[i].style.display = "";
    } else {
      tr[i].style.display = "none";
    }
    
  }
}

</script>



</body>
</html>

