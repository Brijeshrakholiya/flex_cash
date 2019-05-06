<?php

$data['user_id'] = $this->tank_auth->get_user_id();
$data['username'] = $this->tank_auth->get_username();
$user = $this->users->get_user_by_username($this->tank_auth->get_username());
//$data['email'] = $user->email;
$this->load->view('includes/header', $data);
$this->load->view('includes/admin_sidebar', $data);
/*if($this->tank_auth->get_user_type() == 1) {
    $this->load->view('includes/admin_sidebar', $data);
   
} else if($this->tank_auth->get_user_type() == 2) {
    $this->load->view('includes/partner_sidebar', $data);
   
} else if($this->tank_auth->get_user_type() == 3) {
    $this->load->view('includes/user_sidebar', $data);
    
}
else if($this->tank_auth->get_user_type() == 4) {
    $this->load->view('includes/staff_sidebar', $data);
    
}*/
//$this->load->view("includes/messages");
$this->load->view($main_content, $data);
$this->load->view('includes/footer', $data);
?>

