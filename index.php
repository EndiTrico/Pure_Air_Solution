<?php
// start the session
session_start();
include_once 'validateLogin.php';

$errorMessage = '';

// check not NULL
if (isset($_POST['email']) && isset($_POST['password'])) {

  // check that values are not empty string, 0, or false
  if (!empty($_POST['email']) && !empty($_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

   // if (validateLogin($email, $password)) {
      //start the session and register a variable
      // the user id and password match,
      // set the session
      $_SESSION['email'] = $email;

      if (determineRole($email) == "Admin") {
        header('Location: admin_dashboard.php');
        exit();
      } else if (determineRole($email) == "Client") {
        header('Location: client_dashboard.php');
        exit();
      }
    } else {
      $errorMessage = 'Error: Wrong Email or Password!';
    }

 // } else {
  //  $errorMessage = 'Required Fields Missing!';
 // }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="signin.css" />
  <title>Pure Air Solutions</title>
</head>

<body>
  <div class="container">
    <div class="forms-container">
      <div class="left panel">
        <div class="signin-welcome">
          <form action="<?php print($_SERVER['PHP_SELF']); ?>" method="POST" class="signin-form">
            <h2 class="title">Sign in</h2>
            <div class="input-field">
              <i class="fas fa-envelope"></i>
              <input type="email" placeholder="Email" name="email" value="" required />
            </div>
            <div class="input-field">
              <i class="fas fa-lock"></i>
              <input type="password" placeholder="Password" name="password" value="" required />
            </div>
            <button name="submit" class="btn solid">Log In</button>
            <?php
            if ($errorMessage != '') {
              ?>
              <div class="errorMessage">
                <?php echo $errorMessage; ?>
              </div>

              <?php
            }
            ?>
            <p class="social-text">Or Sign in with social platforms</p>
          </form>
        </div>
      </div>
    </div>

    <div class="panels-container">
      <div class="panel left-panel">
        <div class="content">

          <h3>Do You Want to Know About Us?</h3>
          <p>
            Lorem ipsum, dolor sit amet consectetur adipisicing elit. Debitis,
            ex ratione. Aliquid!
          </p>
          <button class="btn transparent" id="welcome-btn">
            Welcome
          </button>
        </div>
        <img src="images/log.svg" class="image" alt="" />
      </div>
      <div class="panel right-panel">
        <div class="content">
          <h3>Do You Want to Sign in?</h3>
          <p>
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Nostrum
            laboriosam ad deleniti.
          </p>
          <button class="btn transparent" id="sign-in-btn">
            Sign in
          </button>
        </div>

        <img src="images/person.png" class="image" alt="" />
      </div>
    </div>
  </div>
  <script src="signin.js"></script>
</body>

</html>