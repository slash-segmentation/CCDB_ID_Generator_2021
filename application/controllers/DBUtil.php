<?php

class DBUtil
{
    private $success = "success";
    private $error_type = "error_type";
    private $error_message = "error_message";
    
    public function getUsers()
    {
        //error_reporting(0);
        $CI = CI_Controller::get_instance();
        $db_params = $CI->config->item('db_params');
        $conn = pg_pconnect($db_params);
        if(!$conn)
        {
            $array = $this->getErrorArray("Cannot establish a db connection.");
            return $array;
        }
        
        $sql = "\n select userid, screenname, lastname || ', ' || firstname as full_name ".
               "\n, emailaddress from user_ where firstname is not null and lastname is not null and length(firstname) > 0 ".
               "\n order by screenname";
        $result = pg_query($conn,$sql);
        if (!$result) 
        {
            $message = "Error occurs during the SQL execution:".pg_last_error();
            $message = htmlspecialchars($message);
            $array = $this->getErrorArray($message);
            pg_close($conn);
            return $array;
        }
        
        $array = array();
        $userArray = array();
        while($row = pg_fetch_row($result))
        {
            $user = array();
            $userid = $row[0];
            $screenname = $row[1];
            $full_name = $row[2];
            $email = $row[3];
            $user['User_id'] = $userid;
            $user['Screen_name'] = $screenname;
            $user['Full_name'] = $full_name;
            $user['Email'] = $email;
            array_push($userArray, $user);
            
        }
        pg_close($conn);
        $json_str = json_encode($userArray);
        $userJson = json_decode($json_str);
        //$array['Users'] = $userArray;
        //$array[$this->success] = true;
        //return $array;
        
        return $userJson;
    }
    
    public function getAllProjects()    
    {
        $CI = CI_Controller::get_instance();
        $db_params = $CI->config->item('db_params');
        $conn = pg_pconnect($db_params);
        if(!$conn)
        {
            $array = $this->getErrorArray("Cannot establish a db connection.");
            return $array;
        }
        $sql = "select project_id, project_name, project_desc from project ". 
               " order by project_id desc";
        $result = pg_query($conn,$sql);
        if (!$result) 
        {
            pg_close($conn);
            return $array;
        }
        $array = $this->handleGetProjectResults($result);
        pg_close($conn);
        
        $pJson_str = json_encode($array);
        $pJson = json_decode($pJson_str);
        
        return $pJson;
        
    }
    
    public function getAllScopeNames()
    {
        $CI = CI_Controller::get_instance();
        $db_params = $CI->config->item('db_params');
        $conn = pg_pconnect($db_params);
        if(!$conn)
        {
            $array = $this->getErrorArray("Cannot establish a db connection.");
            return $array;
        }
        $sql = "select id, name from scope_names order by name asc";
        $result = pg_query($conn,$sql);
        if (!$result) 
        {
            $message = "Error occurs during the SQL execution:".pg_last_error();
            $message = htmlspecialchars($message);
            $array = $this->getErrorArray($message);
            pg_close($conn);
            return $array;
        }
        $array = $this->handleGetScopeNameResults($result);
        pg_close($conn);
        $sJson_str = json_encode($array);
        $scopeJson = json_decode($sJson_str);
        
        return $scopeJson;
    }
    
    
    private function handleGetScopeNameResults($result)
    {
        $array = array();
        $scpopeArray = array();
        $found = false;
        while($row = pg_fetch_row($result))
        {
            $found = true;
            $scope = array();
            $id = $row[0];
            $scope_name = $row[1];
            $scope['Id'] = intval($id);
            $scope['Scope_name'] = $scope_name;
            array_push($scpopeArray, $scope);
        }
        
        return $scpopeArray;
    }
    
    private function handleGetProjectResults($result)
    {
        $pArray = array();
        while($row = pg_fetch_row($result))
        {
            $project = array();
            $project_id = $row[0];
            $project_name = $row[1];
            if(is_null($project_name))
                $project_name = "";
            $project_desc = $row[2];
            if(is_null($project_desc))
                $project_desc = "";
            $project['Project_id'] = intval($project_id."");
            $project['Project_name'] = $project_name;
            $project['Project_desc'] = $project_desc;
            array_push($pArray, $project);
            
        }
        
        
        return $pArray;
    }
}

