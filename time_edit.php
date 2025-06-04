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
$reg_link = 'Register Here';

$check = $conn->prepare("SELECT Exam_ID FROM exam_timetable WHERE Exam_ID = ?");
$check->bind_param("i", $exam_id);
$check->execute();
$check->store_result();

if ($check->num_rows > 0) {

    if ($start_date && $end_date) {
        $stmt = $conn->prepare("UPDATE exam_timetable SET Exam_Name = ?, Start_Date = ?, End_Date = ?, Reg_link = ? WHERE Exam_ID = ?");
        $stmt->bind_param("ssssi", $exam_name, $start_date, $end_date, $reg_link, $exam_id);
    } 
    elseif ($start_date) {
        $stmt = $conn->prepare("UPDATE exam_timetable SET Exam_Name = ?, Start_Date = ?, Reg_link = ? WHERE Exam_ID = ?");
        $stmt->bind_param("sssi", $exam_name, $start_date, $reg_link, $exam_id);
    } 
    
    elseif ($end_date) {
        $stmt = $conn->prepare("UPDATE exam_timetable SET Exam_Name = ?, End_Date = ?, Reg_link = ? WHERE Exam_ID = ?");
        $stmt->bind_param("sssi", $exam_name, $end_date, $reg_link, $exam_id);
    }

    if ($stmt->execute()) {
        echo "<script>alert('Exam timetable updated successfully'); window.location.href='time_edit.html';</script>";
    }

    $stmt->close();
} else {
    echo "<script>alert('Exam not found. Register the examination details first.'); window.location.href='time_edit.html';</script>";
}

$check->close();
$conn->close();
?>
