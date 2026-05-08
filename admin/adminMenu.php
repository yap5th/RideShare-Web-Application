<?php

include '../global/session.php';
include '../global/dbConnection.php';

$username = $_SESSION['username'];

$query = "SELECT * FROM tbl_staff_info WHERE staff_username = '$username'";
$menu_result = mysqli_query($connection, $query);

if ($menu_result && mysqli_num_rows($menu_result) > 0) {
    $row = mysqli_fetch_assoc($menu_result);

    $_SESSION['fullname'] = $row['staff_name'];
    $_SESSION['ic_passport'] = $row['staff_ic_passport'];
    $_SESSION['gender'] = $row['staff_gender'];
    $_SESSION['dob'] = $row['staff_dob'];
    $_SESSION['contact'] = $row['staff_contact'];
    $_SESSION['email'] = $row['staff_email'];
} else {
    session_destroy();
    header("Location: ../index.php");
    exit();
}
?>

<header>
    <div onclick="showMenu('leftSideBar')" class="menuIcon"><i class="fa-solid fa-bars click-icon"></i></div>
    <div class="title">RideShare@APU</div>
</header>
<div class="menu-overlay" onclick="closeMenu('leftSideBar')"></div>
<div class="leftSideBar">
    <div class="closeButton">
         <i onclick="closeMenu('leftSideBar')" class="fa-solid fa-xmark click-icon"></i>
    </div>

    <a href="" class="profile">
        <div class="username"><?php echo htmlspecialchars($_SESSION['username'])?></div>
        <div class="fullname"><?php echo htmlspecialchars($_SESSION['fullname'])?></div>
    </a>

    <div class="line"></div>

    <nav class="menu">
        <ul>
            <li><a href="/RWDD_Assignment_Group10/admin/adminDashboard.php">Dashboard</a></li>
            <li><a href="/RWDD_Assignment_Group10/admin/adminUserManagement.php">Users</a></li>
            <li><a href="/RWDD_Assignment_Group10/admin/adminDriverManagement.php">Drivers</a></li>
            <li><a href="/RWDD_Assignment_Group10/admin/adminStaffManagement.php">Staff</a></li>
            <li><a href="/RWDD_Assignment_Group10/admin/adminLocation.php">Locations</a></li>
            <li><a href="/RWDD_Assignment_Group10/admin/adminReward.php">Rewards</a></li>
            <li><a href="/RWDD_Assignment_Group10/admin/adminAnnouncement.php">Announcements</a></li>
            <li><a href="/RWDD_Assignment_Group10/global/chat.php">Messages</a></li>
        </ul>
    </nav>

    <div class="logout">
        <a href="../logout.php">
            <button><i class="fa-solid fa-arrow-right-from-bracket"></i>   Logout</button>
        </a>
    </div>
</div>

<script src="../global/main.js"></script>