<?php

require_once 'models/clientmodel.php';

class Dashboard extends SessionController{

  private $user; 
  
  function __construct(){
    parent::__construct();
    $this->user = $this->getUserSessionData();
    $this->users = new UserModel();
    $this->clients = new ClientModel();
  }

  function render(){
    $this->view->render('dashboard/index',[
      'user'=>$this->user,
      'total_users'=>$this->users->totalRegisters(),
      'total_clients'=>$this->clients->totalRegisters()
    ]);
  }
 
  public function getClients(){

  }

  public function getPines(){

  }

}
?>