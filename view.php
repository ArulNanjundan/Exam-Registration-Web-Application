<?php
$server = "localhost";
$user = "root";
$password = "root";
$db = "mini_registration";
include('application.html');

$connection = mysqli_connect($server, $user, $password, $db);

$sql = "SELECT Application_no, Name, Initial, Father_Name, Mother_Name, Guardian_Name, Religion, Gender, Community, Mobile_number, DOB, Street, Post, District, Pin_code,Exam_Name FROM registration";

echo "<!DOCTYPE html>
    <html>
    <head>
        <link rel='stylesheet' href='view.css'>
    </head>
    <body>
        <h2>Applications Details</h2>
        <center>
        <table border='1'>
            <tr>
                <th>Application No</th>
                <th>Exam Category</th>
                <th>Name</th>
                <th>Father Name</th>
                <th>Mother Name</th>
                <th>Guardian Name</th>
                <th>Religion</th>
                <th>Gender</th>
                <th>Community</th>
                <th>Mobile Number</th>
                <th>DOB</th>
                <th>Address</th>
            </tr>";
    if ($res = $connection->query($sql)) {
        if ($res->num_rows > 0) {
            while ($row = $res->fetch_object()) {
                $modified_dob = date("d.m.Y", strtotime($row->DOB));
                $modified_mobile = preg_replace('/^(\+91)/', '', $row->Mobile_number);
                $full_name = $row->Name . " " . $row->Initial;
                $address = $row->Street . ", " . $row->Post . ", " . $row->District.",TAMILNADU" . " - " . $row->Pin_code;

                echo "<tr>
                        <td>{$row->Application_no}</td>
                        <td>{$row->Exam_Name}</td>
                        <td>{$full_name}</td>
                        <td>{$row->Father_Name}</td>
                        <td>{$row->Mother_Name}</td>
                        <td>{$row->Guardian_Name}</td>
                        <td>{$row->Religion}</td>
                        <td>{$row->Gender}</td>
                        <td>{$row->Community}</td>
                        <td>{$modified_mobile}</td>
                        <td>{$modified_dob}</td>
                        <td>{$address}</td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='12' class='no-data'>No data in table.</td></tr>";
        }
    }

    echo "</table>
    </center>
    </body>
    </html>";
?>
