<?php 

include '../global/dbConnection.php';

$staffQuery = "
                SELECT s.staff_username, s.staff_name, s.staff_ic_passport, s.staff_dob, s.staff_gender, s.staff_contact, s.staff_email, l.login_role, l.login_status
                FROM tbl_staff_info s INNER JOIN tbl_login l ON s.staff_username = l.login_username
                WHERE l.login_role = 'STAFF' ORDER BY s.staff_username ASC
            ";

$staffResult = mysqli_query($connection, $staffQuery);
if (!$staffResult) {
    die("Query failed: " . mysqli_error($connection));
}

?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Staff Management</title>
        <link rel="stylesheet" href="../global/main.css">
        <link rel="stylesheet" href="../global/footer.css">
        <link rel="stylesheet" href="../global/menu.css">

        <!-- Font Style for RideShare@APU Logo -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Bowlby+One&family=Ultra&display=swap" rel="stylesheet">
        
        <!-- Icon for Footer -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer"/>

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
                        <h1 class="menu-title flex-icon"> <i class="fa-solid fa-user-tie"></i>Staff Management</h1>
                        <p>Oversee staff profiles and system access</p>
                    </div>
                    <div class="page-header-action">
                        <?php include 'searchBar.php'; ?>
                        <button type="button" class="add-button flex-icon" id="add-staff-button">
                            <i class="fa-solid fa-user-plus"></i>Staff
                        </button>
                    </div>
                </div>  
                <div class="card-container" id="card-container">
                    <?php while($row = mysqli_fetch_assoc($staffResult)): ?>
                        <div class="user-card card searchable-card" style="border-left: <?= $row['login_status'] === 'BLOCKED' ? '4px solid var(--error-red)' : '4px solid var(--light-green)' ?>;">
                            <i class="fa-solid fa-circle-arrow-down click-icon view-user-btn"></i>
                            <div class="user-card-body">
                                <div class="user-contact">
                                    <span data-searchable class="username"><?= $row['staff_username']?></span>
                                    <div class="user-name-status">
                                        <p><?= $row['staff_name']?></p>
                                        <div class="status">
                                            <i class="status-icon"></i>
                                            <span class="status-text status-label"><?= htmlspecialchars($row['login_status']) ?></span>
                                        </div>
                                    </div>
                                    <p data-searchable class="flex-icon"><i class="fa-solid fa-phone"></i><?= $row['staff_contact']?></p>
                                    <p  data-searchable class="flex-icon"><i class="fa-solid fa-envelope"></i><?= $row['staff_email']?></p>
                                </div>

                                <div class="user-personal-info">
                                    <table class="user-table-style">
                                        <tr>
                                            <th><span class="label"><i class="fa-solid fa-id-card-clip"></i> IC / Passport:</span></th>
                                            <td><span class="value"><?= $row['staff_ic_passport'] ?></span></td>

                                        </tr>
                                        <tr>
                                            <th><span class="label"><i class="fa-solid fa-venus-mars"></i> Gender:</span></th>
                                            <td><span class="value"><?= $row['staff_gender'] ?></span></td>
                                        </tr>
                                        <tr>
                                            <th><span class="label"><i class="fa-regular fa-calendar-days"></i> Date of Birth:</span></th>
                                            <td><span class="value"><?= $row['staff_dob'] ?></span></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="user-card-action">
                                <button data-key="<?= $row['staff_username']?>" class="delete-staff"> <i class="fa-solid fa-trash" ></i> Delete </button>
                                <button class="toggle-status-btn <?= $row['login_status'] === 'ACTIVE' ? 'user-active' : 'user-blocked' ?>"
                                        data-key="<?= $row['staff_username'] ?>"
                                        data-status="<?= $row['login_status'] ?>"
                                        data-action="toggle_user">
                                    <?= $row['login_status'] === 'ACTIVE' ? '<i class="fa-solid fa-user-slash"></i> Block' : '<i class="fa-solid fa-user-check"></i> Unblock' ?>
                                </button>
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
            
            <form data-mode="add-only" id="staff-form">
                <h2 class="form-title">Staff Registration</h2>
                <input type="hidden" name="form-type" value="staff">

                <div class="form-group">
                    <label>Full Name:</label>
                    <input class="capitalize" type="text" name="name">
                    <div class="error" id="staff-error-name"></div>
                </div>

                <div class="form-group">
                    <label>IC / Passport:</label>
                    <input type="text" name="ic_passport" placeholder="e.g., 020393-10-8888">
                    <div class="error" id="staff-error-ic-passport"></div>
                </div>

                <div class="form-group">
                    <label>Date of Birth:</label>
                    <input type="date" name="dob">
                    <div class="error" id="staff-error-dob"></div>
                </div>

                <div class="gender form-group">
                    <label>Gender: </label>
                    <div class="gender-option">
                        <label><input type="radio" name="gender" value="MALE">Male</label>
                        <label><input type="radio" name="gender" value="FEMALE">Female</label>
                    </div>
                    <div class="error" id="staff-error-gender"></div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Contact:</label>
                        <input type="tel" name="contact" placeholder="e.g., 012-3334444">
                        <div class="error" id="staff-error-contact"></div>
                    </div>
                    <div class="form-group">
                        <label>Email:</label>
                        <input type="text" name="email" placeholder="e.g., xxx@gmail.com">
                        <div class="error" id="staff-error-email"></div>
                    </div>
                </div>

                <button type="submit" class="flex-icon"'><i class="fa-regular fa-floppy-disk"></i>Save</button>
            </form>
        </div>

        <?php include '../global/footer.php'; ?>
        <script src="admin.js"></script>
        <script src="adminEntityManagement.js"></script>
        <script>
            
            document.getElementById('add-staff-button')
                .addEventListener('click', () => {
                    openModal(document.querySelector('.user-modal'));

                    const form = document.getElementById("staff-form");
                    form.reset();
                });


            document.getElementById("staff-form").addEventListener("submit", function (e) {
                e.preventDefault();

                clearErrors();

                fetch("adminPOST.php", {
                    method: "POST",
                    body: new FormData(this)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert("Saved successfully");
                        window.location.reload(); 
                    } else {
                        if (data.name) showError("staff-error-name", data.name);
                        if (data.ic_passport) showError("staff-error-ic-passport", data.ic_passport);
                        if (data.dob) showError("staff-error-dob", data.dob);
                        if (data.gender) showError("staff-error-gender", data.gender);
                        if (data.contact) showError("staff-error-contact", data.contact);
                        if (data.email) showError("staff-error-email", data.email);
                    }
                })
                .catch(err => console.error("Fetch error:", err));
            });


            document.addEventListener('click', e => {
                const btn = e.target.closest('.delete-staff');
                if (!btn) return;

                const id = btn.dataset.key;
                if (!confirm('Delete this staff?')) return;

                fetch('adminAPI.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        action: 'delete_staff',
                        id: id
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        btn.closest('.user-card').remove();
                    } else {
                        alert(data.message || 'Delete failed');
                    }
                })
                .catch(() => alert('Server error'));
            });

        </script>
    </body>
</html>