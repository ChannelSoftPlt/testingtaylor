<?php
include "structure.php";
$structure = new Structure_object();
$createCheckingParams = $updateCheckingParams = $deleteCheckingParams = $createValueParams = $updateValueParams = $deleteValueParams = $readParams = $createParams = $updateParams = $deleteParams = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
 $stmt = mysqli_connect('localhost', 'petkeepe_appointment', 'gcwtkycs1997#', $_POST['database']);
    if (!$stmt) {
        die('Could not connect: ' . mysqli_error());
    }
    /**
     * primary key
     */
    $sql    = "SHOW KEYS FROM " . $_POST['table'] . " WHERE Key_name = 'PRIMARY'";
    $result = mysqli_query($stmt, $sql) or die(phpAlert("Something Wrong with your Table Structure!"));
    while ($row = mysqli_fetch_array($result)) {
        $primary_key = $row['Column_name'];
    }
    /**
     * fetch all column
     */
    $sql = "SELECT COLUMN_NAME FROM information_schema.COLUMNS
     WHERE TABLE_SCHEMA = '" . $_POST["database"] . "' AND TABLE_NAME = '" . $_POST["table"] . "' ORDER BY ORDINAL_POSITION DESC";
    $result = mysqli_query($stmt, $sql) or die(mysqli_error(phpAlert("Table or Database not Found!")));

    while ($row = mysqli_fetch_array($result)) {
        $createCheckingParams .= $structure->checkingParams('create', $row['COLUMN_NAME'], $primary_key);
        $updateCheckingParams .= $structure->checkingParams('update', $row['COLUMN_NAME'], $primary_key);
        $deleteCheckingParams .= $structure->checkingParams('delete', $row['COLUMN_NAME'], $primary_key);

        $createValueParams .= $structure->valueParams('create', $row['COLUMN_NAME'], $primary_key);
        $updateValueParams .= $structure->valueParams('update', $row['COLUMN_NAME'], $primary_key);
        $deleteValueParams .= $structure->valueParams('delete', $row['COLUMN_NAME'], $primary_key);

        $readParams .= $structure->rCfunctionParams('read', $row['COLUMN_NAME'], $primary_key);
        $createParams .= $structure->rCfunctionParams('create', $row['COLUMN_NAME'], $primary_key);

        $updateParams .= $structure->uDfunctionParams('update', $row['COLUMN_NAME'], $primary_key);
        $deleteParams .= $structure->uDfunctionParams('delete', $row['COLUMN_NAME'], $primary_key);

        $numOfquestionMark = $structure->numOfQuestionMark($createParams);
    }
}
if (is_dir('../' . $_POST['directory']) === false) {
    mkdir('../' . $_POST['directory'], 0755, true) or die(phpAlert("Please set your parent's directory's permission to '777'"));
}
$controller = fopen('../' . $_POST['directory'] . '/' . "index.php", "w") or die("Unable to open file!");

$controller_content =
"<?php
include '" . $_POST['model'] . "_function.php';
\$db = new " . $_POST['model'] . "_function();

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');

// json response array
\$response   = array();
\$created_at = \$updated_at = \$soft_delete = (new DateTime('NOW', new DateTimeZone('Asia/Kuala_Lumpur')))->format('Y-m-d H:i:s');
/**
 * read
 */
if (isset(\$_POST['read'])) {
    \$read     = \$db->read();
    \$response['status']   = (\$read ? '1' : '2');
    \$response['" . $_POST['model'] . "'] = \$read;
    echo json_encode(\$response);

}
/**
 * create
 * */
else if (isset(\$_POST['create'])" . $createCheckingParams . ") {
    \$create = \$db->create(array(\$created_at, " . substr(trim($createValueParams), 0, -1) . "));
    \$response['status'] = (\$create ? '1' : '2');
    echo json_encode(\$response);
}
/**
 * update
 * */
