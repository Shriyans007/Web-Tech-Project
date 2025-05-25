<!-- header.inc -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CyberNova</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <header class="site-header">
    <div class="logo">
      <a href="index.php">
        <img src="SuperNovaLogo.png" alt="Cyber Nova Inc. Logo" style="height: 100px;">
      </a>
    </div>
    <nav>
      <ul class="nav-links">
        <li><a href="index.php">Home</a></li>
        <li><a href="jobs.php">Job Openings</a></li>
        <li><a href="about.php">About Us</a></li>
        <li><a href="apply.php">Apply</a></li>
        <!-- USER ICON / LOGIN LINK -->
        <li>
          <a href="login.php" title="Login or Register" class="user-icon-link">
            <!-- Make sure loginimage.jpg sits in the same folder as header.inc (or adjust the path) -->
            <img src="loginimage.jpg" alt="Log In" class="login-icon">
          </a>
        </li>
      </ul>
    </nav>
  </header>
