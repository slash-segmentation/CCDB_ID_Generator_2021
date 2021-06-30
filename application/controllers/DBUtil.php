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
    
    
    public function getExperimentByProjectID($project_id)
    {
        $CI = CI_Controller::get_instance();
        $db_params = $CI->config->item('db_params');
        $conn = pg_pconnect($db_params);
        $array = array();
        if(!$conn)
        {
            return $array;
        }
        $input = array();
        array_push($input,$project_id."");
        $sql = "\n select e.experiment_id, e.experiment_title, ".
            "\n e.experiment_purpose, e.experiement_date as experiment_date ".
            "\n from project p, experiment e ".
            "\n where  p.project_id = e.project_id and p.project_id = $1 order by e.experiment_id desc";
        $result = pg_query_params($conn,$sql,$input);
        if (!$result) 
        {
            pg_close($conn);
            return $array;
        }
        $array = $this->handleGetExperimentResults($result);
        pg_close($conn);
        return $array;
       
    }
    
    
    public function inserMicroscopy($json)
    {
        //error_log("inserMicroscopy", 3, "C:/Test/rest_log.txt");
        $isInvalid = false;
        if(is_null($json))
        {
            $isInvalid = true;
        }
        else if(!isset($json->Microscopy->Experiment_id)
                || !isset($json->Microscopy->Image_basename)
                || !isset($json->Microscopy->User)
                || !isset($json->Microscopy->Description)
                )
        {
            $isInvalid = true;
        }
        if($isInvalid)
        {
            $errorMessage = "";
            if(!isset($json->Microscopy->Experiment_id))
                $errorMessage = "Missing Experiment_id";
            if(!isset($json->Microscopy->Image_basename))
                $errorMessage = "Missing basename";
            if(!isset($json->Microscopy->User))
                $errorMessage = "Missing user";
            if(!isset($json->Microscopy->Description))
                $errorMessage = "Missing description";
            $array = $this->getErrorArray("Invalid JSON input:".$errorMessage);
            return $array;
        }
        
        
        
        $id = -1;
        $idArray = $this->getNextID();
        if($idArray[$this->success])
        {
            $id = $idArray['ID'];
        }
        else
        {
            return $idArray;
        }
        
        
        $CI = CI_Controller::get_instance();
        $db_params = $CI->config->item('db_params');
        $conn = pg_pconnect($db_params);
        if(!$conn)
        {
            $array = $this->getErrorArray("Cannot establish a db connection.");
            return $array;
        }
        
        
        if(!isset($json->Microscopy->Microscope_name))
        {
            //error_log("Not Set:".json_encode($json), 3, "C:/Test/rest_log.txt");
            $sql = "insert into microscopy_products(mpid, experiment_experiment_id, image_basename,portal_screenname,notes,modified_date) ".
                   " values($1,$2,$3,$4,$5,now())";
            $input = array();
            array_push($input,$id."");
            array_push($input,$json->Microscopy->Experiment_id."");
            array_push($input,$json->Microscopy->Image_basename);
            array_push($input,$json->Microscopy->User);
            array_push($input,$json->Microscopy->Description);
        }
        else 
        {
            //error_log("Set:".json_encode($json), 3, "C:/Test/rest_log.txt");
            $sql = "insert into microscopy_products(mpid, experiment_experiment_id, image_basename,portal_screenname,notes,scope_name,modified_date) ".
                   " values($1,$2,$3,$4,$5,$6,now())";
            $input = array();
            array_push($input,$id."");
            array_push($input,$json->Microscopy->Experiment_id."");
            array_push($input,$json->Microscopy->Image_basename);
            array_push($input,$json->Microscopy->User);
            array_push($input,$json->Microscopy->Description);
            array_push($input,$json->Microscopy->Microscope_name);
        }
        
        
        $result = pg_query_params($conn,$sql,$input);
        if (!$result) 
        {
            $message = "Error occurs during the SQL execution:".pg_last_error();
            $message = htmlspecialchars($message);
            $array = $this->getErrorArray($message);
            pg_close($conn);
            return $array;
        }
        pg_close($conn);
        $array = array();
        $array[$this->success] = true;
        $array['Microscopy_id'] = intval($id."");
        return $array;
    }
    
    
    private function getNextID()
    {
        $project_id = -1;
        $CI = CI_Controller::get_instance();
        $db_params = $CI->config->item('db_params');
        $conn = pg_pconnect($db_params);
        if(!$conn)
        {
            $array = $this->getErrorArray("Cannot establish a db connection.");
            return $array;
        }
        $sql = "select nextval('general_sequence')";
        $result = pg_query($conn,$sql);
        if (!$result) 
        {
            $message = "Error occurs during the SQL execution:".pg_last_error();
            $message = htmlspecialchars($message);
            $array = $this->getErrorArray($message);
            pg_close($conn);
            return $array;
        }
        if($row = pg_fetch_row($result))
        {
            $project_id = $row[0];
        }
        pg_close($conn);
        $array = array();
        $array[$this->success] = true;
        $array['ID'] = intval($project_id."");
        return $array;
    }
    
    
    private function handleGetExperimentResults($result)
    {
        $array = array();
        $eArray = array();
        while($row = pg_fetch_row($result))
        {
            $experiment = array();
            $experiment_id = $row[0]; //experiment_id 
            $experiment["Experiment_id"] = intval($experiment_id);
            
            $experiment_title = $row[1]; //experiment_title
            if(!is_null($experiment_title))
            {
                $experiment["Experiment_title"] = $experiment_title;
            }
            else 
            {
                $experiment["Experiment_title"] = "";
            }
                
            $experiment_purpose = $row[2]; //experiment_purpose
            if(!is_null($experiment_purpose))
            {
                $experiment['Experiment_purpose'] = $experiment_purpose;
            }
            else 
            {
                $experiment['Experiment_purpose'] = "";
            }
            $experiment_date = $row[3]; //experiment_date
            if(!is_null($experiment_date))
            {
                $format = 'm/d/Y';
                try
                {
                    $date = new DateTime($experiment_date);
                    $experiment['Experiment_date'] = $date->format('m-d-Y');
                }
                catch(Exception $e)
                {}
                   
            }
            array_push($eArray, $experiment);
        }
        
        
        return $eArray;
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

