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
else if (isset($_POST['check'])&&isset($_POST['selected_date'])&&isset($_POST['service_id'])&&isset($_POST['booking_id'])) {
    $read     = $db->check($_POST['selected_date'],$_POST['service_id'],$_POST['booking_id']);
    $response['status']   = ($read ? '1' : '2');
    $response['booking'] = $read;
    echo json_encode($response);

}
else if (isset($_POST['getBooking'])&&isset($_POST['selected_date'])&&isset($_POST['service_id'])&&isset($_POST['provider_id'])) {
    $read     = $db->getBooking($_POST['selected_date'],$_POST['service_id'],$_POST['provider_id']);
    $response['status']   = ($read ? '1' : '2');
    $response['booking'] = $read;
    echo json_encode($response);

}

else if (isset($_POST['findSpecificBranchBooking'])&&isset($_POST['branch_id'])) {
    $read     = $db->findSpecificBranchBooking($_POST['branch_id']);
    $response['status']   = ($read ? '1' : '2');
    $response['booking'] = $read;
    echo json_encode($response);

}

else if (isset($_POST['findAllBranchBooking'])&&isset($_POST['company_id'])) {
    $read     = $db->findAllBranchBooking($_POST['company_id']);
    $response['status']   = ($read ? '1' : '2');
    $response['booking'] = $read;
    echo json_encode($response);

}
else if (isset($_POST['getCustomerAppointment'])&&isset($_POST['customer_id'])) {
    $read     = $db->getCustomerAppointment($_POST['customer_id']);
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
else if (isset($_POST['createBooking'])&& isset($_POST['person']) && isset($_POST['customer_id']) 
         && isset($_POST['selected_date']) && isset($_POST['duration']) && isset($_POST['selected_time']) 
         && isset($_POST['service_id'])&& isset($_POST['service_title']) && isset($_POST['service_description'])&& isset($_POST['provider_id'])) {
    $create = $db->createBooking(array($_POST['service_id'], $_POST['selected_time'], $_POST['duration'], $_POST['service_title'], $_POST['service_description'],
                                $_POST['selected_date'],$_POST['person'], $_POST['customer_id'], $_POST['provider_id'], $created_at));
    $response['status'] = ($create ? '1' : '2');
    $response['booking'] = $create;
    echo json_encode($response);
}
/**
 * update
 * */
else if (isset($_POST['update']) && isset($_POST['booking_id']) && isset($_POST['person']) && isset($_POST['selected_date']) 
&& isset($_POST['selected_time']) && isset($_POST['customer_id']) && isset($_POST['contact']) && isset($_POST['email']) && isset($_POST['remark']) && isset($_POST['name'])) {
    $updateBooking = $db->updateBooking(array($_POST['selected_time'],$_POST['selected_date'], $_POST['person'], $updated_at, $_POST['booking_id']));
    $updateCustomer = $db->updateCustomer(array($_POST['name'],$_POST['contact'],$_POST['email'],$_POST['remark'], $updated_at,$_POST['customer_id']));
    $response['status'] = ($updateBooking && $updateCustomer ? '1' : '2');
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
