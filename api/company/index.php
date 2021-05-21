<?php
include 'company_function.php';
$db = new company_function();

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');

// json response array
$response   = array();
$created_at = $updated_at = $soft_delete = (new DateTime('NOW', new DateTimeZone('Asia/Kuala_Lumpur')))->format('Y-m-d H:i:s');
/**
 * read
 */
if (isset($_POST['read']) && isset($_POST['company_id'])) {
    $read     = $db->read($_POST['company_id']);
    $response['status']   = ($read ? '1' : '2');
    $response['company'] = $read;
    echo json_encode($response);

}
else if (isset($_POST['upload_image']) && isset($_POST['image_name']) && isset($_POST['image'])) {

    $upload_picture           = $db->upload_picture($_POST['image_name'], $_POST['image']);
    $response['status']       = ($upload_picture ? '1' : '2');
    $response['picture_name'] = $upload_picture;

    echo json_encode($response);
}
/**
 * create
 * */
else if (isset($_POST['create']) && isset($_POST['color']) && isset($_POST['sign_by']) && isset($_POST['do_note']) && isset($_POST['industry']) && isset($_POST['registration_no']) && isset($_POST['logo']) && isset($_POST['name']) && isset($_POST['user_id'])) {
    $create = $db->create(array($created_at, $_POST['color'], $_POST['sign_by'], $_POST['do_note'], $_POST['industry'], $_POST['registration_no'], $_POST['logo'], $_POST['name'], $_POST['user_id']));
    $response['status'] = ($create ? '1' : '2');
    echo json_encode($response);
}
/**
 * update color
 * */
else if (isset($_POST['update']) && isset($_POST['color']) && isset($_POST['company_id'])) {
    $update = $db->update(array($_POST['color'],$updated_at,$_POST['company_id']));
    $response['status'] = ($update ? '1' : '2');
    echo json_encode($response);
}
/**
 * delete
 * */
else if (isset($_POST['delete']) && isset($_POST['company_id'])) {
    $delete         = $db->delete(array($soft_delete, $_POST['company_id']));
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
