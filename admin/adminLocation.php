<?php 
include '../global/dbConnection.php';


$locationQuery = "SELECT location_id, location_name, location_status FROM tbl_location ORDER BY location_id ASC;";
$locationResult = mysqli_query($connection, $locationQuery);
if (!$locationResult) {
    die("Query failed: " . mysqli_error($connection));
}

$locationBarQuery = "   
                        SELECT l.location_id, l.location_name, COUNT(t.trip_id) AS total_rides, COALESCE(SUM(t.trip_co2_kg), 0) AS total_co2_saved
                        FROM tbl_location l LEFT JOIN tbl_ride_offer o  ON l.location_id = o.offer_location_id LEFT JOIN tbl_trip_history t 
                        ON o.offer_id = t.trip_offer_id WHERE l.location_status = 'ACTIVE' GROUP BY l.location_id, l.location_name ORDER BY total_rides DESC;
                    ";
$locationBarResult = mysqli_query($connection, $locationBarQuery);
if (!$locationBarResult) {
    die("Query failed: " . mysqli_error($connection));
}


$locations = [];
$maxRides = 0;
$maxCO2   = 0;

while ($row = mysqli_fetch_assoc($locationBarResult)) {
    $locations[] = $row;

    if ($row['total_rides'] > $maxRides) {
        $maxRides = $row['total_rides'];
    }
    if ($row['total_co2_saved'] > $maxCO2) {
        $maxCO2 = $row['total_co2_saved'];
    }
}

