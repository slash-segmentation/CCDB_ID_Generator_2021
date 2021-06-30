<?php

include_once 'DBUtil.php';

class Ccdb_id_gen extends CI_Controller
{
    
    public function index()
    {
        $this->load->library('session');
        $dbutil = new DBUtil();
        $base_url = $this->config->item('base_url');
        $data['base_url'] = $base_url;
        
        
        $scopeArray = $dbutil->getAllScopeNames();
        $data['scopeArray'] = $scopeArray;
        $this->load->view('templates/header', $data);
        $this->load->view('main/select_scope', $data);
        $this->load->view('templates/footer', $data);
    }
    
    public function start_over()
    {
        $this->load->library('session');
        $this->load->helper('url');
        
        $base_url = $this->config->item('base_url');
        $data['base_url'] = $base_url;
        
        $this->session->set_userdata('scopeID', NULL);
        $this->session->set_userdata('userName', NULL);
        
        redirect($base_url."/Ccdb_id_gen");
    }
    
    
    public function select_user()
    {
        $this->load->library('session');
        $dbutil = new DBUtil();
        $base_url = $this->config->item('base_url');
        $data['base_url'] = $base_url;
        
        $scopeID = $this->input->post('scope_list', TRUE);
        $this->session->set_userdata('scopeID', $scopeID);
        
        $userArray = $dbutil->getUsers();
        $data['userArray'] = $userArray;
        $this->load->view('templates/header', $data);
        $this->load->view('main/select_users', $data);
        $this->load->view('templates/footer', $data);
    }
    
    
    public function select_project()
    {
        $this->load->library('session');
        $this->load->helper('url');
        $base_url = $this->config->item('base_url');
        $data['base_url'] = $base_url;
        
        $userName = $this->input->post('user_list', TRUE);
        $this->session->set_userdata('userName', $userName);
        //echo $userName;
        $dbutil = new DBUtil();
        $pArray = $dbutil->getAllProjects();
        
        $data['pArray'] = $pArray;
        
        $this->load->view('templates/header', $data);
        $this->load->view('main/select_project', $data);
        $this->load->view('templates/footer', $data);
    }
    
    public function select_experiment()
    {
        $this->load->library('session');
        $this->load->helper('url');
        $base_url = $this->config->item('base_url');
        $data['base_url'] = $base_url;
        
        $projectID = $this->input->post('project_list', TRUE);
        $this->session->set_userdata('projectID', $projectID);
        
        $dbutil = new DBUtil();
        $eArray = $dbutil->getExperimentByProjectID($projectID);
        
        $e_json_str = json_encode($eArray);
        $eJson = json_decode($e_json_str);
        
        $data['eArray'] = $eJson;
        
        $this->load->view('templates/header', $data);
        $this->load->view('main/select_experiment', $data);
        $this->load->view('templates/footer', $data);
        
    }
    
    public function create_microscopy()
    {
        $this->load->library('session');
        $this->load->helper('url');
        $base_url = $this->config->item('base_url');
        $data['base_url'] = $base_url;
        
        $experimentID = $this->input->post('experiment_list', TRUE);
        $this->session->set_userdata('experimentID', $experimentID);
        
        $this->load->view('templates/header', $data);
        $this->load->view('create/create_microscopy', $data);
        $this->load->view('templates/footer', $data);
    }
    
    
    public function submit_microscopy()
    {
        $this->load->library('session');
        $this->load->helper('url');
        $base_url = $this->config->item('base_url');
        $data['base_url'] = $base_url;
        
        $imageBasename = $this->input->post('image_basename', TRUE);
        echo "<br/>Image basename:".$imageBasename;
    }
    
}

