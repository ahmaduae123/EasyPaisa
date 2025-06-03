<?php
require_once 'db.php';
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Easypaisa Clone - Home</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #00aaff, #00ff88);
            color: #333;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            text-align: center;
            padding: 50px 0;
        }
        .header h1 {
            font-size: 3em;
            color: #fff;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }
        .services {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
        }
        .service-card {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 30%;
            margin: 10px;
            padding: 20px;
            text-align: center;
            transition: transform 0.3s;
        }
        .service-card:hover {
            transform: scale(1.05);
        }
        .service-card h3 {
            color: #00aaff;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background: #00aaff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 10px;
        }
        .btn:hover {
            background: #0088cc;
        }
        @media (max-width: 768px) {
            .service-card {
                width: 100%;
                margin: 10px 0;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Welcome to Easypaisa Clone</h1>
            <p>Your one-stop solution for digital payments</p>
        </div>
        <div class="services">
            <div class="service-card">
                <h3>Money Transfer</h3>
                <p>Send and receive money instantly with ease.</p>
                <a href="#" class="btn" onclick="navigate('login.php')">Get Started</a>
            </div>
            <div class="service-card">
                <h3>Bill Payments</h3>
                <p>Pay utility bills and mobile recharges effortlessly.</p>
                <a href="#" class="btn" onclick="navigate('login.php')">Pay Now</a>
            </div>
            <div class="service-card">
                <h3>Digital Wallet</h3>
                <p>Manage your funds securely in your wallet.</p>
                <a href="#" class="btn" onclick="navigate('login.php')">Explore</a>
            </div>
        </div>
    </div>
    <script>
        function navigate(page) {
            window.location.href = page;
        }
    </script>
</body>
</html>