else if (isset(\$_POST['update'])" . $updateCheckingParams . ") {
    \$update = \$db->update(array(\$updated_at, " . substr(trim($updateValueParams), 0, -1) . "));
    \$response['status'] = (\$update ? '1' : '2');
    echo json_encode(\$response);
}
/**
 * delete
 * */
else if (isset(\$_POST['delete'])" . $deleteCheckingParams . ") {
    \$delete         = \$db->delete(array(\$soft_delete, " . substr(trim($deleteValueParams), 0, -1) . "));
    \$response['status'] = (\$delete ? '1' : '2');
    echo json_encode(\$response);
}
/**
 * missing parameter
 * */
else {
    \$response['status'] = '4';
    echo json_encode(\$response);
}
?>
";

fwrite($controller, $controller_content);
fclose($controller);

/**
 * create model
 */
$model         = fopen('../' . $_POST['directory'] . '/' . $_POST['model'] . "_function.php", "w") or die("Unable to open file!");
$model_content = 
"<?php
include '" . $structure->countDirectoryLevel($_POST['directory'], false) . "structure/structure.php';
class " . $_POST['model'] . "_function
{
    private \$conn;
    private \$structure;
    // constructor
    public function __construct()
    {
        require_once '" . $structure->countDirectoryLevel($_POST['directory'], true) . "DB_Connect.php';
        // connecting to database
        \$db              = new Db_Connect();
        \$this->conn      = \$db->connect();
        \$this->structure = new Structure_object();
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
        \$stmt = \$this->conn->prepare(\"SELECT " . substr(trim($readParams), 0, -1) . " FROM " . $_POST['table'] . " WHERE soft_delete = '' \");
        //error reporting
        if (!\$stmt) {
            die('prepare() failed: ' . htmlspecialchars(\$this->conn->error));
        }
        \$result = \$stmt->execute();

        if (\$result) {
            //set up bind result
            \$meta = \$stmt->result_metadata();
            while (\$field = \$meta->fetch_field()) {
                \$params[] = &\$row[\$field->name];
            }
            \$return_arr = \$this->structure->bindResult(\$stmt, \$params, \$row);
        }

        return (sizeof(\$return_arr) > 0 ? \$return_arr : false);
    }

    /**
     * create function
     * */
    public function create(\$params)
    {
        \$return_arr = array();
        \$stmt       = \$this->conn->prepare('INSERT INTO " . $_POST['table'] . "(" . substr(trim($createParams), 0, -1) . ") VALUES (" . substr(trim($numOfquestionMark), 0, -1) . ")');
        //error reporting
        if (!\$stmt) {
            die('prepare() failed: ' . htmlspecialchars(\$this->conn->error));
        }
        //bind param
        return \$this->structure->bindParam(\$stmt, \$params);
    }

    /**
     * update function
     * */
    public function update(\$params)
    {
        \$stmt = \$this->conn->prepare('UPDATE " . $_POST['table'] . " SET " . substr(trim($updateParams), 0, -1) . " WHERE " . $primary_key . " = ?');
        //error reporting
        if (!\$stmt) {
            die('prepare() failed: ' . htmlspecialchars(\$this->conn->error));
        }
        //bind param
        return \$this->structure->bindParam(\$stmt, \$params);
    }

    /**
     * delete function
     * */
    public function delete(\$params)
    {
        \$stmt = \$this->conn->prepare('UPDATE " . $_POST['table'] . " SET " . substr(trim($deleteParams), 0, -1) . " WHERE " . $primary_key . " = ?');
        //error reporting
        if (!\$stmt) {
            die('prepare() failed: ' . htmlspecialchars(\$this->conn->error));
        }
        //bind param
        return \$this->structure->bindParam(\$stmt, \$params);
    }
}
?>";
fwrite($model, $model_content);
fclose($model);
phpAlert("File Created Successfully!");

function phpAlert($msg)
{
    echo "<script type='text/javascript'>alert('$msg');document.location='index.php'</script>";
}
