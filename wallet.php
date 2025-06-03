<?php
require_once 'db.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
$user_id = $_SESSION['user_id'];
$wallet_query = "SELECT balance FROM wallets WHERE user_id=$user_id";
$wallet = mysqli_fetch_assoc(mysqli_query($conn, $wallet_query));

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $amount = floatval($_POST['amount']);
    $type = $_POST['type'];
    $pin = $_POST['pin'];
    $user_query = "SELECT pin FROM users WHERE id=$user_id";
    $user = mysqli_fetch_assoc(mysqli_query($conn, $user_query));

    if (password_verify($pin, $user['pin'])) {
        if ($type === 'deposit') {
            mysqli_query($conn, "UPDATE wallets SET balance = balance + $amount WHERE user_id=$user_id");
            mysqli_query($conn, "INSERT INTO transactions (sender_id, amount, type, status) VALUES ($user_id, $amount, 'deposit', 'completed')");
            echo "<script>alert('Deposit successful'); window.location.href='wallet.php';</script>";
        } elseif ($type === 'withdraw' && $wallet['balance'] >= $amount) {
            mysqli_query($conn, "UPDATE wallets SET balance = balance - $amount WHERE user_id=$user_id");
            mysqli_query($conn, "INSERT INTO transactions (sender_id, amount, type, status) VALUES ($user_id, $amount, 'withdrawal', 'completed')");
            echo "<script>alert('Withdrawal successful'); window.location.href='wallet.php';</script>";
        } else {
            echo "<script>alert('Insufficient balance');</script>";
        }
    } else {
        echo "<script>alert('Invalid PIN');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wallet - Easypaisa Clone</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #00aaff, #00ff88);
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .container h2 {
            text-align: center;
            color: #00aaff;
        }
        .balance {
            text-align: center;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input, .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .btn {
            width: 100%;
            padding: 10px;
            background: #00aaff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn:hover {
            background: #0088cc;
        }
        .back {
            text-align: center;
            margin-top: 20px;
        }
        .back a {
            color: #00aaff;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Manage Wallet</h2>
        <div class="balance">
            <h3>Current Balance: PKR <?php echo number_format($wallet['balance'], 2); ?></h3>
        </div>
        <form method="POST">
            <div class="form-group">
                <label>Amount</label>
                <input type="number" step="0.01" name="amount" required>
            </div>
            <div class="form-group">
                <label>Transaction Type</label>
                <select name="type" required>
                    <option value="deposit">Deposit</option>
                    <option value="withdraw">Withdraw</option>
                </select>
            </div>
            <div class="form-group">
                <label>PIN</label>
                <input type="password" name="pin" maxlength="4" required>
            </div>
            <button type="submit" class="btn">Submit</button>
        </form>
        <div class="back">
            <a href="#" onclick="navigate('dashboard.php')">Back to Dashboard</a>
        </div>
    </div>
    <script>
        function navigate(page) {
            window.location.href = page;
        }
    </script>
</body>
</html>
