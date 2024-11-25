<?php

include 'dbconnection.php';
// Database connection
$conn = new mysqli('localhost', 'root', '', 'login_register');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
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
        #h{
    padding-top:60px;
}
        /* Sidebar and Topbar styling remains same as earlier */
        body { background-color: #B4B7FA; }
        #search-bar { margin-bottom: 20px; }
    </style>
</head>
<body>
    <!-- NAV -->
    <div class="topbar">
        <button class="toggle-btn" onclick="toggleSidebar()">
            <span class="bar"></span>
            <span class="bar"></span>
            <span class="bar"></span>
        </button>
        <h1>Product Management</h1>
    </div>

    <div class="sidebar" id="sidebar">
        <a href="#">Home</a>
        <a href="#">Dashboard</a>
        <a href="#">Manage Products</a>
        <a href="#">Orders</a>
        <a href="#">Settings</a>
        <a href="#">Logout</a>
    </div>

    <!-- Main Content -->
    <div class="container mt-5">
        <h1 id="h">Product Dashboard</h1>
        
        <!-- Search and Sort -->
        <div id="search-bar" class="d-flex justify-content-between">
            <form action="" method="GET" class="d-flex">
                <input type="text" name="search" class="form-control me-2" placeholder="Search products..." value="<?= htmlspecialchars($search_query) ?>">
                <button type="submit" class="btn btn-primary">Search</button>
            </form>
            <form action="" method="GET">
                <select name="sort" class="form-select" onchange="this.form.submit()">
                    <option value="name" <?= $sort_option === 'name' ? 'selected' : '' ?>>Sort by Name</option>
                    <option value="price" <?= $sort_option === 'price' ? 'selected' : '' ?>>Sort by Price</option>
                </select>
            </form>
        </div>

        <!-- Product Table -->
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
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td>$<?= number_format($row['price'], 2) ?></td>
                    <td><img src="uploads/<?= htmlspecialchars($row['image']) ?>" alt="<?= htmlspecialchars($row['name']) ?>" width="100"></td>
                    <td>
                        <a href="edit_product.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="products_dashboard.php?delete=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <!-- Pagination -->
        <nav>
            <ul class="pagination">
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <li class="page-item <?= $page === $i ? 'active' : '' ?>">
                        <a class="page-link" href="?page=<?= $i ?>&search=<?= $search_query ?>&sort=<?= $sort_option ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('open');
        }
    </script>
</body>
</html>

<?php
$conn->close();
?>