<?php
include '../structure/structure.php';
class provider_function
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
    public function read()
    {
        $stmt = $this->conn->prepare("SELECT break_time, slot, work_time, work_day, email, phone, staff_description, name, provider_id FROM tb_provider ");
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
    

    public function getAllProvider($service_id)
    {
        $stmt = $this->conn->prepare("SELECT tb_provider.break_time, tb_provider.slot, tb_provider.work_time, tb_provider.work_day, tb_provider.email,
         tb_provider.phone, tb_provider.staff_description, tb_provider.name, tb_provider.provider_id FROM
          tb_provider JOIN tb_link ON tb_provider.provider_id = tb_link.provider_id WHERE tb_link.service_id = '" . $service_id . "' AND tb_provider.status = 1
           ORDER BY tb_provider.provider_id ");
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
    // public function getProviderInfo($provider_id) 
    // {
    //     $stmt = $this->conn->prepare("SELECT break_time, slot, work_time, work_day, email, phone, staff_description, name, provider_id 
    //     FROM tb_providerv WHERE  provider_id = '" . $provider_id . "'");
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
    public function getProviderByCompany($company_id)
    {
        $stmt = $this->conn->prepare("SELECT tb_provider.break_time, tb_provider.slot, tb_provider.work_time, tb_provider.work_day, tb_provider.email,
         tb_provider.phone, tb_provider.status, tb_provider.staff_description, tb_provider.name, tb_provider.provider_id, tb_provider.branch_id FROM
         tb_provider JOIN tb_branch ON tb_provider.branch_id = tb_branch.branch_id WHERE tb_branch.company_id = $company_id AND tb_provider.soft_delete ='' 
         ORDER BY tb_provider.provider_id ");
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
        $stmt       = $this->conn->prepare('INSERT INTO tb_provider(branch_id, name, staff_description, phone, email, work_day,
                                            work_time, slot, status, break_time, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
        //error reporting
        if (!$stmt) {
            die('prepare() failed: ' . htmlspecialchars($this->conn->error));
        }
        //bind param
        return $this->structure->bindParam($stmt, $params);
    }

    /**
     * update function
     * */
    public function update($params)
    {
        $stmt = $this->conn->prepare('UPDATE tb_provider SET branch_id = ?, name = ?, staff_description = ?, phone = ?, 
                                        email = ?, work_day = ?, work_time = ?, slot = ? , status = ?, break_time = ? , updated_at = ?  WHERE provider_id = ?');
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
        $stmt = $this->conn->prepare('UPDATE tb_provider SET soft_delete = ? WHERE provider_id = ?');
        //error reporting
        if (!$stmt) {
            die('prepare() failed: ' . htmlspecialchars($this->conn->error));
        }
        //bind param
        return $this->structure->bindParam($stmt, $params);
    }
}
?>