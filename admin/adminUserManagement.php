<?php 
include '../global/dbConnection.php';

//Fetch Data (View user activity)
if (isset($_GET['fetchUsername'])) {
    $username = $_GET['fetchUsername'];

    $commentsQuery = "
                        SELECT 
                            review_rating,
                            review_comment,
                            review_created_at,
                            review_status
                        FROM tbl_review
                        WHERE review_passenger_username = '$username'
                    ";

    $commentsResult = mysqli_query($connection, $commentsQuery);
    if (!$commentsResult) {
        die("Comments query failed: " . mysqli_error($connection));
    }
    $comments = mysqli_fetch_all($commentsResult, MYSQLI_ASSOC);

    $rewardsQuery = " SELECT  r.reward_title, rd.redeem_redeemed_at, rd.redeem_status FROM tbl_redeem rd 
                        JOIN tbl_reward r ON rd.redeem_reward_id = r.reward_id
                        WHERE rd.redeem_username = '$username'
                    ";
    $rewardsResult = mysqli_query($connection, $rewardsQuery);
    if (!$rewardsResult) {
        die("Rewards query failed: " . mysqli_error($connection));
    }

    $rewards = mysqli_fetch_all($rewardsResult, MYSQLI_ASSOC);

    echo json_encode(['comments' => $comments, 'rewards'  => $rewards]);
    exit;
}

$userQuery = "SELECT u.user_username, u.user_name, u.user_ic_passport, u.user_dob, u.user_gender, 
              u.user_contact, u.user_email, u.user_green_point, u.user_co2_kg, u.user_balance, 
              l.login_role, l.login_status FROM tbl_user_info u INNER JOIN tbl_login l 
              ON u.user_username = l.login_username WHERE l.login_role = 'USER' 
              ORDER BY u.user_username ASC";
$userResult = mysqli_query($connection, $userQuery);
if (!$userResult) {
    die("Query failed: " . mysqli_error($connection));
}

