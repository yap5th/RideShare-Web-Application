<?php 
include '../global/dbConnection.php';

//Fetch Data (View)
if (isset($_GET['fetchId'])) {
    $fetchId = intval($_GET['fetchId']); 

    $fetchQuery = "SELECT * FROM tbl_announcement WHERE announcement_id = $fetchId";

    $fetchResult = mysqli_query($connection, $fetchQuery);
    if (!$fetchResult) {
        die("Query failed: " . mysqli_error($connection));
    }

    if ($row = mysqli_fetch_assoc($fetchResult)) {
        echo json_encode($row);
    } else {
        echo json_encode(["error" => "Announcement not found"]);
    }
    
    exit;
}


$annQuery = "SELECT * FROM tbl_announcement ORDER BY announcement_created_at DESC";
$annResult = mysqli_query($connection, $annQuery);
if (!$annResult) {
    die("Query failed: " . mysqli_error($connection));
}


?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin Announcement</title>
        <link rel="stylesheet" href="../global/main.css">
        <link rel="stylesheet" href="../global/footer.css">
        <link rel="stylesheet" href="../global/menu.css">

        <!-- Font Style for RideShare@APU Logo -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Bowlby+One&family=Ultra&display=swap" rel="stylesheet">
        
        <!-- Icon -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer"/>


        <link rel="stylesheet" href="admin.css">
        <link rel="stylesheet" href="searchBar.css">
        <link rel="stylesheet" href="adminAnnouncement.css">
    </head>
    <body>
        <?php include 'adminMenu.php'; ?>
        <main>
            <div class="page-container">
                <div class="page-header card">
                    <div class="page-header-title">
                        <h1 class="menu-title flex-icon"><i class="fa-solid fa-bullhorn"></i>Announcement Management</h1>
                        <p>Manage announcements to keep users informed of updates and important news</p>
                    </div>
                    <div class="page-header-action">
                        <?php include 'searchBar.php'; ?>
                        <button type="button" class="add-button flex-icon" id="add-announcement-button">
                            <i class="fa-solid fa-plus"></i>Announcement
                        </button>
                    </div>
                </div>  
                <div class="card-container" id="card-container">
                    <?php while ($row = mysqli_fetch_assoc($annResult)): ?>
                        <div class="announcement-card card searchable-card">
                            <div data-searchable class="card-title"><?= htmlspecialchars($row['announcement_title']) ?></div>
                            <div class="line"></div>
                            <div class="announcement-content">
                                <?php if (!empty($row['announcement_content'])): ?>
                                    <?php
                                        $imagePath = htmlspecialchars($row['announcement_content']);
                                        if ($imagePath): 
                                    ?>
                                        <img src="<?= $imagePath ?>" alt="Announcement image" class="announcement-image">
                                        <?php endif; ?>
                                <?php endif; ?>
                                <p><?= htmlspecialchars($row['announcement_description']) ?></p>
                            </div>
                            <div class="card-bottom">
                                <div class="card-info">
                                    <div class="status">
                                        <i class="status-icon"></i>
                                        <span class="status-text"><?= htmlspecialchars($row['announcement_status']) ?></span>
                                    </div>
                                    <p><i class="fa-regular fa-clock"></i>      Created at: <?= htmlspecialchars($row['announcement_created_at']) ?></p>
                                    <?php if (!empty($row['announcement_last_updated'])): ?>
                                        <p>
                                            <i class="fa-solid fa-pen"></i>
                                            Last Edited: <?= htmlspecialchars($row['announcement_last_updated']) ?>
                                        </p>
                                    <?php endif; ?>
                                </div>
                                <div class="card-option">
                                    <button class="view-announcement card-view-button flex-icon" data-key="<?= $row['announcement_id']?>">
                                        View
                                    </button>
                                    <i class="fa-solid fa-trash delete-announcement click-icon delete-btn" data-key="<?= $row['announcement_id']?>"></i>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
        </main>

        <div class="modal announcement-modal">
            <div class="close-modal-icon">
                <i class="fa-solid fa-xmark click-icon" onclick="closeModal(this.closest('.modal'))"></i>
            </div>
            
            <form data-mode="editable" id="announcement-form">
                <h2 class="form-title"></h2>
                <input type="hidden" name="form-type" value="announcement">

                <div class="form-row">
                    <div class="form-group">
                        <label>Announcement ID:</label><input type="text" id="ann-id" name="id" readonly>
                    </div>
                    <div class="form-group">
                        <label>Announcement Title:</label><input type="text" id="ann-title" name="title" data-editable readonly><div class="error" id="ann-error-title"></div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Announcement Description:</label>
                    <textarea id="ann-description" name="description" data-editable readonly></textarea>
                    <div class="error" id="ann-error-description"></div>
                </div>

                <div class="form-group">
                    <label>Applicable To:</label>
                    <div class="checkbox-row">
                        <label><input type="checkbox" name="ann-applicable-to[]" value="ALL" data-editable disabled> All</label>
                        <label><input type="checkbox" name="ann-applicable-to[]" value="DRIVER" data-editable disabled> Drivers</label>
                        <label><input type="checkbox" name="ann-applicable-to[]" value="USER" data-editable disabled> Users</label>
                        <label><input type="checkbox" name="ann-applicable-to[]" value="STAFF" data-editable disabled> Staff</label>
                    </div>
                    <div class="error" id="ann-error-applicable-to"></div>
                </div>

                <div class="form-group">
                    <label>Status:</label>
                    <select id="ann-status" name="status" data-editable disabled>
                        <option value="INACTIVE">Inactive</option>
                        <option value="ACTIVE">Active</option>
                    </select>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Created at:</label><input type="text" id="ann-created-at" readonly>
                    </div>
                    <div class="form-group">
                        <label>Last Updated:</label><input type="text" id="ann-last-updated" readonly>
                    </div>
                </div>

                <div class="form-group">
                    <label>Content Image:</label>
                    <input type="file" id="ann-content" name="content" accept="image/*" data-editable disabled>
                    <div id="current-image-container" style="display:none;">
                        <input type="hidden" name="current-image-path" id="current-image-path">
                        <span id="ann-content-image"></span>
                        <label id="remove-image-wrapper">
                            <input type="checkbox" name="remove_image" value="remove" data-editable disabled> Remove image
                        </label>
                    </div>
                </div>

                <!-- Buttons -->
                <button type="button" class="edit-btn flex-icon">
                    <i class="fa-regular fa-pen-to-square"></i>Edit
                </button>
                <button type="submit" class="save-btn flex-icon" style="display:none;">
                    <i class="fa-regular fa-floppy-disk"></i>Save
                </button>
            </form>
        </div>

        <?php include '../global/footer.php'; ?>
        <script src="admin.js"></script>
        <script>
            openModalWithData({
                triggerSelector: '.view-announcement',
                fetchUrl: 'adminAnnouncement.php?fetchId=',
                modalSelector: '.announcement-modal',
                mapData: (data, modal, form) => {
                    form.querySelector("#ann-id").parentElement.style.display = '';
                    form.querySelector("#ann-created-at").parentElement.style.display = '';
                    form.querySelector("#ann-last-updated").parentElement.style.display = '';
                    form.querySelector('#remove-image-wrapper').style.display = 'none';

                    form.querySelector(".form-title").textContent = "View Announcement Details";
                    form.querySelector('#ann-id').value = data.announcement_id;
                    form.querySelector('#ann-title').value = data.announcement_title;
                    form.querySelector('#ann-description').value = data.announcement_description;
                    form.querySelector('#ann-status').value = data.announcement_status;
                    form.querySelector('#ann-created-at').value = data.announcement_created_at;
                    form.querySelector('#ann-last-updated').value = data.announcement_last_updated;

                    const applicable = (data.announcement_applicable_to || '').split(',');
                    form.querySelectorAll('[name="ann-applicable-to[]"]').forEach(cb => {
                        cb.checked = applicable.includes(cb.value);
                    });

                    form.querySelector('input[name="remove_image"]').checked = false;
                    const imgContainer = form.querySelector('#current-image-container');
                    const imgSpan = form.querySelector('#ann-content-image');
                    
                    form.querySelector('#current-image-path').value = ''; 

                    if (data.announcement_content) {
                        imgContainer.style.display = 'flex';
                        imgSpan.innerHTML = `<img src="${data.announcement_content}" alt="Current image" style="max-height:90px; margin-top:5px;">`;
                        form.querySelector('#current-image-path').value = data.announcement_content;
                    } else {
                        imgContainer.style.display = 'none';
                        imgSpan.innerHTML = '';
                    }
                }
            });


            //check box (role)
            document.addEventListener('DOMContentLoaded', function() {
                const applicableCheckboxes = document.querySelectorAll('input[name="ann-applicable-to[]"]');
                
                applicableCheckboxes.forEach(checkbox => {
                    checkbox.addEventListener('change', function() {
                        const allCheckbox = document.querySelector('input[name="ann-applicable-to[]"][value="ALL"]');
                        const driverCheckbox = document.querySelector('input[name="ann-applicable-to[]"][value="DRIVER"]');
                        const userCheckbox = document.querySelector('input[name="ann-applicable-to[]"][value="USER"]');
                        const staffCheckbox = document.querySelector('input[name="ann-applicable-to[]"][value="STAFF"]');
                        
                        if (this.value === 'ALL' && this.checked) {
                            driverCheckbox.checked = false;
                            userCheckbox.checked = false;
                            staffCheckbox.checked = false;
                        }
                        
                        if (['DRIVER', 'USER', 'STAFF'].includes(this.value) && this.checked) {
                            allCheckbox.checked = false;
                        }
                        
                        if (driverCheckbox.checked && userCheckbox.checked && staffCheckbox.checked) {
                            allCheckbox.checked = true;
                            driverCheckbox.checked = false;
                            userCheckbox.checked = false;
                            staffCheckbox.checked = false;
                        }
                    });
                });
            });


            //ann form submit
            document.getElementById("announcement-form").addEventListener("submit", function (e) {
                e.preventDefault(); 

                clearErrors();

                fetch("adminPOST.php", {method: "POST",body: new FormData(this)})
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert("Saved successfully");
                        window.location.reload(); 
                    } else {
                        if (data.title) showError("ann-error-title", data.title);
                        if (data.description) showError("ann-error-description", data.description);
                        if (data.applicable_to) showError("ann-error-applicable-to", data.applicable_to);
                    }
                })
                .catch(err => console.error("Fetch error:", err));
            });


            //edit button
            document.addEventListener("click", e => {
                const editBtn = e.target.closest('.edit-btn');
                if (!editBtn) return;

                const form = editBtn.closest('form');

                form.querySelector(".form-title").textContent = "Edit Announcement";
                form.querySelector('#remove-image-wrapper').style.display = '';

                setEditMode(form);
            });
            


            //add announcement
            document.getElementById("add-announcement-button").addEventListener("click", function() {
                const modal = document.querySelector('.announcement-modal');
                const form = document.getElementById("announcement-form");

                form.reset();
                document.querySelector(".form-title").textContent = "Add New Announcement";
                document.getElementById("ann-content").value = "";
                document.getElementById("ann-content-image").textContent = "";
                document.getElementById("current-image-container").style.display = "none";

                document.getElementById("ann-id").parentElement.style.display = 'none';
                document.getElementById("ann-created-at").parentElement.style.display = 'none';
                document.getElementById("ann-last-updated").parentElement.style.display = 'none';
                    
                setEditMode(form); 
                openModal(modal);
            });



            //delete annoucement
            document.addEventListener('click', e => {
                const delBtn = e.target.closest('.delete-announcement');
                if (!delBtn) return;

                const id = delBtn.dataset.key;
                if (!confirm('Delete this announcement?')) return;

                fetch('adminAPI.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({action: 'delete_announcement', id: id})
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        delBtn.closest('.announcement-card').remove();
                    } else {
                        alert(data.message || 'Delete failed');
                    }
                })
                .catch(() => alert('Server error'));
            });

        </script>
    </body>
</html>