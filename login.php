<?php
session_start();
require_once("settings.php");

// 1. Connect
$conn = mysqli_connect($host, $username, $password, $database);
if (!$conn) {
    die("DB connect failed: " . mysqli_connect_error());
}



$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $user = trim($_POST['user'] ?? '');
  $pass = $_POST['password'] ?? '';

  if (!$user || !$pass) {
    $errors[] = "Please fill in both fields.";
  } else {
    $stmt = mysqli_prepare($conn,
      "SELECT id,username,password FROM users WHERE username=? OR email=? LIMIT 1");
    mysqli_stmt_bind_param($stmt, "ss", $user, $user);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $id, $username, $hash);

    if (mysqli_stmt_fetch($stmt) && password_verify($pass, $hash)) {
      $_SESSION['user_id']  = $id;
      $_SESSION['username'] = $username;
      header("Location: index.php");
      exit;
    } else {
      $errors[] = "Invalid username/email or password.";
    }
    mysqli_stmt_close($stmt);
  }
}

include 'header.inc';
?>
<main class="form-container">
  <h3>Log In</h3>
  <hr>
  <?php if (isset($_GET['registered'])): ?>
    <p class="no-results">Registration successful! Please log in.</p>
  <?php endif; ?>
  <?php if ($errors): ?>
    <ul class="no-results">
      <?php foreach ($errors as $e): ?>
        <li><?= htmlspecialchars($e) ?></li>
      <?php endforeach ?>
    </ul>
  <?php endif; ?>

  <form method="post" novalidate>
    <table>
      <tbody>
        <tr>
          <td>Username or Email</td>
          <td><input type="text" name="user" required></td>
        </tr>
        <tr>
          <td>Password</td>
          <td><input type="password" name="password" required></td>
        </tr>
      </tbody>
    </table>
    <button type="submit" class="button"><span>Log In</span></button>
    <p>New here? <a href="register.php" class= "LoginStyle">Create an account</a></p>
  </form>
</main>
<?php include 'footer.inc'; ?>
