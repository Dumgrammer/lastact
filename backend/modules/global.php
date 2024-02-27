<?php
class GlobalMethods{
    private $pdo;
    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
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
}