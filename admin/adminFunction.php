<?php

include '../global/dbConnection.php';


//save data (insert n update)
function saveData($table, $data, $id = null, $idColumn = 'id') {
    global $connection;

    if (!$data) throw new InvalidArgumentException("No data provided for saving data");

    $isUpdate = !empty($id);

    if ($isUpdate) {
        $set = []; $types = ''; $values = [];
        foreach ($data as $col => $val) {
            $set[] = "$col = ?";
            $types .= 's';
            $values[] = $val;
        }
        $query = "UPDATE $table SET " . implode(', ', $set) . " WHERE $idColumn = ?";
        $stmt = mysqli_prepare($connection, $query);
        $types .= 's';  
        $values[] = $id;
    } else {
        $columns = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_fill(0, count($data), '?'));
        $query = "INSERT INTO $table ($columns) VALUES ($placeholders)";
        $stmt = mysqli_prepare($connection, $query);
        $types = str_repeat('s', count($data));
        $values = array_values($data);
    }

    if (!$stmt) throw new Exception("Prepare failed: " . mysqli_error($connection));

    mysqli_stmt_bind_param($stmt, $types, ...$values); 
    if (!mysqli_stmt_execute($stmt)) throw new Exception("Query failed: " . mysqli_stmt_error($stmt));

    mysqli_stmt_close($stmt);
    return true; 
}




//delete function
function deleteData($table, $id, $idColumn){
    global $connection;

    if (is_numeric($id)) {
        $type = 'i';
    } else {
        $type = 's';
    }

    $query = "DELETE FROM `$table` WHERE `$idColumn` = ?";

    $stmt = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($stmt, $type, $id);

    return mysqli_stmt_execute($stmt); 
}




//validate annoucement
function validateAnnouncement($annPost, $annFiles) {

    $errors = [];
    $title = trim($annPost['title'] ?? '');
    $description = trim($annPost['description'] ?? '');
    $status = $annPost['status'] ?? 'INACTIVE';
    $groups = $annPost['ann-applicable-to'] ?? [];
    $currentImagePath = $annPost['current-image-path'] ?? null;
    $removeImage = !empty($annPost['remove_image']);

    if ($title === '') {$errors['title'] = 'Title is required';}
    if ($description === '') {$errors['description'] = 'Description is required';}
    if (empty($groups)) {$errors['applicable_to'] = 'At least one applicable group must be selected';}

    if ($errors) {return ['errors' => $errors];}

    $validGroups = ['DRIVER', 'USER', 'STAFF'];
    if (in_array('ALL', $groups) || !array_diff($validGroups, $groups)) {
        $groups = ['ALL'];
    }

    if ($removeImage && $currentImagePath && file_exists($currentImagePath)) {
        unlink($currentImagePath);
        $currentImagePath = null;
    }

    try {
        $isEdit = !empty($annPost['id']);
        $imgPath = uploadImage($annFiles['content'] ?? [], 'ann', '../upload/announcement/', $currentImagePath, $isEdit);
    } catch (Exception $e) {
        return ['errors' => [$e->getMessage()]];
    }

    if ($imgPath === '') $imgPath = null;
    $data = [   
                "announcement_title" => $title, 
                "announcement_description" => $description, 
                "announcement_status" => $status, 
                "announcement_applicable_to" => implode(',', $groups)
            ];

    if ($removeImage) {
        $data['announcement_content'] = null; 
    } elseif ($imgPath !== null && $imgPath !== '') {
        $data['announcement_content'] = $imgPath;
    }
    
    return ['data' => $data];

}



    

