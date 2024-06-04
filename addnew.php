<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Product</title>
    <link rel="stylesheet" href="add_new_styles.css">
</head>
<body>
<?php include 'border.php'; ?>
    <div class="container">
    <?php 
    session_start();
    if (isset($_SESSION['id'])) {
    $userId = $_SESSION['id'];
    // Display the user's ID
    echo '<h3 id="uiduser">User id: ' . $userId . '</h3>';
}
?>
        <h1>Add New Product to Display</h1>

        <form action="#" method="post">
        <input type="hidden" name="userId" id="userId" value="<?php echo $userId; ?>">
            <label for="productName">Product Name:</label>
            <input type="text" id="productName" name="productName" required>

            <label for="productName">Product Image:</label>
            <input type="file" id="productImage" name="productImage" required>
            
            <label for="productDescription">Product Description:</label>
            <textarea id="productDescription" name="productDescription" required></textarea>
            
            <label for="productPrice">Product Price:</label>
            <input type="number" id="productPrice" name="productPrice" step="0.01" min="0" required>
            
            <button type="submit">Add Product</button>
        </form>
    </div>
</body>
</html>
<?php
if($_SERVER['REQUEST_METHOD'] === 'POST')
{
    $productName = $_POST['productName'];
    $productDescription = $_POST['productDescription'];
    $productPrice = $_POST['productPrice'];
    $productImage = $_POST['productImage'];
    $userId = $_POST['userId'];
    $servername = "localhost";
    $db_username = "root";
    $db_password = "";

    // Create connection
    $conn = new mysqli($servername, $db_username, $db_password);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }


    $result = $conn->query("SHOW DATABASES LIKE 'ecom'");
    if ($result->num_rows == 0) {
        // Database does not exist, create it
        $sql = "CREATE DATABASE ecom";
        if ($conn->query($sql) === TRUE) {
            echo "Database created successfully";
        } else {
            echo "Error creating database: " . $conn->error;
        }
    } else {
        // echo "Database 'Ecom' already exists";
    }

    

    $query = "Use ecom";

    if ($conn -> query($query) === true)
    {
    // echo "Success";
    }
    else
    {
        die("Error");
    }

    $result = $conn->query("SHOW TABLES LIKE 'product'");

    if ($result->num_rows == 0) {
        // Table does not exist, create it
        $sql = "CREATE TABLE product (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            productName VARCHAR(100) NOT NULL,
            productImage varchar(100) NOT NULL,
            productDescription TEXT,
            productPrice DECIMAL(10, 2),
            userId INT NOT NULL,
        )";
        
        if ($conn->query($sql) === TRUE) {
            echo "Table product created successfully";
        } else {
            echo "Error creating table: " . $conn->error;
        }
    } else {
        // echo "Table product already exists";
    }


    
    $query = "INSERT INTO product (productName, productImage, productDescription, productPrice, userId) VALUES ('$productName', '$productImage', '$productDescription', '$productPrice', '$userId')";
    if ($conn -> query($query) === true)
    {
        //include 'product.php';
    }
    else
    {
        die("Error");
    }

    mysqli_close($conn);
}
?>

