<?php
    session_start();
    include('base.php');

    if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
        die("<script>alert('Unauthorized access. Only Admin can add Admin_2 users.'); window.location.href='login.html';</script>");
    }

    require 'PHPMailer/src/Exception.php';
    require 'PHPMailer/src/PHPMailer.php';
    require 'PHPMailer/src/SMTP.php';

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    $email = mysqli_real_escape_string($connection, $_POST['user']);
    $password = mysqli_real_escape_string($connection, $_POST['current_password']);

    $check_query = "SELECT * FROM user_login WHERE email = '$email'";
    $check_result = mysqli_query($connection, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        die("<script>alert('Email already exists'); window.history.back();</script>");
    }

    $insert_query = "INSERT INTO user_login (Email, password, user_id) VALUES ('$email', '$password', 'admin_2')";

    if (mysqli_query($connection, $insert_query)) {

        $mail = new PHPMailer(true);
        
        try {
        
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'arulnanjundan@gmail.com'; 
            $mail->Password = 'mroy rjgm jtmf kprs';  
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = 465;
            $mail->SMTPDebug = 0;
            $mail->Timeout = 30;

            $mail->setFrom('your_email@gmail.com', 'Government Examinations');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Admin Account Created';
            $mail->Body = "<h2>Admin Account Created Successfully</h2>
                <p>Congratulations! You have been added as Admin.</p>
                <p><strong>Login Details:</strong></p>
                <p>Email: $email</p>
                <p>Password: $password</p>";

            $mail->send();
            echo "<script>alert('Admin added successfully. Confirmation email sent.'); window.location.href='admin.html';</script>";
        } 
        catch (Exception $e) {
            echo "<script>alert('Admin added but email could not be sent. Error: {$mail->ErrorInfo}'); window.location.href='admin_2.html';</script>";
        }
    } 
    else {
        die("<script>alert('Error adding Admin: " . mysqli_error($connection) . "'); window.history.back();</script>");
    }
?>
