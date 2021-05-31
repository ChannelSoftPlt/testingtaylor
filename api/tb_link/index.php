<?php
include 'tb_link_function.php';
$db = new tb_link_function();

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
    $response['tb_link'] = $read;
    echo json_encode($response);

}
/**
 * getServiceProvider
 */
else if (isset($_POST['getServiceProvider']) && isset($_POST['service_id'])) {
    $read     = $db->getServiceProvider($_POST['service_id']);
    $response['status']   = ($read ? '1' : '2');
    $response['tb_link'] = $read;
    echo json_encode($response);

}
/**
 * create
 * */
else if (isset($_POST['create']) && isset($_POST['service_id']) && isset($_POST['provider_id'])) {
    $create = $db->create(array( $_POST['provider_id'], $_POST['service_id'], $created_at));
    $response['status'] = ($create ? '1' : '2');
    echo json_encode($response);
}
/**
 * update
 * */
else if (isset($_POST['update']) && isset($_POST['service_id']) && isset($_POST['provider_id']) && isset($_POST['link_id'])) {
    $update = $db->update(array($updated_at, $_POST['service_id'], $_POST['provider_id'], $_POST['link_id']));
    $response['status'] = ($update ? '1' : '2');
    echo json_encode($response);
}
/**
 * delete
 * */
else if (isset($_POST['delete']) && isset($_POST['link_id'])) {
    $delete         = $db->delete(array($soft_delete, $_POST['link_id']));
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
