<?php
    session_start();
    include('base.php');

    require 'PHPMailer/src/Exception.php';
    require 'PHPMailer/src/PHPMailer.php';
    require 'PHPMailer/src/SMTP.php';

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        die("<script>alert('Form not submitted properly'); window.location.href='new_log.html';</script>");
    }

    $email = isset($_POST['user']) ? mysqli_real_escape_string($connection, trim($_POST['user'])) : '';
    $password = isset($_POST['current_password']) ? mysqli_real_escape_string($connection, trim($_POST['current_password'])) : '';
    $confirm_password = isset($_POST['confirm_password']) ? mysqli_real_escape_string($connection, trim($_POST['confirm_password'])) : '';

    $check_email_query = "SELECT * FROM user_login WHERE Email = '$email'";
    $result = mysqli_query($connection, $check_email_query);

    if (mysqli_num_rows($result) > 0) {
        die("<script>alert('If email already exists. Please use a different email.'); window.location.href='new_log.html';</script>");
    }
    $insert_user_query = "INSERT INTO user_login (Email, password, user_id) 
                        VALUES ('$email', '$password', 'user')";

    if (mysqli_query($connection, $insert_user_query)) {
        $_SESSION['email'] = $email;
        $_SESSION['logged_in'] = true;
        
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
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Registration Successful';
            $mail->Body = "<h2>Registration Successful</h2>
                <p>Your account has been created successfully.</p>
                <p><b>User Name (Email):</b> $email</p>
                <p><b>Password:</b> $password</p>
                <hr>
                <p>Please keep this information safe.</p>";

            $mail->send();
        
            echo "<script>window.location.href='user.html';</script>";
            exit();
        } 
        catch (Exception $e) {
            error_log('Email sending failed: ' . $mail->ErrorInfo);
            echo "<script>alert('Registration successful but email could not be sent.'); window.location.href='user.html';</script>";
            exit();
        }

    } 
    else {
        die("<script>alert('Registration failed: ".mysqli_error($connection)."'); window.history.back();</script>");
    }
?>
