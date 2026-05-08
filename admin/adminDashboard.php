<?php
include '../global/session.php';
include '../global/dbConnection.php';

// quick access request count
$requestCountQuery = "SELECT COUNT(*) AS total_requests FROM tbl_driver_request";
$requestCountResult = mysqli_query($connection, $requestCountQuery);
if (!$requestCountResult) {
    die("Query failed: " . mysqli_error($connection));
}
$row = mysqli_fetch_assoc($requestCountResult);
$totalRequestCount = $row['total_requests'];


// quick access update count
$updateCountQuery = "SELECT COUNT(*) AS total_updates FROM tbl_driver_update";
$updateCountResult = mysqli_query($connection, $updateCountQuery);
if (!$updateCountResult) {
    die("Query failed: " . mysqli_error($connection));
}
$row = mysqli_fetch_assoc($updateCountResult);
$totalUpdateCount = $row['total_updates'];


// quick access unread message count
$myUsername = $_SESSION['username'];
$unseenQuery = "SELECT COUNT(*) AS unseen_count FROM tbl_message WHERE message_receiver = '$myUsername' AND message_status = 'UNSEEN'";
$unseenResult = mysqli_query($connection, $unseenQuery);
if (!$unseenResult) {
    die("Query failed: " . mysqli_error($connection));
}
$row = mysqli_fetch_assoc($unseenResult);
$unseenMessageCount = $row['unseen_count'];


// quick access user count
$userCountQuery = "SELECT COUNT(*) AS user_count FROM tbl_login WHERE login_role='USER'";
$userCountResult = mysqli_query($connection, $userCountQuery);
if (!$userCountResult) {
    die("Query failed: " . mysqli_error($connection));
}
$userRow = mysqli_fetch_assoc($userCountResult);
$userCount = $userRow['user_count'];


// quick access driver count
$driverCountQuery = "SELECT COUNT(*) AS driver_count FROM tbl_login WHERE login_role='DRIVER'";
$driverCountResult = mysqli_query($connection, $driverCountQuery);
if (!$driverCountResult) {
    die("Query failed: " . mysqli_error($connection));
}
$driverRow = mysqli_fetch_assoc($driverCountResult);
$driverCount = $driverRow['driver_count'];


// quick access staff count
$staffCountQuery = "SELECT COUNT(*) AS staff_count FROM tbl_login WHERE login_role='STAFF'";
$staffCountResult = mysqli_query($connection, $staffCountQuery);
if (!$staffCountResult) {
    die("Query failed: " . mysqli_error($connection));
}
$staffRow = mysqli_fetch_assoc($staffCountResult);
$staffCount = $staffRow['staff_count'];


//total co2 saved
$co2Query = "
                SELECT
                    COALESCE(SUM(th.trip_co2_kg), 0) AS total_co2_saved,
                    COALESCE(SUM(CASE WHEN YEAR(ro.offer_date) = YEAR(CURDATE()) THEN th.trip_co2_kg ELSE 0 END), 0) AS yearly_co2_saved
                FROM tbl_trip_history th JOIN tbl_ride_offer ro ON th.trip_offer_id = ro.offer_id WHERE ro.offer_status = 'COMPLETE'
            ";

$result = mysqli_query($connection, $co2Query);
if (!$result) {
    die("Query failed: " . mysqli_error($connection));
}
$row = mysqli_fetch_assoc($result);
$totalCo2SavedKg   = $row['total_co2_saved'];     
$yearlyCo2SavedKg  = $row['yearly_co2_saved'];    

$co2GoalKg = 500;
$co2ProgressPercent = 0;
if ($co2GoalKg > 0) {
    $co2ProgressPercent = min(($yearlyCo2SavedKg / $co2GoalKg) * 100, 100);
}


// Average CO2 saved per trip
$avgCo2Query = " SELECT COALESCE(AVG(trip_co2_kg), 0) AS avg_co2_per_trip FROM tbl_trip_history";
$avgCo2Result = mysqli_query($connection, $avgCo2Query);
if (!$avgCo2Result) {
    die("Query failed: " . mysqli_error($connection));
}
$row = mysqli_fetch_assoc($avgCo2Result);
$avgCo2PerTripKg = $row['avg_co2_per_trip'];


// Top 3 popular locations by number of completed trips n total co2 saved
$topLocationsQuery = "
                        SELECT 
                            l.location_name,
                            COUNT(th.trip_id) AS total_trips,
                            SUM(th.trip_co2_kg) AS total_co2_saved_kg
                        FROM tbl_trip_history th
                        JOIN tbl_ride_offer ro ON th.trip_offer_id = ro.offer_id
                        JOIN tbl_location l ON ro.offer_location_id = l.location_id
                        WHERE l.location_status = 'ACTIVE'
                        AND ro.offer_status = 'COMPLETE'
                        GROUP BY l.location_id, l.location_name
                        ORDER BY total_trips DESC
                        LIMIT 3
                    ";

