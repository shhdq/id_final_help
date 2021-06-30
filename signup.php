<?php require_once './components/navbar.php';

$email = "";
$success = "";
$errors = "";

if (isset($_POST['submit'])) {

  require_once 'config.php';

  $email = $_POST['regEmail'];
  $password = $_POST['regPassword'];
  $hash = password_hash($password, PASSWORD_DEFAULT);
  //$error = "";

  $user_check_query = "SELECT * FROM users WHERE email='$email' LIMIT 1";
  $result = mysqli_query($db, $user_check_query);
  $user = mysqli_fetch_assoc($result);

  if ($user) { // ja eksistē jau 

    if ($user['email'] === $email) {
      $success = '
      <div class="alert alert-danger" role="alert">
       Email already registered!
      </div>
      ';
    }
  } else {
    $sql = "INSERT INTO users (email, password) VALUES ('$email', '$hash')";

    if ($db->query($sql) === TRUE) { //viss čiki puki un ir aizgājis uz db
      $success = '
      <div class="alert alert-success" role="alert">
       Registration success!
      </div>
      ';
      header('refresh:3; login.php');
    }
  }
}
?>

<!-- Main -->
<div class="container">

  <div class="wrapper">
    <h1>SIGN UP</h1>
    <?php echo $success ?>
    <form action="" method="post">
      <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Email address</label>
        <input type="email" name="regEmail" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
        <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
      </div>
      <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label">Password</label>
        <input type="password" name="regPassword" class="form-control" id="exampleInputPassword1">
      </div>
      <!-- <div class="mb-3 form-check">
      <input type="checkbox" class="form-check-input" id="exampleCheck1">
      <label class="form-check-label" for="exampleCheck1">Check me out</label>
    </div>-->
      <button type="submit" name="submit" class="btn btn-primary" style="color: blue;">SIGN UP</button>
      <a href="./login.php" style="margin-left: 15px">Log in<a>

    </form>
  </div>
</div>

<!-- Footer -->
<?php
require_once './components/footer.php';
?>