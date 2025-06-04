<?php
    session_start();
    include('base.php');

    $user_name = mysqli_real_escape_string($connection, $_POST['user_name']);
    $password = mysqli_real_escape_string($connection, $_POST['password']);

    $query = "SELECT Email, password, user_id FROM user_login WHERE Email = '$user_name'";
    $result = mysqli_query($connection, $query);

    if (!$result) {
        die("<script>alert('Database error'); window.location.href='login.html';</script>");
    }

    if (mysqli_num_rows($result) == 0) {
        die("<script>alert('User Name not register.Plz Register First'); window.location.href='login.html';</script>");
    }

    $user = mysqli_fetch_assoc($result);

    if ($password !== $user['password']) {
        die("<script>alert('Invalid email or password'); window.location.href='login.html';</script>");
    }

    $_SESSION['logged_in'] = true;
    $_SESSION['email'] = $user['Email'];
    $_SESSION['user_type'] = $user['user_id'];

    switch ($user['user_id']) {
        case 'admin':
            header("Location: admin.html");
            exit(); 
        case 'admin_2':
            header("Location: admin_2.html");
            exit();
        case 'user':
            header("Location: user.html");
            exit();
    }
?>
