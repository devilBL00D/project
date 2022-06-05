</head>

<body>

  <header class="page-header">
    <!-- topline -->
    <div class="page-header__topline">
      <div class="container clearfix">

        <div class="currency">
          <a class="currency__change" href="customer/my_account.php?my_orders">
            <?php
            if (!isset($_SESSION['customer_email'])) {
              echo "Welcome :Guest";
            } else {
              echo "Welcome : " . $_SESSION['customer_email'] . "";
            }
            ?>
          </a>
        </div>

        <div class="basket">
          <a href="cart.php" class="btn btn--basket">
            <i class="icon-basket"></i>
            <?php items(); ?> items
          </a>
        </div>


        <ul class="login">

          <li class="login__item">
            <?php
            if (!isset($_SESSION['customer_email'])) {
              echo '<a href="customer_register.php" class="login__link">Register</a>';
            }
            if ($_SESSION['role'] == "wholesaler") {
              echo '<a href="wholesaler/my_account.php?my_orders" class="login__link">My Account</a>';
            }
            if ($_SESSION['role'] == "retailer") {
              echo '<a href="customer/my_account.php?my_orders" class="login__link">My Account</a>';
            }
            ?>
          </li>


          <li class="login__item">
            <?php
            if (!isset($_SESSION['customer_email'])) {
              echo '<a href="checkout.php" class="login__link">Sign In</a>';
            } else {
              echo '<a href="./logout.php" class="login__link">Log out</a>';
            }
            ?>

          </li>
        </ul>

      </div>
    </div>
    <!-- bottomline -->
    <div class="container">
      <nav>
        <input type="checkbox" id="nav" class="hidden">
        <label for="nav" class="nav-btn">
          <i></i>
          <i></i>
          <i></i>
        </label>
        <div class="logo">
          <img src="./images/LOGO.png" class="logo" alt="BC">
        </div>
        <div class="nav-wrapper">
          <ul>
            <li><a href="#">Home</a></li>
<!--            <li><a href="#">Notifications</a></li>-->
<!--            <li><a href="#">Cart</a></li>-->
          </ul>
        </div>
      </nav>
    </div>
  </header>