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
    <title>Order Status</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
            margin-right:30px;
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
        
        /*  */
        /* body {
  background-color: #f8f9fa;
  font-family: Arial, sans-serif;
} */

.OD{
    padding-top:70px;
    
}


.tracking-bar .progress {
  height: 15px;
  border-radius: 5px;
  margin-top:50px;
}

.tracking-bar .steps {
  font-size: 14px;
  color: #6c757d;
}

.step {
  text-align: center;
  flex-grow: 1;
}

.card {
  border-radius: 10px;
  margin-top:30px;
}

.card-title {
  color: #0d6efd;
  font-weight: bold;
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
      
       
        <h1 id="h">Order Status</h1>
    </div>
    <div class="container mt-5">
    <!-- Order Tracking Header -->
    <div class="OD">
        <h1 class="text-center mb-4" id="h">Order Detail</h1>
</div>
    <!-- Order Tracking Progress Bar -->
    <div class="tracking-bar mb-4">
      <div class="progress">
        <div class="progress-bar bg-primary" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
      </div>
      <div class="steps d-flex justify-content-between mt-2">
        <span class="step">Processing</span>
        <span class="step">Picking</span>
        <span class="step">Shipping</span>
        <span class="step">Delivered</span>
      </div>
    </div>

    <!-- Order Details -->
    <div class="card shadow-sm mb-3">
      <div class="card-body">
        <h5 class="card-title">Order: 452135A</h5>
        <p><strong>Delivery Estimate:</strong> December 3, 2021</p>
        <p><strong>Address:</strong><br>
          Glenn Gonzalez Jr.<br>
          6844 Hall Spring Suite 665<br>
          East Annabury, OK 42291</p>
        <p><strong>Payment Method:</strong> Credit Card **1234</p>
      </div>
    </div>

    <!-- Items in Order -->
    <div class="card shadow-sm mb-3">
      <div class="card-body">
        <h5 class="card-title">Order Items</h5>
        <div class="d-flex align-items-center mb-2">
          <img src="https://via.placeholder.com/50" alt="Item Image" class="me-3">
          <div>
            <p class="mb-0">iPhone 13, 128GB, Pink - Unlocked (Premium)</p>
            <small>$500</small>
          </div>
        </div>
        <div class="d-flex align-items-center">
          <img src="https://via.placeholder.com/50" alt="Item Image" class="me-3">
          <div>
            <p class="mb-0">iPhone 13, 128GB, Blue - Unlocked (Premium)</p>
            <small>$500</small>
          </div>
        </div>
        
      </div>
    </div>

    <!-- Actions -->
    <div class="d-flex justify-content-between">
      <button class="btn btn-outline-primary">Contact Us</button>
      <button class="btn btn-outline-danger">Cancel This Order</button>
    </div>
  </div>



  <script src="script.js">
    // Simulate progress bar update dynamically
const progressBar = document.querySelector(".progress-bar");
const steps = document.querySelectorAll(".step");

let progress = 50; // Progress percentage
progressBar.style.width = `${progress}%`;

steps.forEach((step, index) => {
  if ((index + 1) * 25 <= progress) {
    step.style.color = "#0d6efd"; // Highlight completed steps
    step.style.fontWeight = "bold";
  }
});

  </script>


</body>
</html>

<?php
$conn->close();
?>