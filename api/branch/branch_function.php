<?php
include '../structure/structure.php';
class branch_function
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
    public function read($company_id)
    {
        $stmt = $this->conn->prepare("SELECT soft_delete, updated_at, created_at, user_id, working_time, working_day, redirect, auto_approve, phone_number, address, gap, name, company_id, branch_id 
        ,status FROM tb_branch WHERE soft_delete = '' AND company_id = '". $company_id ."' ");
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

    public function get($company_id)
    {
        $stmt = $this->conn->prepare("SELECT soft_delete, updated_at, created_at, user_id, working_time, working_day, redirect, auto_approve, phone_number, address, gap, name, company_id, branch_id 
        ,status FROM tb_branch WHERE status = 1 AND  soft_delete = '' AND company_id = '". $company_id ."' ");
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

    public function getBranchHolidayWorkdayTime($service_id)
    {
        $stmt = $this->conn->prepare("SELECT DISTINCT tb_branch.branch_id, tb_branch.gap, tb_branch.working_day, tb_branch.working_time, tb_holiday.date
        FROM tb_branch JOIN tb_holiday ON tb_branch.branch_id = tb_holiday.branch_id JOIN tb_branch_link ON tb_branch.branch_id = tb_branch_link.branch_id
        WHERE tb_branch_link.service_id = $service_id  ");
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

    public function getHolidayDayTime($company_id)
    {
        $stmt = $this->conn->prepare("SELECT DISTINCT tb_branch.name, tb_branch.branch_id, tb_branch.gap, tb_branch.working_day, tb_branch.working_time, tb_holiday.date
        FROM tb_branch JOIN tb_holiday ON tb_branch.branch_id = tb_holiday.branch_id JOIN tb_branch_link ON tb_branch_link.branch_id = tb_branch.branch_id
        WHERE tb_branch.company_id = $company_id
 ");
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

    public function searchBranch($company_id,$search_branch)
    {   
        $stmt = $this->conn->prepare("SELECT soft_delete, updated_at, created_at, user_id, working_time, working_day, redirect, auto_approve, phone_number, address, gap, name, company_id, branch_id 
            FROM tb_branch WHERE soft_delete = '' AND company_id = $company_id  AND name LIKE '%".$search_branch."%'");
        
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
     * create function
     * */
    public function create($params)
    {
        $return_arr = array();
        $stmt       = $this->conn->prepare('INSERT INTO tb_branch(company_id, name, address,gap, working_day, working_time,redirect,phone_number, auto_approve,status, created_at) 
                                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
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

    /**
     * update function
     * */
    public function update($params)
    {
        $stmt = $this->conn->prepare('UPDATE tb_branch SET name = ?, address = ?, gap = ?, working_day = ?,
                                     working_time = ?, redirect = ?, phone_number = ? , auto_approve = ? , status = ?,  updated_at = ? WHERE branch_id = ?');
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
        $stmt = $this->conn->prepare('UPDATE tb_branch SET soft_delete = ? WHERE branch_id = ?');
        //error reporting
        if (!$stmt) {
            die('prepare() failed: ' . htmlspecialchars($this->conn->error));
        }
        //bind param
        return $this->structure->bindParam($stmt, $params);
    }
}
?>