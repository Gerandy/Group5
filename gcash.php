
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/gcash.css">
    <title>GCASH PAYMENT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #e6f0fa;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .gcash-container {
            background-color:rgb(0, 114, 190);
            border-radius: 20px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            width: 400px;
            padding: 30px 30px 20px 30px;
            color: #fff;
            position: relative;
        }
        .gcash-logo {
            display: block;
            margin: 0 auto 20px auto;
            height: 180px;
            width: 350px;
        }
        .gcash-details {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .gcash-info {
            flex: 1;
        }
        .gcash-info h4, .gcash-info p {
            margin: 0;
        }
        .gcash-qr {
            margin-left: 20px;
        }
        .gcash-qr img {
            width: 90px;
            height: 90px;
            border-radius: 10px;
            background: #fff;
            padding: 5px;
        }
        .gcash-actions {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
        }
        .gcash-actions button {
            width: 48%;
            border-radius: 10px;
            font-weight: bold;
        }
        .cancel-btn {
            background: #fff;
            color: #0077c5;
            border: none;
        }
        .confirm-btn {
            background: #1C8D20;
            color: #fff;
            border: none;
        }
    </style>
</head>
<body>
    <div class="gcash-container">
        <img src="assets/gcashlogo.png" alt="GCash Logo" class="gcash-logo">
        <div class="gcash-details">
            <div class="gcash-info">
                <h2>TechEase</h>
                <h1><p>09959470501</p></h1>
            </div>
            <div class="gcash-qr">
                <img src="" alt="GCash QR">
            </div>
        </div>
        <div class="gcash-actions">
            <button class="cancel-btn" onclick="window.history.back()">Cancel</button>
            <button class="confirm-btn" onclick="alert('Payment Confirmed!')">Confirm</button>
        </div>
    </div>
</body>
</html>