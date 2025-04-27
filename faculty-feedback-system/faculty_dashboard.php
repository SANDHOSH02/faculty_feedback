<?php
session_start();
include 'config/db_connect.php';

// Check if user is logged in and is a faculty
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'faculty') {
    header('Location: login.php');
    exit();
}

// Get the logged-in faculty's ID
$faculty_id = $_SESSION['user_id'];

// Fetch feedbacks for this faculty
$query = "SELECT * FROM feedbacks WHERE faculty_id='$faculty_id' ORDER BY created_at DESC";
$result = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Feedback - Faculty Dashboard</title>
    <link rel="stylesheet" href="assets/css/faculty.css">
</head>
<body>

    <header>
        <h1>Your Feedback</h1>
        <p>See what students have said about you!</p>
    </header>

    <div class="dashboard">
        <nav class="sidebar">
            <ul>
                <li><a href="faculty_dashboard.php">Dashboard Home</a></li>
                <li><a href="view_feedback.php">View Feedback</a></li>
                <li><a href="self_improvement.php">Self Improvement Tips</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>

        <main class="content">
            <section class="feedback-list">
                <h2>Student Feedback</h2>

                <?php if (mysqli_num_rows($result) > 0) { ?>
                    <ul>
                        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                            <li style="border:1px solid #ccc; padding:10px; margin-bottom:10px;">
                                <?php echo htmlspecialchars($row['feedback']); ?>
                                <br><small>Submitted on: <?php echo date('d-m-Y', strtotime($row['created_at'])); ?></small>
                            </li>
                        <?php } ?>
                    </ul>
                <?php } else { ?>
                    <p>No feedback received yet.</p>
                <?php } ?>
            </section>
        </main>
    </div>

</body>
</html>
