<?php
include 'customer_function.php';
$db = new customer_function();

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
    $response['customer'] = $read;
    echo json_encode($response);

}
else if (isset($_POST['getAllCustomer'])&& isset($_POST['company_id'])) {

        $read     = $db->getAllCustomer($_POST['company_id']);
     
    
    $response['status']   = ($read ? '1' : '2');
    $response['customer'] = $read;
    echo json_encode($response);

}
else if (isset($_POST['searchCustomerByName'])&& isset($_POST['company_id'])&& isset($_POST['search_customer'])) {
    
        $read     = $db->searchCustomer($_POST['company_id'],$_POST['search_customer']);
    $response['status']   = ($read ? '1' : '2');
    $response['customer'] = $read;
    echo json_encode($response);

}
/**
 * create
 * */
else if (isset($_POST['create']) && isset($_POST['email']) && isset($_POST['contact']) && isset($_POST['name']) && isset($_POST['remark'])) {
    $create = $db->create(array( $_POST['name'], $_POST['contact'], $_POST['email'], $_POST['remark'] ,$created_at ));
    $response['status'] = ($create ? '1' : '2');
    $response['customer'] = $create;
    echo json_encode($response);
}
/**
 * update
 * */
else if (isset($_POST['update']) && isset($_POST['email']) && isset($_POST['contact']) && isset($_POST['name']) && isset($_POST['customer_id'])) {
    $update =  $db->update(array($_POST['name'],$_POST['contact'],$_POST['email'],$updated_at,$_POST['customer_id']));
    
    $response['status'] = ($update ? '1' : '2');
    echo json_encode($response);
}
/**
 * delete
 * */
else if (isset($_POST['delete']) && isset($_POST['customer_id'])) {
    $deleteCustomer = $db->deleteCustomer(array($soft_delete, $_POST['customer_id']));
    $deleteBooking = $db->deleteBooking(array($soft_delete, $_POST['customer_id']));
    $response['status'] = ($deleteCustomer && $deleteBooking  ? '1' : '2');
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
