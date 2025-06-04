<?php
    session_start();
    include('base.php');

    if (!isset($_SESSION['Email']) || !isset($_SESSION['app_id'])) {
        header("Location: register.html");
        exit();
    }

    $email = $_SESSION['Email'];
    $name = $_SESSION['user_name'];
    $app_id = $_SESSION['app_id'];

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    require 'PHPMailer/src/PHPMailer.php';
    require 'PHPMailer/src/SMTP.php';
    require 'PHPMailer/src/Exception.php';

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'arulnanjundan@gmail.com';
        $mail->Password = 'mroy rjgm jtmf kprs';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;

        $mail->setFrom('arulnanjundan@gmail.com', 'Application System');
        $mail->addAddress($email, $name);

        $mail->isHTML(true);
        $mail->Subject = 'Application Registration Successful';
        $mail->Body = "
            <h3>Dear $name,</h3>
            <p>Your application has been registered successfully!</p>
            <p><strong>Application Number:</strong> APP$app_id</p>
            <p>Thank you for the Registration.All best for Your Examination,Do ur best.</p>";
        $mail->AltBody = "Dear $name,\nYour application (APP$app_id) has been registered successfully!";

        $mail->send();

        session_unset();
        session_destroy();
        echo "<script>alert('Registration complete! Confirmation email sent.');</script>";
        echo "<script>window.location.href='welcome.php';</script>";

    } catch (Exception $e) {
        echo "<script>alert('Registration complete but email failed: ".addslashes($e->getMessage())."');</script>";
        echo "<script>window.location.href='welcome.php';</script>";
    }
?>