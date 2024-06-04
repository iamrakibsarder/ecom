
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
$sql = "SELECT u.id, u.u_name, u.email, u.u_password,  u.reg_date
            FROM users u";
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
  <!-- <header>
    <h1>Simple E-Commerce</h1>
    <nav>
      <ul>
        <li><a href="#">Home</a></li>
        <li><a href="product.php">Products</a></li>
        <li><a href="#">About</a></li>
        <li><a href="#">Contact</a></li>
      </ul>
    </nav>
  </header> -->
  <?php include 'border.php'; ?>

  <main>

  <div class="container">
        <h1>User Details</h1>
                <?php
        if ($result->num_rows > 0) {
            echo '<div class="product-wrapper">';
            // Output data of each row
        while($row = $result->fetch_assoc()) {
                if($userId == $row["id"]){
                echo '<div class="user">';
                echo '<h2 class="user-name">' . htmlspecialchars($row["u_name"]) . '</h2>';
                echo '<p class="user-email">' . htmlspecialchars($row["email"]) . '</p>';
                echo '<p class="user-reg">' . htmlspecialchars($row["reg_date"]) . '</p>';
                echo '</div>';
            }
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


  <script>
    const
  </script>
</body>
</html>
