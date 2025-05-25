<?php
session_start();

require_once 'settings.php';

// Connect to MySQL using mysqli
$conn = mysqli_connect($host, $username, $password, $database);
if (!$conn) {
    // If the connection fails, stop execution and show the error
    die("Database connection failed: " . mysqli_connect_error());
}

// Build the SQL to fetch all jobs
$sql    = "SELECT * FROM jobs ORDER BY id";
// Execute the query
$result = mysqli_query($conn, $sql);
if (!$result) {
    // If the query fails, stop execution and show the MySQL error
    die("Query error: " . mysqli_error($conn));
}

// Include the site-wide header 
include 'header.inc';
?>

<!-- Section header for this page -->
<header class="job-header">
  <h1>Job Opportunities</h1>
</header>

<main>
  <!-- Loop over each row in the result set -->
  <?php while ($job = mysqli_fetch_assoc($result)): ?>
    <?php 
      $anchor = strtolower(
        preg_replace('/[^\w]+/', '_', trim($job['title']))
      );
    ?>
    <!-- Use that anchor ID on the <section> -->
    <section id="<?php echo htmlspecialchars($anchor); ?>">
      <!-- Display the job title -->
      <h2><?php echo htmlspecialchars($job['title']); ?></h2>

      <!-- Reference Number -->
      <p>
        <strong>Reference Number:</strong>
        <?php echo htmlspecialchars($job['ref_number']); ?>
      </p>

      <!-- Salary Range -->
      <p>
        <strong>Salary Range:</strong>
        <?php echo htmlspecialchars($job['salary_range']); ?>
      </p>

      <!-- Reports To -->
      <p>
        <strong>Reports To:</strong>
        <?php echo htmlspecialchars($job['reports_to']); ?>
      </p>

      <!-- Job Description: escape HTML and preserve newlines -->
      <h3>Job Description</h3>
      <p>
        <?php 
          echo nl2br(
            htmlspecialchars($job['description'])
          ); 
        ?>
      </p>

      <!-- Responsibilities: assumed to be safe HTML (e.g., a <ul> list) -->
      <h3>Key Responsibilities</h3>
      <?php echo $job['responsibilities']; ?>

      <!-- Qualifications -->
      <h3>Qualifications and Skills</h3>
      <h4>Essential</h4>
      <?php echo $job['qualifications_essential']; ?>

      <!-- Only show the “Preferable” section if there’s content -->
      <?php if (!empty($job['qualifications_preferable'])): ?>
        <h4>Preferable</h4>
        <?php echo $job['qualifications_preferable']; ?>
      <?php endif; ?>

      <!-- “Apply now” button: pass the reference number in the URL, URL-encoded for safety -->
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
  <p>
    We offer competitive salaries, remote work options, and professional development programs.
  </p>
</aside>

<?php
// Free the result set’s memory
mysqli_free_result($result);
// Close the database connection
mysqli_close($conn);

include 'footer.inc';
?>