?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>User Management</title>
        <link rel="stylesheet" href="../global/main.css">
        <link rel="stylesheet" href="../global/footer.css">
        <link rel="stylesheet" href="../global/menu.css">

        <!-- Font Style for RideShare@APU Logo -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Bowlby+One&family=Ultra&display=swap" rel="stylesheet">
        
        <!-- Icon for Footer -->
        <link 
            rel="stylesheet" 
            href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" 
            integrity="sha512-..."
            crossorigin="anonymous"
            referrerpolicy="no-referrer"
        />

        <link rel="stylesheet" href="admin.css">
        <link rel="stylesheet" href="searchBar.css">
        <link rel="stylesheet" href="adminEntityManagement.css">


    </head>
    <body>
        <?php include 'adminMenu.php'; ?>
        <main>
            <div class="page-container">
                <div class="page-header card">
                    <div class="page-header-title">
                        <h1 class="menu-title flex-icon"> <i class="fa-regular fa-user"></i>User Management</h1>
                        <p>Monitor and control rider account permissions</p>
                    </div>
                    <div class="page-header-action">
                        <?php include 'searchBar.php'; ?>
                    </div>
                </div>  

                <div class="card-container" id="card-container">
                    <?php while($row = mysqli_fetch_assoc($userResult)): ?>
                        <div class="user-card card searchable-card" style="border-left: <?= $row['login_status'] === 'BLOCKED' ? '4px solid var(--error-red)' : '4px solid var(--light-green)' ?>;">
                            <i class="fa-solid fa-circle-arrow-down click-icon view-user-btn"></i>
                            <div class="user-card-body">
                                <div class="user-contact">
                                    <span data-searchable class="username"><?= $row['user_username']?></span>
                                    <div class="user-name-status">
                                        <p data-searchable><?= $row['user_name']?></p>
                                        <div class="status">
                                            <i class="status-icon"></i>
                                            <span class="status-text status-label"><?= htmlspecialchars($row['login_status']) ?></span>
                                        </div>
                                    </div>
                                    <p class="flex-icon"><i class="fa-solid fa-phone"></i><?= $row['user_contact']?></p>
                                    <p data-searchable class="flex-icon"><i class="fa-solid fa-envelope"></i><?= $row['user_email']?></p>
                                </div>

                                <div class="user-personal-info">
                                    <table class="user-table-style">
                                        <tr>
                                            <th><span class="label"><i class="fa-solid fa-id-card-clip"></i> IC / Passport:</span></th>
                                            <td><span class="value"><?= $row['user_ic_passport'] ?></span></td>

                                        </tr>
                                        <tr>
                                            <th><span class="label"><i class="fa-solid fa-venus-mars"></i> Gender:</span></th>
                                            <td><span class="value"><?= $row['user_gender'] ?></span></td>
                                        </tr>
                                        <tr>
                                            <th><span class="label"><i class="fa-regular fa-calendar-days"></i> Date of Birth:</span></th>
                                            <td><span class="value"><?= $row['user_dob'] ?></span></td>
                                        </tr>
                                    </table>
                                </div>

                                <div class="user-matrics-info">
                                    <table class="user-table-style">
                                        <tr>
                                            <th><span class="label"><i class="fa-solid fa-star"></i> Green Points:</span></th>
                                            <td><span class="value"><?= $row['user_green_point'] ?> Points</span></td>
                                        </tr>
                                        <tr>
                                            <th><span class="label"><i class="fa-solid fa-leaf"></i> CO<sub>2</sub> Saved:</span></th>
                                            <td><span class="value"><?= $row['user_co2_kg'] ?> kg</span></td>
                                        </tr>
                                        <tr>
                                            <th><span class="label"><i class="fa-solid fa-sack-dollar"></i> Balance</span></th>
                                            <td><span class="value">RM <?= $row['user_balance'] ?></span></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="user-card-action">
                                <button class="toggle-status-btn <?= $row['login_status'] === 'ACTIVE' ? 'user-active' : 'user-blocked' ?>"
                                        data-key="<?= $row['user_username'] ?>"
                                        data-status="<?= $row['login_status'] ?>"
                                        data-action="toggle_user">
                                    <?= $row['login_status'] === 'ACTIVE' ? '<i class="fa-solid fa-user-slash"></i> Block' : '<i class="fa-solid fa-user-check"></i> Unblock' ?>
                                </button>
                                <button class="view-user-activity" data-key="<?= htmlspecialchars($row['user_username'])?>"><i class="fa-solid fa-clock-rotate-left"></i> User Activity</button>
                            </div>
                        </div>

                    <?php endwhile; ?>
                </div>
            </div>
        </main>

        <div class="modal user-modal">
            <div class="close-modal-icon">
                 <i class="fa-solid fa-xmark click-icon" onclick="closeModal(this.closest('.modal'))"></i>
            </div>
            <div class="user-activity-container">
                <div class="user-activity-menu">
                    <ul class="flex-row">
                        <li data-target="user-comment" class="flex-icon"><i class="fa-regular fa-comment-dots"></i>User Comments</li>
                        <li data-target="user-reward" class="flex-icon"><i class="fa-solid fa-gift"></i>User Rewards</li>
                    </ul>
                </div>
                <div class="user-comment user-activity-tabs">
                    <div class="user-activity-data">   
                        <div class="user-activity-filter">
                            <button>All</button>
                            <button>Active</button>
                            <button>Inactive</button>
                        </div>      

 
                        <table class="activity-table table-style" id="comment-table">
                            <colgroup>
                                <col style="width: 30%">
                                <col style="width: 15%">
                                <col style="width: 30%">
                                <col style="width: 25%">
                            </colgroup>
                            <thead>
                                <tr>
                                    <th>Comment</th>
                                    <th>Rating</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
                <div class="user-reward user-activity-tabs">
                    <div class="user-activity-data">
                        <div class="user-activity-filter">
                            <button>All</button>
                            <button>Used</button>
                            <button>Unused</button>
                        </div>
                        <table class="activity-table table-style" id="reward-table">
                            <thead>
                                <tr>
                                    <th>Reward</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <?php include '../global/footer.php'; ?>
        <script src="admin.js"></script>
        <script src="adminEntityManagement.js"></script>
       <script>
            openModalWithData({
                triggerSelector: '.view-user-activity',
                fetchUrl: 'adminUserManagement.php?fetchUsername=',
                modalSelector: '.user-modal',
                mapData: (data, modal) => {

                    const menuItems = modal.querySelectorAll('.user-activity-menu ul li');
                    const tabs = modal.querySelectorAll('.user-activity-tabs');

                    menuItems.forEach(m => m.classList.remove('active'));
                    tabs.forEach(t => t.style.display = 'none');
                    menuItems[0]?.click();

                    const commentTbody = modal.querySelector('#comment-table tbody');
                    commentTbody.innerHTML = '';
                    data.comments.forEach(c => {
                        commentTbody.insertAdjacentHTML('beforeend', `
                            <tr>
                                <td>${c.review_comment}</td>
                                <td>${c.review_rating}</td>
                                <td>${c.review_created_at}</td>
                                <td>${c.review_status}</td>
                            </tr>
                        `);
                    });

                    const rewardTbody = modal.querySelector('#reward-table tbody');
                    rewardTbody.innerHTML = '';
                    data.rewards.forEach(r => {
                        rewardTbody.insertAdjacentHTML('beforeend', `
                            <tr>
                                <td>${r.reward_title}</td>
                                <td>${r.redeem_redeemed_at}</td>
                                <td>${r.redeem_status}</td>
                            </tr>
                        `);
                    });
                }
            });


            </script>

    </body>
</html>