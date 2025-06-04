<?php
    $server = "localhost";
    $user = "root";
    $password = "root";
    $db = "mini_registration";

    $conn = new mysqli($server, $user, $password, $db);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if (isset($_POST['user'])) {
        $email = $_POST['user'];

        $stmt = $conn->prepare("DELETE FROM user_login WHERE email = ?");
        $stmt->bind_param("s", $email);

        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                echo "<script>alert('Admin deleted successfully!'); window.location.href='admin.html';</script>";
            } else {
                echo "<script>alert('No admin found with this email.'); window.location.href='admin_del.html';</script>";
            }
        } else {
            echo "<script>alert('Error deleting admin.'); window.location.href='admin_del.html';</script>";
        }

        $stmt->close();
    } 
    else {
        echo "<script>alert('Invalid request.'); window.location.href='admin_del.html';</script>";
    }

    $conn->close();
?>
