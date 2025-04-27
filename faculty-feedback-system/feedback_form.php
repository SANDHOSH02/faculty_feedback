<?php
session_start();
include 'config/db_connect.php';

// Check if user is logged in and is a student
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'student') {
    header('Location: login.php');
    exit();
}

// Handle feedback submission
if (isset($_POST['submit_feedback'])) {
    $student_id = $_SESSION['user_id'];
    $faculty_id = $_POST['faculty_id'];
    $feedback = $_POST['feedback'];

    $query = "INSERT INTO feedbacks (student_id, faculty_id, feedback) VALUES ('$student_id', '$faculty_id', '$feedback')";
    mysqli_query($conn, $query);

    $success = "Feedback submitted successfully!";
}

// Fetch all faculty to show in dropdown
$faculty_query = "SELECT * FROM users WHERE role='faculty'";
$faculty_result = mysqli_query($conn, $faculty_query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Submit Feedback</title>
    <link rel="stylesheet" href="assets/css/feedback.css">
</head>
<body>

<h2>Submit Feedback</h2>

<?php if (isset($success)) echo "<p style='color:green;'>$success</p>"; ?>

<form method="post" action="">
    <label>Select Faculty:</label><br>
    <select name="faculty_id" required>
        <option value="">--Select Faculty--</option>
        <?php while ($faculty = mysqli_fetch_assoc($faculty_result)) { ?>
            <option value="<?php echo $faculty['id']; ?>"><?php echo $faculty['username']; ?></option>
        <?php } ?>
    </select><br><br>

    <label>Write Feedback:</label><br>
    <textarea name="feedback" rows="5" cols="40" required></textarea><br><br>

    <input type="submit" name="submit_feedback" value="Submit Feedback">
</form>

</body>
</html>
