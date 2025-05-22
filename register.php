<?php
session_start();
require_once("settings.php");

// 1. Connect
$conn = mysqli_connect($host, $username, $password, $database);
if (!$conn) {
    die("DB connect failed: " . mysqli_connect_error());
}

// 2. Ensure users table exists

// 3. Handle submission
$errors = [];
$username = $email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = trim($_POST['username'] ?? '');
  $email    = trim($_POST['email'] ?? '');
  $password = $_POST['password'] ?? '';
  $confirm  = $_POST['confirm_password'] ?? '';

  if (!preg_match('/^[A-Za-z0-9_]{3,20}$/', $username)) {
    $errors[] = "Username must be 3–20 letters, numbers or underscores.";
  }
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Please enter a valid email.";
  }
  if (strlen($password) < 6) {
    $errors[] = "Password must be at least 6 characters.";
  }
  if ($password !== $confirm) {
    $errors[] = "Passwords do not match.";
  }

  if (empty($errors)) {
    $stmt = mysqli_prepare($conn, "SELECT id FROM users WHERE username=? OR email=?");
    mysqli_stmt_bind_param($stmt, "ss", $username, $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    if (mysqli_stmt_num_rows($stmt) > 0) {
      $errors[] = "Username or email already taken.";
    }
    mysqli_stmt_close($stmt);
  }

  if (empty($errors)) {
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $ins  = mysqli_prepare($conn, "INSERT INTO users(username,email,password) VALUES(?,?,?)");
    mysqli_stmt_bind_param($ins, "sss", $username, $email, $hash);
    if (mysqli_stmt_execute($ins)) {
      header("Location: login.php?registered=1");
      exit;
    } else {
      $errors[] = "Database error; please try again.";
    }
  }
}

include 'header.inc';
?>
<main class="form-container">
  <h3>Create Account</h3>
  <hr>
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
          <td>Username</td>
          <td>
            <input type="text" name="username"
                   value="<?= htmlspecialchars($username) ?>" required>
          </td>
        </tr>
        <tr>
          <td>Email</td>
          <td>
            <input type="email" name="email"
                   value="<?= htmlspecialchars($email) ?>" required>
          </td>
        </tr>
        <tr>
          <td>Password</td>
          <td><input type="password" name="password" required></td>
        </tr>
        <tr>
          <td>Confirm</td>
          <td>
            <input type="password" name="confirm_password" required>
          </td>
        </tr>
      </tbody>
    </table>
    <button type="submit" class="button"><span>Register</span></button>
    <p>
      Already have an account?
      <a href="login.php" class="LoginStyle">Log In</a>
    </p>
  </form>
</main>
<?php include 'footer.inc'; ?>
