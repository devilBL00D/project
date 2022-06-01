<?php



if (!isset($_SESSION['customer_email']) && $_SESSION['role'] != "wholesaler") {

    echo "<script>window.open('wholesaler_login.php','_self')</script>";
} else {

?>

<?php

    if (isset($_GET['delete_product'])) {
        $wholesaler_mail = $_SESSION['customer_email'];
        $seller_id = "";
        $get_seller = "select * from wholesaler where wholesaler_email='$wholesaler_mail'";
        $run_get_seller = mysqli_query($con, $get_seller);
        while ($row_seller = mysqli_fetch_array($run_get_seller)) {
            $seller_id = $row_seller['wholesaler_id'];
        }

        $delete_id = $_GET['delete_product'];

        $delete_pro = "delete from products where product_id='$delete_id' AND seller_id='$seller_id'";

        $run_delete = mysqli_query($con, $delete_pro);

        if ($run_delete) {

            echo "<script>alert('One Product Has been deleted')</script>";

            echo "<script>window.open('index.php?view_products','_self')</script>";
        }
    }

?>

<?php } ?>