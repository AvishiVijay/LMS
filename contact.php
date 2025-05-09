<?php
include('./dbConnection.php');
include('./mainInclude/header.php');
?>

<!-- Link External CSS -->
<link rel="stylesheet" href="./css/jj.css">

<?php
// Handle form submission
$msg = '';
if (isset($_POST['submit'])) {
    $name = trim($_POST['name']);
    $subject = trim($_POST['subject']);
    $email = trim($_POST['email']);
    $message = trim($_POST['message']);

    // Check if all fields are filled
    if ($name != "" && $subject != "" && $email != "" && $message != "") {
        $stmt = $conn->prepare("INSERT INTO contacts (name, subject, email, message) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $subject, $email, $message);

        if ($stmt->execute()) {
            $msg = '<div class="alert alert-success mt-3">✅ Message sent successfully. Thank you!</div>';
        } else {
            $msg = '<div class="alert alert-danger mt-3">❌ Failed to send message. Please try again.</div>';
        }
        $stmt->close();
    } else {
        $msg = '<div class="alert alert-warning mt-3">⚠ Please fill in all fields.</div>';
    }
}
?>

<!-- Start Contact Us -->
<div class="container mt-5 mb-5" id="Contact">
    <h2 class="text-center mb-4 text-primary">Contact Us</h2>
    <div class="row">
        <!-- Form Column -->
        <div class="col-md-8 mb-4">
            <div class="card shadow">
                <div class="card-body">
                    <?php if ($msg != '') echo $msg; ?>
                    <form action="" method="post">
                        <div class="form-group">
                            <input type="text" class="form-control mb-3" name="name" placeholder="Name" required>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control mb-3" name="subject" placeholder="Subject" required>
                        </div>
                        <div class="form-group">
                            <input type="email" class="form-control mb-3" name="email" placeholder="E-mail" required>
                        </div>
                        <div class="form-group">
                            <textarea class="form-control mb-3" name="message" placeholder="How can we help you?" rows="5" required></textarea>
                        </div>
                        <button class="btn btn-primary btn-block" type="submit" name="submit">Send Message</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Contact Info Column -->
        <div class="col-md-4">
            <div class="card bg-primary text-white h-100">
                <div class="card-body d-flex flex-column justify-content-center">
                    <h4 class="card-title">A Cube Tech</h4>
                    <p class="card-text">
                        A Cube Tech,<br>
                        Swami Keshvanand Institute of Technology Management and Gramothan,<br>
                        Jaipur - 302017<br><br>
                        📞 Phone: +1233345<br>
                        🌐 Website: www.acubetech.com
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Contact Us -->

<?php include('./mainInclude/footer.php'); ?>
