<?php
define('TITLE', 'Feedback');
define('PAGE', 'feedback');
include('./maininclude/header.php'); 
include('dbConnection.php');

// Feedback List Display - Public Access
?>
<div class="col-sm-9 mt-5">
  <!-- Table -->
  <p class="bg-dark text-white p-2">List of Feedbacks</p>
  <?php
    $sql = "SELECT * FROM feedback";
    $result = $conn->query($sql);
    if($result->num_rows > 0){
      echo '<table class="table">
      <thead>
        <tr>
          <th scope="col">Feedback ID</th>
          <th scope="col">Content</th>
          <th scope="col">Student ID</th>
        </tr>
      </thead>
      <tbody>';
      while($row = $result->fetch_assoc()){
        echo '<tr>';
        echo '<th scope="row">'.$row["f_id"].'</th>';
        echo '<td>'. $row["f_content"].'</td>';
        echo '<td>'.$row["stu_id"].'</td>';
        echo '</tr>';
      }

      echo '</tbody>
      </table>';
    } else {
      echo "No feedback available at the moment.";
    }
  ?>

  <!-- Optional: Feedback Form for Public -->
  <div class="mt-4">
    <h5>Submit Your Feedback</h5>
    <form action="submit_feedback.php" method="POST">
      <div class="form-group">
        <label for="feedback">Feedback:</label>
        <textarea class="form-control" id="feedback" name="f_content" rows="3" required></textarea>
      </div>
      <div class="form-group">
        <label for="student_id">Your Student ID:</label>
        <input type="text" class="form-control" id="student_id" name="stu_id" required>
      </div>
      <button type="submit" class="btn btn-primary mt-3">Submit Feedback</button>
    </form>
  </div>
</div>
</div>  <!-- div Row close from header -->
</div>  <!-- div Conatiner-fluid close from header -->
<?php
include('./maininclude/header.php');  // Assuming it's in the 'adminInclude' folder.
include('dbConnection.php');          // If 'dbConnection.php' is in the same directory as feedback.php.

?>
