<?php
include 'branch_function.php';
$db = new branch_function();

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');

// json response array
$response   = array();
$created_at = $updated_at = $soft_delete = (new DateTime('NOW', new DateTimeZone('Asia/Kuala_Lumpur')))->format('Y-m-d H:i:s');
/**
 * read
 */
if (isset($_POST['read']) && isset($_POST['company_id']) ) {
    $read     = $db->read($_POST['company_id']);
    $response['status']   = ($read ? '1' : '2');
    $response['branch'] = $read;
    echo json_encode($response);

}
/**
 * create
 * */
else if (isset($_POST['create']) && isset($_POST['user_id']) && isset($_POST['working_time']) && isset($_POST['working_day']) && isset($_POST['address']) && isset($_POST['name']) && isset($_POST['company_id'])) {
    $create = $db->create(array($created_at, $_POST['user_id'], $_POST['working_time'], $_POST['working_day'], $_POST['address'], $_POST['name'], $_POST['company_id']));
    $response['status'] = ($create ? '1' : '2');
    echo json_encode($response);
}
/**
 * update
 * */
else if (isset($_POST['update']) && isset($_POST['user_id']) && isset($_POST['working_time']) && isset($_POST['working_day']) && isset($_POST['address']) && isset($_POST['name']) && isset($_POST['company_id']) && isset($_POST['branch_id'])) {
    $update = $db->update(array($updated_at, $_POST['user_id'], $_POST['working_time'], $_POST['working_day'], $_POST['address'], $_POST['name'], $_POST['company_id'], $_POST['branch_id']));
    $response['status'] = ($update ? '1' : '2');
    echo json_encode($response);
}
/**
 * delete
 * */
else if (isset($_POST['delete']) && isset($_POST['branch_id'])) {
    $delete         = $db->delete(array($soft_delete, $_POST['branch_id']));
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
