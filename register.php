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
$errors   = [];
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
    $stmt = mysqli_prepare($conn,
      "SELECT id FROM users WHERE username=? OR email=?");
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
    $ins  = mysqli_prepare($conn,
      "INSERT INTO users(username,email,password) VALUES(?,?,?)");
    mysqli_stmt_bind_param($ins, "sss", $username, $email, $hash);
    if (mysqli_stmt_execute($ins)) {
      header("Location: login.php?registered=1");
      exit;
    } else {
      $errors[] = "Database error; please try again.";
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1.0" />
  <title>Create Account</title>
  <link rel="stylesheet" href="styles.css" />
</head>
<body class="register-page">
  <div class="register-container">
    <div class="register-left">
      <h1>Create an account</h1>

      <?php if ($errors): ?>
        <ul class="no-results">
          <?php foreach ($errors as $e): ?>
            <li><?= htmlspecialchars($e) ?></li>
          <?php endforeach; ?>
        </ul>
      <?php endif; ?>

      <form method="post" novalidate>
        <div class="form-group">
          <label>Full name</label>
          <input type="text" name="username"
                 value="<?= htmlspecialchars($username) ?>"
                 required />
        </div>
        <div class="form-group">
          <label>Email</label>
          <input type="email" name="email"
                 value="<?= htmlspecialchars($email) ?>"
                 required />
        </div>
        <div class="form-group password-wrapper">
          <label>Password</label>
          <input type="password" name="password" required />
        </div>
        <div class="form-group">
          <label>Confirm Password</label>
          <input type="password" name="confirm_password" required />
        </div>

        <button type="submit" class="btn-primary">Submit</button>

        <div class="register-footer">
          <a href="login.php">Have any account? Sign in</a>
          <a href="terms.php">Terms & Conditions</a>
        </div>
      </form>
    </div>
    <div class="register-right"></div>
  </div>
</body>
</html>
