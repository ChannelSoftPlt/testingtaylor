<?php
include '../structure/structure.php';
class customer_function
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
        $stmt = $this->conn->prepare("SELECT soft_delete, updated_at, created_at, email, contact, name, customer_id FROM tb_customer WHERE soft_delete = '' ");
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

    public function getAllCustomer($company_id)
    {   
        $stmt = $this->conn->prepare("SELECT DISTINCT tb_customer.customer_id, tb_customer.name, tb_customer.contact, tb_customer.email, tb_customer.remark
        FROM tb_customer JOIN tb_booking ON tb_booking.customer_id = tb_customer.customer_id JOIN tb_service ON tb_booking.service_id = tb_service.service_id
        JOIN tb_branch ON tb_service.branch_id = tb_branch.branch_id WHERE tb_customer.soft_delete = '' AND tb_branch.company_id = $company_id");
        
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
    public function searchCustomer($company_id,$search_customer)
    {   
        $stmt = $this->conn->prepare("SELECT DISTINCT tb_customer.customer_id, tb_customer.name, tb_customer.contact, tb_customer.email, tb_customer.remark
            FROM tb_customer JOIN tb_booking ON tb_booking.customer_id = tb_customer.customer_id JOIN tb_service ON tb_booking.service_id = tb_service.service_id
            JOIN tb_branch ON tb_service.branch_id = tb_branch.branch_id WHERE tb_customer.soft_delete = '' AND tb_branch.company_id = $company_id 
            AND tb_customer.name LIKE '%".$search_customer."%'");
        
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
        $stmt       = $this->conn->prepare('INSERT INTO tb_customer(name, contact, email, remark, created_at) VALUES (?, ?, ?, ?, ?)');
        //error reporting
        if (!$stmt) {
            die('prepare() failed: ' . htmlspecialchars($this->conn->error));
        }
        //bind param
        $result  = $this->structure->bindParam($stmt, $params);
        $last_id = $stmt->insert_id;
        $stmt->close();
        return ($result ? $last_id : false);
    }
    

    /**
     * update function
     * */
    public function update($params)
    {
        $stmt = $this->conn->prepare('UPDATE tb_customer SET name = ?, contact = ? , email = ?, updated_at = ?   WHERE customer_id = ?');
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
    public function deleteCustomer($params)
    {
        $stmt = $this->conn->prepare('UPDATE tb_customer SET soft_delete = ? WHERE customer_id = ?');
        //error reporting
        if (!$stmt) {
            die('prepare() failed: ' . htmlspecialchars($this->conn->error));
        }
        //bind param
        return $this->structure->bindParam($stmt, $params);
    }
    public function deleteBooking($params)
    {
        $stmt = $this->conn->prepare('UPDATE tb_booking SET soft_delete = ? WHERE customer_id = ?');
        //error reporting
        if (!$stmt) {
            die('prepare() failed: ' . htmlspecialchars($this->conn->error));
        }
        //bind param
        return $this->structure->bindParam($stmt, $params);
    }
}
?>