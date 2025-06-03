<?php
require_once 'db.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
$user_id = $_SESSION['user_id'];
$transactions_query = "SELECT t.*, u.phone as receiver_phone FROM transactions t LEFT JOIN users u ON t.receiver_id = u.id WHERE t.sender_id=$user_id ORDER BY created_at DESC";
$transactions = mysqli_query($conn, $transactions_query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction History - Easypaisa Clone</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #00aaff, #00ff88);
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 800px;
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
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: left;
        }
        th {
            background: #00aaff;
            color: #fff;
        }
        tr:nth-child(even) {
            background: #f9f9f9;
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
        <h2>Transaction History</h2>
        <table>
            <tr>
                <th>Date</th>
                <th>Type</th>
                <th>Amount</th>
                <th>Receiver</th>
                <th>Status</th>
            </tr>
            <?php while ($transaction = mysqli_fetch_assoc($transactions)) { ?>
                <tr>
                    <td><?php echo $transaction['created_at']; ?></td>
                    <td><?php echo ucfirst($transaction['type']); ?></td>
                    <td>PKR <?php echo number_format($transaction['amount'], 2); ?></td>
                    <td><?php echo $transaction['receiver_phone'] ?: '-'; ?></td>
                    <td><?php echo ucfirst($transaction['status']); ?></td>
                </tr>
            <?php } ?>
        </table>
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
