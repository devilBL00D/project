<?php

session_start();

include("includes/db.php");
include("includes/header.php");
include("functions/functions.php");
include("includes/main.php");

?>

<main>
  <!-- HERO -->
  <div class="nero">
    <div class="nero__heading">
      <span class="nero__bold">Forgot</span> password
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
      <!--- col-md-12 Starts -->

      <ul class="breadcrumb">
        <!-- breadcrumb Starts -->

        <li>
          <a href="index.php">Home</a>
        </li>

        <li>Register</li>

      </ul><!-- breadcrumb Ends -->



    </div>
    <!--- col-md-12 Ends -->


    <div class="col-md-12">
      <!-- col-md-12 Starts -->

      <div class="box">
        <!-- box Starts -->

        <div class="box-header">
          <!-- box-header Starts -->

          <center>

            <h3> Enter Your Email Below , We Will Send You , Your Password </h3>

          </center>

        </div><!-- box-header Ends -->

        <div align="center">
          <!-- center div Starts -->

          <form action="" method="post">
            <!-- form Starts -->

            <input type="text" class="form-control" name="c_email" placeholder="Enter Your Email" required>

            <br>

            <input type="submit" name="forgot_pass" class="btn btn-primary" value="Send My Password">

          </form><!-- form Ends -->

        </div><!-- center div Ends -->

      </div><!-- box Ends -->

    </div><!-- col-md-12 Ends -->


  </div><!-- container Ends -->
</div><!-- content Ends -->



<?php

include("includes/footer.php");

?>

<script src="js/jquery.min.js"> </script>

<script src="js/bootstrap.min.js"></script>

</body>

</html>

<?php

if (isset($_POST['forgot_pass'])) {

  $c_email = trim($_POST['c_email']);

  $sel_c = "select * from customers where customer_email='$c_email'";

  $run_c = mysqli_query($con, $sel_c);

  $count_c = mysqli_num_rows($run_c);

  $row_c = mysqli_fetch_array($run_c);

  $c_name = $row_c['customer_name'];

  if ($count_c == 0) {

    echo "<script> alert('Sorry, We do not have your email') </script>";

    exit();
  } else {
    session_start();
    // generate token by binaryhexa 
    $token = bin2hex(random_bytes(50));
    $_SESSION['token'] = $token;
    $_SESSION['email'] = $c_email;
    $_SESSION['role'] = "retailer";

    require "Mail/phpmailer/PHPMailerAutoload.php";
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
    $mail->setFrom('suipservices@gmail.com', 'Password Reset');
    // get email from input
    $mail->addAddress($c_email);
    //$mail->addReplyTo('lamkaizhe16@gmail.com');

    // HTML body
    $mail->isHTML(true);
    $mail->Subject = "Recover your password";
    $mail->Body = "<b>Dear User</b>
    <h3>We received a request to reset your password.</h3>
    <a href='http://localhost/project/resetpassword.php'>
            
            Click Here To Confirm Email
            
            </a>
    <br><br>
    <p>With regrads,</p>
    <b>Nijam Shrestha</b>";

    if (!$mail->send()) {
?>
      <script>
        alert("<?php echo " Invalid Email " ?>");
      </script>
    <?php
    } else {
    ?>
      <script>
        alert("<?php echo " Check email to reset password " ?>");
      </script>
<?php
    }
  }
}
?>