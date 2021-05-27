<?php
include '../structure/structure.php';
class user_function
{
    private $conn;
    private $structure;
    // constructor
    public function __construct()
    {
        require_once '../DB_Connect.php';
        // connecting to database
        $db              = new Db_Connect();
        $this->conn      = $db->connect();
        $this->structure = new Structure_object();
    }

    // destructor
    public function __destruct()
    {

    }

    /**
     * read function
     * */
    public function read($branch_id)
    {
        $stmt = $this->conn->prepare("SELECT soft_delete, updated_at, created_at, address, salt, status, password, email, contact, role, name, user_id 
        FROM tb_user WHERE soft_delete = '' AND branch_id = $branch_id AND role = 1 ");
        //error reporting
        if (!$stmt) {
            die('prepare() failed: ' . htmlspecialchars($this->conn->error));
        }
        $result = $stmt->execute();

        if ($result) {
            //set up bind result
            $meta = $stmt->result_metadata();
            while ($field = $meta->fetch_field()) {
                $params[] = &$row[$field->name];
            }
            $return_arr = $this->structure->bindResult($stmt, $params, $row);
        }

        return (sizeof($return_arr) > 0 ? $return_arr : false);
    }

    /**
     * Decrypting password
     * @param salt, password
     * returns hash string
     */
    
    public function checkhashSSHA($salt, $user_password_hash)
    {

        $hash = base64_encode(sha1($user_password_hash . $salt, true) . $salt);
        return $hash;
    }


    public function login($email, $password)
    {   
        
        $detail = array();
        $stmt = $this->conn->prepare("SELECT salt, password, email, company_id FROM tb_user WHERE status= 1 AND role=0 AND soft_delete = '' AND email ='$email'  ");
        //error reportin
        if (!$stmt) {
            die('prepare() failed: ' . htmlspecialchars($this->conn->error));
        }
        $result = $stmt->execute();
        if ($result) {
      
            $stmt->bind_result($salt, $epassword, $email, $company_id);
            while ($stmt->fetch()) {
                
                $hash = $this->checkhashSSHA($salt, $password);
               
                if ($epassword == $hash) {
                    $detail = array("company_id" =>$company_id);
                }
            }
            $stmt->close();

            if (sizeof($detail) > 0) {
                return $detail;
            } else {
                return false;
                
            }
        }
      else{
          return false;
      }
    }

    /**
     * Encrypting password
     * @param password
     * returns salt and encrypted password
     */
    public function hashSSHA($user_password_hash)
    {
        $salt = sha1(rand());
        $salt = substr($salt, 0, 10);
        $password_encrypted = base64_encode(sha1($user_password_hash . $salt, true) . $salt);
        $hash = array("salt" => $salt, "password_encrypted" => $password_encrypted);
        return $hash;
    }

    /**
     * Check domain is existed or not
     */
    public function isEmailExisted($email)
    {
        $stmt = $this->conn->prepare("SELECT email from tb_user WHERE email = '".$email."' AND soft_delete = ''");
        //error reporting
        if (!$stmt) {
            die('prepare() failed: ' . htmlspecialchars($this->conn->error));
        }
        $stmt->execute();
        $stmt->store_result();
        return ($stmt->num_rows > 0 ? true : false);
    }

    /**
     * create function
     * */
    public function addUser($params)
    {
        $return_arr = array();
        $stmt = $this->conn->prepare('INSERT INTO tb_user(name, role, contact, email, password, salt, status, company_id, created_at) 
                                     VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)');
        //error reporting
        if (!$stmt) {
            die('prepare() failed: ' . htmlspecialchars($this->conn->error));
        }
        //bind param
        $result  =  $this->structure->bindParam($stmt, $params);
        $last_id = $stmt->insert_id;
        $stmt->close();
        return ($result ? $last_id : false);
    }
    
    public function addCompany($params)
    {
        $return_arr = array();
        $stmt = $this->conn->prepare('INSERT INTO tb_company(name, address, industry, created_at) VALUES (?, ?, ?, ?)');
        //error reporting
        if (!$stmt) {
            die('prepare() failed: ' . htmlspecialchars($this->conn->error));
        }
        //bind param
        $result  =  $this->structure->bindParam($stmt, $params);
        $last_id = $stmt->insert_id;
        $stmt->close();
        return ($result ? $last_id : false);
    }

    public function addBranchUser($params)
    {
        $return_arr = array();
        
        $stmt = $this->conn->prepare('INSERT INTO tb_user(role, email, password, salt, status,branch_id, company_id, created_at) 
                                     VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
        //error reporting
        if (!$stmt) {
            die('prepare() failed: ' . htmlspecialchars($this->conn->error));
        }
        //bind param
        return $this->structure->bindParam($stmt, $params);
    }

    public function getAdmin($company_id)
    {
        $stmt = $this->conn->prepare("SELECT address, salt, password, email, contact, role, name, user_id, company_id 
                                    FROM tb_user WHERE soft_delete = '' AND role = 0 AND company_id = $company_id");
        //error reporting
        if (!$stmt) {
            die('prepare() failed: ' . htmlspecialchars($this->conn->error));
        }
        $result = $stmt->execute();

        if ($result) {
            //set up bind result
            $meta = $stmt->result_metadata();
            while ($field = $meta->fetch_field()) {
                $params[] = &$row[$field->name];
            }
            $return_arr = $this->structure->bindResult($stmt, $params, $row);
        }

        return (sizeof($return_arr) > 0 ? $return_arr : false);
    }
    
    // public function getAdmin($company_id)
    // {
    //     $stmt = $this->conn->prepare("SELECT address, salt, password, email, contact, role, name, user_id, company_id 
    //                                 FROM tb_user WHERE soft_delete = '' AND role = 0 AND company_id = $company_id");
    //     //error reporting
    //     if (!$stmt) {
    //         die('prepare() failed: ' . htmlspecialchars($this->conn->error));
    //     }
    //     $result = $stmt->execute();

    //     if ($result) {
    //         //set up bind result
    //         $meta = $stmt->result_metadata();
    //         while ($field = $meta->fetch_field()) {
    //             $params[] = &$row[$field->name];
    //         }
    //         $return_arr = $this->structure->bindResult($stmt, $params, $row);
    //     }

    //     return (sizeof($return_arr) > 0 ? $return_arr : false);
    // }
    

    /**
     * update company
     * */
    public function updateCompany($params)
    {
        $stmt = $this->conn->prepare('UPDATE tb_company SET name = ?, logo = ?, address = ? , industry = ?,updated_at = ? WHERE company_id = ?');
        //error reporting
        if (!$stmt) {
            die('prepare() failed: ' . htmlspecialchars($this->conn->error));
        }
        //bind param
        return $this->structure->bindParam($stmt, $params);
    }
    /**
     * update user
     * */
    public function updateUser($params)
    {
        $stmt = $this->conn->prepare('UPDATE tb_user SET contact =? , email = ?, updated_at = ?  WHERE company_id = ? AND role = ?');
        //error reporting
        if (!$stmt) {
            die('prepare() failed: ' . htmlspecialchars($this->conn->error));
        }
        //bind param
        return $this->structure->bindParam($stmt, $params);
    }
     /**
     * update branch user
     * */
    public function updateBranchUser($params)
    {
        $stmt = $this->conn->prepare('UPDATE tb_user SET  email = ?, password = ?, salt = ?, status =? , updated_at = ?  WHERE branch_id = ?');
        //error reporting
        if (!$stmt) {
            die('prepare() failed: ' . htmlspecialchars($this->conn->error));
        }
        //bind param
        return $this->structure->bindParam($stmt, $params);
    }


    /**
     * delete function
     * */
    public function delete($params)
    {
        $stmt = $this->conn->prepare('UPDATE tb_user SET soft_delete = ? WHERE user_id = ?');
        //error reporting
        if (!$stmt) {
            die('prepare() failed: ' . htmlspecialchars($this->conn->error));
        }
        //bind param
        return $this->structure->bindParam($stmt, $params);
    }
}
?>