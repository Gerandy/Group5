<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
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
            padding: 5%;
            border-radius: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            height: 80%;
            text-align: center;

        }
    .tab-container {
        background: white;
        padding: 5%;
        border-radius: 20px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        width: 100%;
        height: 70%;
        text-align: center;
       }

    input {
        border-radius: 15px;
        border: none;
        background-color: #D9D9D9;
    }

    .Contact-Num {
        margin-top: 25px;
        margin-left: 60px;
    }

    .Exit-button {
        display:flex ;
        justify-content: right;
        cursor: pointer;
    }

    .dot {
        height: 10px;
        width: 10px;
        background-color: red;
        border-radius: 50%;
        position: absolute;
        top: 10px;
        right: 10px;
    }

    .btn-remove:hover {
        background-color: red;
    }
        
    .btn-confirm:hover {
        background-color: green;
    }

    .btn-remove {
        border-radius: 15px;
        border: none;
        background-color: red;
        width: 40%;
        text-align: center;
        cursor: pointer;
        padding: 5px;
        margin: auto;
        margin-top: 15px;
    }

    .btn-confirm {
        border-radius: 15px;
        border: none;
        background-color: #1C8D20;
        width: 40%;
        text-align: center;
        cursor: pointer;
        padding: 5px;
        margin: auto;
        margin-top: 15px;
    }
  </style>
</head>

<div class="header"></div>
<div class="container mt-4">
    <div class="col-lg-4">
        <div class="tab-container">
            <div class="Exit-button">X</div>
            <div class="Product-name">Product Name:
                <input type="text">
            </div>
            <div class="Contact-Num">Brand:
                <input type="text">
            </div>
            <div class="Contact-Num">Stock:
                <input type="text">
            </div>
            <div class="Contact-Num">Price:
                <input type="text">
            </div>
      <div class="d-flex justify-content-between">
        <button type="button" class="btn btn-remove">Remove</button>
        <button type="submit" class="btn btn-confirm">Confirm</button>
      </div>
    </form>
  </div>

</body>
</html>
