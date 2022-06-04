<?php
session_start();
include("includes/db.php");
include("includes/header.php");
include("functions/functions.php");
include("includes/main.php");
?>
    <div class="main-box">
    <p class="text-muted">
        This portal is for wholesaler login only. If you are not a wholesaler please use the cutomer login link below.

    </p>
    <div class="wrapper_W">
        <div class="heading">
            <h2>Log IN</h2>
        </div>

        <form action="" method ="post">

            <div class="input-box">
                <input type="email" name="c_email" placeholder="Enter your email" value="<?php echo isset($_POST['email'])? trim($_POST['email']):'';?>" required>
            </div>


            <div class="input-box">
                <input type="password" name="c_pass" placeholder="Enter password" required>
            </div>

            <div class="input-box button" >
                <input type="Submit" name="login" value="Sign In">
            </div>
            <div class="text">
                <h3> <a href="../forgot_pass.php">Forgot password?</a></h3>
            </div>
            <div class="text">
                <h3> <a href="../customer/customer_login.php">Click here for customer login</a></h3>
            </div>
        </form>
    </div>
    </div>

<?php

if (isset($_POST['login'])) {

    $customer_email = $_POST['c_email'];

    $customer_pass = $_POST['c_pass'];

    $select_customer = "select * from wholesaler where wholesaler_email='$customer_email'";

    $run_customer = mysqli_query($con, $select_customer);

    $get_ip = getRealUserIp();

    $check_customer = mysqli_num_rows($run_customer);

    $data = mysqli_fetch_assoc($run_customer);
    $hash_password = $data["wholesaler_pass"];
    if (!password_verify($customer_pass, $hash_password)) {
        echo "<script>alert('password or email is wrong')</script>";

        exit();
    } 
    if ($check_customer == 1) {
        

        $_SESSION['customer_email'] = $customer_email;
        $_SESSION['role'] = "wholesaler";

        echo "<script>alert('You are Logged In')</script>";

        echo "<script>window.open('my_account.php?my_orders','_self')</script>";
    }
}

?>