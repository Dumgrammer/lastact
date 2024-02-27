<?php
require_once "global.php";

class POST extends GlobalMethods{

private $pdo;
private $get;

public function __construct(\PDO $pdo){
    $this->pdo=$pdo;
    $this->get = new Get($pdo);
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
    
    $sql = "INSERT INTO employees(EMPLOYEE_ID,FIRST_NAME,LAST_NAME,PHONE_NUMBER,EMAIL,
    SALARY,HIRE_DATE)VALUES(?,?,?,?,?,?,?)";

        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(
        [
            $data->EMPLOYEE_ID,
            $data->FIRST_NAME,
            $data->LAST_NAME,
            $data->PHONE_NUMBER,
            $data->EMAIL,
            $data->SALARY,
            $data->HIRE_DATE,
            
        ]
    );
    return $this->sendPayload(null,'created','Data added successfuly',201);
        } catch (\PDOException $e) {
            $errmsg = $e->getMessage();
            $code = 400;
        }
    
}
public function edit_employees($data, $id){
    $code = 0;
    $errmsg = "";
    $sql = "UPDATE employees SET FIRST_NAME = ?, LAST_NAME = ? WHERE EMPLOYEE_ID=?";
    try {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(
    [
       
        $data->FIRST_NAME,
        $data->LAST_NAME,
        $id,

    ]
);

return $this->sendPayload(null,'updated','Data updated successfuly',201);
    } catch (\PDOException $e) {
        $errmsg = $e->getMessage();
        $code = 400;
    }
}
public function delete_employees($data, $id){
    $code = 0;
    $errmsg = "";
    $sql = "DELETE  FROM employees WHERE EMPLOYEE_ID=?";
    try {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(
    [
       
        
        $id,

    ]
);

return $this->sendPayload(null,'deleted','Data deleted successfuly',201);
    } catch (\PDOException $e) {
        $errmsg = $e->getMessage();
        $code = 400;
    }
}
public function add_jobs($data){
    return $data;
}
}

?>