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
    $exam_name = $_POST['Exam_Name'];
    $start_date = $_POST['date_1'];
    $end_date = $_POST['date_2'];

    $reg_link = "Reg_" . intval($exam_id);

    $check = $conn->prepare("SELECT Exam_ID FROM exam_timetable WHERE Exam_ID = ?");
    $check->bind_param("i", $exam_id);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        echo "<script>alert('Exam already Register'); window.location.href='exam_timetable_create.html';</script>";
    } 
    else {
        $stmt = $conn->prepare("INSERT INTO exam_timetable (Exam_ID, Exam_Name, Start_Date, End_Date, Reg_link) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("issss", $exam_id, $exam_name, $start_date, $end_date, $reg_link);

        if ($stmt->execute()) {
            echo "<script>alert('Exam timetable inserted successfully'); window.location.href='exam_timetable_create.html';</script>";
        } 
        $stmt->close();
    }

    $check->close();
    $conn->close();
?>
