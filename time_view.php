<?php
$server = "localhost";
$user = "root";
$password = "root";
$db = "mini_registration";
include('application.html');

$conn = new mysqli($server, $user, $password, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$current_date = date('Y-m-d');
$delete_sql = "DELETE FROM exam_timetable WHERE STR_TO_DATE(End_Date, '%Y-%m-%d') < ?";
$delete_stmt = $conn->prepare($delete_sql);
$delete_stmt->bind_param("s", $current_date);
$delete_stmt->execute();
$delete_stmt->close();

$sql = "SELECT Exam_ID, Exam_Name, Start_Date, End_Date FROM exam_timetable";
$result = $conn->query($sql);

echo "
<!DOCTYPE html>
<html>
<head>
    <title>Exam Timetable</title>
    <link rel='stylesheet' href='time_view.css'>
</head>
<body>
    <div class='table-container'>
        <h2>Exam Timetable</h2>
        <table>
            <tr>
                <th>Exam ID</th>
                <th>Exam Name</th>
                <th>Exam Start Date</th>
                <th>Exam End Date</th>
            </tr>";

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $start_date = date('d-m-Y', strtotime($row['Start_Date']));
        $end_date = date('d-m-Y', strtotime($row['End_Date']));

        echo "<tr>
                <td>{$row['Exam_ID']}</td>
                <td>{$row['Exam_Name']}</td>
                <td>{$start_date}</td>
                <td>{$end_date}</td>
            </tr>";
    }
} else {
    echo "<tr><td colspan='4'>No details found in Examination Timetable</td></tr>";
}

echo "</table>
    </div>
</body>
</html>";

$conn->close();
?>