function validateReward($rwdPost, $rwdFiles) {
    $errors = [];
    $title = trim($rwdPost['title'] ?? '');
    $description = trim($rwdPost['description'] ?? '');
    $status = $rwdPost['status'] ?? 'INACTIVE';
    $groups = $rwdPost['rwd-applicable-to'] ?? [];
    $point = $rwdPost['point'] ?? null;
    $day = $rwdPost['day'] ?? null;
    $quantity= $rwdPost['quantity'] ?? null;
    $currentImagePath = $rwdPost['current-image-path'] ?? null;
    $removeImage = !empty($rwdPost['remove_image']);


    if ($title === '') {$errors['title'] = 'Title is required';}
    if ($description === '') {$errors['description'] = 'Description is required';}
    if (empty($groups)) {$errors['applicable_to'] = 'At least one applicable group must be selected';}

    
    if ($quantity === null || $quantity === '' || !ctype_digit((string)$quantity) || (int)$quantity < 0) {
        $errors['quantity'] = 'Quantity must be 0 or more';
    }

    $allowedDays = [7, 14, 30, 60, 90, 365];
    if ($day !== null && !in_array((int)$day, $allowedDays, true)) {
        $errors['day'] = 'Invalid valid days';
    }

    $allowedPoints = [50, 100, 300, 500, 800, 1000, 1500];
    if ($point !== null && !in_array((int)$point, $allowedPoints, true)) {
        $errors['point'] = 'Invalid required point';
    }

    if ($errors) {return ['errors' => $errors];}

    $validGroups = ['DRIVER', 'USER'];
    if (in_array('BOTH', $groups) || !array_diff($validGroups, $groups)) {
        $groups = ['BOTH'];
    }

    if ($removeImage && $currentImagePath && file_exists($currentImagePath)) {
        unlink($currentImagePath);
        $currentImagePath = null;
    }

    try {
        $isEdit = !empty($rwdPost['id']);
        $imgPath = uploadImage($rwdFiles['content'] ?? [], 'rwd', '../upload/reward/', $currentImagePath, $isEdit);
    } catch (Exception $e) {
        return ['errors' => [$e->getMessage()]];
    }

    $data = [
                "reward_title" => $title,
                "reward_description" => $description,
                "reward_required_point" => (int)$point,
                "reward_valid_days" => (int)$day,
                "reward_quantity" => (int)$quantity,
                "reward_status" => $status,
                "reward_applicable_to" => implode(',', $groups)
            ];

    if ($removeImage) {
        $data['reward_content'] = null; 
    } elseif ($imgPath !== null && $imgPath !== '') {
        $data['reward_content'] = $imgPath;
    }

    return ['data' => $data];
}






//staff validation
function validateStaff($staffPost) {
    $errors = [];
    $name = ucwords(strtolower(trim($staffPost['name'] ?? '')), " -'");
    $ic_passport = trim($staffPost['ic_passport'] ?? '');
    $dob = trim($staffPost['dob'] ?? '');
    $gender = trim($staffPost['gender'] ?? '');
    $contact = trim($staffPost['contact'] ?? '');
    $email = trim($staffPost['email'] ?? '');

    if ($name === '') $errors['name'] = 'Full name is required';
    if ($ic_passport === '') $errors['ic_passport'] = 'IC / Passport is required';
    if ($dob === '') $errors['dob'] = 'Date of birth is required';
    if ($gender === '') $errors['gender'] = 'Gender is required';
    if ($contact === '') $errors['contact'] = 'Contact is required';
    if ($email === '') $errors['email'] = 'Email is required';

    if ($email) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Invalid email format';
        } elseif (checkDuplicate('tbl_staff_info', 'staff_email', $email) || checkDuplicate('tbl_user_info', 'user_email', $email)) {
            $errors['email'] = 'Email already exists';
        }
    }

    if ($contact && !preg_match('/^(011-\d{8}|01[0-9]-\d{7})$/', $contact)) {
        $errors['contact'] = 'Contact must be in format 011-11111111 or 012-3456789';
    }

    if ($ic_passport && !preg_match('/^(?:\d{6}-\d{2}-\d{4}|[A-Z0-9]{6,12})$/i', $ic_passport)) {
        $errors['ic_passport'] = 'Invalid IC or passport format';
    }

    if ($dob) {
        $dobDate = strtotime($dob);
        if ($dobDate === false || $dobDate > time()) {
            $errors['dob'] = 'Date of birth cannot be in the future';
        }
    }

    if ($contact && (checkDuplicate('tbl_staff_info', 'staff_contact', $contact) || checkDuplicate('tbl_user_info', 'user_contact', $contact))) {
        $errors['contact'] = 'Contact already exists';
    }

    if ($ic_passport && (checkDuplicate('tbl_staff_info', 'staff_ic_passport', $ic_passport) || checkDuplicate('tbl_user_info', 'user_ic_passport', $ic_passport))) {
        $errors['ic_passport'] = 'IC / Passport already exists';
    }

    if ($errors) {return ['errors' => $errors];}

    $data = [
                "staff_name" => $name,
                "staff_ic_passport" => strtoupper($ic_passport),
                "staff_dob"=> $dob,
                "staff_gender" => $gender,
                "staff_contact" => $contact,
                "staff_email" => $email,
            ];

    return ['data' => $data];
}







