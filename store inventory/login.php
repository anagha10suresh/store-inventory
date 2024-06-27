<?php
session_start();

// include 'table_render.php';
$conn = new mysqli("localhost", "root", "", "store");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check user credentials
    $sql = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $_SESSION['loggedin'] = true;
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Invalid email or password";
    }
}

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
    body {
            background-color: white;
            font-family: Arial, sans-serif;
        }

        form {
            max-width: 300px;
            margin: 0 auto;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border: 2px solid #333;
            background-image: url("log.gif");
            background-repeat: no-repeat;
            background-size: cover;   
        }

        label {
            color: black;
            font-weight: bold;
            margin-bottom: 5px;
            display: block;
        }

        input[type="email"],
        input[type="password"],
        input[type="submit"] {
            width: calc(100% - 20px);
            padding: 10px 10px 10px 40px;
            margin-bottom: 20px;
            border: 1px solid black;
            border-radius: 5px;
            box-sizing: border-box;
            background-color: rgba(255, 255, 255, 0.5);
            background-position: 10px center;
            background-repeat: no-repeat;
        }

        input[type="email"]::placeholder,
        input[type="password"]::placeholder {
            font-family: 'FontAwesome';
        }

        input[type="submit"] {
            background-color: black;
            color: white;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #333;
        }

        input[type="submit"]:focus {
            outline: none;
        }
        </style>
</head>
<body>

    <h2><center>Store Login Page<center></h2>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <label for="email">Email:</label>
        <input type="email" id="email" name="email" placeholder="&#xf0e0; Enter your email" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" placeholder="&#xf023; Enter your password" required>

      

        <input type="submit" value="LOGIN">
    <center>
        <?php
    if (isset($error)) {
        echo '<p style="color: red;">' . $error . '</p>';
    }
    ?>
    </center>
    </form>

    

</body>
</html>
