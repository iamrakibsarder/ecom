
<?php
    session_start();
    if(!isset($_SESSION['id'])) {

      header("Location: login.php");
      exit;
    } 
    else {
      
    }
$servername = "localhost";
$db_username = "root";
$db_password = "";
$dbname = "ecom";

// Create connection
$conn = new mysqli($servername, $db_username, $db_password, $dbname);



// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

    $userId = $_SESSION['id'];

// Fetch products from the database
$sql = "SELECT p.productName, p.productImage, p.productDescription, p.productPrice
            FROM product p";
    $result = $conn->query($sql);

?>

<?php
// Database connection parameters

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Simple E-Commerce Website</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>

  <?php include 'border.php'; ?>

  <main>

      <div class="search-box">
        <h2>Search for products: </h2>
        <input id="product-search" type="text" name="search-val">
      </div>

  <div class="container">
        <h1>All Product List</h1>
                <?php
        if ($result->num_rows > 0) {
            echo '<div class="product-wrapper">';
            // Output data of each row
        while($row = $result->fetch_assoc()) {
                echo '<div class="product">';
                echo '<img class="product-image" src="images/' . htmlspecialchars($row["productImage"]) . '" alt="' . htmlspecialchars($row["productName"]) . '">';
                echo '<h2 class="product-title">' . htmlspecialchars($row["productName"]) . '</h2>';
                echo '<p class="product-description">' . htmlspecialchars($row["productDescription"]) . '</p>';
                echo '<span class="product-price">$' . htmlspecialchars($row["productPrice"]) . '</span>';
                echo '</div>';
            }
            echo '</div>';
        } else {
            echo "0 results";
        }
        ?>
        <!-- Add more product items here -->
    </div>
    <!-- More products can be added here -->
  </main>

  <footer>
    <p>&copy; 2024 Simple E-Commerce. All rights reserved.</p>
  </footer>

  <?php 
$sql = "SELECT p.productName, p.productImage, p.productDescription, p.productPrice
  FROM product p";
$result = $conn->query($sql);
  $products = [];
  if ($result->num_rows > 0) {
      while($row = $result->fetch_assoc()) {
          $products[] = [
              'productName' => $row['productName'],
              'productImage' => $row['productImage'],
              'productDescription' => $row['productDescription'],
              'productPrice' => $row['productPrice']
          ];
      }
  }
  
  $json_data = json_encode($products, JSON_PRETTY_PRINT);
  file_put_contents('products.json', $json_data);
  
  ?>

  <script>
    fetch('products.json')
      .then(response => response.json())
      .then(data => {
        for(let i = 0; i<data.length; i++){
          console.log(data[i]);
        }
      })
      .catch(error => {
        console.error('Error fetching product data:', error);
      });
  </script>

</body>
</html>
