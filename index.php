<?php 
include ('db/database.php'); 
session_start()

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POS System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #C0C0C0;
        }
        .pos-container, .container-box {
            background: white;
    padding: 15px;
    border-radius: 20px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    width: 960px;
    height: 850px; 
    display: flex;
    flex-direction: column;
    margin-left:-100px;         
 }
        .separator-line {
        border-top: 3px solid #120C0C;
        margin: 10px 0;
        width: 100%;
    }
    .product-table {
     background: white;
    border-radius: 5px;
    padding: 10px;
    flex-grow: 1;
    height: 500px; 
    overflow-y: auto; 
    }
        .category-buttons-container {
            overflow-x: auto;
                
            gap: 10px;
            
            margin-top: 30px;
            background-color: #D9D9D9;
            height:120px;
        }
        .category-buttons button {
            flex: 0 0 auto;
            width: 150px;
            height: 80px;
            border-radius: 15px;
            margin-right:20px;
            margin-top:10px;
        }
        .search-container {
            display: flex;
            justify-content: flex-end;
            width: 100%;
            margin-bottom: 10px;
            position: relative;
        }
        .searchbar {
            width: 100%;
            max-width: 250px;
            padding: 10px;
            border-radius: 25px;
            border: 1px solid #ccc;
            background-color: #ddd;
            outline: none;
            font-size: 16px;
        }
        .search-icon {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #3572b0;
            font-size: 20px;
            cursor: pointer;
        }
        .addbutton {
            background-color: #D9D9D9;
            border-radius: 10px;
            border: none;
            padding: 5px 10px;
        }
        .header {
            background-color: #2c6ea3;
            height: 50px;
        }

        .container-box {
    background-color: white;
    border-radius: 20px;
    padding: 20px;
    height: 80%;
    width: 430px;
    display: flex;
    flex-direction: column;
    overflow: hidden; 
    height:850px;
    margin-left:20px
    
}

.table-container {
    flex-grow: 1; 
    overflow-y: auto; 
    max-height: 650px; 
}
       

        @media (max-width: 992px) {
            .category-buttons button {
                width: 90px;
                height: 100px;
            }
        }
        .payment-summary {
    margin-top: auto; 
    
  
    text-align: left;
}

.payment-summary {
    background-color: #D9D9D9;
    padding: 10px;
    border-radius: 10px;
    position: sticky;
    bottom: 0;
    width: 100%;
    
    
}

.payment-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 8px 10px;
    border-bottom: 1px solid #bfbfbf;
}

.payment-row:last-child {
    border-bottom: none;
}



.payment-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 8px 10px;
    border-bottom: 1px solid #bfbfbf;
}

.total-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 8px 10px;
    margin-top: 5px; 
    font-weight: bold; 
}

pos-buttons {
    display: flex;
    justify-content: space-between;
    margin-top: 15px;
    padding: 10px;
    background: #f8f9fa;
    border-radius: 10px;
    margin-left:80px;
}

.pos-buttons button {
    flex: 1;
    margin: 5px;
    padding: 10px;
    width:200px;
    border-radius: 10px;
    margin-left:10px;
    margin-top: 20px;
    background-color: rgb(216, 52, 52);
    color:white;
    border-color: none;
    border: none;
}

.button-checkout{
    flex: 1;
    margin: 5px;
    padding: 10px;
    width: 200px;
    border-radius: 10px;
    margin-left:125px;
    margin-top: 18px;
    background-color: rgb(5, 150, 53);
    color:white;
    border-color: none;
    border: none;
    
}

h6 {
    margin-bottom:-30px;
}

    </style>
</head>
<body>
    <div class="header"></div>
    <div class="container mt-4">
        <div class="row g-3">
           
            <div class="col-lg-8">
                <div class="pos-container">
                    <div class="search-container">
                        <input type="text" class="searchbar">
                        <span class="search-icon">🔍</span>
                    </div>
                    <hr class="separator-line">
                    <div class="product-table">
                        <tbody>
    <?php
    

    // Fetch products
                            

                        $query = "SELECT * FROM products";
                        $result = mysqli_query($connection, $query);
                        if (mysqli_num_rows($result) > 0) {
                            echo '<table class="table table-striped">';
                                echo '<tr>';
                                echo '<th> Product Name</th>';
                                echo '<th> Brand</th>';
                                echo '<th> Stock Left</th>';
                                echo '<th> Price</th>';
                                echo '<th> Option</th>';
                                echo '</tr>';
                                echo $_SESSION['test'];
                            while ($row = mysqli_fetch_assoc($result)) {
                                
                                echo '<tr>';
                                echo '<td>' . htmlspecialchars($row['product_name']) . '</td>';
                                echo '<td>' . htmlspecialchars($row['brand']) . '</td>';
                                echo '<td>' . htmlspecialchars($row['stock_left']) . '</td>';
                                echo '<td>' . htmlspecialchars($row['price']) . '</td>';
                                echo '<td><button class="addbutton">Add Item</button>'. '</td>';
                                echo '</tr>';
                                
                            }
                            echo '</table>';
                        } else {
                            echo '<tr><td colspan="4">No products found</td></tr>';
                        }
                                ?>
                            </tbody>

                               
                                
                            </tbody>
                        </table>
                    </div>
                    <div class="category-header">
                        <h6>Category</h6>
                    </div>
                    <div class="category-buttons-container">
                        <div class="category-buttons d-flex">
                            <button class="btn btn-light">All</button>
                            <button class="btn btn-light">GPU</button>
                            <button class="btn btn-light">CPU</button>
                            <button class="btn btn-light">Monitor</button>
                            <button class="btn btn-light">RAM</button>
                            <button class="btn btn-light">Storage</button>
                            <button class="btn btn-light">PSU</button>
                            <button class="btn btn-light">Accessories</button>
                            <button class="btn btn-light">Cases</button>
                        </div>
                    </div>
                    
                </div>
                <div class="pos-buttons">
                    <button class="">Mode of Payment</button>
                    <button class="">Discount</button>
                    <button class="">Clear All</button>
                </div>
            </div>
    
            
            <div class="col-lg-4">
                <div class="container-box">
                    <center><h5>Checkout</h5></center>
                    <div class="table-container">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>RTX 3060</td>
                                    <td>
                                        <button class="btn btn-sm">-</button> 1 <button class="btn btn-sm">+</button>
                                    </td>
                                    <td>₱24,000</td>
                                </tr>
                               
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="payment-summary">
                        <div class="total-row">
                            <span>PAY</span>
                            <span><strong>₱</strong> <button class="btn btn-sm btn-light">0</button></span>
                        </div>
                        <hr>
                        <div class="total-row">
                            <span>CHANGE</span>
                            <span><strong>₱</strong> <button class="btn btn-sm btn-light">0</button></span>
                        </div>
                        <hr>
                        <div class="total-row">
                            <span>TOTAL</span>
                            <span><strong>₱</strong> <button class="btn btn-sm btn-light">24,000</button></span>
                        </div>
                    </div>
                   
                </div>
                
                <button class="button-checkout">Print/Pay</button>
            </div>
        </div>
    </div>
    
   
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
