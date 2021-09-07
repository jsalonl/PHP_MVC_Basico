<?php
class Login extends SessionController{

  function __construct(){
    parent::__construct();
  }

  function render(){
    $this->view->render('login/index');
  }
  
  function authenticate(){
    if($this->existPOST(['identificacion','password'])){
      $identificacion = $this->getPost('identificacion');
      $password = $this->getPost('password');

      if($identificacion == '' || empty($identificacion) || $password == '' || empty($password)){
        $this->redirect('', ['error' => ErrorMessages::ERROR_LOGIN_AUTHENTICATE_EMPTY]);
      }else{
        $user = $this->model->login($identificacion, $password);

        if($user!=NULL){
          if($user->getEstado()==1){
            $this->initialize($user); 
          }else{
            $this->redirect('', ['error'=>ErrorMessages::ERROR_LOGIN_AUTHENTICATE_STATUS]);
          }
        }else{
          $this->redirect('', ['error'=>ErrorMessages::ERROR_LOGIN_AUTHENTICATE_DATA]);
        }
          
      }
    }else{
      $this->redirect('', ['error'=>ErrorMessages::ERROR_LOGIN_AUTHENTICATE_POST]);
    }
  }
}
?>