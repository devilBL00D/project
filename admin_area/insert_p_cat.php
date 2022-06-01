<?php

if (!isset($_SESSION['admin_email'])) {

    echo "<script>window.open('login.php','_self')</script>";
} else {

    $manufacturer_id="";
?>

    <div class="row">
        <!-- 1 row Starts -->

        <div class="col-lg-12">
            <!-- col-lg-12 Starts -->

            <ol class="breadcrumb">
                <!-- breadcrumb Starts -->

                <li>

                    <i class="fa fa-dashboard"></i> Dashboard / Insert Products Category

                </li>

            </ol><!-- breadcrumb Ends -->

        </div><!-- col-lg-12 Ends -->

    </div><!-- 1 row Ends -->

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

                        <i class="fa fa-money fa-fw"></i> Insert Product Category

                    </h3><!-- panel-title Ends -->


                </div><!-- panel-heading Ends -->


                <div class="panel-body">
                    <!-- panel-body Starts -->

                    <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                        <!-- form-horizontal Starts -->

                        <div class="form-group">
                            <!-- form-group Starts -->

                            <label class="col-md-3 control-label">Product Category Title</label>

                            <div class="col-md-6">

                                <input type="text" name="p_cat_title" class="form-control" required>

                            </div>

                        </div><!-- form-group Ends -->
                        <div class="form-group">
                            <!-- form-group Starts -->

                            <label class="col-md-3 control-label"> Select A Manufacturer </label>

                            <div class="col-md-6">

                                <select class="form-control" name="manufacturer" required> 
                                    <!-- select manufacturer Starts -->

                                    <option value=""> Select A Manufacturer </option>

                                    <?php
                                    

                                    $get_manufacturer = "select * from manufacturers";
                                    $run_manufacturer = mysqli_query($con, $get_manufacturer);
                                    while ($row_manufacturer = mysqli_fetch_array($run_manufacturer)) {
                                        $manufacturer_id = $row_manufacturer['manufacturer_id'];
                                        $manufacturer_title = $row_manufacturer['manufacturer_title'];

                                        echo "<option value='$manufacturer_id'>$manufacturer_title</option>";
                                    }

                                    ?>

                                </select><!-- select manufacturer Ends -->

                            </div>

                        </div><!-- form-group Ends -->

                        <div class="form-group">
                            <!-- form-group Starts -->

                            <label class="col-md-3 control-label">Show as Top Product Category</label>

                            <div class="col-md-6">

                                <input type="radio" name="p_cat_top" value="yes">

                                <label> Yes </label>

                                <input type="radio" name="p_cat_top" value="no" checked>

                                <label> No </label>

                            </div>

                        </div><!-- form-group Ends -->


                        <div class="form-group">
                            <!-- form-group Starts -->

                            <label class="col-md-3 control-label"> Select Product Category Image</label>

                            <div class="col-md-6">

                                <input type="file" name="p_cat_image" class="form-control">

                            </div>

                        </div><!-- form-group Ends -->

                        <div class="form-group">
                            <!-- form-group Starts -->

                            <label class="col-md-3 control-label"></label>

                            <div class="col-md-6">

                                <input type="submit" name="submit" value="Submit Now" class="btn btn-primary form-control">

                            </div>

                        </div><!-- form-group Ends -->

                    </form><!-- form-horizontal Ends -->

                </div><!-- panel-body Ends -->


            </div><!-- panel panel-default Ends -->

        </div><!-- col-lg-12 Ends -->

    </div><!-- 2 row Ends -->

    <?php

    if (isset($_POST['submit'])) {

        $p_cat_title = $_POST['p_cat_title'];

        $p_cat_top = $_POST['p_cat_top'];

        $p_manufacturer_id = $_POST['manufacturer'];

        $p_cat_image = $_FILES['p_cat_image']['name'];

        $temp_name = $_FILES['p_cat_image']['tmp_name'];



        move_uploaded_file($temp_name, "other_images/$p_cat_image");

        $insert_p_cat = "insert into product_categories (p_cat_title,p_cat_top,p_cat_image,p_manufacturer_id) values ('$p_cat_title','$p_cat_top','$p_cat_image','$p_manufacturer_id')";

        $run_p_cat = mysqli_query($con, $insert_p_cat);

        if ($run_p_cat) {

            echo "<script>alert('New Product Category Has been Inserted')</script>";

            echo "<script>window.open('index.php?view_p_cats','_self')</script>";
        }
    }



    ?>


<?php } ?>