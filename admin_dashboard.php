<?php
// Include database connection
include 'dbconnection.php';

// Fetch data from the database to display in the admin dashboard
$sql = "SELECT * FROM products"; // Query to get all products
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table border='1'>
            <tr>
                <th>ID</th>
                <th>Product Name</th>
                <th>Price</th>
                <th>Image</th>
                <th>Added On</th>
            </tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row['id'] . "</td>
                <td>" . $row['Product_name'] . "</td>
                <td>" . $row['Product_price'] . "</td>
                <td><img src='uploads/" . $row['Product_image'] . "' width='50'></td>
                
              </tr>";
    }
    echo "</table>";
} else {
    echo "No products found.";
}

//// Handle form submission for adding a product
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['product_image'])) {
    $productName = trim($_POST['product_name']);
    $productPrice = floatval($_POST['product_price']);
    $productImage = $_FILES['product_image'];

    // Validate inputs
    if (empty($productName)) {
        $errorMessage = "Product name cannot be empty.";
    } elseif ($productPrice <= 0) {
        $errorMessage = "Product price must be a positive number.";
    } else {
        // Handle image upload
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
        $imageName = time() . '_' . basename($productImage['name']);
        $targetDir = 'uploads/';
        $targetFile = $targetDir . $imageName;
        $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        if (!in_array($fileType, $allowed_types)) {
            $errorMessage = "Only JPG, JPEG, PNG, and GIF files are allowed.";
        } elseif ($productImage['size'] > 2 * 1024 * 1024) {
            $errorMessage = "File size exceeds the 2MB limit.";
        } else {
            // Upload file and save product to the database
            if (move_uploaded_file($productImage['tmp_name'], $targetFile)) {
                $stmt = $conn->prepare("INSERT INTO products (name, price, image) VALUES (?, ?, ?)");
                $stmt->bind_param("sss", $productName, $productPrice, $imageName);

                if ($stmt->execute()) {
                    $successMessage = "Product added successfully!";
                } else {
                    $errorMessage = "Database error: " . $stmt->error;
                }
                $stmt->close();
            } else {
                $errorMessage = "Failed to upload the image.";
            }
        }
    }
}
//NEW
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];

    // Handle image upload
    $targetDir = "uploads/";
    $imageName = basename($_FILES["image"]["name"]);
    $targetFilePath = $targetDir . $imageName;
    move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath);

    // Insert product into the database
    $stmt = $mysqli->prepare("INSERT INTO products (name, price, image) VALUES (?, ?, ?)");
    $stmt->bind_param("sds", $name, $price, $imageName);
    $stmt->execute();
    $stmt->close();

    header("Location: products.php");
    exit();
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Basic Reset */
        * {
            margin: 0;
            padding: 0;
           
        }

        body {
            font-family: Arial, sans-serif;
            transition: margin-left 0.3s ease; /* Smooth transition for main content */
            background-color: #B4B7FA;
            
        }

        /* Topbar Styling */
        .topbar {
            position: fixed;
            top: 0;
            width: 100%;
            height: 60px;
            background-color: #333;
            color: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
            z-index: 1000;
           
        }


        .topbar h1 {
            font-size: 20px;
            margin-left: 50px;
        }

        .toggle-btn {
            background: none;
            border: none;
            cursor: pointer;
            padding: 10px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: center;
            width: 50px; /* Width of the button */
            height: 40px; /* Height of the button */
        }

        .bar {
            display: fixed;
            width: 100%;
            height: 4px;
            background-color: white;
            transition: 0.3s; /* Smooth transition effect for the bars */
            
        }
        

        /* Sidebar Styling */
        .sidebar {
            width: 200px;
            height: 100cm;
            background-color: #2196f3;
            padding-top: 50px; /* To align below topbar */
            position: fixed;
            left: -200px; /* Initially hidden */
            transition: left 0.3s ease;
            border-radius:20px;
           

        }

        .sidebar.open {
            left: 10px; /* Sidebar is visible */
        }

        .sidebar a {
            display: block;
            color: white;
            padding: 10px;
            text-decoration: none;
            font-size: 16px;
        }

        .sidebar a:hover {
            background-color:#B4C5FA;
        }

        /* Main Content Styling */
        .main {
            /* margin-left: 0; /*Adjust for sidebar visibility */
            padding: 80px 20px 20px 20px;
            width: 100%; */
            transition: margin-left 0.3s ease; /*Smooth transition for main content */
           

            
        }

    
        .form-container {
            max-width: 500px;
            margin: 50px auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        
    </style>

    
</head>
<body>

    <!-- Topbar -->
    <div class="topbar">
        <button class="toggle-btn" onclick="toggleSidebar()">
            <span class="bar"></span>
            <span class="bar"></span>
            <span class="bar"></span>
        </button>
      
       
        <h1>Admin Page</h1>
    </div>


    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <a href="#">Home</a>
        <a href="dashboard.php">Dashboard</a>
        <a href="add_product.php">Manage Products</a>
        <a href="order.php">Track Your Orders</a>
        <a href="#">Settings</a>
        <a href="login.php">Logout</a>
    </div>

   

    <!-- Main Content -->
    <div class="container">
        <div class="form-container">
            <h3 class="text-center mb-4">Add New Product</h3>
            <form action="" method="POST" enctype="multipart/form-data" id="addProductForm">
                <!-- Product Name -->
                <div class="mb-3">
                    <label for="productName" class="form-label">Product Name</label>
                    <input type="text" class="form-control" id="productName" placeholder="Enter product name" required>
                </div>
                <!-- Product Price -->
                <div class="mb-3">
                    <label for="productPrice" class="form-label">Product Price</label>
                    <input type="number" class="form-control" id="productPrice" placeholder="Enter product price" required>
                </div>
                <!-- Product Image -->
                <div class="mb-3">
                    <label for="productImage" class="form-label">Product Image</label>
                    <input type="file" class="form-control" id="productImage" accept="image/*" required>
                </div>
                <!-- Add Product Button -->
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Add Product</button>
                </div>
            </form>
        </div>
    </div>

    <!-- JavaScript to Toggle Sidebar -->
    <script>
        function toggleSidebar() {
            var sidebar = document.getElementById("sidebar");
            sidebar.classList.toggle("open");

            // Adjust the main content margin when sidebar is toggled
            var main = document.querySelector(".main");
            if (sidebar.classList.contains("open")) {
                main.style.marginLeft = "200px"; // Move content to the right when sidebar is open
            } else {
                main.style.marginLeft = "0"; // Move content back to the left when sidebar is closed
            }
        }
        
//         document.querySelectorAll("form button[name='delete_product']").forEach((btn) => {
//     btn.addEventListener("click", function (e) {
//         if (!confirm("Are you sure you want to delete this product?")) {
//             e.preventDefault(); // Stop form submission
//         }
//     });
// });
document.querySelectorAll("form button[name='delete_product']").forEach((btn) => {
    btn.addEventListener("click", function (e) {
        if (!confirm("Are you sure you want to delete this product?")) {
            e.preventDefault(); // Stop form submission
        }
    });
});

    </script>

</body>
</html>
<?php $conn->close(); 
 ?>