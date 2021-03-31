<?php

class Structure_object
{
    //initializing values in this constructor
    public function __construct()
    {
    }

    /**
     * bind param
     */
    public function bindParam($stmt, $params)
    {
        call_user_func_array(array($stmt, 'bind_param'), $this->refValues($params));
        $result = $stmt->execute();
        return ($result ? true : false);
    }

    /**
     * (sss, $column1, $column2)
     */
    public function refValues($arr)
    {
        if (strnatcmp(phpversion(), '5.3') >= 0) //Reference is required for PHP 5.3+
        {
            $refs = array();
            foreach ($arr as $key => $value) {
                if ($key == 0) {
                    $refs[0] = $this->nunOfString(sizeof($arr));
                    $refs[1] = &$arr[$key];
                } else {
                    $refs[$key + 1] = &$arr[$key];
                }
            }
            return $refs;
        }
        return $arr;
    }

    /**
     * number of 'sss'
     */
    public function nunOfString($number)
    {
        $string = '';
        for ($i = 0; $i < $number; $i++) {
            $string .= 's';
        }
        return $string;
    }

    /**
     * number of '?, ?, ?'
     */
    public function numOfQuestionMark($params)
    {
        $string = '';
        for ($i = 0; $i < sizeof(explode(',', $params, -1)); $i++) {
            $string .= '?, ';
        }
        return $string;
    }
    /**
     * ../../../
     */
    public function countDirectoryLevel($path, $config)
    {
        $string = '';
        for ($i = 0; $i < ($config ? sizeof(array_filter(explode('/', $path))) - 1 : sizeof(array_filter(explode('/', $path)))); $i++) {
            $string .= '../';
        }
        return $string;
    }

    /**
     * bind result
     */
    public function bindResult($stmt, $params, $row)
    {
        $return_arr = array();
        call_user_func_array(array($stmt, 'bind_result'), $params);
        //bind return date into array
        while ($stmt->fetch()) {
            foreach ($row as $key => $val) {
                $response[$key] = $val;
            }
            array_push($return_arr, $response);
        }
        $stmt->close();
        return $return_arr;
    }
    // -----------------------------------------------------------------params setup----------------------------------------------------------------------------------
    /**
     * delete, create, update checking parameter
     */
    public function checkingParams($action, $column, $primary_key)
    {
        if ($action === 'create') {
            if (($column !== 'soft_delete') && ($column !== 'updated_at') && ($column !== 'created_at') && ($column !== $primary_key)) {
                return " && isset(\$_POST['" . $column . "'])";
            }
        } else if ($action === 'update') {
            if (($column !== 'soft_delete') && ($column !== 'created_at') && ($column !== 'updated_at')) {
                return " && isset(\$_POST['" . $column . "'])";
            }
        } else if ($action === 'delete') {
            if ($column === $primary_key) {
                return " && isset(\$_POST['" . $column . "'])";
            }
        }
    }

    /**
     * delete, create, update params
     */
    public function valueParams($action, $column, $primary_key)
    {
        if ($action === 'create') {
            if (($column !== 'soft_delete') && ($column !== 'updated_at') && ($column !== 'created_at') && ($column !== $primary_key)) {
                return "\$_POST['" . $column . "'], ";
            }
        } else if ($action === 'update') {
            if (($column !== 'soft_delete') && ($column !== 'created_at') && ($column !== 'updated_at')) {
                return "\$_POST['" . $column . "'], ";
            }
        } else if ($action === 'delete') {
            if ($column === $primary_key) {
                return "\$_POST['" . $column . "'], ";
            }
        }
    }

    /**
     * read, create param
     */
    public function rCfunctionParams($action, $column, $primary_key)
    {
        if ($action === 'read') {
            return $column . ', ';
        } else {
            if (($column !== 'soft_delete') && ($column !== 'updated_at') && ($column !== $primary_key)) {
                return $column . ', ';
            }

        }
    }

    /**
     * update, delete param
     */
    public function uDfunctionParams($action, $column, $primary_key)
    {
        if ($action === 'update') {
            if (($column !== 'soft_delete') && ($column !== 'created_at') && ($column !== $primary_key)) {
                return $column . ' = ?, ';
            }
        } else {
            if (($column === 'soft_delete')) {
                return $column . ' = ?, ';
            }

        }
    }
}
