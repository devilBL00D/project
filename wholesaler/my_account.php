<?php

session_start();

if (!isset($_SESSION['customer_email'])) {

  echo "<script>window.open('wholesaler_login.php','_self')</script>";
} else {

  include("includes/db.php");
  include("../includes/header.php");
  include("functions/functions.php");
  include("includes/main.php");


?>
  <main>
    <!-- HERO -->
    <div class="nero">
      <div class="nero__heading">
        <span class="nero__bold">My </span>Account
      </div>
      <p class="nero__text">
      </p>
    </div>
  </main>

  <div id="content">
    <!-- content Starts -->
    <div class="container">
      <!-- container Starts -->



      <div class="col-md-12">
        <!-- col-md-12 Starts -->

        <?php

        $c_email = $_SESSION['customer_email'];

        $get_customer = "select * from wholesaler where wholesaler_email='$c_email'";

        $run_customer = mysqli_query($con, $get_customer);

        $row_customer = mysqli_fetch_array($run_customer);

        $customer_confirm_code = $row_customer['wholesaler_confirm_code'];

        $c_name = $row_customer['wholesaler_name'];

        if (!empty($customer_confirm_code)) {

        ?>

          <div class="alert alert-danger">
            <!-- alert alert-danger Starts -->

            <strong> Warning! </strong> Please Confirm Your Email and if you have not received your confirmation email

            <a href="my_account.php?send_email" class="alert-link">

              Send Email Again

            </a>

          </div><!-- alert alert-danger Ends -->

        <?php } ?>

      </div><!-- col-md-12 Ends -->

      <div class="col-md-3">
        <!-- col-md-3 Starts -->

        <?php include("includes/sidebar.php"); ?>

      </div><!-- col-md-3 Ends -->

      <div class="col-md-9">
        <!--- col-md-9 Starts -->

        <div class="box">
          <!-- box Starts -->

          <?php

          if (isset($_GET[$customer_confirm_code])) {

            $update_customer = "update wholesaler set wholesaler_confirm_code='' where wholesaler_confirm_code='$customer_confirm_code'";

            $run_confirm = mysqli_query($con, $update_customer);

            echo "<script>alert('Your Email Has Been Confirmed')</script>";

            echo "<script>window.open('my_account.php?my_orders','_self')</script>";
          }

          if (isset($_GET['send_email'])) {

            require "../Mail/phpmailer/PHPMailerAutoload.php";
            $mail = new PHPMailer;

            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->Port = 587;
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = 'tls';

            // h-hotel account
            $mail->Username = 'suipservices@gmail.com';
            $mail->Password = 'Suipservices3101.aa';

            // send by h-hotel email
            $mail->setFrom('suipservices@gmail.com', 'Verify Email');
            // get email from input
            $mail->addAddress($c_email);
            //$mail->addReplyTo('lamkaizhe16@gmail.com');

            // HTML body
            $mail->isHTML(true);
            $mail->Subject = "Email Confirmation Message";
            $mail->Body = "

  <h2>
  Email Confirmation By businessconnect.com $c_name
  </h2>
  
  <a href='localhost/project/wholesaler/my_account.php?$customer_confirm_code'>
  
  Click Here To Confirm Email
  
  </a>
  
  ";

            if (!$mail->send()) {
          ?>
              <script>
                alert("<?php echo " Invalid Email " ?>");
              </script>
            <?php
            } else {
            ?>
              <script>
                alert("<?php echo " Check your mail for account confirmation " ?>");
              </script>
          <?php
            }

            echo "<script>window.open('my_account.php?my_orders','_self')</script>";
          }



          if (isset($_GET['my_orders'])) {

            include("my_orders.php");
          }

          if (isset($_GET['insert_product'])) {

            include("insert_product.php");
          }

          if (isset($_GET['edit_account'])) {

            include("edit_account.php");
          }

          if (isset($_GET['change_pass'])) {

            include("change_pass.php");
          }

          if (isset($_GET['delete_account'])) {

            include("delete_account.php");
          }

          if (isset($_GET['my_products'])) {

            include("view_products.php");
          }

          if (isset($_GET['delete_wishlist'])) {

            include("delete_wishlist.php");
          }
          if (isset($_GET['delete_product'])) {

            include("delete_product.php");
          }

          if (isset($_GET['edit_product'])) {

            include("edit_product.php");
          }

          ?>

        </div><!-- box Ends -->


      </div>
      <!--- col-md-9 Ends -->

    </div><!-- container Ends -->
  </div><!-- content Ends -->



  <?php

  include("../includes/footer.php");

  ?>

  <script src="js/jquery.min.js"> </script>

  <script src="js/bootstrap.min.js"></script>

  </body>

  </html>
<?php } ?>