//upload image
function uploadImage($file, $prefix, $dir, $oldPath = null, $isEdit = false) {

    if (empty($file['name'])) return $isEdit ? $oldPath : null;
    
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
        throw new Exception('Invalid image format');
    }

    if (!is_dir($dir)) mkdir($dir, 0755, true);

    $filename = $prefix . '_' . time() . '_' . bin2hex(random_bytes(4)) . ".$ext";
    $path = $dir . $filename;

    if (!move_uploaded_file($file['tmp_name'], $path)) {
        throw new Exception('Upload failed');
    }

    if ($isEdit && $oldPath && file_exists($oldPath)) {
        unlink($oldPath);
    }

    return $path;
}





//move driver image for update / request
function moveDriverImage($originalFilePath) {
    if (empty($originalFilePath) || !file_exists($originalFilePath)) {
        throw new Exception('File not found');
    }

    $originalFileName = basename($originalFilePath);

    $filename = preg_replace('/^(request|update|driver)_/', 'driver_', $originalFileName);

    $dir = '../upload/driverInfo/';
    if (!is_dir($dir)) mkdir($dir, 0755, true);

    $path = $dir . $filename;

    if (!rename($originalFilePath, $path)) {
        throw new Exception('Failed to move file');
    }

    return $path;
}




//check duplicate in database
function checkDuplicate($table, $column, $value) {
    global $connection;
    $sql = "SELECT 1 FROM `$table` WHERE `$column` = ? LIMIT 1";
    $stmt = mysqli_prepare($connection, $sql);
    mysqli_stmt_bind_param($stmt, "s", $value);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    $exists = mysqli_stmt_num_rows($stmt) > 0;
    mysqli_stmt_close($stmt);

    return $exists;
}




//create new account
function createCredential($name, $ic_passport) {
    $cleanName = strtolower(preg_replace('/\s+/', '', $name));
    $username = $cleanName . $ic_passport;
    $password = password_hash($ic_passport, PASSWORD_DEFAULT);
    
    return ["username" => $username, "password" => $password];
}




//location validation
function validateLocation($locationPost) {
    global $connection;

    $errors = [];
    $name = trim($locationPost['name'] ?? '');
    $id   = intval($locationPost['id'] ?? 0);

    if ($name === '') $errors['name'] = 'Location cannot be empty';

    if ($name) {
        if ($id > 0) {
            $query = "SELECT location_name FROM tbl_location WHERE location_id = ? LIMIT 1";
            $stmt = mysqli_prepare($connection, $query );
            mysqli_stmt_bind_param($stmt, 'i', $id);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result($stmt, $originalName);
            mysqli_stmt_fetch($stmt);
            mysqli_stmt_close($stmt);

            if ($originalName !== $name && checkDuplicate('tbl_location', 'location_name', $name)) {
                $errors['name'] = 'Location already exists';
            }
        } else {
            if (checkDuplicate('tbl_location', 'location_name', $name)) {
                $errors['name'] = 'Location already exists';
            }
        }
    }

    if ($errors) return ['errors' => $errors];

    return ['data' => ['location_name' => $name]];
}


?>