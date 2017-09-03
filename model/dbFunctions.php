<?php
function db_authenticate($userName, $password) {
    $userLogin = selectData('users', array(
        'select'=> ' userName, password',
        'where'=> array('userName' => $userName ),
        'return type' => 'single'
        )
    );

    if(password_verify($password,$userLogin['password'])) {
		return true;
	} else {
		return false;
	}
}

//sanitise data
function sanitiseUserInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    $data = mysql_real_escape_string($data);
	return $data;
}

function insertData($table, $data){
    GLOBAL $db, $lastInsertID;
    if(!empty($data) && is_array($data)) {
        $columns = '';
        $values = '';
        $i = 0;
        $columnString = implode(',', array_keys($data));
        $valueString = ":".implode(',:', array_keys($data));
        $sql = "INSERT INTO ".$table."(".$columnString.") VALUES (".$valueString.")";
        $query = $db->prepare($sql);

        foreach ($data as $key => $val) {
            $query->bindValue(':'.$key, $val);
        }
        $insert = $query->execute();
        $lastInsertID = $db->lastInsertId();
    }
    return $insert;
}


function selectData($table, $conditions = array()) {
    GLOBAL $db;
    $sql = 'SELECT';
    //select column list or * all
    $sql .= array_key_exists("select", $conditions)?$conditions['select']:'*';
    $sql .= ' FROM '.$table;
    //left join - if any
    if(array_key_exists("left join", $conditions)) {
        $sql .= ' LEFT JOIN ';
        $sql .= $conditions['left join']['table2'];
        $sql .= ' ON ';
        $sql .= $table.'.'.$conditions['left join']['column'];
        $sql .= ' = ';
        $sql .= $conditions['left join']['table2'].'.'.$conditions['left join']['column'];
    }
    //where conditions - if any
    if(array_key_exists("where", $conditions)) {
        $sql .= ' WHERE ';
        $i = 0;
        foreach ($conditions['where'] as $key => $value) {
            $pre = ($i > 0)? ' AND ':'';
            $sql .= $pre.$key." = '".$value."'";
            $i++;
        }
    }
    // order by column/s
    if(array_key_exists("order_by", $conditions)) {
        $sql .= ' ORDER BY '.$conditions['order_by'];
    }
    //limit conditions - if any
    if(array_key_exists("start", $conditions) && array_key_exists("limit", $conditions)) {
        $sql .= ' LIMIT '.$conditions['start'].','.$conditions['limit'];
    } elseif (!array_key_exists("start", $conditions) && array_key_exists("limit", $conditions)) {
        $sql .= ' LIMIT '.$conditons['limit'];
    }
    $query = $db->prepare($sql);
    $data = $query->execute();
    //return single or all rows - identifying fetch function required
    if(array_key_exists("return type", $conditions) && $conditions['return type'] != 'all') {
        switch ($conditions['return type']) {
            case 'count':
                $data = $query->rowCount();
                break;
            case 'single':
                $data = $query->fetch(PDO::FETCH_ASSOC);
                break;
            default:
                $data = '';
                break;
        }
    } else {
        if($query->rowCount() > 0) {
            $data = $query->fetchAll();
        } else {
            return false;
        }
        return $data;
    }
    return $data;
}

function updateData($table, $data, $conditions) {
    GLOBAL $db;
    if (!empty($data) && is_array($data)) {
        $colvalSet ='';
        $whereSql = '';
        $i = 0;
        /*if (!array_key_exists('modified', $data)) {
            $data['modified'] = date("y-m-d h-i-s");
        }*/
        foreach ($data as $key => $value) {
            $pre = ($i > 0)?', ':'';
            $colvalSet .= $pre.$key."='".$value."'";
            $i++;
        }
        if (!empty($conditions) && is_array($conditions)){
            $whereSql .= ' WHERE ';
            $i = 0;
            foreach ($conditions as $key => $value) {
                $pre = ($i > 0)? ' AND ':'';
                $whereSql .= $pre.$key." = '".$value."'";
            }
        }
        $sql  = "UPDATE ".$table." SET ".$colvalSet.$whereSql;
        
        $query = $db->prepare($sql);

        $update = $query->execute();
    }
    return $update;
}
 ?>
