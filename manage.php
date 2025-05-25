<?php
#start the session
session_start();
require_once("settings.php");

#Connect to database
$conn = mysqli_connect($host, $username, $password, $database);
if (!$conn) {
    die("Database connect failed: " . mysqli_connect_error());
}


#cleans up user input and removes special characters to avoid sql injection
function clean($s) {
    return mysqli_real_escape_string($GLOBALS['conn'], trim($s));
}

#retrives the form summited by the user and sets to empty string if there is nothing
$action = $_POST['action'] ?? '';


include 'header.inc';
?>


<section class="section-container">
  <div class="section-inner">
 
    <h2>Manage Expressions of Interest</h2>

    <div class="manage-container">
<!--Lists all the EOI's-->
      <div class="manage-sidebar">
        <form class="manage-form" method="post" novalidate>
          <input type="hidden" name="action" value="list_all">
          <button type="submit">List All EOIs</button>
        </form>
<!--Filter EOI by Job refrence-->
        <form class="manage-form" method="post" novalidate>
          <input type="hidden" name="action" value="filter_job">
          <label>Job Reference
            <input type="text" name="job_ref" required>
          </label>
          <button type="submit">Filter by Job</button>
        </form>
<!--Filter EOI by Applicant name-->
        <form class="manage-form" method="post" novalidate>
          <input type="hidden" name="action" value="filter_applicant">
          <label>First Name
            <input type="text" name="first_name">
          </label>
          <label>Last Name
            <input type="text" name="last_name">
          </label>
          <button type="submit">Filter by Applicant</button>
        </form>
<!--Delete EOI by job refrence-->
        <form class="manage-form" method="post" novalidate
              onsubmit="return confirm('Delete all EOIs for this job? This cannot be undone.');">
          <input type="hidden" name="action" value="delete_job">
          <label>Job Reference to Delete
            <input type="text" name="delete_job_ref" required>
          </label>
          <button type="submit">Delete EOIs</button>
        </form>
<!--Change EOI status-->
        <form class="manage-form" method="post" novalidate>
          <input type="hidden" name="action" value="change_status">
          <label>EOI Number
            <input type="number" name="eoi_number" required>
          </label>
          <label>New Status
            <select name="new_status" required>
              <option>Pending</option>
              <option>Accepted</option>
              <option>Rejected</option>
            </select>
          </label>
          <button type="submit">Change Status</button>
        </form>
      </div>

 
      <div class="manage-content">
        <div class="table-wrapper">
          <?php
          if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            #Switch used determine the type of form action was taken
            switch ($action) {
              case 'list_all':
                #lists all EOI's
                $sql = "SELECT * FROM eoi ORDER BY EoiNumber";
                break;

              case 'filter_job':
                #Filters EOI for a specific job
                $jr  = clean($_POST['job_ref'] ?? '');
                $sql = "SELECT * FROM eoi
                        WHERE Job_Reference_number='$jr'
                        ORDER BY EoiNumber";
                break;

              case 'filter_applicant':
                #Filter EOI's by first/last name or both if neccessary
                $fn   = clean($_POST['first_name'] ?? '');
                $ln   = clean($_POST['last_name']  ?? '');
                $conds = [];
                if ($fn !== '') $conds[] = "First_name='$fn'";
                if ($ln !== '') $conds[] = "Last_name='$ln'";
                if (empty($conds)) {
                  echo '<p class="no-results">Enter first name, last name, or both.</p>';
                  break;
                }
                $sql = "SELECT * FROM eoi
                        WHERE " . implode(' AND ', $conds) . "
                        ORDER BY EoiNumber";
                break;

              case 'delete_job':
                #Delete EOI's for a specific job and prints how many rows were removed
                $del_ref = clean($_POST['delete_job_ref'] ?? '');
                $res     = mysqli_query($conn,
                            "DELETE FROM eoi
                             WHERE Job_Reference_number='$del_ref'");
                $count   = $res ? mysqli_affected_rows($conn) : 0;
                echo "<p>Deleted $count record(s) for job '$del_ref'.</p>";
                break;

              case 'change_status':
                #Updates the status of one EOI entry by eoi number
                $num = (int)($_POST['eoi_number'] ?? 0);
                $st  = clean($_POST['new_status'] ?? '');
                $ok  = mysqli_query($conn,
                            "UPDATE eoi
                             SET Status='$st'
                             WHERE EoiNumber=$num");
                echo $ok
                  ? "<p>EOI #$num status changed to '$st'.</p>"
                  : '<p class="no-results">Error updating status.</p>';
                break;
            }

            #Display EOI results in a table
            if (in_array($action,
                 ['list_all','filter_job','filter_applicant'], true)) {
              $result = mysqli_query($conn, $sql);
              if (!$result) {
                echo "<p class='no-results'>Query error: "
                     . mysqli_error($conn)
                     . "</p>";
              } elseif (mysqli_num_rows($result) === 0) {
                echo '<p class="no-results">No records found.</p>';
              } else {
                echo '<table class="eoi-table"><thead><tr>';
                foreach (mysqli_fetch_fields($result) as $f) {
                  echo '<th>' . htmlspecialchars($f->name) . '</th>';
                }
                echo '</tr></thead><tbody>';
                mysqli_data_seek($result, 0);
                while ($row = mysqli_fetch_ass  oc($result)) {
                  echo '<tr>';
                  foreach ($row as $cell) {
                    echo '<td>' . htmlspecialchars($cell) . '</td>';
                  }
                  echo '</tr>';
                }
                echo '</tbody></table>';
                mysqli_free_result($result);
              }
            }
          }
          ?>
        </div>
      </div>
    </div>
  </div>
</section>

<?php
mysqli_close($conn);
include 'footer.inc';
?>
