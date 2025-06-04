<?php
    $server = "localhost";
    $user = "root";
    $password = "root";
    $db = "mini_registration";

    $conn = new mysqli($server, $user, $password, $db);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $exam_id = $_POST['Exam_ID'];

    $check = $conn->prepare("SELECT Exam_ID FROM exam_timetable WHERE Exam_ID = ?");
    $check->bind_param("i", $exam_id);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        
        $stmt = $conn->prepare("DELETE FROM exam_timetable WHERE Exam_ID = ?");
        $stmt->bind_param("i", $exam_id);

        if ($stmt->execute()) {
            echo "<script>alert('Exam timetable deleted successfully.'); window.location.href='time_delete.html';</script>";
        } else {
            echo "<script>alert('Error deleting exam timetable.'); window.location.href='time_delete.html';</script>";
        }
        $stmt->close();
    } else {
        echo "<script>alert('Examination details not available for the provided Exam ID.'); window.location.href='time_delete.html';</script>";
    }

    $check->close();
    $conn->close();
?>
