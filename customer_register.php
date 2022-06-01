<?php

session_start();

include("includes/db.php");
include("functions/functions.php");
include("includes/header.php");



?>


<main>
  <div class="logo_con">

    <img src="images/LOGO.png" class="logo" alt="BC">
  </div>
  <div class="heading">
    <h2>Registration</h2>
  </div>

  <div class="main-box">

    <div class="wrapper">
      <!--      <div class="textanimate">-->
      <!--          <h1>-->
      <!--              <a href="" class="typewrite" data-period="2000" data-type='[ "REGESTRATION" ]'>-->
      <!--                  <span class="wrap"></span>-->
      <!--              </a>-->
      <!--          </h1>-->
      <!--      </div>-->


      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="input-box">
          <input type="text" name="c_name" placeholder="Enter your name" value="<?php echo isset($_POST['name']) ? trim($_POST['name']) : ''; ?>">
        </div>
        <div class="input-box">
          <input type="email" name="c_email" placeholder="Enter your email" value="<?php echo isset($_POST['email']) ? trim($_POST['email']) : ''; ?>">
        </div>
        <div class="input-box">
          <input type="text" name="c_contact" placeholder="Enter your phone" name="phone" value="<?php echo isset($_POST['phone']) ? trim($_POST['phone']) : ''; ?>">
        </div>
        <div class="input-box-dropdown">
          <select name="role" id="role">
            <!--          <option value="">--Select User Type--</option>-->
            <option value="ROLE_RETAILER">Retailer</option>
            <option value="ROLE_WHOLESALER">Wholesaler</option>
            <!-- <option value="admin">Admin</option> -->
          </select>
        </div>
        <div class="input-box">
          <input type="password" name="c_pass" placeholder="Create password">
        </div>
        <div class="input-box">
          <input type="password" name="c_cnfrm_password" placeholder="Confirm password">
        </div>
        <div class="policy">
          <input type="checkbox" required>
          <h3>I accept all terms & condition</h3>
        </div>
        <div class="input-box button">
          <input type="Submit" name="register" value="Register Now">
        </div>
        <div class="text">
          <h3>Already have an account? <a href="checkout.php">Login now</a></h3>
        </div>
      </form>
    </div>
  </div>
</main>

</body>

</html>

<?php
$email_err = $name_err = $contact_number_err = $role_err = $password_err = $confirm_password_err = "";
$name_regex = $phone_regex = $password_regex = "";
$password = "";
$c_email = $c_contact = $c_name = $c_pass = "";
$name_regex = "/^[a-zA-Z]{3,20}(?: [a-zA-Z]+){0,2}$/";
$phone_regex = "/^(?=.*)((?:\+61) ?(?:\((?=.*\)))?([2-47-8])\)?|(?:\((?=.*\)))?([0-1][2-47-8])\)?) ?-?(?=.*)((\d{1} ?-?\d{3}$)|(00 ?-?\d{4} ?-?\d{4}$)|( ?-?\d{4} ?-?\d{4}$)|(\d{2} ?-?\d{3} ?-?\d{3}$))/";
$password_regex = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{6,}$/";

if (isset($_POST['register'])) {

  //validity check


  //check for email
  if (empty(trim($_POST["c_email"]))) {
    $email_err = "Email cannot be blank";
    echo "<script>alert('Enter your email')</script>";
  } else if (!filter_var(trim($_POST["c_email"], FILTER_VALIDATE_EMAIL))) {
    $email_err = "Enter valid email";
    echo "<script>alert('Enter valid email')</script>";
  } else {
    $c_email = trim($_POST['c_email']);
  }

  //check for name
  if (!preg_match($name_regex, (trim($_POST['c_name'])))) {
    $name_err = "Enter Valid name";
    echo "<script>alert('Enter valid name')</script>";
  } else {
    $c_name = trim($_POST['c_name']);
  }

  //check for phone number
  if (!preg_match($phone_regex, (trim($_POST['c_contact'])))) {
    $contact_number_err = "Enter valid australian phone number";
    echo "<script>alert('Enter valid number')</script>";
  } else {
    $c_contact = trim($_POST['c_contact']);
  }

  //check for role
  if (empty(trim($_POST['role']))) {
    $role_err = "Select a role";
  } else {
    $role = $_POST['role'];
  }

  // Check for password
  if (!preg_match($password_regex, (trim($_POST['c_pass'])))) {
    $password_err = "Password must contain an uppercase letter,a lowercase letter and numbers with minimum length 6";
    echo "<script>alert('Password must contain an uppercase letter,a lowercase letter and numbers with minimum length 6')</script>";
  } else {
    $password = trim($_POST['c_pass']);
  }

  // Check for confirm password field
  if (trim($_POST['c_pass']) !=  trim($_POST['c_cnfrm_password'])) {
    $password_err = "Passwords should match";
    echo "<script>alert('Passwords fields should match')</script>";
  }

  $c_pass = password_hash($password, PASSWORD_DEFAULT);









  if (empty($email_err) && empty($name_err) && empty($contact_number_err) && empty($role_err) && empty($password_err)) {

    if ($role === 'ROLE_RETAILER') {


      $c_ip = getRealUserIp();


      $get_email = "select * from customers where customer_email='$c_email'";

      $run_email = mysqli_query($con, $get_email);

      $check_email = mysqli_num_rows($run_email);

      if ($check_email == 1) {

        echo "<script>alert('This email is already registered, try another one')</script>";

        exit();
      }

      $customer_confirm_code = mt_rand();


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
            
            <a href='localhost/project/customer/my_account.php?$customer_confirm_code'>
            
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

















      $insert_customer = "insert into customers (customer_name,customer_email,customer_pass,customer_contact,customer_ip,customer_confirm_code) values ('$c_name','$c_email','$c_pass','$c_contact','$c_ip','$customer_confirm_code')";


      $run_customer = mysqli_query($con, $insert_customer);

      $sel_cart = "select * from cart where ip_add='$c_ip'";

      $run_cart = mysqli_query($con, $sel_cart);

      $check_cart = mysqli_num_rows($run_cart);

      if ($check_cart > 0) {

        $_SESSION['customer_email'] = $c_email;


        echo "<script>window.open('checkout.php','_self')</script>";
      } else {

        $_SESSION['customer_email'] = $c_email;

        echo "<script>window.open('index.php','_self')</script>";
      }
    }

    if ($role === 'ROLE_WHOLESALER') {


      $c_ip = getRealUserIp();


      $get_email = "select * from wholesaler where wholesaler_email='$c_email'";

      $run_email = mysqli_query($con, $get_email);

      $check_email = mysqli_num_rows($run_email);

      if ($check_email == 1) {

        echo "<script>alert('This email is already registered, try another one')</script>";

        exit();
      }

      $wholesaler_confirm_code = mt_rand();


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
            
            <a href='localhost/project/wholesaler/my_account.php?$wholesaler_confirm_code'>
            
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

















      $insert_customer = "insert into wholesaler (wholesaler_name,wholesaler_email,wholesaler_pass,wholesaler_contact,wholesaler_ip,wholesaler_confirm_code) values ('$c_name','$c_email','$c_pass','$c_contact','$c_ip','$customer_confirm_code')";


      $run_customer = mysqli_query($con, $insert_customer);



      $_SESSION['customer_email'] = $c_email;

      echo "<script>window.open('index.php','_self')</script>";
    }
  }
}

?>