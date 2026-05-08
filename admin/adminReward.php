<?php 
include '../global/dbConnection.php';


if (isset($_GET['fetchId'])) {
    $fetchId = intval($_GET['fetchId']);

    $fetchQuery = "
        SELECT 
            r.reward_id,
            r.reward_title,
            r.reward_description,
            r.reward_content,
            r.reward_required_point,
            r.reward_quantity,
            r.reward_valid_days,
            r.reward_applicable_to,
            r.reward_status,
            COUNT(d.redeem_reward_id) AS redeem_quantity
        FROM tbl_reward r
        LEFT JOIN tbl_redeem d ON r.reward_id = d.redeem_reward_id
        WHERE r.reward_id = $fetchId
        GROUP BY r.reward_id
    ";

    $fetchResult = mysqli_query($connection, $fetchQuery);
    if ($row = mysqli_fetch_assoc($fetchResult)) {
        echo json_encode($row);
    } else {
        echo json_encode(["error" => "Reward not found"]);
    }
    exit;
}

$rwdQuery = "
    SELECT r.*, 
           COUNT(d.redeem_reward_id) AS redeem_quantity
    FROM tbl_reward r
    LEFT JOIN tbl_redeem d ON r.reward_id = d.redeem_reward_id
    GROUP BY r.reward_id
    ORDER BY r.reward_id DESC
";

$rwdResult = mysqli_query($connection, $rwdQuery);


