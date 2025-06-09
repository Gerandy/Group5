
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
            background-color:rgb(0, 80, 230);
            border-radius: 20px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            width: 1000px;
            padding: 20px;
            color: #fff;
            position: relative;
        }
        .gcash-logo {
            display: block;
            margin: 0 auto 20px auto;
            width: 300px;
        }
        .gcash-details {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .gcash-info {
            flex: 1;
            margin-left: 90px;
        } 
        .gcash-info h4, .maya-info p {
            margin: 0;
        }
        .gcash-qr {
            margin-left: 20px;
        }
        .gcash-qr img {
            width: 350px;
            height: 400px;
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
            height: 30px;
        }
        .confirm-btn {
            background: #fff;
            color: #0077c5;
            border: none;
            height: 30px;
        }
    </style>
</head>
<body>
    <div class="gcash-container">
        <img src="assets/gcashlogo.png" alt="Gcash logo" class="gcash-logo">
        <div class="gcash-details">
            <div class="gcash-info">
                <h1 style="font-size: 80px;">TechEase</h1>
                <p style="font-size: 40px;">09959470501</p>
            </div>
            <div class="gcash-qr">
                <img src="assets/qrgcash.png" alt="Gcash QR">
            </div>
        </div>
        <div class="gcash-actions">
            <button class="cancel-btn" onclick="window.history.back()">Cancel</button>
            <button class="confirm-btn" onclick="alert('Payment Confirmed!')">Confirm</button>
        </div>
    </div>
</body>
</html>