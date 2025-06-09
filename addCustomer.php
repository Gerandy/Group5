<?php 
include ('db/database.php'); 
session_start()
?>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $customer_name = mysqli_real_escape_string($connection, $_POST['name']);
    $contact_number = mysqli_real_escape_string($connection, $_POST['contact']);

    $insert_sql = "INSERT INTO customer (name, contact) VALUES ('$customer_name', '$contact_number')";
    if (mysqli_query($connection, $insert_sql)) {
        $message = "Customer added successfully!";
    } else {
        $message = "Error: " . mysqli_error($connection);
    } 
}

?>
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
            padding: 5%;
            border-radius: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            height: 60%;
            text-align: center;

        }
        input {
            border-radius: 15px;
            border: none;
            background-color: #D9D9D9;
        }

        .Contact-Num {
            margin-top: 25px;
        }

        .Exit-button {
            display:flex ;
            justify-content: right;
            cursor: pointer;
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
<?php if (!empty($message)) { ?>
    <script>
        alert("<?php echo addslashes($message); ?>");
    </script>
<?php } ?>
    <div class="header"></div>
        <div class="container mt-4">
            <div class="col-lg-4">
                <div class="tab-container">
                    <div class="Exit-button">X</div>
                    <form method="POST" action="addCustomer.php">
                    <div class="Customer-name">Customer Name:
                        <input type="text" name="name" required>
                    </div>
                    <div class="Contact-Num">Contact Number:
                        <input type="text" name="contact" required maxlength="11" pattern="[0-9]{11}" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0,11);" >
                    </div>
                    <button type="submit" class="Confirm-button">Confirm</div>
                    </form>
                </div>
            </div>
        </div>

</body>
</html>