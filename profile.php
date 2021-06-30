<?php

require_once './components/navbar.php';
require_once './config.php';


if (isset($_POST['submitout'])) { //pogas darbība vai seto un strādā
  session_destroy(); //sesiju izbeidz no indexa
  header('Location: login.php'); //refrešo un aiziet uz login lapu
}


$id = 0;
//$update = false;
$errors = "";
$userid = "";
// ievieto taskus , kad nospiež submit pogu
if (isset($_POST['submit'])) {
  if (empty($_POST['task'])) {
    $errors = "You must fill in the task";
  } else {

    $task = $_POST['task'];
    mysqli_query($db, "INSERT INTO tasks (task) VALUES ('$task')");
    //$_SESSION['message'] = "Task saved";
    header('location: profile.php');
  }
}
//edito tasku
/*if (isset($_GET['edit'])) {
  $id = $GET['edit'];
  $update - true;
  $record = mysqli_query($db, "SELECT * FROM tasks WHERE id=$id")
 
  if (count($record) == 1 ) {
    $n = mysqli_fetch_array($record);
    $task = $n['task'];
}
}*/

// dzēst taskus
if (isset($_GET['del_task'])) {
  $id = $_GET['del_task'];

  mysqli_query($db, "DELETE FROM tasks WHERE id=$id");
  header('location: profile.php');
}

?>
<!--
<h4>
  <?php
  //echo "Hi " . $_SESSION['email'] . "!";
  ?>
</h4>-->

<body>
  <form action="" method="post">
    <div class="buttonout">
      <button name="submitout">Logout</button>
      <div class="heading">
        <h2 style="font-style:inherit;">ToDo List</h2>
      </div>
      <form method="post" action="profile.php" class="input_form">
        <?php if (isset($errors)) { ?>
          <p><?php echo $errors; ?></p>
        <?php } ?>
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <input type="text" name="task" class="task_input" value="" placeholder="todo...">


        <button class="btn" type="submit" name="submit" style="color: #c52e42; border: 2px solid #923e3e;">Add task</button>

      </form>
  </form>

  <table>
    <thead>
      <tr class="table">
        <th>N</th>
        <th>Tasks</th>
        <th style="width: 60px;">Edit</th>
        <th style="width: 60px;">Delete</th>
      </tr>
    </thead>

    <tbody>
      <?php
      // selekto visus taskus vai lapa ir refreshota un ieiets tajā

      $tasks = mysqli_query($db, "SELECT * FROM tasks");

      $i = 1;
      while ($row = mysqli_fetch_array($tasks)) { ?>
        <tr>
          <td> <?php echo $i; ?> </td>
          <td class="task"> <?php echo $row['task']; ?> </td>
          <td class="edit">
            <a href="profile.php?edit=<?php echo $row['id']; ?>" class="edit_btn">...</a>
          </td>
          <td class="delete">
            <a href="profile.php?del_task=<?php echo $row['id']; ?>" class="del_btn">x</a>
          </td>
        </tr>
      <?php $i++;
      } ?>

    </tbody>
  </table>
  <?php

  require_once './components/footer.php';
  ?>