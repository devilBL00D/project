<div class="main-box">
        <div class="wrapper">
            <!--      <div class="textanimate">-->
            <!--          <h1>-->
            <!--              <a href="" class="typewrite" data-period="2000" data-type='[ "REGESTRATION" ]'>-->
            <!--                  <span class="wrap"></span>-->
            <!--              </a>-->
            <!--          </h1>-->
            <!--      </div>-->
            <div class="heading">
                <h2>Log IN</h2>
            </div>

            <form action="checkout.php" method ="post">

                <div class="input-box">
                    <input type="email" name="c_email" placeholder="Enter your email" value="<?php echo isset($_POST['email'])? trim($_POST['email']):'';?>" required>
                </div>


                <div class="input-box">
                    <input type="password" name="c_pass" placeholder="Create password" required>
                </div>

                <div class="input-box button">
                    <input type="Submit" name="login" value="Log in">
                </div>
                <div class="text">
                    <h3> <a href="forgotpassword.php">Forgot password?</a></h3>
                </div>
                <div class="text">
                    <h3> <a href="./wholesaler/wholesaler_login.php">Click here for wholesaler login</a></h3>
                </div>
            </form>
        </div>
        <div class="register-box"  >

                <h3>New User ?</h3>


            <div class="register-button" onclick="window.location.href = 'register.php';">
               <p>Register now </p>

            </div>


        </div>
    </div>

<?php

if (isset($_POST['login'])) {

    $customer_email = $_POST['c_email'];

    $customer_pass = $_POST['c_pass'];

    $select_customer = "select * from customers where customer_email='$customer_email'";

    $run_customer = mysqli_query($con, $select_customer);

    $get_ip = getRealUserIp();

    $check_customer = mysqli_num_rows($run_customer);

    $data = mysqli_fetch_assoc($run_customer);
    $hash_password = $data["customer_pass"];
    if (password_verify($customer_pass, $hash_password)) {
        $select_cart = "select * from cart where ip_add='$get_ip'";

        $run_cart = mysqli_query($con, $select_cart);

        $check_cart = mysqli_num_rows($run_cart);
    } else {
        echo "<script>alert('password or email is wrong')</script>";

        exit();
    }





    if ($check_customer == 1 and $check_cart == 0) {

        $_SESSION['customer_email'] = $customer_email;

        echo "<script>alert('You are Logged In')</script>";

        echo "<script>window.open('customer/my_account.php?my_orders','_self')</script>";
    } else {

        $_SESSION['customer_email'] = $customer_email;
        $_SESSION['role'] = "retailer";

        echo "<script>alert('You are Logged In')</script>";

        echo "<script>window.open('checkout.php','_self')</script>";
    }
}

?>