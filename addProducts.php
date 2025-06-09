<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <style>
        .header { background-color: #2c6ea3;
            height: 50px;
        }
        body {
            background-color: #C0C0C0;
            margin: 0;
            height: 81vh;
            display: grid;
        }
        .mt-4{
            display: flex;
            justify-content: center;
        }
        .tab-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            height: 70%;
            text-align: center;
            font-weight: bold;

        }
        input {
            border-radius: 15px;
            border: none;
            background-color: #D9D9D9;
        }

        .Product-name  {
            margin-top: 10px;
        }
        .input-class {
            margin-top: 10px;
            margin-left: 60px;
        }

        .Exit-button {
            display:flex ;
            justify-content: right;
            cursor: pointer;
            padding-right: 20px;
            padding-top: 10px;
        }
        .Confirm-button {
            border-radius: 15px;
            border: none;
            background-color: #1C8D20;
            width: 40%;
            text-align: center;
            font-family: inter;
            cursor: pointer;
            font-weight: bold;
            padding: 5px;
            margin: auto;
            margin-top: 15%;
        }

    </style>
</head>
<body>
    <div class="header"></div>
        <div class="container mt-4">
            <div class="col-lg-4">
                <div class="tab-container">
                    <div class="Exit-button">X</div>
                    <div class="Product-name">Product Name:
                        <input type="text">
                    </div>
                    <div class="input-class">Brand:
                        <input type="text">
                    </div>
                    <div class="input-class">Stock:
                        <input type="text">
                    </div>
                    <div class="input-class">Price:
                        <input type="text">
                    </div>
                    <div class="Confirm-button">Confirm</div>
                </div>
            </div>
        </div>
    
</body>
</html>