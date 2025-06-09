
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
        .maya-container {
            background-color:rgb(47, 242, 158);
            border-radius: 20px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            width: 1000px;
            padding: 20px;
            color: #fff;
            position: relative;
        }
        .maya-logo {
            display: block;
            margin: 0 auto 20px auto;
            width: 300px;
        }
        .maya-details {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .maya-info {
            flex: 1;
            margin-left: 90px;
        } 
        .maya-info h4, .maya-info p {
            margin: 0;
        }
        .maya-qr {
            margin-left: 20px;
        }
        .maya-qr img {
            width: 350px;
            height: 400px;
            border-radius: 10px;
            background: #fff;
            padding: 5px;
        }
        .maya-actions {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
        }
        .maya-actions button {
            width: 48%;
            border-radius: 10px;
            font-weight: bold;
        }
        .cancel-btn {
            background: #fff;
            color:rgb(47, 242, 158);
            border: none;
            height: 30px;
        }
        .confirm-btn {
            background: #fff;
            color: rgb(47, 242, 158);
            border: none;
            height: 30px;
        }
    </style>
</head>
<body>
    <div class="maya-container">
        <img src="assets/mayalogo.png" alt="Maya logo" class="maya-logo">
        <div class="maya-details">
            <div class="maya-info">
                <h1 style="font-size: 80px;">TechEase</h1>
                <p style="font-size: 40px;">09927274046</p>
            </div>
            <div class="maya-qr">
                <img src="assets/qrmaya.png" alt="Maya QR">
            </div>
        </div>
        <div class="maya-actions">
            <button class="cancel-btn" onclick="window.history.back()">Cancel</button>
            <button class="confirm-btn" onclick="alert('Payment Confirmed!')">Confirm</button>
        </div>
    </div>
</body>
</html>