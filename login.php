<?php

require_once './components/navbar.php';
require_once './config.php';

$email = $password = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $email = trim($_POST["logEmail"]);
  $password = trim($_POST["logPassword"]);

  // Prepare a select statement
  $sql = "SELECT email, password FROM users WHERE email = ?";

  if ($stmt = $db->prepare($sql)) {
    // Bind variables to the prepared statement as parameters
    $stmt->bind_param("s", $param_email);

    // Set parameters
    $param_email = $email;

    // Attempt to execute the prepared statement
    if ($stmt->execute()) {
      // Store result
      $stmt->store_result();

      // Check if username exists, if yes then verify password
      if ($stmt->num_rows == 1) {
        // Bind result variables
        $stmt->bind_result($email, $hashed_password);
        if ($stmt->fetch()) {
          if (password_verify($password, $hashed_password)) {
            // Password is correct, so start a new session
            session_start();

            // Store data in session variables
            $_SESSION["loggedin"] = true;
            $_SESSION["id"] = $id;
            $_SESSION["email"] = $email;

            // Redirect user to welcome page
            header("location: profile.php");
          } else {
            // Password is not valid, display a generic error message
            $login_err = "Invalid username or password.";
          }
        }
      } else {
        // Username doesn't exist, display a generic error message
        $login_err = "Invalid username or password.";
      }
    } else {
      echo "Oops! Something went wrong. Please try again later.";
    }

    // Close statement
    $stmt->close();
  }

  // Close connection
  $mysqli->close();
}
?>

<!-- Main -->
<div class="container">
  <div class="wrapper">
    <h1>Log in</h1>
    <form action="" method="POST">
      <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Email address</label>
        <input type="email" name="logEmail" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" required>
        <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
      </div>
      <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label">Password</label>
        <input type="password" name="logPassword" class="form-control" id="exampleInputPassword1" required>
      </div>
      <!-- <div class="mb-3 form-check">
      <input type="checkbox" class="form-check-input" id="exampleCheck1">
      <label class="form-check-label" for="exampleCheck1">Check me out</label>
    </div>-->
      <button type="submit" name="submit" class="btn btn-primary" style="color: blue;">LOG IN</button>
      <a href="./signup.php" style="margin-left: 15px">Sign Up <a>
    </form>
  </div>
</div>

<!-- Footer -->
<?php
require_once './components/footer.php';
?>