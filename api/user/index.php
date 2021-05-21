<?php
include 'user_function.php';
$db = new user_function();

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
    $response['user'] = $read;
    echo json_encode($response);

}
else if (isset($_POST['getAdmin']) && isset($_POST['company_id'])) {
    $read     = $db->getAdmin($_POST['company_id']);
    $response['status']   = ($read ? '1' : '2');
    $response['user'] = $read;
    echo json_encode($response);
}
/**
 * login
 */
else if (isset($_POST['login']) && isset($_POST['password']) && isset($_POST['email'])) {
    $read = $db->login($_POST['email'], $_POST['password']);
    $response['status'] = ($read ? '1' : '2');
    $response['user'] = $read;
    echo json_encode($response);

}
/**
 * register
 * */
else if (isset($_POST['create']) && isset($_POST['name'])&& isset($_POST['email']) && isset($_POST['contact']) && isset($_POST['password'])
&& isset($_POST['company_name'])&& isset($_POST['industry'])&& isset($_POST['address'])) {

    $emailChecking = $db->isEmailExisted($_POST['email']);

    if ($emailChecking) {
        $status = 'User Existed!';
        
    } 
    else {
        $role = 0;
        $userStatus = 1;
        $hash = $db->hashSSHA($_POST['password']);
        $encrypted_password = $hash["password_encrypted"]; // encrypted password
        $salt = $hash["salt"]; // salt

        $addCompany = $db->addCompany(array($_POST['company_name'],$_POST['address'],$_POST['industry'],$created_at));
        
        if($addCompany){
            $addUser = $db->addUser(array($_POST['name'], $role, $_POST['contact'], $_POST['email'], $encrypted_password, $salt,$userStatus,
                                         $addCompany,$created_at ));
            if($addUser){
               $status ='1';
            }
            else{
                $status='4';
            }
        }
        else{
            $status ='Add Company Failed!';
        }

    }
    $response['status'] = $status;
    echo json_encode($response);
}

/**
 * add branch user
 * */
else if (isset($_POST['addBranchUser']) && isset($_POST['company_id'])&& isset($_POST['branch_id']) && isset($_POST['email']) && isset($_POST['password'])) {

    $emailChecking = $db->isEmailExisted($_POST['email']);
    if ($emailChecking) {
        $status = '2';
        
    } 
    else {
        $role = 1;
        $status = 1;
        $hash = $db->hashSSHA($_POST['password']);
        $encrypted_password = $hash["password_encrypted"]; // encrypted password
        $salt = $hash["salt"]; // salt

        $addBranchUser = $db->addBranchUser(array( $role, $_POST['email'], $encrypted_password, $salt, $status, $_POST['branch_id'], $_POST['company_id'],$created_at));
        $response['status'] = ($addBranchUser ? '1' : '2');
        echo json_encode($response);
    }
   
}
/**
 * update
 * */
else if (isset($_POST['update']) && isset($_POST['company_id']) && isset($_POST['name']) && isset($_POST['logo']) 
        && isset($_POST['email']) && isset($_POST['contact']) && isset($_POST['industry']) && isset($_POST['address'])) {
    $role = 0;
    $updateCompany = $db->updateCompany(array($_POST['name'], $_POST['logo'],$_POST['address'], $_POST['industry'],$updated_at,  $_POST['company_id'] ));
    $updateUser  = $db->updateUser(array($_POST['contact'],$_POST['email'],$updated_at,  $_POST['company_id'], $role));   
    
    $response['status'] = ($updateCompany&&$updateUser ? '1' : '2');
    echo json_encode($response);
}
/**
 * delete
 * */
else if (isset($_POST['delete']) && isset($_POST['user_id'])) {
    $delete         = $db->delete(array($soft_delete, $_POST['user_id']));
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
