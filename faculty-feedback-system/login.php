<?php
session_start();
include 'config/db_connect.php';

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role']; // get role from form

    $query = "SELECT * FROM users WHERE username='$username' AND password='$password' AND role='$role'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['username'] = $user['username'];

        if ($user['role'] == 'student') {
            header('Location: feedback_form.php');
        } elseif ($user['role'] == 'faculty') {
            header('Location: faculty_dashboard.php');
        } elseif ($user['role'] == 'admin') {
            header('Location: admin_dashboard.php');
        }
        exit();
    } else {
        $error = "Invalid Username, Password or Role!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login - Faculty Feedback System</title>
    <link rel="stylesheet" href="assets/css/login.css">
</head>
<body>
    <h2>Login</h2>
    
    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>

    <form method="post" action="">
        <label>Username:</label><br>
        <input type="text" name="username" required><br><br>

        <label>Password:</label><br>
        <input type="password" name="password" required><br><br>

        <label>Select Role:</label><br>
        <select name="role" required>
            <option value="">--Select Role--</option>
            <option value="student">Student</option>
            <option value="faculty">Faculty</option>
            <option value="admin">Admin</option>
        </select><br><br>

        <input type="submit" name="login" value="Login">
    </form>
</body>
</html>
