<?php
session_start();
include 'config/db_connect.php';

// Check if user is logged in and is admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header('Location: login.php');
    exit();
}

// Fetch all feedback with faculty names
$query = "SELECT f.feedback, f.created_at, u.username AS faculty_name 
          FROM feedbacks f
          JOIN users u ON f.faculty_id = u.id
          ORDER BY f.created_at DESC";
$result = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>All Feedback Report - Admin</title>
    <link rel="stylesheet" href="assets/css/admin.css">
</head>
<body>

<header>
    <h1>Admin Panel - All Feedback Reports</h1>
    <p>Complete feedback overview from students</p>
</header>

<div class="dashboard">
    <nav class="sidebar">
        <ul>
            <li><a href="admin_dashboard.php">Dashboard Home</a></li>
            <li><a href="admin_feedback_report.php">View All Feedbacks</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>

    <main class="content">
        <section class="feedback-report">
            <h2>All Student Feedbacks</h2>

            <?php if (mysqli_num_rows($result) > 0) { ?>
                <table border="1" cellpadding="10" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Faculty Name</th>
                            <th>Feedback</th>
                            <th>Date Submitted</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['faculty_name']); ?></td>
                                <td><?php echo htmlspecialchars($row['feedback']); ?></td>
                                <td><?php echo date('d-m-Y', strtotime($row['created_at'])); ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            <?php } else { ?>
                <p>No feedback records found.</p>
            <?php } ?>
        </section>
    </main>
</div>

</body>
</html>
