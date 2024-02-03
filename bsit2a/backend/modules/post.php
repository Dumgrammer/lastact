<?php

class POST{


public function post_employee(){

return "this is my post employee records";

}
public function post_job($data){

    $data->date_hired = date_create();
    $data->salary = 100_000;
    //return "this is my post job records";
    return $data;

}

}

?>