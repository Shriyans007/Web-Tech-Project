<?php
// Start the session to support user tracking or access control (e.g., login)
session_start();

// Include database connection settings
require_once 'settings.php';

// Connect to the database
$conn = mysqli_connect($host, $username, $password, $database);
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Fetch all job descriptions from the database
$sql = "SELECT * FROM jobs ORDER BY id";
$result = mysqli_query($conn, $sql);
if (!$result) {
    die("Query error: " . mysqli_error($conn));
}

// Include common header HTML (menu, opening <body>, etc.)
include 'header.inc';
?>

<!-- Header section with the main title -->
<header class="job-header">
  <h1>Job Opportunities</h1>
</header>

<!-- Container that uses CSS Grid to place main and aside side-by-side -->
<div class="layout">

  <!-- Main content section that lists all job descriptions -->
  <main>
    <?php while ($job = mysqli_fetch_assoc($result)): ?>
      <?php 
        // Create a clean anchor ID from the job title (e.g., "Web Developer" -> "web_developer")
        $anchor = strtolower(preg_replace('/[^\w]+/', '_', trim($job['title'])));
      ?>
      <section id="<?php echo htmlspecialchars($anchor); ?>">
        <h2><?php echo htmlspecialchars($job['title']); ?></h2>

        <!-- Basic job information -->
        <p><strong>Reference Number:</strong>
          <?php echo htmlspecialchars($job['ref_number']); ?>
        </p>

        <p><strong>Salary Range:</strong>
          <?php echo htmlspecialchars($job['salary_range']); ?>
        </p>

        <p><strong>Reports To:</strong>
          <?php echo htmlspecialchars($job['reports_to']); ?>
        </p>

        <!-- Job description with line breaks preserved -->
        <h3>Job Description</h3>
        <p><?php echo nl2br(htmlspecialchars($job['description'])); ?></p>

        <!-- Responsibilities listed using an ordered list -->
        <h3>Key Responsibilities</h3>
        <ol>
          <?php
            // Split responsibilities on new lines and list them as <li>
            $responsibilities = explode("\n", trim($job['responsibilities']));
            foreach ($responsibilities as $item) {
              echo '<li>' . htmlspecialchars($item) . '</li>';
            }
          ?>
        </ol>

        <!-- Qualifications section -->
        <h3>Qualifications and Skills</h3>
        <h4>Essential</h4>
        <?php echo $job['qualifications_essential']; ?>

        <!-- Preferable qualifications shown only if not empty -->
        <?php if (!empty($job['qualifications_preferable'])): ?>
          <h4>Preferable</h4>
          <?php echo $job['qualifications_preferable']; ?>
        <?php endif; ?>

        <!-- Apply button links to application form with job reference -->
        <a href="apply.php?ref=<?php echo urlencode($job['ref_number']); ?>" class="button">
          <span>Apply now</span>
        </a>
      </section>
    <?php endwhile; ?>
  </main>

  <!-- Aside section providing supplementary company info -->
  <aside>
    <h3>Why Work With Us?</h3>
    <p>We offer competitive salaries, remote work options, and professional development programs.</p>
  </aside>

</div> <!-- End of .layout wrapper -->

<?php
// Free up result memory
mysqli_free_result($result);

// Close the database connection
mysqli_close($conn);

// Include footer HTML (closing </body></html>)
include 'footer.inc';
?>
