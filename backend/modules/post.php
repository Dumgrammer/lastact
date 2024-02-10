<?php

class POST{

private $pdo;

public function __construct(\PDO $pdo){
    $this->pdo=$pdo;
}

public function post_records($table, $condition=null){
    $sqlString = "SELECT * FROM $table";
    if($condition != null){
        $sqlString.= " WHERE " .$condition;
    }
    $result = $this->executeQuery($sqlString);
    
    if($result['code']==200){
        return $this->sendPayload($result['data'], 'success', 'Successfully retireved records', $result['code']);
    }
    return $this->sendPayload(null, 'failed', 'Failed to retireve records', $result['code']);
}

public function sendPayload($data, $remarks, $message, $code){
    $status = array(
        "remarks" =>$remarks, 
        "message" =>$message
    );

    http_response_code($code);
    return array(
        "status"=>$status,
        "payload"=>$data,
        "prepared_by"=>"Karl Lacap",
        "timestamp"=>date_create()
    );
}

public function executeQuery($sql){
    $data = array();
    $errmsg = "";
    $code = 0;

    try {
        if ($result = $this->pdo->query($sql)->fetchAll()) 
    {
        foreach ($result as $record) {
            array_push($data,$record);
        }
        $code = 200;
        $result = null;
        return array(
            "code"=>$code,
            "data"=>$data
        );
    }
    else
    {
        $errmsg = "No data found";
        $code = 404;
    }
    } catch (\PDOException $e) {
        $errmsg = $e->getMessage();
        $code = 403;
    }
    return array(
        "code"=>$code,
        "errmsg"=>$errmsg
    );
}
    /**
     * Retrieve a list of employees.
     *
     * @return string
     *   A string representing the list of employees.
     */

public function post_employees($id=null){

    $conditionString = null;
    if ($id != null) {
        $conditionString = "EMPLOYEE_ID=$id";
    }
    return $this->post_records("employees",$conditionString);

}
public function post_jobs($id=null){

    $conditionString = null;
    if ($id != null) {
        $conditionString = "JOB_ID=$id";
    }
    return $this->post_records("jobs",$conditionString);

}
public function post_locations($id=null){

    $conditionString = null;
    if ($id != null) {
        $conditionString = "LOCATION_ID=$id";
    }
    return $this->post_records("locations",$conditionString);
}
public function add_employees($data){
    return $data;
}
public function add_jobs($data){
    return $data;
}
}

?>