$topLocationsResult = mysqli_query($connection, $topLocationsQuery);
if (!$topLocationsResult) {
    die("Query failed: " . mysqli_error($connection));
}


//Total reward
$totalRewardsQuery = "SELECT COUNT(*) AS total_rewards FROM tbl_reward WHERE reward_status = 'ACTIVE'";

$result = mysqli_query($connection, $totalRewardsQuery);
if (!$result) {
    die('Query failed: ' . mysqli_error($connection));
}

$row = mysqli_fetch_assoc($result);
$totalRewards = (int)$row['total_rewards'];



// Reward Use Rate (USED / TOTAL REDEEMED)
$rewardUseRateQuery = "SELECT SUM(CASE WHEN redeem_status = 'USED' THEN 1 ELSE 0 END) AS total_used_rewards, COUNT(*) AS total_redeemed_rewards FROM tbl_redeem";

$rewardUseRateResult = mysqli_query($connection, $rewardUseRateQuery);
if (!$rewardUseRateResult) {
    die('Query failed: ' . mysqli_error($connection));
}
$row = mysqli_fetch_assoc($rewardUseRateResult);

$totalUsedRewards = (int)$row['total_used_rewards'];
$totalRedeemedRewards = (int)$row['total_redeemed_rewards'];

$rewardUseRate = 0;
if ($totalRedeemedRewards > 0) {
    $rewardUseRate = round(($totalUsedRewards / $totalRedeemedRewards) * 100, 2);
}


//annoucenemnt
$totalAnnouncementQuery = "SELECT COUNT(*) AS total_announcements, SUM(CASE WHEN announcement_status = 'ACTIVE' THEN 1 ELSE 0 END) AS active_announcements FROM tbl_announcement";
$totalAnnouncementResult = mysqli_query($connection, $totalAnnouncementQuery);
if (!$totalAnnouncementResult) {
    die('Query failed: ' . mysqli_error($connection));
}
$row = mysqli_fetch_assoc($totalAnnouncementResult);
$totalAnnouncements = (int)$row['total_announcements'];
$activeAnnouncements = (int)$row['active_announcements'];



