<?php
include 'global/session.php';
include 'global/dbConnection.php';

$message = ['login' => "Invalid username or password"]; 
if (isset($_POST['txtUsername']) && isset($_POST['txtPassword'])) {
    $username = $_POST['txtUsername'];
    $password = $_POST['txtPassword'];

    $stmt = mysqli_prepare($connection, "SELECT * FROM tbl_login WHERE login_username = ?");
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $hashedPassword = $row['login_password'];

        if ($row['login_status'] === 'ACTIVE') {
            if (password_verify($password, $hashedPassword)) {
                $_SESSION['username'] = $username;
                $_SESSION['role'] = $row['login_role'];
                $message = ['success' => true];

                if ($row['login_role'] == 'ADMIN') {
                    $message['redirect'] = 'admin/adminDashboard.php';
                } elseif ($row['login_role'] == 'DRIVER') {
                    $message['redirect'] = 'driver/driverMain.php';
                } elseif ($row['login_role'] == 'USER') {
                    $message['redirect'] = 'user/searchRides.php';
                } else {
                    $message['redirect'] = 'staff/staff_Dashboard.php';
                }
            }
        } else {
            $message['login'] = "Account restricted. Please call customer support";
        }
    }
    mysqli_stmt_close($stmt);
}
echo json_encode($message);
exit();

?>