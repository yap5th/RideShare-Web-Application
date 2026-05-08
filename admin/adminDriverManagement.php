<?php 
include '../global/dbConnection.php';

//driver activity
if (isset($_GET['fetchUsername'])) {
    $username = $_GET['fetchUsername'];

    $commentsQuery = "
                        SELECT r.review_rating, r.review_comment, r.review_created_at, r.review_status FROM tbl_review r
                        INNER JOIN tbl_ride_offer o ON r.review_offer_id = o.offer_id WHERE o.offer_driver_username = '$username'
                    ";

    $commentsResult = mysqli_query($connection, $commentsQuery);
    if (!$commentsResult) {
        die("Comments query failed: " . mysqli_error($connection));
    }
    $comments = mysqli_fetch_all($commentsResult, MYSQLI_ASSOC);

    // Fetch rewards
    $rewardsQuery = "
                        SELECT r.reward_title, rd.redeem_redeemed_at, rd.redeem_status FROM tbl_redeem rd 
                        JOIN tbl_reward r ON rd.redeem_reward_id = r.reward_id WHERE rd.redeem_username = '$username'
                    ";

    $rewardsResult = mysqli_query($connection, $rewardsQuery);
    if (!$rewardsResult) {
        die("Rewards query failed: " . mysqli_error($connection));
    }
    $rewards = mysqli_fetch_all($rewardsResult, MYSQLI_ASSOC);

    echo json_encode(['comments' => $comments, 'rewards' => $rewards ]);
    exit;
}

// Drivers
$driverQuery = "
    SELECT 
        u.user_username, u.user_name, u.user_ic_passport, u.user_gender,
        u.user_dob, u.user_contact, u.user_email, u.user_green_point,
        u.user_co2_kg, u.user_balance,

        d.driver_profile_image, d.driver_plate_no, d.driver_vehicle_model,
        d.driver_vehicle_color, d.driver_vehicle_image, d.driver_license_image,
        d.driver_license_expiry, d.driver_road_tax_image, d.driver_road_tax_expiry,

        l.login_role, l.login_status,

        ROUND(AVG(r.review_rating), 1) AS avg_rating,
        COUNT(r.review_id) AS total_reviews

    FROM tbl_user_info u
    JOIN tbl_driver_info d ON u.user_username = d.driver_username
    JOIN tbl_login l ON u.user_username = l.login_username
    LEFT JOIN tbl_ride_offer o ON o.offer_driver_username = u.user_username
    LEFT JOIN tbl_review r ON r.review_offer_id = o.offer_id AND r.review_status = 'ACTIVE'

    GROUP BY u.user_username
";


$driverResult = mysqli_query($connection, $driverQuery);

if (!$driverResult) {
    die("Query failed: " . mysqli_error($connection));
}

//updates
$updateQuery = "
                    SELECT u.user_name, u.user_contact, u.user_email, d.*
                    FROM tbl_driver_update d
                    INNER JOIN tbl_user_info u ON d.update_driver_username = u.user_username
                    ORDER BY d.update_id ASC
                ";
$updateResult = mysqli_query($connection, $updateQuery);
if (!$updateResult) {
    die("Query failed: " . mysqli_error($connection));
}


//Requests
$requestQuery = "SELECT * FROM tbl_driver_request ORDER BY request_id ASC";
$requestResult = mysqli_query($connection, $requestQuery);
if (!$requestResult) {
    die("Query failed: " . mysqli_error($connection));
}