?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin Dashboard</title>
        <link rel="stylesheet" href="../global/main.css">
        <link rel="stylesheet" href="../global/footer.css">
        <link rel="stylesheet" href="../global/menu.css">
        <link rel="stylesheet" href="admin.css">
        <link rel="stylesheet" href="adminDashboard.css">

        <!-- Font Style for RideShare@APU Logo -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Bowlby+One&family=Ultra&display=swap" rel="stylesheet">
        
        <!-- Icon -->
        <link 
            rel="stylesheet" 
            href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" 
            integrity="sha512-..."
            crossorigin="anonymous"
            referrerpolicy="no-referrer"
        />

    </head>
    <body>
        <?php include 'adminMenu.php'; ?>
        <main>
            <div class="page-container">
                <div class="page-header card">
                    <div class="page-header-title">
                        <h1 class="menu-title flex-icon"> <i class="fa-solid fa-hand-peace"></i>Welcome back, <?php echo htmlspecialchars($_SESSION['fullname'])?></h1>
                        <p>Everything you need, in one place.</p>
                    </div>
                </div>

                <h2 class="dashboard-title"><i class="fa-solid fa-wave-square"></i> System Overview</h2>
                <div class="card-container" id="card-container">

                    <div class="dashboard-card">
                        <div class="layer-one layer">
                            <a href="../global/chat.php">
                                <div class="quick-access-message card">
                                    <i class="fa-solid fa-location-arrow quick-access-btn"></i>
                                    <div class="quick-access-icon"><i class="fa-solid fa-comments"></i></div>
                                    <div class="quick-access-content">
                                        <span class="dashboard-small-title">Messages</span>
                                        <spap class="quick-access-content-info">Ding dong! You have <?= $unseenMessageCount ?> unread message<?= $unseenMessageCount != 1 ? 's' : '' ?></span>
                                    </div>
                                </div>
                            </a>

                            <a href="adminDriverManagement.php?tab=update">
                                <div class="quick-access-driver-update card">
                                    <i class="fa-solid fa-location-arrow quick-access-btn"></i>
                                    <div class="quick-access-icon"><i class="fa-solid fa-upload"></i></div>
                                    <div class="quick-access-content">
                                        <span class="dashboard-small-title">Driver Updates</span>
                                        <spap class="quick-access-content-info">You have <?= $totalUpdateCount ?> pending vehicle update request<?= $totalUpdateCount != 1 ? 's' : '' ?></span>
                                    </div>
                                </div>
                            </a>

                            <a href="adminDriverManagement.php?tab=request">
                                <div class="quick-access-driver-request card">
                                    <i class="fa-solid fa-location-arrow quick-access-btn"></i>
                                    <div class="quick-access-icon"><i class="fa-solid fa-car-on"></i></div>
                                    <div class="quick-access-content">
                                        <span class="dashboard-small-title">Driver Request</span>
                                        <spap class="quick-access-content-info">You have <?= $totalRequestCount ?> pending driver registration request<?= $totalRequestCount != 1 ? 's' : '' ?></span>
                                    </div>
                                </div>
                            </a>
                            


                            <div class="quick-access-all-user">
                                <a href="adminUserManagement.php">
                                    <div class="user-user card">
                                        <span><i class="fa-solid fa-user-group"></i></span>
                                        <span class="user-count-label"><?= $userCount ?> Users</span>
                                        <span class="user-count-arrow-icon"><i class="fa-solid fa-right-long"></i></span>
                                    </div>
                                </a>

                                <a href="adminDriverManagement.php">
                                    <div class="user-driver card">
                                        <span><i class="fa-regular fa-address-card"></i></span>
                                        <span class="user-count-label"><?= $driverCount ?> Drivers</span>
                                        <span class="user-count-arrow-icon"><i class="fa-solid fa-right-long"></i></span>
                                    </div>
                                </a>

                                <a href="adminStaffManagement.php">
                                    <div class="user-staff card">
                                        <span><i class="fa-solid fa-user-tie"></i></span>
                                        <span class="user-count-label"><?= $staffCount ?> Staff</span>
                                        <span class="user-count-arrow-icon"><i class="fa-solid fa-right-long"></i></span>
                                    </div>
                                </a>
                            </div>

                        </div>
                        

                        <div class="layer-two layer">
                            <div class="dashboard-co2 card">
                                <span class="dashboard-big-title"><i class="fa-solid fa-cloud"></i> CO<sub>2</sub> Overview</span>
                                <div class="dashboard-co2-upper">
                                    <div class="co2-saved card">
                                        <span class="dashboard-small-title">Total CO<sub>2</sub> Saved</span>
                                        <span class="card-value"><?= number_format($totalCo2SavedKg, 2) ?> Kg <div class="line"></div></span>
                                    </div>
                                    <div class="co2-saved card">
                                        <span class="dashboard-small-title">CO<sub>2</sub> Saved / Trip</span>
                                        <span class="card-value"><?= number_format($avgCo2PerTripKg, 2) ?> Kg <div class="line"></div></span>
                                    </div>
                                </div>

                                <div class="dashboard-co2-progress">
                                    <span class="dashboard-small-title">
                                        2026 CO<sub>2</sub> Goal Progress
                                        <div class="line"></div>
                                    </span>

                                    <div class="co2-progress">
                                        <div class="co2-progress-bar"
                                            style="width: <?= $co2ProgressPercent ?>%;"></div>
                                        </div>
                                        <div class="co2-progress-meta">
                                            <span><?= number_format($co2ProgressPercent, 1) ?>% achieved</span>
                                            <span class="co2-goal-value"> Goal: <?= number_format($co2GoalKg, 0) ?> kg</span>
                                        </div>
                                    </div>
                                </div>


                            <div class="darshboard-location card">
                                <span class="dashboard-big-title">
                                    <i class="fa-solid fa-ranking-star"></i> Popular Locations
                                </span>
                                
                                <?php
                                $rank = 1;
                                while ($row = mysqli_fetch_assoc($topLocationsResult)) {
                                    $locationName = htmlspecialchars($row['location_name']);
                                    $totalCo2 = number_format($row['total_co2_saved_kg'], 2);
                                    ?>
                                    <div class="popular-location card">
                                        <div class="location-rank"><?= $rank ?></div>
                                        <div class="location-info">
                                            <span class="location-name"><?= $locationName ?></span>
                                            <div class="line"></div>
                                            <span class="location-co2">Saved <?= $totalCo2 ?> kg (<?= $row['total_trips'] ?> rides)</span>
                                        </div>
                                    </div>
                                    <?php
                                    $rank++;
                                }
                                ?>
                            </div>
            

                            <div class="dashboard-right">
                                <div class="darshboard-reward card">
                                    <span class="dashboard-big-title"><i class="fa-solid fa-gift"></i> Reward Overview</span>
                                    <div class="reward-card-container">
                                        <div class="reward-rate card">
                                            <span class="dashboard-small-title">Total Rewards</span>
                                            <span class="card-value"><?= $totalRewards ?> <div class="line"></div></span>
                                        </div>
                                        <div class="reward-rate card">
                                            <span class="dashboard-small-title">Used Rate</span>
                                            <span class="card-value"><?= number_format($rewardUseRate, 2) ?> % <div class="line"></div></span>
                                        </div>
                                    </div>


                                </div>
                                <div class="darshboard-announcement card">
                                    <span class="dashboard-big-title"><i class="fa-solid fa-scroll"></i> Annoucement Overview</span>
                                    <div class="announcement-quantity">
                                         <span class="card-value"><?= $totalAnnouncements ?></span> announcements  <span class="card-value"><?= $activeAnnouncements ?></span> active 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div


                    
                </div> 
            </div> 
        </main>
        <?php include '../global/footer.php'; ?>
    </body>
</html>