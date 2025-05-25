<?php?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Enhancements Documentation</title>
  <link rel="stylesheet" href="styles/enhancements.css">
</head>
<body>
  <div class="enhancements-doc">
    <h1>Implemented Enhancements (Comprehensive Detail)</h1>

    <section>
      <h2>1. Sort EOI Records by Selected Field</h2>
      <p><span class="subheading">Feature:</span>
        Introduced a dropdown that allows managers to dynamically reorder the EOI list by any column: <code>EoiNumber</code>, <code>Job_Reference_number</code>, <code>First_name</code>, <code>Last_name</code>, or <code>Status</code>.</p>

      <p><span class="subheading">What I did:</span>
        I added a standalone HTML form with a GET method, containing a <code>&lt;select name="sort"&gt;</code> element whose <code>&lt;option&gt;</code> values exactly match the column names in the MySQL <code>eoi</code> table. Upon form submission, the chosen value is passed as <code>$_GET['sort']</code>. In PHP, I defined an array <code>$allowedFields</code> to list all permissible columns. I then sanitized the input by checking <code>in_array($_GET['sort'], $allowedFields)</code> and assigned it to <code>$sortField</code>, or defaulted to <code>'EoiNumber'</code> if no valid parameter was provided. Constructing the SQL with <code>ORDER BY $sortField</code> ensured the database handled sorting efficiently. Finally, I executed the query using PDO:
        <code>$stmt = $pdo->query($sql);</code> and fetched all matching rows into <code>$records</code>.</p>

      <p><span class="subheading">Why I did it:</span>
        Sorting directly in the SQL query leverages the database’s optimized indexing and prevents loading unsorted data into PHP memory. By validating against <code>$allowedFields</code>, I eliminated the risk of SQL injection or invalid column names being passed. Defaulting to the primary key (<code>EoiNumber</code>) ensures a predictable sort order if the input is missing or tampered with. This feature elevates user experience by giving managers control over data presentation without modifying code manually.</p>

      <p><span class="subheading">Key Code Snippet:</span></p>
      <code>
// Define exact MySQL columns for sorting
$allowedFields = ['EoiNumber', 'Job_Reference_number', 'First_name', 'Last_name', 'Status'];

// Validate or default
$sortField = in_array($_GET['sort'] ?? 'EoiNumber', $allowedFields)
           ? $_GET['sort']
           : 'EoiNumber';

// Perform sorted query
$sql    = "SELECT * FROM eoi ORDER BY $sortField";
$stmt   = $pdo->query($sql);
$records = $stmt->fetchAll(PDO::FETCH_ASSOC);
      </code>
    </section>

    <section>
      <h2>2. Manager Registration with Server-Side Validation</h2>
      <p><span class="subheading">Feature:</span>
        Created <code>register.php</code> to securely onboard new managers, enforcing strong validation and storing credentials in the <code>users</code> MySQL table.</p>

      <p><span class="subheading">What I did:</span>
        I implemented a multipart form accepting <code>username</code>, <code>email</code>, <code>password</code>, and <code>confirm_password</code>. On submission, I trimmed inputs and applied multiple server-side checks:
        <ul>
          <li><strong>Username Regex:</strong> <code>/^[A-Za-z0-9_]{3,20}$/</code> to allow only alphanumeric characters and underscores, 3–20 in length.</li>
          <li><strong>Email Format:</strong> <code>filter_var($email, FILTER_VALIDATE_EMAIL)</code> to confirm RFC-compliant addresses.</li>
          <li><strong>Password Rules:</strong> Minimum length of 6, and matching confirmation field.</li>
        </ul>
        After passing validation, I prepared a SELECT against <code>users(username,email)</code> to detect duplicates. Using <code>mysqli_prepare</code> and <code>bind_param</code> prevented SQL injection. If no existing record was found, I hashed the password with <code>password_hash()</code> and inserted a new row:
        <code>INSERT INTO users (username, email, password) VALUES (?, ?, ?)</code>. Errors at any step are collected in <code>$errors</code> and displayed above the form.</p>

      <p><span class="subheading">Why I did it:</span>
        Client-side validation can be bypassed; server-side enforcement is mandatory for security. Regex and PHP filters standardize input formats. Prepared statements stop SQL injection attempts, and bcrypt hashing via <code>password_hash()</code> protects credentials in the event of a database compromise. Immediate user feedback on errors enhances usability, guiding correct input without exposing internal logic or table schema.</p>

      <p><span class="subheading">Key Code Snippet:</span></p>
      <code>
// Unique check against MySQL `users` table
$stmt = mysqli_prepare($conn,
    "SELECT id FROM users WHERE username=? OR email=?"
);
mysqli_stmt_bind_param($stmt, 'ss', $username, $email);
mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);
if (mysqli_stmt_num_rows($stmt) > 0) {
    $errors[] = 'Username or email already taken.';
}

// Securely hash and insert new user
$hash = password_hash($password, PASSWORD_DEFAULT);
$ins  = mysqli_prepare($conn,
    "INSERT INTO users (username, email, password) VALUES (?, ?, ?)"
);
mysqli_stmt_bind_param($ins, 'sss', $username, $email, $hash);
mysqli_stmt_execute($ins);
      </code>
    </section>

    <section>
      <h2>3. Access Control for <code>manage.php</code></h2>
      <p><span class="subheading">Feature:</span>
        Secured <code>manage.php</code> so only authenticated sessions can view or manipulate EOIs.</p>

      <p><span class="subheading">What I did:</span>
        At the very top of <code>manage.php</code>, I called <code>session_start()</code> to initialize session handling. I then checked <code>empty($_SESSION['user_id'])</code>. If true, I immediately sent a <code>Location</code> header redirecting to <code>login.php</code> and exited the script. In <code>login.php</code>, upon successful <code>password_verify()</code>, I set <code>$_SESSION['user_id']</code>, <code>$_SESSION['username']</code>, and redirected back to <code>manage.php</code>. No further code executes until authentication succeeds.</p>

      <p><span class="subheading">Why I did it:</span>
        Placing authentication checks at the top prevents unauthorized code execution and data exposure. Session-based authentication avoids passing credentials back and forth. By storing only the user ID and username in the session, I minimize sensitive data in memory. Immediate redirects reduce risk and simplify the logic flow by handling access control before any business logic runs.</p>

      <p><span class="subheading">Key Code Snippet:</span></p>
      <code>
session_start();
if (empty($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// After verifying credentials in login.php
$_SESSION['user_id']   = $id;
$_SESSION['username']  = $username;
header('Location: manage.php');
exit;
      </code>
    </section>
  </div>
</body>
</html>
