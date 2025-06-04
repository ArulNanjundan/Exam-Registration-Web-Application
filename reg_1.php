<?php
    session_start();
    include('base.php');

    if (!isset($_GET['exam_id'])) {
        die("<script>alert('No exam selected!'); window.location.href='exam_reg.php';</script>");
    }

    $exam_id = mysqli_real_escape_string($connection, $_GET['exam_id']);

    $query = "SELECT Exam_Name FROM exam_timetable WHERE Exam_ID = '$exam_id'";
    $result = mysqli_query($connection, $query);

    if ($row = mysqli_fetch_assoc($result)) {
        $_SESSION['exam_name'] = $row['Exam_Name'];
    } else {
        die("<script>alert('Invalid Exam ID!'); window.location.href='exam_reg.php';</script>");
    }

    include('reg.html');
?>
