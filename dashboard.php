<?php
// Include database connection
include 'dbconnection.php';

// // Fetching the data for dashboard metrics
// $orderCountQuery = "SELECT COUNT(*) AS total_orders FROM orders";
// $orderDeliveredQuery = "SELECT COUNT(*) AS delivered_orders FROM orders WHERE status = 'Delivered'";
// $customerCountQuery = "SELECT COUNT(*) AS total_customers FROM customers";
// $lowStockQuery = "SELECT COUNT(*) AS low_stock_items FROM products WHERE stock_quantity < 10";
// $highStockQuery = "SELECT COUNT(*) AS high_stock_items FROM products WHERE stock_quantity >= 100";

// // Execute queries
// $orderCount = $conn->query($orderCountQuery)->fetch_assoc();
// $orderDelivered = $conn->query($orderDeliveredQuery)->fetch_assoc();
// $customerCount = $conn->query($customerCountQuery)->fetch_assoc();
// $lowStock = $conn->query($lowStockQuery)->fetch_assoc();
// $highStock = $conn->query($highStockQuery)->fetch_assoc();

// // Handle date filtering for orders
// $filterQuery = "";
// if (isset($_POST['filter_type'])) {
//     $filterType = $_POST['filter_type'];

//     if ($filterType == 'date') {
//         $filterQuery = "AND order_date = CURDATE()";
//     } elseif ($filterType == 'week') {
//         $filterQuery = "AND YEARWEEK(order_date, 1) = YEARWEEK(CURDATE(), 1)";
//     } elseif ($filterType == 'month') {
//         $filterQuery = "AND MONTH(order_date) = MONTH(CURDATE())";
//     }
// }

// $orderFilterQuery = "SELECT * FROM orders WHERE 1=1 $filterQuery";
// $filteredOrders = $conn->query($orderFilterQuery);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <style>
        /* NAV */
        
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
            background-color: #2196f3cc;
            padding-top: 50px; /* To align below topbar */
            position: fixed;
            left: -200px; /* Initially hidden */
            transition: left 0.3s ease;
            border-radius:20px;
           

        }

        .sidebar.open {
            left: 10px;  Sidebar is visible
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
            margin-left: 0; /*Adjust for sidebar visibility */
            padding: 80px 20px 20px 20px;
            width: 100%;
            transition: margin-left 0.3s ease; /*Smooth transition for main content */
            
        }
        /* DASHBOARD */
        .dashboard-card {
            height: 200px;
            width: 300px;
            border-radius: 15px;
            padding: 20px;
            background-color: #f8f9fa;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin:50px;
            

           
        }
        .dashboard-card h4 {
            font-size: 18px;
            font-weight: bold;
            text-align: center;
        }
        .dashboard-card .value {
            font-size: 40px;
            color: #007bff;
        }
        .filter-form {
            margin-bottom: 16px;
            margin-top: 40px ;
        }
       
    </style>
</head>
<body>

<!-- NAV -->
<!-- Topbar -->
<div class="topbar">
        <button class="toggle-btn" onclick="toggleSidebar()">
            <span class="bar"></span>
            <span class="bar"></span>
            <span class="bar"></span>
        </button>

        <h1>Admin Dashboard</h1>
    </div>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <a href="">Home</a>
        <a href="#">Dashboard</a>
        <a href="#">Manage Products</a>
        <a href="#">Orders</a>
        <a href="#">Settings</a>
        <a href="">Logout</a>
    </div>
<!-- dashboars -->
 
<div class="container-fluid">
    <div class="row mt-4">
        <!-- Dashboard Header -->
        <div class="col-12 text-center">
            <h2>Admin Dashboard</h2>
        </div>
    </div>
         <!-- Filter Form -->
         <div class="col-md-12 filter-form">
            <form method="POST">
                <label for="filter_type" class="mr-2">Filter Orders by:</label>
                <select name="filter_type" id="filter_type" class="form-control d-inline" style="width: 200px;">
                    <option value="date">Today</option>
                    <option value="week">This Week</option>
                    <option value="month">This Month</option>
                </select>
                <button type="submit" class="btn ">Apply Filter</button>
            </form>
        </div>
    </div>

    <div class="row mt-4">
    <div class="row mt-4">
        <!-- Cards for Metrics -->
       
        <div class="col-md-3" id="ordersContainer">
            <div class="dashboard-card">
                <h4>Total Orders</h4>
                <!-- <p class="value"><?php echo $orderCount['total_orders']; ?></p> -->
            </div>
        </div>
        <div class="col-md-3">
            <div class="dashboard-card">
                <h4>Total Pending Orders</h4>
                <!-- <p class="value"><?php echo $orderDelivered['delivered_orders']; ?></p> -->
            </div>
        </div>
        <div class="col-md-3">
            <div class="dashboard-card">
                <h4>Total Dispatched</h4>
                <!-- <p class="value"><?php echo $customerCount['total_customers']; ?></p> -->
            </div>
        </div>
        <div class="col-md-3">
            <div class="dashboard-card">
                <h4>Total Dispatched</h4>
                <!-- <p class="value"><?php echo $customerCount['total_customers']; ?></p> -->
            </div>
        </div>
    </div>

    <div class="container mt-5">
        <h1 id=h>Product Dashboard</h1>
        <!-- <a href="index.php" class="btn btn-success mb-3">Add New Product</a> -->
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['name'] ?></td>
                    <td><?= $row['price'] ?></td>
                    <td><img src="uploads/<?= $row['image'] ?>" alt="<?= $row['name'] ?>" width="100"></td>
                    <td>
                        <a href="products.php?delete=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    // You can use JavaScript and Chart.js to add graphical representations
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

// Example JavaScript for checking empty orders
function checkOrders(orders) {
    const ordersContainer = document.getElementById('ordersContainer');
    
    // Check if orders array is empty
    if (!orders || orders.length === 0) {
        ordersContainer.innerHTML = "<p>No records</p>";
    } else {
        // Display orders (assuming orders are a list)
        ordersContainer.innerHTML = orders.map(order => `<p>${order}</p>`).join('');
    }
}

// Example usage:
const orders = []; // Replace this with your orders array
checkOrders(orders);

</script>

</body>
</html>

<?php
$conn->close();
?>
