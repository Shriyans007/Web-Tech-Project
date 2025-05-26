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
            "SELECT id,username,password 
               FROM users 
              WHERE username=? OR email=? 
              LIMIT 1"
        );
        mysqli_stmt_bind_param($stmt, "ss", $user, $user);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $id, $username, $hash);

        if (mysqli_stmt_fetch($stmt) && password_verify($pass, $hash)) {
            // success!
            $_SESSION['user_id']  = $id;
            $_SESSION['username'] = $username;
            header("Location: manage.php");
            exit;
        } else {
            $errors[] = "Invalid username/email or password.";
        }
        mysqli_stmt_close($stmt);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1.0" />
  <title>Log In</title>
<link rel="stylesheet" href="styles/styles.css" />
</head>
<body class="register-page">
  <div class="register-container">

    <!-- LEFT PANEL: LOGIN FORM -->
    <div class="register-left">
      <h1>Log In</h1>

      <?php if (isset($_GET['registered'])): ?>
        <p class="no-results">Registration successful! Please log in.</p>
      <?php endif; ?>

      <?php if ($errors): ?>
        <ul class="no-results">
          <?php foreach ($errors as $e): ?>
            <li><?= htmlspecialchars($e) ?></li>
          <?php endforeach; ?>
        </ul>
      <?php endif; ?>

      <form method="post" novalidate>
        <div class="form-group">
          <label>Username or Email</label>
          <input type="text" name="user" required />
        </div>
        <div class="form-group">
          <label>Password</label>
          <input type="password" name="password" required />
        </div>

        <button type="submit" class="btn-primary">Submit</button>

        <div class="register-footer">
          <a href="register.php">New here? Create account</a>
          <a href="terms.php">Terms &amp; Conditions</a>
        </div>
      </form>
    </div>

    <!-- RIGHT PANEL: IMAGE (via your existing CSS rule) -->
    <div class="register-right"></div>
  </div>
</body>
</html>