?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Location Management</title>
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
        <link rel="stylesheet" href="adminLocation.css">
    </head>
    <body>
        <?php include 'adminMenu.php'; ?>
        <main>
            <div class="page-container">
                <div class="page-header card">
                    <div class="page-header-title">
                        <h1 class="menu-title flex-icon"><i class="fa-solid fa-location-dot"></i>Location Management</h1>
                        <p>View and control locations across the platform</p>
                    </div>
                    <div class="page-header-action">
                        <button type="button" class="add-button flex-icon" id="add-location-button">
                            <i class="fa-solid fa-plus"></i>Location
                        </button>
                    </div>
                </div> 

                <div class="add-location">
                    <form data-mode="add-only" id="location-form">
                        <h2 class="form-title">Add New Location</h2>
                        <div class="form-group">
                            <div class="input-row">
                                <input type="hidden" name="form-type" value="location">
                                <input id="location-input" type="text" name="name" placeholder="Enter new location name">
                                <button type="submit" id="add-location-btn"><i class="fa-solid fa-circle-plus"></i></button>
                            </div>
                            <div class="error" id="location-error-name"></div>
                        </div>
                    </form>
                </div>

                <div class="location-co2 chart card">
                    <h3><i class="fa-solid fa-chart-simple"></i> Total CO<sub>2</sub> Saved (kg) by Locations</h3>

                    <?php   
                        foreach ($locations as $barRow): 
                            $width = ($maxCO2 > 0) ? ($barRow['total_co2_saved'] / $maxCO2) * 100 : 0;
                    ?>
                        <div class="bar-row">
                            <span class="location-label" ><?= htmlspecialchars($barRow['location_name']) ?></span>

                            <div class="bar-track">
                                <div class="bar-fill" style="--bar-width: <?= $width ?>%"></div>
                            </div>

                            <span class="value"><?= number_format($barRow['total_co2_saved'], 2) ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>


                <div class="location-table">
                    <table class="table-style">
                        <colgroup>
                            <col style="width: 20%">
                            <col style="width: 40%">
                            <col style="width: 25%">
                            <col style="width: 15%">
                        </colgroup>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Action</th>
                                <th>Edit</th>
                            </tr>
                        </thead>

                        <tbody>
                        <?php while($row = mysqli_fetch_assoc($locationResult)): ?>
                            <tr>
                                <td><?= $row['location_id']?></td>
                                <td class="location-name-status">
                                    <form class="location-name-form">
                                        <textarea
                                            name="name"
                                            data-original="<?= htmlspecialchars($row['location_name']) ?>"
                                            readonly
                                            rows="1"
                                            data-editable
                                        ><?= htmlspecialchars($row['location_name']) ?></textarea>
                                    </form>
                                    <div class="status">
                                        <i class="status-icon"></i>
                                        <span class="status-text"><?= htmlspecialchars($row['location_status']) ?></span>
                                    </div>
                                </td>
                                <td>
                                    <button class="toggle-status-btn"
                                            data-key="<?= $row['location_id'] ?>"
                                            data-status="<?= $row['location_status'] ?>"
                                            data-action="toggle_location">
                                        <?= $row['location_status'] === 'ACTIVE' ? 'Inactivate' : 'Activate' ?>
                                    </button>
                                </td>
                                <td>
                                    <button type="button" class="edit-btn">
                                        <i class="fa-regular fa-pen-to-square click-icon"></i>
                                    </button>
                                    <button type="submit" class="save-btn" style="display:none;" data-key="<?= $row['location_id'] ?>">
                                        <i class="fa-regular fa-floppy-disk click-icon"></i>
                                    </button>
                                </td>
                                
                            </tr>
                        <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>


        <?php include '../global/footer.php'; ?>
        <script src="admin.js"></script>
        <script>


            //trigger add location form to display
            const addLocationBtn = document.getElementById('add-location-button');
            const addLocationForm = document.querySelector('.add-location');
            addLocationBtn.addEventListener('click', () => {
                if (!addLocationForm) return;

                const isActive = addLocationForm.classList.toggle('location-active');
                const input = addLocationForm.querySelector('input[name="name"]');
                if (isActive && input) {
                    input.value = '';
                }
                clearErrors();

                addLocationBtn.innerHTML = isActive ? '<i class="fa-solid fa-xmark"></i> Cancel' : '<i class="fa-solid fa-plus"></i> Location';
            });



            //add location
            document.getElementById("location-form").addEventListener("submit", function (e) {
                e.preventDefault();

                clearErrors();

                fetch("adminPOST.php", {
                    method: "POST",
                    body: new FormData(this)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert("Location Added");
                        window.location.reload(); 
                    } else {
                        if (data.name) showError("location-error-name", data.name);
                    }
                })
                .catch(err => console.error("Fetch error:", err));
            });

            

            //edit location
            document.querySelectorAll('.edit-btn').forEach(editBtn => {
                editBtn.addEventListener('click', () => {
                    const row = editBtn.closest('tr');
                    const input = row.querySelector('[data-editable]');
                    const saveBtn = row.querySelector('.save-btn');

                    const resetTextArea = () => {
                        input.setAttribute('readonly', true);
                        input.classList.remove('editing');
                        saveBtn.style.display = 'none';
                        editBtn.style.display = 'flex';
                    };

                    input.removeAttribute('readonly');
                    input.classList.add('editing');
                    input.focus();

                    editBtn.style.display = 'none';
                    saveBtn.style.display = 'flex';

                    saveBtn.addEventListener('click', (e) => {
                        e.preventDefault();

                        const formData = new FormData();
                        formData.append('form-type', 'location');
                        formData.append('id', saveBtn.dataset.key);
                        formData.append('name', input.value.trim());

                        fetch('adminPOST.php', {
                            method: 'POST',
                            body: formData
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                alert("Location Changed");
                                window.location.reload(); 
                            } else {
                                alert(data.name || 'Error saving location');
                                input.value = input.dataset.original; // set back original data
                                resetTextArea();
                            }
                        })
                        .catch(err => {
                            console.error(err);
                            input.value = input.dataset.original;
                            resetTextArea();
                        });
                    }, { once: true });
                });
            });


            //auto resize textarea
            function autoResizeTextarea(textarea) {
                textarea.style.height = 'auto'; 
                textarea.style.height = textarea.scrollHeight + 'px';
            }

            document.querySelectorAll('textarea[data-editable]').forEach(textarea => {
                autoResizeTextarea(textarea);
                textarea.addEventListener('input', () => autoResizeTextarea(textarea));
                textarea.addEventListener('focus', () => autoResizeTextarea(textarea));
                textarea.addEventListener('blur', () => autoResizeTextarea(textarea));
            });


        </script>
    </body>
</html>