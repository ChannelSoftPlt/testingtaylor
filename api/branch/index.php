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

else if (isset($_POST['getBranchHolidayWorkdayTime']) && isset($_POST['service_id']) ) {
    $read     = $db->getBranchHolidayWorkdayTime($_POST['service_id']);
    $response['status']   = ($read ? '1' : '2');
    $response['branch'] = $read;
    echo json_encode($response);

}
else if (isset($_POST['getHolidayDayTime']) && isset($_POST['company_id']) ) {
    $read     = $db->getHolidayDayTime($_POST['company_id']);
    $response['status']   = ($read ? '1' : '2');
    $response['branch'] = $read;
    echo json_encode($response);

}
else if (isset($_POST['searchBranchByName'])&& isset($_POST['company_id'])&& isset($_POST['search_branch'])) {
    
    $read     = $db->searchBranch($_POST['company_id'],$_POST['search_branch']);
    $response['status']   = ($read ? '1' : '2');
    $response['branch'] = $read;
    echo json_encode($response);

}
/**
 * create
 * */
else if (isset($_POST['create']) && isset($_POST['company_id']) && isset($_POST['name']) && isset($_POST['address']) 
        && isset($_POST['gap']) && isset($_POST['working_day']) && isset($_POST['working_time'])&& isset($_POST['redirect']) 
        && isset($_POST['phone_number'])&& isset($_POST['auto_approve']) && isset($_POST['status'])  ) {
    $create = $db->create(array($_POST['company_id'], $_POST['name'], $_POST['address'], $_POST['gap'], $_POST['working_day'], $_POST['working_time'],
                                 $_POST['redirect'],$_POST['phone_number'],$_POST['auto_approve'],$_POST['status'],$created_at));
    $response['status'] = ($create ? '1' : '2');
    $response['branch'] = $create;
    echo json_encode($response);
}
/**
 * update
 * */
else if (isset($_POST['update']) && isset($_POST['branch_id']) && isset($_POST['name']) && isset($_POST['address']) && isset($_POST['gap']) 
        && isset($_POST['working_day']) && isset($_POST['working_time']) && isset($_POST['redirect']) 
        && isset($_POST['phone_number'])&& isset($_POST['auto_approve'])&& isset($_POST['status'])) {
    $update = $db->update(array($_POST['name'], $_POST['address'], $_POST['gap'], $_POST['working_day'], $_POST['working_time'],
                                 $_POST['redirect'], $_POST['phone_number'], $_POST['auto_approve'],$_POST['status'],$updated_at,$_POST['branch_id']));
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
