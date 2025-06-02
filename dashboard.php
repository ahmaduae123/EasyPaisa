<?php
require_once 'db.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
$user_id = $_SESSION['user_id'];
$wallet_query = "SELECT balance FROM wallets WHERE user_id=$user_id";
$wallet = mysqli_fetch_assoc(mysqli_query($conn, $wallet_query));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Easypaisa Clone</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #00aaff, #00ff88);
            margin: 0;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            text-align: center;
            padding: 20px;
            color: #fff;
        }
        .header h1 {
            font-size: 2.5em;
        }
        .balance {
            background: #fff;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            margin-bottom: 20px;
        }
        .balance h2 {
            color: #00aaff;
        }
        .menu {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
        }
        .menu-item {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 22%;
            padding: 20px;
            text-align: center;
            margin: 10px;
            transition: transform 0.3s;
        }
        .menu-item:hover {
            transform: scale(1.05);
        }
        .menu-item a {
            color: #00aaff;
            text-decoration: none;
            font-size: 1.2em;
        }
        .logout {
            text-align: center;
            margin-top: 20px;
        }
        .logout a {
            color: #fff;
            text-decoration: none;
            padding: 10px 20px;
            background: #ff4444;
            border-radius: 5px;
        }
        .logout a:hover {
            background: #cc0000;
        }
        @media (max-width: 768px) {
            .menu-item {
                width: 100%;
                margin: 10px 0;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Dashboard</h1>
        </div>
        <div class="balance">
            <h2>Wallet Balance: PKR <?php echo number_format($wallet['balance'], 2); ?></h2>
        </div>
        <div class="menu">
            <div class="menu-item"><a href="#" onclick="navigate('wallet.php')">Manage Wallet</a></div>
            <div class="menu-item"><a href="#" onclick="navigate('transfer.php')">Money Transfer</a></div>
            <div class="menu-item"><a href="#" onclick="navigate('bill_payment.php')">Bill Payment</a></div>
            <div class="menu-item"><a href="#" onclick="navigate('history.php')">Transaction History</a></div>
        </div>
        <div class="logout">
            <a href="#" onclick="navigate('logout.php')">Logout</a>
        </div>
    </div>
    <script>
        function navigate(page) {
            window.location.href = page;
        }
    </script>
</body>
</html>
