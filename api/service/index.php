<?php
include 'service_function.php';
$db = new service_function();

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');

// json response array
$response   = array();
$created_at = $updated_at = $soft_delete = (new DateTime('NOW', new DateTimeZone('Asia/Kuala_Lumpur')))->format('Y-m-d H:i:s');
/**
 * read
 */
if (isset($_POST['read']) && isset($_POST['branch_id'])&& isset($_POST['seat'])) {
    $read     = $db->read($_POST['branch_id'],$_POST['seat']);
    $response['status']   = ($read ? '1' : '2');
    $response['service'] = $read;
    echo json_encode($response);

}

else if (isset($_POST['findMaxPerson']) && isset($_POST['branch_id'])) {
    $read     = $db->findMaxPerson($_POST['branch_id']);
    $response['status']   = ($read ? '1' : '2');
    $response['service'] = $read;
    echo json_encode($response);

}
/**
 * create
 * */
else if (isset($_POST['create']) && isset($_POST['status']) && isset($_POST['slot']) && isset($_POST['duration']) && isset($_POST['price']) && isset($_POST['description']) && isset($_POST['title']) && isset($_POST['branch_id'])) {
    $create = $db->create(array($created_at, $_POST['status'], $_POST['slot'], $_POST['duration'], $_POST['price'], $_POST['description'], $_POST['title'], $_POST['branch_id']));
    $response['status'] = ($create ? '1' : '2');
    echo json_encode($response);
}
/**
 * update
 * */
else if (isset($_POST['update']) && isset($_POST['status']) && isset($_POST['slot']) && isset($_POST['duration']) && isset($_POST['price']) && isset($_POST['description']) && isset($_POST['title']) && isset($_POST['branch_id']) && isset($_POST['service_id'])) {
    $update = $db->update(array($updated_at, $_POST['status'], $_POST['slot'], $_POST['duration'], $_POST['price'], $_POST['description'], $_POST['title'], $_POST['branch_id'], $_POST['service_id']));
    $response['status'] = ($update ? '1' : '2');
    echo json_encode($response);
}
/**
 * delete
 * */
else if (isset($_POST['delete']) && isset($_POST['service_id'])) {
    $delete         = $db->delete(array($soft_delete, $_POST['service_id']));
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
