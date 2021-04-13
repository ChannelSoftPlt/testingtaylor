<?php
include 'booking_function.php';
$db = new booking_function();

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');

// json response array
$response   = array();
$created_at = $updated_at = $soft_delete = (new DateTime('NOW', new DateTimeZone('Asia/Kuala_Lumpur')))->format('Y-m-d H:i:s');
/**
 * read
 */
if (isset($_POST['read'])&&isset($_POST['selected_date'])&&isset($_POST['service_id'])) {
    $read     = $db->read($_POST['selected_date'],$_POST['service_id']);
    $response['status']   = ($read ? '1' : '2');
    $response['booking'] = $read;
    echo json_encode($response);

}
/**
 * create
 * */
else if (isset($_POST['create'])&& isset($_POST['person']) && isset($_POST['customer_id']) 
         && isset($_POST['selected_date']) && isset($_POST['duration']) && isset($_POST['selected_time']) 
         && isset($_POST['service_id'])&& isset($_POST['service_title']) && isset($_POST['service_description'])) {
    $create = $db->create(array($_POST['service_id'], $_POST['selected_time'], $_POST['duration'], $_POST['service_title'], $_POST['service_description'],
                                $_POST['selected_date'],$_POST['person'], $_POST['customer_id'], $created_at));
    $response['status'] = ($create ? '1' : '2');
    $response['booking'] = $create;
    echo json_encode($response);
}
/**
 * update
 * */
else if (isset($_POST['update']) && isset($_POST['status']) && isset($_POST['customer_id']) && isset($_POST['selected_date']) && isset($_POST['duration']) && isset($_POST['selected_time']) && isset($_POST['service_id']) && isset($_POST['booking_id'])) {
    $update = $db->update(array($updated_at, $_POST['status'], $_POST['customer_id'], $_POST['selected_date'], $_POST['duration'], $_POST['selected_time'], $_POST['service_id'], $_POST['booking_id']));
    $response['status'] = ($update ? '1' : '2');
    echo json_encode($response);
}
/**
 * delete
 * */
else if (isset($_POST['delete']) && isset($_POST['booking_id'])) {
    $delete         = $db->delete(array($soft_delete, $_POST['booking_id']));
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
