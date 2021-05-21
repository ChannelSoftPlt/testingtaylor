<?php
include '../structure/structure.php';
class company_function
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
        $stmt = $this->conn->prepare("SELECT soft_delete, updated_at, created_at, color, address, sign_by, do_note, industry, registration_no, logo, name, user_id, company_id 
         FROM tb_company WHERE soft_delete = '' AND company_id = '" . $company_id . "' ");
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

    public function upload_picture($image_name, $image)
    {
        $now        = new DateTime('NOW', new DateTimeZone('Asia/Kuala_Lumpur'));
        $created_at = $now->format('Y-m-d H:i:s:u');
        $created_at = preg_replace('/[^0-9]/', '', $created_at);

        $depic     = base64_decode(preg_replace('#^data:image/[^;]+;base64,#', '', $image));
        $extension = explode('.', $image_name);
        $last      = end($extension);

        // $extension0     = preg_replace('/\./', '', $extension[0]);
        $new_image_name = $created_at . '.' . $last;

        $file   = $destination   = '../../appointment/logo/' . $new_image_name;
        $result = file_put_contents($file, $depic);

        if ($result !== false) {
            return $new_image_name;
        } else {
            return false;

        }
    }
    

    /**
     * create function
     * */
    public function create($params)
    {
        $return_arr = array();
        $stmt       = $this->conn->prepare('INSERT INTO tb_company(created_at, color, sign_by, do_note, industry, registration_no, logo, name, user_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)');
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
        $stmt = $this->conn->prepare('UPDATE tb_company SET color = ?, updated_at = ? WHERE company_id = ?');
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
        $stmt = $this->conn->prepare('UPDATE tb_company SET soft_delete = ? WHERE company_id = ?');
        //error reporting
        if (!$stmt) {
            die('prepare() failed: ' . htmlspecialchars($this->conn->error));
        }
        //bind param
        return $this->structure->bindParam($stmt, $params);
    }
}
?>