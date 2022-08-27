<?php
include("connection.php");
if(isset($_POST['filter'])){    
$filter = $_POST['filter'];
    
    $stmt = "SELECT * FROM products";
      
    $rs = mysqli_query($con, $stmt) or die(mysqli_error($con));

    while($row = mysqli_fetch_assoc($rs)){
        $results = array('ID'=>$row['ProductID'],
                         'Name' => $row['ProductName'],
                         'Price' => $row['ProductPrice'], 
                         'SalePrice' => $row['ProductSalePrice'],
                         'Stock' => $row['ProductStock'],
                         'CreatedAt' =>  $row['created_at'],
                         'Img' => $row['ProductImage']);
        }
    }
    echo json_encode($results);
?>