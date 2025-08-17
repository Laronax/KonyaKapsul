<?php
session_start();
require_once 'config.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

$search_results = [];
$search_query = '';
$error_message = '';

// Handle search form submission
if ($_POST && isset($_POST['search'])) {
    $search_query = trim($_POST['search']);
    
    if (!empty($search_query)) {
        // VULNERABLE: Direct string concatenation - SQL Injection possible
        $sql = "SELECT * FROM products WHERE name LIKE '%$search_query%' OR description LIKE '%$search_query%' OR category LIKE '%$search_query%'";
        $result = $conn->query($sql);
        
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $search_results[] = $row;
            }
        } else {
            $error_message = "Error executing search query";
        }
    }
}

// Get all products for initial display
$all_products_sql = "SELECT * FROM products ORDER BY name";
$all_result = $conn->query($all_products_sql);
$all_products = [];
if ($all_result) {
    while ($row = $all_result->fetch_assoc()) {
        $all_products[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SQLi Demo - Search</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
        .search-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            padding: 30px;
            margin-top: 20px;
        }
        .header {
            background: white;
            border-radius: 15px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            padding: 20px;
            margin-top: 20px;
        }
        .product-card {
            border: 1px solid #e9ecef;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            transition: transform 0.2s;
        }
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }
        .price {
            font-size: 1.2em;
            font-weight: bold;
            color: #28a745;
        }
        .category-badge {
            background: #667eea;
            color: white;
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 0.8em;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h2>🔍 Product Search</h2>
                    <p class="text-muted">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</p>
                </div>
                <div class="col-md-6 text-end">
                    <a href="index.php" class="btn btn-outline-primary me-2">Back to Login</a>
                    <a href="index.php?logout=1" class="btn btn-danger">Logout</a>
                </div>
            </div>
        </div>

        <!-- Search Form -->
        <div class="search-container">
            <form method="POST" action="">
                <div class="row">
                    <div class="col-md-8">
                        <input type="text" class="form-control form-control-lg" name="search" 
                               placeholder="Search products by name, description, or category..." 
                               value="<?php echo htmlspecialchars($search_query); ?>">
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary btn-lg w-100">Search</button>
                    </div>
                </div>
            </form>
            
            <?php if ($error_message): ?>
                <div class="alert alert-danger mt-3"><?php echo htmlspecialchars($error_message); ?></div>
            <?php endif; ?>
        </div>

        <!-- Search Results -->
        <?php if (!empty($search_results)): ?>
            <div class="search-container">
                <h4>Search Results for: "<?php echo htmlspecialchars($search_query); ?>"</h4>
                <p class="text-muted">Found <?php echo count($search_results); ?> product(s)</p>
                
                <div class="row">
                    <?php foreach ($search_results as $product): ?>
                        <div class="col-md-6 col-lg-4">
                            <div class="product-card">
                                <h5><?php echo htmlspecialchars($product['name']); ?></h5>
                                <p class="text-muted"><?php echo htmlspecialchars($product['description']); ?></p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="price">$<?php echo number_format($product['price'], 2); ?></span>
                                    <span class="category-badge"><?php echo htmlspecialchars($product['category']); ?></span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php elseif (!empty($search_query)): ?>
            <div class="search-container">
                <div class="alert alert-info">
                    No products found for "<?php echo htmlspecialchars($search_query); ?>"
                </div>
            </div>
        <?php endif; ?>

        <!-- All Products (Initial Display) -->
        <?php if (empty($search_query)): ?>
            <div class="search-container">
                <h4>All Products</h4>
                <p class="text-muted">Showing all available products</p>
                
                <div class="row">
                    <?php foreach ($all_products as $product): ?>
                        <div class="col-md-6 col-lg-4">
                            <div class="product-card">
                                <h5><?php echo htmlspecialchars($product['name']); ?></h5>
                                <p class="text-muted"><?php echo htmlspecialchars($product['description']); ?></p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="price">$<?php echo number_format($product['price'], 2); ?></span>
                                    <span class="category-badge"><?php echo htmlspecialchars($product['category']); ?></span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- SQL Injection Examples -->
        <div class="search-container">
            <h5>🔓 SQL Injection Examples:</h5>
            <div class="row">
                <div class="col-md-6">
                    <h6>Union-based SQLi:</h6>
                    <code>' UNION SELECT 1,2,3,4,5 --</code><br>
                    <code>' UNION SELECT username,password,email,4,5 FROM users --</code>
                </div>
                <div class="col-md-6">
                    <h6>Boolean-based SQLi:</h6>
                    <code>' OR '1'='1</code><br>
                    <code>' AND 1=1 --</code><br>
                    <code>' AND 1=2 --</code>
                </div>
            </div>
            <div class="mt-3">
                <h6>Error-based SQLi:</h6>
                <code>' AND (SELECT 1 FROM (SELECT COUNT(*),CONCAT(0x7e,(SELECT version()),0x7e,FLOOR(RAND(0)*2))x FROM information_schema.tables GROUP BY x)a) --</code>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
