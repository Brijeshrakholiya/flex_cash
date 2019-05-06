<?php

$data['user_id'] = $this->tank_auth->get_user_id();
$data['username'] = $this->tank_auth->get_username();
$user = $this->users->get_user_by_username($this->tank_auth->get_username());
$userdata = $this->users->get_user_by_id($this->tank_auth->get_user_id(),1);
$this->session->set_userdata('email',$userdata->email);
$data['img'] = $userdata->image;
//var_dump($user->username);die;
//$data['email'] = $user->email;
    $this->load->view('includes/header', $data);
//$this->load->view('includes/admin_sidebar', $data);

//$this->load->view("includes/messages");
$this->load->view($main_content, $data);
$this->load->view('includes/footer', $data);
?>

