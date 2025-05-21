<?php
session_start();
require_once 'settings.php';

$conn = mysqli_connect($host, $username, $password, $database);
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}


$sql    = "SELECT * FROM jobs ORDER BY id";
$result = mysqli_query($conn, $sql);
if (!$result) {
    die("Query error: " . mysqli_error($conn));
}


include 'header.inc';
?>

<header class="job-header">
  <h1>Job Opportunities</h1>
</header>

<main>
  <?php while ($job = mysqli_fetch_assoc($result)): ?>
    <?php 
      $anchor = strtolower(preg_replace('/[^\w]+/', '_', trim($job['title'])));
    ?>
    <section id="<?php echo htmlspecialchars($anchor); ?>">
      <h2><?php echo htmlspecialchars($job['title']); ?></h2>
      <p>
        <strong>Reference Number:</strong>
        <?php echo htmlspecialchars($job['ref_number']); ?>
      </p>
      <p>
        <strong>Salary Range:</strong>
        <?php echo htmlspecialchars($job['salary_range']); ?>
      </p>
      <p>
        <strong>Reports To:</strong>
        <?php echo htmlspecialchars($job['reports_to']); ?>
      </p>

      <h3>Job Description</h3>
      <p><?php echo nl2br(htmlspecialchars($job['description'])); ?></p>

      <h3>Key Responsibilities</h3>
      <?php echo $job['responsibilities']; ?>

      <h3>Qualifications and Skills</h3>
      <h4>Essential</h4>
      <?php echo $job['qualifications_essential']; ?>

      <?php if (!empty($job['qualifications_preferable'])): ?>
        <h4>Preferable</h4>
        <?php echo $job['qualifications_preferable']; ?>
      <?php endif; ?>

      <a
        href="apply.php?ref=<?php echo urlencode($job['ref_number']); ?>"
        class="button"
      >
        <span>Apply now</span>
      </a>
    </section>
  <?php endwhile; ?>
</main>

<aside>
  <h3>Why Work With Us?</h3>
  <p>We offer competitive salaries, remote work options, and professional development programs.</p>
</aside>

<?php
// Clean up
mysqli_free_result($result);
mysqli_close($conn);

// Pull in your shared footer (closing </body></html>)
include 'footer.inc';
?>
