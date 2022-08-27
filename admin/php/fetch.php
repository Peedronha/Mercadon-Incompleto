<?php
include("connection.php");
if(isset($_POST['request'])){
    $request = $_POST['request'];

    $stmt = "SELECT * FROM product WHERE category='$request'";
    $rs =  mysqli_query($con, $stmt);

    $count = mysqli_fetch_assoc($rs);
    if($count == 0){
        echo false;
    }
    while($row = mysqli_fetch_assoc($rs)){
        $results = array('ID'=>$row['ProductID'],
                         'Name' => $row['ProductName'],
                         'Price' => $row['ProductPrice'], 
                         'SalePrice' => $row['ProductSalePrice'],
                         'Stock' => $row['ProductStock'],
                         'CreatedAt' =>  $row['created_at'],
                         'Img' => $row['ProductImage']);
        }
        echo json_encode($results);
}
?>