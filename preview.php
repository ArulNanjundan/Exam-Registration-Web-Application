<?php
    include('base.php');
    include('application.html');
    echo "<br>";
    $name=$_POST['name'];
    $initial=$_POST['initial'];
    $father_name = (!empty($_POST['father_name'])) ? htmlspecialchars($_POST['father_name']) : '-';
    $mother_name = (!empty($_POST['mother_name'])) ? htmlspecialchars($_POST['mother_name']) : '-';
    $guardian_name=$_POST['guardian_name'] ;
    $religion=$_POST['RELIGION'] ;
    $gender=$_POST['GENDER'];
    $community=$_POST['COMMUNITY'] ;
    $mobile_no=$_POST['mobile_no'];
    $dob=$_POST['date'];
    $modifed_dob = date("d-m-Y", strtotime($dob));
    $street=$_POST['street'] ;
    $post=$_POST['post'] ;
    $district=$_POST['district'];
    $pin_no=$_POST['pin_no'];
    $full_address = "$street, $post, $district,"."TAMILNADU"." - $pin_no";
    echo "<center><table border='0' cellspacing='0' cellpadding='10' style='border-collapse: collapse; font-family: Arial; width: 50%;'>
            <tr><td>Name</td><td>- $name</td></tr>
            <tr><td>Initial</td><td>- $initial</td></tr>
            <tr><td>Father's Name</td><td>- $father_name</td></tr>
            <tr><td>Mother's Name</td><td>- $mother_name</td></tr>
            <tr><td>Guardian's Name</td><td>- $guardian_name</td></tr>
            <tr><td>Religion</td><td>- $religion</td></tr>
            <tr><td>Gender</td><td>- $gender</td></tr>
            <tr><td>Community</td><td>- $community</td></tr>
            <tr><td>Mobile Number</td><td>- $mobile_no</td></tr>
            <tr><td>Date of Birth</td><td>- $modifed_dob</td></tr>
            <tr><td>Address</td><td>- $full_address</td></tr>
          </table>
          </center>";
?>