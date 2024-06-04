<?php
// Database connection parameters
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

session_start();
$userId = $_SESSION['id'];

// Get search and sort parameters from the form
$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
$sort = isset($_GET['sort']) ? $_GET['sort'] : '';

// Base SQL query
$sql = "SELECT p.productName, p.productDescription, p.productPrice, p.productImage
        FROM product p
        JOIN users u ON p.userId = u.id
        WHERE u.id = $userId";

// Add search condition
if (!empty($search)) {
    $sql .= " AND (p.productName LIKE '%$search%' OR p.productDescription LIKE '%$search%')";
}

// Add sorting condition
switch ($sort) {
    case 'name_asc':
        $sql .= " ORDER BY p.productName ASC";
        break;
    case 'name_desc':
        $sql .= " ORDER BY p.productName DESC";
        break;
    case 'price_asc':
        $sql .= " ORDER BY p.productPrice ASC";
        break;
    case 'price_desc':
        $sql .= " ORDER BY p.productPrice DESC";
        break;
    default:
        $sql .= " ORDER BY p.productName ASC"; // Default sorting
        break;
}

$result = $conn->query($sql);
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List</title>
    <link rel="stylesheet" href="product_styles.css">
</head>
<body>
    <?php include 'border.php'; ?>
    <div class="container">
        <h1>Product List</h1>
        <form method="GET" action="">
            <input type="text" name="search" placeholder="Search products..." value="<?php echo htmlspecialchars($search); ?>">
            <select name="sort">
                <option value="name_asc" <?php if ($sort == 'name_asc') echo 'selected'; ?>>Sort by name (A-Z)</option>
                <option value="name_desc" <?php if ($sort == 'name_desc') echo 'selected'; ?>>Sort by name (Z-A)</option>
                <option value="price_asc" <?php if ($sort == 'price_asc') echo 'selected'; ?>>Sort by price (Low to High)</option>
                <option value="price_desc" <?php if ($sort == 'price_desc') echo 'selected'; ?>>Sort by price (High to Low)</option>
            </select>
            <button type="submit">Search and Sort</button>
        </form>

        <?php
        if ($result->num_rows > 0) {
            // Output data of each row
            while($row = $result->fetch_assoc()) {
                echo '<div class="product">';
                echo '<img class="product-image" src="images/' . htmlspecialchars($row["productImage"]) . '" alt="' . htmlspecialchars($row["productName"]) . '">';

                // Product details container
                echo '<div class="product-details">';
                echo '<h2 class="product-title">' . htmlspecialchars($row["productName"]) . '</h2>';
                echo '<p class="product-description">' . htmlspecialchars($row["productDescription"]) . '</p>';
                echo '<span class="product-price">$' . htmlspecialchars($row["productPrice"]) . '</span>';
                echo '</div>'; // Close product-details

                echo '</div>'; // Close product
            }
        } else {
            echo "0 results";
        }
        ?>
    </div>

    <?php
    // Close connection
    $conn->close();
    ?>
</body>
</html>