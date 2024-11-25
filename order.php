<?php
require_once 'dbconnection.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Tracking</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/bootstrap.min.css">
    <style>


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
      
       
        <h1>Order Tracking</h1>
    </div>

    <div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card p-4 shadow-lg" style="width: 25rem;">
      <h3 class="text-center mb-4">Order Tracking</h3>
      <form id="orderForm" action="order_Status.php" method="GET">
        <div class="mb-3">
          <label for="orderID" class="form-label">Order ID</label>
          <input type="text" class="form-control" id="orderID" placeholder="Enter your Order ID" required>
        </div>
        <div class="mb-3">
          <label for="email" class="form-label">Email</label>
          <input type="email" class="form-control" id="email" placeholder="Enter your Email" required>
        </div>
        <button type="submit"  class="btn btn-primary w-100">Track Order</button>
      </form>
      <div id="statusMessage" class="mt-3"></div>
    </div>
  </div>
</body>
</html>

<?php
$conn->close();
?>
