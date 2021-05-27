<?php
include 'provider_function.php';
$db = new provider_function();

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
    $response['provider'] = $read;
    echo json_encode($response);

}
else if (isset($_POST['getAllProvider'])&& isset($_POST['service_id']) ) {
    $read     = $db->getAllProvider($_POST['service_id']);
    $response['status']   = ($read ? '1' : '2');
    $response['provider'] = $read;
    echo json_encode($response);

}
// else if (isset($_POST['getProviderInfo'])&& isset($_POST['provider_id']) ) {
//     $read     = $db->getProviderInfo($_POST['provider_id']);
//     $response['status']   = ($read ? '1' : '2');
//     $response['provider'] = $read;
//     echo json_encode($response);

// }
else if (isset($_POST['getProviderByCompany'])&& isset($_POST['company_id']) ) {
    $read     = $db->getProviderByCompany($_POST['company_id']);
    $response['status']   = ($read ? '1' : '2');
    $response['provider'] = $read;
    echo json_encode($response);

}
/**
 * create
 * */
else if (isset($_POST['create']) && isset($_POST['break_time']) && isset($_POST['status']) && isset($_POST['slot']) && isset($_POST['work_time']) 
        && isset($_POST['work_day']) && isset($_POST['email']) && isset($_POST['phone']) && isset($_POST['staff_description']) 
        && isset($_POST['name']) && isset($_POST['branch_id'])) {
    $create = $db->create(array($_POST['branch_id'], $_POST['name'],$_POST['staff_description'], $_POST['phone'], $_POST['email'],$_POST['work_day'], $_POST['work_time'],
                                 $_POST['slot'], $_POST['status'],$_POST['break_time'],$created_at));
    $response['status'] = ($create ? '1' : '2');
    echo json_encode($response);
}
/**
 * update
 * */
else if (isset($_POST['update']) && isset($_POST['break_time']) && isset($_POST['slot']) && isset($_POST['work_time']) && isset($_POST['work_day']) && isset($_POST['email']) && isset($_POST['phone']) && isset($_POST['staff_description']) && isset($_POST['name']) && isset($_POST['provider_id'])) {
    $update = $db->update(array($updated_at, $_POST['break_time'], $_POST['slot'], $_POST['work_time'], $_POST['work_day'], $_POST['email'], $_POST['phone'], $_POST['staff_description'], $_POST['name'], $_POST['provider_id']));
    $response['status'] = ($update ? '1' : '2');
    echo json_encode($response);
}
/**
 * delete
 * */
else if (isset($_POST['delete']) && isset($_POST['provider_id'])) {
    $delete         = $db->delete(array($soft_delete, $_POST['provider_id']));
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
