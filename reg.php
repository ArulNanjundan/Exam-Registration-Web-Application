<?php
    session_start();
    include('base.php');

    if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in'] || !isset($_SESSION['email'])) {
        header("Location: new_log.html");
        exit();
    }

    require 'PHPMailer/src/Exception.php';
    require 'PHPMailer/src/PHPMailer.php';
    require 'PHPMailer/src/SMTP.php';

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    $email = $_SESSION['email'];
    $exam_name = $_SESSION['exam_name'];

    $check_query = "SELECT * FROM registration WHERE emaill = '$email' AND Exam_Name = '$exam_name'";
    $check_result = mysqli_query($connection, $check_query);

    if (!$check_result) {
        die("<script>alert('Database error: ".mysqli_error($connection)."'); window.history.back();</script>");
    }

    if (mysqli_num_rows($check_result) > 0) {
        die("<script>alert('You have already registered for this exam'); window.location.href='user.html';</script>");
    }

    $get_last_app_no = "SELECT LPAD(MAX(Application_no), 6, '0') as last_no FROM registration";
    $result = mysqli_query($connection, $get_last_app_no);
    $row = mysqli_fetch_assoc($result);
    $next_no = ($row['last_no']) ? intval($row['last_no']) + 1 : 1;
    $app_number = str_pad($next_no, 6, '0', STR_PAD_LEFT);

    $name = mysqli_real_escape_string($connection, $_POST['name']);
    $initial = mysqli_real_escape_string($connection, $_POST['initial']);
    $father_name = mysqli_real_escape_string($connection, $_POST['father_name'] ?? '-');
    $mother_name = mysqli_real_escape_string($connection, $_POST['mother_name'] ?? '-');
    $guardian_name = mysqli_real_escape_string($connection, $_POST['guardian_name']);
    $religion = mysqli_real_escape_string($connection, $_POST['RELIGION']);
    $gender = mysqli_real_escape_string($connection, $_POST['GENDER']);
    $community = mysqli_real_escape_string($connection, $_POST['COMMUNITY']);
    $mobile = '+91' . preg_replace('/[^0-9]/', '', $_POST['mobile_no']);
    $dob = date('Y-m-d', strtotime($_POST['date']));
    $street = mysqli_real_escape_string($connection, $_POST['street']);
    $post = mysqli_real_escape_string($connection, $_POST['post'] ?? '');
    $district = mysqli_real_escape_string($connection, $_POST['district']);
    $pin_no = mysqli_real_escape_string($connection, $_POST['pin_no']);

    $query = "INSERT INTO registration 
            (Application_no, Name, Initial, Father_name, Mother_name, Guardian_name, 
            Religion, Gender, Community, Mobile_number, DOB, Street, Post, District, 
            Pin_code, emaill, Exam_Name) 
            VALUES 
            ('$app_number', '$name', '$initial', '$father_name', '$mother_name', '$guardian_name',
            '$religion', '$gender', '$community', '$mobile', '$dob', '$street', '$post', '$district', 
            '$pin_no', '$email', '$exam_name')";

    if (mysqli_query($connection, $query)) {

        $cred_query = "SELECT email, password FROM user_login WHERE email = '$email' LIMIT 1";
        $cred_result = mysqli_query($connection, $cred_query);

        if ($cred_result && mysqli_num_rows($cred_result) > 0) {
            $cred_row = mysqli_fetch_assoc($cred_result);
            $user_email = $cred_row['email'];
            $user_password = $cred_row['password'];

            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'arulnanjundan@gmail.com';
                $mail->Password = 'mroy rjgm jtmf kprs';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                $mail->Port = 465;

                $mail->setFrom('arulnanjundan@gmail.com', 'Exam Registration System');
                $mail->addAddress($user_email);

                $mail->isHTML(true);
                $mail->Subject = 'Exam Registration Confirmation';
                $mail->Body = "<h2>Exam Registration Confirmation</h2>
                    <p><strong>Application Number:</strong> $app_number</p>
                    <p><strong>Name:</strong> $name.$initial</p>
                    <p><strong>Exam Name:</strong> $exam_name</p>
                    <p><strong>Registered Email:</strong> $user_email</p>
                    <p><strong>Password:</strong> $user_password</p>
                    <hr>
                    <p>Thank you for registering. Please keep this application number for future reference.</p>";

                $mail->send();
                echo "<script>alert('Registration successful! Application No: $app_number'); window.location.href='user.html';</script>";
                exit();
            } catch (Exception $e) {
                error_log("Email sending failed: " . $mail->ErrorInfo);
                echo "<script>alert('Registration successful but email could not be sent'); window.location.href='user.html';</script>";
                exit();
            }
        } 
        else {
            echo "<script>alert('Registration successful but could not fetch your login details'); window.location.href='user.html';</script>";
            exit();
        }
    } 
    else {
        die("<script>alert('Registration failed: ".mysqli_error($connection)."'); window.history.back();</script>");
    }
?>
