<?php
class Dashboard extends SessionController{

  private $user; 
  
  function __construct(){
    parent::__construct();
    $this->user = $this->getUserSessionData();
    $this->users = new UserModel();
  }

  function render(){
    $this->view->render('dashboard/index',[
      'user'=>$this->user,
      'total_users'=>$this->users->totalRegisters()
    ]);
  }
 
  public function getClients(){

  }

  public function getPines(){

  }

}
?>