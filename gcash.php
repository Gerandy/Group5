
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
        background-color: rgb(0, 114, 190);
        border-radius: 20px;
        box-shadow: 0 0 20px rgba(0,0,0,0.1);
        width: 100%;
        max-width: 800px;
        min-width: 350px;
        padding: 10px 30px 30px 30px; 
        color: #fff;
        position: relative;
        box-sizing: border-box;
    }
    .gcash-logo {
        display: block;
        margin: 0 auto 10px auto; 
        width: 100%;
        max-width: 300px; 
        height: auto;
    }
    .gcash-details {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 10px; 
    }
    .gcash-info {
        flex: 2 1 300px;
        min-width: 200px;
        margin-left: 60px;             
    }
    .gcash-info h2 {
        margin: 0 0 10px 0;
        word-break: break-all;
        font-size: 2.5rem;
        letter-spacing: 1px;
        font-weight: bold;
    }
    .gcash-info p {
        margin: 0;
        font-size: 1.5rem;
        font-weight: 500;
    }
    .gcash-qr {
        margin-left: 20px; 
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .gcash-qr img {
        width: 320px;   
        height: 320px;
        max-width: 40vw;
        border-radius: 10px;
        background: #fff;
        padding: 10px;
        display: block;
        
    }
    .gcash-actions {
        display: flex;
        justify-content: space-between;
        margin-top: 40px;
        gap: 20px;
    }
    .gcash-actions button {
        width: 48%;
        border-radius: 10px;
        font-weight: bold;
        font-size: 1.2rem;
        padding: 12px 0;
    }
    .cancel-btn {
        background: #fff;
        color: #0077c5;
        border: none;
    }
    .confirm-btn {
        background: #fff;
        color: #0077c5;
        border: none;
    }
    @media (max-width: 900px) {
        .gcash-container {
            max-width: 98vw;
            padding: 15px 5px;
        }
        .gcash-details {
            flex-direction: column;
            align-items: center;
            gap: 10px;
        }
        .gcash-qr {
            margin-left: 0;
            margin-top: 10px;
            width: 100%;
        }
        .gcash-qr img {
            width: 100%;
            max-width: 90vw;
            height: auto;
        }
        .gcash-info h2 {
            font-size: 2rem;
        }
        .gcash-info p {
            font-size: 1.2rem;
        }
    }
</style>
</head>
<body>
    <div class="gcash-container">
        <img src="assets/gcashlogo.png" alt="GCash Logo" class="gcash-logo">
        <div class="gcash-details">
            <div class="gcash-info">
                <h2>TechEase</h>
                <p>09959470501</p>
            </div>
            <div class="gcash-qr">
                <img src="assets/qrgcash.png" alt="GCash QR">
            </div>
        </div>
        <div class="gcash-actions">
            <button class="cancel-btn" onclick="window.history.back()">Cancel</button>
            <button class="confirm-btn" onclick="alert('Payment Confirmed!')">Confirm</button>
        </div>
    </div>
</body>
</html>