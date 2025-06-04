<?php
    $server = "localhost";
    $user = "root";
    $password = "root";
    $db = "mini_registration";
    $connection = mysqli_connect($server, $user, $password, $db);

    include('application.html');

    if (!$connection) {
        die("<script>alert('Database connection failed'); window.location.href='application.html';</script>");
    }

    $search = trim($_POST['search']);
    $raw_number = ltrim($search, '0') ?: '0';

    if (!($search === '')) {
        $check_column = "SHOW COLUMNS FROM registration LIKE 'Exam_Name'";
        $column_result = mysqli_query($connection, $check_column);

        if (mysqli_num_rows($column_result) > 0) {
            $sql = "SELECT Application_no, Name, Initial, Father_name, Mother_name, Guardian_name, 
                        Religion, Gender, Community, Mobile_number, DOB, 
                        Street, Post, District, Pin_code, Exam_Name 
                    FROM registration 
                    WHERE Application_no = ?";
        } 
        else {
            $sql = "SELECT Application_no, Name, Initial, Father_name, Mother_name, Guardian_name, 
                        Religion, Gender, Community, Mobile_number, DOB, 
                        Street, Post, District, Pin_code 
                    FROM registration 
                    WHERE Application_no = ?";
        }

        $stmt = mysqli_prepare($connection, $sql);
        if (!$stmt) {
            die("<script>alert('Database error'); window.location.href='application.html';</script>");
        }

        mysqli_stmt_bind_param($stmt, "s", $raw_number);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) > 0) {
            
            if (mysqli_num_rows($column_result) > 0) {
                mysqli_stmt_bind_result($stmt, $app_no, $name, $initial, $father, $mother, $guardian, 
                                        $religion, $gender, $community, $mobile, $dob, 
                                        $street, $post, $district, $pincode, $exam_name);
            } else {
                mysqli_stmt_bind_result($stmt, $app_no, $name, $initial, $father, $mother, $guardian, 
                                        $religion, $gender, $community, $mobile, $dob, 
                                        $street, $post, $district, $pincode);
            }

            mysqli_stmt_fetch($stmt);

            $modified_name = htmlspecialchars("$name.$initial");
            $modified_dob = date("d.m.Y", strtotime($dob));
            $modified_mobile = preg_replace('/^(\+91)/', '', $mobile);
            $full_address = htmlspecialchars("$street, $post, $district,TAMILNADU - $pincode");

            echo "<center><table border='0' cellspacing='5' cellpadding='10' style='border-collapse: collapse;'>
                    <tr><th colspan='2' style='font-size:21px;'>Application</th></tr>
                    <tr><td><strong>Application No</strong></td><td>" . str_pad($app_no, 6, '0', STR_PAD_LEFT) . "</td></tr>
                    <tr><td><strong>Name</strong></td><td>$modified_name</td></tr>
                    <tr><td><strong>Father's Name</strong></td><td>" . htmlspecialchars($father) . "</td></tr>
                    <tr><td><strong>Mother's Name</strong></td><td>" . htmlspecialchars($mother) . "</td></tr>
                    <tr><td><strong>Guardian's Name</strong></td><td>" . htmlspecialchars($guardian) . "</td></tr>
                    <tr><td><strong>Religion</strong></td><td>" . htmlspecialchars($religion) . "</td></tr>
                    <tr><td><strong>Gender</strong></td><td>" . htmlspecialchars($gender) . "</td></tr>
                    <tr><td><strong>Community</strong></td><td>" . htmlspecialchars($community) . "</td></tr>
                    <tr><td><strong>Mobile Number</strong></td><td>$modified_mobile</td></tr>
                    <tr><td><strong>Date of Birth</strong></td><td>$modified_dob</td></tr>
                    <tr><td><strong>Address</strong></td><td>$full_address</td></tr>";

            if (mysqli_num_rows($column_result) > 0) {
                echo "<tr><td><strong>Exam Name</strong></td><td>" . htmlspecialchars($exam_name) . "</td></tr>";
            }

            echo "</table></center>";
        } else {
            echo "<script>alert('Not Available the Application Number');window.location.href='search_admin.html';</script>";
        }
    } else {
        echo "<script>window.location.href='search_admin.html';</script>";
    }

    mysqli_stmt_close($stmt);
    mysqli_close($connection);
?>
