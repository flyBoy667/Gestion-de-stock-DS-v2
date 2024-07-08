<?php

$liaison = mysqli_connect('127.0.0.1', 'fly', 'root');
mysqli_select_db($liaison, 'stock_v3');


include('includes/header.php');

?>

<?php include('includes/footer.php'); ?>