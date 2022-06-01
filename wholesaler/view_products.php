<?php



if (!isset($_SESSION['customer_email']) && $_SESSION['role'] != "wholesaler") {

    echo "<script>window.open('wholesaler_login.php','_self')</script>";
} else {

?>


    <div class="row">
        <!--  1 row Starts -->

        <div class="col-lg-12">
            <!-- col-lg-12 Starts -->

            <ol class="breadcrumb">
                <!-- breadcrumb Starts -->

                <li class="active">

                    <i class="fa fa-dashboard"></i> Dashboard / View Products

                </li>

            </ol><!-- breadcrumb Ends -->

        </div><!-- col-lg-12 Ends -->

    </div><!--  1 row Ends -->

    <div class="row">
        <!-- 2 row Starts -->

        <div class="col-lg-12">
            <!-- col-lg-12 Starts -->

            <div class="panel panel-default">
                <!-- panel panel-default Starts -->

                <div class="panel-heading">
                    <!-- panel-heading Starts -->

                    <h3 class="panel-title">
                        <!-- panel-title Starts -->

                        <i class="fa fa-money fa-fw"></i> View Products

                    </h3><!-- panel-title Ends -->


                </div><!-- panel-heading Ends -->

                <div class="panel-body">
                    <!-- panel-body Starts -->

                    <div class="table-responsive">
                        <!-- table-responsive Starts -->

                        <table class="table table-bordered table-hover table-striped">
                            <!-- table table-bordered table-hover table-striped Starts -->

                            <thead>

                                <tr>
                                    <th>Product S.N</th>
                                    <th>Product Title</th>
                                    <th>Product Image</th>
                                    <th>Product Price</th>
                                    <th>Product sold</th>
                                    <th>Product Keywords</th>
                                    <th>Product Date</th>
                                    <th>Product Delete</th>
                                    <th>Product Edit</th>



                                </tr>

                            </thead>

                            <tbody>

                                <?php

                                $i = 0;
                                $seller_id="";
                                $wholesaler_mail = $_SESSION['customer_email'];
                                $get_seller = "select * from wholesaler where wholesaler_email='$wholesaler_mail'";
                                $run_get_seller = mysqli_query($con, $get_seller);
                                while ($row_seller = mysqli_fetch_array($run_get_seller)) {
                                    $seller_id = $row_seller['wholesaler_id'];
                                }

                                $get_pro = "select * from products where seller_id='$seller_id'";

                                $run_pro = mysqli_query($con, $get_pro);

                                while ($row_pro = mysqli_fetch_array($run_pro)) {

                                    $pro_id = $row_pro['product_id'];

                                    $pro_title = $row_pro['product_title'];

                                    $pro_image = $row_pro['product_img1'];

                                    $pro_price = $row_pro['product_price'];

                                    $pro_keywords = $row_pro['product_keywords'];

                                    $pro_date = $row_pro['date'];

                                    $i++;

                                ?>

                                    <tr>

                                        <td><?php echo $i; ?></td>

                                        <td><?php echo $pro_title; ?></td>

                                        <td><img src="product_images/<?php echo $pro_image; ?>" width="60" height="60"></td>

                                        <td>$ <?php echo $pro_price; ?></td>

                                        <td>
                                            <?php

                                            $get_sold = "select * from pending_orders where product_id='$pro_id'";
                                            $run_sold = mysqli_query($con, $get_sold);
                                            $count = mysqli_num_rows($run_sold);
                                            echo $count;
                                            ?>
                                        </td>

                                        <td> <?php echo $pro_keywords; ?> </td>

                                        <td><?php echo $pro_date; ?></td>

                                        <td>

                                            <a href="?delete_product=<?php echo $pro_id; ?>">

                                                <i class="fa fa-trash-o"> </i> Delete

                                            </a>

                                        </td>

                                        <td>

                                            <a href="?edit_product=<?php echo $pro_id; ?>">

                                                <i class="fa fa-pencil"> </i> Edit

                                            </a>

                                        </td>

                                    </tr>

                                <?php } ?>


                            </tbody>


                        </table><!-- table table-bordered table-hover table-striped Ends -->

                    </div><!-- table-responsive Ends -->

                </div><!-- panel-body Ends -->

            </div><!-- panel panel-default Ends -->

        </div><!-- col-lg-12 Ends -->

    </div><!-- 2 row Ends -->




<?php } ?>