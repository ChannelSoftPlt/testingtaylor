<?php
include 'user_function.php';
$db = new user_function();

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');

// json response array
$response   = array();
$created_at = $updated_at = $soft_delete = (new DateTime('NOW', new DateTimeZone('Asia/Kuala_Lumpur')))->format('Y-m-d H:i:s');
/**
 * read
 */
if (isset($_POST['read'])) {
    $read     = $db->read();
    $response['status']   = ($read ? '1' : '2');
    $response['user'] = $read;
    echo json_encode($response);

}
/**
 * login
 */
else if (isset($_POST['login']) && isset($_POST['password']) && isset($_POST['email'])) {
    $read = $db->login($_POST['email'], $_POST['password']);
    $response['status'] = ($read ? '1' : '2');
    $response['user'] = $read;
    echo json_encode($response);

}
/**
 * register
 * */
else if (isset($_POST['create']) && isset($_POST['name'])&& isset($_POST['email']) && isset($_POST['contact']) && isset($_POST['password'])) {

    if ($db->isEmailExisted($_POST['email'])) {
        $status = 'User Existed!';
    } else {
        $hash = $db->hashSSHA($_POST['password']);
        $encrypted_password = $hash["password_encrypted"]; // encrypted password
        $salt = $hash["salt"]; // salt
        $create = $db->create(array($_POST['name'], $_POST['contact'], $_POST['email'], $encrypted_password, $salt, $created_at ));
        $status ='1';
    }
    $response['status'] = $status;
    echo json_encode($response);
}
// /**
//  * create
//  * */
// else if (isset($_POST['create']) && isset($_POST['address']) && isset($_POST['salt']) && isset($_POST['password']) && isset($_POST['email']) && isset($_POST['contact']) && isset($_POST['role']) && isset($_POST['name'])) {
//     $create = $db->create(array($created_at, $_POST['address'], $_POST['salt'], $_POST['password'], $_POST['email'], $_POST['contact'], $_POST['role'], $_POST['name']));
//     $response['status'] = ($create ? '1' : '2');
//     echo json_encode($response);
// }
/**
 * update
 * */
else if (isset($_POST['update']) && isset($_POST['address']) && isset($_POST['salt']) && isset($_POST['password']) && isset($_POST['email']) && isset($_POST['contact']) && isset($_POST['role']) && isset($_POST['name']) && isset($_POST['user_id'])) {
    $update = $db->update(array($updated_at, $_POST['address'], $_POST['salt'], $_POST['password'], $_POST['email'], $_POST['contact'], $_POST['role'], $_POST['name'], $_POST['user_id']));
    $response['status'] = ($update ? '1' : '2');
    echo json_encode($response);
}
/**
 * delete
 * */
else if (isset($_POST['delete']) && isset($_POST['user_id'])) {
    $delete         = $db->delete(array($soft_delete, $_POST['user_id']));
    $response['status'] = ($delete ? '1' : '2');
    echo json_encode($response);
}
/**
 * missing parameter
 * */
else {
    $response['status'] = '4';
    echo json_encode($response);
}
?>
