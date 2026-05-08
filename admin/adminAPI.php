<?php 

header('Content-Type: application/json');

include '../global/dbConnection.php';
include 'adminFunction.php';

$data = json_decode(file_get_contents("php://input"), true);



//delete data 
if (isset($data['action'], $data['id']) && in_array($data['action'], ['delete_staff', 'delete_announcement', 'delete_reward'])) {
    $id = $data['id'];
    $success = false;

    if ($data['action'] === 'delete_staff') {
        $success =  deleteData('tbl_staff_info', $id, 'staff_username') &&
                    deleteData('tbl_message', $id, 'message_sender') &&
                    deleteData('tbl_message', $id, 'message_receiver') &&
                    deleteData('tbl_login', $id, 'login_username');
    }

    if ($data['action'] === 'delete_announcement') {
        $success = deleteData('tbl_announcement', $id, 'announcement_id');
    }

    if ($data['action'] === 'delete_reward') {
        $success = deleteData('tbl_reward', $id, 'reward_id');
    }

    echo json_encode($success ? ['success' => true] : ['success' => false, 'message' => mysqli_error($connection)]);
    exit;
}



//user status
if (isset($data['action'], $data['id']) && $data['action'] === 'toggle_user') {
    $username = $data['id'];

    $newStatus = toggleStatus('tbl_login', 'login_status', 'login_username', $username);
    if ($newStatus) {
        echo json_encode(['success' => true, 'newStatus' => $newStatus]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update']);
    }
    exit;
}


//location status
if (isset($data['action'], $data['id']) && $data['action'] === 'toggle_location') {
    $location_id = $data['id'];

    $newStatus = toggleStatus('tbl_location', 'location_status', 'location_id', $location_id, 'ACTIVE', 'INACTIVE');
    if ($newStatus) {
        echo json_encode(['success' => true, 'newStatus' => $newStatus]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update']);
    }
    exit;
}


function toggleStatus($table, $column, $idColumn, $id, $activeValue = 'ACTIVE', $blockedValue = 'BLOCKED') {
    global $connection;
    $query = "SELECT `$column` FROM `$table` WHERE `$idColumn` = '$id'";
    $result = mysqli_query($connection, $query);
    if (!$result || !$row = mysqli_fetch_assoc($result)) {
        return false;
    }

    $newValue = ($row[$column] === $activeValue) ? $blockedValue : $activeValue;

    $updated = saveData($table, [$column => $newValue], $id, $idColumn);

    return $updated ? $newValue : false;
}



//driver request
if (isset($data['action'], $data['request_id']) && in_array($data['action'], ['accept_driver', 'reject_driver'])) {
    $request_id = (int) $data['request_id'];

    if ($data['action'] === 'accept_driver') {
        $requestQuery = "SELECT * FROM tbl_driver_request WHERE request_id = $request_id";
        $reqResult = mysqli_query($connection, $requestQuery);

        if (!$reqResult || !$request = mysqli_fetch_assoc($reqResult)) {
            echo json_encode(['success' => false, 'message' => 'Request not found']);
            exit;
        }

        $name = $request['request_name'];
        $ic = $request['request_ic_passport'];
        $email = $request['request_email'];
        $contact = $request['request_contact'];

        if (checkDuplicate('tbl_user_info', 'user_ic_passport', $ic)) {
            echo json_encode(['success' => false, 'message' => 'IC already exists']);
            exit;
        }

        if (checkDuplicate('tbl_user_info', 'user_email', $email)) {
            echo json_encode(['success' => false, 'message' => 'Email already exists']);
            exit;
        }

        if (checkDuplicate('tbl_user_info', 'user_contact', $contact)) {
            echo json_encode(['success' => false, 'message' => 'Contact already exists']);
            exit;
        }

        $cred = createCredential($name, $ic);
        $username = $cred['username'];
        $password = $cred['password'];

        $profileImage = moveDriverImage($request['request_profile_image']);
        $vehicleImage = moveDriverImage($request['request_vehicle_image']);
        $licenseImage = moveDriverImage($request['request_license_image']);
        $roadTaxImage = moveDriverImage($request['request_road_tax_image']);


        $loginData = ['login_username' => $username, 'login_password' => $password, 'login_role' => 'DRIVER', 'login_status' => 'ACTIVE'];
        saveData('tbl_login', $loginData);

        $userData = [
                        'user_username' => $username,
                        'user_name' => $name,
                        'user_ic_passport' => $ic,
                        'user_gender' => $request['request_gender'],
                        'user_dob' => $request['request_dob'],
                        'user_contact' => $contact,
                        'user_email' => $email,
                    ];
        saveData('tbl_user_info', $userData);


        $driverData = [
                            'driver_username' => $username,
                            'driver_profile_image' => $profileImage,
                            'driver_plate_no' => $request['request_plate_no'],
                            'driver_vehicle_model' => $request['request_vehicle_model'],
                            'driver_vehicle_color' => $request['request_vehicle_color'],
                            'driver_vehicle_image' => $vehicleImage,
                            'driver_license_image' => $licenseImage,
                            'driver_license_expiry' => $request['request_license_expiry'],
                            'driver_road_tax_image' => $roadTaxImage,
                            'driver_road_tax_expiry' => $request['request_road_tax_expiry']
                        ];
        saveData('tbl_driver_info', $driverData);
    }


    if ($data['action'] === 'reject_driver') {
        $requestQuery = "   SELECT request_profile_image, request_vehicle_image, request_license_image, request_road_tax_image 
                            FROM tbl_driver_request WHERE request_id = $request_id";
        $reqResult = mysqli_query($connection, $requestQuery);
        
        if ($reqResult && $request = mysqli_fetch_assoc($reqResult)) {
            $images = [$request['request_profile_image'], $request['request_vehicle_image'], $request['request_license_image'], $request['request_road_tax_image']];
            
            foreach ($images as $imgPath) {
                if (file_exists($imgPath)) {
                    @unlink($imgPath); 
                }
            }
        }
    }

    //delete update requets after accept ot reject
    deleteData('tbl_driver_request', $request_id, 'request_id');
    echo json_encode(['success'=>true]);
    exit;
}




//driver new vehicle update request
if (isset($data['action'], $data['update_id']) && in_array($data['action'], ['approve_update', 'reject_update'])) {
    $update_id = (int)$data['update_id'];

    $updateQuery = "SELECT * FROM tbl_driver_update WHERE update_id = $update_id";
    $updateResult = mysqli_query($connection, $updateQuery);

    if (!$updateResult || !($update = mysqli_fetch_assoc($updateResult))) {
        echo json_encode(['success' => false, 'message' => 'Update request not found']);
        exit;
    }

    if ($data['action'] === 'approve_update') {

        $currentQuery = "SELECT driver_vehicle_image, driver_road_tax_image FROM tbl_driver_info  WHERE driver_username = '{$update['update_driver_username']}'";
        $currentResult = mysqli_query($connection, $currentQuery);
        $current = mysqli_fetch_assoc($currentResult);

        $oldImages = [$current['driver_vehicle_image'] ?? null, $current['driver_road_tax_image'] ?? null];

        $vehicleImage = moveDriverImage($update['update_vehicle_image']);
        $roadTaxImage = moveDriverImage($update['update_road_tax_image']);

        if (in_array($vehicleImage, ['FILE NOT FOUND', 'FAILED TO MOVE']) || in_array($roadTaxImage, ['FILE NOT FOUND', 'FAILED TO MOVE'])) {
            echo json_encode(['success' => false, 'message' => 'Image processing failed']);
            exit;
        }

        $driverData = [
                            'driver_plate_no' => $update['update_plate_no'],
                            'driver_vehicle_model' => $update['update_vehicle_model'],
                            'driver_vehicle_color' => $update['update_vehicle_color'],
                            'driver_vehicle_image' => $vehicleImage,
                            'driver_road_tax_image' => $roadTaxImage,
                            'driver_road_tax_expiry' => $update['update_road_tax_expiry']
                        ];

        try {
            saveData('tbl_driver_info', $driverData, $update['update_driver_username'], 'driver_username');

            foreach ($oldImages as $img) {
                if (!$img) continue;
                if ($img === $vehicleImage || $img === $roadTaxImage) continue;

                if (file_exists($img)) {
                    unlink($img);
                }
            }

        } catch (Exception $e) {

            foreach ([$vehicleImage, $roadTaxImage] as $img) {
                if ($img && file_exists($img)) {
                    unlink($img);
                }
            }
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
            exit;
        }
    }

    if ($data['action'] === 'reject_update') {
        $images = [$update['update_vehicle_image'], $update['update_road_tax_image']];

        foreach ($images as $img) {
            if ($img && file_exists($img)) {
                unlink($img);
            }
        }
    }

    deleteData('tbl_driver_update', $update_id, 'update_id');
    echo json_encode(['success' => true]);
    exit;
}


?>