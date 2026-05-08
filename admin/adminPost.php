<?php

include '../global/dbConnection.php';
include 'adminFunction.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit;
}

$formType = $_POST['form-type'] ?? '';

switch ($formType) {

    case 'announcement':
        $result = validateAnnouncement($_POST, $_FILES);
        if (!empty($result['errors'])) {
            echo json_encode($result['errors']);
            exit;
        }
        $sql_result = saveData('tbl_announcement', $result['data'], $_POST['id'] ?? null,'announcement_id');
        echo json_encode(['success' => $sql_result]);
        exit;



    case 'reward':
        $result = validateReward($_POST, $_FILES);
        if (!empty($result['errors'])) {
            echo json_encode($result['errors']);
            exit;
        }
        $sql_result = saveData('tbl_reward', $result['data'], $_POST['id'] ?? null,'reward_id');
        echo json_encode(['success' => $sql_result]);
        exit;



    case 'staff':
        $result = validateStaff($_POST);
        if (!empty($result['errors'])) {
            echo json_encode($result['errors']);
            exit;
        }
        $staffData = $result['data'];
        $cred = createCredential($staffData['staff_name'], $staffData['staff_ic_passport']);
        $staffData['staff_username'] = $cred['username'];

        $sql_result_1 = saveData('tbl_login', ['login_username' => $cred['username'], 'login_password' => $cred['password'], 'login_role' => 'STAFF',]);
        $sql_result_2 = saveData('tbl_staff_info', $staffData);
        echo json_encode(['success' => $sql_result_1 && $sql_result_2]);
        exit;



    case 'location':
        $result = validateLocation($_POST);
        if (!empty($result['errors'])) {
            echo json_encode($result['errors']);
            exit;
        }
        $sql_result = saveData('tbl_location', $result['data'], $_POST['id'] ?? null , 'location_id');
        echo json_encode(['success' => $sql_result]);
        exit;



    default:
        http_response_code(400);
        echo json_encode(['form' => 'Invalid form type']);
        exit;
}





?>

