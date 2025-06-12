<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Brand - TechEase</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Inter font for consistency -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #C0C0C0;
            min-height: 100vh;
            margin: 0;
            font-family: 'Inter', Arial, Helvetica, sans-serif;
        }
        .navbar {
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            font-family: 'Inter', Arial, Helvetica, sans-serif;
        }
        .container.mt-4 {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            min-height: 80vh;
        }
        .tab-container {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 0 20px rgba(0,0,0,0.12);
            width: 480px;
            min-height: 400px;
            padding: 40px 35px 35px 35px;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            align-items: stretch;
            font-family: 'Inter', Arial, Helvetica, sans-serif;
        }
        .form-title {
            text-align: center;
            font-size: 2rem;
            font-weight: bold;
            color: #2c6ea3;
            margin-bottom: 25px;
            letter-spacing: 1px;
        }
        .form-label {
            font-weight: 500;
            color: #2c6ea3;
            margin-bottom: 6px;
            margin-left: 2px;
        }
        .form-control {
            border-radius: 12px;
            border: 1px solid #b0b0b0;
            background-color: #f5f7fa;
            font-size: 1.1rem;
            padding: 12px;
            margin-bottom: 18px;
            transition: border-color 0.2s;
            font-family: 'Inter', Arial, Helvetica, sans-serif;
        }
        .form-control:focus {
            border-color: #2c6ea3;
            box-shadow: 0 0 0 2px #2c6ea340;
        }
        .Confirm-button {
            border-radius: 15px;
            border: none;
            background-color: #1C8D20;
            width: 60%;
            text-align: center;
            font-family: 'Inter', Arial, Helvetica, sans-serif;
            cursor: pointer;
            font-weight: bold;
            padding: 12px;
            margin: 30px auto 0 auto;
            color: #fff;
            font-size: 1.15rem;
            transition: background 0.2s;
            box-shadow: 0 2px 8px rgba(28,141,32,0.08);
        }
        .Confirm-button:disabled {
            background-color: #b0b0b0;
            cursor: not-allowed;
        }
        .brand-list {
            margin-top: 30px;
        }
        .brand-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 0;
            border-bottom: 1px solid #eee;
        }
        .brand-name {
            color: #2c6ea3;
            font-weight: 500;
            font-size: 1.05rem;
        }
        .delete-btn {
            background: #dc3545;
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 4px 12px;
            font-size: 0.95rem;
            font-family: 'Inter', Arial, Helvetica, sans-serif;
            transition: background 0.2s;
        }
        .delete-btn:hover {
            background: #b52a37;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg shadow-sm" style="background: linear-gradient(90deg, #2c6ea3 60%, #4682b4 100%); height: 70px;">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold d-flex align-items-center" style="font-size: 2rem; color: #fff;" href="index.php">
      <img src="assets/teacheaseshoplogo.png" alt="Logo" style="height:36px;margin-right:10px;">TechEase
    </a>
    <div class="ms-auto">
      <a href="product.php" class="btn btn-outline-light rounded-pill px-4 py-2 d-flex align-items-center"
         style="font-weight:600; font-size:1.1rem; box-shadow:0 2px 8px rgba(0,0,0,0.08); min-width:140px;">
        <span class="me-2" style="font-size:1.3rem;">&#8592;</span> Back
      </a>
    </div>
  </div>
</nav>
<div class="container mt-4">
    <div class="tab-container">
        <div class="form-title">Add New Brand</div>
        <form autocomplete="off" novalidate>
            <div class="mb-3">
                <label for="brand_name" class="form-label">Brand Name:</label>
                <input type="text" class="form-control" id="brand_name" name="brand_name" required>
            </div>
            <center>
                <button type="submit" class="Confirm-button" id="confirmBtn" disabled>Confirm</button>
            </center>
        </form>
        <div class="brand-list">
            <div class="form-title" style="font-size:1.2rem; margin-bottom:10px; margin-top:0; text-align:left;">Registered Brands</div>
            <div class="brand-item">
                <span class="brand-name">Sample Brand 1</span>
                <button class="delete-btn" disabled>Delete</button>
            </div>
            <div class="brand-item">
                <span class="brand-name">Sample Brand 2</span>
                <button class="delete-btn" disabled>Delete</button>
            </div>
            <div class="brand-item">
                <span class="brand-name">Sample Brand 3</span>
                <button class="delete-btn" disabled>Delete</button>
            </div>
        </div>
    </div>
</div>
<script>
    // Disable Confirm button if input is empty
    const brandInput = document.getElementById('brand_name');
    const confirmBtn = document.getElementById('confirmBtn');
    brandInput.addEventListener('input', function() {
        confirmBtn.disabled = this.value.trim() === '';
    });
</script>
</body>
</html>