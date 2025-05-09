<?php
if(!isset($_SESSION)){ 
  session_start(); 
}
define('TITLE', 'My Course');
define('PAGE', 'mycourse');
include('./stuInclude/header.php'); 
include_once('../dbConnection.php');

// Check if student is logged in
if(isset($_SESSION['is_login'])){
    $stuLogEmail = $_SESSION['stuLogEmail'];
} else {
    echo "<script> location.href='../index.php'; </script>";
}
?>

<div class="container mt-5 ml-4">
    <div class="row">
        <div class="jumbotron">
            <h4 class="text-center">Your Purchased Courses</h4>

            <?php 
            if(isset($stuLogEmail)){
                // Query to fetch purchased courses for the logged-in student
                $sql = "SELECT co.order_id, c.course_id, c.course_name, c.course_duration, c.course_desc, 
                        c.course_img, c.course_author, c.course_original_price, c.course_price 
                        FROM courseorder AS co 
                        JOIN course AS c ON c.course_id = co.course_id 
                        WHERE co.stu_email = '$stuLogEmail'"; 
                
                $result = $conn->query($sql);
                
                // Check if there are any courses the student has purchased
                if($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()){
            ?>
            <!-- Course Card -->
            <div class="card mb-4 bg-light">
                <div class="row no-gutters">
                    <div class="col-md-4">
                        <img src="<?php echo $row['course_img']; ?>" class="card-img" alt="course-image">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $row['course_name']; ?></h5>
                            <p class="card-text"><?php echo $row['course_desc']; ?></p>
                            <p class="card-text"><small class="text-muted">Instructor: <?php echo $row['course_author']; ?></small></p>
                            <p class="card-text">Duration: <?php echo $row['course_duration']; ?></p>
                            
                            <p class="card-text">
                                Price: <small><del>&#8377 <?php echo $row['course_original_price']; ?></del></small>
                                <span class="font-weight-bolder">&#8377 <?php echo $row['course_price']; ?></span>
                            </p>

                            <a href="watchcourse.php?course_id=<?php echo $row['course_id']; ?>" class="btn btn-primary float-right">
                                Watch Course
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <?php
                    }
                } else {
                    echo "<p class='text-center'>You have not purchased any courses yet.</p>";
                }
            }
            ?>
        </div>
    </div>
</div>

<?php
include('./stuInclude/footer.php'); 
?>