?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Driver Management</title>
        <link rel="stylesheet" href="../global/main.css">
        <link rel="stylesheet" href="../global/footer.css">
        <link rel="stylesheet" href="../global/menu.css">

        <!-- Font Style for RideShare@APU Logo -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Bowlby+One&family=Ultra&display=swap" rel="stylesheet">
        
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer"/>

        <link rel="stylesheet" href="admin.css">
        <link rel="stylesheet" href="searchBar.css">
        <link rel="stylesheet" href="adminEntityManagement.css">
        <link rel="stylesheet" href="adminDriverManagement.css">
    </head>
    <body>
        <?php include 'adminMenu.php'; ?>
        <main>
            <div class="page-container">
                <div class="page-header card">
                    <div class="page-header-title">
                        <h1 class="menu-title flex-icon"><i class="fa-solid fa-car-side"></i>Driver Management</h1>
                        <p>Ensure all drivers are verified, licensed, and compliant with safety and system policies</p>
                    </div>
                    <div class="page-header-action">
                        <?php include 'searchBar.php'; ?>
                    </div>
                </div>

                <div class="driver-submenu">
                    <ul class="flex-row">
                        <li data-target="driver">Drivers</li>
                        <li data-target="update">Updates</li>
                        <li data-target="request">Requests</li>
                    </ul>
                </div>

                <div class="card-container" id="card-container">

                   <div class="driver-card-container subpage">
                        <?php while($row = mysqli_fetch_assoc($driverResult)): ?>
                        <div class="driver-card card user-card searchable-card" style="border-left: <?= $row['login_status'] === 'BLOCKED' ? '4px solid var(--error-red)' : '4px solid var(--light-green)' ?>;">
                            <div class="driver-card-top" >
                                <div class="view-driver-btn view-btn" data-key="<?= $row['user_username']?>" ><i class="fa-solid fa-expand"></i></div>
                                <div class="driver-profile">
                                    <img src="<?= htmlspecialchars($row['driver_profile_image']) ?>" alt="Driver Profile Image">
                                </div>
                                <span data-searchable class="driver-username"><?= $row['user_username']?></span>
                                <div class="driver-name-status">
                                    <span data-searchable ><?= $row['user_name']?></span>
                                    <div class="status">
                                        <i class="status-icon"></i>
                                        <span class="status-text"><?= htmlspecialchars($row['login_status']) ?></span>
                                    </div>                                    
                                </div>
                                <div>
                                    <div class="star-rating" data-rating="<?= $row['avg_rating'] ?? 0 ?>"></div>
                                    <span class="rating-text">
                                        <?= $row['avg_rating'] ? $row['avg_rating'].' / 5' : 'No rating' ?>
                                    </span>
                                </div>
                                <p class="flex-icon">
                                    <i class="fa-solid fa-car"></i><?= $row['driver_plate_no']?>  •  <?= $row['driver_vehicle_color']?> <?= $row['driver_vehicle_model']?>
                                </p>
                            </div>
                            <div class="driver-card-bottom">
                                <div class="driver-personal-info">
                                    <div class="form-group">
                                        <span class="label"><i class="fa-solid fa-id-card-clip"></i> IC / Passport:</span>
                                        <span class="value"><?= $row['user_ic_passport'] ?></span>
                                    </div>

                                    <div class="form-group">
                                        <span class="label"><i class="fa-solid fa-venus-mars"></i> Gender:</span>
                                        <span class="value"><?= $row['user_gender'] ?></span>
                                    </div>

                                    <div class="form-group">
                                        <span class="label"><i class="fa-regular fa-calendar-days"></i> Date of Birth:</span>
                                        <span class="value"><?= $row['user_dob'] ?></span>
                                    </div>

                                    <div class="form-group">
                                        <span class="label"><i class="fa-regular fa-address-book"></i> Contact:</span>
                                        <span class="value"><?= $row['user_contact'] ?></span>
                                    </div>

                                    <div class="form-group">
                                        <span class="label"><i class="fa-solid fa-envelope"></i> Email:</span>
                                        <span class="value"><?= $row['user_email'] ?></span>
                                    </div>

                                    <div class="form-group">
                                        <span class="label"><i class="fa-solid fa-star"></i> Green Points:</span>
                                        <span class="value"><?= $row['user_green_point'] ?> points</span>
                                    </div>

                                    <div class="form-group">
                                        <span class="label"><i class="fa-solid fa-leaf"></i> CO<sub>2</sub> Saved:</span>
                                        <span class="value"><?= $row['user_co2_kg'] ?> kg</span>
                                    </div>

                                    <div class="form-group">
                                        <span class="label"><i class="fa-solid fa-sack-dollar"></i> Balance:</span>
                                        <span class="value">RM <?= $row['user_balance'] ?></span>
                                    </div>
                                </div>
                                <div class="driver-vehicle-info">
                                    <div class="form-group">
                                        <span class="label"><i class="fa-solid fa-car"></i> Vehicle Image:</span>
                                        <span class="value">
                                            <a href="<?= $row['driver_vehicle_image'] ?>" class="image-viewer"><i class="fa-regular fa-hand-point-right"></i> Click to view</a>
                                        </span>
                                    </div>

                                    <div class="form-group">
                                        <span class="label"><i class="fa-solid fa-id-card"></i> License Expiry:</span>
                                        <span class="value">
                                            <?php
                                                $today = date('Y-m-d');
                                                $isExpired = strtotime($row['driver_license_expiry']) < strtotime($today);
                                            ?>
                                            <p class="<?= $isExpired ? 'expired' : '' ?>"><?= $row['driver_license_expiry'] ?></p>
                                            <a href="<?= $row['driver_license_image'] ?>" class="image-viewer"><i class="fa-regular fa-hand-point-right"></i> Click to view</a>
                                        </span>
                                    </div>

                                    <div class="form-group">
                                        <span class="label"><i class="fa-solid fa-id-card"></i> Road Tax Expiry:</span>
                                        <span class="value">
                                            <?php
                                                $today = date('Y-m-d');
                                                $isExpired = strtotime($row['driver_road_tax_expiry']) < strtotime($today);
                                            ?>
                                            <p class="<?= $isExpired ? 'expired' : '' ?>"><?= $row['driver_road_tax_expiry'] ?></p>
                                            <a href="<?= $row['driver_road_tax_image'] ?>" class="image-viewer"><i class="fa-regular fa-hand-point-right"></i> Click to view</a>
                                        </span>
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="driver-card-action user-card-action">
                                <button class="toggle-status-btn <?= $row['login_status'] === 'ACTIVE' ? 'user-active' : 'user-blocked' ?>"
                                        data-key="<?= $row['user_username'] ?>"
                                        data-status="<?= $row['login_status'] ?>"
                                        data-action="toggle_user">
                                    <?= $row['login_status'] === 'ACTIVE' ? '<i class="fa-solid fa-user-slash"></i> Block' : '<i class="fa-solid fa-user-check"></i> Unblock' ?>
                                </button>
                                <button class="view-user-activity" data-key="<?= htmlspecialchars($row['user_username'])?>"><i class="fa-solid fa-clock-rotate-left"></i> View Driver Activity</button>
                                
                            </div>
                        </div>
                        <?php endwhile; ?>
                   </div>

                   <div class="update-card-container subpage">
                            <?php while($row = mysqli_fetch_assoc($updateResult)): ?>
                            <div class="update-card card searchable-card">
                                <div class="update-card-body">
                                    <div class="update-driver-info">
                                        <p data-searchable class="update-username"><?= $row['update_driver_username']?></p>
                                        <p data-searchable class="update-name"><?= $row['user_name']?></p>
                                        <div class="update-driver-contact">
                                            <p class="flex-icon"><i class="fa-solid fa-phone"></i><?= $row['user_contact']?></p>
                                            <p class="flex-icon"><i class="fa-solid fa-envelope"></i><?= $row['user_email']?></p>
                                        </div>
                                    </div>

                                    <div class="update-documentation">
                                        <div class="form-group">
                                            <span class="label"><i class="fa-solid fa-car"></i> Vehicle Image:</span>
                                            <span class="value">
                                                <p><?= $row['update_plate_no']?>  •  <?= $row['update_vehicle_color']?> <?= $row['update_vehicle_model']?></p>
                                                <a href="<?= $row['update_vehicle_image'] ?>" class="image-viewer"><i class="fa-regular fa-hand-point-right"></i> Click to view</a>
                                            </span>
                                        </div>

                                        <div class="form-group">
                                            <span class="label"><i class="fa-solid fa-id-card"></i> Road Tax Expiry:</span>
                                            <span class="value">
                                                <?php
                                                    $today = date('Y-m-d');
                                                    $isExpired = strtotime($row['update_road_tax_expiry']) < strtotime($today);
                                                ?>
                                                <p class="<?= $isExpired ? 'expired' : '' ?>"><?= $row['update_road_tax_expiry'] ?></p>
                                                <a href="<?= $row['update_road_tax_image'] ?>" class="image-viewer"><i class="fa-regular fa-hand-point-right"></i> Click to view</a>
                                            </span>
                                        </div>
                                    </div>
                                    <p class="flex-icon submitted-at"><i class="fa-solid fa-clock"></i>Submitted at <?= $row['update_submitted_at']?></p>
                                </div>
                                <div class="update-card-action">
                                    <button data-key="<?= $row['update_id']?>" data-action="reject_update" class="reject-btn update-action">Reject</button>
                                    <button data-key="<?= $row['update_id']?>" data-action="approve_update" class="accept-btn update-action">Approve</button>
                                </div>
                            </div>
                        <?php endwhile; ?>
                   </div>

                    <div class="request-card-container subpage">
                        <?php while($row = mysqli_fetch_assoc($requestResult)): ?>
                        <div class="request-card card searchable-card">
                            <div class="request-card-header"></div>
                            <div class="request-card-body">
                                <div class="request-driver-info">
                                    <div class="request-profile"><img src="<?= $row['request_profile_image']?>" alt="Request Driver Profile"></div>
                                    <div class="request-driver-contact">
                                        <p data-searchable><?= $row['request_name']?></p>
                                        <p data-searchable class="flex-icon"><i class="fa-solid fa-phone"></i><?= $row['request_contact']?></p>
                                        <p  data-searchable class="flex-icon"><i class="fa-solid fa-envelope"></i><?= $row['request_email']?></p>
                                    </div>
                                </div>
                                <div class="request-driver-personal-info">
                                    <table>
                                        <tr>
                                            <th><span class="label"><i class="fa-solid fa-id-card-clip"></i> IC / Passport:</span></th>
                                            <td><span class="value"><?= $row['request_ic_passport'] ?></span></td>
                                        </tr>
                                        <tr>
                                            <th><span class="label"><i class="fa-solid fa-venus-mars"></i> Gender:</span></th>
                                            <td><span class="value"><?= $row['request_gender'] ?></span></td>
                                        </tr>
                                        <tr>
                                            <th><span class="label"><i class="fa-regular fa-calendar-days"></i> Date of Birth:</span></th>
                                            <td><span class="value"><?= $row['request_dob'] ?></span></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="request-documentation">
                                    <div class="form-group">
                                        <span class="label"><i class="fa-solid fa-car"></i> Vehicle Image:</span>
                                        <span class="value">
                                            <p><?= $row['request_plate_no']?>  •  <?= $row['request_vehicle_color']?> <?= $row['request_vehicle_model']?></p>
                                            <a href="<?= $row['request_vehicle_image'] ?>" class="image-viewer"><i class="fa-regular fa-hand-point-right"></i> Click to view</a>
                                        </span>
                                    </div>

                                    <div class="form-group">
                                        <span class="label"><i class="fa-solid fa-id-card"></i> License Expiry:</span>
                                        <span class="value">
                                            <?php
                                                $today = date('Y-m-d');
                                                $isExpired = strtotime($row['request_license_expiry']) < strtotime($today);
                                            ?>
                                            <p class="<?= $isExpired ? 'expired' : '' ?>"><?= $row['request_license_expiry'] ?></p>
                                            <a href="<?= $row['request_license_image'] ?>" class="image-viewer"><i class="fa-regular fa-hand-point-right"></i> Click to view</a>
                                        </span>
                                    </div>

                                    <div class="form-group">
                                        <span class="label"><i class="fa-solid fa-id-card"></i> Road Tax Expiry:</span>
                                        <span class="value">
                                            <?php
                                                $today = date('Y-m-d');
                                                $isExpired = strtotime($row['request_road_tax_expiry']) < strtotime($today);
                                            ?>
                                            <p class="<?= $isExpired ? 'expired' : '' ?>"><?= $row['request_road_tax_expiry'] ?></p>
                                            <a href="<?= $row['request_road_tax_image'] ?>" class="image-viewer"><i class="fa-regular fa-hand-point-right"></i> Click to view</a>
                                        </span>
                                    </div>
                                </div>
                                <p class="flex-icon submitted-at"><i class="fa-solid fa-clock"></i>Submitted at <?= $row['request_submitted_at']?></p>
                            </div>
                            <div class="request-card-action">
                                <button data-key="<?= $row['request_id']?>" data-action="reject_driver" class="reject-btn request-action">Reject</button>
                                <button data-key="<?= $row['request_id']?>" data-action="accept_driver" class="accept-btn request-action">Accept</button>
                            </div>
                        </div>
                        <?php endwhile; ?>
                   </div>
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
                        <li data-target="user-comment" class="flex-icon"><i class="fa-regular fa-comment-dots"></i>Driver Comments</li>
                        <li data-target="user-reward" class="flex-icon"><i class="fa-solid fa-gift"></i>Driver Rewards</li>
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


        <div class="modal image-modal">
            <div class="close-modal-icon">
                <i class="fa-solid fa-xmark click-icon" onclick="closeModal(this.closest('.modal'))"></i>
            </div>
            <div class="image-container">
                <img id="modalImage" src="" alt="Image Preview">
            </div>
        </div>


        <?php include '../global/footer.php'; ?>

        <script src="admin.js"></script>
        <script src="adminEntityManagement.js"></script>

        <script>

            //tab menu
            document.addEventListener('DOMContentLoaded', () => {
                const tabs = document.querySelectorAll('.driver-submenu li');
                const pages = document.querySelectorAll('.subpage');

                const params = new URLSearchParams(window.location.search);
                const tabFromURL = params.get('tab'); 

                function hideAll() {
                    pages.forEach(p => p.style.display = 'none');
                    tabs.forEach(t => t.classList.remove('active'));
                }

                function activate(target) {
                    const tab = document.querySelector(`.driver-submenu li[data-target="${target}"]`);
                    const page = document.querySelector(`.${target}-card-container`);
                    if (!tab || !page) return;

                    hideAll();
                    tab.classList.add('active');
                    page.style.display = 'flex';
                }

                activate(tabFromURL || 'driver');

                tabs.forEach(tab => {
                    tab.addEventListener('click', () => {
                        const target = tab.dataset.target;

                        if (!tab.classList.contains('active')) {
                            const newURL = `${window.location.pathname}?tab=${target}`;
                            window.location.href = newURL; 
                        } else {
                            activate(target);
                        }
                    });
                });
            });



            //start rating
            document.querySelectorAll('.star-rating').forEach(starContainer => {
                const rating = parseFloat(starContainer.dataset.rating); //3.5

                for (let i = 1; i <= 5; i++) {
                    const star = document.createElement('i');

                    if (rating >= i) {
                        star.className = 'fa-solid fa-star filled';
                    } else if (rating >= i - 0.5) {
                        star.className = 'fa-solid fa-star-half-stroke filled';
                    } else {
                        star.className = 'fa-regular fa-star';
                    }

                    starContainer.appendChild(star);
                }
            });

            
            //expand driver card
            document.querySelectorAll('.view-driver-btn').forEach(btn => {
                btn.addEventListener('click', () => {
                    const card = btn.closest('.driver-card');

                    document.querySelectorAll('.driver-card.driver-details-active').forEach(c => c !== card && c.classList.remove('driver-details-active'));

                    card.classList.toggle('driver-details-active');
                });
            });


            //view user activity
            openModalWithData({
                triggerSelector: '.view-user-activity',
                fetchUrl: 'adminDriverManagement.php?fetchUsername=',
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



            document.querySelectorAll('.request-action').forEach(btn => {
                btn.addEventListener('click', () => {
                    const card = btn.closest('.request-card');
                    const requestId = btn.dataset.key;
                    const action = btn.dataset.action;
                    const message = action === 'accept_driver' ? 'Approve this driver? This action cannot be undone.' : 'Reject this driver request? This will delete the request.';

                    if (!confirm(message)) return; 
                    if (!requestId) return;

                    fetch('adminAPI.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ request_id: requestId, action: action })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            card.remove();
                        } else {
                            alert(data.message || 'Action failed');
                        }
                    });
                });
            });



            document.querySelectorAll('.update-action').forEach(btn => {
                btn.addEventListener('click', () => {
                    const card = btn.closest('.update-card');
                    const updateId = btn.dataset.key;
                    const action = btn.dataset.action;

                    const message = action === 'accept_update' ? 'Approve this driver update? This action cannot be undone.' : 'Reject this driver update? This will delete the request.';

                    if (!confirm(message)) return;  

                    if (!updateId) return;

                    fetch('adminAPI.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ update_id: updateId, action: action })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            card.remove(); 
                        } else {
                            alert(data.message || 'Action failed');
                        }
                    });
                });
            });


            document.querySelectorAll('.image-viewer').forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault(); 
                    const modal = document.querySelector('.image-modal');
                    const modalImg = modal.querySelector('#modalImage');
                    modalImg.src = this.href; 
                    openModal(modal);          
                });
            });




        </script>
    </body>
</html>