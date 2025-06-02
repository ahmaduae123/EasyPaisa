<?php
require_once 'db.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
$user_id = $_SESSION['user_id'];
$providers_query = "SELECT * FROM service_providers";
$providers = mysqli_query($conn, $providers_query);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $provider_id = intval($_POST['provider_id']);
    $amount = floatval($_POST['amount']);
    $reference_number = mysqli_real_escape_string($conn, $_POST['reference_number']);
    $pin = $_POST['pin'];
    $user_query = "SELECT pin FROM users WHERE id=$user_id";
    $user = mysqli_fetch_assoc(mysqli_query($conn, $user_query));
    $wallet_query = "SELECT balance FROM wallets WHERE user_id=$user_id";
    $wallet = mysqli_fetch_assoc(mysqli_query($conn, $wallet_query));

    if (password_verify($pin, $user['pin'])) {
        if ($wallet['balance'] >= $amount) {
            mysqli_query($conn, "UPDATE wallets SET balance = balance - $amount WHERE user_id=$user_id");
            mysqli_query($conn, "INSERT INTO bill_payments (user_id, provider_id, amount, reference_number) VALUES ($user_id, $provider_id, $amount, '$reference_number')");
            mysqli_query($conn, "INSERT INTO transactions (sender_id, amount, type, status) VALUES ($user_id, $amount, 'bill_payment', 'completed')");
            echo "<script>alert('Bill payment successful'); window.location.href='dashboard.php';</script>";
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
    <title>Bill Payment - Easypaisa Clone</title>
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
        <h2>Bill Payment</h2>
        <form method="POST">
            <div class="form-group">
                <label>Service Provider</label>
                <select name="provider_id" required>
                    <?php while ($provider = mysqli_fetch_assoc($providers)) { ?>
                        <option value="<?php echo $provider['id']; ?>"><?php echo $provider['name']; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label>Amount</label>
                <input type="number" step="0.01" name="amount" required>
            </div>
            <div class="form-group">
                <label>Reference Number</label>
                <input type="text" name="reference_number" required>
            </div>
            <div class="form-group">
                <label>PIN</label>
                <input type="password" name="pin" maxlength="4" required>
            </div>
            <button type="submit" class="btn">Pay Bill</button>
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