?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Reward System</title>
        <link rel="stylesheet" href="../global/main.css">
        <link rel="stylesheet" href="../global/footer.css">
        <link rel="stylesheet" href="../global/menu.css">

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

        <link rel="stylesheet" href="admin.css">
        <link rel="stylesheet" href="searchBar.css">
        <link rel="stylesheet" href="adminReward.css">
    </head>
    <body>
        <?php include 'adminMenu.php'; ?>
        <main>
            <div class="page-container">
                <div class="page-header card">
                    <div class="page-header-title">
                        <h1 class="menu-title flex-icon"> <i class="fa-solid fa-gifts"></i>Reward Management</h1>
                        <p>Create, update, and control reward availability for the platform</p>
                    </div>
                    <div class="page-header-action">
                        <?php include 'searchBar.php'; ?>
                        <button type="button" class="add-button flex-icon" id="add-reward-button">
                            <i class="fa-solid fa-plus"></i>Reward
                        </button>
                    </div>
                </div>  
                <div class="card-container" id="card-container">
                    <?php while($row = mysqli_fetch_assoc($rwdResult)): ?>
                        <div class="reward-card card searchable-card">
                            <div class="reward-content">
                                <?php if(!empty($row['reward_content'])): ?>
                                    <?php 
                                        $imagePath = htmlspecialchars($row['reward_content']);
                                        if($imagePath):
                                    ?>
                                    <img src="<?= $imagePath ?>" alt="Reward Image" class="reward-image">
                                    <?php endif; ?>
                                <?php else: ?>
                                    <p>[No Image]</p>    
                                <?php endif; ?>
                            </div>
                            <div class="line"></div>
                            <div data-searchable class="card-title"><?= htmlspecialchars($row['reward_title'])?></div>
                            <div class="card-bottom">
                                <div class="card-info">
                                    <div class="status">
                                        <i class="status-icon"></i>
                                        <span class="status-text"><?= htmlspecialchars($row['reward_status']) ?></span>
                                    </div>
                                    <p><i class="fa-solid fa-hashtag"></i> Remaining Quantity: <?= htmlspecialchars($row['reward_quantity'])?></p>
                                    <p><i class="fa-solid fa-user-group"></i> Applicable to: <?= htmlspecialchars($row['reward_applicable_to'])?></p>
                                </div>
                                <div class="card-option">
                                    <button class="view-reward card-view-button" data-key="<?= $row['reward_id']?>">View</button>
                                    <?php if ($row['redeem_quantity'] == 0):?>
                                        <i class="fa-solid fa-trash delete-reward click-icon delete-btn" data-key="<?= $row['reward_id']?>"></i>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
        </main>

        <div class="modal reward-modal">
            <div class="close-modal-icon">
                <i class="fa-solid fa-xmark click-icon" onclick="closeModal(this.closest('.modal'))"></i>
            </div>
            
            <form data-mode="editable" id="reward-form">
                <h2 class="form-title"></h2>
                <input type="hidden" name="form-type" value="reward">

                <div class="form-row">
                    <div class="form-group">
                        <label>Reward ID:</label>
                        <input type="text" id="rwd-id" name="id" readonly>
                    </div>
                    <div class="form-group">
                        <label>Reward Title:</label>
                        <input type="text" id="rwd-title" name="title" data-editable readonly>
                        <div class="error" id="rwd-error-title"></div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Reward Description:</label>
                    <textarea id="rwd-description" name="description" data-editable readonly></textarea>
                    <div class="error" id="rwd-error-description"></div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Required Point:</label>
                        <select id="rwd-point" name="point" data-editable disabled>
                            <option value="">-- Select Points --</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                            <option value="300">300</option>
                            <option value="500">500</option>
                            <option value="800">800</option>
                            <option value="1000">1000</option>
                            <option value="1500">1500</option>
                        </select>
                    <div class="error" id="rwd-error-point"></div>
                    </div>

                    <div class="form-group">
                        <label>Valid Days:</label>
                        <select id="rwd-day" name="day" data-editable disabled>
                            <option value="">-- Select Duration --</option>
                            <option value="7">7 Days</option>
                            <option value="14">14 Days</option>
                            <option value="30">30 Days</option>
                            <option value="60">60 Days</option>
                            <option value="90">90 Days</option>
                            <option value="365">365 Days</option>
                        </select>
                        <div class="error" id="rwd-error-day"></div>
                    </div>

                    <div class="form-group">
                        <label id="quantity">Remaining Quantity:</label>
                        <input type="text" id="rwd-quantity" name="quantity" data-editable readonly>
                        <div class="error" id="rwd-error-quantity"></div>
                    </div>

                    <div class="form-group">
                        <label>Total Redeemed:</label>
                        <input type="text" id="rwd-redeem-quantity" name="redeem-quantity" readonly>
                    </div>

                </div>

                <div class="form-group">
                    <label>Applicable To:</label>
                    <div class="checkbox-row">
                        <label><input type="checkbox" name="rwd-applicable-to[]" value="BOTH" data-editable disabled> Both</label>
                        <label><input type="checkbox" name="rwd-applicable-to[]" value="DRIVER" data-editable disabled> Drivers</label>
                        <label><input type="checkbox" name="rwd-applicable-to[]" value="USER" data-editable disabled> Users</label>
                    </div>
                    <div class="error" id="rwd-error-applicable-to"></div>
                </div>

                <div class="form-group">
                    <label>Status:</label>
                    <select id="rwd-status" name="status" data-editable disabled>
                        <option value="INACTIVE">Inactive</option>
                        <option value="ACTIVE">Active</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Content Image:</label>
                    <input type="file" id="rwd-content" name="content" accept="image/*" data-editable disabled>
                    <div id="current-image-container" style="display:none;">
                        <input type="hidden" name="current-image-path" id="current-image-path">
                        <span id="rwd-content-image"></span>
                        <label>
                            <input type="checkbox" name="remove_image" value="remove" data-editable disabled>
                            Remove image
                        </label>
                    </div>
                </div>

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
                triggerSelector: '.view-reward',
                fetchUrl: 'adminReward.php?fetchId=',
                modalSelector: '.reward-modal',
                mapData: (data, modal, form) => {

                    resetEditableFields(form);
                    clearErrors();

                    document.querySelector(".form-title").textContent = "View Reward Details";
                    modal.querySelector("#rwd-id").parentElement.style.display = '';
                    modal.querySelector("#rwd-redeem-quantity").parentElement.style.display = '';

                    document.getElementById("quantity").textContent = 'Remaining Quantity: ';

                    form.querySelector('#rwd-id').value = data.reward_id;
                    form.querySelector('#rwd-title').value = data.reward_title;
                    form.querySelector('#rwd-description').value = data.reward_description;
                    form.querySelector('#rwd-point').value = data.reward_required_point;
                    form.querySelector('#rwd-day').value = data.reward_valid_days;
                    form.querySelector('#rwd-quantity').value = data.reward_quantity;
                    form.querySelector('#rwd-redeem-quantity').value = data.redeem_quantity;
                    form.querySelector('#rwd-status').value = data.reward_status;

                    const applicable = data.reward_applicable_to;
                    form.querySelectorAll('[name="rwd-applicable-to[]"]').forEach(cb => {
                        cb.checked = (cb.value === applicable);
                    });

                    const imgContainer = modal.querySelector('#current-image-container');
                    const imgSpan = modal.querySelector('#rwd-content-image');

                    form.querySelector('#current-image-path').value = ''; 

                    if (data.reward_content) {
                        imgContainer.style.display = 'flex';
                        imgSpan.innerHTML = `<img src="${data.reward_content}" alt="Current image" style="max-height:90px; margin-top:5px;">`;
                        form.querySelector('#current-image-path').value = data.reward_content;
                    } else {
                        imgContainer.style.display = 'none';
                        imgSpan.innerHTML = '';
                    }
                }
            });


            //edit reward
            document.querySelectorAll('.edit-btn').forEach(button => {
                button.addEventListener('click', () => {
                    const form = button.closest('form');
                    const unusedQtyEl = form.querySelector('#rwd-redeem-quantity');
                    const unusedQty = unusedQtyEl ? Number(unusedQtyEl.value) : 0;

                    form.querySelector(".form-title").textContent = "Edit Reward";

                    // Fields that can be edited
                    const editableFields = ['#rwd-point', '#rwd-quantity', '#rwd-day'];
                    const checkboxes = form.querySelectorAll('[name="rwd-applicable-to[]"]');

                    if (unusedQty > 0) {
                        // If unused quantity > 0, disable editing
                        editableFields.forEach(selector => {
                            const el = form.querySelector(selector);
                            if (el) {
                                el.setAttribute('readonly', true);
                                el.setAttribute('disabled', true);
                                el.removeAttribute('data-editable');
                            }
                        });
                        checkboxes.forEach(cb => {
                            cb.disabled = true;
                            cb.removeAttribute('data-editable');
                        });
                    } else {
                        editableFields.forEach(selector => {
                            const el = form.querySelector(selector);
                            if (el) {
                                el.removeAttribute('readonly');
                                el.removeAttribute('disabled');
                                el.setAttribute('data-editable', 'true');
                            }
                        });
                        checkboxes.forEach(cb => {
                            cb.disabled = false;
                            cb.setAttribute('data-editable', 'true');
                        });
                    }
                    setEditMode(form);
                });
            });


            //form submit
            document.getElementById("reward-form").addEventListener("submit", function (e) {
                e.preventDefault(); 

                clearErrors();

                const form = this;
                const editableFields = ['#rwd-point', '#rwd-day', '#rwd-quantity'];
                editableFields.forEach(selector => {
                    const el = form.querySelector(selector);
                    if (el.disabled || el.readOnly) {
                        // Remove previous hidden input for the same name if exists
                        const prevHidden = form.querySelector(`input[type="hidden"][name="${el.name}"]`);
                        if (prevHidden) prevHidden.remove();

                        // Create hidden input to submit the value
                        const hidden = document.createElement('input');
                        hidden.type = 'hidden';
                        hidden.name = el.name;
                        hidden.value = el.value;
                        form.appendChild(hidden);
                    }
                });


                form.querySelectorAll('input[type="checkbox"][name="rwd-applicable-to[]"]:disabled').forEach(cb => {
                    if (cb.checked) {
                        // Remove previous hidden input for the same value if exists
                        const prevHidden = form.querySelector(`input[type="hidden"][name="${cb.name}"][value="${cb.value}"]`);
                        if (prevHidden) prevHidden.remove();

                        const hidden = document.createElement('input');
                        hidden.type = 'hidden';
                        hidden.name = cb.name;
                        hidden.value = cb.value;
                        form.appendChild(hidden);
                    }
                });


                //form validation
                fetch("adminPost.php", {
                    method: "POST",
                    body: new FormData(this)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert("Saved successfully");
                        window.location.reload(); 
                    } else {             
                        if (data.title) showError("rwd-error-title", data.title);
                        if (data.description) showError("rwd-error-description", data.description);
                        if (data.applicable_to) showError("rwd-error-applicable-to", data.applicable_to);
                        if (data.point) showError("rwd-error-point", data.point);
                        if (data.quantity) showError("rwd-error-quantity", data.quantity);
                        if (data.day) showError("rwd-error-day", data.day);
                    }
                })
                .catch(err => console.error("Fetch error:", err));
            });

        //add reward
        document.getElementById("add-reward-button").addEventListener("click", function() {
            clearErrors();
            const modal = document.querySelector('.reward-modal');
            const form = document.getElementById("reward-form");

            form.reset();
            
            resetEditableFields(form);

            document.querySelector(".form-title").textContent = "Add New Reward";
            document.getElementById("rwd-content").value = "";
            document.getElementById("rwd-content-image").textContent = "";
            document.getElementById("current-image-container").style.display = "none";


            document.getElementById("rwd-id").parentElement.style.display = 'none';
            modal.querySelector("#rwd-redeem-quantity").parentElement.style.display = 'none';
            document.getElementById("quantity").textContent = 'Quantity: ';

                
            setEditMode(form); 
            openModal(modal);
        });


        //check box
        document.addEventListener('DOMContentLoaded', function() {
            const applicableCheckboxes = document.querySelectorAll('input[name="rwd-applicable-to[]"]');
            
            applicableCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const bothCheckbox = document.querySelector('input[name="rwd-applicable-to[]"][value="BOTH"]');
                    const driverCheckbox = document.querySelector('input[name="rwd-applicable-to[]"][value="DRIVER"]');
                    const userCheckbox = document.querySelector('input[name="rwd-applicable-to[]"][value="USER"]');
                    
                    if (this.value === 'BOTH' && this.checked) {
                        driverCheckbox.checked = false;
                        userCheckbox.checked = false;
                    }
                    
                    if (['DRIVER', 'USER'].includes(this.value) && this.checked) {
                        bothCheckbox.checked = false;
                    }
                    
                    if (driverCheckbox.checked && userCheckbox.checked) {
                        bothCheckbox.checked = true;
                        driverCheckbox.checked = false;
                        userCheckbox.checked = false;
                    }
                });
            });
        });

        
        function resetEditableFields(form) {
            const editableFields = ['#rwd-point', '#rwd-day', '#rwd-quantity'];
            const checkboxes = form.querySelectorAll('[name="rwd-applicable-to[]"]');

            editableFields.forEach(selector => {
                const el = form.querySelector(selector);
                if (el) {
                    el.removeAttribute('readonly');
                    el.removeAttribute('disabled');
                    el.setAttribute('data-editable', 'true');
                    el.value = ''; 
                }
            });

            checkboxes.forEach(cb => {
                cb.disabled = false;
                cb.checked = false; 
                cb.setAttribute('data-editable', 'true');
            });
        }

        //delete reward
        document.addEventListener('click', e => {
            const btn = e.target.closest('.delete-reward');
            if (!btn) return;

            const id = btn.dataset.key;
            if (!confirm('Delete this reward?')) return;

            fetch('adminAPI.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({action: 'delete_reward', id: id})
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    btn.closest('.reward-card').remove();
                } else {
                    alert(data.message || 'Delete failed');
                }
            })
            .catch(() => alert('Server error'));
        });

        </script>
    </body>
</html>