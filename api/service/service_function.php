<?php
include '../structure/structure.php';
class service_function
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
    public function read($branch_id,$seat)
    {
        $stmt = $this->conn->prepare("SELECT tb_service.* FROM `tb_service` JOIN tb_branch_link ON tb_branch_link.service_id = tb_service.service_id
         WHERE tb_branch_link.branch_id =  $branch_id AND tb_service.soft_delete='' AND tb_service.seat >= $seat AND tb_service.slot != 0 ORDER BY tb_service.seat ASC LIMIT 1
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


    public function findMaxPerson($branch_id)
    {
        $stmt = $this->conn->prepare("SELECT tb_service.* 
        FROM tb_service JOIN tb_branch_link ON tb_branch_link.service_id = tb_service.service_id WHERE tb_branch_link.branch_id = $branch_id 
        AND tb_service.soft_delete='' AND tb_service.slot!= 0 ORDER BY tb_service.seat DESC LIMIT 1");
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

    public function findAllService($branch_id)
    {
        $stmt = $this->conn->prepare("SELECT tb_service.*
        FROM tb_service JOIN tb_branch_link ON tb_service.service_id = tb_branch_link.service_id WHERE tb_branch_link.branch_id = $branch_id AND tb_service.soft_delete='' ");
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
    
    public function getSelectedService($service_id)
    {
        $stmt = $this->conn->prepare("SELECT updated_at, created_at, provider_id, status, slot, duration, price, description, seat, title, branch_id, service_id
        FROM tb_service WHERE service_id = '" .$service_id."' ");
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
        $stmt       = $this->conn->prepare('INSERT INTO tb_service(created_at, status, slot, duration, price, description, title, branch_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
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
        $stmt = $this->conn->prepare('UPDATE tb_service SET updated_at = ?, status = ?, slot = ?, duration = ?, price = ?, description = ?, title = ?, branch_id = ? WHERE service_id = ?');
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
        $stmt = $this->conn->prepare('UPDATE tb_service SET  WHERE service_id = ?');
        //error reporting
        if (!$stmt) {
            die('prepare() failed: ' . htmlspecialchars($this->conn->error));
        }
        //bind param
        return $this->structure->bindParam($stmt, $params);
    }
}
?>