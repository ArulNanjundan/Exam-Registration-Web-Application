<?php
    session_start();
    include('base.php');

    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }

    include('application.html');

    $sql = "SELECT Exam_ID, Exam_Name, Start_Date, End_Date FROM exam_timetable";
    $result = $connection->query($sql);


    echo "<!DOCTYPE html>
    <html>
    <head>
        <link rel='stylesheet' href='exam_reg.css'>
    </head>
    <body>

    <h2 style='text-align: center;'>Exam Registration</h2>
    <center>
    <table border='1' cellpadding='10'>
        <tr>
            <th>Exam ID</th>
            <th>Exam Name</th>
            <th>Exam Date</th>
            <th>Exam Time</th>
            <th>Register Link</th>
        </tr>";

    $current_date = date('d-m-Y');

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $exam_id = urlencode($row['Exam_ID']);
            $start_date = date('d-m-Y', strtotime($row['Start_Date']));
            $end_date = date('d-m-Y', strtotime($row['End_Date']));
            if ($current_date >= $start_date && $current_date <= $end_date) {
                echo "<tr>
                        <td>{$row['Exam_ID']}</td>
                        <td>{$row['Exam_Name']}</td>
                        <td>{$start_date}</td>
                        <td>{$end_date}</td>
                        <td><a class='btn-register' href='reg_1.php?exam_id={$exam_id}'>Register</a></td>
                    </tr>";
            } 
            else {
                echo "<tr>
                        <td>{$row['Exam_ID']}</td>
                        <td>{$row['Exam_Name']}</td>
                        <td>{$start_date}</td>
                        <td>{$end_date }</td>
                        <td><span style='color:red;'>Registration Soon</span></td>
                    </tr>";
            }
        }
    } 
    else {
        echo "<tr><td colspan='5'>No exam records found.</td></tr>";
    }
    $connection->close();

    echo "</table>
    </center>
    </body>
    </html>";
?>
