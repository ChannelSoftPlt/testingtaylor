<?php
include 'holiday_function.php';
$db = new holiday_function();

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');

// json response array
$response   = array();
$created_at = $updated_at = $soft_delete = (new DateTime('NOW', new DateTimeZone('Asia/Kuala_Lumpur')))->format('Y-m-d H:i:s');
/**
 * read
 */
if (isset($_POST['read'])&&isset($_POST['branch_id'])) {
    $read     = $db->read($_POST['branch_id']);
    $response['status']   = ($read ? '1' : '2');
    $response['holiday'] = $read;
    echo json_encode($response);

}
/**
 * create
 * */
else if (isset($_POST['create']) && isset($_POST['date']) && isset($_POST['branch_id'])) {
    $create = $db->create(array( $_POST['branch_id'],$_POST['date'],$created_at));
    $response['status'] = ($create ? '1' : '2');
    echo json_encode($response);
}
/**
 * update
 * */
else if (isset($_POST['update']) && isset($_POST['date']) && isset($_POST['branch_id'])) {
    $update = $db->update(array($_POST['date'],$updated_at, $_POST['branch_id']));
    $response['status'] = ($update ? '1' : '2');
    echo json_encode($response);
}
/**
 * delete
 * */
else if (isset($_POST['delete']) && isset($_POST['holiday_id'])) {
    $delete         = $db->delete(array($soft_delete, $_POST['holiday_id']));
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
